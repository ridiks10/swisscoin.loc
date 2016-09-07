<?php

class income_bv_history_model extends inf_model {

    private $_table = 'income_bv_history';
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $user_source
     * @param $user_recipient
     * @param $order_id
     * @param $type
     * @param $amount
     * @param null $cron_id
     * @return CI_DB_active_record|CI_DB_result
     */
    public function insert($user_source, $user_recipient, $order_id, $type, $amount, $cron_id = NULL){
        return $this->db->insert(
            $this->_table,
            [
                'user_id_source' => $user_source,
                'user_id_recipient' => $user_recipient,
                'order_id' => $order_id,
                'type' => $type,
                'amount' => $amount,
                'cron_id' => $cron_id
            ]
        );
    }

    /**
     * @param $user_id_recipient
     * @param  string $type Values: "first_line" or "second_line"
     * @return mixed
     */
    public function getByRecipientAndType($user_id_recipient, $type){
        return $this->db->from($this->_table)->where('user_id_recipient', $user_id_recipient)->where('type', $type)->where('cron_id')->get()->result_array();
    }

    /**
     * @param $user_id_source
     * @param $order_id
     * @return mixed
     */
    public function getSecondLineSpendAmount($user_id_source, $order_id){
        return $this->db
            ->select_sum('amount_spent', 'sum')
            ->where('user_id_source', $user_id_source)
            ->where('order_id', $order_id)
            ->where('type', 'second_line')
            ->where('cron_id')
            ->get($this->_table)
            ->first_row('array')['sum'];
    }

    /**
     * @param $id
     * @param $amount_spent
     * @param $cron_id
     * @return CI_DB_active_record|CI_DB_result
     */
    public function updateSecondLineSpendAmount($id, $amount_spent){
        return $this->db
            ->set('amount_spent', 'ROUND(' . $amount_spent . ',2)', false)
            ->where('id', $id)
            ->update($this->_table);
    }

    /**
     * @param $cron_id
     * @return CI_DB_active_record|CI_DB_result
     */
    public function markProcessed($cron_id){
        return $this->db->set('cron_id', $cron_id)->where('cron_id')->update($this->_table);
    }

    /**
     * @return CI_DB_active_record|CI_DB_result
     */
    public function truncate(){
        $deleted_rows = $this->db->count_all($this->_table);
        $this->db->insert(
            'cron_history',
            [
                'end_date' => date("Y-m-d H:i:s"),
                'date' => date("Y-m-d H:i:s"),
                'status' => 'success',
                'cron' => "bv_history truncate ($deleted_rows)"
            ]
        );
        return $this->db->truncate($this->_table);
    }
    
}
