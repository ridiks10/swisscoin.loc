<?php

require_once 'Inf_Controller.php';

/**
 * @property-read report_model $report_model 
 */
class Report extends Inf_Controller {

    function profile_report_view() {

        $title = $this->lang->line('select_user');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->ARR_SCRIPT[0]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        $this->load_langauge_scripts();

        if ($this->input->post('profile_update')) {
            $user_name = strip_tags($this->input->post('user_name'));
            $profile_arr = $this->report_model->includereport($user_name);
            $user_id = $this->report_model->userNameToID($user_name);
            $this->set("details", $profile_arr['details']);
            $this->set("sponser", $profile_arr['sponser']);
            $this->set("user_id", $user_id);
            $this->set("u_name", $user_name);
        } else {
            //User
            $user_name = strip_tags($this->input->post('user_name'));
            if ($user_name != '') {
                $profile_arr = $this->report_model->includereport($user_name);
                $user_id = $this->report_model->userNameToID($user_name);

                $this->set("details", $profile_arr['details']);
                $this->set("sponser", $profile_arr['sponser']);
                $this->set("user_id", $profile_arr['user_id']);
                $this->set("u_name", $user_name);
            }
        }

        ////////////////////////////////for language traslation///////////////////////////
        ////////////////////FOR REPORT_TAB
        $this->set("tran_profile_report", $this->lang->line('profile_report'));
        $this->set("tran_joining_report", $this->lang->line('joining_report'));
        $this->set("tran_total_payout_report", $this->lang->line('total_payout_report'));
        $this->set("tran_bank_statement", $this->lang->line('bank_statement'));
        $this->set("tran_payout_release_report", $this->lang->line('payout_release_report'));
        //////////////////////////////////////////////////////////////////////////////
        $this->set("tran_name", $this->lang->line('name'));
        $this->set("tran_epin", $this->lang->line('epin'));
        $this->set("tran_user_name", $this->lang->line('user_name'));
        $this->set("tran_sponser_name", $this->lang->line('sponser_name'));
        $this->set("tran_sponser_id", $this->lang->line('sponser_id'));
        $this->set("tran_resident", $this->lang->line('resident'));
        $this->set("tran_post_office", $this->lang->line('post_office'));
        $this->set("tran_pincode", $this->lang->line('pincode'));
        $this->set("tran_town", $this->lang->line('town'));
        $this->set("tran_state", $this->lang->line('state'));
        $this->set("tran_mobile_no", $this->lang->line('mobile_no'));
        $this->set("tran_land_line_no", $this->lang->line('land_line_no'));
        $this->set("tran_email", $this->lang->line('email'));
        $this->set("tran_date_of_birth", $this->lang->line('date_of_birth'));
        $this->set("tran_blood_group", $this->lang->line('blood_group'));
        $this->set("tran_marital_status", $this->lang->line('marital_status'));
        $this->set("tran_occupation", $this->lang->line('occupation'));
        $this->set("tran_gender", $this->lang->line('gender'));
        $this->set("tran_nominee", $this->lang->line('nominee'));
        $this->set("tran_relationship", $this->lang->line('relationship'));
        $this->set("tran_male", $this->lang->line('male'));
        $this->set("tran_female", $this->lang->line('female'));
        //////////////////////////language ends/////////////////////////////////////

        $this->setView();
    }

