<?php

class direct_bonuses_model extends inf_model {

    private $_table = 'direct_bonuses';
    
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

    public function getNewUserIds(){

        $result = $this->db
            ->select('distinct user_id_recipient as user_id', false)
            ->where('cron_id')
            ->get($this->_table)
            ->result_array();
        foreach ($result as &$item) {
            $item = $item['user_id'];
        }
        return $result;
    }

    public function getNew(){
        return $this->db->where('cron_id')->get($this->_table)->result_array();
    }

    public function updateAfterProcessing($id, $cron_id, $added_amount, $leg_amount_id){
        return $this->db->update($this->_table, ['cron_id' => $cron_id, 'added_amount' => $added_amount, 'leg_amount_id' => $leg_amount_id], ['id' => $id]);
    }
    
}
