<?php

class product_model extends inf_model {

    var $product_detail = Array();

    function __construct() {
        parent::__construct();
        $this->load->model('file_upload_model');
    }

    public function getAllProducts($status = '', $limit = '200', $page = '') {

        $product_details = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('package');
        if ($status != '') {
            $this->db->where('active', $status);
        }
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product_details[] = $row;
        }
        return $product_details;
    }

    public function getAllProductsCount($status = '') {

        $this->db->select('count(*) as cnt');
        $this->db->from('package');
        if ($status)
            $this->db->where('active', $status);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function addProduct($prod_name, $product_amount, $pair_value, $bv_value,$no_of_token,$splits,$academy_level) {

        $date = date('Y-m-d H:i:s');
        $data = array(
            'product_name' => $prod_name,
            'active' => 'yes',
            'date_of_insertion' => $date,
            'product_value' => $product_amount,
            'num_of_tokens' => $no_of_token,
            'splits' => $splits,
            'academy_level' => $academy_level,
            'bv_value' => $bv_value
        );
        $query = $this->db->insert("package", $data);
        return $query;
    }

    public function editProduct($id) {

        $product = 'package';
        $query = $this->db->get_where($product, array('product_id' => $id));
        foreach ($query->result() as $row) {
            return $row;
        }
    }

    public function updateProduct($id, $prod_name, $product_amount, $pair_value, $bv_value,$no_of_token,$splits,$academy_level,$image) {

        $product = 'package';
        $data = array(
            'product_name' => $prod_name,
            'active' => 'yes',
            'product_value' => $product_amount,
            'pair_value' => $pair_value,
            'num_of_tokens' => $no_of_token,
            'splits' => $splits,
            'academy_level' => $academy_level,
            'bv_value' => $bv_value,
            'image' => $image
        );
        $this->db->where('product_id', $id);
        $query = $this->db->update($product, $data);
        return $query;
    }

    public function inactivateProduct($product_id) {

        $product = 'package';
        $this->db->set('active', 'no');
        $this->db->where('product_id', $product_id);
        $query = $this->db->update($product);
        return $query;
    }

    public function activateProduct($product_id) {

        $product = 'package';
        $this->db->set('active', 'yes');
        $this->db->where('product_id', $product_id);
        $query = $this->db->update($product);
        return $query;
    }

    public function InsertProductImage($product_id, $file_name) {

        if ($this->table_prefix == '') {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $product_image_table = $this->table_prefix . 'product_image_table';
        $img_id = '';
        $this->db->select('product_image_id')
                ->from($product_image_table)
                ->where('product_ref_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $img_id = $row->product_image_id;
        }

        if ($img_id != '') {

            $this->db->set('product_image_name', $file_name);
            $this->db->where('product_image_id', $img_id);
            $res = $this->db->update($product_image_table);
        } else {

            $this->db->set('product_image_name', $file_name);
            $this->db->set('product_ref_id', $product_id);
            $res = $this->db->insert($product_image_table);
        }
        return $res;
    }

    public function getPrdocutName($product_id) {
        $product_name = '';
        $this->db->select('product_name');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function isProductAvailable($product_id, $type = '') {
        $count = 0;
        $flag = FALSE;
       $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('count(*) AS cnt');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $this->db->where('active', 'yes');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
        } else {
            $where = '';
            if ($type == 'register') {
                $where = "AND category_id = 145"; //registration pack
            }

            $query = $this->db->query("SELECT count(product_id) as cnt FROM " . $this->db->ocprefix . "product_to_category WHERE product_id = $product_id $where");
            foreach ($query->result() as $row) {
                $count = $row->cnt;
            }
        }
        if ($count > 0) {
            $flag = TRUE;
        }
        return $flag;
    }

    /**
     * 
     * @param string $prodcutid This value will be escaped!
     * @param string $prodcutpin This value will be escaped!
     * @return int
     */
    public function isProductPinAvailable($prodcutid, $prodcutpin) {
        $this->db->select('count(*) AS cnt');
        $this->db->from('pin_numbers');
        $this->db->where('pin_numbers', $prodcutpin);
        $this->db->where('pin_prod_refid', $prodcutid);
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        try {
            return $query->row()->cnt > 0 ? 1 : 0;
        } catch (Exception $ex) {
            log_message('error', $ex->getMessage());
            return 0;
        }
    }

    public function isPasscodeAvailable($product_pin, $active = 'yes') {

        $flag = 0;
        $this->db->select('count(*) AS cnt');
        $this->db->from('pin_numbers');
        $this->db->where('pin_numbers', $product_pin);
        $this->db->where('status', $active);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = 1;
        return $flag;
    }

    public function getProduct($product_id) {
        $amount = 0;
       
       $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('product_value');
            $this->db->from('package');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $amount = $row['product_value'];
            }
        } else {
            $query = $this->db->query('SELECT price AS product_value FROM ' . $this->db->ocprefix . 'product WHERE product_id =' . $product_id);
            foreach ($query->result_array() as $row) {
                $amount = $row['product_value'];
            }
        }
        return $amount;
    }

    public function getProductDetails($product_id = '', $status = 'yes') {
        $product_details = array();
        
       $MODULE_STATUS = $this->trackModule();
       
        if ($MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('*');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            if ($status != '') {
                $this->db->where('active', $status);
            }
            $query = $this->db->get('package');
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $where = '';
            if ($product_id != '') {
                $where = ' WHERE product_id =' . $product_id;
            }
            $query = $this->db->query('SELECT product_id,model AS product_name,pair_value,price AS product_value FROM ' . $this->db->ocprefix . 'product' . $where);
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        }
        return $product_details;
    }

    public function checkProductNameAvailability($product_name) {
        $this->db->select('product_id');
        $this->db->where('product_name', $product_name);
        $result = $this->db->get('package');
        if (count($result->result_array()) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getProductAmountAndPV($product_id) {
        $pair_value = 0;
        $product_value = 0;
        $MODULE_STATUS = $this->trackModule();
        
        if ($MODULE_STATUS['opencart_status_demo'] == "no") {
            $this->db->select('pair_value');
            $this->db->select('product_value');
            $this->db->where('product_id', $product_id);
            $query = $this->db->get('package');
            foreach ($query->result() as $row) {
                $pair_value = $row->pair_value;
                $product_value = $row->product_value;
            }
        } else {
            $query = $this->db->query('SELECT pair_value,price AS product_value FROM ' . $this->db->ocprefix . 'product WHERE product_id =' . $product_id);
            foreach ($query->result() as $row) {
                $pair_value = $row->pair_value;
                $product_value = $row->product_value;
            }
        }
        
        $amount['pair_value'] = $pair_value;
        $amount['product_value'] = $product_value;
        return $amount;
    }
    
     public function getAllProd($status = '') {

        $product_details = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('product');
        if ($status != '') {
            $this->db->where('active', $status);
        }
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product_details[] = $row;
        }
        return $product_details;
    }

}
