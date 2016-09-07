<?php

require_once 'Inf_Controller.php';

class Purchase extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function product_purchase() {
        $title = $this->lang->line('buying_packs');
        $this->set("title", $this->COMPANY_NAME . " | $title");



        $this->HEADER_LANG['page_top_header'] = lang('buying_packs');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('buying_packs');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = FALSE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $this->set("flag", $flag);
        $this->set("user_id", $user_id);


        $user_cart = array();

        if (isset($this->session->userdata['user_cart'])) {
            $user_cart = $this->session->userdata['user_cart'];
        }

        $this->set("user_cart", $user_cart);



        if ($user_id != '0') {

            $all_packs = $this->purchase_model->getAllPackages();
            $this->set("all_packs", $all_packs);
            $this->set("pack_count", count($all_packs));
        }
        $this->set("user_name", $user_name);
        $this->setView();
    }

    function mycart() {
        $title = 'My Cart';
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = 'My Cart';
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = 'My Cart';
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = FALSE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $first_purchase_status = $this->purchase_model->getFirstPurchaseStatus($user_id);

        $all_packs = array();
        if (isset($this->session->userdata['user_cart'])) {
            $all_packs = $this->session->userdata['user_cart'];
        }else{
            $all_packs = [];
        }

        $check_tot_price = 0;
        foreach ($all_packs as $order_check) {
            $check_tot_price += $order_check['price'] * $order_check['qty'];
            if ($first_purchase_status == 'yes') {
                $check_tot_price+=25;
            }
        }

        if($check_tot_price >= 100){
            $this->load->model('profile_model');
            $KYC_status = $this->profile_model->getKYCStatus($user_id) == 'approved';
            if(!$KYC_status){
                $this->set('KYC_status', $KYC_status);
            }
        }

        $this->set("first_purchase_status", $first_purchase_status);
        $this->set("all_packs", $all_packs);
        $this->set("flag", $flag);
        $this->set("user_id", $user_id);

        $this->set("user_name", $user_name);
        $this->setView();
    }

    function confirm() {

        $title = 'Confirm Order';
        $this->set("title", $this->COMPANY_NAME . " | Confirm Order");

        $this->HEADER_LANG['page_top_header'] = 'Confirm Order';
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = 'Confirm Order';
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $fp_status = 0;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $lang_id = $this->LANG_ID;
        $first_purchase_status = $this->purchase_model->getFirstPurchaseStatus($user_id);
        $user_balence = $this->validation_model->getUserBalanceAmount($user_id);

        $cash_acc_balence = $this->validation_model->getUserCashBalanceAmount($user_id);
        $trading_acc_balence = $this->validation_model->getUserTradingBalanceAmount($user_id);

        if (!$this->session->userdata['user_cart']) {
            $msg = 'Invalid details';
            $this->redirect($msg, 'purchase/product_purchase', false);
        } else {
            $order_details = $this->session->userdata['user_cart'];
            $this->set("all_packs", $order_details);
            $check_tot_price = 0;
            foreach ($order_details as $order_check) {
                $check_tot_price += $order_check['price'] * $order_check['qty'];
                if ($first_purchase_status == 'yes') {
                    $check_tot_price+=25;
                }
            }

            if ($check_tot_price > $cash_acc_balence) {
                $this->set("ewallet_info_status", 'yes');
            }
            if ($check_tot_price > $trading_acc_balence) {
                $this->set("trading_acc_status", 'yes');
            }

            $this->load->model('profile_model');
            $KYC_status = true;//$this->profile_model->getKYCStatus($user_id) == 'approved';
            if($check_tot_price >= 100 && !$KYC_status){
                $msg = 'You cannot make a purchase on € 100 or more without KYC verification.';
                $this->redirect($msg, 'purchase/mycart', false);
            }
        }

        if ($this->input->post('pay_ewallet')) {
            $current_pack = $this->validation_model->getProductId($user_id);

            if ($check_tot_price > $cash_acc_balence) {
                $msg = 'Insufficiant Balance in E-wallet';
                $this->redirect($msg, 'purchase/confirm', false);
            }

            $this->purchase_model->tranBegin();


            $order_id = $this->purchase_model->getOredrId();
            $total_price = 0;
            foreach ($order_details as $order) {

                $user_id = $this->LOG_USER_ID;
                $product_id = $order['id'];
                $product_value = $order['price'];
                $product_bv = $order['bv'];
                $tokens = $order['token'];
                $quantity = $order['qty'];

                if ($product_id > $current_pack) {
                    $current_pack = $product_id;
                }

                $total_price += $product_value * $quantity;

                $res1 = $this->purchase_model->insertOrderDetails($user_id, $product_id, $product_value, $product_bv, $tokens, $quantity, $order_id);


                $res2 = $this->purchase_model->updateUserToken($user_id, $product_id, $quantity);
                $res3 = $this->purchase_model->updateUserBv($user_id, $product_id, $quantity);
                $res4 = $this->purchase_model->updateAcademyLevel($user_id, $product_id);
            }
            if ($first_purchase_status == 'yes') {
                $total_price+=25;
                $fp_status = 1;
            }


            $res = $this->purchase_model->insertInToOrder($order_id, $user_id, $total_price, 'E-wallet', $fp_status);
            $res4 = $this->purchase_model->updateCurrentPackId($user_id, $current_pack);
            $res5 = $this->purchase_model->insertUsedEwallet($user_id, $user_id, $total_price,'ewallet');
            if ($res1 && $res2 && $res3) {
                $this->purchase_model->tranCommit();
                $this->session->unset_userdata('user_cart');
                $msg = 'Order Confirmed';
                $this->redirect($msg, 'purchase/product_purchase', true);
            } else {
                $this->purchase_model->tranRollback();
                $msg = 'Order Confirmation Failed';
                $this->redirect($msg, 'purchase/mycart', false);
            }
        } else if ($this->input->post('pay_cash')) {

			if( $check_tot_price > ( $cash_acc_balence + $trading_acc_balence ) ) {
				$this->redirect( 'Insufficiant Balance in Cash & Trading Accounts', 'purchase/confirm', false);
			}
			if( $trading_acc_balence - $check_tot_price >= 0 ) {
				$_targets = [];
				array_push( $_targets, [
					'ratio'  => $check_tot_price,
					'type'   => 'trading',
					'target' => 'Trading Account'
				] );
			} else if( $trading_acc_balence >= 1 ) {
				$_targets = [];
				array_push( $_targets, [
					'ratio'  => $trading_acc_balence,
					'type'   => 'trading',
					'target' => 'Trading Account'
				] );
				array_push( $_targets, [
					'ratio'  => $check_tot_price - $trading_acc_balence,
					'type'   => 'cash',
					'target' => 'Cash Account'
				] );
			} else {
				$_targets = [];
				array_push( $_targets, [
					'ratio'  => $check_tot_price,
					'type'   => 'cash',
					'target' => 'Cash Account'
				] );
			}

			$response = $this->purchase_model->execute_batch_orders($order_details, $first_purchase_status, $user_id, $_targets );

			$this->redirect( $response['msg'], 'purchase/product_purchase', $response['status'] );

        }


        $info_box_con_payza     = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_payza' );
        $info_box_con_payeer    = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_payeer' );
        $info_box_con_sepa      = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_sepa' );
        $info_box_con_swift     = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_swift' );
        $info_box_bitcoin       = $this->purchase_model->getInfoBoxMessage( $lang_id, 'bitcoin' );
        $info_box_con_e_wallet  = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_e_wallet' );
        $info_box_con_cash_acc  = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_cash_acc' );
        $info_box_con_trade_acc = $this->purchase_model->getInfoBoxMessage( $lang_id, 'con_trade_acc' );

        $this->set("info_box_con_payza", $info_box_con_payza);
        $this->set("info_box_con_payeer", $info_box_con_payeer);
        $this->set("info_box_con_sepa", $info_box_con_sepa);
        $this->set("info_box_con_swift", $info_box_con_swift);
        $this->set("info_box_bitcoin", $info_box_bitcoin);
        $this->set("info_box_con_e_wallet", $info_box_con_e_wallet);
        $this->set("info_box_con_cash_acc", $info_box_con_cash_acc);
        $this->set("info_box_con_trade_acc", $info_box_con_trade_acc);

        $this->set("user_balence", $user_balence);
        $this->set("cash_acc_balence", $cash_acc_balence);
        $this->set("trading_acc_balence", $trading_acc_balence);
        $this->set("first_purchase_status", $first_purchase_status);
        $this->set("user_id", $user_id);
        $this->set("user_name", $user_name);
        $this->set("SWISSC_SHOP_URL", SWISSC_SHOP_URL);
        $this->set("base_url", $this->BASE_URL);
        $this->setView();
    }

    function confirm_from_shop(){

        $input = $this->input->get();

        $user_id = $input['user_id'];
		if( empty( $input['_hash'] ) )
			$this->failed_purchase_result();

		$res_shop = file_get_contents( purchase_model::SHOP_LINK . '?_hash=' . $input['_hash'] );
		$res_shop = json_decode( $res_shop, true );
		if( $res_shop['is_paid'] !== 'true' )
			$this->failed_purchase_result();

        $order_id = $this->purchase_model->getOredrId();

        $current_pack = (int)$this->db->select("product_id")->from("ft_individual")->where('id', $user_id)->get()->first_row('array')['product_id'];

        $this->purchase_model->tranBegin();

        $result = 1;
        $total_price = $input['first_purchase'] ? 25 : 0;

        try {

            foreach ($input['products'] as $p) {


                $product = $this->db->select('*')->from('package')->where('product_id', $p['id'])->get()->first_row('array');

                $result &= $this->purchase_model->insertOrderDetails($user_id, $product['product_id'], $product['product_value'], $product['bv_value'], $product['num_of_tokens'], $p['qty'], $order_id);
                $result &= $this->purchase_model->updateUserToken($user_id, $product['product_id'], $p['qty']);
                $result &= $this->purchase_model->updateUserBv($user_id, $product['product_id'], $p['qty']);

                $total_price += (int)$product['product_value'];
                $current_pack = (int)$product['product_id'] > $current_pack ? (int)$product['product_id'] : $current_pack;
                if (!$result)
                    $this->failed_purchase_result();

            }
            $result &= $this->purchase_model->insertInToOrder($order_id, $user_id, $total_price, 'Trading Account', (int)$input['first_purchase']);
            $result &= $this->purchase_model->updateCurrentPackId($user_id, $current_pack);
            $result &= $this->purchase_model->insertUsedEwallet($user_id, $user_id, $total_price, 'trading', 'paypal');
            $result &= $this->purchase_model->insertUsedEwallet($user_id, $user_id, $total_price, 'trading');
        } catch (Exception $e) {
            $this->failed_purchase_result();
        }

        if ($result) {
            $this->purchase_model->tranCommit();
            $this->session->unset_userdata('user_cart');
            $msg = 'Order Confirmed';
            $this->redirect($msg, 'purchase/product_purchase', true);
        } else {
            $this->failed_purchase_result();
        }
    }

    function check_okpay(){
        $list = $this->db->get('test')->result_array();
        $new_list = [];
        foreach ($list as $item) {
            $text = $item['text'];
            $x = explode(PHP_EOL . 'GET: ', $text);
            $post = json_decode(substr($x[0], 6), true);
            $get = json_decode($x[1], true);
            if($get['success'] == 'true'){

                for ($i = 1; $i <= (int)$post['ok_items_count']; $i++) {
                    $product_id = $post["ok_item_{$i}_article"];
                    $product = $this->db->where('product_id', $product_id)->get('package')->first_row('array');
                    $cur_price = (double)$post["ok_item_{$i}_price"];
                    $product_price = (double)$product['product_value'];
                    if(round($cur_price, 2) != round($product_price, 2)){
                        $new_list[] = [
                            'user_id' => (int)$get['user_id'],
                            'name' => $post["ok_item_{$i}_name"],
                            'quantity' => (int)$post["ok_item_{$i}_quantity"],
                            'charged' => $post["ok_item_{$i}_price"],
                            'price' => $product_price,
                        ];
                        break;
                    }
                }
            }
        }
        echo '<pre>';
        print_r($new_list);
        echo '</pre>';
        die;
    }

    function confirm_from_okpay(){
        $last_test_id = 0;
        if($this->db->table_exists('55_test')){
            $this->db->insert('55_test', ['text' => 'POST: ' . json_encode($this->input->post()) . PHP_EOL . 'GET: ' . json_encode($this->input->get())]);
            $last_test_id = $this->db->insert_id();
        }

        $success = $this->input->get('success') == 'true';

        if(!$success){
            $this->purchase_model->tranRollback();
            $msg = 'Order Confirmation Failed';
            $this->redirect($msg, 'purchase/mycart', false);
        }

        $input = $this->input->post();
//        $input = (array)json_decode('{"ok_charset":"utf-8","ok_txn_kind":"marketplace","ok_receiver_wallet":"OK240669175","ok_receiver_email":"payment@swisscoin.eu","ok_receiver_phone":"41-764561200","ok_receiver_id":"334207818","ok_payer_country":"Afghanistan","ok_payer_city":"Payer City","ok_payer_country_code":"AF","ok_payer_address_name":"Legal","ok_payer_state":"Payer State","ok_payer_street":"Payer Address","ok_payer_zip":"123456","ok_payer_address_status":"confirmed","ok_payer_phone":"777-777777","ok_payer_first_name":"Payer First Name","ok_payer_last_name":"Payer Last Name","ok_payer_business_name":"Payer Business Name","ok_payer_email":"payer@okpay.com","ok_payer_id":"123456789","ok_payer_reputation":"100","ok_payer_status":"verified","ok_txn_id":"1","ok_txn_parent_id":"10","ok_txn_payment_type":"instant","ok_txn_gross":"100.00","ok_txn_net":"90.00","ok_txn_fee":"10.00","ok_txn_currency":"EUR","ok_txn_exchange_rate":"1.1234","ok_txn_datetime":"2016-07-25 07:54:16","ok_txn_status":"completed","ok_txn_handling":"100.00","ok_txn_shipping":"10.00","ok_txn_shipping_method":"Payment Shipping Method","ok_txn_tax":"1.00","ok_txn_comment":"Payment Comment","ok_invoice":"Payment Invoice","ok_items_count":"2","ok_item_1_id":"123456789","ok_item_1_name":"Item Name","ok_item_1_article":"4","ok_item_1_type":"Tangible Good (Request Delivery Address)","ok_item_1_quantity":"2","ok_item_1_gross":"16.00","ok_item_1_amount":"9.00","ok_item_1_fee":"1.00","ok_item_1_handling":"1.00","ok_item_1_shipping":"4.00","ok_item_1_tax":"1.00","ok_item_1_custom_1_title":"Item Custom 1 Title","ok_item_1_custom_1_value":"Item Custom 1 Value","ok_item_1_custom_2_title":"Item Custom 2 Title","ok_item_1_custom_2_value":"Item Custom 2 Value","ok_item_2_id":"123456789","ok_item_2_name":"Item Name","ok_item_2_article":"4","ok_item_2_type":"Tangible Good (Request Delivery Address)","ok_item_2_quantity":"2","ok_item_2_gross":"16.00","ok_item_2_amount":"9.00","ok_item_2_fee":"1.00","ok_item_2_handling":"1.00","ok_item_2_shipping":"4.00","ok_item_2_tax":"1.00","ok_item_2_custom_1_title":"Item Custom 1 Title","ok_item_2_custom_1_value":"Item Custom 1 Value","ok_item_2_custom_2_title":"Item Custom 2 Title","ok_item_2_custom_2_value":"Item Custom 2 Value","ok_ipn_test":"1","ok_ipn_id":"3069424"}');
        $user_id = $this->input->get('user_id');
//        $user_id = 30020;
        if(!$user_id){
            return false;
        }
        $products = [];
        for($i = 1; $i <= $input['ok_items_count']; $i++){
            $products[$i]['id'] = $input["ok_item_{$i}_article"];
            $products[$i]['qty'] = $input["ok_item_{$i}_quantity"];
            $products[$i]['price'] = $input["ok_item_{$i}_price"];
        }

        foreach ($products as $product) {

            $p = $this->db->where('product_id', $product['id'])->get('package')->first_row('array');
            $product_price = $p['product_value'];
            if($product_price != $product['price']){
                $msg = "OkPay response contains wrong price. (id=$last_test_id)";
                log_message('error', $msg);
                $this->redirect($msg, 'purchase/mycart', false);
                return false;
            }
        }

//        $user_id = $this->LOG_USER_ID;

        $order_id = $this->purchase_model->getOredrId();

        $current_pack = (int)$this->db->select("product_id")->from("ft_individual")->where('id', $user_id)->get()->first_row('array')['product_id'];

        $first_purchase_status = $this->purchase_model->getFirstPurchaseStatus($user_id);

        $this->purchase_model->tranBegin();

        $result = 1;
        $total_price = $first_purchase_status ? 25 : 0;

        try {

            foreach ($products as $p) {


                $product = $this->db->select('*')->from('package')->where('product_id', $p['id'])->get()->first_row('array');

                $result &= $this->purchase_model->insertOrderDetails($user_id, $product['product_id'], $product['product_value'], $product['bv_value'], $product['num_of_tokens'], $p['qty'], $order_id);
                $result &= $this->purchase_model->updateUserToken($user_id, $product['product_id'], $p['qty']);
                $result &= $this->purchase_model->updateUserBv($user_id, $product['product_id'], $p['qty']);

                $total_price += (int)$product['product_value'];
                $current_pack = (int)$product['product_id'] > $current_pack ? (int)$product['product_id'] : $current_pack;
                if (!$result)
                    $this->failed_purchase_result();

            }
            $result &= $this->purchase_model->insertInToOrder($order_id, $user_id, $total_price, 'Trading Account', (int)$first_purchase_status);
            $result &= $this->purchase_model->updateCurrentPackId($user_id, $current_pack);
			$result &= $this->purchase_model->insertUsedEwallet($user_id, $user_id, $total_price, 'trading', 'okpay');
            $result &= $this->purchase_model->insertUsedEwallet($user_id, $user_id, $total_price, 'trading');
        } catch (Exception $e) {
            $this->failed_purchase_result();
        }

        if ($result) {
            $this->purchase_model->tranCommit();
            $this->session->unset_userdata('user_cart');
            $msg = 'Order Confirmed';
            $this->redirect($msg, 'purchase/product_purchase', true);
        } else {
            $this->failed_purchase_result();
        }
    }

    private function failed_purchase_result($msg = 'Order Confirmation Failed'){
        $this->purchase_model->tranRollback();
        $this->redirect($msg, 'purchase/mycart', false);
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

    function setShoppingCart() {

        $product_id = $this->input->post('product_id');
        $flag = FALSE;
        if ($product_id != "") {
            $product_qty = $this->input->post('product_qty');
            if ($product_qty > 0) {
                $cart_details = array();
                if (isset($this->session->userdata['user_cart'])) {
                    $cart_details = $this->session->userdata['user_cart'];
                }

                $cart_details_count = count($cart_details);
                if ($cart_details_count > 0) {
                    foreach ($cart_details as $key => $cartdetails) {
                        if ($cartdetails['id'] == $product_id) {
                            $flag = TRUE;

                            $update_qty = $cartdetails['qty'] + $product_qty;
                            $cart_details[$key]['qty'] = $update_qty;
                        }
                    }

                    if ($flag) {

                        $this->session->set_userdata("user_cart", $cart_details);
                    } else {
                        $products = $this->purchase_model->getPackageCartDetails($product_id);
                        $cart_details[] = array('id' => $product_id,
                            'name' => $products['product_name'],
                            'price' => $products['product_value'],
                            'token' => $products['num_of_tokens'],
                            'bv' => $products['bv_value'],
                            'product_image' => $products['image'],
                            'qty' => $product_qty);
//                        $this->cart->insert($data);
                        $this->session->set_userdata("user_cart", $cart_details);
                    }
                } else {
                    $products = $this->purchase_model->getPackageCartDetails($product_id);
                    $cart_details[] = array('id' => $product_id,
                        'name' => $products['product_name'],
                        'price' => $products['product_value'],
                        'token' => $products['num_of_tokens'],
                        'bv' => $products['bv_value'],
                        'product_image' => $products['image'],
                        'qty' => $product_qty);

                    $this->session->set_userdata("user_cart", $cart_details);
                }
            }
        }
        $product_details = $this->session->userdata['user_cart'];
        $base_url = base_url();
        $html = "<a href='#' class='dropdown-toggle' data-toggle='dropdown' >My Cart <b class='glyphicon glyphicon-shopping-cart'></b></a>
            <ul class='dropdown-menu' style='margin-left: -170px;min-width: 270px; max-width: 270px; margin-top: 12px;'>";
        if ($product_details) {
            $total = 0;

            foreach ($product_details as $cart) {
                $total = $total + $cart['qty'] * $cart['price'];

                $html .="<div class='col-sm-12' style='padding:0px; margin: 14px 0px 70px 0px;'>
                                        <div class='col-sm-4' style='width:100px;float:left;'><img src='" . $base_url . "/public_html/images/package/" . $cart['product_image'] . "' class='img-responsive'></div>
                                        <div class='col-sm-8' style='width:160px;float:left;padding:0px'>" . $cart['name'] . "<br>" . $cart['price'] . " × " . $cart['qty'] . "</div></div>";
            }


            $amount_payable = $total;


            $html .= "<li class='cart_text'><a href='#'>SUB-TOTAL : " . number_format($total, 2) . "</a></li>
                            

                        <li class='cart_text'><a href='#'>TOTAL :  " . number_format($amount_payable, 2) . "</a></li>
            <li class='divider'></li>
            <div class='col-sm-12'>
                                    <div class='col-sm-6' style='padding: 0px;'>
                                        <p class='btn111 btn-add'>
                                            <a href='mycart'>View cart</a>
                                        </p>
                                    </div>
                                    <div class='col-sm-6' style='padding: 0px;'>
                                        <p class='btn111 btn-add'>
                                            <a href='confirm'>Checkout</a>
                                        </p>
                                    </div>
            </div>";
        } else {
            $html .= 'Your shopping cart is empty...';
        }

        $html .="</ul>";

        $out_products = $this->purchase_model->getPackageCartDetails($product_id);
        $result['cart'] = $html;
        $result['productname'] = $out_products['product_name'];
        $result['image'] = $out_products['image'];
        $result = json_encode($result);
        echo $result;
    }

    function clearCart() {
//        $rslt = $this->cart->destroy();
        $rslt = $this->session->unset_userdata('user_cart');
        $this->redirect("Your Cart is Cleared..", 'purchase/mycart', TRUE);
    }

    function removeCart() {
        $data = array();
        $stat = false;
        $id = $this->input->post('id');
        $product_details = $this->session->userdata['user_cart'];


        foreach ($product_details as $row) {
            if ($id == $row['id']) {
                $stat = true;
            } else {
                $data[] = $row;
            }
        }
        if ($stat) {
            $this->session->set_userdata("user_cart", $data);
        }
        return;
    }

    function updateCart() {
        $data = array();
        $stat = false;
        $id = $this->input->post('id');
        $qty = $this->input->post('qty');
        $product_details = $this->session->userdata['user_cart'];
        foreach ($product_details as $row) {
            if ($id == $row['id']) {
                $row['qty'] = $qty;
                $stat = true;
            }
            $data[] = $row;
        }
        if ($stat) {
            $this->session->set_userdata("user_cart", $data);
        }
        return;
    }

    function confirm_status() {
        $status = 'no';
        $user_id = $this->LOG_USER_ID;
        $status = $this->purchase_model->confirmStatus($user_id);
        echo $status;
        exit();
    }

}

?>
