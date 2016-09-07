<?php

require_once 'Inf_Controller.php';

class Home extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->model('career_model');
        $title = lang('dashboard');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "dashboard";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('dashboard');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('dashboard');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $prefix = str_replace('_', '', $table_prefix);
        $site_url = $this->home_model->getSiteUrl();
        $firstline_count = $this->validation_model->getFirstLineCount($user_id);
        $downline_count = $this->validation_model->getCountOfRegisteredUsers();
//        $secondline_count = $this->home_model->getAllSecondlineCount($user_id);
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

        $webinars = $this->home_model->getWebinarDetails();
        $workshop = $this->home_model->getWorkshopDetails();

//        $total_joining = $this->home_model->totalJoiningUsers();
//        $todays_joining = $this->home_model->todaysJoiningCount();

        $total_amount = 0;
        $requested_amount = 0;
        $released_amount = 0;
        $ewallet_status = $this->MODULE_STATUS['ewallet_status'];

        $total_pin = 0;
        $used_pin = 0;
        $requested_pin = 0;
        $pin_status = $this->MODULE_STATUS['pin_status'];

        $read_mail      = $this->home_model->getAllReadMessages( 'admin' );
        $unread_mail    = $this->home_model->getAllUnreadMessages( 'admin' );
        $mail_today     = $this->home_model->getAllMessagesToday( 'admin' );

        $this->set("pinstatus", "NO");

        if ($webinars) {
            $this->set("webinar", $webinars[0]);
        }
        if ($workshop) {
            $this->set("workshop", $workshop[0]);
        }
        $this->load->model('video_model');
        $video = $this->video_model->getDashboardVideo();
        if ($video) {
            $this->set("video", $video);
        }

        $this->load->model('mining_tokens_model');
        $coins = $this->mining_tokens_model->getCoins($user_id);
        $this->set('coins', number_format($coins, 2, ".", " "));


		$this->set('user_bv', $user_bv );
		$this->set('difficulty_level', $difficulty_level );
		$this->set('user_career', $user_career );
		$this->set('user_academy_level', $ac_level );

        $this->set("bonus_since_start",  number_format($bonus_since_start,2,"."," "));
        $this->set("bonus_this_week",  number_format($bonus_this_week,2,"."," "));
//        $this->set("e_wallet",  number_format($e_wallet,2,"."," "));
        $this->set('swiss_val', number_format($swiss_val, 4, ".", " ") );
        $this->set('split_val', $split_val );
        $this->set("cash_wallet",  number_format($cash_acc,2,"."," "));
        $this->set("trade_wallet",  number_format($trade_acc,2,"."," "));
        $this->set("user_id", $user_id);
        $this->set("table_prefix", $prefix);
        $this->set("site_url", $site_url);
        $this->set("firstline_count", $firstline_count);
        $this->set("downline_count", $downline_count);
//        $this->set("secondline_count", $secondline_count);
//        $this->set("cash_account_sum",  number_format($cash_account_sum,2,"."," "));
//        $this->set("trading_account_sum",  number_format($trading_account_sum,2,"."," "));
        $this->set("total_tokens", number_format($total_tokens,4,"."," "));

        $col_sm = 4;
        if ($ewallet_status == "no" && $pin_status == "no") {
            $col_sm = 6;
        } elseif ($ewallet_status == "no" && $pin_status == "yes") {
            $col_sm = 4;
        } elseif ($ewallet_status == "yes" && $pin_status == "no") {
            $col_sm = 4;
        } else {
            $col_sm = 3;
        }

        $this->set("col_sm", $col_sm);

        $this->setView();
    }

    /**
     * @deprecated 1.21 This moved to separate Ajax controller
     */
    public function get_notifications() {
        log_message('error', "home->get_notifications() :: Deprecated call");
        $notifications = $this->home_model->getNotifications();

        echo json_encode($notifications);
        exit();
    }

    function live_ticker() {

        $base_url = base_url();

        $user_id = $this->LOG_USER_ID;
        $image_path = $base_url . 'public_html/images/';
        $users = $this->home_model->getLastRegistration($user_id);


        $res = '<marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();">';
        foreach ($users as $user) {
            $res.= ' <li style="float:left; margin-left: 0px; margin-right: 30px; list-style:none;"><img src="' . $image_path . 'country_flags/' . strtolower($user['country_code']) . '.png" width="25px"  />
              <b>' . strtoupper($user['user_name']) . '</b></br>
              <small style=" padding-left: 30px">' . $user['country_name'] . '</small></li>';
        }

        $res.= '</marquee>';
        echo $res;
        exit();
    }
    
}
