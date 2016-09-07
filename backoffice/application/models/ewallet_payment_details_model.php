<?php

class ewallet_payment_details_model extends inf_model {

    private $_table = 'ewallet_payment_details';
    
    public function __construct() {

    }

    /**
     * 
     * @param int $user
     * @return array user spendings
     */
    public function getUserSpend($user)
    {
        $this->db->select('SUM(IF(`payed_account` != \'trading\', `used_amount`, 0)) as cash, SUM(IF(`payed_account` = \'trading\', `used_amount`, 0)) as trading', false);
        $this->db->group_by('user_id');
        $this->db->having('user_id', $user);
        return $this->db->get($this->_table)->row_array();
    }
    
    /**
     * 
     * @return array
     */
    public function getUsersSpend($from = null, $to = null)
    {
        $this->db->select('user_id as user, SUM(IF(`payed_account` != \'trading\', `used_amount`, 0)) as cash, SUM(IF(`payed_account` = \'trading\', `used_amount`, 0)) as trading', false);
        if (!is_null($from)) {
            $this->db->where('user_id >', $from);
        }
        if (!is_null($to)) {
            $this->db->where('user_id <', $to);
        }
        $this->db->group_by('user_id');
        
        $arr = [];
        foreach($this->db->get($this->_table)->result_array() as $result) {
            $arr[$result['user']] = ['cash' => $result['cash'], 'trading' => $result['trading']];
        }
        return $arr;
    }
    
    public function insertEntry($user, $amount, $type, $account, $date = null)
    {
        if (!$this->db->insert($this->_table, [
            'user_id' => $user,
            'used_user_id' => $user,
            'used_amount' => round($amount, 2),
            'used_for' => $type,
            'payed_account' => $account,
            'date' => !empty($date) ? $date : date('Y-m-d H:i:s')
        ])) {
            throw new Exception('Error while insert fund transfer');
        }
        return true;
    }
    
    public function minusCreditTrading($user, $amount, $date = null)
    {
        $this->load->model('user_balance_amount_model');
        $this->db->trans_start();
        
        try {
            $this->insertEntry($user, $amount, 'minus_credit', 'trading', $date);
//            user_balance_amount account values was deprecated
//            $this->user_balance_amount_model->updateAccounts($user, 0, 0, $amount);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Was not able to add credit::' . $e->getMessage());
            show_error('Was not able to add credit');
        }

        $this->db->trans_complete();

        return true;
    }
    
}
