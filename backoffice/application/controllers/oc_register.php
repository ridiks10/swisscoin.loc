<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'admin/Inf_Controller.php';

class Oc_Register extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function opencart_user_register() {
        if ($this->input->post()) {
            $this->load->model('login_model', '', TRUE);
            $this->load->model('register_model', '', TRUE);
            $this->load->model('configuration_model', TRUE);
            $reg_post_array = $this->input->post();
            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            $reg_post_array = $this->validation_model->escapeStringPostArray($reg_post_array);
          
            $table_prefix = $reg_post_array['table_prefix'];
            $this->session->set_userdata('inf_table_prefix', $table_prefix);
            $this->login_model->setDBPrefix($table_prefix);

            $this->MODULE_STATUS = $module_status = $this->login_model->trackModule();
            $product_status = $this->MODULE_STATUS['product_status'];

            $regr = $reg_post_array;
            $reg_from_tree = $regr['reg_from_tree'];
            if ($reg_from_tree && $this->MODULE_STATUS['mlm_plan'] != "Unilevel") {
                $regr['placement_user_name'] = $reg_post_array["placement_user_name"];
                $regr['placement_full_name'] = $reg_post_array["placement_full_name"];
            } else {
                $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
                $regr['placement_full_name'] = $reg_post_array["sponsor_full_name"];
            }

            $regr['registration_fee'] = $this->register_model->getRegisterAmount();
            $product_id = 0;
            $product_name = 'NA';
            $product_pv = '0';
            $product_amount = '0';
            if ($product_status == "yes") {
                $product_id = $regr['product_id'];
                $this->load->model('product_model');
                $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                $product_name = $product_details[0]['product_name'];
                $product_pv = $product_details[0]['pair_value'];
                $product_amount = $product_details[0]['product_value'];
            }
            $regr['order_id'] = (isset($reg_post_array['order_id'] ))?$reg_post_array['order_id'] :'0';
            $regr['product_id'] = $product_id;
            $regr['product_name'] = $product_name;
            $regr['product_pv'] = $product_pv;
            $regr['product_amount'] = $product_amount;
            $regr['total_amount'] = $regr['registration_fee'] + $regr['product_amount'];
            $regr['joining_date'] = date('Y-m-d H:i:s');
            // $regr['payment_type'] = 'opencart';
            $regr['payment_type'] = (isset($reg_post_array['payment_type'])) ? $reg_post_array['payment_type'] : 'opencart';
            $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
            $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
            $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);

            $status = $this->oc_register_model->confirmRegister($regr, $module_status);
            if ($status) {
                echo 'registration_successfull';
            } else {
                echo 'registration_failed';
            }
            $this->session->unset_userdata('inf_table_prefix');
            exit();
        } else {
            echo "Access Denied.";
            exit();
        }
    }

    function opencart_repurchase_commission() {
        if ($this->input->post()) {
            $order_data = $this->input->post();
            $this->load->model('login_model', '', TRUE);

            $order_details = $this->input->post();
            $order_details = $this->validation_model->stripTagsPostArray($order_details);
            $order_details = $this->validation_model->escapeStringPostArray($order_details);

            $table_prefix = $order_details['table_prefix'];
            $this->session->set_userdata('inf_table_prefix', $table_prefix);
            $this->login_model->setDBPrefix($table_prefix);

            $this->MODULE_STATUS = $module_status = $this->login_model->trackModule();
            $status = $this->oc_register_model->distributeRePurchaseCommission($order_details, $module_status);
            if ($status) {
                echo 'repurchase_successfull';
            } else {
                echo 'repurchase_failed';
            }
        } else {
            echo "Access Denied.";
            exit();
        }
    }

}
