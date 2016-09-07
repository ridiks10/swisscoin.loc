<?php

/**
 * @property-read product_model $product_model 
 */
class register_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('product_model');
        $this->load->model('configuration_model');
        $this->load->model('registersubmit_model');
        $this->load->model('mail_model');
    }

    public function confirmRegister($regr, $module_status) {
     
        $msg = array('user' => '', 'pwd' => '', 'id' => '', 'status' => false, 'tran' => '');
        $updt_login_res = false;
        $updt_ft_res = false;
        $insert_user_det_res = false;
        $insert_tmp1_res = false;
        $mlm_plan = $module_status['mlm_plan'];
        $error_message='';
        $reg_from_tree='';

        
        $sponsor_id = $regr['placement_id'];
//        $reg_from_tree = $regr['reg_from_tree'];

        //USER PLACEMENT SECTION STARTS//
       if (!$reg_from_tree) {
          
  $placement_details = $this->getPlacementUnilevel($sponsor_id);
 if ($placement_details) {
                    $regr['placement_id'] = $placement_details['id'];
                    $regr['position'] = $placement_details['position'];
                } else {
                    $error_message = "Unexpected error occured. Please conatct Admin";
                }
}


        //USER PLACEMENT SECTION ENDS//

        if ($error_message != '') {
            if ($regr['by_using'] !== "opencart") {
                $this->redirect_out($error_message, 'register/user_register');
            } else {
                echo "$error_message";
            }
        }

        $max_nod_id = $this->registersubmit_model->getMaxOrderID();
        $next_order_id = $max_nod_id + 1;

        if ($regr['user_name_type'] == 'dynamic') {
            $regr['username'] = $this->registersubmit_model->getUsername();
        } else {
            $regr['username'] = $regr['user_name_entry'];
        }

        if ($this->validateRegisterData($regr, $module_status)) {
            $new_user_id = $this->validation_model->getChildNodeId($regr['placement_id'], $regr['position']);

            $user_level = $this->registersubmit_model->getLevel($regr['placement_id']) + 1;

            $customer_id = (isset($regr['customer_id'])) ? $regr['customer_id'] : '';
           
         
            $updt_ft_res = $this->registersubmit_model->updateFTIndividual($regr['placement_id'], $regr['sponsor_id'], $regr['position'], $regr['username'], $new_user_id, $next_order_id, $regr['by_using'], $user_level, $regr['product_id'], $regr['joining_date'], $customer_id);

            if ($updt_ft_res) {
                $updt_login_res = $this->registersubmit_model->insertLoginUser($new_user_id, $regr['username'], $regr['pswd'], $new_user_id);
                if ($updt_login_res) {
                    $regr['userid'] = $new_user_id;
                    $insert_user_det_res = $this->registersubmit_model->insertUserDetails($regr);

                    //INSERT TEMP POSITION STARTS//
                        $insert_tmp1_res = $this->registersubmit_model->tmpInsert($new_user_id, '1');
                            $new_position = $this->registersubmit_model->getNewPositionOfUser($new_user_id) + 1;
                            $insert_tmp2_res = $this->registersubmit_model->tmpInsert($regr['placement_id'], $new_position);

                    //INSERT TEMP POSITION ENDS//
                }
            }

            if (($updt_ft_res) && ($updt_login_res) && ($insert_user_det_res) && ($insert_tmp1_res)) {
                $this->registersubmit_model->insertBalanceAmount($new_user_id);

                $rank_status = $module_status['rank_status'];
                $product_status = $module_status['product_status'];
                $first_pair = $module_status['first_pair'];
                $referal_status = $module_status['referal_status'];
                $balance_amount = 0;

                $product_id = 0;
//                $product_amount = $regr['reg_amount'];
//                $product_pair_value = $regr['reg_amount']; //if there is no product, level commissions are based on the registration fee
//                if ($product_status == "yes") {
//                    $product_id = $regr['product_id'];
//                    $product_details = $this->product_model->getProductAmountAndPV($product_id);
//                    $product_pair_value = $product_details['pair_value'];
//                    $product_amount = $product_details['product_value'];
//                }

                $oc_order_id = 0;
                if (isset($regr['order_id'])) {
                    $oc_order_id = $regr['order_id'];
                }

                //CALCULATION SECTION STARTS//
                require_once 'calculation_model.php';
                    $obj_calc = new calculation_model();
                    $upline_id = $regr['placement_id'];
                    $amount_type = 'level_commission';
       //new veto             //$obj_calc->calculateLegCount($new_user_id, $upline_id, $product_id, $product_pair_value, $product_amount, $amount_type, $oc_order_id);

                //CALCULATION SECTION ENDS//

                $from_level_upto_sponsor = $this->getUserSponsorTreeLevel($regr['sponsor_id'], $new_user_id);

                if ($referal_status == "yes") {
                    $referal_amount = $this->getReferalAmount();
                    $referal_id = $regr['sponsor_id'];
                    if ($referal_amount > 0) {
                        $obj_calc->insertReferalAmount($referal_id, $referal_amount, $new_user_id, $from_level_upto_sponsor);
                    }
                }

//                if ($rank_status == "yes") {
//                    $referal_count = $this->validation_model->getReferalCount($regr['sponsor_id']);
//                    $old_rank = $this->validation_model->getUserRank($regr['sponsor_id']);
//                    $new_rank = $this->validation_model->checkNewRank($referal_count);
//
//                    if ($old_rank != $new_rank) {
//
//                        $this->updateUserRank($regr['sponsor_id'], $new_rank);
//                        $balance_amount = $this->getBalanceAmount($regr['sponsor_id']);
//                        $rank_bonus = $this->configuration_model->getActiveRankDetails($new_rank);
//                        $this->insertIntoRankHistory($old_rank, $new_rank, $regr['sponsor_id']);
//                        $date_of_sub = date("Y-m-d H:i:s");
//                        $amount_type = "rank_bonus";
//                        $obj_arr = $this->getSettings();
//                        $tds_db = $obj_arr["tds"];
//                        $service_charge_db = $obj_arr["service_charge"];
//                        $rank_amount = $rank_bonus[0]['rank_bonus'];
//                        $tds_amount = ($rank_amount * $tds_db) / 100;
//                        $service_charge = ($rank_amount * $service_charge_db) / 100;
//                        $amount_payable = $rank_amount - ($tds_amount + $service_charge);
//
//                        $obj_calc->insertRankBonus($regr['sponsor_id'], $rank_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type, $new_user_id, $from_level_upto_sponsor);
//                    }
//                }

                $username = $regr['username'];
                $password = $regr['pswd'];

                $tran_code = $this->registersubmit_model->getRandTransPasscode(8);
                $this->registersubmit_model->savePassCodes($new_user_id, $tran_code);

                if (($regr['email'] != "") && ($regr['email'] != null)) {
                    $type = 'registration';
                    $check_status = $this->mail_model->checkMailStatus($type);
                    if ($check_status == 'yes') {
                        $this->mail_model->sendAllEmails($type, $regr);
                    }
                }
                $this->insertInToUserRegistrationDetails($regr);
                $encr_id = $this->getEncrypt($new_user_id);

                $msg['user'] = $username;
                $msg['pwd'] = $password;
                $msg['id'] = $regr['userid'];
                $msg['encr_id'] = $encr_id;
                $msg['status'] = true;
                $msg['tran'] = $tran_code;
            }
        }
        return $msg;
    }

    public function validateRegisterData($regr, $module_status) {
        
//        $product_status = $module_status['product_status'];
        $username = $regr['username'];
        $position = $regr['position'];
        $fatherid = $regr['placement_id'];
        $check_position = true;

        $flag = true;
        if ($this->validation_model->isUserNameAvailable($username)) {
            $flag = false;
            if ($regr['by_using'] !== "opencart") {
                $msg = $this->lang->line('user_name_not_available');
                $this->redirect_out($msg, 'register/user_register');
            } else {
                echo "Username Not Available";
            }
        }
        if (!$this->validation_model->isLegAvailable($fatherid, $position, $check_position)) {
            $flag = false;
            if ($regr['by_using'] !== "opencart") {
                $msg = $this->lang->line('user_already_registered');
                $this->redirect_out($msg, 'register/user_register');
            } else {
                echo "Leg Not Available";
            }
        }
//        if ($product_status == 'yes') {
//            $product_id = $regr['product_id'];
//            if (!$this->product_model->isProductAvailable($product_id, "register")) {
//                $flag = false;
//
//                if ($regr['by_using'] !== "opencart") {
//                    $msg = $this->lang->line('product_not_available');
//                    $this->redirect_out($msg, 'register/user_register');
//                } else {
//                    echo "Product Not Available";
//                }
//            }
//        }

        return $flag;
    }

    public function insertInToUserRegistrationDetails($regr) {
        $insert_data = array(
            "user_id" => $regr['userid'],
            "user_name" => $regr['username'],
            "sponsor_id" => $regr['sponsor_id'],
            "placement_id" => $regr['placement_id'],
            "position" => $regr['position'],
//            "first_name" => $regr['first_name'],
//            "last_name" => $regr['last_name'],
//            "address" => $regr['address'],
//            "address_line2" => $regr['address_line2'],
            "country_id" => $regr['country'],
            "country_name" => $regr['country_name'],
//            "state_id" => $regr['state'],
//            "state_name" => $regr['state_name'],
//            "city" => $regr['city'],
            "email" => $regr['email'],
//            "mobile" => $regr['mobile'],
//            "product_id" => $regr['product_id'],
//            "product_name" => $regr['product_name'],
//            "product_pv" => $regr['product_pv'],
//            "product_amount" => $regr['product_amount'],
//            "reg_amount" => $regr['reg_amount'],
//            "total_amount" => $regr['total_amount'],
            "reg_date" => $regr['joining_date']
        );
        $result = $this->db->insert('infinite_user_registration_details', $insert_data);
        return $result;
    }

    public function getUserRegistrationDetails($user_id) {
        $registration_details = array();
        $get_data = array(
            "user_id" => $user_id
        );
        $this->db->limit(1);
        $result = $this->db->get_where('infinite_user_registration_details', $get_data);
        foreach ($result->result_array() AS $row) {
            $registration_details = $row;
        }
        return $registration_details;
    }

    public function viewProducts($product_id = '', $status = 'yes') {
        $product_array = $this->product_model->getAllProducts($status);
        $lang_product = $this->lang->line('select_product');
        $products = '<option value="">' . $lang_product . '</option>';
        for ($i = 0; $i < count($product_array); $i++) {
            $id = $product_array[$i]['product_id'];
            $product_name = $product_array[$i]['product_name'];
            $product_value = $product_array[$i]['product_value'];
            $selected = '';
            if ($id == $product_id) {
                $selected = 'selected';
            }
            $products.='<option value="' . $id . '"' . $selected . ' >' . $product_name . '</option>';
        }
        return $products;
    }

    public function isProductAdded() {

        $flag = 'no';

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('package');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }

        if ($count > 0)
            $flag = 'yes';

        return $flag;
    }

    public function isPinAdded() {
        $flag = 'no';

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('pin_numbers');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }

        if ($count > 0)
            $flag = 'yes';

        return $flag;
    }

    public function checkPassCode($prodcutpin, $prodcutid = "") {
        if ($this->product_model->isProductPinAvailable($prodcutid, $prodcutpin))
            return $this->product_model->isPasscodeAvailable($prodcutpin);
    }

    /**
     * @todo Optimization required
     * @param string $sponser_full_name
     * @param int $user_id
     * @return boolean
     */
    public function checkSponser($sponser_full_name, $user_id) {
        $flag = false;

        $sponser_user_id = $this->validation_model->userNameToID($sponser_user_name);
        $sponser_full_name = $this->validation_model->getUserFullName($user_id);

        if ($sponser_user_id > 0) {

            $this->db->select('COUNT(*) AS cnt');
            $this->db->from('user_details');
            $this->db->where('user_detail_refid', $sponser_user_id);
            $this->db->where('user_detail_name', $sponser_full_name);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
            if ($count > 0) {
                $flag = true;
            }
        }
        return $flag;
    }

    public function getPlacementBinary($sponsor_id, $position) {
        $sponsor_array = NULL;
        $this->db->select('id,active');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $sponsor_id);
        $this->db->where('position', $position);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->active == 'server') {
                $sponsor_array ['id'] = $sponsor_id;
                $sponsor_array ['position'] = $position;
            } else {
                $sponsor_array = $this->getPlacementBinary($row->id, $position);
            }
        }
        return $sponsor_array;
    }

    function getPlacementUnilevel($sponsor_id) {
        $sponsor_array = NULL;
        $this->db->select("position");
        $this->db->from("ft_individual");
        $this->db->where('father_id', $sponsor_id);
        $this->db->where('active', 'server');
        $res = $this->db->get();

        foreach ($res->result() as $row) {
            $position = $row->position;
            $sponsor_array['id'] = $sponsor_id;
            $sponsor_array['position'] = $position;
        }
        return $sponsor_array;
    }

    public function checkLeg($sponserleg, $sponser_user_name) {

        $sponserid = $this->validation_model->userNameToID($sponser_user_name);

        return $this->validation_model->isLegAvailable($sponserid, $sponserleg);
    }

    public function checkUser($user_name) {
        $flag = TRUE;
        if ($user_name == "") {
            $flag = FALSE;
            return $flag;
        }

        $this->db->select('COUNT(*) AS cnt');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $user_name);

        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = FALSE;
        }
        return $flag;
    }

    function getEncrypt($string) {
        $key = "EASY1055MLM!@#$";
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }
        return base64_encode($result);
    }

    public function getReferalAmount() {
        $referal_amount = '';
        $this->db->select('referal_amount');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_amount = $row->referal_amount;
        }
        return $referal_amount;
    }

    /**
     * 
     * @param string $user_name This value will be escaped
     * @return int
     */
    public function isUserAvailable($user_name) {
        $this->db->select("COUNT(id) as count");
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $this->db->where('active !=', 'server');
        $query = $this->db->get();
        foreach ($query->result()AS $row) {
            $count = $row->count;
        }

        return $count;
    }

    public function getTermsConditions($lang_id = '') {
        $this->db->select('terms_conditions');
        $this->db->from('terms_conditions');
        if ($lang_id != '')
            $this->db->where('lang_ref_id', $lang_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $terms_con = $row->terms_conditions;
        }
        return stripslashes($terms_con);
    }

    public function getUserDetails($uid) {
        $user_details = array();

        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $uid);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_details = $row;
        }
        return $this->replaceNullFromArray($user_details, 'NA');
    }

    public function replaceNullFromArray($user_detail, $replace = '') {

        if ($replace == '') {
            $replace = "NA";
        }

        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);

        for ($i = 0; $i < $len; $i++) {

            $key_field = $key_up_arr[$i];
            if ($user_detail["$key_field"] == "") {
                $user_detail["$key_field"] = $replace;
            }
        }
        return $user_detail;
    }

    public function getProduct($product_id) {
        $product = array();
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product = $row;
        }
        return $product;
    }

    /**
     * 
     * @param int $user_id This value will be escaped!
     * @return string
     */
    public function getReferralName($user_id) {
        $user_detail_name = NULL;
        $this->db->select('user_detail_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_detail_name = $row->user_detail_name;
        }
        return $user_detail_name;
    }

    public function insertIntoRankHistory($old_rank, $new_rank, $user_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('current_rank', $old_rank);
        $this->db->set('new_rank', $new_rank);
        $this->db->set('date', $date);
        $res = $this->db->insert('rank_history');
        return $res;
    }

    public function updateUserRank($id, $rank) {
        $this->db->set('user_rank_id', $rank);
        $this->db->where('id', $id);
        $result = $this->db->update('ft_individual');
        return $result;
    }

    public function checkMailStatus() {
        $status = NULL;
        $this->db->select('from_name');
        $this->db->select('reg_mail_status');
        $this->db->from('mail_settings');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $status = $row;
        }
        return $status;
    }

    public function insertIntoSalesOrder($user_id, $product_id, $payment_method = "") {
        $date = date('Y-m-d H:i:s');
        $last_inserted_id = $this->db->insert_id();
        $invoice_no = 1000 + $last_inserted_id;
        $product_details = $this->getProduct($product_id);
        $amount = $product_details['product_value'];

        $this->db->set('invoice_no', $invoice_no);
        $this->db->set('prod_id', $product_id);
        $this->db->set('user_id', $user_id);
        $this->db->set('amount', round($amount, 2));
        $this->db->set('date_submission', $date);
        $this->db->set('payment_method', $payment_method);
        $res = $this->db->insert('sales_order');
        return $res;
    }

    /**
     * 
     * @param string $epin This value will be scaped!
     * @return array
     */
    public function checkEPinValidity($epin) {
        $epin_arr = array();
        $date = date('Y-m-d');
        $this->db->select('pin_numbers,pin_balance_amount');
        $this->db->from('pin_numbers');
        $this->db->where('pin_numbers', $epin);
        $this->db->where('pin_amount >', 0);
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $epin_arr['pin_numbers'] = $row['pin_numbers'];
            $epin_arr['pin_amount'] = $row['pin_balance_amount'];
        }
        return $epin_arr;
    }

    public function insertCredicardDetails($credit_card) {
        $data = array(
            'ecom_user_id' => $credit_card['user_id'],
            'credit_card_number' => $credit_card['card_no'],
            'credit_card_type' => $credit_card['credit_card_type'],
            'credit_date' => $credit_card['card_expiry_date'],
            'credit_invoice_number' => $credit_card['card_veri_no'],
            'credit_user_forename' => $credit_card['card_forename'],
            'credit_user_surname' => $credit_card['card_surename'],
            'credit_email' => $credit_card['card_email'],
            'mobile_no' => $credit_card['card_phone'],
        );

        $res = $this->db->insert('credit_card_purchase_details', $data);
        return $res;
    }

    public function UpdateUsedEpin($pin_det, $pin_count) {
        $user_id = $pin_det['user_id'];

        for ($i = 1; $i <= $pin_count; $i++) {
            $pin_no = $pin_det["$i"]['pin'];
            $pin_balnce = $pin_det["$i"]['balance_amount'];
            if ($pin_balnce == 0) {
                $this->db->set('status', "no");
            }
            $this->db->set('used_user', $user_id);
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $this->db->where('pin_numbers', $pin_no);
            $this->db->where('status', "yes");
            $result = $this->db->update('pin_numbers');
        }
        return $result;
    }

    public function insertUsedPin($epin_det, $pin_count) {
        $user_id = $epin_det['user_id'];
        $date = date('Y-m-d H:m:s');

        for ($i = 1; $i <= $pin_count; $i++) {
            $pin_no = $epin_det["$i"]['pin'];
            $pin_balnce = $epin_det["$i"]['balance_amount'];
            $pin_amount = $epin_det["$i"]['amount'];
            $status = "yes";
            if ($pin_balnce == 0) {
                $status = "no";
            }
            $this->db->set('status', $status);
            $this->db->set('pin_number', $pin_no);
            $this->db->set('used_user', $user_id);
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('pin_amount', round($pin_amount, 2));
            $this->db->set('pin_balance_amount', round($pin_balnce, 2));
            $res = $this->db->insert('pin_used');
        }
        return $res;
    }

    public function getProductAmount($product_id) {
        $product_amount = $this->product_model->getProduct($product_id);
        return $product_amount;
    }

    public function getBalanceAmount($user_id, $balance = '') {
        $user_balance = 0;
        $this->db->select('balance_amount');
        $this->db->select('user_id');
        $this->db->where('user_id', $user_id);
        if ($balance != '') {
            $this->db->where('balance_amount >', $balance);
        }
        $this->db->from('user_balance_amount');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_balance = $row['balance_amount'];
        }
        return $user_balance;
    }

    public function checkEwalletPassword($user_id, $password) {
        $flag = 'no';
        $this->db->where('user_id', $user_id);
        $this->db->where('tran_password', $password);
        $this->db->limit(1);
        $this->db->from('tran_password');
        $count = $this->db->count_all_results();
        if ($count) {
            $flag = 'yes';
        }
        return $flag;
    }

    public function insertUsedEwallet($user_ref_id, $user_id, $used_amount) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('used_user_id', $user_ref_id);
        $this->db->set('used_amount', round($used_amount, 2));
        $this->db->set('user_id', $user_id);
        $this->db->set('used_for', 'registration');
        $this->db->set('date', $date);
        $res = $this->db->insert('ewallet_payment_details');
        return $res;
    }

    public function updateUsedEwallet($ewallet_user, $ewallet_bal, $up_bal = '') {
        if ($up_bal == '') {
            $user_id = $this->validation_model->userNameToID($ewallet_user);
        } else {
            $user_id = $ewallet_user;
        }
        $this->db->set('balance_amount', round($ewallet_bal, 2));
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function getPaymentGatewayStatus() {

        $details ['paypal_status'] = $this->getGatewayStatus('Paypal');
        $details ['creditcard_status'] = $this->getGatewayStatus('Creditcard');
        $details ['epdq_status'] = $this->getGatewayStatus('EPDQ');
        $details ['authorize_status'] = $this->getGatewayStatus('Authorize.net');

        return $details;
    }

    public function getGatewayStatus($gateway) {
        $this->db->select('status');
        $this->db->like('gateway_name', $gateway);
        $this->db->from('payment_gateway_config');
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getPaymentStatus($type) {
        $this->db->select('status');
        $this->db->like('payment_type', $type);
        $this->db->from('payment_methods');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getPaymentModuleStatus() {

        $details = array();
        $details ['gateway_type'] = $this->getPaymentStatus('Payment Gateway');
        $details ['epin_type'] = $this->getPaymentStatus('E-pin');
        $details ['free_joining_type'] = $this->getPaymentStatus('Free Joining');
        $details ['ewallet_type'] = $this->getPaymentStatus('E-wallet');
        return $details;
    }

    public function insertintoPaymentDetails($payment_details) {

        $data = array(
            'type' => $payment_details['payment_method'],
            'user_id' => $payment_details['user_id'],
            'acceptance' => $payment_details['acceptance'],
            'payer_id' => $payment_details['payer_id'],
            'order_id' => $payment_details['token_id'],
            'amount' => $payment_details['amount'],
            'currency' => $payment_details['currency'],
            'status' => $payment_details['status'],
            'card_number' => $payment_details['card_number'],
            'ED' => $payment_details['ED'],
            'card_holder_name' => $payment_details['card_holder_name'],
            'date_of_submission' => $payment_details['submit_date'],
            'pay_id' => $payment_details['pay_id'],
            'error_status' => $payment_details['error_status'],
            'brand' => $payment_details['brand']
        );
        $res = $this->db->insert('payment_registration_details', $data);
        return $res;
    }

    public function getRegisterAmount() {
        $amount = 0;
        $this->db->select('reg_amount');
        $this->db->from('configuration');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $amount = $row->reg_amount;
        }
        return $amount;
    }

    public function getProductName($product_id) {
        return $this->product_model->getPrdocutName($product_id);
    }

    public function generateOrderid($name, $type) {
        $order_id = null;
        $date = date('Y-m-d H:i:s');
        $this->db->set('firstname', $name);
        $this->db->set('status', $type);
        $this->db->set('date_added', $date);
        $res = $this->db->insert('epdq_payment_order');
        $order_id = $this->db->insert_id();
        return $order_id;
    }

    public function redirect_out($msg, $page, $message_type = false) {
        //redirection for the registration as it needs not the admin/user in url redirect function is modified 
        $MSG_ARR = array();
        $MSG_ARR["MESSAGE"]["DETAIL"] = $msg;
        $MSG_ARR["MESSAGE"]["TYPE"] = $message_type;
        $MSG_ARR["MESSAGE"]["STATUS"] = true;

        $this->session->set_flashdata('MSG_ARR', $MSG_ARR);
        redirect($page, 'refresh');
    }

    public function authorizePay($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp) {
        require_once 'anet_php_sdk/AuthorizeNet.php';
        $fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp);
        return $fingerprint;
    }

    public function insertAuthorizeNetPayment($response, $user_id = '0') {

        $date = date('Y-m-d H:i:s');

        $this->db->set('user_id', $user_id);
        $this->db->set('first_name', $response['x_first_name']);
        $this->db->set('last_name', $response['x_last_name']);
        $this->db->set('company', $response['x_company']);
        $this->db->set('address', $response['x_address']);
        $this->db->set('city', $response['x_city']);
        $this->db->set('state', $response['x_state']);
        $this->db->set('zip', $response['x_zip']);
        $this->db->set('country', $response['x_country']);
        $this->db->set('phone', $response['x_phone']);
        $this->db->set('fax', $response['x_fax']);
        $this->db->set('email', $response['x_email']);
        $this->db->set('date', $date);
        $this->db->set('invoice_num', $response['x_invoice_num']);
        $this->db->set('description', $response['x_description']);
        $this->db->set('cust_id', $response['x_cust_id']);
        $this->db->set('ship_to_first_name', $response['x_ship_to_first_name']);
        $this->db->set('ship_to_last_name', $response['x_ship_to_last_name']);
        $this->db->set('ship_to_company', $response['x_ship_to_company']);
        $this->db->set('ship_to_address', $response['x_ship_to_address']);
        $this->db->set('ship_to_city', $response['x_ship_to_city']);
        $this->db->set('ship_to_state', $response['x_ship_to_state']);
        $this->db->set('ship_to_zip', $response['x_ship_to_zip']);
        $this->db->set('ship_to_country', $response['x_ship_to_country']);
        $this->db->set('amount', $response['x_amount']);
        $this->db->set('tax', $response['x_tax']);
        $this->db->set('duty', $response['x_duty']);
        $this->db->set('freight', $response['x_freight']);
        $this->db->set('auth_code', $response['x_auth_code']);
        $this->db->set('trans_id', $response['x_trans_id']);
        $this->db->set('method', $response['x_method']);
        $this->db->set('card_type', $response['x_card_type']);
        $this->db->set('account_number', $response['x_account_number']);
        $res = $this->db->insert('authorize_payment_details');
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateAuthorizeNetPayment($insert_id, $user_id) {
        $this->db->set('user_id', $user_id);
        $this->db->where('id', $insert_id);
        $result = $this->db->insert('authorize_payment_details');
        return $result;
    }

    public function getAuthorizeDetails() {
        return $this->configuration_model->getAuthorizeConfigDetails();
    }

    public function sendMailSmtp($mail_subject = '', $mail_message = '', $email = '') {
        $mail_details = $this->getSmtpEmailDetails();
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        // $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_host'] = $mail_details['host'];
        $config['smtp_port'] = $mail_details['port'];
        $config['smtp_timeout'] = $mail_details['time_out'];
        $config['smtp_user'] = $mail_details['username'];
        $config['smtp_pass'] = $mail_details['password'];
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from($config['smtp_user'], 'admin');
        $this->email->to($email);

        $this->email->subject($mail_subject);
        $this->email->message($mail_message);

        $this->email->send();
    }

    function getMailType() {
        $reg_mail_type = '';
        $this->db->select('reg_mail_type');
        $this->db->from('mail_settings');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $reg_mail_type = $row->reg_mail_type;
        }
        return $reg_mail_type;
    }

    public function getSmtpEmailDetails() {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('mail_settings');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mail_details['host'] = $row->smtp_host;
            $mail_details['port'] = $row->smtp_port;
            $mail_details['time_out'] = $row->smtp_timeout;
            $mail_details['username'] = $row->smtp_username;
            $mail_details['password'] = $row->smtp_password;
        }
        return $mail_details;
    }

    public function getWidthCieling() {

        $obj_arr = $this->getSettings();
        $width_cieling = $obj_arr["width_ceiling"];
        return $width_cieling;
    }

    public function getSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["pair_price"] = $row['pair_price'];
            $obj_arr["pair_ceiling"] = $row['pair_ceiling'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["product_point_value"] = $row['product_point_value'];
            $obj_arr["pair_value"] = $row['pair_value'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
            $obj_arr["level_commission_type"] = $row['level_commission_type'];
            $obj_arr["pair_commission_type"] = $row['pair_commission_type'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
        }


        return $obj_arr;
    }

    public function getPlacementBoard($sponsor_id) {
        $user["0"] = $sponsor_id;
        $sponser_arr = $this->checkPosition($user);
        return $sponser_arr;
    }

    public function getPlacementMatrix($sponsor_id) {
        $user["0"] = $sponsor_id;
        $sponser_arr = $this->checkPosition($user);
        return $sponser_arr;
    }

    public function checkPosition($downlineuser) {

        $p = 0;
        $child_arr = "";
        for ($i = 0; $i < count($downlineuser); $i++) {
            $sponsor_id = $downlineuser["$i"];
            $this->db->select("id");
            $this->db->select("position");
            $this->db->from("ft_individual");
            $this->db->where('father_id', $sponsor_id);
            $this->db->where('active !=', 'server');
            $res = $this->db->get();
            $row_count = $res->num_rows();
            if ($row_count > 0) {
                foreach ($res->result_array() as $row) {
                    $width_ceiling = $this->getWidthCieling();
                    if ($row_count < $width_ceiling) {
                        $sponsor['id'] = $sponsor_id;
                        $sponsor['position'] = $row_count + 1;
                        return $sponsor;
                    } else {
                        $child_arr[$p] = $row["id"];
                        $p++;
                    }
                }
            } else {
                $sponsor['id'] = $sponsor_id;
                $sponsor['position'] = 1;
                return $sponsor;
            }
        }

        if (count($child_arr) > 0) {
            $position = $this->checkPosition($child_arr);
            return $position;
        }
    }

    function usernameToID($user_name) {
        return $this->validation_model->userNameToID($user_name);
    }

    function IdToUserName($user_id) {
        return $this->validation_model->IdToUserName($user_id);
    }

    public function getNextPosition($user_id) {

        $this->db->select_min('position');
        $this->db->from('ft_individual');
        $this->db->where('father_id', $user_id);
        $this->db->where('active', "server");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->position;
        }
    }

    public function getProdAndJoiningDetails($user_id) {

        $details = array();
        $this->db->select('*');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {

            $details['product_id'] = $row->product_id;
            $details['date_of_joining'] = date('Y-m-d', strtotime($row->date_of_joining));
        }

        return $details;
    }

    public function getTotalPurchase($user_name, $from_date = '', $to_date = '') {

        $amount = 0;
        $this->db->select('order_id');
        $this->db->where('sponsor', $user_name);
        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("date_added between '$from_date' and'$to_date'");
        } else {
            $this->db->like('date_added', date('Y-m'), 'after');
        }

        $query = $this->db->get('order');

        foreach ($query->result() as $row) {

            $order_id = $row->order_id;
            $amount+=$this->getAmount($order_id);
        }

        return $amount;
    }

    public function getDownlineDetailsAll($id) {
        $arr1[] = $id;
        unset($this->referals);
        $this->referals = array();
        $arr = $this->getReferralCount($arr1, $i = 0);
        return $arr;
    }

    public function getReferralCount($user_id_arr, $i) {
        $temp_user_id_arr = array();
        $qr = $this->createQuerys($user_id_arr);
        $res = $this->selectData($qr, "Error On Selecting 157894512345");
        while ($row = mysql_fetch_array($res)) {
            $this->referals[$i] = $row['id'];
            $temp_user_id_arr[] = $row['id'];
            $i++;
        }
        if (count($temp_user_id_arr) > 0) {
            $this->getReferralCount($temp_user_id_arr, $i);
        }
        return $this->referals;
    }

    public function createQuerys($user_id_arr) {

        if ($this->table_prefix == "") {
            $_SESSION['table_prefix'] = '57_';
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $arr_len = count($user_id_arr);
        if ($arr_len == 1)
            $where_qr = " father_id = '$user_id_arr[0]'";
        else {
            $where_qr = " father_id = '$user_id_arr[0]'";
            for ($i = 1; $i < $arr_len; $i++) {
                $user_id = $user_id_arr[$i];
                $where_qr .= " OR father_id = '$user_id'";
            }
        }


        //  if (count($this->referals) == 0)
        $qr = "Select id from $ft_individual where ($where_qr) and active NOT LIKE 'server'";


        return $qr;
    }

    public function getClosedPartyId($user_id, $from_date = '', $to_date = '') {

        $i = 0;
        $details = array();
        $this->db->select('*');
        $this->db->where('added_by', $user_id);
        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("from_date between '$from_date' and'$to_date'");
        } else {
            $this->db->like('from_date', date('Y-m'), 'after');
        }

        $this->db->where('status', 'closed');
        $query = $this->db->get('party');

        foreach ($query->result() as $row) {

            $details[$i] = $row->id;
            $i++;
        }
        return $details;
    }

    public function totalProductAmountGetFromParty($party_id, $from_date = '', $to_date = '') {

        $amount = 0;
        $this->db->select_sum('total_amount');
        $this->db->where('party_id', $party_id);

        if ($from_date != '') {
            $from_date = $from_date . " " . "00:00:00";
            $to_date = $to_date . ' ' . "23:59:59";
            $this->db->where("date between '$from_date' and'$to_date'");
        } else {
            $this->db->like('date', date('Y-m'), 'after');
        }

        $query = $this->db->get('party_guest_orders');

        foreach ($query->result() as $row) {

            $amount = $row->total_amount;
        }

        return $amount;
    }

    public function getProducts() {
        $product_array = $this->product_model->getAllProducts('yes');
        return $product_array;
    }

    public function deductFromBalanceAmount($user_id, $total_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount -' . $total_amount . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function addOpencartCustomer($data) {
        $customer_group_id = 0;
        $customer_group_info = $this->getCustomerGroup($customer_group_id);

        $this->db->query("INSERT INTO " . $this->db->ocprefix . "customer SET customer_group_id = '" . (int) $customer_group_id . "', store_id = '" . (int) $this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['account']) ? serialize($data['custom_field']['account']) : '') . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int) $data['newsletter'] : 0) . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '" . (int) !$customer_group_info['approval'] . "', date_added = NOW()");

        $customer_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . $this->db->dbprefix . "address SET customer_id = '" . (int) $customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int) $data['country_id'] . "', zone_id = '" . (int) $data['zone_id'] . "', custom_field = '" . $this->db->escape(isset($data['custom_field']['address']) ? serialize($data['custom_field']['address']) : '') . "'");

        $address_id = $this->db->getLastId();

        $this->db->query("UPDATE " . $this->db->dbprefix . "customer SET address_id = '" . (int) $address_id . "' WHERE customer_id = '" . (int) $customer_id . "'");
    }

    public function getCustomerGroup($customer_group_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "customer_group cg LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (cg.customer_group_id = cgd.customer_group_id) WHERE cg.customer_group_id = '" . (int) $customer_group_id . "' AND cgd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

        return $query->row;
    }

    public function checkAllEpins($pin_details, $product_id, $product_status = "no", $return_status = false) {
        $is_pin_ok = false;
        $pin_array = array();
        $reg_amount = $this->getRegisterAmount();
        $product_amount = 0;
        if ($product_status == "yes" && $product_id != "") {
            $product_details = $this->product_model->getProductDetails($product_id, 'yes');
            $product_amount = $product_details[0]['product_value'];
        }

        $total_reg_amount = $product_amount + $reg_amount;
        $total_reg_balance = $total_reg_amount;
        $arr_length = count($pin_details);

        if ($arr_length) {
            for ($i = 0; $i <= $arr_length; $i++) {
                if (isset($pin_details[$i])) {
                    $epin_value = $pin_details[$i]['pin'];
                    $epin_details = $this->checkEPinValidity($epin_value);
                    if ($epin_details) {
                        $epin_amount = $epin_details['pin_amount'];
                        $epin_balance_amount = $epin_details['pin_amount'];
                        $epin_used_amount = $epin_details['pin_amount'];
                        if ($total_reg_balance) {
                            if ($epin_amount == $total_reg_balance) {
                                $epin_balance_amount = 0;
                                $total_reg_balance = 0;
                            } else {
                                if ($epin_amount > $total_reg_balance) {
                                    $epin_balance_amount = $epin_amount - $total_reg_balance;
                                    $epin_used_amount = $total_reg_balance;
                                    $total_reg_balance = 0;
                                } else {
                                    $epin_balance_amount = 0;
                                    $reg_balance = $total_reg_balance - $epin_amount;
                                    $total_reg_balance = ($reg_balance >= 0) ? $reg_balance : 0;
                                }
                            }
                            if ($total_reg_balance == 0) {
                                $is_pin_ok = true;
                            }
                        } else {
                            $epin_used_amount = 0;
                        }
                        $pin_array["$i"]['pin'] = $epin_details['pin_numbers'];
                        $pin_array["$i"]['amount'] = $epin_amount;
                        $pin_array["$i"]['balance_amount'] = $epin_balance_amount;
                        $pin_array["$i"]['reg_balance_amount'] = $total_reg_balance;
                        $pin_array["$i"]['epin_used_amount'] = $epin_used_amount;
                    } else {
                        $pin_array["$i"]['pin'] = 'nopin';
                        $pin_array["$i"]['amount'] = '0';
                        $pin_array["$i"]['balance_amount'] = '0';
                        $pin_array["$i"]['reg_balance_amount'] = '0';
                        $pin_array["$i"]['epin_used_amount'] = '0';
                    }
                }
            }
        } else {
            $pin_array["0"]['pin'] = 'nopin';
            $pin_array["0"]['amount'] = '0';
            $pin_array["0"]['balance_amount'] = '0';
            $pin_array["0"]['reg_balance_amount'] = '0';
            $pin_array["0"]['epin_used_amount'] = '0';
        }
        if ($return_status) {
            $pin_array['is_pin_ok'] = $is_pin_ok;
        }
        return $pin_array;
    }

    public function getUserSponsorTreeLevel($user_id, $from_id, $level = 0) {
        $this->db->select('sponsor_id');
        $this->db->where('id', $from_id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {
            $father_id = $row->sponsor_id;
            $level++;
            if ($father_id && $father_id < $user_id) {
                $level = $this->getUserSponsorTreeLevel($user_id, $father_id, $level);
            }
        }

        return $level;
    }

}
