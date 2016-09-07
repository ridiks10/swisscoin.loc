<?php

class payout_release_requests_model extends inf_model {

    private $_table = 'payout_release_requests';
    
    public function __construct() {

    }

    /**
     * 
     * @param int $user User to get released payouts
     * @return float payout sum
     */
    public function getUserPayouts($user)
    {
        $this->db->select('SUM(`requested_amount` - `requested_amount_balance`) as amount', false);
        $this->db->where('requested_user_id', $user);
        $this->db->where('status', 'released');
        return floatval($this->db->get($this->_table)->row()->amount);
    }
    
    public function getUsersPayouts($from = null, $to = null)
    {
        $this->db->select('requested_user_id as user, SUM(`requested_amount` - `requested_amount_balance`) as amount', false);
        if (!is_null($from)) {
            $this->db->where('requested_user_id >', $from);
        }
        if (!is_null($to)) {
            $this->db->where('requested_user_id <', $to);
        }
        $this->db->where('status', 'released');
        $this->db->group_by('requested_user_id');
        
        $arr = [];
        foreach($this->db->get($this->_table)->result_array() as $result) {
            $arr[$result['user']] = $result['amount'];
        }
        return $arr;
    }
    
}
