<?php

class tran_pass_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function getUserPasscode($user_id) {
        $tran_password = '';
        $this->db->select('tran_password');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('tran_password');

        foreach ($query->result_array() as $rows) {
            $tran_password = $rows['tran_password'];
        }
        return $tran_password;
    }

    public function sentTransactionPasscode($user_id, $passcode, $user_name) {
        $type = "send_tranpass";
        $email = $this->validation_model->getUserData($user_id, "user_detail_email");
        $first_name = $this->validation_model->getUserData($user_id, "user_detail_name");
        $last_name = $this->validation_model->getUserData($user_id, "user_detail_name");
        $send_details = array("email" => $email, "tranpass" => $passcode, "first_name" => $first_name, "last_name" => $last_name);
        $res = $this->mail_model->sendAllEmails($type, $send_details);
        return $res;
    }

    public function getLetterSetting() {
        $letter_arr = array();
        $this->db->select('*');
        $this->db->from('letter_config');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $rows) {
            $letter_arr['company_name'] = $rows['company_name'];
            $letter_arr['address_of_company'] = $rows['address_of_company'];
            $letter_arr['main_matter'] = $rows['main_matter'];
            $letter_arr['logo'] = $rows['logo'];
            $letter_arr['productmatter'] = $rows['productmatter'];
            $letter_arr['place'] = $rows['place'];
        }

        return $letter_arr;
    }

    /**
     * 
     * @param int $user_id
     * @param string $new This value will be escaped!
     * @param string $old This value will be escaped!
     * @return type
     */
    public function updatePasscode($user_id, $new, $old = '') {
        if ($old != '') {
            $this->db->set('tran_password', $new);
            $this->db->where('user_id', $user_id);
            $this->db->where('tran_password', $old);
            $query = $this->db->update('tran_password');
        } else {
            $this->db->set('tran_password', $new);
            $this->db->where('user_id', $user_id);
            $query = $this->db->update('tran_password');
        }
        return $query;
    }

}
