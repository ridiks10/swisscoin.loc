<?php

Class myorder_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function getAllPackage($user_id) {
        $obj_arr = array();
        $this->db->select('id,change_price,change_bv,change_token,date,product_name');
        $this->db->from('package_history');
        $this->db->join('package', 'change_pack = product_id');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["package_id"] = $row['id'];
            $obj_arr[$i]["package_price"] = $row['change_price'];
            $obj_arr[$i]["package_bv"] = $row['change_bv'];
            $obj_arr[$i]["package_token"] = $row['change_token'];
            $obj_arr[$i]["package_date"] = $row['date'];
            $obj_arr[$i]["package_name"] = $row['product_name'];

            $i++;
        }
        return $obj_arr;
    }

    public function getCountOrders($user_id='')
    {
        $this->db->select('COUNT(*) as num');
        if($user_id!=''){
             $this->db->where('user_id', $user_id);
        }
        try {
            return $this->db->get('orders')->row()->num;
        } catch (Exception $ex) {
            return 0;
        }
    }
    
    public function getMyOrders($user_id='', $page = 0) {

        $obj_arr = array();
        $this->db->select('o.*, ft.user_name as username');
        $this->db->select('CONCAT_WS(" ", ud.user_detail_name, ud.user_detail_second_name) as name', false);
        $this->db->from('orders as o');
        $this->db->join('ft_individual as ft', "o.user_id = ft.id", 'INNER');
        $this->db->join('user_details as ud', "o.user_id = ud.user_detail_refid", 'INNER');
        if($user_id!=''){
             $this->db->where('user_id', $user_id);
        }
        $this->db->limit(100, ($page - 1) * 100);
        $this->db->order_by('date','desc');
        $query = $this->db->get();
        $arr = $query->result_array();
        $query->free_result();
        foreach ($arr as $row) {
            
            $row['package_purchase'] = $this->getOrderDetailsFromId($row['order_id']);
            $obj_arr[] = $row;
           
        }
        
        return $obj_arr;
    }

    function getOrderDetailsFromId($id) {
        $data = array();
        $this->db->where('order_id', $id);
        $res = $this->db->get('order_history');
        foreach ($res->result_array() as $row) {
            $row['package_name'] = $this->validation_model->getPrdocutName($row['package']);
            $data[] = $row;
        }
        $res->free_result();
        return $data;
    }

}
