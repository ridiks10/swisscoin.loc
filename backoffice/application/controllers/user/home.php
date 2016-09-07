<?php

require_once 'Inf_Controller.php';

class Home extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
		$this->load->model('career_model');

        $title = $this->lang->line('dashboard');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "dashboard";
        $this->set("help_link", $help_link);

		$this->HEADER_LANG['page_top_header']       = lang( 'dashboard' );
		$this->HEADER_LANG['page_top_small_header'] = '';
		$this->HEADER_LANG['page_header']           = lang( 'dashboard' );
		$this->HEADER_LANG['page_small_header']     = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $prefix = str_replace('_', '', $table_prefix);
        $site_url = $this->home_model->getSiteUrl();
        //joining 
        $total_joining = $this->home_model->totalJoiningUsers($user_id);
        $todays_joining = $this->home_model->todaysJoiningCount($user_id);
        $firstline_count = $this->validation_model->getFirstLineCount($user_id);
//        ini_set('memory_limit', '-1');
          ini_set('xdebug.max_nesting_level', 200);
//        $secondline_count = $this->home_model->getDownlineCount($user_id);
        $secondline_count = $this->validation_model->getSecondLineCount($user_id);
//        $cash_account_sum = $this->home_model->getCashAccountSum($user_id);
//        $trading_account_sum = $this->home_model->getTradingAccountSum($user_id);

        //$total_tokens = $this->validation_model->getUserTotalTokens($user_id);
        $total_tokens = $this->validation_model->getUserResultTokens($user_id);

        
//        $e_wallet = $this->validation_model->getUserBalanceAmount($user_id);
        
        $cash_acc = $this->validation_model->getUserCashBalanceAmount($user_id);
        $trade_acc = $this->validation_model->getUserTradingBalanceAmount($user_id);

        $swiss_val = $this->validation_model->getColumnFromConfig('swisscoin_value');
        $split_val = $this->validation_model->getColumnFromConfig('splitindicator_value');

        $ac_level = $this->validation_model->getMaxAcademyLevel( $this->VIEW_DATA_ARR['email'] );
        $difficulty_level = $this->validation_model->getColumnFromConfig( 'ac_skg_v' );


		$allCareers  = $this->career_model->getAllCareers();
		$stat        = $this->career_model->getCarrerStat( $user_id );
		$user_bv     = $stat['aq_team_bv'];
		$user_career_id = $stat['career'];
		$user_career = 'NA';
		foreach ( $allCareers as $career ) {
			if ( $career['id'] == $user_career_id ) {
				$user_career = $career['leadership_rank'];
			}
		}


        $bonus_this_week = $this->home_model->getUserBonusThisWeek($user_id);
        $bonus_since_start = $this->home_model->getUserBonusSinceStart($user_id);
        //webinar

        $webinars = $this->home_model->getWebinarDetails();
        
        //workshop
        $workshop = $this->home_model->getWorkshopDetails();
        

        //ewallet
        $ewallet_status = $this->MODULE_STATUS['ewallet_status'];
        $total_amount = 0;
        $requested_amount = 0;
        $total_request = 0;
        $total_released = 0;
        if ($ewallet_status == 'yes') {
//            $total_amount = $this->home_model->getGrandTotalEwallet($user_id);
//            $requested_amount = $this->home_model->getTotalRequestAmount($user_id);
//            $total_request = $this->home_model->getGrandTotalEwallet($user_id);
//            $total_released = $this->home_model->getTotalReleasedAmount($user_id);
        }
        //epin
        $pin_status = $this->MODULE_STATUS['pin_status'];
        $total_pin = 0;
        $used_pin = 0;
        $requested_pin = 0;
        if ($pin_status == 'yes') {
            $total_pin = $this->home_model->getAllPinCount($user_id);
            $used_pin = $this->home_model->getUsedPinCount($user_id);
            $requested_pin = $this->home_model->getRequestedPinCount($user_id);
        }
        //mail
//        $read_mail = $this->home_model->getAllReadMessages('user');
//        $unread_mail = $this->home_model->getAllUnreadMessages('user');
//        $mail_today = $this->home_model->getAllMessagesToday('user');
        //chart
//        $joining_details_per_month = $this->home_model->getJoiningDetailsperMonth($user_id);
        //pie diagram
//        $payout_details = $this->home_model->getPayoutReleasePercentages($user_id);
//        $released_payouts_percentage = round($payout_details["released"], 2);
//        $pending_payouts_percentage = round($payout_details["pending"], 2);
        /////////////////////////////////////////////////////////////////////////////////////
