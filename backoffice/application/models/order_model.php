<?php

class order_model extends inf_model {

    public function __construct() {
        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
        $this->load->model('page_model');
    }

    public function getCurrentOrderHistoryDetails($customer_id, $order_id = '') {
        $order_details = array();

        $this->db->select('o.*');
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("oh.order_status_id >=", 1);
        $this->db->where("o.customer_id", $customer_id);
        if ($order_id != '') {
            $this->db->where("o.order_id", $order_id);
        }
        $this->db->group_by('o.order_id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date('Y/m/d', strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $order_details[$i]['order_id_with_prefix'] = str_pad($row['order_id'], 7, 0, STR_PAD_LEFT);
            $order_details[$i]['firstname'] = $row['firstname'];
            $order_details[$i]['lastname'] = $row['lastname'];
            $order_details[$i]['customer_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['fullname'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['total'] = $row['total'];

            $order_products = $this->getOrderProductDetails($row['order_id']);
            $order_details[$i]['products'] = $order_products;

            $quantity = '';
            $model = '';
            foreach ($order_products AS $product) {
                $quantity .= $product['quantity'] . "<br>";
                $model .= $product['model'] . "<br>";
            }
            $order_details[$i]['quantity'] = $quantity;
            $order_details[$i]['model'] = $model;

            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['shipping_firstname'] = $row['shipping_firstname'];
            $order_details[$i]['shipping_lastname'] = $row['shipping_lastname'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_city'] = $row['shipping_city'];
            $order_details[$i]['shipping_zone'] = $row['shipping_zone'];
            $order_details[$i]['shipping_country'] = $row['shipping_country'];
            $order_details[$i]['payment_firstname'] = $row['payment_firstname'];
            $order_details[$i]['payment_lastname'] = $row['payment_lastname'];
            $order_details[$i]['payment_address_1'] = $row['payment_address_1'];
            $order_details[$i]['payment_city'] = $row['payment_city'];
            $order_details[$i]['payment_country'] = $row['payment_country'];
            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['payment_zone'] = $row['payment_zone'];

            $order_details[$i]['order_total'] = $this->getOrderTotalDetails($row['order_id']);
            $i = $i + 1;
        }

        return $order_details;
    }

    public function getOrderProductDetails($order_id) {
        $details = array();
        $i = 0;
        $this->db->from('oc_order_product');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details[$i] = $row;
            $i++;
        }

        return $details;
    }

    public function getOrderTotalDetails($order_id) {
        $order_details = array();
        $this->db->select('title,code,value');
        $this->db->from('oc_order_total');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['code'] = $row['code'];
            $order_details[$i]['value'] = $row['value'];
            $order_details[$i]['title'] = $row['title'];
            $i = $i + 1;
        }
        return $order_details;
    }

    public function checkOrderExist($order_id) {
        $count = 0;
        $this->db->from('oc_order');
        $this->db->where('order_id', $order_id);
        $count = $this->db->count_all_results();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getCustomerIdFromOrder($order_id) {
        $customer_id = 0;
        $this->db->select('customer_id');
        $this->db->from('oc_order');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $customer_id = $row->customer_id;
        }
        return $customer_id;
    }

    public function getOrderHistoryCount($customer_id = '') {
        $count = 0;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("oh.order_status_id >=", 1);
        if ($customer_id) {
            $this->db->where("o.customer_id", $customer_id);
        }
//        if ($date) {
//            $date1 = $date . ' 00:00:00';
//            $date2 = $date . ' 23:59:59';
//            $this->db->where("o.date_added BETWEEN '$date1' and '$date2'");
//        }
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getOrderDetails($page = '', $limit = '', $customer_id = '', $date = '') {
        $order_details = array();

        $this->db->select('o.*');
        $this->db->from("oc_order as o");
        $this->db->join("oc_order_history as oh", "o.order_id=oh.order_id ", "INNER");
        $this->db->where("oh.order_status_id >=", 1);
        if ($limit) {
            $this->db->limit($limit, $page);
        }
        if ($customer_id != '') {
            $this->db->where("o.customer_id", $customer_id);
        }
//        if ($date != '') {
//            $date1 = $date . ' 00:00:00';
//            $date2 = $date . ' 23:59:59';
//            $this->db->where("o.date_added BETWEEN '$date1' and '$date2'");
//        }
        $this->db->group_by('o.order_id');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result_array() as $row) {
            $order_details[$i]['date_added'] = date('Y/m/d', strtotime($row['date_added']));
            $order_details[$i]['order_id'] = $row['order_id'];
            $order_details[$i]['order_id_with_prefix'] = str_pad($row['order_id'], 7, 0, STR_PAD_LEFT);
            $order_details[$i]['firstname'] = $row['firstname'];
            $order_details[$i]['lastname'] = $row['lastname'];
            $order_details[$i]['customer_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $order_details[$i]['total'] = $row['total'];
            $user_id=  $this->validation_model->getUserIDFromCustomerID($row['customer_id']);
            $user_name=  $this->validation_model->IdToUserName($user_id);
            $order_products = $this->getOrderProductDetails($row['order_id']);
            $order_details[$i]['products'] = $order_products;
            $order_details[$i]['user_name'] = $user_name;
            $quantity = '';
            $model = '';
            $pair_value = '';
            $total_pair_value = '';
            $price = array();
            $total_price=array();
            $j=0;
            foreach ($order_products AS $product) {
                $quantity .= $product['quantity'] . "<br>";
                $model .= $product['model'] . "<br>";
                $pair_value .= $product['pair_value'] . "<br>";
                $total_pair_value .= $product['pair_value']*$product['quantity'] . "<br>";
                $price[$j]= $product['price']. "<br>";
                $total_price[$j]= $product['price']*$product['quantity']. "<br>";
                $j++;
            }
            $order_details[$i]['quantity'] = $quantity;
            $order_details[$i]['model'] = $model;
            $order_details[$i]['pair_value'] = $pair_value;
            $order_details[$i]['total_pair_value'] = $total_pair_value;
            $order_details[$i]['price'] = $price;
            $order_details[$i]['total_price'] = $total_price;
            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['shipping_firstname'] = $row['shipping_firstname'];
            $order_details[$i]['shipping_lastname'] = $row['shipping_lastname'];
            $order_details[$i]['shipping_address_1'] = $row['shipping_address_1'];
            $order_details[$i]['shipping_city'] = $row['shipping_city'];
            $order_details[$i]['shipping_zone'] = $row['shipping_zone'];
            $order_details[$i]['shipping_country'] = $row['shipping_country'];
            $order_details[$i]['payment_firstname'] = $row['payment_firstname'];
            $order_details[$i]['payment_lastname'] = $row['payment_lastname'];
            $order_details[$i]['payment_address_1'] = $row['payment_address_1'];
            $order_details[$i]['payment_city'] = $row['payment_city'];
            $order_details[$i]['payment_country'] = $row['payment_country'];
            $order_details[$i]['shipping_method'] = $row['shipping_method'];
            $order_details[$i]['payment_zone'] = $row['payment_zone'];
            $order_details[$i]['order_total'] = $this->getOrderTotalDetails($row['order_id']);
            $i = $i + 1;
        }
        return $order_details;
    }

    function getOcCustomerId($user_id) {
        $oc_customer_id = 0;
        $this->db->select('customer_id');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('oc_customer');
        foreach ($res->result() as $row) {
            $oc_customer_id = $row->customer_id;
        }
        return $oc_customer_id;
    }

}
