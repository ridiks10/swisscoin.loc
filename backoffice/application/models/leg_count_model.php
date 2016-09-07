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

    public function getUserLegDetails($user_id, $page, $limit, $user_type, $table_prefix = '') {
        $this->obj_leg->setTablePrefix($table_prefix);
        $user_leg_detail = $this->obj_leg->getUserLegDetails($user_id, $page, $limit, $user_type);
        return $user_leg_detail;
    }

    public function getCountUserLegDetails($user_id, $user_type) {
        return $this->obj_leg->getCountUserLegDetails($user_id, $user_type);
    }

    public function paging($user_id, $page, $limit, $current_url) {
        $this->load->model('page_model');
        $numrows = $this->obj_leg->getUserLegPage($user_id);
        $arr['first'] = $this->page_model->paging($page, $limit, $numrows);
        $arr['page_footer'] = $this->page_model->setFooter($page, $limit, $current_url);
        return $arr;
    }

    public function getUserTypeFromUserID($user_id, $table_prefix = '') {
        $this->db->select('user_type');
        $this->db->from($table_prefix . "login_user");
        $this->db->where('user_id', $user_id);
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $type = $row['user_type'];
        }
        return $type;
    }

///////////////////Niyasali.//////////////
    public function getUserIdFromUserName($usr, $table_prefix = '') {
        $this->db->select('user_id');
        $this->db->select('user_name');
        $this->db->select('user_type');
        $this->db->from($table_prefix . "login_user");
        $this->db->where('user_name', $usr);
        $result = $this->db->get();
        foreach ($result->result_array() as $row) {
            $users['user_id'] = $row['user_id'];
            $users['user_type'] = $row['user_type'];
            $users['user_name'] = $row['user_name'];
        }
        return $users;
    }

    public function isUserAvailable($user_name) {

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $this->db->where('active !=', 'server');


        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $cnt = $row->cnt;
        }

        if ($cnt > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

//////////////////////End//////////////////////
}
