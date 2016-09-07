<?php

require_once 'Inf_Controller.php';

class Select_report extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function admin_profile_report() {

        $title = $this->lang->line('select_user');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        //$this->set('action_page', $this->report/profile_report_view);
        $this->ARR_SCRIPT[0]["name"] = "ajax.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        
        $this->ARR_SCRIPT[1]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[1]["type"] = "js";
        
        $this->ARR_SCRIPT[2]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[2]["type"] = "css";
        
        $this->ARR_SCRIPT[3]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[3]["type"] = "js";
        
        $this->load_langauge_scripts();

        /////////////////////////////////coded added by ameen////////////////////////////////////
        ////////////////////////////////for language traslation/////////////////////////////////
        ////////////////////FOR PRODUCT_TAB
        $this->set("tran_profile_report", $this->lang->line('profile_report'));
        $this->set("tran_joining_report", $this->lang->line('joining_report'));
        $this->set("tran_total_payout_report", $this->lang->line('total_payout_report'));
        $this->set("tran_bank_statement", $this->lang->line('bank_statement'));
        $this->set("tran_payout_release_report", $this->lang->line('payout_release_report'));
        ////////////////////////////////////////////////////////////////////////////////////////
        $this->set("tran_profile_report", $this->lang->line('profile_report'));
        $this->set("tran_select_user_name", $this->lang->line('select_user_name'));
        $this->set("tran_view", $this->lang->line('view'));
        $this->set("tran_enter_count", $this->lang->line('enter_count'));
        $this->set("tran_enter_count_start_from", $this->lang->line('enter_count_start_from'));

        ///////////////////////////////////////////////////////////////////////////////////////
        $this->setView();
    }

    function total_joining_report() {

        $title = $this->lang->line('joining_report');

        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[0]["name"] = "calendar-win2k-cold-1.css";
        $this->ARR_SCRIPT[0]["type"] = "css";
        $this->ARR_SCRIPT[1]["name"] = "jscalendar/calendar.js";
        $this->ARR_SCRIPT[1]["type"] = "js";
        $this->ARR_SCRIPT[2]["name"] = "jscalendar/calendar-setup.js";
        $this->ARR_SCRIPT[2]["type"] = "js";
        $this->ARR_SCRIPT[3]["name"] = "jscalendar/lang/calendar-en.js";
        $this->ARR_SCRIPT[3]["type"] = "js";
        $this->ARR_SCRIPT[4]["name"] = "validate_joining.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        $this->load_langauge_scripts();

        /////////////////////////////////coded added by ameen////////////////////////////////////
        ////////////////////////////////for language traslation/////////////////////////////////
        ////////////////////FOR PRODUCT_TAB
        $this->set("tran_profile_report", $this->lang->line('profile_report'));
        $this->set("tran_joining_report", $this->lang->line('joining_report'));
        $this->set("tran_total_payout_report", $this->lang->line('total_payout_report'));
        $this->set("tran_bank_statement", $this->lang->line('bank_statement'));
        $this->set("tran_payout_release_report", $this->lang->line('payout_release_report'));
        $this->setView();
    }

    function total_payout_report() {

        $title = $this->lang->line('total_payout_report');

        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->set("temp_path", TEMPLATE_APP_PATH);

        $this->ARR_SCRIPT[0]["name"] = "calendar-win2k-cold-1.css";
        $this->ARR_SCRIPT[0]["type"] = "css";
        
        $this->ARR_SCRIPT[1]["name"] = "jscalendar/calendar.js";
        $this->ARR_SCRIPT[1]["type"] = "js";
        
        $this->ARR_SCRIPT[2]["name"] = "jscalendar/calendar-setup.js";
        $this->ARR_SCRIPT[2]["type"] = "js";
        
        $this->ARR_SCRIPT[3]["name"] = "jscalendar/lang/calendar-en.js";
        $this->ARR_SCRIPT[3]["type"] = "js";
        
        $this->ARR_SCRIPT[4]["name"] = "ajax.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        
        $this->ARR_SCRIPT[5]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[5]["type"] = "js";
        
        $this->ARR_SCRIPT[6]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[6]["type"] = "css";
        
        $this->ARR_SCRIPT[7]["name"] = "validate_joining.js";
        $this->ARR_SCRIPT[7]["type"] = "js";

        $this->load_langauge_scripts();
    }

    function payout_release_report() {

        $obj_pay = new SelectReport();

        $payout_type = $this->SelectReport->getPayoutType();
        $this->set("payout_type", $payout_type);

        if ($payout_type != "daily") {
            $arr_dates = $obj_pay->getAllBinaryPayoutDates("DESC");
            $arr_len = count($arr_dates);
            $this->set('arr_dates', $arr_dates);
            $this->set('arr_len', $arr_len);
        }

        $this->set("temp_path", TEMPLATE_APP_PATH);
        $title = $this->lang->line('payout_release_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[0]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[0]["type"] = "css";

        $this->ARR_SCRIPT[1]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[1]["type"] = "js";

        $this->ARR_SCRIPT[2]["name"] = "calendar-win2k-cold-1.css";
        $this->ARR_SCRIPT[2]["type"] = "css";

        $this->ARR_SCRIPT[3]["name"] = "jscalendar/calendar.js";
        $this->ARR_SCRIPT[3]["type"] = "js";

        $this->ARR_SCRIPT[4]["name"] = "jscalendar/calendar-setup.js";
        $this->ARR_SCRIPT[4]["type"] = "js";

        $this->ARR_SCRIPT[5]["name"] = "jscalendar/lang/calendar-en.js";
        $this->ARR_SCRIPT[5]["type"] = "js";

        $this->load_langauge_scripts();
    }

    function my_transfer_details() {
        $title = $this->lang->line('transfer_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->ARR_SCRIPT[0]["name"] = "calendar-win2k-cold-1.css";
        $this->ARR_SCRIPT[0]["type"] = "css";
        
        $this->ARR_SCRIPT[1]["name"] = "jscalendar/calendar.js";
        $this->ARR_SCRIPT[1]["type"] = "js";
        
        $this->ARR_SCRIPT[2]["name"] = "jscalendar/calendar-setup.js";
        $this->ARR_SCRIPT[2]["type"] = "js";
        
        $this->ARR_SCRIPT[3]["name"] = "jscalendar/lang/calendar-en.js";
        $this->ARR_SCRIPT[3]["type"] = "js";
        
        $this->ARR_SCRIPT[4]["name"] = "ajax.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        
        $this->ARR_SCRIPT[5]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[5]["type"] = "js";
        
        $this->ARR_SCRIPT[6]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[6]["type"] = "css";
        
        $this->ARR_SCRIPT[7]["name"] = "validate_profile.js";
        $this->ARR_SCRIPT[7]["type"] = "js";
        
        $this->load_langauge_scripts();
        $this->set("temp_path", TEMPLATE_APP_PATH);
    }

    public function ajax_users_auto($user_name) {
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $str = $this->select_report_model->selectUser($letters);

        echo $str;
    }

    /*     * ****************************code by albert************************** */

    function bank_statement_report() {
        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', "$user_type");
        $this->set('username', "User Name");
        $title = $this->lang->line('bank_statement_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

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

}

?>
