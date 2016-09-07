<?php

Class home_model extends inf_model {

    public function __construct() {

        $this->load->model('validation_model');
        $this->load->model('joining_class_model');
        $this->load->model('joining_model');
        $this->load->model('mail_model');
        $this->load->model('epin_model');
        $this->load->model('ewallet_model');
        $this->load->model('payout_model');
        $this->load->model('webinars_model');
        $this->load->model('workshop_model');

        $this->load->model('my_report_model');
    }

    public function todaysJoiningCount($user_id = '') {
        $date = date("Y-m-d");
        return $this->joining_class_model->todaysJoiningCount($date, $user_id);
    }

    public function totalJoiningUsers($user_id = '') {
        return $this->joining_model->totalJoiningUsers($user_id);
    }

//    public function getAllFirstlineCount($user_id) {
//        $firstline = $this->validation_model->getFirstLine($user_id);
//        return count($firstline);
//    }

    public function getDownlineCount($id) {
        $down_line = 0;
        $this->db->select('left_father,right_father');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('ft_individual');
        if ($query->num_rows() > 0) {
            $left = $query->row()->left_father;
            $right = $query->row()->right_father;
            $down_line = ($right - $left - 1) / 2;
        }
        return $down_line;
    }

//    public function getAllSecondlineCount($id) {
//       $down_lines = array();
//       $next_lines = array();
//       array_push($next_lines, $id);
//       $down_lines = $this->getDownlines($next_lines, $down_lines, $level = 1);       
//       $i=0;
//       foreach ($down_lines as $row){
//            if($row['level']!=1){
//                $i++;
//            }
//        }
//        return $i-1;
//    }

    public function getAllReadMessages($type) {
        return $this->mail_model->getAllReadMessages($type);
    }

    public function getAllUnreadMessages($type) {
        return $this->mail_model->getAllUnreadMessages($type);
    }

    public function getCountUserUnreadMessages($type, $id) {
        return $this->mail_model->getCountUserUnreadMessages($type, $id);
    }

    public function getAllUserUnreadMessages($type) {
        return $this->mail_model->getAllUserUnreadMessages($type);
    }

    public function getAllMessagesToday($type) {
        return $this->mail_model->getAllMessagesToday($type);
    }

    public function getAllPinCount($user_id = '') {
        return $this->epin_model->getAllPinCount($user_id);
    }

    public function getUsedPinCount($user_id = '') {
        return $this->epin_model->getUsedPinCount($user_id);
    }

    public function getRequestedPinCount($user_id = '') {
        return $this->epin_model->getRequestedPinCount($user_id);
    }

    public function getGrandTotalEwallet($user_id = '') {
        return $this->ewallet_model->getGrandTotalEwallet($user_id);
    }

    public function getTotalRequestAmount($user_id = '') {
        return $this->ewallet_model->getTotalRequestAmount($user_id);
    }

    public function getTotalReleasedAmount($user_id = '') {
        return $this->ewallet_model->getTotalReleasedAmount($user_id);
    }

    public function getJoiningDetailsperMonth($user_id = '') {
        return $this->joining_model->getJoiningDetailsperMonth($user_id);
    }

    public function getPayoutReleasePercentages($user_id = '') {
        return $this->payout_model->getPayoutReleasePercentages($user_id);
    }

    function login($username, $password) {
        $this->db->select('user_id, user_name, password,user_type');
        $this->db->from('31_login_user');
        $this->db->where('user_name = ' . "'" . $username . "'");
        $this->db->where('password = ' . "'" . MD5($password) . "'");
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUnreadMessages($type, $user_id) {
        $result = array();
        if ($type == "admin") {
            $tbl = 'mailtoadmin';
            $this->db->select('*');
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->order_by("mailadiddate", "desc");
            $this->db->from($tbl);
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $rows) {
                $result[$i] = $rows;
                $result[$i]['username'] = $this->validation_model->IdToUserName($rows['mailaduser']);
                $mail_userid = $this->validation_model->userNameToID($result[$i]['username']);
                $result[$i]['image'] = $this->validation_model->getProfilePicture($mail_userid);
                $i++;
            }
            return $result;
        } else {

            $tbl = 'mailtouser';
            $this->db->select('*');
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->order_by("mailtousdate", "desc");
            $this->db->where('mailtoususer', $user_id);
            $this->db->from($tbl);
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $rows) {

                $result[$i]["mailaduser"] = $rows["mailtoususer"];
                $result[$i]["mailadsubject"] = $rows["mailtoussub"];
                $result[$i]["mailadiddate"] = $rows["mailtousdate"];
                $result[$i]['username'] = $this->validation_model->getAdminUsername();
                $mail_userid = $this->validation_model->userNameToID($result[$i]['username']);
                $result[$i]['image'] = $this->validation_model->getProfilePicture($mail_userid);
                $i++;
            }
            return $result;
        }
    }

    public function getSubMenuItems() {

        $infinite_mlm_sub_menu = $this->table_prefix . "infinite_mlm_sub_menu";
        $qrCat = "select * from  $infinite_mlm_sub_menu WHERE sub_status='yes' order by sub_order_id";
        $query = $this->selectData($qrCat, "eroro on 34657 435");
        $i = 0;
        while ($rows = mysql_fetch_array($query)) {
            $menu_item["detail$i"]["id"] = $rows['sub_id'];
            $menu_item["detail$i"]["link"] = $rows['sub_link'];
            $menu_item["detail$i"]["text"] = $rows['sub_text'];
            $menu_item["detail$i"]["status"] = $rows['sub_status'];
            $menu_item["detail$i"]["perm_admin"] = $rows['perm_admin'];
            $menu_item["detail$i"]["perm_emp"] = $rows['perm_emp'];
            $menu_item["detail$i"]["perm_dist"] = $rows['perm_dist'];
            $menu_item["detail$i"]["order_id"] = $rows['sub_order_id'];
            $i++;
        }
        return $menu_item;
    }

    public function getSiteUrl() {
        $this->db->select('lead_url');
        $this->db->from('site_information');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $site_url = $row->lead_url;
        }
        return $site_url;
    }

    public function getLastRegistration($user_id = '') {

        $admin_id = $this->validation_model->getAdminId();

        $data = array();

        $this->db->select('user_name,date_of_joining,id,user_detail_country,country_code,country_name');
        $this->db->from("ft_individual");

        $this->db->join('user_details', 'id=user_detail_refid', 'left');
        $this->db->join('infinite_countries', 'country_id=user_detail_country', 'left');
        $this->db->where('active !=', 'server');
        $this->db->where('id !=', $admin_id);
        $this->db->limit(10);

        $this->db->order_by("date_of_joining", "desc");
//        if ($user_id != $admin_id) {
//            $this->db->where('sponsor_id', $user_id);
//            $this->db->where('id !=', $user_id);
//        } else {
//            $this->db->where('id !=', $admin_id);
//        }
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @deprecated 1.21
     * @see moved to application/models/ajax_model
     */
    public function getNotifications() {
        $notifications = array();

        $date = date("Y-m-d H:i:s", time() - 30);

        $this->db->select('id,user_id,done_by,ip,activity');
        $this->db->from('activity_history');
        $this->db->where('date >', $date);
        $this->db->where('notification_status', 0);
        $this->db->where('done_by_type !=', 'admin');
        $this->db->where('done_by !=', '');
        $this->db->order_by('date', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {

            $doneby_user_name = $this->validation_model->idToUserName($row['done_by']);
            $user_name = $this->validation_model->idToUserName($row['user_id']);
            $ip = $row['ip'];
            $activity = $row['activity'];
            $message = sprintf(lang($activity), $doneby_user_name, $ip);
            if ($message == '') {
                $message = "$doneby_user_name performed '$activity'";
            }
            $row["message"] = $message;
            $notifications [] = $row;

            $this->db->set("notification_status", 1);
            $this->db->where("id", $row["id"]);
            $this->db->update("activity_history");
        }
        return $notifications;
    }

    public function getWebinarDetails() {
        return $this->webinars_model->getWebinars();
    }

    public function getWorkshopDetails() {
        return $this->workshop_model->getWorkshop();
    }

//    public function getDownlines($next_lines, $down_lines, $level) {
//        $this->db->select('id,user_name,user_rank_id');
//        $this->db->from('ft_individual');
//        $this->db->where('active', 'yes');
//        $this->db->where_in('father_id', $next_lines);
//        $query = $this->db->get();
//        $next_lines = array();
//        foreach ($query->result_array() as $row) {
//
//            $row['level'] = $level;
//            array_push($next_lines, $row['id']);
//            array_push($down_lines, $row);
//        }
//        if (empty($next_lines)) {
//            $down_lines['num_level'] = --$level;
//            return $down_lines;
//        } else {
//            $level++;
//            return $this->getDownlines($next_lines, $down_lines, $level);
//        }
//    }
//    public function getCashAccountSum($user_id){
//        $cash_account_sum=0;
//        $this->db->select_sum('cash_account');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get('leg_amount');
//         foreach ($query->result_array() as $rows) {
//                $cash_account_sum = $rows["cash_account"];
//            }
//        return $cash_account_sum;
//       
//    }
//     public function getTradingAccountSum($user_id){
//        $trading_account_sum=0;
//        $this->db->select_sum('trading_account');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get('leg_amount');
//         foreach ($query->result_array() as $rows) {
//                $trading_account_sum = $rows["trading_account"];
//            }
//        return $trading_account_sum;
//       
//    }
    public function getUserBonusThisWeek($user_id) {
        $user_amount = 0;
        $stage = $this->getLegAmountStage();
        $this->db->select_sum('amount_payable');
        $this->db->where('user_id', $user_id);
        $this->db->where('stage', $stage);
        $query = $this->db->get('leg_amount');
        foreach ($query->result_array() as $rows) {
            $user_amount = $rows["amount_payable"];
        }
        return $user_amount;
    }

    public function getUserBonusSinceStart($user_id) {
        $user_amount = 0;

        $this->db->select_sum('amount_payable');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('leg_amount');
        foreach ($query->result_array() as $rows) {
            $user_amount = $rows["amount_payable"];
        }
        return $user_amount;
    }

    public function getLegAmountStage() {
        $status = 1;
        $this->db->select_max('stage');
        $query = $this->db->get('leg_amount');
        $rowcount = $query->num_rows();
        if ($rowcount) {
            $status = $query->row()->stage;
        }
        return $status;
    }

}
