<?php

class Leg_count_commission_model extends inf_model {

    private $obj_leg_pro;

    public function initialize($product_status) {
        if ($product_status == 'yes') {
            require_once 'leg_with_product_model.php';
        } else {
            require_once 'leg_without_product_model.php';
        }
        $this->obj_leg_pro = new leg_model();
    }

    public function __construct() {
        $this->load->model('leg_class_model');
        $this->load->model('settings_model');
        $this->load->model('page_model');
        $this->load->model('validation_model');
    }

    public function getCountUserLegDetails($user_id, $user_type) {

        return $this->obj_leg_pro->getCountUserLegDetails($user_id, $user_type);
    }

    public function paging($page, $limit) {
        $numrows = $this->leg_class_model->getUserTotalLegDetails($page, $limit);
        //$page_arr['first'] = $this->page_model->paging($page,$limit,$numrows);
        //$page_arr['page_footer'] = $this->page_model->setFooter($page,$limit,$url);
        //return $page_arr;
        return $numrows;
    }

    public function getEachLeveLegCountAndTotalLeveAmount($user_id_tmp, $depth_ceiling) {
         return $this->leg_class_model->getEachLeveLegCountAndTotalLeveAmount($user_id_tmp, $depth_ceiling);
    }

    public function userNameToID($user_name) {
        return $this->validation_model->userNameToID($user_name);
    }

    public function getUserLegDetails($user_id, $page, $limit) {
        return $this->leg_class_model->getUserLegDetails($user_id, $page, $limit);
    }

    public function getDepthCieling() {
       return $this->settings_model->getDepthCieling();
    }

    public function getUserDetails() {
        $echo = "";
        $table_prefix = $_SESSION['table_prefix'];

        $login_user = $table_prefix . "login_user";
        $user_details = $table_prefix . "user_details";

        $qry = "select l.user_name,u.user_detail_name,u.user_detail_mobile,u.user_detail_email
	from $login_user as l INNER JOIN $user_details as u ON  l.user_id=u.user_detail_refid WHERE addedby !='server'  order by user_id";

        $res = $this->selectData($qry, "Error on user selection-12213423435");
        while ($inf = mysql_fetch_array($res)) {
            $link = "<a style='text-decoration:none; font-weight:bold ;color:white' href='#' name=" . $inf['user_name'] . " onClick='userSelection(this)'>";
            $echo . "<tr bgcolor='#3891BF'><td>$link" . $inf['user_name'] . "</td><td>$link " . $inf['user_detail_name'] . " </td><td>$link  " . $inf['user_detail_mobile'] . "</td><td>$link " . $inf['user_detail_email'] . " </td></tr></a> ";
        }
        return $echo;
    }
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


}
