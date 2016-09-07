<?php

//require_once 'Inf_Model.php';

class Party_guest_order_model extends Inf_Model {

    function __construct() {
        parent::__construct();
    }

    public function getInvitedGuest($party_id) {
        $guest = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('party_guest_invited');
        $this->db->where('party_id', $party_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $id = $row['guest_id'];
            $this->db->select('first_name,last_name,address,city');
            $this->db->from('party_guest');
            $this->db->where('guest_id', $id);
            $res1 = $this->db->get();
            foreach ($res1->result_array() as $row1) {
                $guest[$i]['first_name'] = $row1['first_name'];
                $guest[$i]['last_name'] = $row1['last_name'];
                $guest[$i]['address'] = $row1['address'];
                $guest[$i]['city'] = $row1['city'];
                $guest[$i]['id'] = $id;

                $this->db->select_sum('product_count', 'product_count');
                $this->db->select_sum('total_amount', 'total_amount');
                $this->db->from('party_guest_orders');
                $this->db->where('guest_id', $id);
                $this->db->where('processed', 'no');
                $this->db->where('party_id', $party_id);
                $res2 = $this->db->get();
                foreach ($res2->result_array() as $row2) {
                    $guest[$i]['count'] = $row2['product_count'];
                    $guest[$i]['amount'] = $row2['total_amount'];
                }
            }
            $i++;
        }
        return $guest;
    }

    public function getGuestName($id) {
        $guest = array();
        $guest['first_name'] = '';
        $guest['last_name'] = '';
        $guest['guest_id'] = '';
        $this->db->select('first_name,last_name');
        $this->db->from('party_guest');
        $this->db->where('guest_id', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $guest['first_name'] = $row['first_name'];
            $guest['last_name'] = $row['last_name'];
            $guest['guest_id'] = $id;
        }
        return $guest;
    }

    public function getOrderDetails($id, $party_id) {
        $i = 0;
        $data = array();
        $this->db->select('id,product_id,product_count,total_amount,discount_price');
        $this->db->from('party_guest_orders');
        $this->db->where('guest_id', $id);
        $this->db->where('party_id', $party_id);
        $this->db->where('processed', 'no');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $data[$i]['id'] = $row['id'];
            $data[$i]['count'] = $row['product_count'];
            $data[$i]['product_id'] = $row['product_id'];
            $data[$i]['discount_price'] = $row['discount_price'];
            $data[$i]['total_amount'] = $row['total_amount'];
            $det = $this->getProductDetails($data[$i]['product_id']);
            $data[$i]['product_name'] = $det['product_name'];
            $data[$i]['price'] = $det['price'];
            $i++;
        }

