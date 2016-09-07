<?php

class configuration_model extends inf_model {

    private $mailObj;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function initialize() {

        $this->load->model('settings_model');
        $this->load->model('file_upload_model');
        $this->load->model('tooltip_class_model');
    }

    public function getSettings() {
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $obj_arr = $row;
        }

        return $obj_arr;
    }

    public function getPackages() {
        $packages = "";
        $this->db->select("product_name,product_id");
        $this->db->from('package');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $packages[] = $row;
//           $packages .= "<option value= " . $row['product_id'] . "> " . $row['product_name'] . "</option>";
        }

        return $packages;
    }

    public function getBoardSettings($board_no = '') {
        if ($board_no != '') {
            $this->db->where('board_id', $board_no);
        }
        $query = $this->db->get('board_configuration');
        return $query->result_array();
    }

    public function getStatcountSettings() {
        $query = $this->db->get('stat_counter');
        foreach ($query->result_array() as $row) {
            $obj_arr = $row;
        }

        return $obj_arr;
    }

    function setLevel($depth, $depth_no) {

        $query = NULL;
        if ($depth_no != $depth) {

            $this->db->truncate('level_commision');

            for ($j = 1, $i = $depth; $j <= $depth; $j++, $i--) {
                $this->db->set('level_no', $j);
                $this->db->set('level_percentage', $i);
                $query = $this->db->insert('level_commision');
            }
        }
        return $query;
    }

    public function updateDepth($depth) {

        $this->db->set('depth_ceiling', $depth);
        $query = $this->db->update('configuration');

        return $query;
    }

    public function getPayOutTypes() {
        $payout_release = NULL;
        $this->db->select('payout_release');
        $query = $this->db->get('configuration');
        foreach ($query->result() as $row) {
            $payout_release = $row->payout_release;
        }

        return $payout_release;
    }

    public function insertdate($arr) {
        $query = NULL;
        $l = count($arr);
        $data = array();
        for ($i = 0; $i < $l; $i++) {
            $res = $this->isExist($arr[$i]);
            if ($res) {
                $this->db->set('release_date', $arr[$i]);
                $query = $this->db->insert('payout_release_date');
            }
        }
        return $query;
    }

    public function getmonth($startDate, $endDate) {
        $mnth = array();
        $start = new DateTime($startDate);
        $start->modify('first day of this month');
        $end = new DateTime($endDate);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $mnth[] = $dt->format('Y-m-d') . '<br>\n';
        }
        return $mnth;
    }

    public function insertmonth($arr) {
        $query = NULL;
        $l = count($arr);
        $data = array();
        for ($i = 0; $i < $l; $i++) {
            $res = $this->isExist($arr[$i]);
            if ($res) {
                $this->db->set('release_date', $arr[$i]);
                $query = $this->db->insert('payout_release_date');
            }
        }
        return $query;
    }

    public function isExist($data) {

        $this->db->select("COUNT('release_date') AS cnt");
        $this->db->where('release_date', $data);
        $this->db->from('payout_release_date');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            if ($row->cnt != 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    public function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber) {

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $dateArr = array();

        do {
            if (date('w', $startDate) != $weekdayNumber) {
                $startDate += (24 * 3600); // add 1 day
            }
        } while (date('w', $startDate) != $weekdayNumber);


        while ($startDate <= $endDate) {
            $dateArr[] = date('Y-m-d', $startDate);
            $startDate += (7 * 24 * 3600); // add 7 days
        }

        return($dateArr);
    }

    public function getLetterSetting($lang_id = 1) {
        $letter_array = NULL;
        if ($lang_id != NULL) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $query = $this->db->get('letter_config');

        foreach ($query->result_array() as $row) {
            $letter_array = $row;
        }

        return $letter_array;
    }

    public function updateLetterSetting($post) {

        $company_name = $post['company_name'];
        $company_add = $post['company_add'];
        $lang_id = $post['lang_id'];
        $main_matter = addslashes($post['txtDefaultHtmlArea']);
        $product_matter = $post['product_matter'];
        $place = $post['place'];
        if (array_key_exists('logo_name', $post)) {

            $file_name = $post['logo_name'];

            $this->db->set('company_name', $company_name);
            $this->db->set('address_of_company', $company_add);
            $this->db->set('main_matter', $main_matter);
            $this->db->set('logo', $file_name);
            $this->db->set('productmatter', $product_matter);
            $this->db->set('place', $place);
            if ($lang_id != NULL)
                $this->db->where('lang_ref_id', $lang_id);
            $query = $this->db->update('letter_config');
        } else {

            $this->db->set('company_name', $company_name);
            $this->db->set('address_of_company', $company_add);
            $this->db->set('main_matter', $main_matter);
            $this->db->set('productmatter', $product_matter);
            $this->db->set('place', $place);
            if ($lang_id != NULL)
                $this->db->where('lang_ref_id', $lang_id);
            $query = $this->db->update('letter_config');
        }

        return $query;
    }

    public function updateConfigurationSettings($post_array, $module_status, $board_count) {

        $settings_array = array();
        $board_settings_array = array();
        $level_settings_array = array();
        $settings = $this->validation_model->getSettings();
        $depth_ceiling = $settings['depth_ceiling'];

        if ($this->MLM_PLAN == "Binary") {
            $settings_array['pair_commission_type'] = $post_array['pair_commission_type'];
            $post_array['pair_price'] = round((floatval($post_array['pair_price'])), 2);
            $settings_array['pair_price'] = $post_array['pair_price'];
        } else if ($this->MLM_PLAN == "Board") {
            for ($i = 0; $i < $board_count; $i++) {
                $board_settings_array[$i]["board_commission"] = $post_array["board" . $i . "_commission"];
            }
        }

        if ($module_status['referal_status'] == 'yes') {
            $post_array['referal_amount'] = round((floatval($post_array['referal_amount'])), 2);
            $settings_array['referal_amount'] = $post_array['referal_amount'];
        }

        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $module_status['sponsor_commission_status'] == 'yes') {
            $settings_array['level_commission_type'] = $post_array['level_commission_type'];

            for ($j = 1; $j <= $depth_ceiling; $j++) {
                if (array_key_exists('level_percentage' . $j, $post_array)) {
                    $level_settings_array[$j] = $post_array['level_percentage' . $j];
                }
            }
        }

        $post_array['service_charge'] = round((floatval($post_array['service_charge'])), 2);
        $post_array['tds'] = round((floatval($post_array['tds'])), 2);
        $post_array['trans_fee'] = round((floatval($post_array['trans_fee'])), 2);
        $settings_array['reg_amount'] = $post_array['reg_amount'];
        $settings_array['tds'] = $post_array['tds'];
        $settings_array['service_charge'] = $post_array['service_charge'];
        $settings_array['trans_fee'] = $post_array['trans_fee'];
        $settings_array['setting_staus'] = 'yes';

        $query = $this->db->update('configuration', $settings_array);

        if ($level_settings_array) {
            $result_level = $this->configuration_model->updatLevelSettings($level_settings_array);
        }
        if ($board_settings_array) {
            for ($i = 0; $i < $board_count; $i++) {
                $this->db->where('board_id', $i + 1);
                $result = $this->db->update('board_configuration', $board_settings_array[$i]);
            }
        }

        return $query;
    }

    public function updateConfigurationSettingsBonus($post_array, $module_status, $board_count) {

//        print_r($post_array);die();

        $settings_array = array();
        $board_settings_array = array();
        $level_settings_array = array();
        $settings = $this->validation_model->getSettings();
        $depth_ceiling = $settings['depth_ceiling'];



        if ($module_status['referal_status'] == 'yes') {
            $post_array['referal_amount'] = round((floatval($post_array['referal_amount'])), 2);
            $settings_array['referal_amount'] = $post_array['referal_amount'];
        }

        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $module_status['sponsor_commission_status'] == 'yes') {
            $settings_array['level_commission_type'] = $post_array['level_commission_type'];

            for ($j = 1; $j <= $depth_ceiling; $j++) {
                if (array_key_exists('level_percentage' . $j, $post_array)) {
                    $level_settings_array[$j] = $post_array['level_percentage' . $j];
                }
            }
        }

        //direct bonus
        $settings_array['db_percentage'] = $post_array['db_percentage'];

        //fast start bonus
        $settings_array['fsb_percentage'] = $post_array['fsb_percentage'];
        $settings_array['fsb_required_firstliners'] = $post_array['fsb_required_firstliners'];
        $settings_array['fsb_accumulated_turn_over_1'] = $post_array['fsb_accumulated_turn_over_1'];
        $settings_array['fsb_accumulated_turn_over_2'] = $post_array['fsb_accumulated_turn_over_2'];

        $settings_array['fsb_firstliners_pack'] = $post_array['fsb_firstliners_pack'];

        //matching bonus
        $settings_array['mb_minimum_pack'] = $post_array['mb_minimum_pack'];
        $settings_array['mb_required_firstliners'] = $post_array['mb_required_firstliners'];
        $settings_array['mb_first_line_minimum_pack'] = $post_array['mb_first_line_minimum_pack'];


