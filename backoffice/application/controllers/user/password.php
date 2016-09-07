<?php

require_once 'Inf_Controller.php';

class Password extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function change_password() {
        $title = lang('change_password');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-password';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        //Function start for change password
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $this->set('user_type', $user_type);

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//        $table_prefix = substr($this->db->dbprefix, 0, -1);
//        if ((DEMO_STATUS == 'yes') && (($table_prefix == 5552) || ($table_prefix == 5553) || ($table_prefix == 5554) || ($table_prefix == 5555) || ($table_prefix == 5556))) {
//            $preset_demo = 'yes';
//        }
        
        if ($this->input->post('change_pass_button_admin') && $this->validate_change_password()) {
            // UNCOMMENT FOLLOWING 3 LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//            if ($preset_demo == 'yes' && (($user_name == 'INF750391') || ($user_name == 'INF823741') || ($user_name == 'INF792691') || ($user_name == 'INF793566') || ($user_name == 'INF867749'))) {
//                $msg = lang('this_option_is_not_available_for_preset_users');
//                $this->redirect($msg, 'tran_pass/change_passcode', FALSE);
//            }
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $current_pwd = $post_arr['current_pwd_admin'];
            $new_pwd = $post_arr['new_pwd_admin'];
            $cf_pwd = $post_arr['confirm_pwd_admin'];
            $new_pwd_md5 = md5($new_pwd);

            $update = $this->password_model->updatePassword($new_pwd_md5, $user_id, $user_type);
            if ($update) {

                $send_details = array();
                $type = 'change_password';
                $email = $this->validation_model->getUserEmailId($user_id);
                $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
                $send_details['new_password'] = $new_pwd;
                $send_details['email'] = $email;
                $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                $result = $this->mail_model->sendAllEmails($type, $send_details);
                $this->validation_model->insertUserActivity($user_id, 'password changed', $user_id);
                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', TRUE);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', FALSE);
            }
        }
        
        $this->set('preset_demo', $preset_demo);
        $this->setView();
    }

    function validate_change_password() {

        $user_id = $this->LOG_USER_ID;

        $post_arr = $this->input->post();
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
        $current_pwd = $post_arr['current_pwd_admin'];
        $new_pwd = $post_arr['new_pwd_admin'];
        $cf_pwd = $post_arr['confirm_pwd_admin'];
        $val = $this->password_model->validatePswd($new_pwd);

        $dbpassword = $this->password_model->selectPassword($user_id);

        if (!$current_pwd) {
            $msg = lang('you_must_enter_your_current_password');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (!$new_pwd) {
            $msg = lang('you_must_enter_new_password');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (!$val) {
            $msg = lang('special_chars_not_allowed');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (strcmp($dbpassword, md5($current_pwd)) != 0 || strlen($new_pwd) < 6) {
            $msg = lang('your_current_password_is_incorrect_or_new_password_is_too_short');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (strcmp($new_pwd, $cf_pwd) != 0) {
            $msg = lang('password_mismatch');
            $this->redirect($msg, 'password/change_password', FALSE);
        } else
            return TRUE;
    }

    function ajax_users_auto() {
        $this->AJAX_STATUS = true;
        $letters = $this->URL['letters'];
        $letters = preg_replace('/[^a-z0-9 ]/si', '', $letters);
        $str = $this->password_model->selectUser($letters);
        echo $str;
    }

}