        return $data;
    }

    public function getProductDetails($product_id) {
        $product = array();
        $this->db->select('*');
        $this->db->from('party_product');
        $this->db->where('product_id', $product_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $product['product_name'] = $this->getProductName($product_id);
            $product['price'] = $row['price'];
            // $product['prod_id'] = $row['prod_id'];
        }
        return $product;
    }

    public function storeOrder($order) {
        $this->db->truncate('order_session');
        for ($j = 0; $j < count($order); $j++) {
            $this->db->set('qty', $order[$j]['amount']);
            $this->db->set('product_id', $order[$j]['product_id']);
            $this->db->set('total', $order[$j]['total']);
            $this->db->set('date', $order[$j]['date']);
            $this->db->set('guest_id', $order[$j]['guest_id']);
            $det1 = $this->db->insert('order_session');
        }

        return $det1;
    }

    public function storeSessionData($data) {

        $this->db->truncate('payment_session');

        $cart = $data['cart'];
        $logged_in = $data['logged_in'];
        $lang_arr = $data['lang_arr'];

        $this->db->set('table_prefix', $logged_in['table_prefix']);
        $this->db->set('language', $data['language']);
        $this->db->set('currency', $data['currency']);
        if ($cart['31::'] != "") {
            $this->db->set('cart', $cart['31::']);
        } else {
            $this->db->set('cart', 1);
        }
        $this->db->set('customer_id', $data['customer_id']);
        $this->db->set('user_id', $logged_in['user_id']);
        $this->db->set('user_name', $logged_in['user_name']);
        $this->db->set('user_type', $logged_in['user_type']);
        $this->db->set('is_logged_in', $logged_in['is_logged_in']);
        $this->db->set('shipping_country_id', $data['shipping_country_id']);
        $this->db->set('shipping_zone_id', $data['shipping_zone_id']);
        $this->db->set('shipping_postcode', $data['shipping_postcode']);
        $this->db->set('regenerated', $data['regenerated']);
        $this->db->set('tran_language', $data['tran_language']);

        $this->db->set('lang_id0', $lang_arr[0]['lang_id']);
        $this->db->set('lang_code0', $lang_arr[0]['lang_code']);
        $this->db->set('lang_name0', $lang_arr[0]['lang_name']);
        $this->db->set('lang_name_in_english0', $lang_arr[0]['lang_name_in_english']);
        $this->db->set('flag_image0', $lang_arr[0]['flag_image']);
        $this->db->set('status0', $lang_arr[0]['status']);

        $this->db->set('lang_id1', $lang_arr[1]['lang_id']);
        $this->db->set('lang_code1', $lang_arr[1]['lang_code']);
        $this->db->set('lang_name1', $lang_arr[1]['lang_name']);
        $this->db->set('lang_name_in_english1', $lang_arr[1]['lang_name_in_english']);
        $this->db->set('flag_image1', $lang_arr[1]['flag_image']);
        $this->db->set('status1', $lang_arr[1]['status']);

        $this->db->set('lang_id2', $lang_arr[2]['lang_id']);
        $this->db->set('lang_code2', $lang_arr[2]['lang_code']);
        $this->db->set('lang_name2', $lang_arr[2]['lang_name']);
        $this->db->set('lang_name_in_english2', $lang_arr[2]['lang_name_in_english']);
        $this->db->set('flag_image2', $lang_arr[2]['flag_image']);
        $this->db->set('status2', $lang_arr[2]['status']);

        $this->db->set('lang_id3', $lang_arr[3]['lang_id']);
        $this->db->set('lang_code3', $lang_arr[3]['lang_code']);
        $this->db->set('lang_name3', $lang_arr[3]['lang_name']);
        $this->db->set('lang_name_in_english3', $lang_arr[3]['lang_name_in_english']);
        $this->db->set('flag_image3', $lang_arr[3]['flag_image']);
        $this->db->set('status3', $lang_arr[3]['status']);

        $this->db->set('lang_id4', $lang_arr[4]['lang_id']);
        $this->db->set('lang_code4', $lang_arr[4]['lang_code']);
        $this->db->set('lang_name4', $lang_arr[4]['lang_name']);
        $this->db->set('lang_name_in_english4', $lang_arr[4]['lang_name_in_english']);
        $this->db->set('flag_image4', $lang_arr[4]['flag_image']);
        $this->db->set('status4', $lang_arr[4]['status']);

        $this->db->set('party_id', $data['party_id']);
        // $this->db->set('guest_id',$data['guest_id']);

        $det = $this->db->insert('payment_session');
        return $det;
    }

    public function authorizePay($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp) {
        require_once 'anet_php_sdk/AuthorizeNet.php';
        // $this->load->model('anet_php_sdk/AuthorizeNet.php');
        $fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp);
        return $fingerprint;
    }

    /**
     * @deprecated 1.21 really 45_ prefix?..
     */
    public function getProd($product_id) {
        log_message('error', 'Party_guest_order_model->getProd :: Depracated call');
        $details = array();
        $query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM 45_url_alias WHERE query = 'product_id=" . $product_id . "') AS keyword FROM 45_product p LEFT JOIN 45_product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . $product_id . "' ");

        foreach ($query->result_array() as $row) {
            $details['name'] = $row['name'];
            $details['price'] = $row['price'];
            $details['image'] = $row['image'];
        }
        return $details;
    }

    public function getShoppingCartItemForGuest($guest_id, $party_id) {
        $details = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('party_guest_orders');
        $this->db->where('guest_id', $guest_id);
        $this->db->where('party_id', $party_id);
        $this->db->where('processed', 'no');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {

            $details[$i]['product_id'] = $row['product_id'];
            $details[$i]['count'] = $row['product_count'];
            $details[$i]['total_amount'] = $row['total_amount'];
            $det = $this->getProductDetails($details[$i]['product_id']);
            $details[$i]['price'] = $row['discount_price'];
            $details[$i]['product_name'] = $det['product_name'];
            $i++;
        }

        return $details;
    }

    public function getAllProducts($user_id = '') {

        $this->load->model('myparty_model');

        $details = array();
        $i = 0;
        $party_commission = 0;

        $rank_id = $this->myparty_model->checkRankStatus($user_id);
        $comm_details = $this->myparty_model->getCommissionDetails($rank_id);
        if ($rank_id > 0) {
            $party_commission = $this->myparty_model->getPartyCommission($rank_id);
        }


        $this->db->select('*');
        $this->db->from('party_product');
        $this->db->where('status', 1);
        $this->db->where('quantity > ', 0);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $amount = $row['price'] - ( $row['price'] * ($party_commission / 100));
            $details[$i]['product_id'] = $row['product_id'];
            $details[$i]['product_name'] = $this->getProductName($row['product_id']);
            // $details[$i]['prod_id']=$row['prod_id']; 
            $details[$i]['price'] = $row['price'];
            $details[$i]['stock'] = $row['quantity'];
            $details[$i]['discount_price'] = $amount;
            $i++;
        }
        return $details;
    }

    /**
     * Return product info
     * @param string $keyword This value will be escaped
     * @return array
     */
    public function serachProducts($keyword) {
        $details = array();
        $where = "name like {$this->db->escape('%' . $keyword . '%')}";
        $this->db->select('*');
        $this->db->from('party_product_description');
        $this->db->where($where);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $stock = $this->getProductStock($row['product_id']);
            $details[$i]['stock'] = $stock;
            $details[$i]['product_id'] = $row['product_id'];
            $details[$i]['product_name'] = $row['name'];
            $details[$i]['price'] = $this->getProductAmount($row['product_id']);
            $details[$i]['discount_price'] = 0;
            $i++;
        }
        return $details;
    }

    public function getProductStock($product_id) {
        $stock = 0;
        $this->db->select('quantity');
        $this->db->from('party_product');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $stock = $row->quantity;
        }
        return $stock;
    }

    public function insertProductOrder($order, $party_id) {
        for ($i = 0; $i < count($order); $i++) {
            $flag = 1;
            $this->db->select('product_id,guest_id,processed');
            $this->db->from('party_guest_orders');
            $this->db->where('party_id', $party_id);
            $res = $this->db->get();

            foreach ($res->result_array() as $row) {
                if ($row['product_id'] == $order[$i]['product_id'] && $row['guest_id'] == $order[$i]['guest_id'] && $row['processed'] == 'no') {
                    $flag = 0;
                    $product = $this->getProductDetails($order[$i]['product_id']);
                    $this->db->where('product_id', $order[$i]['product_id']);
                    $this->db->where('guest_id', $order[$i]['guest_id']);
                    $this->db->where('party_id', $party_id);
                    $this->db->set('product_count', 'product_count+' . (int) $order[$i]['qty'], false);
                    $this->db->set('total_amount', 'total_amount+' . $order[$i]['total'], false);
                    $this->db->set('date', $order[$i]['date']);
                    $res = $this->db->update('party_guest_orders');
                    break;
                }
            }
            if ($flag) {
                $product = $this->getProductDetails($order[$i]['product_id']);
                $this->db->set('guest_id', $order[$i]['guest_id']);
                $this->db->set('product_id', $order[$i]['product_id']);
                $this->db->set('discount_price', $order[$i]['discount_price']);
                $this->db->set('product_count', $order[$i]['qty']);
                $this->db->set('total_amount', $order[$i]['total']);
                $this->db->set('date', $order[$i]['date']);
                $this->db->set('party_id', $party_id);
                $this->db->set('processed', 'no');
                $res = $this->db->insert('party_guest_orders');
            }
        }
        return $res;
    }

    public function updateOrder($data, $party_id) {
        $this->db->where('guest_id', $data['id']);
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('party_id', $party_id);
        //$this->db->set('product_count', 'product_count+' . $data['amount'], false);
        $this->db->set('product_count', $data['new_qty']);
        $this->db->set('total_amount', $data['total_amount']);
        $this->db->set('date', $data['date']);
        $res = $this->db->update('party_guest_orders');
        return $res;
    }

    public function delete_product_order($id, $p_id, $party_id) {

        $this->db->where('id', $id);
        $this->db->where('product_id', $p_id);
        $this->db->where('party_id', $party_id);
        $res = $this->db->delete('party_guest_orders');
        return $res;
    }

    public function delete_order($id, $party_id) {

        $this->deleteProductOrder($id, $party_id);
        $res = $this->db->delete('party_guest_orders', array('guest_id' => $id, 'party_id' => $party_id, 'processed' => 'no'));
        return $res;
    }

    public function deleteProductOrder($id, $party_id) {

        $this->db->select('product_id,product_count');
        $this->db->where('guest_id', $id);
        $this->db->where('party_id', $party_id);
        $this->db->where('processed', 'no');
        $query = $this->db->get('party_guest_orders');

        foreach ($query->result() as $row) {

            $product_id = $row->product_id;
            $qty = $row->product_count;
            $this->insertProductStock($product_id, $qty);
        }
    }

    public function getProcessedOrderDetails($id, $party_id) {
        $i = 0;
        $data = array();
        $this->db->select('id,product_id,product_count,total_amount,discount_price');
        $this->db->from('party_guest_orders');
        $this->db->where('guest_id', $id);
        $this->db->where('party_id', $party_id);
        $this->db->where('processed', 'yes');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $data[$i]['id'] = $row['id'];
            $data[$i]['count'] = $row['product_count'];
            $data[$i]['product_id'] = $row['product_id'];
            $data[$i]['total_amount'] = $row['total_amount'];
            $det = $this->getProductDetails($data[$i]['product_id']);
            $data[$i]['price'] = $det['price'];
            $data[$i]['discount_price'] = $row['discount_price'];
            $data[$i]['product_name'] = $det['product_name'];
            $i++;
        }

        return $data;
    }

    function getProductName($product_id) {

        $this->db->select('name');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('party_product_description');

        foreach ($query->result() as $row) {

            return $row->name;
        }
    }

    public function getProductAmount($product_id) {

        $this->db->select('price');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('party_product');

        foreach ($query->result() as $row) {

            return $row->price;
        }
    }

    public function checkStock($qty, $product_id) {
        $this->db->select('*');
        $this->db->where('product_id', $product_id);
        $this->db->where('quantity >=', $qty);
        $count = $this->db->count_all_results('party_product');
        if ($count > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function checkStockProduct($data) {
        if ($data['new_qty'] <= $data['old_qty']) {
            return TRUE;
        }
        $this->db->select('*');
        $this->db->where('product_id', $data['product_id']);
        $this->db->where('quantity >=', $data['new_qty']);
        $count = $this->db->count_all_results('party_product');

        if ($count > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function updateProductStock($product_id, $quantityt) {

        $this->db->set('quantity', "quantity-$quantityt", FALSE);
        $this->db->where('product_id', $product_id);
        $result = $this->db->update('party_product');

        return $result;
    }

    public function insertProductStock($product_id, $qty) {

        $this->db->set('quantity', "quantity+$qty", FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('party_product');
    }

    public function checkRankStatus($user_id) {

        $this->load->model('register_model');

        $prod_join_details = $this->register_model->getProdAndJoiningDetails($user_id);

        $date_after_six_month = date('Y-m-d', strtotime('+6 month', strtotime($prod_join_details['date_of_joining'])));
        $curr_date = date('Y-m-d');
        $amount = 0;
        $order_amount = 0;

        $rank_id = $this->validation_model->getRankId($user_id);

        if ($prod_join_details['product_id'] > 1 && $date_after_six_month < $curr_date && $rank_id < 5) {

            $total_income = $this->register_model->getTotalIncome($rank_id);
            $user_name = $this->validation_model->idToUserName($user_id);

            $from_date = $prod_join_details['date_of_joining'];
            $to_date = $date_after_six_month;

            $amount = $this->register_model->getTotalPurchase($user_name, $from_date, $to_date);

            $this->register_model->getDownlineDetailsAll($user_id);

            foreach ($this->register_model->referals as $id) {

                $ref_user_name = $this->validation_model->IdToUserName($id);
                $amount+=$this->register_model->getTotalPurchase($ref_user_name, $from_date, $to_date);
            }
            $all_party_id = $this->register_model->getClosedPartyId($user_id, $from_date, $to_date);

            foreach ($all_party_id as $party_id) {

                $order_amount+=$this->register_model->totalProductAmountGetFromParty($party_id, $from_date, $to_date);
            }
            $amount+=$order_amount;

            if ($amount >= $total_income['tot_income']) {

                return $rank_id;
            } else {
                $rank_id = $this->register_model->findBelowRank($rank_id);

                return $rank_id;
            }
        } else {
            return $rank_id;
        }
    }

}
