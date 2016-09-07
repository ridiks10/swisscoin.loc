<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'Inf_Controller.php';

class Home extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $title = lang('home');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $demo_details = $this->home_model->getDemoDetails($this->session->userdata('super_demo_id'));
        $this->set('demo_details', $demo_details);

        $this->setView();
    }

    function update_super_details() {

        $title = "Update Super Admin Details";
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'Dashboard ';
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = 'Dashboard';
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $demo_id = $this->session->userdata('super_demo_id');
        $active_status = 0;
        $active_status = $this->home_model->getActiveStatus($demo_id);

        if ($this->input->post('block_software')) {

            $result = $this->home_model->blockDataBase($demo_id);

            if ($result) {
                $msg = "Block Database Sucessfully.";
                $this->redirect($msg, "super_admin_check/update_super_details", true);
            } else {
                $msg = "Error on block database.";
                $this->redirect($msg, "super_admin_check/update_super_details", false);
            }
        }
        if ($this->input->post('unblock_software')) {
            $result = $this->home_model->unBlockDataBase($demo_id);
            if ($result) {
                $msg = "UnBlock Database Sucessfully.";
                $this->redirect($msg, "super_admin_check/update_super_details", true);
            } else {
                $msg = "Error on UnBlock database.";
                $this->redirect($msg, "super_admin_check/update_super_details", false);
            }
        }

        if ($this->input->post('change_password')) {
            $random_number = time() * rand(1000, 9999);
            $result = $this->home_model->changePassword($demo_id, $random_number);
            if ($result) {
                $msg = "Password changed sucessfully .";
                $this->redirect($msg, "super_admin_check/update_super_details", true);
            } else {
                $msg = "Error on password changed database.";
                $this->redirect($msg, "super_admin_check/update_super_details", false);
            }
        }


        if ($this->input->post('delete_software') && $this->validate_super_admin_delete_reason()) {

            $result = $this->home_model->deleteDemo($demo_id);
            if ($result) {
                $msg = "Delete your database sucessfully.";
                $this->redirect($msg, "super_admin_check/update_super_details", true);
            } else {
                $msg = "Error on delete your database.";
                $this->redirect($msg, "super_admin_check/update_super_details", false);
            }
        }

        if ($this->input->post('back_login')) {
            $this->session->unset_userdata('inf_demo_id');
            $this->redirect('', "super_admin_check/check_super_admin", true);
        }
        $this->set("active_status", $active_status);

        $this->setView();
    }

    function validate_super_admin_delete_reason() {
        $this->form_validation->set_rules('delete_reason', 'delete reason', 'trim|required|strip_tags|xss_clean|min_length[2]|max_length[500]|htmlentities');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function change_password() {
        $title = "Change Super Admin Password";
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'Change Password';
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = 'Change Password';
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $demo_id = $this->session->userdata('super_demo_id');
        $active_status = 0;
        if ($this->input->post('change_password')) {
            $random_number = time() * rand(1000, 9999);
            $result = $this->home_model->changePassword($demo_id, $random_number);
            if ($result) {
                $msg = "Password changed sucessfully .";
                $this->redirect($msg, "home/change_password", true);
            } else {
                $msg = "Error on password changed database.";
                $this->redirect($msg, "home/change_password", false);
            }
        }
        $this->setView();
    }

    public function block_or_unblock() {

        $title = "Block Or Unblock User";
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'Block OR Unblock User ';
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = 'Block OR Unblock User ';
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $demo_id = $this->session->userdata('super_demo_id');
        $active_status = 0;
        $active_status = $this->home_model->getActiveStatus($demo_id);
        if ($this->input->post('block_software')) {
            $result = $this->home_model->blockDataBase($demo_id);
            if ($result) {
                $msg = "Block Database Sucessfully.";
                $this->redirect($msg, "home/block_or_unblock", true);
            } else {
                $msg = "Error on block database.";
                $this->redirect($msg, "home/block_or_unblock", false);
            }
        }
        if ($this->input->post('unblock_software')) {
            $result = $this->home_model->unBlockDataBase($demo_id);
            if ($result) {
                $result = $this->home_model->sendSuperAdminMails($demo_id, 'un_block_software');
                $msg = "UnBlock Database Sucessfully.";
                $this->redirect($msg, "super_admin_check/block_or_unblock", true);
            } else {
                $msg = "Error on UnBlock database.";
                $this->redirect($msg, "super_admin_check/block_or_unblock", false);
            }
        }

        $this->set("active_status", $active_status);
        $this->setView();
    }

    public function delete() {

        $title = "Delete Software";
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'Delete Software';
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = 'Delete Software';
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $demo_id = $this->session->userdata('super_demo_id');
        if ($this->input->post('delete_software') && $this->validate_super_admin_delete_reason()) {
            $delete_reason = $this->input->post('delete_reason');
            $result = $this->home_model->deleteDemo($demo_id);
            if ($result) {
                $this->home_model->insertDeleteReason($demo_id, $delete_reason);
                $msg = "Delete your database sucessfully.";
                echo $msg;
                die();
                $this->redirect($msg, "super_admin_check/delete", true);
            } else {
                $msg = "Error on delete your database.";
                $this->redirect($msg, "super_admin_check/delete", false);
            }
        }

        $this->setView();
    }

}
