<?php

require_once 'Inf_Controller.php';

class Mining_tokens extends Inf_Controller
{

	function __construct()
	{
		parent::__construct();
		//$this->lang->study('mining_tokens');
	}
	function request_list()
	{

		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;

		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = $this->lang->line( 'mining_release' );
		$this->set( "title", $this->COMPANY_NAME . " | " . $title );

		$help_link = 'request-list';
		$this->set( 'help_link', $help_link );

		$this->HEADER_LANG['page_top_header']       = lang( 'mining_release' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'mining_release' );
		$this->HEADER_LANG['page_small_header']     = '';

		$this->load->model('tokens_model');
		$this->load->model('validation_model');
		$user_id = null;
		if ( $this->input->post( 'user_name' ) && $this->validate_report_tokens() ) {
			$user_name         = $this->input->post( 'user_name' );
			$is_valid_username = $this->validation_model->isUserNameAvailable( $user_name );
			if ( ! $is_valid_username ) {
				$msg = lang( 'Username_not_Exists' );
				$this->redirect( $msg, "select_report/token_stats", false );
			}
			$user_id = $this->validation_model->userNameToID( $user_name );
		}

		$mining_details = $this->mining_tokens_model->getRequestedTokens( $user_id, $pagination );
		$total_rows = $this->mining_tokens_model->getTotalRows( $user_id );

		$this->set( 'mining_details', $mining_details );
		$this->set('count', $total_rows );
		$this->load_langauge_scripts();
		$this->set('offset', ++$pagination['offset'] );
		$this->set('total', $total_rows );
		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "admin/mining_tokens/request_list/",
			'total_rows' => $total_rows
		] );
		$this->set('links', $links );
		$this->setView();
	}
	function validate_report_tokens() {
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
		$validate_form = $this->form_validation->run();
		return $validate_form;
	}
}