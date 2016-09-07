<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Inf_Controller.php';

/**
 * @property cron_model $cron_model
 */
class cron extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->cron_model = new cron_model();
    }

    function generate_backup() {
        $this->load->model('backup_model', '', TRUE);
        $this->backup_model->generateBackup();
    }

    public function update_purchase() {
        if(!$this->cron_model->haveCronHour('update_purchase')){
            $cron_id = $this->cron_model->insertCronHistory('update_purchase');
            $this->load->model('user_balance_amount_model');
            $ordersCount = $this->user_balance_amount_model->processNewOrders();
            $this->cron_model->updateCronHistory($cron_id, "finish ($ordersCount)");
        }
    }

    public function bonus_daycalculation() {

        $haveStartedCronInDay = $this->cron_model->haveStartedCronInDay('bonus_calculation');

        if (!$haveStartedCronInDay) {

            ini_set('max_execution_time', 60 * 60);

            $this->load->model('user_balance_amount_model');
            $this->load->model('career_model');
            $this->load->model('leg_amount_model');

            $cron_id = $this->cron_model->insertCronHistory('bonus_calculation');

            #Process orders with status = 0
            $ordersCount = $this->user_balance_amount_model->processNewOrders();

            #Update career for users who aq_team_bv was increased
            $careerCount = $this->career_model->updateCareers();

            $stage = $this->cron_model->getLegAmountStage() + 1;

            #process bonuses
            $directAndMatchingCounts = $this->leg_amount_model->processDirectAndMatchingBonus($cron_id, $stage);
            $teamCount = $this->leg_amount_model->processTeamBonus($cron_id, $stage);

            $this->cron_model->updateCronHistory($cron_id, "success ($ordersCount / {$directAndMatchingCounts['direct']} / {$directAndMatchingCounts['matching']} / $teamCount / $careerCount)");
        }
        return 1;
    }

    public function fast_start_bonus($init) {

        $haveStartedCronInDay = $this->cron_model->haveStartedCronInDay('fast_start_bonuses');

        if(!$haveStartedCronInDay){

            ini_set('max_execution_time', 60 * 60);

            $cron_id = $this->cron_model->insertCronHistory('fast_start_bonuses');
            $this->load->model('leg_amount_model');
            $init = ($init == 'init');
            $status = $this->leg_amount_model->processFSB($init);

            $this->cron_model->updateCronHistory($cron_id, $status);
        }

        return;
    }

    public function rank_bonus() {

        $haveCronInDay = $this->cron_model->haveStartedCronInDay('rank_bonuses');

        if(!$haveCronInDay){

            ini_set('max_execution_time', 60 * 60);

            $cron_id = $this->cron_model->insertCronHistory('rank_bonuses');
            $this->load->model('leg_amount_model');
            $status = $this->leg_amount_model->processRankBonus();

            $this->cron_model->updateCronHistory($cron_id, $status);
            echo $status;
        }

        return;
    }

    public function diamond_pool()
    {
        if ($this->cron_model->DiamondPoolStarted() !== false) {
            die('Diamond pool already calculated');
        }
        
        $this->load->model('order_history_model');
        $this->load->model('ft_individual_model');
        $this->load->model('leg_amount_model');
        $this->load->model('diamond_bonuses_model');
        //recalc careers so there won't be any strange ranks
        $this->career_update();
        
        $stage = $this->cron_model->getLegAmountStage();
        $world_commission = $this->order_history_model->getWorldwideYield() * $this->settings_model->getDPCommission() / 100;
        $cron_id = $this->cron_model->insertCronHistory('diamond_pool');
        
        $users = $this->ft_individual_model->getDiamondUsers();
        $sharesum = array_sum(array_column($users, 'share'));
        $shareval = round($world_commission / $sharesum, 2);
        foreach ($users as $user) {
            try {
                $leg_id = $this->leg_amount_model->insertDiamondPoolBonus($user['id'], $user['share'], $shareval, $stage);
                $this->diamond_bonuses_model->insertBonus($user['id'], $world_commission, $shareval, $user['share'], $cron_id, $leg_id);
            } catch (Exception $ex) {
                // display error message no additional logging needed
                $this->cron_model->updateCronHistory($cron_id, 'ERROR');
                echo 'ERROR!';
                die;
            }
        }
        
        $this->cron_model->updateCronHistory($cron_id, 'SUCCESS');

        return;
    }

    public function career_achivers() {

        $this->db->trans_start();
        $cron_id4 = $this->cron_model->insertCronHistory('diamond_pool');

        $details = $this->cron_model->getUserIdandTeamBV();
        $tb_status = false;
        if ($details) {
            foreach ($details as $user) {

                if ($user['aq_team_bv'] > 0) {

                    if ($user['aq_team_bv'] >= 4) {
//                      $team_bv = 100000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 2;
                        $first_line_number = 1;
                        $commission = 1;
                    } elseif ($user['career'] == 5) {
//                      $team_bv = 250000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 3;
                        $first_line_number = 1;
                        $commission = 2;
                    } elseif ($user['career'] == 10) {
//                      $team_bv = 500000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 4;
                        $first_line_number = 1;
                        $commission = 3;
                    } elseif ($user['career'] == 11) {
//                      $team_bv = 1000000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 4;
                        $first_line_number = 2;
                        $commission = 4;
                    } elseif ($user['career'] == 12) {
//                      $team_bv = 5000000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 4;
                        $first_line_number = 5;
                        $commission = 5;
                    } elseif ($user['career'] == 6) {
//                      $team_bv = 10000000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 4;
                        $first_line_number = 10;
                        $commission = 6;
                    } elseif ($user['career'] == 7) {
//                      $team_bv = 50000000;
                        $team_bv = $user['qualifying_personal_pv'];
                        $first_line_career = 4;
                        $first_line_number = 20;
                        $commission = 7;
                    }


                    $tb_status = $this->cron_model->getDiamondCommissionStatus($user['id'], $team_bv, $first_line_career, $first_line_number);
                    if ($tb_status) {

                        $res = $this->cron_model->distributeDiamondPoolBonus($user['id'], $amount, $bonus_type, $stage);
                    }
                }
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $status = 'fail';
        } else {
            $this->db->trans_complete();
            $status = 'success';
        }
        $this->cron_model->updateCronHistory($cron_id4, $status);
        return;
    }

    public function userbalence_absent() {
        $cron_id4 = $this->cron_model->userbalence_absent();
    }
    public function bonus_distrb() {
        $cron_id4 = $this->cron_model->bonus_distrb();
    }


    
    public function career_update ($output = '')
    {
		$this->load->model('ft_individual_model');
		$this->load->model('career_model');
       // $this->ft_individual_model->discardCareer();
        $users = $this->career_model->career_list();
        $conditions = $this->career_model->getCareersCondition();
        $limit = 0;
        foreach ($users as $user) {
            $limit++;
			if( $limit < 100 )
				continue;
			if( $limit > 1000 )
				break;
            $this->career_model->_career_distrb($user, $conditions, $output === 'output');
        }
    }


    /**
     * @deprecated Function is not relevant
     * @throws Exception
     */
    public function _recalculate()
    {
        /*
UPDATE `55_order_history` SET `status` = 1 WHERE `status` > 1;
UPDATE `55_user_balance_amount` SET `status` = 0;
DELETE FROM `55_cron_history` WHERE `cron` = 'recalculate';
         */
        $limit = 900;
        ini_set('max_execution_time', $limit);
        
        $this->load->model('user_balance_amount_model');
        $num = $this->cron_model->haveCron('recalculate');
        if (!$num) {
            $this->cron_model->insertCronHistory('recalculate');
            $this->cron_model->prepareTables();
            $this->user_balance_amount_model->prepareBalanceToRecalc();
        }
        $start = time();
//        $limit = ini_get('max_execution_time');
//        var_dump($start, $limit);
        $this->load->model('order_history_model');
        $this->load->model('fund_transfer_details_model');
        $this->load->model('ewallet_payment_details_model');
        $this->load->model('payout_release_requests_model');
        $this->load->model('ft_individual_model');
        $this->load->model('leg_amount_model');
        $this->load->model('career_model');
        $day = $this->order_history_model->getPendingOrderDay();
        
        while (!empty($day)) {
            $doDay = true;
            echo '<br><br>day(' . $day . ') start at : ' . date('H:i:s');
            if ($limit && time() - $start > $limit - 15) {
                log_message('warning', 'Script took too long need to continue further');
                echo '<p style="color: red;">UPDATE INCOMPLETE rerun script again please</p>';
                exit;
            }
            $this->db->trans_start();

            $orders = $this->order_history_model->getOrdersByDay($day);
            if (count($orders) > 200 && time() - $start > $limit - 180) {
                log_message('warning', 'Script took too long need to continue further');
                echo '<p style="color: red;">UPDATE INCOMPLETE Day update will take longer than available. Rerun script again please</p>';
                $this->db->trans_rollback();
                exit;
            }
            foreach ($orders as $order) {
                try {
                    $this->user_balance_amount_model->calculateBVIncome($order['user_id'], $order['bv'], $order['id'], 3);
                    $this->user_balance_amount_model->selfBVCalculate($order['user_id'], $order['bv'] * $order['quantity']);
                    $this->ft_individual_model->updateProduct($order['user_id'], $order['package']);
                } catch (Exception $e) {
                    log_message('error', $e->getMessage());
                    $this->db->trans_rollback();
                    show_error($e->getMessage(), 500);
                }
            }
            $direct_bonus = $this->cron_model->getDirectBonusPercentage();
            $stage = $this->cron_model->getLegAmountStage();
            $users = $this->cron_model->getAchiversList();

            $stage+=1;
            echo '<br>AchiversList: (' . count($users) . ')';
            foreach ($users as $user) {
                if ($limit && time() - $start > $limit - 15) {
                    log_message('warning', 'Script took too long need to continue further');
                    echo '<p style="color: red;">UPDATE INCOMPLETE rerun script again please</p>';
                    $this->db->trans_rollback();
                    exit;
                }
                try {
                    // direct_bonus + matching bonus 
                    if ($user['first_line_weekly_bv'] > 0) {
                        $amount = ($user['first_line_weekly_bv'] * $direct_bonus) / 100;
                        $this->leg_amount_model->processDirectAndMatchingBonus($user['user_id'], $amount, $stage, $day, true);
//                        $res = $this->cron_model->distributeDirectBonus($user['user_id'], $amount, $bonus_type, $stage, '', $day . ' 00:00:01');
    //                    echo '<br>AFTER::distributeDirectBonus: ' . $user['user_id'] . ' ( ' . $amount . ' ) -> ' . $bonus_type;
                    }
                    //team_bonus
                    $downline_spend = 0;
                    if ($user['week_team_bv'] > 0) {
                        $this->leg_amount_model->insertTeamBonus($user['user_id'], $user['aq_team_bv'], $user['week_team_bv'], $stage, $day, true);
                    }

                    $this->cron_model->resetWeekBv($user['user_id']);
                    //broken atm -- wrong $downline_spend
                    $this->cron_model->insertCommissionHistory($user['user_id'], $user['first_line_weekly_bv'], $user['week_team_bv'], $user['aq_team_bv'], $downline_spend, $day . ' 00:00:01');
                } catch (Exception $e) {
                    log_message('warning', 'Script took too long need to continue further');
                    $this->db->trans_rollback();
                    show_error($e->getMessage(), 500);
                }
            }
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception('Was not able to update BV for day(' . $day . ')');
            } else {
                $this->db->trans_complete();
            }

            $day = $this->order_history_model->getPendingOrderDay();
        }
        if (!empty($doDay)) {
            echo '<p style="color: red;">UPDATE INCOMPLETE rerun script again please</p>';
            exit;
        }
        
        $last_user = $this->user_balance_amount_model->getLastUserWithStatus(4);
        
        $credit = $this->fund_transfer_details_model->getUsersCredit(true, $last_user);
        $debit = $this->fund_transfer_details_model->getUsersDebit(true, $last_user);
        $payout = $this->payout_release_requests_model->getUsersPayouts($last_user);
        $purchase = $this->ewallet_payment_details_model->getUsersSpend($last_user);
        $total = array_keys($credit + $debit + $payout + $purchase);
        sort($total);
        
        echo '<br>Calculate credit/debit: (' . count($total) . ') entries';
        // Look for strange differences in account balances
        //SELECT `user_id`, `balance_amount`, `cash_account`, `trading_account` FROM `55_user_balance_amount` WHERE (`balance_amount` = 0 AND (`cash_account` != 0 OR `trading_account` != 0)) OR (`cash_account` = 0 AND (`balance_amount` != 0 OR `trading_account` != 0)) OR (`trading_account` = 0 AND ((`cash_account` != 0 OR `balance_amount` != 0) AND `cash_account` != `balance_amount`))
        
        foreach ($total as $i => $user) {
            $this->db->trans_start();
            
            if ($limit && time() - $start > $limit - 15) {
                log_message('warning', 'Script took too long need to continue further');
                echo '<p style="color: red;">UPDATE INCOMPLETE fund transfer proccessed (' . ($i) . ') entries. rerun script again please</p>';
                exit;
            }
            $c = isset($credit[$user]) ? $credit[$user] : 0;
            $d = isset($debit[$user]) ? $debit[$user] : 0;
            $p = isset($payout[$user]) ? $payout[$user] : 0;
            $pc = isset($purchase[$user]['cash']) ? $purchase[$user]['cash'] : 0;
            $pt = isset($purchase[$user]['trading']) ? $purchase[$user]['trading'] : 0;
            $amount = $cash = $c - $d - $p - $pc;
            $trading = $pt * -1;
            echo '<br>user(' . $user . ')->amount(' . $amount . '); cash(' . $cash . '); trading(' . $trading . ')';
            try {
                $this->user_balance_amount_model->updateAccounts($user, $amount, $cash, $trading, 4);
            } catch (Exception $e) {
                log_message('error', $e->getMessage());
                $this->db->trans_rollback();
                show_error($e->getMessage(), 500);
            }
            
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                throw new Exception('Was not able to update users fund transfers');
            } else {
                $this->db->trans_complete();
            }
        }

        $seconds = time() - $start;
        echo 'User calculation lasted: ' . round($seconds / 60) . ':' . $seconds % 60;

        echo '<br>Calculate career';
        $users = $this->career_model->career_list();
        $conditions = $this->career_model->getCareersCondition();
        
        if ($limit && time() - $start > $limit - 30) {
            log_message('warning', 'Script took too long need to continue further');
            echo '<p style="color: red;">UPDATE INCOMPLETE career update required. rerun script again please</p>';
            exit;
        }
        
        foreach ($users as $user) {
            $this->career_model->_career_distrb($user, $conditions);
        }
        
        echo '<p class="recalculate-complete" style="color: green;">UPDATE COMPLETE</p>';

        $this->order_history_model->markAllOrder(1);
        $this->user_balance_amount_model->recalcDone();
        $this->cron_model->updateRecalcCronHistory('bonus_calculation');
    }

    public function _fixminus()
    {
        try {
            $this->load->model('user_balance_amount_model');
            $this->load->model('fund_transfer_details_model');
            $this->load->model('ewallet_payment_details_model');
            foreach ($this->user_balance_amount_model->getMinusAccount('cash') as $entry) {
                $this->fund_transfer_details_model->minusCredit($entry['user_id'], $entry['amount'], 'credit minus');
            }
            foreach ($this->user_balance_amount_model->getMinusAccount('trading') as $entry) {
                $this->ewallet_payment_details_model->minusCreditTrading($entry['user_id'], $entry['amount']);
            }
            echo '<p style="color: green;">FIX MINUS COMPLETE</p>';
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            echo '<p style="color: red;">ERROR WHILE UPDATE</p>';
        }
    }

    public function _fixpurchases()
    {
        $this->load->model('user_balance_amount_model');
        $this->load->model('ewallet_payment_details_model');
        $purchase = $this->ewallet_payment_details_model->getUsersSpend();
        foreach ($purchase as $user => $data) {
            $pc = isset($data['cash']) ? $data['cash'] : 0;
            $pt = isset($data['trading']) ? $data['trading'] : 0;
            $amount = $cash = $pc * -1;
            $trading = $pt * -1;
            $this->user_balance_amount_model->updateAccounts($user, $amount, $cash, $trading);
        }
    }
    
    public function recalcauto()
    {
        echo 
'<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<title>Automated recalculation script</title>
<link rel="stylesheet" href="' . base_url() . 'public_html/plugins/bootstrap/css/bootstrap.min.css" media="screen">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="' . base_url() . 'public_html/javascript/autorecalc.js" type="text/javascript"></script>
<script> var ajaxurl = "' . base_url() . 'admin/cron/recalculate"</script>
</head>
<body>
<h1>Recalculation script</h1>
<button id="run"> Run script</button>
<div id="result-container"></div>
</body>
</html>
';
    }

    public function fixUserAccountsProcess(){
        $done = (int)$this->input->get('done');
        $this->load->model('ewallet_model');
        $this->load->model('fund_transfer_details_model');
        $this->load->model('trading_model');
        $this->load->model('ewallet_payment_details_model');
        $result = ['force_finish' => false];
        if(!$this->db->field_exists('is_fixed', 'user_balance_amount')) {
            $this->db->query('ALTER TABLE `55_user_balance_amount` ADD `is_fixed` BOOLEAN NOT NULL DEFAULT FALSE AFTER `downline_spend`');
        }
        $query = $this->db->from('user_balance_amount')
            ->or_where('( balance_amount != ', 0)
            ->or_where('cash_account != ', 0)
            ->or_where('trading_account != ', 0)
            ->or_where('tokens != ', 0)
            ->or_where('bv != ', 0)
            ->or_where('aq_team_bv != ', 0)
            ->or_where('week_team_bv != ', 0)
            ->or_where('first_line_aq_bv != ', 0)
            ->or_where('first_line_weekly_bv != 0 )')
            ->where('is_fixed = ', 0);
        if($done == 0){
            $query_total = clone $query;
            $result['total'] = $query_total->get()->num_rows();
        }else{
            $result['total'] = (int)$this->input->get('total');
        }
        $user_accounts = $query->get('', 1000, $done)->result_array();
        if(count($user_accounts) == 0){
            $result['force_finish'] = true;
            $result['done'] = $result['total'];
            die(json_encode($result));
        }
        $start = time();
        $limit = 5;
        foreach ($user_accounts as $user_account) {
            $user_id = $user_account['user_id'];

//            $epsilon = 0.00001;

//            $cash_account_dashboard = (double)$user_account['cash_account'];
            $cash_ewallet_amount = (double)$this->ewallet_model->getCommission($user_id, Date('Y-m-d', strtotime($this->ewallet_model->getJoiningDate($user_id))), Date('Y-m-d'));
            if($cash_ewallet_amount < 0){
                $this->fund_transfer_details_model->minusCredit($user_id, abs($cash_ewallet_amount), 'credit minus');
//                $cash_ewallet_amount = 0;
            }

//            $is_equal = abs($cash_account_dashboard - $cash_ewallet_amount) < $epsilon ;
            /*if(!$is_equal){
                $this->db->update('user_balance_amount', ['cash_account' => $cash_ewallet_amount], ['user_id' => $user_id]);
            }*/

//            $trading_account_dashboard = (double)$user_account['trading_account'];
            $trading_ewallet_amount = (double)$this->trading_model->getCommission($user_id, Date('Y-m-d', strtotime($this->trading_model->getJoiningDate($user_id))), Date('Y-m-d'));
            if($trading_ewallet_amount < 0){
                $this->ewallet_payment_details_model->minusCreditTrading($user_id, abs($trading_ewallet_amount));
//                $trading_ewallet_amount = 0;
            }

//            $is_equal = abs($trading_account_dashboard - $trading_ewallet_amount) < $epsilon ;
            /*if(!$is_equal){
                $this->db->update('user_balance_amount', ['trading_account' => $trading_ewallet_amount], ['user_id' => $user_id]);
            }*/
            $done++;
            $this->db->update('user_balance_amount', ['is_fixed' => 1], ['user_id' => $user_id]);
            if(time() > $start + $limit){
                $result['done'] = $done;
                die(json_encode($result));
            }
        }
        $result['done'] = $done;
        die(json_encode($result));
    }

    public function fixUserAccountsRestart(){
        $result = $this->db->update('user_balance_amount', ['is_fixed' => 0]);
        die(json_encode(['status'=>$result]));
    }

    public function fixUserAccounts(){
        $this->cronInterface('Fix minus user accounts (cash and trading)', 'fixUserAccounts.js', 'fixUserAccountsProcess', true);
    }
    private function cronInterface($title, $script_name, $cron_function, $with_restart = false)
    {
        echo
'<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title>'.$title.'</title>
        <link rel="stylesheet" href="' . base_url() . 'public_html/plugins/bootstrap/css/bootstrap.min.css" media="screen">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="' . base_url() . 'public_html/javascript/'. $script_name  .'" type="text/javascript"></script>
        <script> var ajaxurl = "' . base_url() . 'admin/cron/' . $cron_function  . ($with_restart ? '", restarturl = "'. base_url()  .'admin/cron/fixUserAccountsRestart"' : '' ) . '";</script>
    </head>
    <body class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>'.$title.'</h1>
                <hr>
                <button id="run" class="btn btn-primary">Run script</button>
                <button id="stop" class="btn btn-danger" style="display:none;">Stop script</button>
                <hr> ' . ($with_restart ?
                '<button id="restart" class="btn btn-warning">Restart (reset)</button>
                <hr>' : '' ) .
                '<p style="margin-top:10px">State: <span id="state">waiting for action...</span></p>
                <p style="margin-top:10px"><span id="done">0</span> / <span id="total">0</span></p>
                <hr>
                <div style="margin-top:10px" class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width:0%;">
                    </div>
                </div>
                <div id="result" style="margin-top:10px">
                </div>
            </div>
        </div>
    </body>
</html>
';
    }

    function recalculate_from(){
        $this->cronInterface('Recalculate BV and tokens from 22/7/16', 'fixUserAccounts.js', 'recalculate_from_process', false);
    }
    function recalculate_from_process(){
        $done = (int)$this->input->get('done');
        $this->load->model('user_balance_amount_model');
        $this->load->model('order_history_model');

        $result = ['force_finish' => false];
        if($done == 0){
            $result['total'] = $this->db->select('*')->where('status', 0)->get('order_history')->num_rows();
        }else{
            $result['total'] = (int)$this->input->get('total');
        }
        $orders = $this->db->select('*')->where('status', 0)->get('order_history', 500)->result_array();
        if(count($orders) == 0){
            $result['force_finish'] = true;
            $result['done'] = $result['total'];
            die(json_encode($result));
        }
        $start = time();
        $limit = 15;
        foreach ($orders as $order) {
            $res = 1;
            try {
                $this->db->trans_start();
                $res &= $this->user_balance_amount_model->updateSelfTokens($order['user_id'], $order['token'] * $order['quantity']);
                $res &= $this->user_balance_amount_model->updateSelfBV($order['user_id'], $order['bv'] * $order['quantity']);
                $res &= $this->user_balance_amount_model->updateParentsBV($order['user_id'], $order['bv'] * $order['quantity'], $order['order_id']);
                $res &= $this->order_history_model->markOrder($order['id']);
                $done++;

            } catch (Exception $e) {
                log_message('error', $e->getMessage());
                $this->db->trans_rollback();
                show_error($e->getMessage(), 500);
            }

            if ($this->db->trans_status() === FALSE || !$res) {
                $this->db->trans_rollback();
                throw new Exception('Was not able to update pending BV');
            } else {
                $this->db->trans_complete();
            }

            if(time() > $start + $limit){
                $result['done'] = $done;
                die(json_encode($result));
            }

        }
        $result['done'] = $done;
        die(json_encode($result));
    }

    public function fixaccountfrom($restart = false)
    {
        if ('restart' == $restart) {
//            $this->db->update('user_balance_amount', ['is_fixed' => 0]);
        }
        $this->cronInterface('Fix minus user accounts (cash and trading) by 2016-08-10', 'fixUserAccounts.js', 'fixminusbydate', false);
    }
    
    public function fixminusbydate()
    {        
        $done = (int)$this->input->get('done');
        $this->load->model('ewallet_model');
        $this->load->model('fund_transfer_details_model');
        $this->load->model('trading_model');
        $this->load->model('ewallet_payment_details_model');
        $result = ['force_finish' => false];
        if (!$this->db->field_exists('is_fixed', 'user_balance_amount')) {
            $this->db->query('ALTER TABLE `55_user_balance_amount` ADD `is_fixed` BOOLEAN NOT NULL DEFAULT FALSE AFTER `downline_spend`');
        }
        $query = $this->db->from('user_balance_amount as ub')
            ->or_where('( balance_amount != ', 0)
            ->or_where('cash_account != ', 0)
            ->or_where('trading_account != ', 0)
            ->or_where('tokens != ', 0)
            ->or_where('bv != ', 0)
            ->or_where('aq_team_bv != ', 0)
            ->or_where('week_team_bv != ', 0)
            ->or_where('first_line_aq_bv != ', 0)
            ->or_where('first_line_weekly_bv != 0 )')
            ->where('is_fixed = ', 0);
        if ($done == 0) {
            $query_total = clone $query;
            $result['total'] = $query_total->select('COUNT(*) as count')->get()->row()->count;
        } else {
            $result['total'] = (int)$this->input->get('total');
        }
        $user_accounts = $query->select('ub.user_id, ft.date_of_joining as joindate')->join('ft_individual AS ft', 'ft.id = ub.user_id')->get('', 1000)->result_array();
        if(count($user_accounts) == 0){
            $result['force_finish'] = true;
            $result['done'] = $result['total'];
            die(json_encode($result));
        }
        $start = time();
        $limit = 5;
        foreach ($user_accounts as $user_account) {
            $user_id = $user_account['user_id'];

            $cash_amount = round((float)$this->ewallet_model->getCommission($user_id, DateTime::createFromFormat('Y-m-d H:i:s', $user_account['joindate'])->format('Y-m-d'), '2016-08-09'), 2);
            if($cash_amount < 0){
                $this->fund_transfer_details_model->minusCredit($user_id, abs($cash_amount), 'credit minus', '2016-08-10 00:00:00');
            }

            $trading_amount = round((float)$this->trading_model->getCommission($user_id, DateTime::createFromFormat('Y-m-d H:i:s', $user_account['joindate'])->format('Y-m-d'), '2016-08-09'), 2);
            if($trading_amount < 0){
                $this->ewallet_payment_details_model->minusCreditTrading($user_id, abs($trading_amount), '2016-08-10 00:00:00');
            }
//            log_message('error', "USER: {$user_id}; CASH: {$cash_amount}; TRADING: {$trading_amount}");

            $this->db->update('user_balance_amount', ['is_fixed' => 1], ['user_id' => $user_id]);
            if(time() > $start + $limit){
                $result['done'] = $done;
                die(json_encode($result));
            }
            $done++;
        }
        $result['done'] = $done;
        die(json_encode($result));
    }
    
}
