<?php



class feedback_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function addFeedback($feedback_user, $feed_company, $feed_phone, $feed_time, $feed_email, $feed_comment) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('feedback_user_id', $feedback_user);
        $this->db->set('feedback_company', $feed_company);
        $this->db->set('feedback_email', $feed_email);
        $this->db->set('feedback_phone', $feed_phone);
        $this->db->set('feedback_time', $feed_time);
        $this->db->set('feedback_remark', $feed_comment);
        $this->db->set('feedback_date', $date);
        $res = $this->db->insert('feedback');
        return $res;
    }

    public function getAllfeedback($user_id = '') {
        $feedback_details = array();
        $this->db->order_by('feedback_date', 'desc');
        if ($user_id)
            $this->db->where('feedback_user_id', $user_id);
        $query = $this->db->get('feedback');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $feedback_details[$i]['feedback_id'] = $row['feedback_id'];
            $feedback_details[$i]['feedback_name'] = $this->validation_model->IdToUserName($row['feedback_user_id']);
            $feedback_details[$i]['feedback_company'] = $row['feedback_company'];
            $feedback_details[$i]['feedback_email'] = $row['feedback_email'];
            $feedback_details[$i]['feedback_phone'] = $row['feedback_phone'];
            $feedback_details[$i]['feedback_time'] = $row['feedback_time'];
            $feedback_details[$i]['feedback_remark'] = $row['feedback_remark'];
            $feedback_details[$i]['feedback_date'] = $row['feedback_date'];
            $i++;
        }
        return $feedback_details;
    }

    public function deleteFeedback($id) {
        $this->db->where('feedback_id', $id);
        $res = $this->db->delete('feedback');
        return $res;
    }

}