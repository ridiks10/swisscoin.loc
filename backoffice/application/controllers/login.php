<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'admin/Inf_Controller.php';

class Login extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

//    function index($url_type = "admin", $admin_user_name = "", $user_user_name = "") {
//        $title = lang('login');
//        $this->set("title", $this->COMPANY_NAME . " | $title");
//
//        $this->load_langauge_scripts();
//
//        $is_logged_in = $this->checkSession();
//        if ($is_logged_in) {
//            $this->redirect("", 'home', true);
//        }
//
//        $admin_captcha_status = '';
//        $user_captcha_status = '';
//        if ($this->session->userdata('inf_invalid_count')) {
//            if ($this->session->userdata('inf_invalid_count') >= 3) {
//                $admin_captcha_status = 'yes';
//            }
//        }
//
//        if ($this->session->userdata('inf_user_invalid_count')) {
//            if ($this->session->userdata('inf_user_invalid_count') >= 3) {
//                $user_captcha_status = 'yes';
//            }
//        }
//
//        if ($admin_user_name) {
//            $demo_detail = $this->login_model->checkDemoDetails($admin_user_name);
//            if ($demo_detail) {
//                $table_prefix = $demo_detail['id'];
//                $valid_admin = $this->login_model->isUserNameValid($admin_user_name, $table_prefix);
//                if ($valid_admin) {
//                    if ($user_user_name) {
//                        $valid_user = $this->login_model->isUserNameValid($user_user_name, $table_prefix);
//                        if (!$valid_user) {
//                            $user_user_name = '';
//                        }
//                    }
//                } else {
//                    $admin_user_name = '';
//                    $user_user_name = '';
//                }
//            } else {
//                $admin_user_name = '';
//                $user_user_name = '';
//            }
//        }
//
//        $this->set('admin_user_name', urldecode($admin_user_name));
//        $this->set('url_user_type', $url_type);
//        $this->set('user_user_name', urldecode($user_user_name));
//        $this->set('admin_captcha_status', $admin_captcha_status);
//        $this->set('user_captcha_status', $user_captcha_status);
//        $this->setView();
//    }
//
//    function verifylogin_admin() {
//        if ($this->session->userdata('inf_invalid_count')) {
//            $invalid_count = $this->session->userdata('inf_invalid_count');
//        } else {
//            $invalid_count = 0;
//        }
//
//        $admin_name = $this->input->post('admin_user_name');
//        $captcha = $this->session->userdata('inf_captcha');
//        $captcha_status = $this->session->userdata('inf_invalid_count');
//
//        if ($captcha_status >= 3) {
//            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
//                $captcha_message = "Invalid captcha";
//                $admin_name = urlencode($admin_name);
//                $this->redirect("$captcha_message", "login/index/admin/$admin_name", false);
//            }
//        }
//
//        $this->form_validation->set_rules('admin_user_name', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
//        $this->form_validation->set_rules('admin_password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|callback_check_database');
//
//        $login_res = $this->form_validation->run();
//
//        $this->session->unset_userdata('inf_captcha_user');
//
//        if ($login_res) {
//            $this->session->unset_userdata('inf_user_invalid_count');
//            $this->session->unset_userdata('inf_invalid_count');
//            if ($this->session->userdata('inf_old_demo')) {
//                $this->session->unset_userdata('inf_old_demo');
//                redirect(base_url() . "../soft/binary", "");
//            } else {
//                if ($this->session->userdata("redirect_url")) {
//                    $redirect_url = $this->session->userdata("redirect_url");
//                    $this->session->unset_userdata("redirect_url");
//                    if (strcmp($redirect_url, "register/") >= 0) {
//                        $this->redirect("", $redirect_url, true);
//                    } else {
//                        $this->redirect("", $redirect_url, true);
//                    }
//                } else {
//                    $this->redirect("", "home", true);
//                }
//            }
//        } else {
//            $invalid_count++;
//            $this->session->set_userdata('inf_invalid_count', $invalid_count);
//            $admin_name = $this->input->post('admin_user_name');
//            $admin_name = urlencode($admin_name);
//            $path = "login/index/admin/$admin_name";
//            $msg = $this->lang->line('Invalid_username_or_password');
//            $this->redirect("$msg", "$path", false);
//        }
//    }
//
//    function verifylogin_user() {
//        $valid = '';
//        $path = '';
//        $admin_name = $this->input->post('admin_username');
//        $u_user_name = $this->input->post('user_username');
//
//        $captcha_user = $this->session->userdata('inf_captcha_user');
//
//        if ($this->session->userdata('inf_user_invalid_count')) {
//            $invalid_count = $this->session->userdata('inf_user_invalid_count');
//        } else {
//            $invalid_count = 0;
//        }
//
//        $captcha_status = $this->session->userdata('inf_user_invalid_count');
//        if ($captcha_status >= 3) {
//            if ((empty($captcha_user) || trim(strtolower($_REQUEST['captcha_user'])) != $captcha_user)) {
//                $captcha_message = "Invalid captcha";
//                $admin_name = urlencode($admin_name);
//                $u_user_name = urlencode($u_user_name);
//                $this->redirect("$captcha_message", "login/index/user/$admin_name/$u_user_name", false);
//            }
//        }
//
//        $this->form_validation->set_rules('admin_username', 'Admin Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
//        $this->form_validation->set_rules('user_username', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
//        $this->form_validation->set_rules('user_password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[30]|callback_check_database');
//        $login_res = $this->form_validation->run();
//
//        $this->session->unset_userdata('inf_captcha_user');
//        if ($login_res) {
//            $this->session->unset_userdata('inf_user_invalid_count');
//            $this->session->unset_userdata('inf_invalid_count');
//            if ($this->session->userdata('inf_old_demo')) {
//                $this->session->unset_userdata('inf_old_demo');
//                redirect(base_url() . "../soft/binary", "");
//            } else {
//                if ($this->session->userdata("redirect_url")) {
//                    $redirect_url = $this->session->userdata("redirect_url");
//                    $this->session->unset_userdata("redirect_url");
//                    if (strcmp($redirect_url, "register/") >= 0) {
//                        $this->redirect("", $redirect_url, true);
//                    } else {
//                        $this->redirect("", $redirect_url, true);
//                    }
//                } else {
//                    $this->redirect("", "home", true);
//                }
//            }
//        } else {
//            $invalid_count++;
//            $this->session->set_userdata('inf_user_invalid_count', $invalid_count);
//            $admin_name = urlencode($admin_name);
//            $u_user_name = urlencode($u_user_name);
//            $path = "login/index/user/$admin_name/$u_user_name";
//
//
//            $this->redirect("Invalid Username or Password", "$path", false);
//        }
//    }
//
//    function check_database($password) {
//        $flag = false;
//        $username = "";
//        $password = "";
//        $login_type = "";
//        $admin_username = "";
//        $login_details = $this->input->post();
//        $login_details = $this->validation_model->stripTagsPostArray($login_details);
//        $login_details = $this->validation_model->escapeStringPostArray($login_details);
//        if (array_key_exists("admin_user_name", $login_details)) {
//            $login_type = "admin";
//            $username = $login_details['admin_user_name'];
//            $password = $login_details['admin_password'];
//        } elseif (array_key_exists("user_username", $login_details)) {
//            $login_type = "user";
//            $admin_username = $login_details['admin_username'];
//            $username = $login_details['user_username'];
//            $password = $login_details['user_password'];
//        }
//
//        $login_result = $this->login_model->login($username, $password, $login_type, $admin_username);
//
//        if ($login_result) {
//            $this->login_model->setUserSessionDatas($login_result);
//            $flag = true;
//        } else {
//            $flag = false;
//        }
//        return $flag;
//    }
//
//    function login_employee($admin_username = '', $employee_username = '') {
//        $title = $this->lang->line('login');
//        $this->set("title", $this->COMPANY_NAME . " | $title");
//        $is_logged_in = $this->checkSession();
//        if ($is_logged_in) {
//            $this->redirect("", 'home', true);
//        }
//
//        $this->load_langauge_scripts();
//
//        $this->set("admin_username", urldecode(str_replace("_", "/", $admin_username)));
//        $this->set("employee_username", urldecode(str_replace("_", "/", $employee_username)));
//
//        $this->setView();
//    }
//
//    function verify_employee_login() {
//        $admin_username = $this->input->post('admin_username');
//        $employee_username = $this->input->post('employee_username');
//
//        $this->form_validation->set_rules('admin_username', 'Admin Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
//        $this->form_validation->set_rules('employee_user_name', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
//        $this->form_validation->set_rules('employee_password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[30]|callback_check_database_employee');
//        $login_res = $this->form_validation->run();
//
//        if ($login_res) {
//            $this->redirect("", "home", true);
//        } else {
//            $admin_username = urlencode(str_replace("/", "_", $admin_username));
//            $employee_username = urlencode(str_replace("/", "_", $employee_username));
//            $path = "login/login_employee/$admin_username/$employee_username";
//            $this->redirect("Invalid Username or Password", "$path", false);
//        }
//    }
//
//    function check_database_employee($password) {
//        $flag = false;
//        $login_type = 'employee';
//        $login_details = $this->input->post();
//        $login_details = $this->validation_model->stripTagsPostArray($login_details);
//        $login_details = $this->validation_model->escapeStringPostArray($login_details);
//        $admin_username = $login_details['admin_username'];
//        $username = $login_details['employee_username'];
//        $password = $login_details['employee_password'];
//        $login_result = $this->login_model->login($username, $password, $login_type, $admin_username);
//        if ($login_result) {
//            $this->login_model->setUserSessionDatasEmployee($login_result);
//            $flag = true;
//        } else {
//            $flag = false;
//        }
//        return $flag;
//    }
//
//    function logout() {
//        $admin_user_name = '';
//        $user_name = '';
//        $user_type = '';
//        if ($this->checkSession()) {
//            $user_name = $this->LOG_USER_NAME;
//            $user_id = $this->LOG_USER_ID;
//            $user_type = $this->LOG_USER_TYPE;
//            $admin_user_name = $this->ADMIN_USER_NAME;
//
//            if ($user_id) {
//                $this->login_model->insertActivityHistory($user_id, "Logout");
//            }
//        }
//        foreach ($this->session->userdata as $key => $value) {
//            if (strpos($key, 'inf_') === 0) {
//                $this->session->unset_userdata($key);
//            }
//        }
//
//        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" || $this->MODULE_STATUS['opencart_status'] == "yes") {
//            $this->session->unset_userdata('customer_id');
//        }
//
//        $path = "login";
//        $admin_user_name = urlencode($admin_user_name);
//        $user_name = urlencode($user_name);
//
//        if ($user_type == "admin") {
//            $path = "login/index/admin/$user_name";
//        } elseif ($user_type == 'employee') {
//            $path = "login/login_employee";
//        } else if ($user_type == "distributor") {
//            $path = "login/index/user/$admin_user_name/$user_name";
//        }
//
//        $this->redirect("Successfully Logged Out...", $path, true);
//    }

    //For Individual Projects//

    function index($url_user_name = "") {
        $title = lang('login');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "login";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }

        if ($this->session->userdata('inf_user_invalid_count')) {
            if ($this->session->userdata('inf_user_invalid_count') >= 3) {
                $this->CAPTCHA_STATUS = 'yes';
            }
        }
        $isvalid = $this->login_model->isUsernameValid($url_user_name);
        if (!$isvalid) {
            $url_user_name = $user_user_name = '';
        } else {
            $url_user_name_decode = urldecode($url_user_name);
            $url_user_name_decode = str_replace("_", "/", $url_user_name_decode);
            $user_user_name = $this->encrypt->decode($url_user_name_decode);
        }
        $admin_user_name = $this->validation_model->getAdminUsername();
        $this->set('is_valid_username', $isvalid);
        $this->set('url_user_name', $user_user_name);
        $this->set('CAPTCHA_STATUS', $this->CAPTCHA_STATUS);
        $this->set('admin_user_name', $admin_user_name);

        $this->setView();
    }

    function verifylogin() {

        if(in_array($this->input->post('user_username'), $this->config->item('blocked_users'))) {
            $this->redirect("Site is in maintenance mode. Please try to login later...", "login/index", false);
        }
        if($this->config->item('maintenance_mode') == TRUE) {
            $this->redirect("Site is in maintenance mode. Please try to login later.", "login/index", false);
        }

        $path = '';

        //This method will have the credentials validation
        $u_user_name = $this->input->post('user_username');
        $captcha_user = $this->session->userdata('inf_captcha_user');

        if ($this->session->userdata('inf_user_invalid_count')) {
            $invalid_count = $this->session->userdata('inf_user_invalid_count');
        } else {
            $invalid_count = 0;
        }


        $captcha_status = $this->session->userdata('inf_user_invalid_count');
        $user_name_encode = $this->encrypt->encode($u_user_name);
        $user_name_encode = str_replace("/", "_", $user_name_encode);
        $user_name_encode = urlencode($user_name_encode);
        if ($captcha_status >= 3) {
            if ((empty($captcha_user) || trim(strtolower($_REQUEST['captcha_user'])) != $captcha_user)) {
                $captcha_message = "Invalid captcha";
                $this->redirect(" $captcha_message", "login/index/$user_name_encode", false);
            }
        }

        $this->form_validation->set_rules('user_username', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[30]|callback_check_database');
        $login_res = $this->form_validation->run();

        if ($login_res) {
            $this->session->unset_userdata('inf_captcha_user');
            $this->session->unset_userdata('inf_user_invalid_count');
            if ($this->session->userdata("redirect_url")) {
                $redirect_url = $this->session->userdata("redirect_url");
                $this->session->unset_userdata("redirect_url");
                if (strcmp($redirect_url, "register/") >= 0) {
                    $this->redirect("", $redirect_url, true);
                } else {
                    $this->redirect("", $redirect_url, true);
                }
            } else {
                $this->redirect("", "home", true);
            }
        } else {
            $invalid_count++;
            $this->session->set_userdata('inf_user_invalid_count', $invalid_count);
            $u_user_name = $this->input->post('user_username');
            $valid = $this->login_model->isUsernameValid($u_user_name);
            if ($valid)
                $path = "login/index/$user_name_encode";
            $this->redirect("Invalid Username or Password", "$path", false);
        }
    }

    function check_database($password) {
        $flag = false;
        //Field validation succeeded.  Validate against database

        $login_details = $this->input->post();
        $login_details = $this->validation_model->stripTagsPostArray($login_details);
        $login_details = $this->validation_model->escapeStringPostArray($login_details);

        $username = $login_details['user_username'];
        $password = $login_details['user_password'];

        //query the database
        $login_result = $this->login_model->login($username, $password);

        if ($login_result) {
            $this->login_model->setUserSessionDatas($login_result);
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    function login_employee($employee_username = '') {
        $title = $this->lang->line('login');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $is_logged_in = $this->checkSession();
        if ($is_logged_in) {
            $this->redirect("", 'home', true);
        }

        $this->load_langauge_scripts();

        $this->set("employee_username", urldecode(str_replace("_", "/", $employee_username)));

        $this->setView();
    }

    function verify_employee_login() {
        $employee_username = $this->input->post('user_name');
        $admin_username="admin";
        $this->form_validation->set_rules('user_name', 'Username', 'trim|required|strip_tags|xss_clean|min_length[3]|max_length[30]|htmlentities');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|strip_tags|xss_clean|min_length[5]|max_length[30]|callback_check_database_employee');
        $login_res = $this->form_validation->run();

        if ($login_res) {
            $this->redirect("", "home", true);
        } else {
            $employee_username = urlencode(str_replace("/", "_", $employee_username));
            $path = "login/login_employee/$admin_username/  $employee_username";
            $this->redirect("Invalid Username or Password", "$path", false);
        }
    }

    function check_database_employee($password) {
        $flag = false;

        $login_details = $this->input->post();
        $login_details = $this->validation_model->stripTagsPostArray($login_details);
        $login_details = $this->validation_model->escapeStringPostArray($login_details);
        $username = $login_details['user_name'];
        $password = $login_details['password'];
        $login_result = $this->login_model->login_employee($username, $password);
        if ($login_result) {
            $this->login_model->setUserSessionDatasEmployee($login_result);
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    function logout() {
        $admin_user_name = '';
        $user_name = '';

        $user_type = '';
        if ($this->checkSession()) {
            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;
            $admin_user_name = $this->ADMIN_USER_NAME;

            $user_name_encode = $this->encrypt->encode($user_name);
            $user_name_encode = str_replace("/", "_", $user_name_encode);
            $user_name_encode = urlencode($user_name_encode);
            if ($user_id) {
                $this->login_model->insertActivityHistory($user_id, "Logout");
            }
        }
        foreach ($this->session->userdata as $key => $value) {
            if (strpos($key, 'inf_') === 0) {
                $this->session->unset_userdata($key);
            }
        }

        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" || $this->MODULE_STATUS['opencart_status'] == "yes") {
            $this->session->unset_userdata('customer_id');
        }

        $path = "login";
        if ($user_type == 'employee') {
            $path = "login/login_employee";
        } else {
            $path = "login/index/$user_name_encode";
        }

        $this->redirect("Successfully Logged Out...", $path, true);
    }

    function forgot_password() {
        $this->set("title", $this->COMPANY_NAME .
                " | Forgot Password");

        $this->load_langauge_scripts();
        if ($this->input->post("forgot_password_submit") && $this->validate_forgot_password()) {
            $user_name = $this->input->post("user_name");
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = "Invalid captcha";
                $this->redirect("$captcha_message", "login/forgot_password", false);
            } $user_id = $this->login_model->userNameToIdFromOut($user_name);
            $e_mail = $this->input->post("e_mail");

            $check_result = $this->login_model->checkEmail($user_id, $e_mail);
            if ($check_result) {
                $key = $this->login_model->sendEmail($user_id, $e_mail);
                if ($key) {
                    $msg = 'Your request has been accepted we will send you confirmation mail please follow that instruction';
                    $this->redirect($msg, "login", TRUE);
                } else {
                    $msg = 'Email Failed.....';
                    $this->redirect($msg, "login", FALSE);
                }
            } else {
                $msg = 'Invalid User Name or E-mail.....';
                $this->redirect($msg, "login", FALSE);
            }
        }
        $this->setView();
    }

    function validate_forgot_password() {
        $this
        ->form_validation->set_rules(
                'user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('e_mail', lang('email'), 'trim|required|strip_tags|valid_email');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function reset_password($resetkey = "") {
        $this->set("title", $this->COMPANY_NAME . " | Reset Password");

        $this->load_langauge_scripts();
        $resetkey_original = $resetkey;

        $resetkey = urldecode($resetkey);
        $resetkey = str_replace("_", "/", $resetkey);
        $resetkey = $this->encrypt->decode($resetkey);

        if ($this->input->post("reset_password_submit") && $this->validate_reset_password()) {
            $user_name = $this->input->post("user_name");
            $key = $this->input->post("key");
            $captcha = $this->session->userdata('inf_captcha');
            if ((empty($captcha) || trim(strtolower($_REQUEST['captcha'])) != $captcha)) {
                $captcha_message = "Invalid captcha";
                $this->redirect("$captcha_message", "login/reset_password/$resetkey_original", false);
            }
            $user_id = $this->login_model->userNameToIdFromOut($user_name);

            $pass_word = $this->input->post("pass");
            $confirm_pass = $this->input->post("confirm_pass");
            if ($pass_word == $confirm_pass) {
                $res = $this->login_model->updatePasswordOut($user_id, $pass_word, $key);
                if ($res) {
                    $this->redirect('Password Updated Successfully', "login", true);
                } else
                    $this->redirect('Error On Reset Password...', "login", FALSE);
            }
        }
        else {
            $user_name = NULL;
            $id = NULL;
            if ($resetkey != "") {
                $user_arr = $this->login_model->getUserDetailFromKey($resetkey);
                $id = $user_arr[0];
                if ($id == "") {
                    $this->redirect('Invalid URL !!!!!', "login", FALSE);
                }
                $user_name = $user_arr[1];
            } else {
                $this->redirect('Invalid URL!!!!!!', "login", FALSE);
            }
        }
        $this->set("user_id", $id);
        $this->set("key", $resetkey_original);
        $this->set("user_name", $user_name);
        $this->setView();
    }

    function validate_reset_password() {
        $this->form_validation->set_rules
                ('pass', lang('password'), 'trim|required|strip_tags|min_length[6]');
        $this->form_validation->set_rules('confirm_pass', lang('confirm_password'), 'trim|required|strip_tags|matches[pass]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    //For Individual Projects//
}
