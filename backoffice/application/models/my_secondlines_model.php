<?php

class my_secondlines_model extends inf_model {

    public function __construct() {
        parent::__construct();
       
    }
     public function getAllSecondlineUser($id) {
       $down_lines = array();
       $next_lines = array();
       array_push($next_lines, $id);
       $down_lines = $this->getDownlines($next_lines, $down_lines, $level = 1);
     //  print_r($down_lines);die();
       $second_line=array();
       $i=0;
       foreach ($down_lines as $row){
            if($row['level']!=1){
                $second_line[$i]=$row['id'];
                $i++;
            }
            
        }

        return $second_line;
    }
     public function getDownlines($next_lines, $down_lines, $level) {
        $this->db->select('id,user_name,user_rank_id');
        $this->db->from('ft_individual');
        $this->db->where('active', 'yes');
        $this->db->where_in('father_id', $next_lines);
        $query = $this->db->get();
        $next_lines = array();
        foreach ($query->result_array() as $row) {

            $row['level'] = $level;
            array_push($next_lines, $row['id']);
            array_push($down_lines, $row);
        }
        if (empty($next_lines)) {
            $down_lines['num_level'] = --$level;
            return $down_lines;
        } else {
            $level++;
            return $this->getDownlines($next_lines, $down_lines, $level);
        }
    }
    public function getAllSecondlineUserDetails($secondline){
        
        $data=array();
        //$this->db->select('ud.*');
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details as ud','ft.id = ud.user_detail_refid');
        $this->db->where_in('ft.id', $secondline);
        $query = $this->db->get();
        $a=$this->db->last_query();
              
        foreach ($query->result_array() as $row) {
            $row['country_name']=$this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $row['state_name']=$this->country_state_model->getStateNameFromId($row['user_detail_state']);
            $data[] = $row;
        }
        return $data;
    }
   
}

?>