    public function profile_report() {
        $this->ARR_SCRIPT[0]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        $this->load_langauge_scripts();

        ////////////////////FOR PRODUCT_TAB
        $this->set("tran_profile_report", $this->lang->line('profile_report'));
        $this->set("tran_joining_report", $this->lang->line('joining_report'));
        $this->set("tran_total_payout_report", $this->lang->line('total_payout_report'));
        $this->set("tran_bank_statement", $this->lang->line('bank_statement'));
        $this->set("tran_payout_release_report", $this->lang->line('payout_release_report'));
        ////////////////////////////////////////////////////////////////////////////////
        $this->set("tran_create_excel", $this->lang->line('create_excel'));
        $this->set("tran_no", $this->lang->line('no'));
        $this->set("tran_bank", $this->lang->line('bank'));
        $this->set("tran_branch", $this->lang->line('branch'));
        $this->set("tran_acc_no", $this->lang->line('acc_no'));
        $this->set("tran_pan_no", $this->lang->line('pan_no'));
        $this->set("tran_ifsc", $this->lang->line('ifsc'));
        $this->set("tran_date_of_joining", $this->lang->line('date_of_joining'));
        $this->set("tran_name", $this->lang->line('name'));
        $this->set("tran_epin", $this->lang->line('epin'));
        $this->set("tran_user_name", $this->lang->line('user_name'));
        $this->set("tran_sponser_name", $this->lang->line('sponser_name'));
        $this->set("tran_sponser_id", $this->lang->line('sponser_id'));
        $this->set("tran_resident", $this->lang->line('resident'));
        $this->set("tran_mobile_no", $this->lang->line('mobile_no'));
        $this->set("tran_land_line_no", $this->lang->line('land_line_no'));
        $this->set("tran_email", $this->lang->line('email'));
        $this->set("tran_nominee", $this->lang->line('nominee'));
        $this->set("tran_relationship", $this->lang->line('relationship'));
        $this->set("tran_pincode", $this->lang->line('pincode'));

        if ($this->input->post('profile')) {
            $count = strip_tags($this->input->post('count'));
            
            $profile_arr = $this->report_model->profileReport($count);
            $this->set("profile_arr", $profile_arr);
            $this->set("count", count($profile_arr));
        }

        if ($this->input->post('profile_from')) {

            $count_from = strip_tags($this->input->post('count_from'));
            $count_to = strip_tags($this->input->post('count_to'));

            $profile_arr = $this->report_model->profileReport($count_to - $count_from, $count_from - 1);
            $this->set("profile_arr", $profile_arr);
            $this->set("count", count($profile_arr));
        }
        $this->setView();
    }

    function total_joining_daily() {
        $this->load->model('joining_class_model');
        
        $todays_join = $this->joining_class_model->getJoinings($this->input->post('date'));
        $this->set("count", count($todays_join));
        $this->set("todays_join", $todays_join);
        $this->setView();
    }


    function bank_statement() {
        $count = "";
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == "admin") {
            if ($this->input->post('bank_stmnt')) {
                $user_name = strip_tags($this->input->post('user_name'));
            } else {
                $user_name = $this->LOG_USER_NAME;
            }
            $bank_stmt_arr = $this->report_model->getBankStatement($user_name);
        }
        $date = date("Y-m-d");
        $count = count($bank_stmt_arr['member_payout']);
        $this->set("count", $count);
        $this->set("date", $date);
        $this->set("details", $bank_stmt_arr['details']);
        $this->set("member_payout", $bank_stmt_arr['member_payout']);
        $report_name = "Covering Letter";
        $this->set('report_name', "$report_name");
        $this->set('username', "User Name");
        $this->ARR_SCRIPT[0]["name"] = "ajax.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->ARR_SCRIPT[1]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[1]["type"] = "js";

        $this->ARR_SCRIPT[2]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[2]["type"] = "css";

        $this->ARR_SCRIPT[3]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[3]["type"] = "js";

        $this->load_langauge_scripts();

        $this->setView();
    }

    function weekly_payout_report() {
        $date = date("Y-m-d");
        $this->set("date", $date);
        $from_date = strip_tags($this->input->post('week_date1')) . " 00:00:00";
        $to_date = strip_tags($this->input->post('week_date2')) . " 23:59:59";
        $weekly_payout = $this->report_model->getTotalPayout($from_date, $to_date);
        $count = count($weekly_payout);
        $this->set("count", $count);
        $this->set("weekly_payout", $weekly_payout);

        ////////////////////////////////for language traslation///////////////////////////
        $this->set("tran_no", $this->lang->line('no'));
        $this->set("tran_user_name", $this->lang->line('user_name'));
        $this->set("tran_full_name", $this->lang->line('full_name'));
        $this->set("tran_total_amount", $this->lang->line('total_amount'));
        $this->set("tran_tds", $this->lang->line('tds'));
        $this->set("tran_service_charge", $this->lang->line('service_charge'));
        $this->set("tran_amount_payable", $this->lang->line('amount_payable'));
        $this->set("tran_user_payout_report", $this->lang->line('user_payout_report'));
        $this->set("tran_click_here_print", $this->lang->line('click_here_print'));
        /////////////////////////////////////////////////////////////////////////////////////

        $this->setView();
    }

}