//        $this->set("total_joining", $total_joining);
//        $this->set("todays_joining", $todays_joining);
//
//        $this->set("total_amount", $total_amount);
//        $this->set("requested_amount", $requested_amount);
//        $this->set("total_request", $total_request);
//        $this->set("total_released", $total_released);
//        $this->set("total_pin", $total_pin);
//        $this->set("used_pin", $used_pin);
//        $this->set("requested_pin", $requested_pin);
//        $this->set("read_mail", $read_mail);
//        $this->set("unread_mail", $unread_mail);
//        $this->set("mail_today", $mail_today);
//        $this->set("joining_details_per_month", $joining_details_per_month);
//
//        $this->set("released_payouts_percentage", $released_payouts_percentage);
//        $this->set("pending_payouts_percentage", $pending_payouts_percentage);
		$this->set('user_bv', $user_bv );
		$this->set('difficulty_level', $difficulty_level );
		$this->set('user_career', $user_career );
		$this->set('user_academy_level', $ac_level );

		$this->set('user_bv', $user_bv );
		$this->set('user_bv', $user_bv );

		$this->set('swiss_val', number_format($swiss_val, 4, ".", " ") );
		$this->set('split_val', $split_val );
        
        $this->set("bonus_since_start", number_format($bonus_since_start,2,"."," "));
        $this->set("bonus_this_week", number_format($bonus_this_week,2,"."," "));
//        $this->set("e_wallet", number_format($e_wallet,2,"."," "));
        $this->set("pinstatus", "NO");
        $this->set("user_id", $user_id);
        $this->set("table_prefix", $prefix);
        $this->set("site_url", $site_url);
        if ($webinars) {
            $this->set("webinar", $webinars[0]);
        }
        if ($workshop) {
            $this->set("workshop", $workshop[0]);
        }
        //video
        $this->load->model('video_model');
        $video = $this->video_model->getDashboardVideo();
        if ($video) {
            $this->set("video", $video);
        }
        $this->set("firstline_count", $firstline_count);
        $this->set("secondline_count", $secondline_count);
//        $this->set("secondline_count", $secondline_count);
//        $this->set("downline_count",floor($downline_count));
//        $this->set("cash_account_sum", number_format($cash_account_sum,2,"."," "));
//        $this->set("trading_account_sum", number_format($trading_account_sum,2,"."," "));
        
        $this->set("cash_wallet",  number_format($cash_acc,2,"."," "));
        $this->set("trade_wallet",  number_format($trade_acc,2,"."," "));
        
        $this->set("total_tokens", number_format($total_tokens,4,"."," "));
        $col_sm = 4;
        if ($ewallet_status == "no" && $pin_status == "no") {
            $col_sm = 6;
        } elseif ($ewallet_status == "no") {
            $col_sm = 4;
        } elseif ($pin_status == "no") {
            $col_sm = 4;
        } else {
            $col_sm = 3;
        }

        $this->load->model('news_model');
        $this->set('news', $this->news_model->getLatestNews($this->LOG_USER_ID));
        $this->load->model('profile_model');
        $kyc_status = $this->profile_model->getKYCStatus($user_id);
        if($kyc_status != 'approved'){
            $this->set('kyc_status', $kyc_status);
            $this->set('kyc_message', lang('kyc_' . $kyc_status));
        }

        $this->load->model('mining_tokens_model');
        $coins = $this->mining_tokens_model->getCoins($user_id);
        $this->set('coins', number_format($coins, 2, ".", " "));

        $this->set('base_url', base_url());
        $this->set("col_sm", $col_sm);
        $this->setView();
    }



      function live_ticker() {

        $base_url = base_url();

        $user_id = $this->LOG_USER_ID;
        $image_path = $base_url . 'public_html/images/';
        $users = $this->home_model->getLastRegistration($user_id);


        $res = '<marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();">';
        foreach ($users as $user) {
            $res.= ' <li style="float:left; margin-left: 0px; margin-right: 30px; list-style:none;"><img src="'.$image_path.'country_flags/'.strtolower($user['country_code']).'.png" width="25px"  />
              <b>' . strtoupper($user['user_name']) . '</b></br>
              <small style=" padding-left: 30px">' . $user['country_name'] . '</small></li>';
            
        }
        
        $res.= '</marquee>';
        echo $res;
        exit();
    }

}

?>
