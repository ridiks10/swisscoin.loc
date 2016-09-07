<?php

require_once 'Inf_Controller.php';

/**
 * @property-read tran_pass_model $tran_pass_model 
 */
class tran_pass extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function send_transaction_passcode() {
        $title = lang('send_transaction_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'send-transaction-passcode';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('send_transaction_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('send_transaction_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('sent_passcode') && $this->validate_send_transaction_passcode()) {
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tran_pass/send_transaction_passcode', false);
            } else {
                $passcode = $this->tran_pass_model->getUserPasscode($user_id);
                if ($passcode != '') {
                    $result = $this->tran_pass_model->sentTransactionPasscode($user_id, $passcode, $user_name);
                    if ($result) {
                        $data_array['user_id'] = $user_id;
                        $data_array['tran_password'] = $passcode;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'transaction password sent', $user_id, $data);
                        $msg = lang('transaction_password_send_successfully');
                        $this->redirect($msg, 'tran_pass/send_transaction_passcode', true);
                    } else {
                        $msg = lang('error_on_sending_transaction_password');
                        $this->redirect($msg, 'tran_pass/send_transaction_passcode', false);
                    }
                } else {
                    $msg = lang('you_dont_have_transaction_password');
                    $this->redirect($msg, 'tran_pass/send_transaction_passcode', false);
                }
            }
        }

        $this->setView();
    }

    function validate_send_transaction_passcode() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function change_passcode() {
        $title = lang('change_transaction_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'change-passcode';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_transaction_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_transaction_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = ' active';
        $tab2 = '';
        $user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;

        if ($user_type == 'employee') {
            $tab2 = ' active';
            $tab1 = '';
        }

        $preset_demo = 'no';
        if ($this->input->post('change_tran') && $this->validate_change_passcode()) {
            if ($preset_demo == 'yes') {
                $msg = lang('this_option_is_not_available_in_preset_demos');
                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
            }
            $old_passcode = $this->input->post('old_passcode');
            $new_passcode = $this->input->post('new_passcode');
            $passcode = $this->tran_pass_model->getUserPasscode($user_id);

            if ($old_passcode != $passcode) {
                $msg = lang('your_current_transaction_password_is_incorrect');
                $this->redirect($msg, "tran_pass/change_passcode", FALSE);
            } else {
                $result = $this->tran_pass_model->updatePasscode($user_id, $new_passcode, $passcode);
                if ($result) {
                    $this->tran_pass_model->sentTransactionPasscode($user_id, $new_passcode, $user_name);
                    $data_array['user_id'] = $user_id;
                    $data_array['new_tran_password'] = $new_passcode;
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'transaction password changed', $user_id, $data);
                    $msg = lang('transaction_password_updated_successfully');
                    $this->redirect($msg, "tran_pass/change_passcode", TRUE);
                } else {
                    $msg = lang('sorry_failed_to_update_try_again');
                    $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                }
            }
        }

        if ($this->input->post('change_user') && $this->validate_change_passcode_user()) {
            $user_name_submit = $this->input->post('user_name');
            $user_id_submit = $this->validation_model->userNameToID($user_name_submit);
            if ($user_id_submit) {
                $user_type_submit = $this->validation_model->getUserType($user_id_submit);
                if ($user_type_submit == 'admin') {
                    $msg = lang('You_cant_change_admin_transaction_password');
                    $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                } else {
                    $new_passcode_user = $this->input->post('new_passcode_user');
                    $result = $this->tran_pass_model->updatePasscode($user_id_submit, $new_passcode_user);
                    if ($result) {
                        $this->tran_pass_model->sentTransactionPasscode($user_id_submit, $new_passcode_user, $user_name_submit);
                        $data_array['user_id'] = $user_id_submit;
                        $data_array['new_tran_password'] = $new_passcode_user;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($user_id, 'transaction password changed', $user_id_submit, $data);
                        $msg = lang('transaction_password_updated_successfully');
                        $this->redirect($msg, "tran_pass/change_passcode", true);
                    } else {
                        $msg = lang('sorry_failed_to_update_try_again');
                        $this->redirect($msg, "tran_pass/change_passcode", FALSE);
                    }
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
            }
        }

        if ($this->session->userdata('inf_tranpass_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_tranpass_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_tranpass_tab_active_arr']['tab2'];
            $this->session->unset_userdata("inf_tranpass_tab_active_arr");
        }

        $this->set('preset_demo', $preset_demo);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);

        $this->setView();
    }

    function validate_change_passcode() {
        $tab1 = 'active';
        $tab2 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $this->form_validation->set_rules('old_passcode', lang('old_passcode'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_passcode', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode]');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function validate_change_passcode_user() {
        $tab1 = '';
        $tab2 = 'active';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_passcode_user', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode_user', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode_user]');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

}
