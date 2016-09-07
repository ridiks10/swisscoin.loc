<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inf_Controller extends Core_Inf_Controller {

    function __construct() {

        parent::__construct();

        $this->set_flash_message();

        $this->set_site_information();

        $this->set_public_variables();
    }

    function initialize_public_variables() {
        $this->SESS_STATUS = FALSE;
        $this->MODULE_STATUS = array();
        $this->MLM_PLAN = 'Unilevel';
        $this->LANG_ID = 1;
        $this->LANG_NAME = 'english';
        $this->table_prefix = '55_';
        $this->CURRENT_CTRL = $this->router->class;
        $this->CURRENT_MTD = $this->router->method;
        $this->CURRENT_URL_FULL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->REDIRECT_URL_FULL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->CURRENT_URL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->IP_ADDR = $this->input->server('REMOTE_ADDR');
        $this->BASE_URL = base_url();
        $this->PUBLIC_URL = $this->BASE_URL . "public_html/";
        $this->DEFAULT_CURRENCY_VALUE = 1;
        $this->DEFAULT_CURRENCY_CODE = 'EUR';
        $this->DEFAULT_SYMBOL_LEFT = '€';
        $this->DEFAULT_SYMBOL_RIGHT = '';
        $this->ADMIN_THEME_FOLDER = 'default';
        $this->USER_THEME_FOLDER = 'default';
        $this->COMMON_PAGES = array("login", "register", "auto_register", "captcha", "time", "social_invites");
        $this->NO_LOGIN_PAGES = array("login", "captcha", "backup", "time", "cron", "fix_issues", "test_mail", "oc_register", "social_invites");
        $this->NO_TRANSLATION_PAGES = array("auto_register", "captcha", "time", "fix_issues", "test_mail", "oc_register", "social_invites");
        $this->NO_MODEL_CLASS_PAGES = array("auto_register", "time", "test_mail");
        $this->CSRF_TOKEN_NAME = $this->security->get_csrf_token_name();
        $this->CSRF_TOKEN_VALUE = $this->security->get_csrf_hash();

        $this->FROM_MOBILE = true;

        $this->NO_LOGIN_PAGES[] = "tree";
        $this->NO_LOGIN_PAGES[] = "android";
        $this->NO_LOGIN_PAGES[] = "token";

        $this->NO_MODEL_CLASS_PAGES[] = "android";
        $this->NO_MODEL_CLASS_PAGES[] = "token";

        $this->NO_TRANSLATION_PAGES[] = "android";
        $this->NO_TRANSLATION_PAGES[] = "token";
    }

    function setView() {

        $sub_directory = 'mobile';
        $this->smarty->view("$sub_directory/" . $this->CURRENT_CTRL . '/' . $this->CURRENT_MTD . '.tpl', $this->VIEW_DATA_ARR);
    }

}
