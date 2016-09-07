<?php

require_once 'Inf_Controller.php';

/**
 * @property-read party_guest_order_model $party_guest_order_model 
 */
class Party_guest_order extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function guest_orders() {
        $title = lang('place_an_order_for_each_guest');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('place_an_order_for_each_guest');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('place_an_order_for_each_guest');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "guest_orders";
        $this->set("help_link", $help_link);

        $guest = array();
        $party_id = $this->session->userdata('inf_party_id');
        $guest = $this->party_guest_order_model->getInvitedGuest($party_id);
        $this->set('guest_arr', $guest);

        $this->setView();
    }

    function select_product($id = "") {
        $title = lang('select_product');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('select_product');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('select_product');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "select_product";
        $this->set("help_link", $help_link);

        $party_id = $this->session->userdata('inf_party_id');
        $user_id = $this->LOG_USER_ID;
        $this->load->model('myparty_model');

        if ($id == '')
            $this->redirect('', 'party_guest_order/guest_orders', '');

        $product = $this->party_guest_order_model->getAllProducts($user_id);

        $product_selected = array();
        $dat = false;
        if ($this->session->userdata('inf_product_selected')) {
            $product_selected = $this->session->userdata('inf_product_selected');
        } else {
            $product_selected = array();
        }
        $count = count($product_selected);

        if ($this->input->post('add')) {

            $add_post_array = $this->input->post();
            $add_post_array = $this->validation_model->stripTagsPostArray($add_post_array);
            $add_post_array = $this->validation_model->escapeStringPostArray($add_post_array);

            $i = $add_post_array['ii'];
            $product_idd = $add_post_array["product_id"];
            $qty = $add_post_array['qty'];
            $flag = 1;
            $party_commission = 0;
            if ($qty > 0) {
                $rank_id = $this->myparty_model->checkRankStatus($user_id);
                //$comm_details = $this->myparty_model->getCommissionDetails($rank_id);
                if ($rank_id > 0) {
                    $party_commission = $this->myparty_model->getPartyCommission($rank_id);
                }

                for ($k = 0; $k < $count; $k++) {
                    if ($product_selected[$k]['product_idd'] == $product_idd) {

                        $new_order = $product_selected[$k]['qty'] + $qty;
                        if ($this->party_guest_order_model->checkStock($new_order, $product_idd)) {
                            $amount = $product_selected[$k]['price'] - ( $product_selected[$k]['price'] * ($party_commission / 100));
                            $product_selected[$k]['qty'] = $product_selected[$k]['qty'] + $qty;
                            $product_selected[$k]['tot_price'] = $product_selected[$k]['qty'] * $product_selected[$k]['price'];
                            $flag = 0;
                        } else {
                            $msg = lang('out_of_stock');
                            $this->redirect($msg, 'party_guest_order/select_product/' . $id, FALSE);
                        }
                    }
                }
                if ($flag == 1) {
                    $products = $this->party_guest_order_model->getProductDetails($product_idd);
                    if ($this->party_guest_order_model->checkStock($qty, $product_idd)) {
                        $amount = $products['price'] - ($products['price'] * ($party_commission / 100));
                        $tot_price = $qty * $amount;
                        $product_selected[$count]['product_idd'] = $product_idd;
                        $product_selected[$count]['qty'] = $qty;
                        $product_selected[$count]['tot_price'] = $tot_price;
                        $product_selected[$count]['product_name'] = $products['product_name'];
                        $product_selected[$count]['price'] = $amount;
                    } else {
                        $msg = lang('out_of_stock');
                        $this->redirect($msg, 'party_guest_order/select_product/' . $id, FALSE);
                    }
                }

                $this->session->set_userdata('inf_product_selected', $product_selected);
                $this->redirect('', 'party_guest_order/select_product/' . $id, true);
            }
            
            else{
               $this->redirect('Plese enter product count', 'party_guest_order/select_product/' . $id, false); 
            }
        }
        $count_product_selected = count($product_selected);
        $this->set('product_selected', $product_selected);

        $res = array();
        if ($this->input->post('search')) {
            $keyword = $this->input->post('keyword');
            if ($keyword != '') {
                $res = $this->party_guest_order_model->serachProducts($keyword);
                $product = $res;
            }
        }
        if ($this->input->post('submit')) {
            $total = 0;
            $j = 0;
            // $this->session->set_userdata('inf_order_status', 'true');
            $submit_post_array = $this->input->post();
            $submit_post_array = $this->validation_model->stripTagsPostArray($submit_post_array);
            $submit_post_array = $this->validation_model->escapeStringPostArray($submit_post_array);
            $count = $submit_post_array['count'];
            if ($count_product_selected) {
                for ($i = 1; $i <= $count; $i++) {
                    $product_id = $submit_post_array['product_id_sel' . $i];
                    $quantity = $submit_post_array['qty' . $i];
                    $price = $submit_post_array['discount_price' . $i];

                    if ($quantity != "" && is_numeric($quantity)) {
                        $order[$j]['qty'] = $quantity;
                        $order[$j]['product_id'] = $product_id;
                        $order[$j]['discount_price'] = $price;
                        $this->party_guest_order_model->updateProductStock($product_id, $quantity);
                        //$product = $this->party_guest_order_model->getProductDetails($product_id);
                        $order[$j]['total'] = $quantity * $price;
                        $total = $total + $order[$j]['total'];
                        $order[$j]['date'] = date("y-m-d H:i:s");
                        $order[$j]['guest_id'] = $submit_post_array['guest_id'];
                        $j++;
                    }
                }

                $dat = $this->party_guest_order_model->insertProductOrder($order, $party_id);
            }
            if ($dat) {

                $this->session->unset_userdata('inf_product_selected');
                $this->redirect('', 'party_guest_order/select_product/' . $id, true);
            }
        }
        if ($this->input->post('back')) {
            $this->session->unset_userdata('inf_product_selected');
            $this->redirect('', 'party_guest_order/guest_orders', true);
        }
        if ($id != "") {
            $guest = $this->party_guest_order_model->getGuestName($id);
            $this->set('guest', $guest);
            $this->set('product', $product);
            $pdts = $this->party_guest_order_model->getAllProducts($user_id);
            $this->set('pdts', $pdts);
        }
        $cart_item = $this->party_guest_order_model->getShoppingCartItemForGuest($id, $party_id);
        $this->set('cart_item', $cart_item);

        $this->setView();
    }

    function edit_order($id) {
        $title = lang('edit_order');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('edit_order');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('edit_order');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $help_link = "edit_order";
        $this->set("help_link", $help_link);

        if ($id == '')
            $this->redirect('', 'party_guest_order/guest_orders', '');
        $party_id = $this->session->userdata('inf_party_id');
        if ($this->input->post('submit')) {

            $submit_edit_order_array = $this->input->post();
            $submit_edit_order_array = $this->validation_model->stripTagsPostArray($submit_edit_order_array);
            $submit_edit_order_array = $this->validation_model->escapeStringPostArray($submit_edit_order_array);
            $count = $submit_edit_order_array['count'];
            $guest = $submit_edit_order_array['guest_id'];
            $update_count = 0;
            $res = FALSE;

            for ($i = 1; $i <= $count; $i++) {
                $data['id'] = $id;
                $data['product_id'] = $submit_edit_order_array['product_id' . $i];
                $data['new_qty'] = $submit_edit_order_array['new_qty' . $i];
                if (!is_numeric($submit_edit_order_array['new_qty' . $i]) || $submit_edit_order_array['new_qty' . $i] < 0) {
                    $msg = lang('invalid_quantity');
                    $this->redirect($msg, 'party_guest_order/guest_orders', false);
                }

                $data['old_qty'] = $submit_edit_order_array['old_qty' . $i];
                $old_qty = $submit_edit_order_array['old_qty' . $i];

                $updated_quantity = $old_qty - $data['new_qty'];
                if (is_numeric($data['new_qty'])) {

                    if ($data['new_qty'] != 0) {
                        $arr = $this->party_guest_order_model->getProductDetails($data['product_id']);
                        $result = $this->party_guest_order_model->checkStockProduct($data);
                        if ($result) {
                            $update_count = $data['new_qty'] - $old_qty;

                            $this->party_guest_order_model->updateProductStock($data['product_id'], $update_count);

                            $data['total_amount'] = $data['new_qty'] * $arr['price'];
                            $data['date'] = date("y-m-d H:i:s");
                            $res = $this->party_guest_order_model->updateOrder($data, $party_id);
                        } else {
                            $msg = lang('out_of_stock');
                            $this->redirect($msg, 'party_guest_order/guest_orders', false);
                        }
                    }
                }
            }

            if ($res) {
                $msg = lang('order_updated');
                $this->redirect($msg, 'party_guest_order/guest_orders', true);
            } else {
                $msg = lang('updation_failed');
                $this->redirect($msg, 'party_guest_order/guest_orders', false);
            }
        }
        $guest = $this->party_guest_order_model->getGuestName($id);
        $this->set('guest', $guest);
        $this->set('guest_id', $id);
        $data = $this->party_guest_order_model->getOrderDetails($id, $party_id);
        $this->set('data', $data);

        $this->set("page_top_header", $this->lang->line('edit_order'));
        $this->set("page_top_small_header", "");
        $this->set("page_header", $this->lang->line('edit_order'));
        $this->set("page_small_header", "");

        $this->setView();
    }

    function delete_order($id) {
        $this->ARR_SCRIPT[0]["name"] = "validate_setup_party.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->load_langauge_scripts();

        $party_id = $this->session->userdata('inf_party_id');
        $res = $this->party_guest_order_model->delete_order($id, $party_id);
        if ($res) {
            $this->redirect('Order Deleted Successfully', 'party_guest_order/guest_orders', true);
        } else {
            $this->redirect('Deletion Failed', 'party_guest_order/guest_orders', false);
        }
    }

    function delete_product_order($id, $p_id, $qty) {

        $this->ARR_SCRIPT[0]["name"] = "validate_setup_party.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        $this->load_langauge_scripts();

        $party_id = $this->session->userdata('inf_party_id');
        $res = $this->party_guest_order_model->delete_product_order($id, $p_id, $party_id);
        if ($res) {
            $this->party_guest_order_model->insertProductStock($p_id, $qty);
            $this->redirect('Product Item Deleted...', 'party_guest_order/guest_orders', TRUE);
        } else {
            $this->redirect('Product Item Cannot be Deleted...', 'party_guest_order/guest_orders', FALSE);
        }
    }

    function view_order($id) {

        $title = lang('view_order');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('view_order');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_order');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "view_order";
        $this->set("help_link", $help_link);


        $party_id = $this->session->userdata('inf_party_id');

        $guest = $this->party_guest_order_model->getGuestName($id);
        $this->set('guest', $guest);
        $this->set('guest_id', $id);
        $data = $this->party_guest_order_model->getProcessedOrderDetails($id, $party_id);
        $this->set('data', $data);

        $this->set("page_top_header", $this->lang->line('view_order'));
        $this->set("page_top_small_header", "");
        $this->set("page_header", $this->lang->line('view_order'));
        $this->set("page_small_header", "");

        $this->setView();
    }

}
