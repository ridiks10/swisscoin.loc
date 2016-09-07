<?php

require_once 'Inf_Controller.php';

class Excel extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function user_detail_excel() {
        $from = $this->session->userdata['inf_prev_date'];
        $to = $this->session->userdata['inf_payout_date'];
        $arr = $this->excel_model->getUserArray($from, $to);
        $date = date("Y-m-d H:i:s");
        $this->excel_model->writeToExcel($arr, "Binary Released User Report ($date)");
    }

    function user_profiles_excel() {
        $this->session->userdata['inf_profile_type'];
        if ($this->session->userdata['inf_profile_type'] == "one_count") {
            $cnt = $this->session->userdata['inf_profile_count'];
            $arr = $this->excel_model->getProfiles($cnt);
            $date = date("Y-m-d H:i:s");
            $this->excel_model->writeToExcel($arr, lang('profile_report') . " ($date)");
        } else if ($this->session->userdata['inf_profile_type'] == "two_count") {
            $count_from = $this->session->userdata['inf_count_from'];
            $count_to = $this->session->userdata['inf_count_to'];
            $date = date("Y-m-d H:i:s");
            $arr = $this->excel_model->getProfilesFrom($count_from, $count_to);
            $this->excel_model->writeToExcel($arr, lang('profile_report') . " ($date)");
        }
    }

    function create_excel_joining_report_daily() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_total_joining_daily'])) {
            $report_date = $this->session->userdata['inf_total_joining_daily'];
            $excel_array = $this->excel_model->getJoiningReportDaily($report_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_joining_report_weekly() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_week_date1']) && isset($this->session->userdata['inf_week_date2'])) {
            $from_date = $this->session->userdata['inf_week_date1'];
            $to_date = $this->session->userdata['inf_week_date2'];
            $excel_array = $this->excel_model->getJoiningReportWeekly($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_total_payout_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getTotalPayoutReport();
        $this->excel_model->writeToExcel($excel_array, lang('total_payout_report') . " ($date)");
    }

    function create_excel_weekly_payout_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_week_date1"])) {
            $from_date = $this->session->userdata["inf_week_date1"];
            $to_date = $this->session->userdata["inf_week_date2"];
            $excel_array = $this->excel_model->getTotalPayoutReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('weekly_payout_report') . " ($date)");
        }
    }

    function create_excel_rank_achievers_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_rank_week_date1"])) {
            $from_date = $this->session->userdata["inf_rank_week_date1"];
            $to_date = $this->session->userdata["inf_rank_week_date2"];
            $ranks = $this->session->userdata["inf_ranks"];
            $excel_array = $this->excel_model->getRankAchieversReport($from_date, $to_date, $ranks);
            $this->excel_model->writeToExcel($excel_array, lang('rank_achievers_report') . " ($date)");
        }
    }

    function create_excel_commission_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_commision_type"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
            $to_date = $this->session->userdata["inf_commision_week_date2"];
            $type = $this->session->userdata["inf_commision_type"];
            $excel_array = $this->excel_model->getCommissionReport($from_date, $to_date, $type);
            $this->excel_model->writeToExcel($excel_array, lang('commission_report') . " ($date)");
        }
    }

    function create_excel_epin_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getEpinReport();
        $this->excel_model->writeToExcel($excel_array, lang('epin_report') . " ($date)");
    }

    function create_excel_top_earners_report() {
        $date = date("Y-m-d H:i:s");
        $excel_array = $this->excel_model->getTopEarnersReport();
        $this->excel_model->writeToExcel($excel_array, lang('top_earners_report') . " ($date)");
    }

    function create_excel_profile_view_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_profile_report_view_user_name"])) {
            $user_name = $this->session->userdata["inf_profile_report_view_user_name"];
            $excel_array = $this->excel_model->getProfileViewReport($user_name);
            $this->excel_model->writeToExcel($excel_array, lang('profile_report') . " ($date)");
        }
    }

    function create_excel_sales_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_week_date1']) && isset($this->session->userdata['inf_week_date2'])) {
            $from_date = $this->session->userdata['inf_week_date1'];
            $to_date = $this->session->userdata['inf_week_date2'];
            $excel_array = $this->excel_model->getSalesReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('sales_report') . " ($date)");
        }
    }

    function create_excel_product_sales_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_product_sales_id"])) {
            $prod_id = $this->session->userdata["inf_product_sales_id"];
            $excel_array = $this->excel_model->productSalesReport($prod_id);
            $this->excel_model->writeToExcel($excel_array, lang('tran_product_wise_sales_report') . " ($date)");
        }
    }

    function create_excel_member_wise_payout_report() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata["inf_user_name_payout"])) {
            $user_name = $this->session->userdata["inf_user_name_payout"];
            $excel_array = $this->excel_model->getMemberPayoutReport($user_name);
            $this->excel_model->writeToExcel($excel_array, lang('member_wise_payout_report') . " ($date)");
        }
    }

    function create_excel_activate_deactivate_report_view() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_week_date1']) && isset($this->session->userdata['inf_week_date2'])) {
            $from_date = $this->session->userdata['inf_week_date1'];
            $to_date = $this->session->userdata['inf_week_date2'];
            $excel_array = $this->excel_model->getActiveInactiveReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

    function create_excel_activate_deactivate_report_view_daily() {
        $date = date("Y-m-d H:i:s");
        if (isset($this->session->userdata['inf_date1'])) {
            $report_date = $this->session->userdata['inf_date1'];
            $from_date = $report_date . " 00:00:00";
            $to_date = $report_date . " 23:59:59";
            $excel_array = $this->excel_model->getActiveInactiveReport($from_date, $to_date);
            $this->excel_model->writeToExcel($excel_array, lang('user_joining_report') . " ($date)");
        }
    }

}

?>