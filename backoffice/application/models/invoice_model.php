<?php

class invoice_model extends inf_model {

    public function __construct() {
        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
        $this->load->model('page_model');
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

	function getCountOfOrderDetails( $user_id = null, $order_id = null ) {
		if( ! is_null( $user_id ) ) {
			$this->db->where('o.user_id', intval( $user_id ) );
		}
		if( ! is_null( $order_id ) ) {
			$this->db->where('o.order_id', intval( $order_id ) );
		}
		return $this->db->count_all_results('orders');
	}

    function getUserOrderDetails( $user_id = null, $order_id = null, array $pagination = null ) {
        $this->db->select('o.order_id');
		$this->db->select('fi.user_name as username');
		$this->db->select('CONCAT(`ud`.`user_detail_name`, "  ", ud.user_detail_second_name) as name', false );
		$this->db->select('o.price');
		$this->db->select('o.date');
		$this->db->select('o.payment_type');
		$this->db->select('o.fp_status');
		$this->db->from('orders as o');
		$this->db->join( 'ft_individual as fi', 'fi.id = o.user_id', 'left' );
		$this->db->join( 'user_details as ud', 'ud.user_detail_refid = o.user_id', 'left' );
		if( ! is_null( $user_id ) ) {
			$this->db->where('o.user_id', intval( $user_id ) );
		}
		if( ! is_null( $order_id ) ) {
			$this->db->where('o.order_id', intval( $order_id ) );
		}
		if( ! is_null( $pagination ) ) {
			$this->db->limit( $pagination['limit'], $pagination['offset'] );
		}
		$this->db->order_by('date', 'DESC');

		return $this->db->get()->result_array();
    }
    
    
    function getOrderDetailsFromId($id) {
        $data = array();
        $this->db->where('order_id',$id);
        $res = $this->db->get('order_history');
        foreach ($res->result_array() as $row) {
           
            $row['package_name']=$this->validation_model->getPrdocutName( $row['package'] );
            $data[] = $row;
        }
        return $data;
    }
    function getFPStatus($id) {
        $status = 0;
        $this->db->select('fp_status'); 
        $this->db->where('order_id',$id);
        $this->db->limit(1);
        $res = $this->db->get('orders');
        foreach ($res->result() as $row) {
            $status = $row->fp_status;
        }
        return $status;
    }
    function getPaymentType($id) {
        $status = '';
        $this->db->select('payment_type'); 
        $this->db->where('order_id',$id);
        $this->db->limit(1);
        $res = $this->db->get('orders');
        foreach ($res->result() as $row) {
            $status = $row->payment_type;
        }
        return $status;
    }

}
