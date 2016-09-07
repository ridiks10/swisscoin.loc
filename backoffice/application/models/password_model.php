<?php

class password_model extends inf_model {

    public $mail;

    public function __construct() {
        parent::__construct();
        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
    }

    public function isUserNameAvailable($user_name) {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function selectPassword($id) {
        $dbpassword = '';
        $this->db->select('password');
        $this->db->from('login_user');
        $this->db->where('user_id', $id);
        $this->db->where('addedby !=', 'server');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $dbpassword = $row['password'];
        }
        return $dbpassword;
    }

    public function updatePassword($new_pwd, $id = '', $user_type = '', $user_ref_id = '') {
        $this->db->set('password', $new_pwd);
        $this->db->where('user_id', $id);
        $res = $this->db->update('login_user');
        if ($user_type == 'admin' && DEMO_STATUS == 'yes') {
            $res = $this->db->query("update infinite_mlm_user_detail SET pswd ='$new_pwd' WHERE id='$user_ref_id'");
        }
        return $res;
    }

    public function sentPassword($user_id, $password, $user_name) {

        $letter_arr = $this->getLetterSetting();
        $company_name = $letter_arr['company_name'];
        $place = $letter_arr['place'];
        $subject = 'Password Change';
        $dt = date('Y-m-d h:m:s');
        $full_name = $this->validation_model->getUserFullName('$user_id');
        $mail_details = $this->validation_model->getCommonMailSettings('forgot_pswd');
        $mail_details['mail_content'] = str_replace('{full_name}', $full_name, $mail_details['mail_content']);
        $mail_details['mail_content'] = str_replace('{user_name}', $user_name, $mail_details['mail_content']);
        $mail_details['mail_content'] = str_replace('{password}', $password, $mail_details['mail_content']);
        $mail_details['mail_content'] = str_replace('{company_name}', $company_name, $mail_details['mail_content']);
        $mail_details['mail_content'] = str_replace('{date}', $dt, $mail_details['mail_content']);
        $mail_details['mail_content'] = str_replace('{place}', $place, $mail_details['mail_content']);

        $this->validation_model->sendEmail($mail_details['mail_content'], $user_id, $mail_details['subject']);

        return true;
    }

    public function getPassword($user_id) {
        $this->db->select('password');
        $this->db->from('login_user');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $dbpassword = $row['password'];
        }
        return $dbpassword;
    }

    public function getLetterSetting() {

        $this->db->select('*');
        $this->db->from('letter_config');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $arr['company_name'] = $row['company_name'];
            $arr['address_of_company'] = $row['address_of_company'];
            $arr['main_matter'] = $row['main_matter'];
            $arr['logo'] = $row['logo'];
            $arr['productmatter'] = $row['productmatter'];
            $arr['place'] = $row['place'];
        }

        return $arr;
    }

    function validatePswd($password) {
        if (!preg_match('/^[a-z0-9A-Z_\-!@#\$%&\*\(\)?<>|\\+\/\[\]{}\'";=]*$/', $password)) {

            return false;
        } else
            return true;
    }

}
