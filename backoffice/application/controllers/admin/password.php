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

        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $tab2 = ' active';
            $tab1 = '';
        } else {
            $tab1 = ' active';
            $tab2 = '';
        }
        $table_prefix = $this->password_model->table_prefix;
        $user_ref_id = str_replace('_', '', $table_prefix);
        $this->set('user_type', $user_type);
        $msg = '';

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING 3 LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
        
//        if ((DEMO_STATUS == 'yes') && (($user_id == 5604) || ($user_id == 5553) || ($user_id == 5605) || ($user_id == 5606) || ($user_id == 5607))) {
//            $preset_demo = 'yes';
//        }
        
        ///admin password......
        if ($this->input->post('change_pass_button_admin') && $this->validate_change_password_change_pass_admin()) {
            if($preset_demo == 'yes') {
                $msg = lang('this_option_is_not_available_in_preset_demos');
                $this->redirect($msg, 'password/change_password', FALSE);
            }
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $current_pwd = $post_arr['current_pwd_admin'];
            $new_pwd = $post_arr['new_pwd_admin'];
            $cf_pwd = $post_arr['confirm_pwd_admin'];
            $new_pwd_md5 = md5($new_pwd);

            $update = $this->password_model->updatePassword($new_pwd_md5, $user_id, $user_type, $user_ref_id);

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

                $data = serialize($send_details);
                $this->validation_model->insertUserActivity($user_id, 'password changed', $user_id, $data);
                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', TRUE);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', FALSE);
            }
        }
        //admin passwod ends
        //user password in admin 
        if ($this->input->post('change_pass_button_common') && $this->validate_change_password_change_pass_common()) {            
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $name_user = $post_arr['user_name_common'];
            $id_user = $this->validation_model->userNameToID($name_user);
            $new_pwd_user = $post_arr['new_pwd_common'];
            $cf_pwd_user = $post_arr['confirm_pwd_common'];
            $new_pwd_user_md5 = md5($new_pwd_user);
            
            if($preset_demo == 'yes' && (($name_user == 'INF750391') || ($name_user == 'INF823741') || ($name_user == 'INF792691') || ($name_user == 'INF793566') || ($name_user == 'INF867749'))) {
                $msg = lang('this_option_is_not_available_for_preset_users');
                $this->redirect($msg, 'password/change_password', FALSE);
            }
            
            $update = $this->password_model->updatePassword($new_pwd_user_md5, $id_user);
            if ($update) {

                $send_details = array();
                $type = 'change_password';
                $email = $this->validation_model->getUserEmailId($id_user);
                $send_details['full_name'] = $this->validation_model->getUserFullName($id_user);
                $send_details['new_password'] = $new_pwd_user;
                $send_details['email'] = $email;
                $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                $result = $this->mail_model->sendAllEmails($type, $send_details);
                $this->validation_model->insertUserActivity($id_user, 'password change', $user_id);
                $msg = lang('password_updated_successfully');
                $this->redirect($msg, 'password/change_password', TRUE);
            } else {
                $msg = lang('error_on_password_updation');
                $this->redirect($msg, 'password/change_password', FALSE);
            }
            //user password in admin end  
        }

        if ($this->session->userdata('inf_pass_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_pass_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_pass_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_pass_tab_active_arr');
        }

        $this->set('preset_demo', $preset_demo);
        $this->set('user_type', $user_type);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
    }

    function validate_change_password_change_pass_admin() {

        $tab1 = ' active';
        $tab2 = '';
        $this->session->set_userdata('inf_pass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $user_id = $this->LOG_USER_ID;

        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
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

    function validate_change_password_change_pass_common() {

        $tab1 = '';
        $tab2 = ' active';
        $this->session->set_userdata('inf_pass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        $name_user = $post_arr['user_name_common'];
        $id_user = $this->validation_model->userNameToID($name_user);
        $new_pwd_user = $post_arr['new_pwd_common'];
        $cf_pwd_user = $post_arr['confirm_pwd_common'];

        $val = $this->password_model->validatePswd($new_pwd_user);
        $admin_id = $this->validation_model->getAdminId();

        if (!$name_user) {
            $msg = lang('You_must_enter_user_name');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (!$this->password_model->isUserNameAvailable($name_user)) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (!$new_pwd_user || !$cf_pwd_user) {
            $msg = lang('you_must_enter_new_password');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (!$val) {
            $msg = lang('special_chars_not_allowed');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (strlen($new_pwd_user) < 6) {
            $msg = lang('New_password_is_too_short');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif (strcmp($new_pwd_user, $cf_pwd_user) != 0) {
            $msg = lang('password_mismatch');
            $this->redirect($msg, 'password/change_password', FALSE);
        } elseif ($admin_id == $id_user) {
            $msg = lang('You_cant_change_admin_password');
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

?>