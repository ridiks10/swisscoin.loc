<?php

class profile_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('registersubmit_model');
        $this->load->model('validation_model');
        $this->load->model('file_upload_model');
        $this->load->model('member_model');
    }

    public function userNameToId($user_name) {

        $user_id = $this->validation_model->userNameToID($user_name);
        return $user_id;
    }

    public function getProfileDetails($user_id, $u_name, $product_status, $lang_id = '', $table_prefix = "") {
        $this->db->select('*');
        $this->db->from($table_prefix . 'user_details AS u');
        $this->db->join($table_prefix . 'ft_individual AS f', 'u.user_detail_refid = f.id', 'INNER');
        $this->db->where('user_detail_refid', $user_id);
        $result = $this->db->get();
        $qr = $this->db->last_query();
        $profile_arr['details'] = $this->getUserDetails($qr, $lang_id, $table_prefix);
        $profile_arr['sponser'] = $this->validation_model->getSponserIdName($user_id, $table_prefix);
        if ($product_status == "yes") {
            $profile_arr['product_name'] = $this->validation_model->getProductNameFromUserID($user_id, $table_prefix);
        }
        return $profile_arr;
    }

    public function updateUserDetails($regr, $user_ref_id) {
        $res = $this->registersubmit_model->updateUserDetails($regr, $user_ref_id);
        return $res;
    }

    public function changeUsername($user_id, $user_name, $new_user_name) {
        $flag = false;

        $user_type = $this->validation_model->getUserType($user_id);
        if ($user_type == 'admin')
            $is_mlm_user_name = $this->checkUserName($new_user_name);
        else
            $is_mlm_user_name = true;

        if ($is_mlm_user_name) {
            $this->db->set('user_name', $new_user_name);
            $this->db->where('user_id', $user_id);
            $this->db->where('user_name', $user_name);
            $query = $this->db->update('login_user');
            if ($query) {

                $res_ft = $this->updateUsernameFtIndividual($user_id, $new_user_name);
                if ($res_ft) {
                    //$updt_customer = $this->updateCustomer($user_id, $new_user_name);
                    //if ($updt_customer) {
                    $res_his = $this->updateUsernameHistory($user_id, $user_name, $new_user_name);
                    if ($res_his) {
                        if ($user_type == 'admin')
                            $res = $this->updtMlmUsrDetails($new_user_name);
                        else
                            $res = 1;
                        if ($res)
                            $flag = true;
                    }
                    // }
                }
            }
        }
        return $flag;
    }

    public function updateUsernameFtIndividual($user_id, $new_user_name) {
        $this->db->set('user_name', $new_user_name);
        $this->db->where('id', $user_id);
        $res_unilevel = $this->db->update('ft_individual');
        return $res_unilevel;
    }

    public function updateUsernameHistory($user_id, $user_name, $new_user_name) {
        $data = array(
            'user_id' => $user_id,
            'old_username' => $user_name,
            'new_username' => $new_user_name,
            'modified_date' => date('y-m-d H:i:s')
        );
        $res = $this->db->insert('username_change_history', $data);
        return $res;
    }

    public function updateCustomer($user_id, $new_user_name) {
        $customer_id = $this->validation_model->getOcCustomerId($user_id);
        $this->db->set('user_name', $new_user_name);
        $this->db->where('customer_id', $customer_id);
        $res = $this->db->update('customer');
        return $res;
    }

    public function getUserDetails($qr, $lang_id = '', $table_prefix = '') {
        $this->load->model('country_state_model');
        $user_detail = array();
        $res1 = $this->db->query($qr);
        $i = 1;
        foreach ($res1->result_array() as $row) {
            $user_detail["detail$i"]["id"] = $row["user_detail_refid"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["second_name"] = $row["user_detail_second_name"];
            $user_detail["detail$i"]["address"] = $row["user_detail_address"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["position"] = $row["position"];
            $user_detail["detail$i"]["network"] = $row["default_leg"];
            $user_detail["detail$i"]["country_code"] = $row["user_detail_country"];
            $user_detail["detail$i"]["country"] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $user_detail["detail$i"]["state"] = $this->country_state_model->getStateNameFromId($row["user_detail_state"]);
            $user_detail["detail$i"]["pincode"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["passcode"] = $row["user_detail_passcode"];
            $user_detail["detail$i"]["mobile"] = $row["user_detail_mobile"];
            $user_detail["detail$i"]["land"] = $row["user_detail_land"];
            $user_detail["detail$i"]["user_detail_second_name"] = $row["user_detail_second_name"];
            $user_detail["detail$i"]["user_detail_address2"] = $row["user_detail_address2"];
            $user_detail["detail$i"]["user_detail_city"] = $row["user_detail_city"];
            $user_detail["detail$i"]["email"] = $row["user_detail_email"];
            $user_detail["detail$i"]["dob"] = $row["user_detail_dob"];
            $user_detail["detail$i"]["gender"] = $row["user_detail_gender"];
            $user_detail["detail$i"]["nominee"] = $row["user_detail_nominee"];
            $user_detail["detail$i"]["relation"] = $row["user_detail_relation"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["bank_country"] = $row["user_detail_bank_country"];
            $user_detail["detail$i"]["level"] = $row["user_level"];
            $user_detail["detail$i"]["date"] = $row["join_date"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["referral"] = $row["sponsor_id"];
            $user_detail["detail1"]["nominee"] = $row["user_detail_nominee"];
            $user_detail["detail1"]["relation"] = $row["user_detail_relation"];
            $user_detail["detail1"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail1"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail1"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail1"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail1"]["passport_id"] = $row["passport_id"];
            $user_detail["detail1"]["id_expire"] = $row["id_expire"];
            $user_detail["detail1"]["father_name"] = $this->validation_model->getFullName($row["father_id"]);
            $user_detail["detail1"]["sponsor_name"] = $this->validation_model->getFullName($row["sponsor_id"]);
//            $user_detail["detail1"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["facebook"] = $row["user_detail_facebook"];
            $user_detail["detail$i"]["twitter"] = $row["user_detail_twitter"];
            $user_detail["detail$i"]["tax-id"] = $row["tax_id"];
            $user_detail["detail$i"]["tax-number"] = $row["tax_number"];

            $i++;
        }
        $user_detail = $this->replaceNullFromArray($user_detail, "NA");
        return $user_detail;
    }

    public function replaceNullFromArray($user_detail, $replace = '') {
        if ($replace == '') {
            $replace = "NA";
        }
        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);
        for ($i = 1; $i <= $len; $i++) {
            $k = $i - 1;
            $fild = $key_up_arr[$k];
            $arr_key = array_keys($user_detail["$fild"]);
            $key_len = count($arr_key);
            for ($j = 0; $j < $key_len; $j++) {
                $key_field = $arr_key[$j];
                if ($user_detail["$fild"]["$key_field"] == "") {
                    $user_detail["$fild"]["$key_field"] = $replace;
                }
            }
        }
        return $user_detail;
    }

    public function getUserPhoto($user_id) {
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->user_photo;
        }
    }

    public function changeProfilePicture($user_id, $file_name) {
        $arr = array(
            'user_photo' => $file_name
        );
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->update('user_details', $arr);
        return $res;
    }

    public function createThumbs($from_name, $to_name, $max_x, $max_y) {
        ini_set('memory_limit', '-1');

        // include image processing code
        include('image.class.php');
        $img = new Zubrag_image;

        // initialize
        $img->max_x = $max_x;
        $img->max_y = $max_y;

        $img->cut_x = 0;
        $img->cut_y = 0;
        $img->quality = 100;
        $img->save_to_file = true;
        $img->image_type = -1;
        $img->GenerateThumbFile($from_name, $to_name);
    }

    /**
     * 
     * @param array $network All value will be escaped ['id' => 3, 'position' => 'left]
     * @return bool
     */
    public function updateUserNetwork($network) {

        $id = $network['id'];
        $position = $network['position'];
        $this->db->where('id', $id);
        $this->db->set('default_leg', $position);
        $res = $this->db->update('ft_individual');
        return $res;
    }

    public function checkUserName($new_user_name) {

        $flag = 0;
        $query = $this->db->query("select count(id) AS cnt from infinite_mlm_user_detail  WHERE user_name='$new_user_name' AND account_status != 'deleted' LIMIT 1");

        foreach ($query->result_array() as $row) {
            $count = $row['cnt'];
        }
        if ($count == 0) {
            $flag = 1;
        }
        return $flag;
    }

    public function updtMlmUsrDetails($new_user_name) {
        $table_prefix = $this->table_prefix;

        $res = $this->db->query("update infinite_mlm_user_detail SET user_name ='$new_user_name' WHERE id='$table_prefix'");
        return $res;
    }

    function user_summary_header($username) {
        $user_detail = array();
        $is_valid_username = $this->val->isUserNameAvailable($username);
        $details = array();
        if ($is_valid_username) {
            $user_id = $this->val->userNameToID($username);
            $profile_arr = $this->getProfileDetails($user_id, '', '', '');

            $details = $profile_arr['details']['detail1'];
            $file_name = $this->getUserPhoto($user_id);
            if ($file_name == '')
                $file_name = 'nophoto.jpg';

            $details['file_name'] = $file_name;
            $details['username'] = $username;
            $details['user_id'] = $user_id;
        }
        $details['is_valid_user_name'] = $is_valid_username;
        return $details;
    }

    public function getUserDefaultValues($user_id) {
        $details = array();
        $name = '';
        $surname = '';
        $this->db->select('user_detail_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            if ($row->user_detail_name != 'NA')
                $name = $row->user_detail_name;
            $details['name'] = $name . " " . $surname;
        }
        return $details;
    }

    public function getBankingDetails($user_id) {
        $details = array();
        $this->db->select('*');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get('user_details');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $row) {
                $details['user_detail_acnumber'] = $row->user_detail_acnumber;
                $details['user_detail_ifsc'] = $row->user_detail_ifsc;
                $details['user_detail_nbank'] = $row->user_detail_nbank;
                $details['user_detail_nbranch'] = $row->user_detail_nbranch;
            }
        }
        //$details = $this->replaceNullFromArrayOneD($details, "NA");
        return $details;
    }

    public function replaceNullFromArrayOneD($user_detail, $replace = '') {
        if ($replace == '') {
            $replace = "NA";
        }
        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);

        for ($i = 1; $i <= $len; $i++) {
            $k = $i - 1;
            $fild = $key_up_arr[$k];
            $arr_key = array_keys($user_detail["$fild"]);
            $key_len = count($arr_key);
            for ($j = 0; $j < $key_len; $j++) {
                $key_field = $arr_key[$j];
                if ($user_detail["$fild"]["$key_field"] == "") {
                    $user_detail["$fild"]["$key_field"] = $replace;
                }
            }
        }
        return $user_detail;
    }

    public function updateBankingDetails($user_id, $post_arr) {


        $this->db->set('user_detail_nbank', $post_arr['bank']);
        $this->db->set('user_detail_nbranch', $post_arr['branch']);
        $this->db->set('user_detail_ifsc', $post_arr['ifsc']);
        $this->db->set('user_detail_acnumber', $post_arr['acc_no']);
        $this->db->where('user_detail_refid', $user_id);

        $res = $this->db->update('user_details');

        return $res;
    }

    public function uploadDocuments($address = '', $passport = '', $user_id) {
        $user_exist = $this->checkUserExist($user_id);

        if ($address != '')
            $this->db->set('address_proof', $address);
            $this->db->set('address_status', 'submit');
        if ($passport != '')
            $this->db->set('passport_proof', $passport);
            $this->db->set('passport_status', 'submit');

        if ($user_exist) {
            $this->db->where('user_id', $user_id);
            $res = $this->db->update('kyc_details');
        } else {
            $this->db->set('user_id', $user_id);
            $res = $this->db->insert('kyc_details');
        }

        return $res;
    }

    public function checkUserExist($user_id) {
        $status = false;
        $this->db->select('user_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('kyc_details');
        if ($query->num_rows > 0) {
            $status = true;
        }

        return $status;
    }

    public function getUserVerificationDetails($id = '') {
        $data = array();
        if ($id != '') {
            $this->db->where('user_id', $id);
            $this->db->limit(1);
        }
        $query = $this->db->get('kyc_details');
        foreach ($query->result_array() as $row) {

            $row['username'] = $this->validation_model->IdToUserName($row['user_id']);
            $data[] = $row;
        }
        return $data;
    }

    public function updateUserVerification($verify_id, $doc_arr) {

       
        if (isset($doc_arr['address']) && $doc_arr['address']== 'yes')
            $this->db->set('address_status', 'verified');
        if (isset($doc_arr['passport']) && $doc_arr['passport']== 'yes')
            $this->db->set('passport_status', 'verified');

        $this->db->where('id', $verify_id);
        $this->db->limit(1);
        $query = $this->db->update('kyc_details');

        return $query;
    }
    public function rejectUserVerification($verify_id, $doc_arr) {

       
       if (isset($doc_arr['address']) && $doc_arr['address']== 'yes')
            $this->db->set('address_status', 'reject');
        if (isset($doc_arr['passport']) && $doc_arr['passport']== 'yes')
            $this->db->set('passport_status', 'reject');

        $this->db->where('id', $verify_id);
        $this->db->limit(1);
        $query = $this->db->update('kyc_details');

        return $query;
    }

    public function getDiamondRanks() {
        $rank = array();
        $this->db->select('id,leadership_rank, 0 as \'count\'',false);
        $this->db->order_by('order');
        $query = $this->db->get('careers');
//        $i = 1;
        foreach ($query->result_array() as $row) {
            $rank[] = $row;
//            $rank[$i]['rank_name'] = $row['rank_name'];
//            $rank[$i]['achievers_cnt'] = $this->getAchieversCount($row['rank_id'], 'pending');
//            $i++;
        }
        return $rank;
    }
    
    public function getAchievers($career_id) {
       
        $data = array();
        $this->db->select('ft.user_name, CONCAT(pd.user_detail_name, ", ", pd.user_detail_second_name) as realname', false);
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details AS pd', 'ft.id = pd.user_detail_refid');
        $this->db->where('career', $career_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function getKYCStatus($user_id){
        return 'approved';
        $statuses_rank = [
            //todo:'rejected' => 0,
            'submit' => 1,
            'approved' => 2
        ];
        $kyc_details = $this->db->select('address_status,passport_status')->from('kyc_details')->where('user_id', $user_id)->get()->row(0, 'array');
        if(empty($kyc_details)){
            return 'missing';
        }else{
            #todo: the next commented snippet for future
            /*if(($res = $statuses_rank[$kyc_details['address_status']] + $statuses_rank[$kyc_details['passport_status']]) <= 2){
                return 'pending';
            }else{
                return 'approved';
            }*/
            return 'approved';
        }

    }

}
