<?php

require_once 'Inf_Controller.php';

class cash_account extends Inf_Controller {

	function my_cash() {

		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;

		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = lang( 'cash_account' );
		$this->set( 'title', $this->COMPANY_NAME . ' |' . $title );
		$help_link = 'my-e-wallet';
		$this->set( 'help_link', $help_link );

		$this->HEADER_LANG['page_top_header']       = lang( 'cash_account' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'cash_account' );
		$this->HEADER_LANG['page_small_header']     = '';

		$this->load->model( 'ewallet_model', '' );
		$this->load_langauge_scripts();
		$mlm_plan = $this->MLM_PLAN;
		$lang_id  = $this->LANG_ID;
		$this->set( 'mlm_plan', $mlm_plan );
		$user_type = $this->LOG_USER_TYPE;
		$employee_view_permission = ( $user_type == 'employee' ) ? 'no' : 'yes';
		if( $this->session->userdata('cash_account_chosen_uid') ) {
			$user_id   = intval( $this->session->userdata('cash_account_chosen_uid') );
			$user_name = $this->validation_model->IdToUserName( $user_id );
		} else {
			$user_id   = $this->LOG_USER_ID;
			$user_name = $this->LOG_USER_NAME;
		}

		$is_valid_username = false;

		if ($this->input->post('user_name') && $this->validate_my_ewallet()) {
			$user_name = $this->input->post('user_name');
			$is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
			if (!$is_valid_username) {
				$msg = lang('Username_not_Exists');
				$this->redirect($msg, "ewallet/my_ewallet", false);
			}
			$this->set('ewallet_view_permission', 'yes');
			$user_id = $this->validation_model->userNameToID($user_name);
			$this->session->set_userdata('cash_account_chosen_uid', $user_id );
		}
		$from_date = Date( 'Y-m-d', strtotime( $this->ewallet_model->getJoiningDate( $user_id ) ) );
		$to_date   = Date( 'Y-m-d' );

		$details_data    = $this->ewallet_model->getCommission2( $user_id, $from_date, $to_date, $pagination, true );
		$ewallet_details = $this->ewallet_model->getCommissionDetails2( $user_id, $from_date, $to_date, $pagination, $details_data['initial_balance'] );

		$info_box = $this->validation_model->getInfoDetails('cash_account',$lang_id);
		$this->set('info_box', $info_box);

		$this->set('ewallet_view_permission', $employee_view_permission);
		$this->set('details_count', $details_data['num_rows']);
		$this->set('ewallet_details', $ewallet_details);
		$this->set('user_name', $user_name);
		$this->set('is_valid_username', $is_valid_username);

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "admin/cash_account/my_cash/",
			'total_rows' => $details_data['num_rows']
		] );
		$this->set('offset_count', ++$pagination['offset'] );
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
