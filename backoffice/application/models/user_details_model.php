<?php

class user_details_model extends inf_model {

    private $_table = 'user_details';
    
    public function __construct() {

    }

    public function autocompleteUsername($name)
    {
        $this->db->select('ft.id, ft.user_name as value, CONCAT(ft.user_name, " - ", pd.user_detail_name, ", ", pd.user_detail_second_name) as label', false);
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details AS pd', 'ft.id = pd.user_detail_refid');
        $this->db->where('pd.user_detail_name LIKE', '%' . $name . '%');
        $this->db->or_where('pd.user_detail_second_name LIKE', '%' . $name . '%');
        $this->db->or_where('ft.user_name LIKE', '%' . $name . '%');
        return $this->db->get()->result_array();
    }
    
}
