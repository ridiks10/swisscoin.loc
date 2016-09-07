<?php

Class activity_history_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }
    public function getActivityHistory($offset, $limit) {
        $activity_details = array();
        $query = $this->db
            ->select('*')
            ->order_by('date','desc')
            ->get('activity_history', $limit, $offset);
        $i=0;
        foreach ($query->result_array() as $row) {
            $activity_details[$i]['username_done']=  $this->validation_model->IdToUserName($row['done_by']);
            $activity_details[$i]['username']=  $this->validation_model->IdToUserName($row['user_id']);
            $activity_details[$i]['date']=  $row['date'];
            $activity_details[$i]['ip']= $row['ip'];
            $activity_details[$i]['activity']= $row['activity'];
            $i++;
        }
        return $activity_details;
    }

    public function getActivityHistoryCount() {
        return $this->db->count_all('activity_history');
    }
}