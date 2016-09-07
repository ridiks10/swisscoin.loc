<?php

Class oc_register_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function confirmRegister($regr, $module_status) {
        $this->load->model('register_model');
        $status = $this->register_model->confirmRegister($regr, $module_status);
        return $status['status'];
    }

    public function distributeRePurchaseCommission($order_details, $module_status) {
        $status = FALSE;
        $oc_order_id = $order_details['order_id'];
        $user_id = $order_details['user_id'];
        $ordered_products = $order_details['order_data'];

        $total_order_pv = 0;
        $product_id = 0;
        $total_order_price = 0;
        foreach ($ordered_products AS $order) {
            $product_id = $order['product_id'];
            $quantity = $order['quantity'];
            $pv = $order['pair_value'];
            $total_product_pv = $quantity * $pv;
            $total_order_pv = $total_order_pv + $total_product_pv;
            $total_order_price = $total_order_price + $order['total'];
        }

        $mlm_plan = $module_status['mlm_plan'];
        $first_pair = $module_status['first_pair'];
        $product_status = $module_status['product_status'];
        $amount_type = 'repurchase';
        $upline_details = $this->validation_model->getUserFTDetails($user_id);
        $upline_id = $upline_details['father_id'];
        $user_position = $upline_details['position'];

        if ($mlm_plan == 'Matrix' || $mlm_plan == 'Unilevel') {
            require_once 'calculation_model.php';
            $obj_calc = new calculation_model();
            $amount_type = "repurchase_level_commission";
            $status = $obj_calc->calculateLegCount($user_id, $upline_id, $product_id, $total_order_pv, $total_order_price, $amount_type, $oc_order_id);
        } else {
            if ($mlm_plan == "Binary") {
                if ($product_status == "yes" && $first_pair == "1:1") {
                    require_once 'calculation_11_product_model.php';
                } else if ($product_status == "yes" && $first_pair == "2:1") {
                    require_once 'calculation_21_product_model.php';
                }

                $obj_calc = new calculation_model();
                $amount_type = "repurchase_leg";
                if ($product_status == "yes") {
                    $status = $obj_calc->calculateLegCount($user_id, $upline_id, $user_position, $product_id, $total_order_pv, $total_order_price, $amount_type, $oc_order_id);
                }
            } else {
                require_once 'calculation_model.php';
                $obj_calc = new calculation_model();
            }

            if ($module_status['sponsor_commission_status'] == 'yes' && $total_order_pv) {
                $amount_type = "repurchase_level_commission";
                $sponsor_id = $upline_details['sponsor_id'];
                $status = $obj_calc->calculateLevelCommission($user_id, $sponsor_id, $product_id, $total_order_pv, $total_order_price, $amount_type, $oc_order_id);
            }
        }

        return $status;
    }

}
