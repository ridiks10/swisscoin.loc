<?php

require_once 'Inf_Controller.php';

class Home extends Inf_Controller {

    public $display_tree = "";

    function __construct() {
        parent::__construct();
    }

    function get_details() {
        $is_loggin = $this->LOG_USER_ID;
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid Login details';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->android_inf_model->getUserDetails($this->LOG_USER_ID);
        }

        echo json_encode($json_response);
        exit();
    }

    function get_module_status() {

        $is_loggin = $this->LOG_USER_ID;
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid Login details';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->MODULE_STATUS;
        }

        echo json_encode($json_response);
        exit();
    }

    function get_user_income_details() {
        $is_loggin = $this->LOG_USER_ID;
        $this->load->model('income_details_model');
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->android_inf_model->getIncome($this->LOG_USER_ID);
        }

        echo json_encode($json_response);
        exit();
    }

    function get_user_ewallet_details() {
        $is_loggin = $this->LOG_USER_ID;
        $this->load->model('ewallet_model');
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $json_response['data'] = $this->ewallet_model->getCommissionDetails($this->LOG_USER_ID, $from_date = '', $to_date = '');
        }

        echo json_encode($json_response);
        exit();
    }

}
