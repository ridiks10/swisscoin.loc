<?php

/**
 *
 */
class diamond_bonuses_model extends inf_model {

    private $_table = 'diamond_bonuses';

    public function __construct()
    {

    }
    
    public function insertBonus($user_id, $pool, $amount, $share, $cron_id, $leg_amount_id)
    {
        return $this->db->insert($this->_table, compact('user_id', 'pool', 'amount', 'share', 'cron_id', 'leg_amount_id'));
    }
    
}
