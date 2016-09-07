<?php

class team_bonuses_model extends inf_model {

    private $_table = 'team_bonuses';
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $user_source
     * @param $user_recipient
     * @param $order_id
     * @param $bv_amount
     * @return CI_DB_active_record|CI_DB_result
     */
    public function insert($user_source, $user_recipient, $order_id, $bv_amount){
        return $this->db->insert(
            $this->_table,
            [
                'user_id_source' => $user_source,
                'user_id_recipient' => $user_recipient,
                'order_id' => $order_id,
                'bv_amount' => $bv_amount
            ]
        );
    }

    public function getNew(){
        return $this->db->where('cron_id')->order_by('id')->get($this->_table)->result_array();
    }

    public function getTotalTeamBV($user_id){
        return (int)$this->db->select('aq_team_bv')->where('user_id', $user_id)->get('user_balance_amount')->first_row('array')['aq_team_bv'];
    }


    public function getSpendAmount($user_id_source, $order_id){
        return round(
            $this->db
            ->select_sum('added_amount', 'sum')
            ->where('user_id_source', $user_id_source)
            ->where('order_id', $order_id)
            ->get($this->_table)
            ->first_row('array')['sum'],
            2);
    }

    public function updateAfterProcessing($id, $cron_id, $amount_spent, $is_qualified, $team_bonus_percent = NULL, $leg_amount_id = NULL){
        return $this->db
            ->set('added_amount', 'ROUND(' . $amount_spent . ',2)', false)
            ->set('cron_id', $cron_id)
            ->set('is_qualified', $is_qualified)
            ->set('bonus_percent', $team_bonus_percent)
            ->set('leg_amount_id', $leg_amount_id)
            ->where('id', $id)
            ->update($this->_table);
    }

    public function updateCronId($id, $cron_id){
        return $this->db->update($this->_table, ['cron_id' => $cron_id], ['id' => $id]);
    }
    
}
