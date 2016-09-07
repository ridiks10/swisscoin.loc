<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inf_Controller extends Core_Inf_Controller {

    function __construct() {

        parent::__construct();

        $is_logged_in = false;
        if (!in_array($this->CURRENT_CTRL, $this->NO_LOGIN_PAGES)) {
            $is_logged_in = false;
            if (!in_array($this->CURRENT_CTRL, $this->COMMON_PAGES)) {
                $is_logged_in = $this->checkUserLogged();
            } else {
                $is_logged_in = $this->checkLogged();
            }
        } else {
            if (DEMO_STATUS == 'no' && in_array("register", $this->NO_LOGIN_PAGES)) {
                if ($this->checkSession()) {
                    $is_logged_in = true;
                }
            }
        }

        if ($is_logged_in) {

            $this->update_session_status();

            if (!$this->input->is_ajax_request()) {
                $this->set_header_mailbox();
            }

            $this->LEFT_MENU = $this->menu->BuildMenu($this->LOG_USER_ID, $this->LOG_USER_TYPE, $this->CURRENT_URL);

            if (DEMO_STATUS == 'yes' && $this->MODULE_STATUS['footer_demo_status'] == "yes") {
                $this->set_demo_upgrade_status();
            }
        }

        $this->set_flash_message();

        $this->set_site_information();

        $this->set_public_variables();
    }

}
