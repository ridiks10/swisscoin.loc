<?php

Class moodle_model extends inf_model {

    public $table = 'login_user';

    private $mail_config = array();
    private $mail_template = '/export_user_mail.tpl';

    public function __construct() {
        parent::__construct();

        $mail_details = $this->register_model->getSmtpEmailDetails();

        // 1
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = $mail_details['host'];
        $config['smtp_port'] = $mail_details['port'];
        $config['smtp_timeout'] = $mail_details['time_out'];
        $config['smtp_user'] = $mail_details['username'];
        $config['smtp_pass'] = $mail_details['password'];
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['validation'] = TRUE;

        // 2
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.swisscoin.eu';
        $config['smtp_port'] = '587';
        $config['smtp_timeout'] = $mail_details['time_out'];
        $config['smtp_user'] = 'no-reply@swisscoin.eu';
        $config['smtp_pass'] = '$tp4Sg';
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['validation'] = TRUE;

        $this->mail_config = $config;
    }

    public function getUserList() {
        $this->db->select('*');
        $users = $this->db->get('login_user')->result();

        return $users;
    }

    public function getUserById($user_id) {
        $this->db->select('*');
        $this->db->where("user_id", $user_id);
        $users = $this->db->get('login_user')->row();

        return $users;
    }

    public function getUserByName($username) {
        $this->db->select('*');
        $this->db->where("user_name", $username);
        $users = $this->db->get('login_user')->row();

        return $users;
    }

    public function getUserDetail($user_id) {
        $this->db->select('*');
        $this->db->where("user_detail_refid", $user_id);
        $users = $this->db->get('user_details')->row();

        return $users;
    }

    public function createUser($user, $user_detail, $password = null, $change_password = true) {
        $this->load->library('moodle_api');
        $this->load->library('email');
        $this->load->model('country_state_model');
        $this->load->model('configuration_model');
        $this->load->model('inf_model');
        $this->load->helper('string');

        $site_info = $this->configuration_model->getSiteConfiguration();

        $languages = $this->inf_model->getAllLanguages();

        $password = !empty($password) ? $password : random_string('alnum', 8);

        $fields = array(
            'username' => $user->user_name,
            'password' => $password,
            'firstname' => $user_detail->user_detail_name,
            'lastname' => $user_detail->user_detail_second_name,
            'email' => $user_detail->user_detail_email,
            'country' => $this->country_state_model->getCountryCodeFromId($user_detail->user_detail_country),
        );

        if ($change_password) {
            $fields['preferences'] = array(array('type' => 'auth_forcepasswordchange', 'value' => true));
        }

        $new_user = $this->moodle_api->createUser($fields);
        if (!empty($new_user) && !empty($new_user['id'])) {
            $this->moodle_api->freeEnrollUser($new_user['id']);
        }

        if (!empty($new_user)) {
            $mail_subject = 'You have been registered in Academy';
            $language = 'en';
            foreach($languages as $lang) {
                if ($user->default_lang == $lang['lang_id']) {
                    $language = $lang['lang_code'];
                }
            }

            $mail_template = 'mail/' . $language . $this->mail_template;

            $email_view_data = array(
                'user' => $user,
                'user_detail' => $user_detail,
                'base_url' => 'http://swisscoin.eu/backoffice/',
                'site_logo' => $site_info['logo'],
                'password' => $password,
            );
            $mail_message = $this->smarty->view($mail_template, $email_view_data, true);

            // 1
            $this->email->clear();
            $this->email->from($this->mail_config['smtp_user'], 'admin');
            $this->email->to($user_detail->user_detail_email);
            $this->email->subject($mail_subject . '!-');
            $this->email->message($mail_message);
            $this->email->set_mailtype("html");
            $this->email->send();

            // 2
            $this->email->clear();
            $this->email->initialize($this->mail_config);
            $this->email->from($this->mail_config['smtp_user'], 'admin');
            $this->email->to($user_detail->user_detail_email);
            $this->email->subject($mail_subject . '!+');
            $this->email->message($mail_message);
            $this->email->set_mailtype("html");
            $this->email->send();

            // 3
            $headers = 'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=utf-8' . "\r\n" .
                'From:  admin <' . $this->mail_config['smtp_user'] . '>';
            mail($user_detail->user_detail_email, $mail_subject, $mail_message, $headers);
        }

        return $new_user;
    }
}
