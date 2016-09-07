<?php

/**
 * @property order_history_model $order_history_model
 * @property  ft_individual_model $ft_individual_model
 * @property  income_bv_history_model $income_bv_history_model
 * @property  direct_bonuses_model $direct_bonuses_model
 * @property  team_bonuses_model $team_bonuses_model
 */
class user_balance_amount_model extends inf_model {

    private $_table = 'user_balance_amount';
    
    public function __construct() {
        if (empty($this->order_history_model)) {
            $this->load->model('order_history_model');
        }
        if (empty($this->ft_individual_model)) {
            $this->load->model('ft_individual_model');
        }
    }

    public function prepareBalanceToRecalc()
    {
        $this->db->set('first_line_aq_bv', 0);
        $this->db->set('first_line_weekly_bv', 0);
        $this->db->set('aq_team_bv', 0);
        $this->db->set('week_team_bv', 0);
        $this->db->set('bv', 0);
        $this->db->set('downline_spend', 0);
        $this->db->set('balance_amount', 0);
        $this->db->set('cash_account', 0);
        $this->db->set('trading_account', 0);
        $this->db->set('status', 2);
        $this->db->where('status <', 2);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Was not able to prepare tables for recalc');
        }
    }
    
    public function recalcDone()
    {
        echo '<br> Return table status to ready';
        $this->db->set('status', 0);
        $this->db->update($this->_table);
    }

    public function updateFirstlineTotalBV($id, $amount)
    {
        $this->db->set('first_line_aq_bv', $amount . ' + first_line_aq_bv', false);
        $this->db->set('first_line_weekly_bv', $amount . ' + first_line_weekly_bv', false);
        $this->db->set('status', 3);
        $this->db->where('user_id', $id);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Invalid update');
        }
    }
    
    public function updateTeamTotalBV($id, $amount)
    {
        $this->db->set('aq_team_bv', $amount . ' + aq_team_bv', false);
        $this->db->set('week_team_bv', $amount . ' + week_team_bv', false);
        $this->db->set('status', 3);
        $this->db->where('user_id', $id);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Invalid "Team" update');
        }
    }
    
    public function calculateBVIncome($father_id, $bv, $order, $status = 1)
    {
//        echo '<br><span style="color:goldenrod">user(' . $father_id . ')</span>::receive bv(' . $bv . ') for order (' . $order . ')';
        $father = $this->validation_model->getFatherId($father_id);
        $this->db->trans_start();
        $father = $this->ft_individual_model->getFather($father_id);
        if ($father) {
            try {
//                $this->prepareBalanceToRecalc($father);
                $this->updateFirstlineTotalBV($father, $bv);
            } catch (Exception $e) {
                throw $e;
            }

            while ($father) {
                try {
                    $this->updateTeamTotalBV($father, $bv);
                } catch (Exception $e) {
                    throw $e;
                }
                $father = $this->validation_model->getFatherId($father);
            }
        }
        $this->order_history_model->markOrder($order, $status);
    }
    
    public function havePendingDayUpdates()
    {
        $this->db->select('SUM(*) as sum');
        $this->db->where('status', 3);
        return $this->db->get($this->_table)->row()->sum;
    }
    
    /**
     * 
     * @param int $user user to change balance
     * @param float $balance total balance change positiv for addition negative for subtraction
     * @param float $cash cash balance change positiv for addition negative for subtraction
     * @param float $trading trading balance change positiv for addition negative for subtraction
     * @param int|null $status order status update check or null
     * @return boolean whether ok with update
     * @throws Exception on update error
     */
    public function updateAccounts($user, $balance, $cash, $trading, $status = null)
    {
        if (!$balance && !$cash && !$trading) {
            if (!is_null($status)) {
                $this->db->set('status', $status);
                $this->db->where('user_id', $user);
                $this->db->update($this->_table);
            }
            return true;
        }
        
        if ($balance) {
            $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $balance . ', 2)', false);
        }
        if ($cash) {
            $this->db->set('cash_account', 'ROUND(cash_account + ' . $cash . ', 2)', false);
        }
        if ($trading) {
            $this->db->set('trading_account', 'ROUND(trading_account + ' . $trading . ', 2)', false);
        }
        if (!is_null($status)) {
            $this->db->set('status', $status);
            $this->db->where('status <', $status);
        }
        $this->db->where('user_id', $user);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Was not able to update user balance');
        }
        return true;
    }
    
    public function selfBVCalculate($user, $value)
    {
        $this->db->set('bv', 'ROUND(bv +' . $value . ',2)', false);
        $this->db->where('user_id', $user);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Was not able to update user bv');
        }
    }
    
    public function getUpdatedUsers()
    {
        $this->db->select('user_id');
        $this->db->where('status', 3);
    }
    
    public function allUsers($status)
    {
        if (is_array($status)) {
            $from = $status[0];
            $status = $status[1];
        }
        
        $this->db->select('ub.user_id');
        $this->db->from('ft_individual AS ft');
        $this->db->join('user_balance_amount AS ub', 'ft.id = ub.user_id');
        $this->db->where('ft.active !=', 'server');
        $this->db->where('ub.status <', $status);
        if (isset($from)) {
            $this->db->where('ub.status >', $from);
        }
        return $this->db->get()->result_array();
    }
    
    public function getDownlineTeamBonus($user)
    {
        $this->db->select_sum('downline_spend', 'sum');
        $this->db->where('user_id', $user);
        return $this->db->get($this->_table)->row()->sum;
    }
    
    public function setTeamBonus($user, $amount)
    {
        $this->db->set('downline_spend', round($amount, 2));
        $this->db->where('user_id', $user);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Was not able to update team bonuses');
        }
    }
    
    /**
     * Calculate pending BV and credit it to users
     * @throws Exception on SQL error or if update failing
     */
    public function processNewOrders()
    {
        $this->load->model('direct_bonuses_model');
        $this->load->model('team_bonuses_model');

        $orders = $this->order_history_model->getNewOrders();
        foreach ($orders as $order) {
            $this->db->trans_start();

            $user_id = $order['user_id'];
            
            $father = $this->ft_individual_model->getFather($order['user_id']);
            if ($father) {
                try {
                    $this->updateFirstlineTotalBV($father, $order['bv'] * $order['quantity'] );
                    $this->direct_bonuses_model->insert($user_id, $father, $order['order_id'], $order['bv'] * $order['quantity']);

                    while ($father) {
                        $this->updateTeamTotalBV($father, $order['bv'] * $order['quantity'] );
                        $this->team_bonuses_model->insert($user_id, $father, $order['order_id'], $order['bv'] * $order['quantity']);
                        $father = $this->ft_individual_model->getFather($father);
                    }
                } catch (Exception $e) {
                    $this->db->trans_rollback();
                    log_message('error', $e->getMessage());
                    throw $e;
                }
            }
            $this->order_history_model->markOrder($order['id']);

            $this->db->trans_complete();
        }
        return count($orders);
    }

    
    public function creditMinusAccount()
    {
        $this->db->trans_start();
        
//        $this->db->where('balance_amount < ', 0);
//        $this->db->update($this->_table, ['balance_amount' => 0]);
        
        $this->db->where('cash_account < ', 0);
        $this->db->update($this->_table, ['cash_account' => 0]);
        
        $this->db->where('trading_account < ', 0);
        $this->db->update($this->_table, ['trading_account' => 0]);
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            throw new Exception('Was not able to fix minus accounts');
        } else {
            $this->db->trans_complete();
        }
    }
    
    public function getMinusAccount($type = 'cash')
    {
        if (!in_array($type, ['cash', 'trading'])) {
            throw new Exception('Invalid account');
        }
        $this->db->select('user_id, ABS(' . $type . '_account) as amount');
        $this->db->where($type . '_account < ', 0);
        return $this->db->get($this->_table)->result_array();
    }
    
    public function getLastUserWithStatus($status, $desc = false)
    {
        $this->db->select('user_id');
        $this->db->order_by('user_id', $desc ? 'asc' : 'desc');
        $r = $this->db->get_where($this->_table, ['status' => $status], 1)->row_array();
        return !empty($r['user_id']) ? $r['user_id'] : null;
    }



    public function selfBVUpdate($user, $value)
    {
        $this->db->set('bv', 'ROUND(bv +' . $value . ',2)', false);
        $this->db->where('user_id', $user);
        if (!$this->db->update($this->_table)) {
            throw new Exception('Was not able to update user bv');
        }
    }

    public function updateSelfTokens($user_id, $value)
    {
        return $this->db
            ->set('tokens', 'ROUND(tokens +' . $value . ',2)', FALSE)
            ->where('user_id', $user_id)
            ->update($this->_table);
    }

    public function updateSelfBV($user_id, $value)
    {
        return $this->db->set('bv', 'ROUND(bv +' . $value . ',2)', FALSE)
            ->where('user_id', $user_id)
            ->update($this->_table);
    }
    public function updateParentsBV($user_id, $bv, $order_id)
    {
        $this->load->model('income_bv_history_model');
        $father = $this->ft_individual_model->getFather($user_id);
        if ($father) {

            try {
                $this->income_bv_history_model->insert($user_id, $father, $order_id, 'first_line', $bv);
                $this->updateFirstlineTotalBV($father, $bv);

                while ($father) {
                    $this->income_bv_history_model->insert($user_id, $father, $order_id, 'second_line', $bv);
                    $this->updateTeamTotalBV($father, $bv);
                    $father = $this->ft_individual_model->getFather($father);
                }

            } catch (Exception $e) {
                $this->db->trans_rollback();
                log_message('error', $e->getMessage());
                throw $e;
            }
        }
        return true;
    }
    
}
