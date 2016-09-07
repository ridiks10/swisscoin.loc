<?php

require_once 'Inf_Controller.php';

class trading extends Inf_Controller {

	function my_trading() {

		$this->load->library('inf_pagination');
		$pagination = [];
		$pagination['limit'] = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = lang('trading_account');
		$this->set('title', $this->COMPANY_NAME . ' |' . $title);
		$help_link = 'my-e-wallet';
		$this->set('help_link', $help_link);

		$this->HEADER_LANG['page_top_header'] = lang('trading_account');
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header'] = lang('trading_account');
		$this->HEADER_LANG['page_small_header'] = '';

		$this->load_langauge_scripts();
		$mlm_plan = $this->MLM_PLAN;
		$lang_id  = $this->LANG_ID;
		$this->set( 'mlm_plan', $mlm_plan );
		$user_type = $this->LOG_USER_TYPE;
		$employee_view_permission = $user_type == 'employee' ? 'no' : 'yes';

		$userid            = $this->LOG_USER_ID;
		$user_name         = $this->LOG_USER_NAME;
		$user_id           = $userid;
		$is_valid_username = false;

		$start = microtime(true);
		$details_data = $this->trading_model->getCommission2( $user_id, '', '', true, $pagination );
		$finish = microtime(true) - $start;
		$var = true;


		$start = microtime(true);
		$ewallet_details = $this->trading_model->getCommissionDetails2( $user_id, null, null, $pagination, $details_data['initial_balance'] );
		$finish = microtime(true) - $start;

		$info_box        = $this->validation_model->getInfoDetails( 'trading_account', $lang_id );
		$this->set( 'info_box', $info_box );

		$this->set( 'ewallet_view_permission', $employee_view_permission );
		$this->set( 'details_count', $details_data['num_rows'] );
		$this->set( 'ewallet_details', $ewallet_details );
		$this->set( 'user_name', $user_name );
		$this->set( 'is_valid_username', $is_valid_username );

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/trading/my_trading/",
			'total_rows' => $details_data['num_rows']
		] );
		$this->set('offset_bonus', ++$pagination['offset'] );
		$this->set('total_amount', $details_data['total_amount'] );
		$this->set('links', $links );
		$this->setView();
	}


	function validate_my_ewallet() {
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
		$validate_form = $this->form_validation->run();
		return $validate_form;
	}
}
