<?php

class purchase_model extends inf_model {

    private $mailObj;

    const SHOP_LINK = "https://swissc-shop.de/purchase/status";

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function initialize() {

        $this->load->model('settings_model');
        $this->load->model('file_upload_model');
        $this->load->model('tooltip_class_model');
    }

    public function getCurrentPackId($user_id) {
        $pack_id = 0;
        $this->db->select("product_id");
        $this->db->where("id", $user_id);
        $query = $this->db->get('ft_individual');
        foreach ($query->result() as $row) {
            $pack_id = $row->product_id;
        }
        return $pack_id;
    }
   
    public function getCurrentPacks($user_id) {
        $pack_id = $this->getCurrentPackId($user_id);
        $package = array();
        $this->db->select("product_name,product_value,num_of_tokens");
        $this->db->where("product_id", $pack_id);
        $query = $this->db->get('package');
        foreach ($query->result() as $row) {
            $package['name'] = $row->product_name;
            $package['product_value'] = $row->product_value;
            $package['tokens'] = $row->num_of_tokens;
            $package['pack_id'] = $pack_id;
        }
        return $package;
    }

    public function getAllPackages($pack_id = "") {
        $package = array();
        $this->db->select("product_id,product_name,bv_value,product_value,num_of_tokens,image");
        if ($pack_id != '') {
            $this->db->where("product_id !=", $pack_id);
        }

        $this->db->where("product_id !=", "1");
        $query = $this->db->get('package');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $package[$i]['product_id'] = $row['product_id'];
            $package[$i]['product_name'] = $row['product_name'];
            $package[$i]['bv_value'] = $row['bv_value'];
            $package[$i]['product_value'] = $row['product_value'];
            $package[$i]['tokens'] = $row['num_of_tokens'];
            $package[$i]['image'] = $row['image'];
            $i++;
        }
        return $package;
    }

    public function insertProductPurchaseDetails($user_id, $current_pack, $product_id, $product_value, $product_bv, $tokens, $changed_by) {
        $date = date('Y-m-d H:i:s');
        $this->db->set("user_id", $user_id);
        $this->db->set("current_pack", $current_pack);
        $this->db->set("change_pack", $product_id);
        $this->db->set("change_price", $product_value);
        $this->db->set("change_bv", $product_bv);
        $this->db->set("change_token", $tokens);
        $this->db->set("date", $date);
        $this->db->set("changed_by", $changed_by);
        $res = $this->db->insert("package_history");
        return $res;
    }

    public function insertInToOrder($order_id, $user_id, $total, $payment_type, $fp_status) {
        $date = date('Y-m-d H:i:s');
        $this->db->set("order_id", $order_id);
        $this->db->set("user_id", $user_id);
        $this->db->set("price", $total);
        $this->db->set("payment_type", $payment_type);
        $this->db->set("date", $date);
        $this->db->set("fp_status", $fp_status);
        $res = $this->db->insert("orders");
        return $res;
    }

    public function insertOrderDetails($user_id, $product_id, $product_value, $product_bv, $tokens, $qty, $order_id) {
        $date = date('Y-m-d H:i:s');

        $this->db->set("order_id", $order_id);
        $this->db->set("user_id", $user_id);
        $this->db->set("package", $product_id);
        $this->db->set("price", $product_value);
        $this->db->set("bv", $product_bv);
        $this->db->set("token", $tokens);
        $this->db->set("quantity", $qty);
        $this->db->set("date", $date);
        $res = $this->db->insert("order_history");
        return $res;
    }

    public function getOredrId() {
        $order_id = 1;
        $this->db->select_max('order_id');
        $result = $this->db->get('order_history')->row();
        if ($result->order_id) {
            $order_id = $result->order_id + 1;
        }

        return $order_id;
    }

    public function updateCurrentPackId($user_id, $product_id) {
        $this->db->set("product_id", $product_id);
        $this->db->where("id", $user_id);
        $this->db->limit(1);
        $res = $this->db->update("ft_individual");
        return $res;
    }

    public function updateUserToken($user_id, $product_id, $quantity = 1) {

        $token = $this->validation_model->getTokenFromProduct($product_id);
        $token = $token * $quantity;
        $this->db->set('tokens', 'ROUND(tokens +' . $token . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function updateUserBv($user_id, $product_id, $quantity = 1) {

        $bv = $this->validation_model->getBvFromProduct($product_id);
        $bv = $bv * $quantity;
        $this->db->set('bv', 'ROUND(bv +' . $bv . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function updateAcademyLevel($user_id, $product_id) {
        $this->load->library('moodle_api');

        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $result = $this->db->get('login_user')->row();
        $user = null;

        if (!empty($result)) {
            $fields = array(
                'key' => 'username',
                'value' => $result->user_name,
            );
            $user = $this->moodle_api->getUser($fields);

            if (empty($user)) {
                $this->db->select('*');
                $this->db->where("user_detail_refid", $user_id);
                $result = $this->db->get('user_details')->row();
                $fields = array(
                    'key' => 'email',
                    'value' => $result->user_detail_email,
                );
                $user = $this->moodle_api->getUser($fields);
            }
        }

        if (!empty($user)) {
            $this->moodle_api->changeUserPackage($user['id'], $product_id);
        }

        return true;
    }

    public function getPackageCartDetails($product_id) {

        $res = array();
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->limit(1);
        $quary = $this->db->get('package');
        foreach ($quary->result_array() as $row) {
            $res = $row;
        }
        return $res;
    }

    public function getFirstPurchaseStatus($user_id) {
        $num_rews = 0;
        $status = "yes";
        $this->db->select();
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('orders');
        $num_rews = $query->num_rows();
        if ($num_rews) {
            $status = "no";
        }
        return $status;
    }

    public function insertUsedEwallet( $user_ref_id, $user_id, $used_amount, $payed_account, $user_for = 'repurchase' ) {

        $res = $this->updateBalanceAmount( $user_id, $used_amount, $payed_account );
        if ( $res ) {
            $date = date( 'Y-m-d H:i:s' );
            $this->db->set( 'used_user_id', $user_ref_id );
            $this->db->set( 'used_amount', round( $used_amount, 2 ) );
            $this->db->set( 'user_id', $user_id );
            $this->db->set( 'used_for', $user_for );
            $this->db->set( 'payed_account', $payed_account );
            $this->db->set( 'date', $date );
            $res = $this->db->insert( 'ewallet_payment_details' );
        }

        return $res;
    }

    public function updateBalanceAmount($user_id, $total_amount,$payed_account) {
        if($payed_account=='trading'){
            $this->db->set('trading_account', 'ROUND(trading_account -' . $total_amount . ',2)', FALSE);
        }else{
            $this->db->set('balance_amount', 'ROUND(balance_amount -' . $total_amount . ',2)', FALSE);
            $this->db->set('cash_account', 'ROUND(cash_account -' . $total_amount . ',2)', FALSE);
        }
       
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');

        return $res;
    }

    public function confirmStatus($user_id) {

        $status = 'no';

        $this->db->where('user_detail_name !=', 'NA');
        $this->db->where('user_detail_second_name !=', '');
        $this->db->where('user_detail_pin !=', 'NA');
        $this->db->where('user_detail_city !=', 'NA');
        $this->db->where('user_detail_address !=', '');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('user_details');
        
        
        if ($query->num_rows() > 0)
        {
            $status = 'yes';
        }
        return $status;
    }

    public function getInfoBoxMessage($lang_id = 1,$type='') {
        $info_array = '';
        if ($lang_id != NULL) {
            $this->db->where('lang_ref_id', $lang_id);
        }
        $this->db->where('info_type', $type);
        $query = $this->db->get('info_box');

        foreach ($query->result() as $row) {
            $info_array = $row->message;
        }
        return stripslashes($info_array);
    }
    
    public function tranBegin() {
        $this->begin();
    }

    public function tranCommit() {
        $this->commit();
    }

    public function tranRollback() {
        $this->rollBack();
    }

    public function execute_batch_orders( $order_details, $first_purchase_status, $user_id, array $_targets ) {
		self::tranBegin();
		$this->load->model( 'validation_model' );
		$order_ID = self::getOredrId();
		$current_pack = $this->validation_model->getProductId( $user_id );
		$total_price  = 0;
		$results = true;
        foreach ($order_details as $order) {

			$product_id    = $order['id'];
			$product_value = $order['price'];
			$product_bv    = $order['bv'];
			$tokens        = $order['token'];
			$quantity      = $order['qty'];

            if ($product_id > $current_pack) {
                $current_pack = $product_id;
            }

            $total_price += $product_value * $quantity;

            $results &= $this->insertOrderDetails( $user_id, $product_id, $product_value, $product_bv, $tokens, $quantity, $order_ID );
            $results &= $this->updateUserToken( $user_id, $product_id, $quantity );
            $results &= $this->updateUserBv( $user_id, $product_id, $quantity );
            $results &= $this->updateAcademyLevel($user_id, $product_id);
        }
		$fp_status = 0;
		if ( $first_purchase_status == 'yes' ) {
			$total_price += 25;
			$fp_status = 1;
		}
		foreach( $_targets as $target ) {
			$results &= $this->insertUsedEwallet( $user_id, $user_id, $target['ratio'], $target['type'] );
		}

		$results &= $this->insertInToOrder( $order_ID, $user_id, $total_price, 'Trading & Cash Account', $fp_status );
		$results &= $this->updateCurrentPackId( $user_id, $current_pack );

		if (  $results ) {

			self::tranCommit();
			get_instance()->session->unset_userdata( 'user_cart' );
			return [
				'msg'    => 'Order Confirmed',
				'status' => true
			];

		} else {

			self::tranRollback();
			return [
				'msg'    => 'Order Confirmation Failed',
				'status' => false
			];
		}
    }


}
