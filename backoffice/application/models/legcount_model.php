<?php

class leg_count_model extends inf_model {

    private $obj_leg;

    public function initialize($product_status) {
        if ($product_status == 'yes') {
            require_once 'leg_with_product_model.php';
        } else {
            require_once 'leg_without_product_model.php';
        }
        $this->obj_leg = new leg_model();
    }

    public function getUserLegDetails($user_id, $page, $limit, $user_type,$table_prefix ="") {
     
        
        
        $user_leg_detail = $this->obj_leg->getUserLegDetails($user_id, $page, $limit, $user_type);

        return $user_leg_detail;
    }

    public function paging($user_id, $page, $limit, $current_url) {
        $this->load->model('page_model');
        $numrows = $this->obj_leg->getUserLegPage($user_id);

        $arr['first'] = $this->page_model->paging($page, $limit, $numrows);
        $arr['page_footer'] = $this->page_model->setFooter($page, $limit, $current_url);

        return $arr;
    }
 
}