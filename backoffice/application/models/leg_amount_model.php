<?php

/**
 * @since 1.21 remove fields for deleted DB columns
 * 
 * @property  income_bv_history_model $income_bv_history_model
 * @property  user_balance_amount_model $user_balance_amount_model
 * @property  ft_individual_model $ft_individual_model
 * @property  calculation_model $calculation_model
 * @property  settings_model $settings_model
 * @property  career_model $career_model
 * @property  cron_model $cron_model
 * @property  direct_bonuses_model $direct_bonuses_model
 * @property  team_bonuses_model $team_bonuses_model
 */
class leg_amount_model extends inf_model {

    private $_table = 'leg_amount';

    private $_defaults = [
        'product_value' => 0,
        'oc_order_id' => 0,
        'pair_value' => '',
    ];

    private $_matching_level;
    private $_direct;
    private $_team_level = [];
    private $_fsb_settings = [];
    private $_rank_bonus_settings = [];

    public function __construct()
    {
        if (empty($this->user_balance_amount_model)) {
            $this->load->model('user_balance_amount_model');
        }
        if (empty($this->ft_individual_model)) {
            $this->load->model('ft_individual_model');
        }
        if (empty($this->settings_model)) {
            $this->load->model('settings_model');
        }
        if (empty($this->calculation_model)) {
            $this->load->model('calculation_model');
        }

        $this->load->model('career_model');

        $config_details = $this->settings_model->getSettings();
        $this->_direct = $config_details['db_percentage'];
        foreach ($this->db->get('level_commision')->result_array() as $d) {
            $this->_matching_level[$d['level_no']] = $d['level_percentage'];
        }
        foreach (['tb_10000000', 'tb_5000000', 'tb_1000000', 'tb_500000', 'tb_250000', 'tb_100000', 'tb_50000', 'tb_25000', 'tb_10000', 'tb_5000', 'tb_1000'] as $key) {
            $this->_team_level[substr($key, 3)] = $config_details[$key];
        }
        $this->_fsb_settings = $this->settings_model->getFSBSettings();
        $this->_rank_bonus_settings = $this->career_model->getAllCareers();
    }

    protected function teamBonus($amount)
    {
        foreach ($this->_team_level as $key => $value) {
            if (intval($key) <= $amount) return (float)$value;
        }
        return .0;
    }
    public function getDirectBonusPercentage() {
        return $this->db
            ->select('db_percentage')
            ->get('configuration')
            ->first_row()
            ->db_percentage;
    }


