<?php

class fund_transfer_details_model extends inf_model {

    private $_table = 'fund_transfer_details';
    
    private $_admin_id;
    
    public function __construct() {
        $this->_admin_id = $this->validation_model->getAdminId();
        
        if (empty($this->user_balance_amount_model)) {
            $this->load->model('user_balance_amount_model');
        }
    }

    /**
     * Get total amount user have spend
     * @param int $id user id
     * @return float Sum spend
     */
    public function getUserDebit($id, $admin = true)
    {
        $this->db->select_sum('amount','sum');
        $this->db->where('to_user_id', $id);
        $type = ['user_debit'];
        // Stupid CI2 have no grouping so do a where in
        if ($admin) {
            $type[] = 'admin_debit';
        }
        $this->db->where_in('amount_type', $type);
        return floatval($this->db->get($this->_table)->row()->sum);
    }
    
    /**
     * Get total amount user have received
     * @param int $id user id
     * @return float Sum received
     */
    public function getUserCredit($id, $admin = true)
    {
        $this->db->select_sum('amount','sum');
        $this->db->where('to_user_id', $id);
        $type = ['user_credit'];
        if ($admin) {
            $type[] = 'admin_credit';
        }
        $this->db->where_in('amount_type', $type);
        return floatval($this->db->get($this->_table)->row()->sum);
    }
    
    /**
     * Get amount of user debit to admin
     * @param int $id user id
     * @return float Sum spend
     */
    public function getAdminDebit($id)
    {
        $this->db->select('SUM(amount) as sum');
        $this->db->where('amount_type', 'admin_debit');
        $this->db->group_by('to_user_id');
        $this->db->having('to_user_id', $id);
        $r = $this->db->get($this->_table)->row();
        return floatval($r ? $r->sum : 0);
    }
    
    /**
     * 
     * @param bool $admin count admin charges
     * @return array all users credits
     */
    public function getUsersCredit($admin = true, $from = null, $to = null) {
        $this->db->select('to_user_id as user, SUM(amount) as sum');
        if (!is_null($from)) {
            $this->db->where('to_user_id >', $from);
        }
        if (!is_null($to)) {
            $this->db->where('to_user_id <', $to);
        }
        $type = ['user_credit'];
        // Stupid CI2 have no grouping so do a where in
        if ($admin) {
            $type[] = 'admin_credit';
        }
        $this->db->where_in('amount_type', $type);
        $this->db->group_by('to_user_id');
        
        $arr = [];
        foreach($this->db->get($this->_table)->result_array() as $result) {
            $arr[$result['user']] = $result['sum'];
        }
        return $arr;
    }
    
    /**
     * 
     * @param bool $admin count admin charges
     * @return array All users debits
     */
    public function getUsersDebit($admin = true, $from = null, $to = null) {
        $this->db->select('to_user_id as user, SUM(amount) as sum');
        if (!is_null($from)) {
            $this->db->where('to_user_id >', $from);
        }
        if (!is_null($to)) {
            $this->db->where('to_user_id <', $to);
        }
        $type = ['user_debit'];
        // Stupid CI2 have no grouping so do a where in
        if ($admin) {
            $type[] = 'admin_debit';
        }
        $this->db->where_in('amount_type', $type);
        $this->db->group_by('to_user_id');
        
        $arr = [];
        foreach($this->db->get($this->_table)->result_array() as $result) {
            $arr[$result['user']] = $result['sum'];
        }
        return $arr;
    }
    
    public function insertEntry($from, $to, $amount, $type, $note, $date = null)
    {
        if (!$this->db->insert($this->_table, [
            'from_user_id' => $from,
            'to_user_id' => $to,
            'amount' => round($amount, 2),
            'amount_type' => $type,
            'transaction_concept' => $note,
            'date' => !empty($date) ? $date : date('Y-m-d H:i:s')
        ])) {
            throw new Exception('Error while insert fund transfer');
        }
        return true;
    }
    
    public function adminCredit($to, $amount, $type = 'admin_credit', $note = '', $date = null)
    {
        $this->db->trans_start();
        
        try {
            $this->insertEntry($this->_admin_id, $to, $amount, $type, $note, $date);
//            user_balance_amount account values was deprecated
//            $this->user_balance_amount_model->updateAccounts($to, $amount, $amount, 0);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', 'Was not able to add credit::' . $e->getMessage());
            show_error('Was not able to add credit');
        }

        $this->db->trans_complete();
        
        return true;
    }
    
    public function minusCredit($to, $amount, $note, $date = null)
    {
        return $this->adminCredit($to, $amount, 'minus_credit', $note, $date);
    }
    
}
