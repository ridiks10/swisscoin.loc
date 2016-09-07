<?php

require_once 'Inf_Controller.php';

class bonus extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function statistics() {
        $title = $this->lang->line('statistics');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('statistics');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('statistics');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;

        $joining_details_per_month = $this->bonus_model->getJoiningDetailsperMonth($user_id);
        $payout_details = $this->bonus_model->getPayoutReleasePercentages2($user_id);
//      $payout_details = $this->bonus_model->getPayoutReleasePercentages($user_id);
        
        $released_payouts_percentage = round($payout_details["released"], 2);
        $pending_payouts_percentage = round($payout_details["pending"], 2);
        $this->set("joining_details_per_month", $joining_details_per_month);
        $this->set("released_payouts_percentage", $released_payouts_percentage);
        $this->set("pending_payouts_percentage", $pending_payouts_percentage);

        $this->setView();
    }
    function direct_bonus() {

		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

		$title = $this->lang->line( 'direct_bonus' );
		$this->set( "title", $this->COMPANY_NAME . " | $title" );
		$this->HEADER_LANG['page_top_header']       = lang( 'direct_bonus' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'direct_bonus' );
		$this->HEADER_LANG['page_small_header']     = '';
		$flag                                       = "false";
		$this->load_langauge_scripts();
		$user_id              = $this->LOG_USER_ID;
		$user_name            = $this->LOG_USER_NAME;
		$is_valid_username    = false;
		$direct_bonus_details = '';
		$bonus_type           = "direct_bonus";
		$direct_bonus_details = $this->bonus_model->getBonusDetails( $user_id, $bonus_type, null, $pagination );

		$countAndTotal = $this->bonus_model->getTotalCountBonus( $user_id, $bonus_type );

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/bonus/{$bonus_type}/",
			'total_rows' => $countAndTotal['max_num_pages']
		] );
		$this->set('offset_bonus', ++$pagination['offset'] );
		$this->set('total_amount', $countAndTotal['total_amount'] );
		$this->set('links', $links );
        $this->set('user_name', $user_name);
        $this->set('is_valid_username', $is_valid_username);
        $this->set("direct_bonus_details", $direct_bonus_details);
        
        $this->set("flag", $flag);
        $this->setView();
    }
    function matching_bonus() {

		$this->load->library('inf_pagination');
		$pagination = [];
		$pagination['limit'] = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

        $title = $this->lang->line('matching_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('matching_bonus');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('matching_bonus');
        $this->HEADER_LANG['page_small_header'] = '';
        $flag = "false";
        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;


        $bonus_type = "matching_bonus";
        $this->set('user_name', $user_name);
        $matching_bonus_details = $this->bonus_model->getBonusDetails( $user_id, $bonus_type, null, $pagination );
        $this->set("matching_bonus_details", $matching_bonus_details);

		$countAndTotal = $this->bonus_model->getTotalCountBonus( $user_id, $bonus_type );

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/bonus/{$bonus_type}/",
			'total_rows' => $countAndTotal['max_num_pages']
		] );
		$this->set('offset_bonus', ++$pagination['offset'] );
		$this->set('total_amount', $countAndTotal['total_amount'] );
		$this->set('links', $links );
        $this->set("flag", $flag);
        $this->setView();
    }

    
    function team_bonus() {

		$this->load->library('inf_pagination');
		$pagination = [];
		$pagination['limit'] = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

        //$title = 'Team Bonus';
        $title = $this->lang->line('team_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        $flag = "false";
        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $bonus_type = "team_bonus";
        $this->set('user_name', $user_name);
        $matching_bonus_details = $this->bonus_model->getBonusDetails( $user_id, $bonus_type, null, $pagination );
        $this->set("matching_bonus_details", $matching_bonus_details);

		$countAndTotal = $this->bonus_model->getTotalCountBonus( $user_id, $bonus_type );

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/bonus/{$bonus_type}/",
			'total_rows' => $countAndTotal['max_num_pages']
		] );
		$this->set('offset_bonus', ++$pagination['offset'] );
		$this->set('total_amount', $countAndTotal['total_amount'] );
		$this->set('links', $links );
        $this->set("flag", $flag);
        $this->setView();
    }
    function fast_start_bonus() {

		$this->load->library('inf_pagination');
		$pagination = [];
		$pagination['limit'] = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}

       // $title = 'Fast Start Bonus';
        $title = $this->lang->line('fast_start_bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        $flag = "false";
        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $bonus_type = "fast_start_bonus";
        $this->set('user_name', $user_name);
        $matching_bonus_details = $this->bonus_model->getBonusDetails( $user_id, 'team_bonus', null, $pagination );
        $this->set("matching_bonus_details", $matching_bonus_details);

		$countAndTotal = $this->bonus_model->getTotalCountBonus( $user_id, 'team_bonus' );

		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/bonus/{$bonus_type}/",
			'total_rows' => $countAndTotal['max_num_pages']
		] );
		$this->set('offset_bonus', ++$pagination['offset'] );
		$this->set('total_amount', $countAndTotal['total_amount'] );
		$this->set('links', $links );
        $this->set("flag", $flag);
        $this->setView();
    }

    function bonus_from_start() {
        $title = 'Bonus From Start';
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $is_valid_username = false;
        $bonus_details='';
        $user_type = $this->LOG_USER_TYPE;
        
       if ($this->input->post('select')) {  
            
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);

            if ($user_id) {
                $is_valid_username = true;
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'bonus/bonus_from_start', false);
            }
        }
        $this->set('user_name', $user_name);
        $bonus_details = $this->bonus_model->getBonusDetails($user_id);
        
        $this->set('is_valid_username', $is_valid_username);
        $this->set("bonus_details", $bonus_details);
        
        $this->setView();
    }
    function bonus_this_week() {
        $title = 'Bonus This Day';
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $is_valid_username = false;
        $bonus_details='';
        $user_type = $this->LOG_USER_TYPE;
        
       if ($this->input->post('select')) {  
            
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);

            if ($user_id) {
                $is_valid_username = true;
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'bonus/bonus_from_start', false);
            }
        }
        $this->set('user_name', $user_name);
        $stage=$this->bonus_model->getLegAmountStage();
        $bonus_details = $this->bonus_model->getBonusDetails($user_id,'',$stage);
        
        $this->set('is_valid_username', $is_valid_username);
        $this->set("bonus_details", $bonus_details);
        
        $this->setView();
    }
    
    
}