    /**
     *
     * @since 1.16 Now return id of insert row
     * 
     * @param int $user User id
     * @param array $array data to insert
     * @return bool|int Record id or false if error occurs
     * @throws Exception on update error
     */
    public function insertData($user, array $array)
    {
        $data = array_merge($array, ['user_id' => $user]);

        $round = ['total_amount', 'amount_payable', 'product_value', 'cash_account', 'trading_account'];
        foreach ($data as $key => &$value) {
            if (in_array($key, $round)) {
                $value = round($value, 2);
            }
        }
        $this->db->set($data);

        try {
            if ($this->db->insert($this->_table)) {
                return $this->db->insert_id();
            } else {
                throw new Exception('Unable insert leg amount');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     *
     * @param int $user user to receive direct bonus
     * @param int $amount initial bonus sum
     * @param int $stage ???
     * @param string|null $day treat transaction as on this date, today or null
     * @param bool $output display commentary
     * @return boolean whether ok with matching update
     * @throws Exception on update error
     */
    public function insertDirectBonus($user, $amount, $stage, $day = null, $output = false)
    {
        if (empty($amount)) {
            return false;
        }
        if ($output) echo '<br><span style="color:purple">user(' . $user . ')</span>';

        $amount_payable = $amount;

        $this->load->model('income_bv_history_model');
        $this->load->model('cron_model');

        try {

            $direct_bonus_percent = (double)$this->cron_model->getDirectBonusPercentage() / 100;
            $bv_income_history = $this->income_bv_history_model->getByRecipientAndType($user, 'first_line');

            foreach ($bv_income_history as $item) {

                $amount_payable = $item['amount'] * $direct_bonus_percent;

                $cash_amount = $amount_payable * 0.6;
                $trade_amount = $amount_payable * 0.4;

                $data = array_merge([
                    'from_id' => $item['user_id_source'],
                    'user_level' => 0,
                    'total_amount' => 0,
                ], [
                    'amount_payable' => $amount_payable,
                    'cash_account' => $cash_amount,
                    'trading_account' => $trade_amount,
                    'amount_type' => 'direct_bonus',
                    'product_value' => $amount,
                    'total_amount' => $amount,
                    'stage' => $stage,
                    'date_of_submission' => empty($day) ? date('Y-m-d H:i:s') : $day . ' 00:00:01'
                ]);
                if ($this->insertData($user, $data)) {
                    if ($output) echo '::receive <span style="color:green">direct</span>(' . $amount . ')';
                    $this->insertMatchingBonus($user, $user, $amount_payable, $stage, 1, $day, $output);
                } else {
                    if ($output) echo '::error update <span style="color:red">direct</span>(' . $amount . ')';
                }
            }


            $this->cron_model->resetWeekFirstLineBv($user);

        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            throw $e;
        }
        return true;
    }

    /**
     *
     * @param $cron_id
     * @param $stage
     * @return bool whether ok with matching update
     * @throws Exception on update error
     */
    public function processDirectAndMatchingBonus($cron_id, $stage)
    {
        $this->load->model('direct_bonuses_model');

        $direct_bonus_percent = (double)$this->getDirectBonusPercentage() / 100;

        $rows = $this->direct_bonuses_model->getNew();

        $directCount = $matchingCount = 0;

        foreach ($rows as $row) {

            try {

                $this->db->trans_start();

                $amount_payable = $row['bv_amount'] * $direct_bonus_percent;

                $cash_amount = $amount_payable * 0.6;
                $trade_amount = $amount_payable * 0.4;

                $data = [
                    'from_id' => $row['user_id_source'],
                    'amount_payable' => $amount_payable,
                    'cash_account' => $cash_amount,
                    'trading_account' => $trade_amount,
                    'amount_type' => 'direct_bonus',
                    'product_value' => $amount_payable,
                    'total_amount' => $amount_payable,
                    'stage' => $stage,
                    'date_of_submission' => date('Y-m-d H:i:s')
                ];

                $leg_amount_id = $this->insertData($row['user_id_recipient'], $data);

                $directCount++;

                $matchingCount += $this->insertMatchingBonus($row['user_id_source'], $row['user_id_recipient'], $amount_payable, $stage, 1);


                $this->direct_bonuses_model->updateAfterProcessing($row['id'], $cron_id, $amount_payable, $leg_amount_id);

                $this->db->trans_complete();

            } catch (Exception $e) {
                $this->db->trans_rollback();
                log_message('error', $e->getMessage());
                throw $e;
            }
        }
        return [
            'direct' => $directCount,
            'matching' => $matchingCount
        ];
    }

    /**
     *
     * @param int $child user that receive direct bonus
     * @param int $user beneficiare
     * @param float $amount initial bonus sum
     * @param int $stage
     * @param int $level level of $child relative to $user
     * @param int $count
     * @return bool whether ok with matching update
     * @throws Exception on update error
     */
    public function insertMatchingBonus($child, $user, $amount, $stage, $level, $count = 0)
    {
        if (empty($amount) || $level > 11) {
            return $count;
        }

        try {

            $father = $this->ft_individual_model->getFather($user);

            if ($father) {
                $mb_status = $this->calculation_model->getMatchingBonusStatus($father);
                if ($mb_status) {
                    $bonus = $amount * ($this->_matching_level[$level] / 100);
                    $amount_payable = $bonus;

                    $cash_amount = $amount_payable * 0.6;
                    $trade_amount = $amount_payable * 0.4;

                    $this->insertData($father, [
                        'from_id' => $child,
                        'date_of_submission' => empty($day) ? date('Y-m-d H:i:s') : $day . ' 00:00:01',
                        'amount_payable' => $amount_payable,
                        'cash_account' => $cash_amount,
                        'trading_account' => $trade_amount,
                        'amount_type' => 'matching_bonus',
                        'total_amount' => $bonus,
                        'user_level' => $level,
                        'product_value' => $amount,
                        'stage' => $stage,
                    ]);
                    $count++;
                }

                $count = $this->insertMatchingBonus($child, $father, $amount, $stage, $level + 1, $count);

            }
            return $count;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $cron_id
     * @param $stage
     * @return int
     * @throws Exception
     */
    public function processTeamBonus($cron_id, $stage)
    {
        $this->load->model('team_bonuses_model');
        $this->load->model('ft_individual_model');

        $rows = $this->team_bonuses_model->getNew();

        $count = 0;

        foreach ($rows as $row) {

            try {

                $this->db->trans_start();

                $leg_amount_id = null;
                $amount_payable = $team_bonus_percent = 0;

                if ($is_qualified = $this->ft_individual_model->qualifyTeamBonus($row['user_id_recipient'])) {

                    $totalTeamBV = $this->team_bonuses_model->getTotalTeamBV($row['user_id_recipient']);

                    $team_bonus_percent = $this->teamBonus($totalTeamBV) / 100;


                    if($team_bonus_percent != 0) {

                        $amount_spent = $this->team_bonuses_model->getSpendAmount($row['user_id_source'], $row['order_id']);

                        $amount_payable = round($row['bv_amount'] * $team_bonus_percent, 2) - $amount_spent;

                        if ($amount_payable > 0) {

                            $cash_amount = $amount_payable * 0.6;
                            $trade_amount = $amount_payable * 0.4;

                            $data = [
                                'from_id' => $row['user_id_source'],
                                'date_of_submission' => date('Y-m-d H:i:s'),
                                'amount_payable' => $amount_payable,
                                'cash_account' => $cash_amount,
                                'trading_account' => $trade_amount,
                                'amount_type' => 'team_bonus',
                                'total_amount' => $amount_payable,
                                'product_value' => $amount_payable,
                                'stage' => $stage,
                            ];

                            $leg_amount_id = $this->insertData($row['user_id_recipient'], $data);

                            $count++;

                        } else {
                            $amount_payable = 0;
                        }

                    }
                }

                $this->team_bonuses_model->updateAfterProcessing($row['id'], $cron_id, $amount_payable, (int)$is_qualified, $team_bonus_percent, $leg_amount_id);

                $this->db->trans_complete();

            } catch (Exception $e) {
                $this->db->trans_rollback();
                log_message('error', $e->getMessage());
                throw $e;
            }

        }

        return $count;
    }

    function getUsersForFSB($is_init) {

        $joining_date = (new DateTime())->sub(new DateInterval('P30D'))->format('Y-m-d');

        $this->db->_protect_identifiers = false;
        $this->db
            ->select('ub.user_id,ub.aq_team_bv,ft.date_of_joining')
            ->from('user_balance_amount as ub')
            ->join('ft_individual as ft', 'ft.id = ub.user_id')
            ->join('fast_start_bonuses as fsb', 'fsb.user_id = ub.user_id', 'left')
            ->where('fsb.user_id', NULL);

        if ($is_init)
            $this->db->where("DATE_FORMAT(ft.date_of_joining, '%Y-%m-%d') <= '$joining_date'", NULL, FALSE);
        else
            $this->db->where("DATE_FORMAT(ft.date_of_joining, '%Y-%m-%d') = '$joining_date'", NULL, FALSE);

        $result = $this->db
            ->order_by('ft.date_of_joining')
            ->get()
            ->result_array();
        $this->db->_protect_identifiers = true;
        return $result;
    }

    public function processFSB($is_init) {

        $stage = $this->getLegAmountStage();
        $settings = $this->_fsb_settings;
        $users = $this->getUsersForFSB($is_init);
        $total = count($users);
        $inserted = $processed = 0;
        $init_msg = $is_init ? ' init' : '';

        $break_time = time() + 60 * 10;
        foreach ($users as $user) {

            $bv = (int)$user['aq_team_bv'];

            $first_liners = $this->db
                ->select('id')
                ->where('father_id', $user['user_id'])
                ->where('product_id >=', $settings['package'])
                ->get('ft_individual')
                ->result_array();

            $first_liners_ids = [];
            foreach ($first_liners as $first_liner) {
                $first_liners_ids[] = $first_liner['id'];
            }

            $this->db->trans_start();

            if(count($first_liners) >= $settings['first_liners'] && $bv >= $settings['turnover_1']){
                $accumulated_lvl = ($bv >= (int)$settings['turnover_2'] ? 2 : 1);
                $bonus_amount = $settings["turnover_$accumulated_lvl"] *  $settings["percentage"];

                $cash_amount = $bonus_amount * 0.6;
                $trade_amount = $bonus_amount * 0.4;

                $args = [
                    'date_of_submission' => date("Y-m-d H:i:s"),
                    'trading_account' => $trade_amount,
                    'cash_account' => $cash_amount,
                    'stage' => $stage,
                    'user_id' => $user['user_id'],
                    'amount_type' => 'fast_start_bonus',
                    'amount_payable' => $bonus_amount,
                    'total_amount' => $bonus_amount,
                ];
                $this->db->set($args)->insert($this->_table);
                $leg_id = $this->db->insert_id();
                $inserted ++;
            }else{
                $bonus_amount = 0;
                $leg_id = null;
            }

            $processed ++;

            $this->db->set([
                    'user_id' => $user['user_id'],
                    'bv' => $bv,
                    'first_liners' => implode(',', $first_liners_ids),
                    'amount' => $bonus_amount,
                    'leg_amount_id' => $leg_id
                ])->insert('fast_start_bonuses');

            if(!$this->db->trans_complete()){
                return "failed$init_msg ($inserted / $processed / $total)";
            }
            if($break_time <= time()){
                return "success$init_msg ($inserted / $processed / $total)";
            }

        }
        return "success$init_msg ($inserted / $processed / $total)";
    }



    public function getLegAmountStage() {

        return $this->db->select_max('stage')
            ->get($this->_table)
            ->first_row()
            ->stage ?: 1;
    }
    
    /**
     * 
     * @param int $user user id
     * @param int $share num of shares this user receive
     * @param float $pool amount of diamond pool share
     * @param int $stage ???
     * @param string|null $day treat transaction as on this date, today or null
     * @param bool $output
     * @throws Exception on invalid insert
     */
    public function insertDiamondPoolBonus($user, $share, $pool, $stage, $day = null, $output = false)
    {
        $amount_payable = $share * $pool;
        
        $cash_amount = $amount_payable * 0.6;
        $trade_amount = $amount_payable * 0.4;
        
        try {
            return $this->insertData($user, [
                'from_id' => '',
                'date_of_submission' => empty($day) ? date('Y-m-d H:i:s') : $day . ' 00:00:02',
                'amount_payable' => $amount_payable,
                'cash_account' => $cash_amount,
                'trading_account' => $trade_amount,
                'amount_type' => 'diamond_pool',
                'total_amount' => $amount_payable,
                'user_level' => 0,
                'product_value' => 0,
                'stage' => $stage,
            ]);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            throw $e;
        }
    }

    public function processRankBonus(){
        $stage = $this->getLegAmountStage();
        $settings = $this->_rank_bonus_settings;
        $users = $this->getUsersForRankBonus();
        $total = count($users);
        $bonuses = $processed = 0;

        $break_time = time() + 60 * 10;
        foreach ($users as $user) {
            $j = 0;
            for($cur_career = $user['last_bonused_career'] < 1 ? 1 : (int)$user['last_bonused_career']; $cur_career < $user['currect_career']; $cur_career++){

                $next_career = $cur_career + 1;
                $next_bonus_settings = $settings[$next_career];

                $bonus_amount = (double)$next_bonus_settings['rank_bonus'];

                $cash_amount = $bonus_amount * 0.6;
                $trade_amount = $bonus_amount * 0.4;

                $args = [
                    'date_of_submission' => date("Y-m-d H:i:s", time() + $j),
                    'trading_account' => $trade_amount,
                    'cash_account' => $cash_amount,
                    'stage' => $stage,
                    'user_id' => $user['user_id'],
                    'amount_type' => 'rank_bonus',
                    'amount_payable' => $bonus_amount,
                    'total_amount' => $bonus_amount,
                ];
                $j++;


                $this->db->trans_start();

                $this->db->set($args)->insert($this->_table);
                $leg_id = $this->db->insert_id();

                $this->db
                    ->set([
                        'user_id' => $user['user_id'],
                        'rank_id' => $next_bonus_settings['id'],
                        'leg_amount_id' => $leg_id
                    ])
                    ->insert('rank_bonuses');

                $bonuses++;

                if(!$this->db->trans_complete()){
                    return "failed ($processed / $bonuses / $total)";
                }
                if($break_time <= time()){
                    if($next_career == $user['currect_career']){
                        $processed++;
                    }
                    return "success ($processed / $bonuses / $total)";
                }

            }
            $processed++;

        }

        return "success ($processed / $bonuses / $total)";
    }


    function getUsersForRankBonus() {

        $this->db->_protect_identifiers = false;
        $result = $this->db
            ->select(['ft.id as user_id', 'ft.user_name', 'IFNULL(c.order, 0) as currect_career', 'IFNULL(lrb.value, 0) as last_bonused_career'], false)
            ->from('ft_individual as ft')
            ->join('careers as c', 'c.id = ft.career', 'left')
            ->join('last_rank_bonuses as lrb', 'lrb.user_id = ft.id', 'left')
            ->where('IFNULL(c.order, 0) > ', 'IFNULL(lrb.value, 0)', false)
            ->where('IFNULL(c.order, 0) >= ', 2, false)
            ->order_by('ft.id')
            ->get()
            ->result_array();
        $this->db->_protect_identifiers = true;
        return $result;
    }

}
