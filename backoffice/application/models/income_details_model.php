<?php

class income_details_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function getUserId($username) {

        $this->db->select("user_id");
        $this->db->from("login_user");
        $this->db->where('user_name', $username);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_id = $row->user_id;
            return $user_id;
        }
    }

    public function userNameToID($posted_user_name) {
        $this->validation_model->userNameToID($posted_user_name);
        return $posted_user_name;
    }

    public function userIdToName($user_id) {
        $user_name = $this->validation_model->IdToUserName($user_id);
        return $user_name;
    }

    public function add_income($id) {
        $array = array();
        $tot_amount = 0;
        $this->db->select('amount_type,amount_payable,user_id,user_level,from_id');
        $this->db->from('leg_amount');
        $this->db->where('user_id', $id);
        $res = $this->db->get();
        $i = 1;
        foreach ($res->result_array() as $row) {
            $view_amt_type = $this->validation_model->getViewAmountType($row["amount_type"]);
            $array["det$i"]["amount_type"] = $view_amt_type;
            $array["det$i"]["amount_payable"] = $row["amount_payable"];
            if ($row["from_id"]) {
                $array["det$i"]["from_id"] = $this->userIdToName($row["from_id"]);
            } else {
                $array["det$i"]["from_id"] = "NA";
            }

            $array["det$i"]["user_level"] = $row["user_level"];
            $tot_amount+=$array["det$i"]["amount_payable"];
            $array["det$i"]['tot_amount'] = $tot_amount;
            $i++;
        }
        return $array;
    }

    public function getAllProducts($status = "") {
        $product_details = array();
        $i = 0;
        if ($status == '') {
            $this->db->select('product_id ,product_name,active,date_of_insertion,prod_id,product_value,pair_value,product_qty,product_amt');
            $this->db->from("product");
        } else {

            $this->db->select('product_id ,product_name,active,date_of_insertion,prod_id,product_value,pair_value,product_qty,product_amt');
            $this->db->from("product");
            $this->db->where('active = ' . "'" . $status . "'");
        }

        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $product_details[] = $row;
        }
        return $product_details;
    }

    public function addProduct($prod_name, $product_id, $product_amount, $ref_amt) {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //to add a new  product

        $product = "product";
        $date = date('Y-m-d H:i:s');

        $data = array(
            'product_name' => $prod_name,
            'active' => 'yes',
            'date_of_insertion' => $date,
            'prod_id' => $product_id,
            'product_value' => $product_amount,
            'product_amt' => $ref_amt
        );

        $res = $this->db->insert($product, $data);
        return $res;
    }

    public function editProduct($id) {

        //////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //to get  details of a product

        $product = "product";
        $query = $this->db->get_where($product, array('product_id' => $id));
        foreach ($query->result() as $row) {
            return $row;
        }
    }

    public function updateProduct($id, $prod_name, $product_id, $product_amount, $pdct_amt) {

        //////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //to update  details of a product

        $product = "product";

        $data = array(
            'product_name' => $prod_name,
            'active' => 'yes',
            'prod_id' => $product_id,
            'product_value' => $product_amount,
            'product_amt' => $pdct_amt
        );

        $this->db->where('product_id', $id);
        $res = $this->db->update($product, $data);
        return $res;
    }

    public function deleteProduct($product_id) {

        //////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //to inactivate of a product

        $product = "product";
        $this->db->set('active', 'no');
        $this->db->where('product_id', $product_id);
        $res = $this->db->update($product);
        return $res;
    }

    public function activateProduct($product_id) {

        //////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //to activate a product

        $product = "product";
        $this->db->set('active', 'yes');
        $this->db->where('product_id', $product_id);
        $res = $this->db->update($product);
        return $res;
    }

    public function InsertProductImage($product_id, $file_name) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $product_image_table = $this->table_prefix . "product_image_table";
        $img_id = '';

        $this->db->select('product_image_id')->from($product_image_table)->where('product_ref_id', $product_id);
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

    public function getRandFileName($userfile, $path) {
        return $this->up->getRandFileName($userfile, $path);
    }

    public function config($file_size, $file_type) {
        return $this->up->config($file_size, $file_type);
    }

    public function upload($userfile, $path, $file_name) {
        $this->up->upload($userfile, $path, $file_name);
    }

    public function getPrdocutName($product_id) {
        $product_name = "";
        $this->db->select("product_name");
        $this->db->from("product");
        $this->db->where("product_id", $product_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function isProductAvailable($product_id) {
        $flag = FALSE;
        $this->db->select("count(*) AS cnt");
        $this->db->from("product");
        $this->db->where("product_id", $product_id);
        $this->db->where("active", "yes");
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = TRUE;
        return $flag;
    }

    public function isProductPinAvailable($prodcutid, $prodcutpin) {
        $flag = 0;
        $this->db->select("count(*) AS cnt");
        $this->db->from("pin_numbers");
        $this->db->where("pin_numbers", $prodcutpin);
        $this->db->where("pin_prod_refid", $prodcutid);
        $this->db->where("status", "yes");
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = 1;
        return $flag;
    }

    public function isPasscodeAvailable($product_pin, $active = 'yes') {

        $flag = 0;
        $this->db->select("count(*) AS cnt");
        $this->db->from("pin_numbers");
        $this->db->where("pin_numbers", $product_pin);
        $this->db->where("status", $active);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0)
            $flag = 1;
        return $flag;
    }

    public function getProductValue($amount) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $configuration = $this->table_prefix . "configuration";

        $qr = "SELECT pair_value FROM $configuration";
        $res = $this->selectData($qr, "Error on selecting point value");
        $row = mysql_fetch_array($res);
        $pair_value = $row['pair_value'];
        $pair_value_cal = intval($amount / $pair_value);
        return $pair_value_cal;
    }

    public function getProductAmount($product_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $product = $this->table_prefix . "product";

        $qr = "SELECT pair_value FROM $product WHERE product_id='$product_id'";
        $res = $this->selectData($qr, "Error on selecting point Amount");
        $row = mysql_fetch_array($res);
        $pair_value = $row['pair_value'];
        $pair_value_cal = intval($amount / $pair_value);
        return $pair_value_cal;
    }

    public function getfee() {
        $this->db->select("monthlyfee");
        $this->db->from("configuration");
        $this->db->where("id", '1');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $fee = $row->monthlyfee;
        }
        return $fee;
    }

    public function getPermittedMenus($user_id, $url) {
        $this->db->select("module_status");
        $this->db->from("login_employee");
        $this->db->where('user_id', $user_id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_menus = $row->module_status;
        }
        $splittedstring = explode(",", $user_menus);
        $this->db->select("id");
        $this->db->from("infinite_mlm_menu");
        $this->db->where('link', $url);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $menu_id = $row->id;
        }

        if (isset($menu_id)) {
            $menu_id1 = '1#' . $menu_id;
        } else {
            $this->db->select("sub_id");
            $this->db->select("sub_refid");
            $this->db->from("infinite_mlm_sub_menu");
            $this->db->where('sub_link', $url);
            $qr = $this->db->get();
            foreach ($qr->result() as $row) {
                $menu_id = $row->sub_id;
                $menu_sub_refid = $row->sub_refid;
            }
            $menu_id1 = $menu_sub_refid . '#' . $menu_id;
        }
        $menu_id2 = 'm#' . $menu_id;

        for ($i = 0; $i < 5; $i++) {

            if (($splittedstring[$i] == $menu_id1) || ($splittedstring[$i] == $menu_id2)) {
                return true;
            }
        }
    }

    public function getFromUserLevel($from_id, $id) {
        $level = "NA";
        $login_level = $this->validation_model->getUserLevel($id);
        $user_level = $this->validation_model->getUserLevel($from_id);
        if ($login_level != "NA" && $user_level != "NA") {
            $level = $user_level - $login_level;
        }

        return $level;
    }

}
