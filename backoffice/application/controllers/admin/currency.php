<?php

require_once 'Inf_Controller.php';

class currency extends Inf_Controller {

    public function currency_management($delete = '') {

        $title = lang('currency_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('currency_management');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('currency_management');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $help_link = "currency Management";
        $this->set("help_link", $help_link);

        if ($this->input->post('update')) {
            if ($this->validate_currency_management()) {
                $det = $this->input->post();
                $det = $this->validation_model->stripTagsPostArray($det);
                $det = $this->validation_model->escapeStringPostArray($det);
                if ($det['currency_value'] <= 0) {
                    $msg = lang('currency_value_must_be_greater_than_zero');
                    $this->redirect($msg, 'currency/currency_management', FALSE);
                }
                $res = $this->currency_model->insertCurrencyDetails($det);
                if ($res) {
                    $data = serialize($det);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'currency added', $this->LOG_USER_ID, $data);
                    $msg = lang('currency_added');
                    $this->redirect($msg, 'currency/currency_management', TRUE);
                } else {
                    $msg = lang('Unable_to_add_currecy');
                    $this->redirect($msg, 'currency/currency_management', TRUE);
                }
            }
        }

        $currency_details = $this->currency_model->getCurrencyDetails();
        $this->set('currency_details', $currency_details);
        $conversion_status = $this->currency_model->getConversionStatus();

        $this->set('conversion_status', $conversion_status);

        $this->setView();
    }

    function validate_currency_management() {

        $this->form_validation->set_rules('currency_title', 'title', 'required|alpha');
        $this->form_validation->set_rules('currency_code', 'currency code', 'required|alpha');
        $this->form_validation->set_rules('currency_value', 'currency_value', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function edit_currency($currency_id = '') {
        $title = 'Edit currency_details';
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('currency_management');
        $this->HEADER_LANG['page_top_small_header'] = lang('edit_currency');
        $this->HEADER_LANG['page_header'] = lang('edit_currency');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'Edit currency_details';
        $this->set("help_link", $help_link);

        $currency_details = $this->currency_model->getCurrencyDetailsById($currency_id);

        $this->set('currency_details', $currency_details);
        if ($this->input->post('update')) {

            if ($this->validate_currency_management()) {
                $det = $this->input->post();
                $det = $this->validation_model->stripTagsPostArray($det);
                $det = $this->validation_model->escapeStringPostArray($det);
                if ($det['currency_value'] <= 0) {
                    $msg = lang('currency_value_must_be_greater_than_zero');
                    $this->redirect($msg, 'currency/currency_management', FALSE);
                }
                $res = $this->currency_model->updateCurrencyDetails($det);
                if ($res) {
                    $data = serialize($det);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'currency updated', $this->LOG_USER_ID, $data);
                    $msg = lang('currency_updated');
                    $this->redirect($msg, 'currency/currency_management', TRUE);
                } else {
                    $msg = lang('Unable_to_update_currecy');
                    $this->redirect($msg, 'currency/currency_management', FALSE);
                }
            }
        }

        $this->setView();
    }

    public function delete_currency() {
        $currency_id = $this->input->post('currency_id');
        $res = $this->currency_model->deleteCurrency($currency_id);
        if ($res) {
            $data_array['currency_id'] = $currency_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'currency deleted', $this->LOG_USER_ID, $data);
            $msg = lang('currency_deleted');
            $this->redirect($msg, 'currency/currency_management', TRUE);
        } else {
            $msg = lang('Unable_to_delete_currecy');
            $this->redirect($msg, 'currency/currency_management', TRUE);
        }
    }

    public function set_default_currency($currency_id) {
        $session_data = $this->session->userdata('inf_logged_in');
        $user_id = $session_data['user_id'];
        $res = $this->currency_model->setDefaultCurrency($currency_id, $user_id);
        if ($res) {
            $data_array['currency_id'] = $currency_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'default currency updated', $this->LOG_USER_ID, $data);
            $msg = lang('default_currency_updated');
            $this->redirect($msg, 'currency/currency_management', TRUE);
        } else {
            $msg = lang('unable_to_update_default_currency');
            $this->redirect($msg, 'currency/currency_management', false);
        }
    }

    public function automatic_currency_conversion() {

        $admin_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $result = $this->currency_model->automaticCurrencyUpdate($admin_default_currency['code']);
        if ($result) {
            $msg = lang('Currency_values_are_updated');
            $this->redirect($msg, 'currency/currency_management', true);
        } else {
            $msg = lang('unable_to_update_currency_values');
            $this->redirect($msg, 'currency/currency_management', false);
        }
    }

    public function change_currency($id = '') {
        $user_id = $this->LOG_USER_ID;
        echo $this->currency_model->updateUserCurrency($id, $user_id);
    }

    function delete($delete_id = '') {

        $result = $this->currency_model->deleteCurrency($delete_id);
        if ($result) {
            $data_array['currency_id'] = $delete_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'currency deleted', $this->LOG_USER_ID, $data);
            $msg = lang('currency_deleted_successfully');
            $this->redirect($msg, 'currency/currency_management', TRUE);
        } else {
            $msg = lang('error_on_deleting_currency');
            $this->redirect($msg, 'currency/currency_management', FALSE);
        }
    }

}
