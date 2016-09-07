<?php

require_once 'Inf_Controller.php';

class Leg_Count extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function view_leg_count() {

        $title = lang('leg_count');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'commission-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('commission_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('commission_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $product_status = $this->MODULE_STATUS['product_status'];
        $this->leg_count_model->initialize($product_status);
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $mlm_plan = $this->MLM_PLAN;
        $is_valid_username = "";
        $user_name = $this->LOG_USER_NAME;
        $user_leg_detail = $numrows = $result_per_page = 0;

        ////////////////////Niyasali////////////
        $legcount = FALSE;
        if ($this->input->post('user_name') && $this->validate_view_leg_count()) {
            $base_url = base_url() . 'leg_count/view_leg_count';
            $config['base_url'] = $base_url;
            $config['per_page'] = 25;
            if ($this->uri->segment(4) != "")
                $page = $this->uri->segment(4);
            else
                $page = 0;

            $legcount = TRUE;
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if ($is_valid_username) {
                $users = $this->leg_count_model->getUserIdFromUserName($user_name);
                $user_id = $users['user_id'];
                $user_type = $users['user_type'];
                $user_name = $users['user_name'];
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'leg_count/view_leg_count', false);
            }

            $user_leg_detail = $this->leg_count_model->getUserLegDetails($user_id, $page, $config['per_page'], $user_type);
            $numrows = $this->leg_count_model->getCountUserLegDetails($user_id, $user_type);

            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
        }
        ////////////////////////////////

        $this->set('user_leg_detail', $user_leg_detail);
        $this->set('count', $numrows);
        $this->set('result_per_page', $result_per_page);
        $this->set('mlm_plan', $mlm_plan);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('user_name', $user_name);
        $this->set('legcount', $legcount);

        $this->setView();
    }

    function validate_view_leg_count() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}

?>