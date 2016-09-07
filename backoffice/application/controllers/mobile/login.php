<?php

require_once 'Inf_Controller.php';

class Login extends Inf_Controller {

    public $display_tree = "";

    function __construct() {
        parent::__construct();
    }

    function check_login() {
        $is_loggin = $this->LOG_USER_ID;
        if (!$is_loggin) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Login details';
        } else {
            $user_details['status'] = true;
            $user_details['message'] = 'Login Success';
        }
        echo json_encode($user_details);
        exit();
    }

}
