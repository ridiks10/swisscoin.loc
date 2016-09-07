<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inf_Controller extends Core_Inf_Controller {

    public $DEMO_ID;
    public $DEMO_STATUS;

    function __construct() {

        parent::__construct();

        $this->load_super_inf_model();

        $is_logged_in = false;

        if (!in_array($this->CURRENT_CTRL, $this->NO_LOGIN_PAGES)) {
            $is_logged_in = $this->checkSuperAdminLogged();
        }

        if ($is_logged_in) {
            $this->update_session_status();

            $this->set_super_admin_data();

            $this->LEFT_MENU = $this->super_inf_model->getLeftMenu($this->CURRENT_URL);
        }
        $this->set_flash_message();

        $this->set_site_information();

        $this->set_public_variables();
    }

    function load_super_inf_model() {
        $this->load->model("super_admin/super_inf_model");
    }

    function checkSuperAdminSession() {
        $flag = isset($this->session->userdata['super_logged_in']) ? true : false;
        return $flag;
    }

    function checkSuperAdminLogged() {
        if (!$this->checkSuperAdminSession()) {
            $base_url = base_url();
            $login_link = $base_url . "super_admin/login";
            echo "You don't have permission to access this page ! . <a href='$login_link'>Login</a>";
            die();
        }
        return true;
    }

    function set_super_admin_data() {
        $super_logged_in_array = $this->session->userdata['super_logged_in'];
        $this->LOG_USER_ID = $super_logged_in_array['id'];
        $this->LOG_USER_NAME = $super_logged_in_array['user_name'];
        $this->DEMO_ID = $super_logged_in_array['id'];
        $this->DEMO_STATUS = $super_logged_in_array['account_status'];
    }

    function load_default_langauge() {
        $langs = ['common'];

        if (!in_array($this->CURRENT_CTRL, $this->NO_TRANSLATION_PAGES)) {
            $langs[] = "super_admin/" . $this->CURRENT_CTRL;
        }
        $this->lang->load($langs, $this->LANG_NAME);
    }

    function load_langauge_scripts() {
        $this->set_array_scripts();
        $this->set_header_language();
    }

    function set_array_scripts() {
        $this->VIEW_DATA_ARR['ARR_SCRIPT'] = $this->super_inf_model->getURLScripts($this->CURRENT_URL);
    }

    function set_header_language() {
        $this->VIEW_DATA_ARR['HEADER_LANG'] = $this->HEADER_LANG;
    }

    function setView() {

        $sub_directory = 'super_admin';
        $this->smarty->view("$sub_directory/" . $this->CURRENT_CTRL . '/' . $this->CURRENT_MTD . '.tpl', $this->VIEW_DATA_ARR);
    }

    function redirect($msg, $page, $message_type = false, $MSG_ARR = array()) {
        $MSG_ARR["MESSAGE"]["DETAIL"] = $msg;
        $MSG_ARR["MESSAGE"]["TYPE"] = $message_type;
        $MSG_ARR["MESSAGE"]["STATUS"] = true;
        $this->session->set_flashdata('MSG_ARR', $MSG_ARR);

        $path = base_url();

        $path .= "super_admin/$page";
        redirect("$path", 'refresh');
        exit();
    }

}
