<?php

class ajax_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getNotifications() {
        $notifications = array();

        $date = date("Y-m-d H:i:s", time() - 30);

        $this->db->select('ah.id, ah.user_id, ft.user_name as done_by, ah.ip, ah.activity')
                ->from('activity_history as ah')
                ->join('ft_individual as ft', 'ah.done_by = ft.id')
                ->where('date >', $date)
                ->where('notification_status', 0)
                ->where('done_by_type !=', 'admin')
                ->where('done_by !=', '')
                ->order_by('date', 'DESC')
                ->order_by('id', 'DESC')
                ->limit(5);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $ip = $row['ip'];
            $activity = $row['activity'];
            $message = sprintf(lang($activity), $row['done_by'], $ip);
            if ($message == '') {
                $message = "{$row['done_by']} performed '{$activity}'";
            }
            $row["message"] = $message;
            $notifications [] = $row;

            $this->db->set("notification_status", 1);
            $this->db->where("id", $row["id"]);
            $this->db->update("activity_history");
        }
        return $notifications;
    }
    
}