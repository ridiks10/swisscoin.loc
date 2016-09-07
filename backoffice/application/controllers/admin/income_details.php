<?php

require_once 'Inf_Controller.php';

class Income_Details extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function income() {

        $title = lang('income_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'income-details';
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('income_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $is_valid_username = false;
        $amount = array();

        if ($this->input->post('user_name') && $this->validate_income()) {
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);

            if ($user_id) {
                $is_valid_username = true;
                $amount = $this->income_details_model->add_income($user_id);
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'income_details/income', false);
            }
        }

        $this->set('is_valid_username', $is_valid_username);
        $this->set('amount', $amount);
        $this->set('user_name', $user_name);

        $this->setView();
    }

    function validate_income() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}

?>