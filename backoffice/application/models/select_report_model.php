<?php

class select_report_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('select_report_class_model');
        $this->load->model('page_model');
        $this->load->model('validation_model');
    }

    public function paging($page, $limit, $url) {
        $numrows = $this->select_report_class_model->payoutWeeklyPage($_SESSION['from'], $_SESSION['to']);
        $page_arr['first'] = $this->page_model->paging($page, $limit, $numrows);
        $page_arr['page_footer'] = $this->page_model->paging($page, $limit, $url);
        return $page_arr;
    }

    public function payoutWeeklyTotal($limit, $page, $from, $to, $user_id = "") {
        return $this->select_report_class_model->payoutWeeklyTotal($limit, $page, $from, $to, $user_id);
    }

    //////edited
    public function getAllBinaryPayoutDates($des) {
        return $this->select_report_class_model->getAllBinaryPayoutDates("DESC");
    }

    public function updatePaidStatus($POST) {
        return $this->select_report_class_model->updatePaidStatus($POST);
    }

    public function getBeforePayoutDateBinary($date_sub) {
        return $this->select_report_class_model->getBeforePayoutDateBinary($date_sub);
    }

    public function getNonPaidAmounts($previous_pyout_date, $date_sub) {
        return $this->select_report_class_model->getNonPaidAmounts($previous_pyout_date, $date_sub);
    }

    public function getPayoutType() {
        $payout_release = "";
        $this->db->select("payout_release");
        $this->db->from("configuration");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $payout_release = $row->payout_release;
        }
        return $payout_release;
    }

    public function getPayoutReleaseStatus() {
        $payout_release_status = "";
        $this->db->select("payout_release_status");
        $this->db->from("module_status");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $payout_release_status = $row->payout_release_status;
        }
        return $payout_release_status;
    }

    public function selectUser($letters) {

        $this->db->select('lu.user_id,lu.user_name');
        $this->db->from("login_user AS lu");
        $this->db->join("ft_individual AS ft", "ft.id=lu.user_id");
        $this->db->where('lu.addedby !=', 'server');
        $this->db->where('ft.active !=', 'terminated');
        $this->db->like('lu.user_name', $letters, 'after');
        $this->db->order_by('lu.user_id');
        $this->db->limit(500);
        $query = $this->db->get();
        $user_detail = "";
        foreach ($query->result() as $row) {
           $user_detail.= $row->user_id . "###" . $row->user_name . "|";
        }
        return $user_detail;
    }

    public function selectEpin($letters) {
        $this->db->select('pin_id,pin_numbers');
        $this->db->from("pin_numbers");
        $this->db->where('status !=', 'delete');
        $this->db->like('pin_numbers', $letters, 'after');
        $this->db->order_by('pin_id');
        $this->db->limit(500);
        $query = $this->db->get();
        $pin_details = "";
        foreach ($query->result() as $row) {
           $pin_details.= $row->pin_id . "###" . $row->pin_numbers . "|";
        }
        return $pin_details;
    }

    public function getAllRank() {
        $rank_arr = array();
        $this->db->select('rank_name');
        $this->db->select('rank_id');
        $this->db->from("rank_details");
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {
            $rank_arr[$i]["rank_name"] = $row->rank_name;
            $rank_arr[$i]["rank_id"] = $row->rank_id;
            $i++;
        }
        return $rank_arr;
    }

    public function getCommissinTypes() {
        $commission_types = array();
        $this->db->select('db_amt_type,view_amt_type');
        $this->db->from('amount_type');
        $this->db->where('status' , 'yes') ; 
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $commission_types["$i"]["db_amt_type"] = $row['db_amt_type'];
            $commission_types["$i"]["view_amt_type"] = $row['view_amt_type'];
            $i++;
        }
        return $commission_types;
    }
    public function getUserBV() {
        $commission_types = array();
        $this->db->select('b.bv, f.user_name');
        $this->db->select("CONCAT_WS(' ', d.user_detail_name, d.user_detail_second_name) as name", false);
        $this->db->from('user_balance_amount as b');
        $this->db->join("ft_individual as f", "b.user_id = f.id", "INNER");
        $this->db->join("user_details as d", "b.user_id = d.user_detail_refid", "INNER");
        $this->db->where('b.bv >',0);
        $this->db->order_by('b.bv','desc');
        $query = $this->db->get();

        return $query->result_array();
    }
    
    public function getTopEarners(){
         $top_earners = array();
        
     $this->db->select('SUM(total_amount) as total_amount');
     $this->db->select('user_id');
     $this->db->from('leg_amount');
     $this->db->group_by('user_id');
     $this->db->order_by('total_amount','DESC');
     $this->db->limit(50);
     $query = $this->db->get();
     $i=0;
     foreach($query->result_array() as $row){
         $top_earners["details$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
         $top_earners["details$i"]["name"] = $this->validation_model->getUserFullName($row['user_id']);
         $top_earners["details$i"]["current_balance"] = round($this->validation_model->getUserBalanceAmount($row['user_id']),2);
         $top_earners["details$i"]["total_earnings"] = round($row['total_amount'],2);
         $i++;
     }
     return $top_earners;
    }

    

}
