<?php

require_once 'Inf_Controller.php';

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

        if ($this->input->post('sent_passcode')) {
            $user_id = $this->LOG_USER_ID;
            $user_name = $this->LOG_USER_NAME;
            $user_type = $this->LOG_USER_TYPE;

            $passcode = $this->tran_pass_model->getUserPasscode($user_id);
            if ($passcode != '') {
                $result = $this->tran_pass_model->sentTransactionPasscode($user_id, $passcode, $user_name);
                if ($result) {
                        $data_array = array();
                        $data_array['tran_pass'] = $passcode;
                        $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($user_id, 'transaction password sent', $user_id, $data);
                    $msg = lang('transaction_password_send_successfully');
                    $this->redirect($msg, "tran_pass/send_transaction_passcode", true);
                } else {
                    $msg = lang('error_on_sending_transaction_password');
                    $this->redirect($msg, "tran_pass/send_transaction_passcode", false);
                }
            } else {
                $msg = lang('you_dont_have_transaction_password');
                $this->redirect($msg, "tran_pass/send_transaction_passcode", false);
            }
        }
        $this->setView();
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

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $user_type = $this->LOG_USER_TYPE;

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//        $table_prefix = substr($this->db->dbprefix, 0, -1);
//        if ((DEMO_STATUS == 'yes') && (($table_prefix == 5552) || ($table_prefix == 5553) || ($table_prefix == 5554) || ($table_prefix == 5555) || ($table_prefix == 5556))) {
//            $preset_demo = 'yes';
//        }

        if ($this->input->post('change') && $this->validate_change_passcode()) {
            // UNCOMMENT FOLLOWING 3 LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//            if ($preset_demo == 'yes' && (($user_name == 'INF750391') || ($user_name == 'INF823741') || ($user_name == 'INF792691') || ($user_name == 'INF793566') || ($user_name == 'INF867749'))) {
//                $msg = lang('this_option_is_not_available_for_preset_users');
//                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
//            }

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $new_passcode = $post_arr['new_passcode'];
            $old_passcode = $post_arr['old_passcode'];
            $passcode = $this->tran_pass_model->getUserPasscode($user_id);
            if ($old_passcode != $passcode) {
                $msg = lang('your_current_transaction_password_is_incorrect');
                $this->redirect($msg, "tran_pass/change_passcode", false);
            } else {
                $result = $this->tran_pass_model->updatePasscode($user_id, $new_passcode, $passcode);
                if ($result) {
                    $this->tran_pass_model->sentTransactionPasscode($user_id, $new_passcode, $user_name);
                    $this->validation_model->insertUserActivity($user_id, 'transaction password changed', $user_id);
                    $msg = lang('transaction_password_changed_successfully');
                    $this->redirect($msg, "tran_pass/change_passcode", true);
                } else {
                    $msg = lang('sorry_failed_to_update_try_again');
                    $this->redirect($msg, "tran_pass/change_passcode", false);
                }
            }
        }
        
        $this->set('preset_demo', $preset_demo);
        $this->setView();
    }

    function validate_change_passcode() {
        $this->form_validation->set_rules('old_passcode', lang('old_passcode'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_passcode', lang('new_password'), 'trim|required|strip_tags|min_length[8]|alpha_numeric');
        $this->form_validation->set_rules('re_new_passcode', lang('re_new_passcode'), 'trim|required|strip_tags|matches[new_passcode]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}