//team bonus   
        $settings_array['tb_required_firstliners'] = $post_array['tb_required_firstliners'];
        $settings_array['tb_first_line_minimum_pack'] = $post_array['tb_first_line_minimum_pack'];
        $settings_array['tb_1000'] = $post_array['tb_1000'];
        $settings_array['tb_5000'] = $post_array['tb_5000'];
        $settings_array['tb_10000'] = $post_array['tb_10000'];
        $settings_array['tb_25000'] = $post_array['tb_25000'];
        $settings_array['tb_50000'] = $post_array['tb_50000'];
        $settings_array['tb_100000'] = $post_array['tb_100000'];
        $settings_array['tb_250000'] = $post_array['tb_250000'];
        $settings_array['tb_500000'] = $post_array['tb_500000'];
        $settings_array['tb_1000000'] = $post_array['tb_1000000'];
        $settings_array['tb_5000000'] = $post_array['tb_5000000'];
        $settings_array['tb_10000000'] = $post_array['tb_10000000'];
//diamnd pool   
        $settings_array['dp_percentage'] = $post_array['dp_percentage'];

        $query = $this->db->update('configuration', $settings_array);

        if ($level_settings_array) {
            $result_level = $this->configuration_model->updatLevelSettings($level_settings_array);
        }
//        if ($board_settings_array) {
//            for($i = 0; $i < $board_count; $i++) {
//                $this->db->where('board_id', $i + 1);
//                $result = $this->db->update('board_configuration', $board_settings_array[$i]);
//            }
//        }

        return $query;
    }

    public function updatLevelSettings($level_settings_array) {
        $c = count($level_settings_array);
        for ($j = 1; $j <= $c; $j++) {
            $this->db->set('level_percentage', $level_settings_array[$j]);
            $this->db->where('level_no', $j);
            $rec = $this->db->update('level_commision');
        }
        return $rec;
    }

    public function updatBoardSettings($board_settings, $board_count = '1') {
        for ($i = 0; $i < $board_count; $i++) {
            $this->db->where('board_id', $i + 1);
            $result = $this->db->update('board_configuration', $board_settings[$i]);
        }
        return ($result);
    }

    public function updatePayoutSettng($min_payout, $payout_validity, $payout_status, $max_payout) {
        $this->db->set('min_payout', $min_payout);
        $this->db->set('max_payout', $max_payout);
        $this->db->set('payout_request_validity', $payout_validity);
        $query = $this->db->update('configuration');
        if ($query) {
            $ewallet_request_status = "no";
            if ($payout_status == 'ewallet_request') {
                $ewallet_request_status = 'yes';
            }
            $this->db->set('sub_status', $ewallet_request_status);
            $this->db->where('sub_id', 49);
            $query1 = $this->db->update('infinite_mlm_sub_menu');
            return $query1;
        }
    }

    public function updateStatcountSettngs($sc_project, $sc_invisible, $sc_security) {

        $this->db->set('sc_project', $sc_project);
        $this->db->set('sc_invisible', $sc_invisible);
        $this->db->set('sc_security', $sc_security);
        $query = $this->db->update('stat_counter');
        return $query;
    }

    public function getReferalDetails($user_id, $limit, $offset, $table_prefix = NULL) {

        $this->load->model('country_state_model');

        $session_data = $this->session->userdata('inf_logged_in');
        $arr = array();

        if ($session_data['user_type'] == 'admin' || $table_prefix != NULL || $session_data['user_type'] == 'employee') {
            $id = $user_id;
        } else {
            $id = $session_data['user_id'];
        }
        if ($id != NULL) {

            $this->db->select('user_detail_refid');
            $this->db->select('user_detail_name');
            $this->db->select('join_date');
            $this->db->select('user_detail_email');
            $this->db->select('user_detail_country');
            $this->db->from('user_details');
            $this->db->where('user_details_ref_user_id', $id);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();

            $i = 0;
            foreach ($query->result_array() as $row) {
                $user_id = $row['user_detail_refid'];
                $arr[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $arr[$i]['name'] = $row['user_detail_name'];
                $arr[$i]['join_date'] = $row['join_date'];
                $arr[$i]['email'] = $row['user_detail_email'];
                $arr[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
                $i++;
            }

            for ($j = 0; $j < count($arr); $j++) {
                if ($arr[$j]['email'] == NULL)
                    $arr[$j]['email'] = 'NA';
                if ($arr[$j]['country'] == NULL)
                    $arr[$j]['country'] = 'NA';
            }
            return $arr;
        }
    }

    public function getReferalDetailscount($user_id) {
        $this->db->select('count(*) as cnt');
        $this->db->from('user_details');
        $this->db->where('user_details_ref_user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function setReferalStatus($referal_status) {
        if ($referal_status != NULL) {
            $this->db->set('referal_status', $referal_status);
            $query = $this->db->update('module_status');

            return $query;
        }
    }

    public function setCreditCardStatus($id, $status) {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_gateway_config');
    }

    public function getCreditCardStatus() {

        $this->db->select('*');
        $this->db->from('payment_gateway_config');
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get();
        $details = array();
        $i = 0;
        foreach ($query->result() as $row) {
            if ($row->gateway_name != 'Creditcard') {
                $details[$i]['id'] = $row->id;
                $details[$i]['gateway_name'] = $row->gateway_name;
                $details[$i]['status'] = $row->status;
                $details[$i]['logo'] = $row->logo;
                $details[$i]['sort_order'] = $row->sort_order;
                $details[$i]['mode'] = $row->mode;
                $i++;
            }
        }
        return $details;
    }

    public function setLanguageStatus($lang_id, $status) {
        $this->db->set('status', $status);
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->update('infinite_languages');
        if ($query && $status == "no") {
            $this->load->model("multi_language_model");
            $default_lang_id = $this->getDefaultLangID($lang_id);

            if ($lang_id == $default_lang_id) {
                $user_id = $this->LOG_USER_ID;
                $default_lang_id = $this->multi_language_model->getActiveLangaugeID();
                $this->multi_language_model->setDefaultLanguage($default_lang_id, $user_id);
            }
            $this->multi_language_model->updateAllUserDefaultLanguage($lang_id, $default_lang_id);
        }
        return $query;
    }

    public function getDefaultLangID() {
        $lang_id = 1;
        $this->db->select('lang_id');
        $this->db->where('default_id', 1);
        $query = $this->db->get('infinite_languages');
        foreach ($query->result_array() AS $row) {
            $lang_id = $row['lang_id'];
        }
        return $lang_id;
    }

    public function setModuleStatus($module_name, $status) {
        $this->db->set($module_name, $status);
        $query = $this->db->update('module_status');
        if ($query) {
            $this->updateLeftMenus($module_name, $status);
        }
        if ($module_name == 'opencart_status') {
            if ($status == 'yes') {
                $this->db->set('product_status', $status);
                $query = $this->db->update('module_status');
                $this->updateLeftMenus('product_status', 'no');
            } else {
                $this->updateLeftMenus('product_status', 'yes');
            }
        }
        return $query;
    }

    public function updateLeftMenus($module_name, $status) {
        if ($module_name == 'ewallet_status') {
            $this->setPaymentStatus(3, $status);
            $this->db->set('status', $status);
            $this->db->where('id', 14);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->setSubMenuStatus(14, $status);
            }
        } else if ($module_name == 'sponsor_tree_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 3);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'sponsor_commission_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 54);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'rank_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 7);
            $query = $this->db->update('infinite_mlm_sub_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 34);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'sms_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 18);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->setSubMenuStatus(18, $status);
                $this->db->set('sub_status', $status);
                $this->db->where('sub_id', 9);
                $query = $this->db->update('infinite_mlm_sub_menu');
            }
        } else if ($module_name == 'employee_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 17);
            $query = $this->db->update('infinite_mlm_menu');
            if ($query) {
                $this->setSubMenuStatus(17, $status);
            }
        } else if ($module_name == 'upload_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 13);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'lead_capture_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 26);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'multy_currency_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 27);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'ticket_system_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 32);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'autoresponder_status') {
            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', 56);
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'pin_status') {
            $this->setPaymentStatus(2, $status);
            $this->db->set('status', $status);
            $this->db->where('id', 13);
            $query1 = $this->db->update('infinite_mlm_menu');
            if ($query1) {
                $this->db->set('sub_status', $status);
                $this->db->where("(sub_refid='13' OR sub_id = '5' OR sub_id = '27' OR sub_id = '36') ");
                $query = $this->db->update('infinite_mlm_sub_menu');
            }
        } else if ($module_name == 'product_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 12);
            $query = $this->db->update('infinite_mlm_menu');

            $this->db->set('sub_status', $status);
            $this->db->where('sub_id', '38');
            $query = $this->db->update('infinite_mlm_sub_menu');
        } else if ($module_name == 'referal_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 22);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == "sponsor_commission_status") {
            if ($status == "yes") {
                $this->db->set('db_amt_type', 'level_commission');
                $this->db->set('view_amt_type', 'Level Commission');
                $query = $this->db->insert('amount_type');
            } else {
                $this->db->where('db_amt_type', 'level_commission');
                $query = $this->db->delete('amount_type');
            }
        } else if ($module_name == 'multy_currency_status') {
            $this->db->set('status', $status);
            $this->db->where('id', 27);
            $query = $this->db->update('infinite_mlm_menu');
        } else if ($module_name == 'opencart_status') {
            if ($status == 'yes') {
                $stat = 'no';
            } else {
                $stat = 'yes';
            }
            $this->db->set('status', $status);
            $this->db->where('id', 37);
            $query1 = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $stat);
            $this->db->where('id', 12);
            $query2 = $this->db->update('infinite_mlm_menu');

            $this->db->set('status', $status);
            $this->db->where('id', 38);
            $query3 = $this->db->update('infinite_mlm_menu');
        }
    }

    public function setSubMenuStatus($sub_refid, $status) {
        $this->db->set('sub_status', $status);
        $this->db->where('sub_refid', $sub_refid);
        $query = $this->db->update('infinite_mlm_sub_menu');
    }

    public function getModuleStatus() {
        $status_arr = array();
        $this->db->select('*');
        $this->db->from('module_status');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $status_arr['pin_status'] = $row['pin_status'];
            $status_arr['product_status'] = $row['product_status'];
            $status_arr['sms_status'] = $row['sms_status'];
            $status_arr['referal_status'] = $row['referal_status'];
            $status_arr['ewallet_status'] = $row['ewallet_status'];
            $status_arr['upload_status'] = $row['upload_status'];
            $status_arr['rank_status'] = $row['rank_status'];
            $status_arr['sponsor_tree_status'] = $row['sponsor_tree_status'];
            $status_arr['employee_status'] = $row['employee_status'];
            $status_arr['lang_status'] = $row['lang_status'];
            $status_arr['help_status'] = $row['help_status'];
            $status_arr['statcounter_status'] = $row['statcounter_status'];
            $status_arr['footer_demo_status'] = $row['footer_demo_status'];
            $status_arr['captcha_status'] = $row['captcha_status'];
            $status_arr['sponsor_commission_status'] = $row['sponsor_commission_status'];
        }
        $status = $this->getPaymentTypeStatus();

        $status_arr['credit_card'] = $status;
        return $status_arr;
    }

    public function getPaymentTypeStatus() {

        $status = NULL;
        $this->db->select('status');
        $this->db->where('payment_type', 'Credit Card');
        $this->db->from('payment_methods');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $status = $row['status'];
        }
        return $status;
    }

    public function getTermsConditionsSettings($lang_id = NULL) {
        $TermsConditions = "";
        if ($lang_id != NULL) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $query = $this->db->get('terms_conditions');

        foreach ($query->result() as $row) {
            $TermsConditions = $row->terms_conditions;
        }
        return stripslashes($TermsConditions);
    }

    public function getInfoBoxDetails($lang_id = 1, $type = '') {
        $info_array = '';
        if ($lang_id != NULL) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $this->db->where('info_type', $type);
        $query = $this->db->get('info_box');

        foreach ($query->result() as $row) {
            $info_array = $row->message;
        }
        return stripslashes($info_array);
    }

    public function updateInfoBoxSetting($post) {

        $message = addslashes($post['txtDefaultHtmlArea']);
        $lang_id = $post['lang_id'];
        $info_type = $post['type'];

        $this->db->set('message', $message);
        $this->db->where('lang_ref_id', $lang_id);
        $this->db->where('info_type', $info_type);

        $query = $this->db->update('info_box');
        return $query;
    }

    public function updateTermsConditionsSettings($post) {

        $newone = addslashes($post['txtDefaultHtmlArea1']);
        $lang_id = $post['lang_id'];
        $this->db->set('terms_conditions', $newone);
        if ($lang_id != NULL)
            $this->db->where('lang_ref_id', $lang_id);
        $query = $this->db->update('terms_conditions');
        return $query;
    }

    public function getPinConfig() {
        $arr = NULL;

        $query = $this->db->get('pin_config');

        foreach ($query->result() as $row) {
            $arr['pin_amount'] = $row->pin_amount;
            $arr['pin_length'] = $row->pin_length;
            $arr['pin_type'] = $row->pin_type;
            $arr['pin_maxcount'] = $row->pin_maxcount;
            $arr['pin_character_set'] = $row->pin_character_set;
        }

        return $arr;
    }

    public function setPinConfig($pin_value, $pin_length, $pin_maxcount, $pin_character_set) {
        if ($pin_value != '') {
            $this->db->set('pin_amount', $pin_value);
        }
        $this->db->set('pin_maxcount', $pin_maxcount);
        $this->db->set('pin_length', $pin_length);
        $this->db->set('pin_character_set', $pin_character_set);
        $query = $this->db->update('pin_config');

        return $query;
    }

    public function getUsernameConfig() {

        $query = $this->db->get('username_config');
        foreach ($query->result() as $row) {
            $config['length'] = $row->length;
            $config['prefix_status'] = $row->prefix_status;
            $config['prefix'] = $row->prefix;
            $config['type'] = $row->user_name_type;
        }

        return $config;
    }

    public function setUsernameConfig($length, $prefix_status, $prefix = NULL, $type) {
        $this->db->set('length', $length);
        $this->db->set('prefix_status', $prefix_status);
        $this->db->set('prefix', $prefix);
        $this->db->set('user_name_type', $type);
        $query = $this->db->update('username_config');

        return $query;
    }

    public function setUserNameType($type) {

        $length = 6;
        $prefix_status = 'no';
        $prefix = NULL;
        $this->db->set('length', $length);
        $this->db->set('prefix_status', $prefix_status);
        $this->db->set('prefix', $prefix);
        $this->db->set('user_name_type', $type);
        $query = $this->db->update('username_config');
        return $query;
    }

    public function getUsernamePrefix() {
        $this->db->select('prefix');
        $this->db->from('username_config');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $prefix = $row->prefix;
        }
        return $prefix;
    }

    public function getUserPhoto() {
        $this->db->select('img');
        $this->db->from('photo');
        $this->db->where('id', '1');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->img;
        }
    }

    public function siteConfiguration($nam, $address, $lang, $em, $ph, $thumbnail_logo, $thumbnail_favicon, $lead_url) {

        $this->db->set('company_name', $nam);
        $this->db->set('company_address', $address);
        $this->db->set('default_lang', $lang);
        $this->db->set('logo', $thumbnail_logo);
        $this->db->set('email', $em);
        $this->db->set('phone', $ph);
        $this->db->set('favicon', $thumbnail_favicon);
        $this->db->set('lead_url', $lead_url);
        $this->db->where('id', '1');
        $query = $this->db->update('site_information');

        $this->db->set('logo', $thumbnail_logo);
        $this->db->update('letter_config');

        return $query;
    }

    public function getSiteConfiguration() {
        $this->db->select('*');
        $this->db->from('site_information');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $site_info_arr['co_name'] = $row['company_name'];
            $site_info_arr['company_address'] = htmlspecialchars($row['company_address']);
            $site_info_arr['logo'] = $row['logo'];
            if (!file_exists('public_html/images/logos/' . $row['logo'])) {
                $site_info_arr['logo'] = 'logo_login_page.png';
            }
            $site_info_arr['email'] = $row['email'];
            $site_info_arr['phone'] = $row['phone'];
            $site_info_arr['favicon'] = $row['favicon'];
            if (!file_exists('public_html/images/logos/' . $row['logo'])) {
                $site_info_arr['favicon'] = 'favicon.ico';
            }
            $site_info_arr['default_lang'] = $row['default_lang'];
            $site_info_arr['lead_url'] = $row['lead_url'];
        }
        return $site_info_arr;
    }

    public function getLanguages() {
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $lang[$i]['lang_id'] = $row['lang_id'];
            $lang[$i]['lang_code'] = $row['lang_code'];
            $lang[$i]['lang_name'] = $row['lang_name'];
            $lang[$i]['lang_name_in_english'] = $row['lang_name_in_english'];
            $lang[$i]['status'] = $row['status'];
            $i++;
        }
        return $lang;
    }

    public function updateSiteStatus($status, $content) {
        $this->db->set('site_status', $status);
        $this->db->set('content', $content);

        $query = $this->db->update('configuration');

        return $query;
    }

    public function getMailDetails() {
        $mail_details = array();
        $this->db->select('*');
        $this->db->where('id', 1);
        $this->db->from('mail_settings');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    public function updateMailSettings($mail_setting) {

        $this->db->set('reg_mail_type', $mail_setting['reg_mail_type']);
        $this->db->set('smtp_host', $mail_setting['smtp_host']);
        $this->db->set('smtp_username', $mail_setting['smtp_username']);
        $this->db->set('smtp_password', $mail_setting['smtp_password']);
        $this->db->set('smtp_port', $mail_setting['smtp_port']);
        $this->db->set('smtp_timeout', $mail_setting['smtp_timeout']);
        $this->db->set('smtp_authentication', $mail_setting['smtp_authentication']);
        $this->db->set('smtp_protocol', $mail_setting['smtp_protocol']);
        $this->db->where('id', '1');
        $query = $this->db->update('mail_settings');
        return $query;
    }

    public function insertGeneralMail($post) {
        $main_matter = $post['txtDefaultHtmlArea'];
        $main_matter = strip_tags($main_matter, '<b><p><i><u><h2><h3><ol><li><ul><sub><sup><span><br><hr><a>');
        if (array_key_exists('userfile0', $post) || array_key_exists('userfile1', $post) || array_key_exists('userfile2', $post)) {
            $this->db->set('main_matter', $main_matter);
            if (array_key_exists('userfile0', $post))
                $this->db->set('attach_1', $post['userfile0']);
            if (array_key_exists('userfile1', $post))
                $this->db->set('attach_2', $post['userfile1']);
            if (array_key_exists('userfile2', $post))
                $this->db->set('attach_3', $post['userfile2']);
            $this->db->set('send_from', $post['send_from']);
            $query = $this->db->insert('general_mail_history');
        }
        else {
            $this->db->set('main_matter', $main_matter);
            $this->db->set('send_from', $post['send_from']);
            $query = $this->db->insert('general_mail_history');
        }
        return $query;
    }

    public function getUserEmailList($mail_detilas) {
        $result = array();
        $this->db->select('user_detail_email,user_detail_refid,user_detail_country');
        $this->db->where('user_detail_refid !=', 12345);
        $query = $this->db->get('user_details');

        $i = 0;

        foreach ($query->result_array() as $row) {
            if ($this->checkUser($row['user_detail_refid'])) {
                $result[$i]['email'] = $row['user_detail_email'];
                $result[$i]['id'] = $row['user_detail_refid'];
                $i++;
            }
        }
        return $result;
    }

    public function checkUser($id) {
        $this->db->select('active');
        $this->db->where('id', $id);
        $query = $this->db->get('ft_individual');
        foreach ($query->result_array() as $row) {
            if ($row['active'] != 'terminated') {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function insertRankDetails($rank_name, $ref_count, $rank_bonus) {
        $this->db->set('rank_name', $rank_name);
        $this->db->set('referal_count', $ref_count);
        $this->db->set('rank_bonus', $rank_bonus);
        $this->db->set('rank_status', 'active');
        $query = $this->db->insert('rank_details');
        return $query;
    }

    public function selectRankDetails($edit_id) {

        $this->db->where('rank_id', $edit_id);

        $query = $this->db->get('rank_details');

        foreach ($query->result_array() as $row) {
            $obj_arr['rank_id'] = $row['rank_id'];
            $obj_arr['rank_name'] = $row['rank_name'];
            $obj_arr['referal_count'] = $row['referal_count'];
            $obj_arr['rank_bonus'] = $row['rank_bonus'];
        }
        return $obj_arr;
    }

    public function selectBoardDetails($edit_id) {

        $this->db->where('board_id', $edit_id);

        $query = $this->db->get('board_configuration');

        foreach ($query->result_array() as $row) {
            $obj_arr['board_id'] = $row['board_id'];
            $obj_arr['board_width'] = $row['board_width'];
            $obj_arr['board_depth'] = $row['board_depth'];
            $obj_arr['board_name'] = $row['board_name'];
            $obj_arr['board_commission'] = $row['board_commission'];
            $obj_arr['sponser_follow_status'] = $row['sponser_follow_status'];
            $obj_arr['re_entry_status'] = $row['re_entry_status'];
            $obj_arr['re_entry_to_next_status'] = $row['re_entry_to_next_status'];
        }
        return $obj_arr;
    }

    public function updateRank($rank_id1, $rank_name1, $referal_count1, $rank_bonus) {
        $this->db->set('rank_name', $rank_name1);
        $this->db->set('referal_count', $referal_count1);
        $this->db->set('rank_bonus', $rank_bonus);

        $this->db->where('rank_id', $rank_id1);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function updateBoard($edit_id, $board_width, $board_depth, $board_name, $board_commission, $re_entry_status, $sponser_follow_status, $re_entry_to_next_status) {
        $this->db->set('board_width', $board_width);
        $this->db->set('board_depth', $board_depth);
        $this->db->set('board_name', $board_name);
        $this->db->set('board_commission', $board_commission);
        $this->db->set('re_entry_status', $re_entry_status);
        $this->db->set('sponser_follow_status', $sponser_follow_status);
        $this->db->set('re_entry_to_next_status', $re_entry_to_next_status);
        $this->db->where('board_id', $edit_id);
        $query = $this->db->update('board_configuration');
        return $query;
    }

    public function inactivate_rank($rank_id) {
        $this->db->set('rank_status', 'inactive');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function activate_rank($rank_id) {
        $this->db->set('rank_status', 'active');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->update('rank_details');
        return $query;
    }

    public function getMailHistory() {

        $arr = array();
        $query = $this->db->get('general_mail_history');
        $i = 0;
        foreach ($query->result() as $row) {
            $arr[$i]['id'] = $row->id;
            $arr[$i]['sent_from'] = $row->send_from;
            $arr[$i]['main_matter'] = $row->main_matter;
            $arr[$i]['logo'] = $row->attach_1;
            $arr[$i]['logo_1'] = $row->attach_2;
            $arr[$i]['logo_2'] = $row->attach_3;
            $i++;
        }

        return $arr;
    }

    public function getActiveRankDetails($rank_id = NULL) {
        $arr = array();
        if ($rank_id != NULL) {
            $this->db->where('rank_id', $rank_id);
        }
        $this->db->where('rank_status', 'active');
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get('rank_details');
        foreach ($query->result_array() as $row) {
            $arr[] = $row;
        }

        return $arr;
    }

    public function getAllRankDetails($rank_id = NULL) {
        $arr = array();
        if ($rank_id != NULL) {
            $this->db->where('rank_id', $rank_id);
        }
        $this->db->where('delete_status', 'yes');
        $query = $this->db->get('rank_details');
        foreach ($query->result_array() as $row) {
            $arr[] = $row;
        }

        return $arr;
    }

    public function getAllBoardDetails() {
        $arr = array();
        $query = $this->db->get('board_configuration');
        $i = 0;
        foreach ($query->result() as $row) {
            $arr[$i]['board_id'] = $row->board_id;
            $arr[$i]['board_width'] = $row->board_width;
            $arr[$i]['board_depth'] = $row->board_depth;
            $arr[$i]['board_name'] = $row->board_name;
            $arr[$i]['board_commission'] = $row->board_commission;
            $arr[$i]['sponser_follow_status'] = $row->sponser_follow_status;
            $arr[$i]['re_entry_status'] = $row->re_entry_status;
            $arr[$i]['re_entry_to_next_status'] = $row->re_entry_to_next_status;

            $i++;
        }

        return $arr;
    }

    public function deleteMessage($id) {
        $query = $this->db->delete('mail_history', array('id' => $id));
        return $query;
    }

    public function setSmsConfig($details) {

        $this->db->set('sender_id', $details['sender_id']);
        $this->db->set('username', $details['user_name']);
        $this->db->set('password', $details['password']);
        $query = $this->db->insert('sms_config');
        return $query;
    }

    public function getSmsConfigDetails() {

        $details = array();
        $this->db->select('sender_id,username,password');
        $this->db->from('sms_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $details['sender_id'] = $row->sender_id;
            $details['username'] = $row->username;
            $details['password'] = $row->password;
        }
        return $details;
    }

    public function updatePaypalConfig($api_username, $api_password, $api_signature, $mode, $currency, $return_url, $cancel_url) {
        $this->db->select('id');
        $this->db->from('paypal_config');
        $query = $this->db->get();
        $data = array(
            'api_username' => $api_username,
            'api_password' => $api_password,
            'api_signature' => $api_signature,
            'mode' => $mode,
            'currency' => $currency,
            'return_url' => $return_url,
            'cancel_url' => $cancel_url
        );
        if ($query->num_rows()) {
            $query = $this->db->update('paypal_config', $data);
        } else {
            $query = $this->db->insert('paypal_config', $data);
        }
        return $query;
    }

    public function getPaypalConfigDetails() {

        $this->db->select('*');
        $this->db->from('paypal_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['api_username'] = $row->api_username;
            $details['api_password'] = $row->api_password;
            $details['api_signature'] = $row->api_signature;
            $details['mode'] = $row->mode;
            $details['currency'] = $row->currency;
            $details['return_url'] = $row->return_url;
            $details['cancel_url'] = $row->cancel_url;
        }
        if ($query->num_rows()) {
            return $details;
        }
    }

    public function getPaymentMethods() {

        $this->db->select('*');
        $this->db->from('payment_methods');
        $query = $this->db->get();
        $details = array();
        $i = 0;

        foreach ($query->result() as $row) {
            $details[$i]['id'] = $row->id;
            $details[$i]['payment_type'] = $row->payment_type;
            $details[$i]['status'] = $row->status;
            $i++;
        }
        return $details;
    }

    public function setPaymentStatus($id, $status) {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_methods');
        if ($id == 1 && $status == 'no') {
            $this->setGatewayStatusFalse();
        }
        return $query;
    }

    public function checkAtleastOnePaymentActive($id) {
        $this->db->select('status');
        $this->db->where('id !=', $id);
        $this->db->where('status', 'yes');
        $this->db->from('payment_methods');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function checkAtleastOneCreditCardActive($id) {
        $this->db->select('status');
        $this->db->where('id !=', $id);
        $this->db->where('status', 'yes');
        $this->db->from('payment_gateway_config');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getLevelSettings() {
        $arr_comm = array();
        $this->db->select('*');
        $this->db->from('level_commision');
        $query = $this->db->get();
        $l = 0;
        foreach ($query->result_array() as $row) {
            $arr_comm[$l] = $row['level_percentage'];
            $l++;
        }
        return $arr_comm;
    }

    public function getEpdqConfigDetails() {

        $this->db->select('*');
        $this->db->from('epdq_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['api_pspid'] = $row->api_pspid;
            $details['api_password'] = $row->api_password;
            $details['api_language'] = $row->api_language;
            $details['api_currency'] = $row->api_currency;
            $details['accept_url'] = $row->accept_url;
            $details['decline_url'] = $row->decline_url;
            $details['exception_url'] = $row->exception_url;
            $details['cancel_url'] = $row->cancel_url;
            $details['api_url'] = $row->api_url;
        }
        if ($query->num_rows()) {
            return $details;
        }
    }

    public function updateEpdqConfig($api_pspid, $api_password, $language, $currency, $accept_url, $decline_url, $exception_url, $cancel_url, $api_url) {
        $this->db->select('id');
        $this->db->from('paypal_config');
        $query = $this->db->get();
        $data = array(
            'api_pspid' => $api_pspid,
            'api_language' => $language,
            'api_currency' => $currency,
            'accept_url' => $accept_url,
            'decline_url' => $decline_url,
            'exception_url' => $exception_url,
            'cancel_url' => $cancel_url,
            'api_password' => $api_password,
            'api_url' => $api_url
        );
        if ($query->num_rows()) {
            $query = $this->db->update('epdq_config', $data);
        } else {
            $query = $this->db->insert('epdq_config', $data);
        }
        return $query;
    }

    public function setGatewayStatusFalse() {
        $this->db->set('status', 'no');
        return $this->db->update('payment_gateway_config');
    }

    public function getAuthorizeConfigDetails() {
        $details = array();
        $this->db->select('*');
        $this->db->from('authorize_config');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $details['merchant_id'] = $row->merchant_id;
            $details['transaction_key'] = $row->transaction_key;
        }
        return $details;
    }

    public function updateAuthorizeConfig($merchant_id, $transaction_key) {

        $data = array(
            'merchant_id' => $merchant_id,
            'transaction_key' => $transaction_key,
        );
        $query = $this->db->update('authorize_config', $data);
        return $query;
    }

    public function getLanguageStatus() {
        $language_array = array();
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $language_array[] = $row;
        }
        return $language_array;
    }

    function getEmailManagementContent($mail_type, $lang_id = '') {
        $mail = array();
        $this->db->select('*')
                ->from('common_mail_settings')
                ->where('mail_type', $mail_type);
        if ($lang_id != '') {
            $this->db->where('lang_id', $lang_id);
        }
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            $mail['content'] = $row->mail_content;
            $mail['subject'] = $row->subject;
            $mail['mail_status'] = $row->mail_status;
        }
        return $mail;
    }

    function updateEmailManagement($arr, $mail_type = '', $lang_id = '') {
        $this->db->trans_begin();
        $data = array(
            'mail_status' => $arr['mail_status'],
            'date' => date('Y-m-d h:i:s')
        );
        $this->db->where('mail_type', $mail_type);
        $this->db->update('common_mail_settings', $data);

        $data = array(
            'subject' => $arr['subject'],
            'mail_content' => $arr['mail_content'],
        );
        if ($lang_id != '') {
            $this->db->where('lang_id', $lang_id);
        }

        $this->db->where('mail_type', $mail_type);
        $this->db->update('common_mail_settings', $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return true;
    }

    public function getAutoResponderData($mail_id = '') {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('autoresponder_setting');
        if ($mail_id) {
            $this->db->where('mail_id', $mail_id);
        } else {
            $this->db->limit(1);
        }
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }

        return $mail_details;
    }

    public function getAuto() {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('autoresponder_setting');
        $this->db->order_by('mail_id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $mail_details[$i]['mail_id'] = $row['mail_id'];
            $mail_details[$i]['subject'] = $row['subject'];
            $mail_details[$i]['content'] = $row['content'];
            $mail_details[$i]['date_to_send'] = $row['date_to_send'];
            $i++;
        }
        return $mail_details;
    }

    function insertIntoAutoResponder($settings) {
        $this->db->select('mail_id');
        $this->db->from('autoresponder_setting');
        $this->db->where('mail_id', $settings['mail_number']);

        $count = $this->db->count_all_results();

        if (!$count) {
            $data = array(
                'subject' => $settings['subject'],
                'content' => $settings['mail_content'],
                'mail_id' => $settings['mail_number'],
                'date_to_send' => $settings['date_to_send'],
                'date' => date("Y-m-d H:i:s")
            );
            $res = $this->db->insert('autoresponder_setting', $data);
        } else {

            $this->db->set('subject', $settings['subject']);
            $this->db->set('content', $settings['mail_content']);
            $this->db->set('mail_id', $settings['mail_number']);
            $this->db->set('date_to_send', $settings['date_to_send']);
            $this->db->where('mail_id', $settings['mail_number']);
            $res = $this->db->update('autoresponder_setting');
        }
        return $res;
    }

    public function DeleteAutoResponderData($mail_id) {
        $this->db->where('mail_id', $mail_id);
        return $this->db->delete('autoresponder_setting');
    }

    public function updateSortOrder($id, $order) {
        $this->db->set('sort_order', $order);
        $this->db->where('id', $id);
        $query = $this->db->update('payment_gateway_config');
    }

    public function getBoardViewConfig() {

        $board_config = array();
        $i = 0;
        $this->db->from('board_configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $board_config[$i]['board_id'] = $row->board_id;
            $board_config[$i]['board_name'] = $row->board_name;
            $board_config[$i]['board_depth'] = $row->board_depth;
            $board_config[$i]['board_width'] = $row->board_width;
            $board_config[$i]['amount'] = $row->amount;
            $i++;
        }
        return $board_config;
    }

    public function updateBoardConfig($i, $depth, $width, $amount) {
        $this->db->set('board_width', $width);
        $this->db->set('board_depth', $depth);
        $this->db->set('amount', $amount);
        $this->db->where('board_id', $i);
        return $this->db->update('board_configuration');
    }

    public function delete_rank($rank_id) {
        $this->db->set('delete_status', 'no');
        $this->db->set('rank_status', 'inactive');
        $this->db->where('rank_id', $rank_id);
        $result = $this->db->update('rank_details');
        return $result;
    }

    public function updateThemeFolder($admin_folder, $user_folder) {
        $this->db->set('admin_theme_folder', $admin_folder);
        $this->db->set('user_theme_folder', $user_folder);
        $res = $this->db->update('site_information');
        if ($res) {
            $this->admin_theme_folder = $admin_folder;
            return $res;
        }
    }

    public function getThemeFolder() {
        $this->db->select('admin_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $data = $row->admin_theme_folder;
        }
        return $data;
    }

    public function getUserThemeFolder() {
        $this->db->select('user_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $user_data = $row->user_theme_folder;
        }
        return $user_data;
    }

    public function updatePlanSettings($post_array, $module_status, $board_count = '0') {
        $settings_array = array();
        $board_settings_array = array();
        if ($this->MLM_PLAN == "Binary") {
            $settings_array['pair_ceiling_type'] = $post_array['pair_ceiling_type'];
            if ($post_array['pair_ceiling_type'] != 'none') {
                $settings_array['pair_ceiling'] = $post_array['pair_ceiling'];
            }
            $settings_array['pair_value'] = $post_array['pair_value'];
            $settings_array['product_point_value'] = $post_array['product_point_value'];
            if ($module_status['sponsor_commission_status'] == "yes") {
                $settings_array['depth_ceiling'] = $post_array['depth_ceiling'];
            }
        } else if ($this->MLM_PLAN == "Board") {
            if ($module_status['sponsor_commission_status'] == "yes") {
                $settings_array['depth_ceiling'] = $post_array['depth_ceiling'];
            }
            $reentry_flag = FALSE;
            for ($i = 0; $i < $board_count; $i++) {
                $board_settings_array[$i]["board_width"] = $post_array["board" . $i . "_width"];
                $board_settings_array[$i]["board_depth"] = $post_array["board" . $i . "_depth"];
                $board_settings_array[$i]["board_name"] = $post_array["board" . $i . "_name"];
                $board_settings_array[$i]["sponser_follow_status"] = $post_array["board" . $i . "_sponsor_follow_status"];
                $board_settings_array[$i]["re_entry_status"] = $post_array["board" . $i . "_reentry_status"];
                $board_settings_array[$i]["re_entry_to_next_status"] = ($reentry_flag) ? "no" : $post_array["board" . $i . "_reentry_to_next_status"];
                if ($board_settings_array[$i]["re_entry_to_next_status"] == "no") {
                    $reentry_flag = TRUE;
                }
            }
        } else if ($this->MLM_PLAN == "Unilevel") {
            $settings_array['depth_ceiling'] = $post_array['depth_ceiling'];
        } else if ($this->MLM_PLAN == "Matrix") {
            $settings_array['depth_ceiling'] = $post_array['depth_ceiling'];
            $settings_array['width_ceiling'] = $post_array['width_ceiling'];
        }

        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $module_status['sponsor_commission_status'] == 'yes') {
            $settings_array['depth_ceiling'] = $post_array['depth_ceiling'];
        }

        if ($settings_array) {
            $query = $this->db->update('configuration', $settings_array);
        }

        if ($board_settings_array) {
            $query = $result_level = $this->configuration_model->updatBoardSettings($board_settings_array, $board_count);
        }

        return $query;
    }


}
