<?php

require_once 'Inf_Controller.php';

class Purchase extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function product_purchase() {
        $title = $this->lang->line('buying_packs');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "view-my-referrals";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('buying_packs');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('buying_packs');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_id = $this->LOG_USER_ID;
        $current_pack = $this->purchase_model->getCurrentPacks($user_id);
        $this->set("current_pack", $current_pack);

        $all_packs = $this->purchase_model->getAllPackages($current_pack['pack_id']);
        $this->set("all_packs", $all_packs);
        $this->set("pack_count", count($all_packs));
        if ($this->input->post('purchase')) {
            $product_id = $this->input->post('product_id');
            $product_value = $this->input->post('product_value');
            $product_bv = $this->input->post('bv_value');
            $tokens = $this->input->post('tokens');
            if ($product_id == '' || $product_value == '' || $product_bv == '') {
                $msg = $this->lang->line('invalid_details');
                $this->redirect($msg, 'purchase/product_purchase', false);
            } else {
                $this->purchase_model->tranBegin();
                $res1 = $this->purchase_model->insertProductPurchaseDetails($user_id, $current_pack['pack_id'], $product_id, $product_value, $product_bv, $tokens, $this->LOG_USER_ID);
                $res2 = $this->purchase_model->updateCurrentPackId($user_id, $product_id);
                $res3 = $this->purchase_model->updateUserToken($user_id, $product_id);
                if ($res1 && $res2 && $res3) {
                    $this->purchase_model->tranCommit();
                    $msg = $this->lang->line('successfully_changed_your_package');
                    $this->redirect($msg, 'purchase/product_purchase', true);
                } else {
                    $this->purchase_model->tranRollback();
                    $msg = $this->lang->line('error_on_package_updation');
                    $this->redirect($msg, 'purchase/product_purchase', false);
                }
            }
        }

        $this->setView();
    }

    function sales_facilities() {
        $title = $this->lang->line('sales_facilities');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sales_facilities');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_facilities');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = FALSE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        if ($this->input->post('get_user')) {
            $user_name = $this->input->post('user_name');
            if ($user_name == '') {
                $msg = $this->lang->line('please_select_user_name');
                $this->redirect($msg, 'purchase/product_purchase', false);
            } else {
                $flag = TRUE;
                $user_id = $this->validation_model->userNameToID($user_name);
            }
        }
        $this->set("flag", $flag);
        $this->set("user_id", $user_id);
        if ($user_id != '0') {
            $current_pack = $this->purchase_model->getCurrentPacks($user_id);
            $this->set("current_pack", $current_pack);

            $all_packs = $this->purchase_model->getAllPackages($current_pack['pack_id']);
            $this->set("all_packs", $all_packs);
            $this->set("pack_count", count($all_packs));
            if ($this->input->post('purchase')) {
                $product_id = $this->input->post('product_id');
                $product_value = $this->input->post('product_value');
                $product_bv = $this->input->post('bv_value');
                $tokens = $this->input->post('tokens');
                $user_id = $this->input->post('user_id');
                $current_pack = $this->purchase_model->getCurrentPacks($user_id);
                $this->set("current_pack", $current_pack);

                if ($product_id == '' || $product_value == '' || $product_bv == '') {
                    $msg = $this->lang->line('invalid_details');
                    $this->redirect($msg, 'purchase/product_purchase', false);
                } else {
                    $this->purchase_model->tranBegin();
                    $res1 = $this->purchase_model->insertProductPurchaseDetails($user_id, $current_pack['pack_id'], $product_id, $product_value, $product_bv, $tokens, $this->LOG_USER_ID);
                    $res2 = $this->purchase_model->updateCurrentPackId($user_id, $product_id);
                    if ($res1 && $res2) {
                        $this->purchase_model->tranCommit();
                        $msg = $this->lang->line('successfully_changed_your_package');
                        $this->redirect($msg, 'purchase/product_purchase', true);
                    } else {
                        $this->purchase_model->tranRollback();
                        $msg = $this->lang->line('error_on_package_updation');
                        $this->redirect($msg, 'purchase/product_purchase', false);
                    }
                }
            }
        }
        $this->set("user_name", $user_name);
        $this->setView();
    }

}

?>
