<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'Inf_Controller.php';

class Login extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $title = lang('login');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        if ($this->checkSuperAdminSession()) {
            $this->redirect("", 'home', true);
        }

        $this->CAPTCHA_STATUS = 'yes';

        $super_login_post = array();
        if ($this->session->userdata("inf_super_login_post")) {
            $super_login_post = $this->session->userdata("inf_super_login_post");
            $this->session->unset_userdata("inf_super_login_post");
        }
        $super_login_error = array();
        if ($this->session->userdata("inf_super_login_error")) {
            $super_login_error = $this->session->userdata("inf_super_login_error");
            $this->session->unset_userdata("inf_super_login_error");
        }
        if ($this->input->post('user_login') && $this->validate_super_admin_login()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $captcha = $this->session->userdata('inf_captcha');
            $captcha_text = $post_arr['captcha_text'];

            if ((empty($captcha) || trim(strtolower($captcha_text)) != $captcha)) {
                $captcha_message = lang('invalid_capcha');
                $this->redirect($captcha_message, "login", false);
            }

            $details = $this->login_model->checkSuperAdmin($post_arr);

            if (!$details) {
                $msg = lang('invalid_login_details');
                $this->redirect($msg, "login", false);
            } else {
                $details = $this->login_model->setSuperAdminSession($details);
                $this->redirect('', "home", true);
            }
        }

        $this->set('CAPTCHA_STATUS', $this->CAPTCHA_STATUS);
        $this->set('super_login_post', $super_login_post);
        $this->set('super_login_error', $super_login_error);

        $this->setView();
    }

    function validate_super_admin_login() {
        $this->form_validation->set_rules('super_user_name', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[50]|htmlentities');
        $this->form_validation->set_rules('super_password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[100]|htmlentities');

        $res_val = $this->form_validation->run();
        if ($res_val) {
            $post_arr = $this->input->post();
            $this->session->set_userdata("inf_super_login_post", $post_arr);
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_super_login_error', $error);
        }
        return $res_val;
    }

    function logout() {
        foreach ($this->session->userdata as $key => $value) {
            if (strpos($key, 'super_') === 0) {
                $this->session->unset_userdata("$key");
            }
        }
        $message = lang('sucessfully_logged_out');
        $this->redirect($message, "login", true);
    }

    public function unsubscribe_user($mail) {

        $title = lang('unsubscribe_user');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'Unsubscribe User';
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = 'Unsubscribe User';
        $this->HEADER_LANG['page_small_header'] = lang('');
       
        $mail = urldecode($mail);
        $mail = str_replace("_", "/", $mail);
        $mail = $this->encrypt->decode($mail);

      
        $this->load_langauge_scripts();

        $result=$this->login_model->changeSubscriptionStatus($mail);
     
        $this->set('status',$result);
        
        
        $this->setView();
    }

    public function validate_super_admin_unsubscribe() {
        $this->form_validation->set_rules('user_name', 'Username', 'trim|required|strip_tags|xss_clean|min_length[2]|htmlentities');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function super_mlm_users($user_name = "") {
        $this->load->model('select_report_model');
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $user_detail = $this->login_model->selectUser($letters);
        echo $user_detail;
    }

}
