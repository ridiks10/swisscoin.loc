<?php

class excel_model extends inf_model {

    private $obj_xml;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        require_once 'excel/class-excel-xml.inc.php';
        $this->obj_xml = new Excel_XML();
        $this->load->model('payout_model');
        $this->load->model('report_model');
        $this->load->model('select_report_model');
    }

    public function writeToExcel($doc_arr, $file_name) 
    {
        $this->obj_xml->addArray($doc_arr);
        $this->obj_xml->generateXML("$file_name");
    }

    public function getUserArray($from, $to) {
        $excel_array = array();
        $details_arr = $this->payout_model->getPayoutUserDetails($from, $to);
        $detail_count = count($details_arr);
        $excel_array[1] = array(lang('user_name'), lang('name'), lang('address'), lang('mobile'), lang('amount_payable'), lang('bank'), lang('branch'), lang('account_no'), lang('ifsc'));
        for ($i = 2; $i <= $detail_count + 1; $i++) {
            $excel_array[$i][0] = $details_arr[$i - 2]["user_name"];
            $excel_array[$i][1] = $details_arr[$i - 2]["name"];
            $excel_array[$i][2] = $details_arr[$i - 2]["address"];
            $excel_array[$i][3] = $details_arr[$i - 2]["mobile"];
            $excel_array[$i][4] = $details_arr[$i - 2]["amount_payable"];
            $excel_array[$i][5] = $details_arr[$i - 2]["bank"];
            $excel_array[$i][6] = $details_arr[$i - 2]["branch"];
            $excel_array[$i][7] = $details_arr[$i - 2]["acc"];
            $excel_array[$i][8] = $details_arr[$i - 2]["ifsc"];
        }
        return $excel_array;
    }

    public function getProfiles($cnt) {
        $excel_array = array();
        $details_arr = $this->report_model->profileReport($cnt);
        $detail_count = count($details_arr);
        $excel_array[1] = array(lang('name'), lang('user_name'),
lang('sponsor_name'), lang('address'), lang('pin_code'),
lang('mobile'), lang('land_line'), lang('email'), lang('nominee'),
lang('relationship'), lang('bank'), lang('branch'),
lang('account_no'),  lang('ifsc'),
lang('date_of_joining'));
        for ($i = 2; $i <= $detail_count + 1; $i++) {
            $excel_array[$i][0] = $details_arr[$i - 2]["user_detail_name"];
            $excel_array[$i][1] = $details_arr[$i - 2]['uname'];
            $excel_array[$i][2] = $details_arr[$i - 2]['sponser_name'];
            $excel_array[$i][3] = $details_arr[$i - 2]["user_detail_address"];
            $excel_array[$i][4] = $details_arr[$i - 2]["user_detail_pin"];
            $excel_array[$i][5] = $details_arr[$i - 2]["user_detail_mobile"];
            $excel_array[$i][6] = $details_arr[$i - 2]["user_detail_land"];
            $excel_array[$i][7] = $details_arr[$i - 2]["user_detail_email"];
            $excel_array[$i][8] = $details_arr[$i - 2]["user_detail_nominee"];
            $excel_array[$i][9] = $details_arr[$i - 2]["user_detail_relation"];
            $excel_array[$i][10] = $details_arr[$i - 2]["user_detail_nbank"];
            $excel_array[$i][11] = $details_arr[$i - 2]["user_detail_nbranch"];
            $excel_array[$i][12] = $details_arr[$i - 2]["user_detail_acnumber"];
//            $excel_array[$i][13] = $details_arr[$i - 2]["user_detail_pan"];
            $excel_array[$i][13] = $details_arr[$i - 2]["user_detail_ifsc"];
            $excel_array[$i][14] = $details_arr[$i - 2]["join_date"];
        }
        return $excel_array;
    }

    public function getProfilesFrom($count_from, $count_to) {
        $excel_array = array();
        $details_arr = $this->report_model->profileReportFromTo($count_to, $count_from);
        $detail_count = count($details_arr);
        $excel_array[1] = array(lang('name'), lang('user_name'), lang('sponsor_name'), lang('address'), lang('pin_code'), lang('mobile'), lang('land_line'), lang('email'), lang('nominee'), lang('relationship'), lang('bank'), lang('branch'), lang('account_no'),  lang('ifsc'), lang('date_of_joining'));
        for ($i = 2; $i <= $detail_count + 1; $i++) {
            $excel_array[$i][0] = $details_arr[$i - 2]["user_detail_name"];
            $excel_array[$i][1] = $details_arr[$i - 2]['uname'];
            $excel_array[$i][2] = $details_arr[$i - 2]['sponser_name'];
            $excel_array[$i][3] = $details_arr[$i - 2]["user_detail_address"];
            $excel_array[$i][4] = $details_arr[$i - 2]["user_detail_pin"];
            $excel_array[$i][5] = $details_arr[$i - 2]["user_detail_mobile"];
            $excel_array[$i][6] = $details_arr[$i - 2]["user_detail_land"];
            $excel_array[$i][7] = $details_arr[$i - 2]["user_detail_email"];
            $excel_array[$i][8] = $details_arr[$i - 2]["user_detail_nominee"];
            $excel_array[$i][9] = $details_arr[$i - 2]["user_detail_relation"];
            $excel_array[$i][10] = $details_arr[$i - 2]["user_detail_nbank"];
            $excel_array[$i][11] = $details_arr[$i - 2]["user_detail_nbranch"];
            $excel_array[$i][12] = $details_arr[$i - 2]["user_detail_acnumber"];
//            $excel_array[$i][13] = $details_arr[$i - 2]["user_detail_pan"];
            $excel_array[$i][13] = $details_arr[$i - 2]["user_detail_ifsc"];
            $excel_array[$i][14] = $details_arr[$i - 2]["join_date"];
        }
        return $excel_array;
    }

    public function getJoiningReportDaily($date) {
        $joinings_arr = $this->report_model->getTodaysJoining($date);
        $count = count($joinings_arr);
        $excel_array[1] = array(lang('user_name'), lang('name'), lang('upline_name'), lang('sponsor_name'), lang('status'), lang('date_of_joining'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $joinings_arr["detail$j"]["user_name"];
            $excel_array[$i][1] = $joinings_arr["detail$j"]["user_full_name"];
            $excel_array[$i][2] = $joinings_arr["detail$j"]["father_user"];
            $excel_array[$i][3] = $joinings_arr["detail$j"]["sponsor_name"];
            if($joinings_arr["detail$j"]['active'] == 'yes') {
                $excel_array[$i][4] = 'Active';
            } else {
                $excel_array[$i][4] = 'Blocked';
            }
            $excel_array[$i][5] = $joinings_arr["detail$j"]["date_of_joining"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getJoiningReportWeekly($from_date, $to_date) {
        $joinings_arr = $this->report_model->getWeeklyJoining($from_date, $to_date);
        $count = count($joinings_arr);
        $excel_array[1] = array(lang('user_name'), lang('name'), lang('upline_name'), lang('sponsor_name'), lang('status'), lang('date_of_joining'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $joinings_arr["detail$j"]["user_name"];
            $excel_array[$i][1] = $joinings_arr["detail$j"]["user_full_name"];
            $excel_array[$i][2] = $joinings_arr["detail$j"]["father_user"];
            $excel_array[$i][3] = $joinings_arr["detail$j"]["sponsor_name"];
            if($joinings_arr["detail$j"]['active'] == 'yes') {
                $excel_array[$i][4] = 'Active';
            } else {
                $excel_array[$i][4] = 'Blocked';
            }
            $excel_array[$i][5] = $joinings_arr["detail$j"]["date_of_joining"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getTotalPayoutReport($from_date = '', $to_date = '') {
        if($from_date == '' && $to_date == '') {
            $total_payout_array = $this->report_model->getTotalPayout();
        } else {
            $total_payout_array = $this->report_model->getTotalPayout($from_date, $to_date);
        }
        $count = count($total_payout_array);
        $excel_array[1] = array(lang('user_full_name'), lang('user_name'), lang('address'), lang('bank'), lang('account_no'), lang('total_amount'), lang('tds'), lang('service_charge'), lang('amount_payable'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $total_payout_array["detail$j"]["full_name"];
            $excel_array[$i][1] = $total_payout_array["detail$j"]["user_name"];
            $excel_array[$i][2] = $total_payout_array["detail$j"]["user_address"];
            $excel_array[$i][3] = $total_payout_array["detail$j"]["user_bank"];
            $excel_array[$i][4] = $total_payout_array["detail$j"]["acc_number"];
            $excel_array[$i][5] = $total_payout_array["detail$j"]["total_amount"];
            $excel_array[$i][6] = $total_payout_array["detail$j"]["tds"];
            $excel_array[$i][7] = $total_payout_array["detail$j"]["service_charge"];
            $excel_array[$i][8] = $total_payout_array["detail$j"]["amount_payable"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getRankAchieversReport($from_date, $to_date, $ranks) {
        $ranked_users_array = $this->report_model->rankedUsers($ranks, $from_date, $to_date);
        $count = count($ranked_users_array);
        $excel_array[1] = array(lang('new_rank'), lang('user_name'), lang('user_full_name'), lang('rank_achieved_date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $ranked_users_array[$i - 2]["rank_name"];
            $excel_array[$i][1] = $ranked_users_array[$i - 2]["user_name"];
            $excel_array[$i][2] = $ranked_users_array[$i - 2]["user_detail_name"];
            $excel_array[$i][3] = $ranked_users_array[$i - 2]["date"];            
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getCommissionReport($from_date, $to_date, $type) {
        $commission_details_array = $this->report_model->getCommisionDetails($type, $from_date, $to_date);
        $count = count($commission_details_array);
        $excel_array[1] = array(lang('user_name'), lang('user_full_name'), lang('amount_type'), lang('date'), lang('total_amount'), lang('amount_payable'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $commission_details_array[$i - 2]["user_name"];
            $excel_array[$i][1] = $commission_details_array[$i - 2]["full_name"];
            $excel_array[$i][2] = $commission_details_array[$i - 2]["amount_type"];
            $excel_array[$i][3] = $commission_details_array[$i - 2]["date"];            
            $excel_array[$i][4] = $commission_details_array[$i - 2]["total_amount"];
            $excel_array[$i][5] = $commission_details_array[$i - 2]["amount_payable"];
            
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
        
    }
    
    public function getEpinReport() {
        $epin_details_array = $this->report_model->getUsedPin();
        $count = count($epin_details_array);
        $excel_array[1] = array(lang('used_user'), lang('epin'), lang('epin_uploaded_date'), lang('epin_amount'), lang('epin_balance_amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $epin_details_array[$i - 2]["used_user"];
            $excel_array[$i][1] = $epin_details_array[$i - 2]["pin_number"];
            $excel_array[$i][2] = $epin_details_array[$i - 2]["pin_alloc_date"];
            $excel_array[$i][3] = $epin_details_array[$i - 2]["pin_amount"];            
            $excel_array[$i][4] = $epin_details_array[$i - 2]["pin_balance_amount"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getTopEarnersReport() {
        $top_earners_array = $this->select_report_model->getTopEarners();
        $count = count($top_earners_array);
        $excel_array[1] = array(lang('user_full_name'), lang('user_name'), lang('current_balance'), lang('total_earnings'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $top_earners_array["details$j"]["name"];
            $excel_array[$i][1] = $top_earners_array["details$j"]["user_name"];
            $excel_array[$i][2] = $top_earners_array["details$j"]["current_balance"];
            $excel_array[$i][3] = $top_earners_array["details$j"]["total_earnings"];            
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getProfileViewReport($user_name) {
        $profile_details_array = $this->report_model->getProfileDetails($user_name);
        $excel_array[1][0] = lang('user_full_name');
        $excel_array[1][1] = $profile_details_array["details"][0]['user_detail_name'];
        
//        $excel_array[2][0] = lang('epin');
//        $excel_array[2][1] = $profile_details_array["details"][0]['user_detail_pin'];
        
        $excel_array[2][0] = lang('user_name');
        $excel_array[2][1] = $user_name;
        
        $excel_array[3][0] = lang('sponsor_name');
        $excel_array[3][1] = $profile_details_array["sponser"]['name'];
        
        $excel_array[4][0] = lang('address');
        $excel_array[4][1] = $profile_details_array["details"][0]['user_detail_address'];
        
        $excel_array[5][0] = lang('pin_code');
        $excel_array[5][1] = $profile_details_array["details"][0]['user_detail_pin'];
        
        $excel_array[6][0] = lang('country');
        $excel_array[6][1] = $profile_details_array["details"][0]['user_detail_country'];
        
        $excel_array[7][0] = lang('state');
        $excel_array[7][1] = $profile_details_array["details"][0]['user_detail_state'];
        
        $excel_array[8][0] = lang('mobile');
        $excel_array[8][1] = $profile_details_array["details"][0]['user_detail_mobile'];
        
        $excel_array[9][0] = lang('land_line');
        $excel_array[9][1] = $profile_details_array["details"][0]['user_detail_land'];
        
        $excel_array[10][0] = lang('gender');
        $excel_array[10][1] = $profile_details_array["details"][0]['user_detail_gender'];
        
        $excel_array[11][0] = lang('email');
        $excel_array[11][1] = $profile_details_array["details"][0]['user_detail_email'];
        
        $excel_array[12][0] = lang('date_of_birth');
        $excel_array[12][1] = $profile_details_array["details"][0]['user_detail_dob'];
        
        
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getSalesReport($from_date, $to_date) {
        $sales_report_array = $this->report_model->salesReport($from_date, $to_date);
        $count = count($sales_report_array);
        $excel_array[1] = array(lang('invoice_no'), lang('prod_name'), lang('user_name'), lang('payment_method'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $sales_report_array[$i - 2]["invoice_no"];
            $excel_array[$i][1] = $sales_report_array[$i - 2]["prod_id"];
            $excel_array[$i][2] = $sales_report_array[$i - 2]["user_id"];
            $excel_array[$i][3] = $sales_report_array[$i - 2]["payment_method"];
            $excel_array[$i][4] = $sales_report_array[$i - 2]["amount"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function productSalesReport($prod_id) {
        $sales_report_array = $this->report_model->productSalesReport($prod_id);
        $count = count($sales_report_array);
        $excel_array[1] = array(lang('invoice_no'), lang('prod_name'), lang('user_name'), lang('payment_method'), lang('amount'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $excel_array[$i][0] = $sales_report_array[$i - 2]["invoice_no"];
            $excel_array[$i][1] = $sales_report_array[$i - 2]["prod_id"];
            $excel_array[$i][2] = $sales_report_array[$i - 2]["user_id"];
            $excel_array[$i][3] = $sales_report_array[$i - 2]["payment_method"];
            $excel_array[$i][4] = $sales_report_array[$i - 2]["amount"];
        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
    public function getMemberPayoutReport($user_name) {
        $member_payout_array = $this->report_model->getMemberPayout($user_name);
        $excel_array[1][0] = lang('user_name');
        $excel_array[1][1] = $member_payout_array['user_name'];
        
        $excel_array[2][0] = lang('user_full_name');
        $excel_array[2][1] = $member_payout_array['full_name'];
        
        $excel_array[3][0] = lang('address');
        $excel_array[3][1] = $member_payout_array['user_address'];
        
        $excel_array[4][0] = lang('bank');
        $excel_array[4][1] = $member_payout_array['user_bank'];
        
        $excel_array[5][0] = lang('account_no');
        $excel_array[5][1] = $member_payout_array['acc_number'];
        
        $excel_array[6][0] = lang('total_amount');
        $excel_array[6][1] = $member_payout_array['total_amount'];
        
        $excel_array[7][0] = lang('tds');
        $excel_array[7][1] = $member_payout_array['tds'];
        
        $excel_array[8][0] = lang('service_charge');
        $excel_array[8][1] = $member_payout_array['service_charge'];
        
        $excel_array[9][0] = lang('amount_payable');
        $excel_array[9][1] = $member_payout_array['amount_payable'];
        
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
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
    
    
       public function getActiveInactiveReport($from_date, $to_date) {
        $active_deactive_arr = $this->report_model->getAciveDeactiveUserDetails($from_date, $to_date);
        $count = count($active_deactive_arr);
        $excel_array[1] = array(lang('user_name'), lang('user_full_name'), lang('status'), lang('active_deactive_date'));
        for ($i = 2; $i <= $count + 1; $i++) {
            $j = $i - 2;
            $excel_array[$i][0] = $active_deactive_arr["$j"]["user_name"];
            $excel_array[$i][1] = $active_deactive_arr["$j"]["full_name"];
            $excel_array[$i][2] = $active_deactive_arr["$j"]["status"];
            $excel_array[$i][3] = $active_deactive_arr["$j"]["date"];

        }
        $excel_array = $this->replaceNullFromArray($excel_array);
        return $excel_array;
    }
    
}