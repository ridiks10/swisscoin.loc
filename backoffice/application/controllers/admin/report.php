<?php

require_once 'Inf_Controller.php';

/**
 * @property-read report_model $report_model
 */
class Report extends Inf_Controller {

    function profile_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if (($this->input->post('profile_view')) && $this->validate_profile_report_view()) {
            $user_name = $this->input->post('user_name');
            $user_id = $this->report_model->userNameToID($user_name);
            if ($user_id) {
                $this->session->set_userdata("inf_profile_report_view_user_name", $user_name);
            } else {
                $msg = lang('Invalid_Username');
                $this->redirect($msg, "select_report/admin_profile_report", false);
            }
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }

        if (isset($this->session->userdata["inf_profile_report_view_user_name"])) {
            $user_name = $this->session->userdata["inf_profile_report_view_user_name"];
            $profile_arr = $this->report_model->getProfileDetails($user_name);
            $this->set("details", $profile_arr['details']);
            $this->set("sponser", $profile_arr['sponser']);
            $this->set("user_name", $user_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_profile_report_view() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function profile_report() {
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('profile_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);
        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if ($this->input->post('profile') && $this->validate_profile_report_single_count()) {
            $profile_arr = $this->report_model->profileReport($this->input->post('count'));
            $this->set("profile_arr", $profile_arr);
            $count = count($profile_arr);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_count_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }
        $help_link = "profile_report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_profile_report_single_count() {
        $this->form_validation->set_rules('count', 'Count', 'trim|required|strip_tags|is_natural_no_zero');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function profile_report_multiple_count() {
        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('profile_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $this->HEADER_LANG['page_top_header'] = lang('profile_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);


        if ($this->input->post('profile_from') && $this->validate_profile_report()) {
            $count_from = $this->input->post('count_from');
            $count_to = $this->input->post('count_to');

            $profile_arr = $this->report_model->profileReport($count_to - $count_from, $count_from - 1);
            $this->set("profile_arr", $profile_arr);

            $count = count($profile_arr);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_count_error', $error_array);
            redirect('admin/select_report/admin_profile_report');
        }

        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_profile_report() {
        $this->form_validation->set_rules('count_from', 'Count From', 'trim|required|strip_tags|is_natural_no_zero');
        $this->form_validation->set_rules('count_to', 'Count To', 'trim|required|strip_tags|is_natural_no_zero');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function total_joining_daily() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('user_joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if ($this->input->post('dailydate') && $this->validate_total_joining_daily()) {
            $this->load->model('joining_class_model');
            
            $todays_join = $this->joining_class_model->getJoinings($this->input->post('date'));
            $this->set("count", count($todays_join));
            $this->set("todays_join", $todays_join);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_joining_daily_error', $error_array);
            redirect('admin/select_report/total_joining_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_total_joining_daily() {
        $this->form_validation->set_rules('date', 'Date', 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function total_joining_weekly() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('user_joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_joining_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->report_header();

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $this->set("date", $date);
        if ($this->input->post('weekdate') && $this->validate_total_joining_weekly()) {
            $from = $this->input->post('week_date1') . " 00:00:00";
            $to = $this->input->post('week_date2') . " 23:59:59";
            $this->load->model('joining_class_model');
            
            $week_join = $this->joining_class_model->getJoinings($from, $to);
            $this->set("count", count($week_join));
            $this->set("week_join", $week_join);
        } else {
            $error_array_weekely = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_joining_weekly_error', $error_array_weekely);
            redirect('admin/select_report/total_joining_report');
        }

        $this->set("help_link", "downlaod_document");
        $this->setView();
    }

    function validate_total_joining_weekly() {
        $this->form_validation->set_rules('week_date1', 'Starting date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Ending date', 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function bank_statement() {
        $this->report_header();

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $count = "";

        if ($this->input->post('bank_stmnt') && $this->validate_bank_statement()) {
            $user_mob_name = $this->input->post('user_name');
            $user_id = $this->report_model->userNameToID($user_mob_name);

            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, "select_report/bank_statement_report", FALSE);
            } else {
                $userid = $user_id;
            }
            $bank_stmt_user_details = $this->report_model->getBankStatement($user_mob_name);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_bank_statement_report_error', $error_array);
            redirect('admin/select_report/bank_statement_report');
        }
        $date = date("Y-m-d");
        $count = count($bank_stmt_user_details['member_payout']);
        $this->set("count", $count);
        $this->set("date", $date);
        $this->set("details", $bank_stmt_user_details['details']);
        $this->set("member_payout", $bank_stmt_user_details['member_payout']);
        $report_name = lang('Covering_Letter');
        $this->set('report_name', "$report_name");
        $this->set('username', "User Name");

        $this->setView();
    }

    function validate_bank_statement() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function payout_released_report_binary() {

        $title = lang('payout_release_report');
        $this->set("title", $title);

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->load_langauge_scripts();

        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if (($this->input->post('payout_released')) && $this->validate_payout_released_report_binary()) {
            $payout = $this->report_model->getPayoutType();
            $payout_type = strip_tags($this->input->post('payout_type'));
            $amount_type_arr[] = "leg";
            $amount_type_arr[] = "referral";
            if ($payout == "daily") {

                if ($payout_type == 'pending') {
                    $date = strip_tags($this->input->post('week_date1'));
                    $payout_details = $this->report_model->getDailyPaidoutPendingDetails($date, $amount_type_arr);
                } else {

                    $date = strip_tags($this->input->post('week_date1'));
                    $payout_details = $this->report_model->getDailyPaidoutDetails($date, $amount_type_arr);
                }
            } else {
                $released_date1 = strip_tags($this->input->post('released_date1'));
                $released_date2 = strip_tags($this->input->post('released_date2'));
                if ($payout_type == 'pending') {

                    $payout_status = "no";
                    $payout_details = $this->report_model->getReleasedPayoutDetails($released_date2, $payout_status, $amount_type_arr);
                    $before_payout_date = $this->report_model->getBeforePayoutDateBinary($released_date2);
                    $previous_pyout_date = $before_payout_date . " 59:59:59";
                } else {

                    $payout_status = "yes";
                    $payout_details = $this->report_model->getReleasedPayoutDetails($released_date1, $payout_status, $amount_type_arr);
                    $before_payout_date = $this->report_model->getBeforePayoutDateBinary($released_date1);
                    $previous_pyout_date = $before_payout_date . " 59:59:59";
                }
            }
            $count = count($payout_details);
            $this->set("binary_details", $payout_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_released_report_binary_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }

        $this->setview();
    }

    public function validate_payout_released_report_binary() {

        $this->form_validation->set_rules('released_date2', 'Date', 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function total_payout_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('user_payout_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('user_payout_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_payout_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);

        $total_payout = $this->report_model->getTotalPayout();
        $count = count($total_payout);
        $this->set("count", $count);
        $this->set("total_payout", $total_payout);

        $help_link = "report";
        $this->set("help_link", $help_link);

        $this->setview();
    }

    function member_payout_report() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('member_wise_payout_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('member_wise_payout_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('member_wise_payout_report');
        $this->HEADER_LANG['page_small_header'] = '';


        $this->load_langauge_scripts();

        $this->report_header();

        $date = date("Y-m-d");
        $this->set("date", $date);
        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);
        if ($this->input->post('user_submit') && $this->validate_member_payout_report()) {
            $user_mob_name = $this->input->post('user_name');
            $this->session->set_userdata("inf_user_name_payout", $user_mob_name);
        } else {
            $error_array_user = $this->form_validation->error_array();
            $this->session->set_userdata('inf_member_payout_report_error', $error_array_user);
            redirect('admin/select_report/total_payout_report');
        }
        if (isset($this->session->userdata["inf_user_name_payout"])) {
            $user_mob_name = $this->session->userdata["inf_user_name_payout"];
            $member_payout = $this->report_model->getMemberPayout($user_mob_name);
            $count = count($member_payout);
            $this->set("count", $count);
            $this->set("member_payout", $member_payout);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/total_payout_report');
        }

        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_member_payout_report() {
        $this->form_validation->set_rules('user_name', 'User name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function weekly_payout_report() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('user_payout_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('user_payout_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_payout_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->report_header(); //for report header

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);
        if ($this->input->post('weekdate') && $this->validate_weekly_payout_report()) {
            $from_date = $this->input->post('week_date1') . " 00:00:00";
            $to_date = $this->input->post('week_date2') . " 23:59:59";
            $weekly_payout = $this->report_model->getTotalPayout($from_date, $to_date);
            $this->set("count", count($weekly_payout));
            $this->set("weekly_payout", $weekly_payout);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_weekly_payout_report_error', $error_array);
            redirect('admin/select_report/total_payout_report');
        }

        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_weekly_payout_report() {
        $this->form_validation->set_rules('week_date1', 'Startind date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Ending date', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function payout_release_ewallet_request() {

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if (($this->input->post('payout_released')) && $this->validate_payout_release_ewallet_request()) {

            $from_date = $this->input->post('week_date1') . " 00:00:00";
            $to_date = $this->input->post('week_date2') . " 23:59:59";

            $amount_type_arr[] = "leg";
            $amount_type_arr[] = "referral";
            $payout_status = "yes";

            $ewallt_req_details = $this->report_model->getReleasedPayoutDetailsEwalletRequest($from_date, $to_date, $payout_status, $amount_type_arr);
            $count = count($ewallt_req_details);
            $this->set("binary_details", $ewallt_req_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_release_ewallet_request_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }
        $this->setView();
    }

    public function validate_payout_release_ewallet_request() {

        $this->form_validation->set_rules('week_date1', 'Date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Date', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function payout_request_pending() {
        $title = lang('payout_release_report');
        $this->set("title", $title);

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->load_langauge_scripts();

        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);
        if (($this->input->post('payout_released')) && $this->validate_payout_request_pending()) {

            $from_date = $this->input->post('week_date3') . " 00:00:00";
            $to_date = $this->input->post('week_date4') . " 23:59:59";
            $amount_type_arr[] = "leg";
            $amount_type_arr[] = "referral";
            $payout_status = "yes";
            $ewallt_req_details = $this->report_model->getPayoutRequestEwalletRequest($from_date, $to_date, $payout_status, $amount_type_arr);
            $count = count($ewallt_req_details);
            $this->set("binary_details", $ewallt_req_details);
            $this->set("count", $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_payout_request_pending_error', $error_array);
            redirect('admin/select_report/payout_release_report');
        }

        $this->setview();
    }

    public function validate_payout_request_pending() {

        $this->form_validation->set_rules('week_date3', 'Date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date4', 'Date', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function fund_transfer_report_view() {

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->load_langauge_scripts();

        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if ($this->input->post('weekdate')) {
            $week = strip_tags($this->input->post('week'));
            $year = strip_tags($this->input->post('year'));
            $fund_transfer_rprt = $this->report_model->getFundTransferDeductReport($week, $year, "transfer");
            $this->set('fund_transfer_rprt', $fund_transfer_rprt);
            $this->set('cnt', count($fund_transfer_rprt));
        }
        $report_name = "Covering Letter";
        $this->set('report_name', "$report_name");
        $this->set('username', "User Name");
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function fund_deduct_report_view() {
        $date = date("Y-m-d");
        $this->set("date", $date);

        if ($this->input->post('weekdate')) {
            $week = strip_tags($this->input->post('week'));
            $year = strip_tags($this->input->post('year'));
            $fund_deduct_rprt = $this->report_model->getFundTransferDeductReport($week, $year, "deduct");
            $this->set('fund_deduct_rprt', $fund_deduct_rprt);
            $this->set('cnt', count($fund_deduct_rprt));
        }
        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $this->set("count", $header_count);
        $this->set("date", $date);

        $report_name = "Covering Letter";
        $this->set('report_name', "$report_name");
        $this->set('username', "User Name");
        $this->report_header();

        $this->setView();
    }

    function sales_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set("date_submission", lang('date_submission'));
        $this->set("payment_method", lang('Payment_method'));

        $report_name = lang('sales_report');
        $this->set('report_name', "$report_name");

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);

        if (($this->input->post('weekdate')) && $this->validate_sales_report_view()) {
            $from_date = $this->input->post('week_date1');
            $to_date = $this->input->post('week_date2');
            $this->session->set_userdata("inf_week_date1", $from_date);
            $this->session->set_userdata("inf_week_date2", $to_date);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_sales_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        if (isset($this->session->userdata["inf_week_date1"])) {
            $from_date = $this->session->userdata["inf_week_date1"];
            $to_date = $this->session->userdata["inf_week_date2"];
            $report_arr = $this->report_model->salesReport($from_date, $to_date);
            $count = count($report_arr);
            $this->set('report_arr', $report_arr);
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_sales_report_view() {

        $this->form_validation->set_rules('week_date1', 'Date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Date', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function product_sales_report() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();


        $this->set("date_submission", lang('date_submission'));
        $this->set("payment_method", lang('Payment_method'));
        $report_name = lang('sales_report');
        $this->set('report_name', "$report_name");

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);

        if (($this->input->post('user_submit')) && $this->validate_product_sales_report()) {
            $prod_id = $this->input->post('product_id');
            $this->session->set_userdata("inf_product_sales_id", $prod_id);
        } else {
            $error_array_sales = $this->form_validation->error_array();
            $this->session->set_userdata('inf_product_sales_report_error', $error_array_sales);
            redirect('admin/select_report/sales_report');
        }
        ///////////////////////////////////
        if (isset($this->session->userdata["inf_product_sales_id"])) {
            $prod_id = $this->session->userdata["inf_product_sales_id"];
            $sales_report_arr = $this->report_model->productSalesReport($prod_id);
            $count = count($sales_report_arr);
            $this->set('sales_report_arr', $sales_report_arr);
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/sales_report');
        }
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_product_sales_report() {

        $this->form_validation->set_rules('product_id', 'Product', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function report_header() {

        $this->set("tran_Welcome_to", $this->lang->line('Welcome_to'));
        $this->set("tran_O", $this->lang->line('O'));
        $this->set("tran_I", $this->lang->line('I'));
        $this->set("tran_Floor", $this->lang->line('Floor'));
        $this->set("tran_em", $this->lang->line('em'));
        $this->set("tran_addr", $this->lang->line('addr'));
        $this->set("tran_comp", $this->lang->line('comp'));
        $this->set("tran_ph", $this->lang->line('ph'));
        $this->set("tran_nfinite", $this->lang->line('nfinite'));
        $this->set("tran_pen", $this->lang->line('pen'));
        $this->set("tran_ource", $this->lang->line('ource'));
        $this->set("tran_olutions", $this->lang->line('olutions'));
        $this->set("tran_S", $this->lang->line('S'));
        $this->set("tran_Date", $this->lang->line('Date'));
        $this->set("tran_email", $this->lang->line('email'));
        $this->set("tran_address", $this->lang->line('address'));
        $this->set("tran_phone", $this->lang->line('phone'));
        $this->set("tran_click_here_print", $this->lang->line('click_here_print'));
    }

    public function rank_achievers_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $report_name = $this->lang->line('rank_achieve_report');
        $this->set('report_name', "$report_name");

        $date = date("Y-m-d");
        $this->set("date", $date);
        $rank = array();
        if ($this->input->post('weekdate') && $this->validate_rank_achievers_report_view()) {
            $from_date = $this->input->post('week_date1');
            $to_date = $this->input->post('week_date2');
            $ranks = $this->input->post('ranks');
            $from_date = $from_date . ' 00:00:00';
            $to_date = $to_date . ' 23:59:59';
            $this->session->set_userdata("inf_rank_week_date1", $from_date);
            $this->session->set_userdata("inf_rank_week_date2", $to_date);
            $this->session->set_userdata("inf_ranks", $ranks);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_rank_achievers_report_error', $error_array);
            redirect('admin/select_report/rank_achievers_report');
        }
        if (isset($this->session->userdata["inf_rank_week_date1"])) {
            $from_date = $this->session->userdata["inf_rank_week_date1"];
            $to_date = $this->session->userdata["inf_rank_week_date2"];
            $ranks = $this->session->userdata["inf_ranks"];
            $ranked_user_details = array();
            $ranked_user_details = $this->report_model->rankedUsers($ranks, $from_date, $to_date);
            $count = count($ranked_user_details);
            $this->set('report_arr', $ranked_user_details);
            $this->set('count', $count);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/rank_achievers_report');
        }
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_rank_achievers_report_view() {

        $this->form_validation->set_rules('week_date1', 'Starting date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Ending date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('ranks[]', 'Rank', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function commission_report_view() {


        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('commission_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('commission_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $type = "";
        $date = date("Y-m-d");
        $this->set("date", $date);
        $date1 = date('Y-m-d:H:i:s');
        if ($this->input->post('commision') && $this->validate_commission_report_view()) {
            $type = $this->input->post("amount_type");
            $from_date = $this->input->post("from_date");
            $to_date = $this->input->post("to_date");
            $this->session->set_userdata("inf_commision_week_date1", $from_date);
            $this->session->set_userdata("inf_commision_week_date2", $to_date);
            $this->session->set_userdata("inf_commision_type", $type);
            if ($type == '') {
                $msg = lang('enter_amount_type');
                $this->redirect($msg, 'select_report/commission_report', false);
            }
            $details = $this->report_model->getCommisionDetails($type, $from_date, $to_date);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_commission_report_error', $error_array);
            redirect('admin/select_report/commission_report');
        }

        if (isset($this->session->userdata["inf_commision_type"])) {
            $from_date = $this->session->userdata["inf_commision_week_date1"];
            $to_date = $this->session->userdata["inf_commision_week_date2"];
            $type = $this->session->userdata["inf_commision_type"];
            $details = $this->report_model->getCommisionDetails($type, $from_date, $to_date);
            $count = count($details);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/commission_report');
        }
        $this->report_header();
        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);
        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $this->set('details', $details);
        $this->set('count', $count);
        $this->set('date1', $date1);
        $this->set('type', $type);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    public function validate_commission_report_view() {

        $this->form_validation->set_rules('from_date', 'From date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('to_date', 'To date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('amount_type[]', 'Amount type', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function epin_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('epin_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('epin_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);
        $pin_details = $this->report_model->getUsedPin();
        $count = count($pin_details);
        $this->set("count", $count);
        $this->set("pin_details", $pin_details);
        $help_link = "report";
        $this->set("help_link", $help_link);
        $this->setview();
    }
    
     function activate_deactivate_report_view() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->report_header();

        $this->load_langauge_scripts();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        $date = date("Y-m-d");
        $this->set("date", $date);
        if ($this->input->post('submit_active_deactive') && $this->validate_activate_deactivate_report_view()) {
            $from = $this->input->post('week_date1') . " 00:00:00";
            $to = $this->input->post('week_date2') . " 23:59:59";
            $this->session->set_userdata("inf_week_date1", $from);
            $this->session->set_userdata("inf_week_date2", $to);
        } else {
            
            $error_array_active_deactive = $this->form_validation->error_array();
           
            $this->session->set_userdata('inf_total_active_deactive_error', $error_array_active_deactive);
            redirect('admin/select_report/activate_deactivate_report');
        }

        if (isset($this->session->userdata["inf_week_date1"])) {
            $start_date = $this->session->userdata["inf_week_date1"];
            $to_date = $this->session->userdata["inf_week_date2"];
            $activate_deactive = $this->report_model->getAciveDeactiveUserDetails($start_date, $to_date);
            $count = count($activate_deactive);
            $this->set("count", $count);
            $this->set("activate_deactive", $activate_deactive);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }
    
    
    
       function validate_activate_deactivate_report_view() {
        
           $this->form_validation->set_rules('week_date1', 'Starting date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('week_date2', 'Ending date', 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }
    
    
      function activate_deactivate_daily() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $date = date("Y-m-d");
        $this->set("date", $date);

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->report_header();

        $report_header = $this->report_model->getReportdetails();
        $this->set("report_header", $report_header);

        $header_count = count($report_header);
        $this->set("header_count", $header_count);

        if ($this->input->post('dailydate') && $this->validate_active_inactive_daily()) {
          
            $today = $this->input->post('date');
            $this->session->set_userdata("inf_date1", $today);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_total_active_deactive_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        if (isset($this->session->userdata["inf_date1"])) {
            $today = $this->session->userdata["inf_date1"];
            $todays_active_deactive = $this->report_model->getDailyActivateDeactivateReport($today);
            $count = count($todays_active_deactive);
            $this->set("count", $count);
            $this->set("todays_active_deactive", $todays_active_deactive);
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_profile_report_view_error', $error_array);
            redirect('admin/select_report/activate_deactivate_report');
        }
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function validate_active_inactive_daily() {
        $this->form_validation->set_rules('date', 'Date', 'trim|required|strip_tags');

        $validate_form = $this->form_validation->run();

        return $validate_form;
    }


}
