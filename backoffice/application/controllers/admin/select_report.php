<?php

require_once 'Inf_Controller.php';

class Select_report extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function admin_profile_report() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('profile_reports');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('profile_reports');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_reports');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_profile_report_view_error')) {
            $error_array = $this->session->userdata('inf_profile_report_view_error');
            $this->session->unset_userdata('inf_profile_report_view_error');
        }

        $error_array_count = array();
        if ($this->session->userdata('inf_profile_report_view_count_error')) {
            $error_array_count = $this->session->userdata('inf_profile_report_view_count_error');
            $this->session->unset_userdata('inf_profile_report_view_count_error');
        }

        $error_array_profile_count = array();
        if ($this->session->userdata('inf_profile_report_count_error')) {
            $error_array_profile_count = $this->session->userdata('inf_profile_report_count_error');

            $this->session->unset_userdata('inf_profile_report_count_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_count', $error_array_count);
        $this->set('error_single_count', count($error_array_count));

        $this->set('error_array_profile_count', $error_array_profile_count);
        $this->set('error_profile_count', count($error_array_profile_count));

        $help_link = "member-profile-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function total_joining_report() {

        $title = lang('joining_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('joining_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('joining_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_total_joining_daily_error')) {
            $error_array = $this->session->userdata('inf_total_joining_daily_error');
            $this->session->unset_userdata('inf_total_joining_daily_error');
        }
        $error_array_weekely = array();
        if ($this->session->userdata('inf_total_joining_weekly_error')) {
            $error_array_weekely = $this->session->userdata('inf_total_joining_weekly_error');
            $this->session->unset_userdata('inf_total_joining_weekly_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_weekly', $error_array_weekely);
        $this->set('error_count_weekly', count($error_array_weekely));

        $help_link = "joining-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    function total_payout_report() {

        $title = lang('total_payout_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('total_payout_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('total_payout_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_weekly_payout_report_error')) {
            $error_array = $this->session->userdata('inf_weekly_payout_report_error');
            $this->session->unset_userdata('inf_weekly_payout_report_error');
        }

        $error_array_user = array();
        if ($this->session->userdata('inf_member_payout_report_error')) {
            $error_array_user = $this->session->userdata('inf_member_payout_report_error');
            $this->session->unset_userdata('inf_member_payout_report_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_user', $error_array_user);
        $this->set('error_count_user', count($error_array_user));

        $help_link = "payout-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    //check 
    function payout_release_report() {

        $title = lang('payout_release_reports');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_release_reports');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release_reports');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_payout_release_ewallet_request_error')) {
            $error_array = $this->session->userdata('inf_payout_release_ewallet_request_error');
            $this->session->unset_userdata('inf_payout_release_ewallet_request_error');
        }

        $error_array_binary = array();
        if ($this->session->userdata('inf_payout_released_report_binary_error')) {
            $error_array_binary = $this->session->userdata('inf_payout_released_report_binary_error');
            $this->session->unset_userdata('inf_payout_released_report_binary_error');
        }

        $error_array_request = array();
        if ($this->session->userdata('inf_payout_request_pending_error')) {
            $error_array_request = $this->session->userdata('inf_payout_request_pending_error');
            $this->session->unset_userdata('inf_payout_request_pending_error');
        }

        $obj_pay = new select_report_model();
        $payout_release_status = $this->select_report_model->getPayoutReleaseStatus();
        $payout_type = $this->select_report_model->getPayoutType();
        $this->set("payout_type", $payout_type);
        $this->set("payout_release_status", $payout_release_status);

        $help_link = "payout-release-report";
        $this->set("help_link", $help_link);

        if ($payout_type != "daily") {
            $arr_dates = $obj_pay->getAllBinaryPayoutDates("DESC");
            $arr_len = count($arr_dates);
            $this->set('arr_dates', $arr_dates);
            $this->set('arr_len', $arr_len);
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->set('error_array_binary', $error_array_binary);
        $this->set('error_binary_count', count($error_array_binary));

        $this->set('error_array_request', $error_array_request);
        $this->set('error_request_count', count($error_array_request));

        $this->setView();
    }

    public function ajax_users_auto($user_name = "") {
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $user_detail = $this->select_report_model->selectUser($letters);
        echo $user_detail;
    }

    public function ajax_epin_auto($user_name = "") {
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $str = $this->select_report_model->selectEpin($letters);
        echo $str;
    }

    /*     * ****************************code by albert************************** */

    function bank_statement_report() {
        $user_type = $this->LOG_USER_TYPE;

        $this->set('user_type', "$user_type");
        $this->set('username', "User Name");

        $title = lang('bank_statement_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('bank_statement_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('bank_statement_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_bank_statement_report_error')) {
            $error_array = $this->session->userdata('inf_bank_statement_report_error');
            $this->session->unset_userdata('inf_bank_statement_report_error');
        }

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "bank-statement-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    //----------------------------------------------code edited by amrutha
    function fund_transfer_report() {
        $user_type = $this->LOG_USER_TYPE;

        $this->set('user_type', "$user_type");
        $this->set('username', "User Name");

        $title = lang('fund_transfer_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('fund_transfer_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_transfer_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "fund_transfer_report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function fund_deduct_report() {
        $user_type = $this->LOG_USER_TYPE;

        $this->set('user_type', "$user_type");
        $this->set('username', "User Name");

        $title = lang('fund_deduct_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('fund_deduct');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_deduct');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "fund_deduct_report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function sales_report() {
        $title = lang('sales_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('sales_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_sales_report_view_error')) {
            $error_array = $this->session->userdata('inf_sales_report_view_error');
            $this->session->unset_userdata('inf_sales_report_view_error');
        }
        $error_array_sales = array();
        if ($this->session->userdata('inf_product_sales_report_error')) {
            $error_array_sales = $this->session->userdata('inf_product_sales_report_error');
            $this->session->unset_userdata('inf_product_sales_report_error');
        }
        $this->set('error_array_sales', $error_array_sales);
        $this->set('error_sales_count', count($error_array_sales));

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "sales-report";
        $this->set("help_link", $help_link);

        $this->load->model('register_model');
        $products = $this->register_model->viewProducts();

        $this->set("products", $products);
        $this->setView();
    }

    function rank_achievers_report() {

        $title = lang('rank_achieve_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "rank-achievers-report";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('rank_achieve_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_rank_achievers_report_error')) {
            $error_array = $this->session->userdata('inf_rank_achievers_report_error');
            $this->session->unset_userdata('inf_rank_achievers_report_error');
        }

        $rank_arr = array();
        $rank_arr = $this->select_report_model->getAllRank();

        $this->set("rank_arr", $rank_arr);
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $this->setView();
    }

    function commission_report() {

        $title = lang('commission_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('commission_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $error_array = array();
        if ($this->session->userdata('inf_commission_report_error')) {
            $error_array = $this->session->userdata('inf_commission_report_error');
            $this->session->unset_userdata('inf_commission_report_error');
        }

        $commission_types = $this->select_report_model->getCommissinTypes();
        $count_commission = count($commission_types);

        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $help_link = "commission_report";
        $this->set("help_link", $help_link);
        $this->set("commission_types", $commission_types);
        $this->set("count_commission", $count_commission);
        $this->set("MLM_PLAN", $this->MLM_PLAN);

        $this->setView();
    }

    function epin_report() {

        $title = lang('epin_report');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('epin_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_report');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $help_link = "payout-report";
        $this->set("help_link", $help_link);
        $this->setView();
    }

    function top_earners_report() {

        $title = lang('user_BV');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('user_BV');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_BV');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $top_earners = $this->select_report_model->getUserBV();
//        $top_earners = $this->select_report_model->getTopEarners();
        $help_link = "Top-earners";
        $this->set("help_link", $help_link);
        $this->set("top_earners", $top_earners);

        $this->setView();
    }
    
    
     function activate_deactivate_report() {

        $title = lang('activate_deactivate_report');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate_report');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $error_array_actveInactive = array();
        if ($this->session->userdata('inf_total_active_deactive_error')) {
            $error_array_actveInactive = $this->session->userdata('inf_total_active_deactive_error');
           
            $this->session->unset_userdata('inf_total_active_deactive_error');
        }

        $this->set('error_array_actveInactive', $error_array_actveInactive);
        $this->set('error_count_activeInactive', count($error_array_actveInactive));

        $help_link = "activate_inactivate-report";
        $this->set("help_link", $help_link);

        $this->setView();
    }
    function token_stats() {

		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;

		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = lang('token_stats');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('token_stats');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('token_stats');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

		$this->load->model('tokens_model');
		$this->load->model('validation_model');
		$single = null;
		$user_id   = $this->LOG_USER_ID;
		$user_name = $this->LOG_USER_NAME;
		if ( $this->input->post( 'user_name' ) && $this->validate_report_tokens() ) {
			$user_name         = $this->input->post( 'user_name' );
			$is_valid_username = $this->validation_model->isUserNameAvailable( $user_name );
			if ( ! $is_valid_username ) {
				$msg = lang( 'Username_not_Exists' );
				$this->redirect( $msg, "select_report/token_stats", false );
			}
			$user_id = $this->validation_model->userNameToID( $user_name );
			$single  = $user_id;
		}

		$total_count   = is_null($single) ? $this->tokens_model->getHistoryCount() : 0;
		$details_token = $this->tokens_model->getTokenStats($single, $pagination);

		$this->set('total_count', $total_count);
		$this->set('details_token', $details_token);
		$this->set('offset', ++$pagination['offset'] );
		$this->set('user_name', $user_name);
		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "admin/select_report/token_stats",
			'total_rows' => $total_count
		] );
		$this->set('links', $links );
        $this->setView();

    }

	function pack_report()
	{
		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;

		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = lang( 'pack_report' );
		$this->set( "title", $this->COMPANY_NAME . " | $title" );

		$this->HEADER_LANG['page_top_header']       = lang( 'pack_report' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'pack_report' );
		$this->HEADER_LANG['page_small_header']     = '';
		$this->load_langauge_scripts();
		$this->load->model( 'package_model' );
		$this->load->model( 'validation_model' );
		$single    = null;
		$from_date = null;
		$to_date   = null;
		$paginate  = $pagination;
		if ( $this->input->post( 'week_date1' ) && $this->input->post( 'week_date2' ) ) {
			$_start = $this->input->post( 'week_date1' );
			$_finish = $this->input->post( 'week_date2' );
			if( ! empty( $_start ) && ! empty( $_finish ) ) {
				$from_date =  DateTime::createFromFormat('m/d/Y', $_start )->setTime(0,0)->format('Y-m-d H:i:s');
				$to_date   = DateTime::createFromFormat('m/d/Y', $_finish )->setTime(0,0)->format('Y-m-d H:i:s');
				$paginate  = null;
			}
		}

		$user_id   = $this->LOG_USER_ID;
		$user_name = $this->LOG_USER_NAME;

		if ( $this->input->post( 'user_name' ) && $this->validate_report_tokens() ) {
			$user_name         = $this->input->post( 'user_name' );
			$is_valid_username = $this->validation_model->isUserNameAvailable( $user_name );
			if ( ! $is_valid_username ) {
				$msg = lang( 'Username_not_Exists' );
				$this->redirect( $msg, "select_report/token_stats", false );
			}
			$user_id = $this->validation_model->userNameToID( $user_name );
			$single = $user_id;
			$paginate = null;
		}
		$details = $this->package_model->getPackageStats( $single, $from_date, $to_date, $paginate );


		$total_count = $this->package_model->getTotalRows( $single, $from_date, $to_date );

		if( is_null( $paginate ) ) {
			$pagination['offset'] = 0;
			$pagination['limit'] = $total_count;
		}
		$this->set( 'total_count', 0 );
		$this->set( 'details', $details );
		$this->set( 'offset', ++$pagination['offset'] );
		$this->set( 'user_name', $user_name );
		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "admin/select_report/pack_report",
			'total_rows' => $total_count
		] );
		$this->set( 'links', $links );
		$this->setView();
	}
    function pack_stats() {
		$title = lang( 'pack_stats' );
		$this->set( "title", $this->COMPANY_NAME . " | $title" );

		$this->HEADER_LANG['page_top_header']       = lang( 'pack_stats' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'pack_stats' );
		$this->HEADER_LANG['page_small_header']     = '';
		$this->load_langauge_scripts();

		$this->setView();
    }
	function validate_report_tokens() {
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
		$validate_form = $this->form_validation->run();
		return $validate_form;
	}

}
