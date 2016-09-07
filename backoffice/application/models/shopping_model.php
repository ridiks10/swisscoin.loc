<?php

/**
 * @todo All Indian legacy code should be purged from here
 *  as it hardcoded to unexistent tables and table prefixes
 */
class shopping_model extends inf_model {

    public $upline_id_arr;
    public $upline_id_arr_unilevel;

    public function __construct() {
        $this->load->model('products_model');
        $this->load->model('validation_model');
        $this->session->set_userdata('inf_pos_prefix', '9');
        $this->upline_id_arr = array();
        $this->upline_id_arr_unilevel = array();
    }

    public function getProducts($cat_id = "") {
        $product = array();
        $products = $this->table_prefix . 'products';
        if ($cat_id)
            $query = $this->db->get_where($products, array('category_id' => "$cat_id", 'product_type' => "ecommerce"));
        else
            $query = $this->db->get_where($products, array('product_type' => "ecommerce"));
        if ($query->num_rows() > 0) {
            $i = 0;
            foreach ($query->result_array() as $row) {
                $prod_id = $row['id'];
                $product["product$i"]["id"] = $prod_id;
                $product["product$i"]["product"] = $row['product'];
                $product["product$i"]["price"] = $row['price'];
                $product["product$i"]["product_count"] = $row['stock_count'];
                $product["product$i"]["tax"] = $row['tax'];
                $product["product$i"]["thumb"] = $row['product_image1'];
                $i++;
            }
            return $product;
        }
    }

    public function getProductDetails($id) {
        $products = $this->table_prefix . 'products';
        $qry = $this->db->get_where($products, array('id' => $id, 'product_type' => "ecommerce"));

        if ($qry->num_rows() == 1) {
            foreach ($qry->result_array() as $row) {

                $product["id"] = $row['id'];
                $product["product"] = $row['product'];
                $product["tax"] = $row['tax'];
                $product["description"] = $row['product_description'];
                $product["thumb1"] = $row['thumb1'];
                $product["image1"] = $row['product_image1'];
                $product["thumb2"] = $row['thumb2'];
                $product["image2"] = $row['product_image2'];
                $product["thumb3"] = $row['thumb3'];
                $product["image3"] = $row['product_image3'];
                $product["price"] = $row['price'];
                $product["features"] = $row['product_features'];
                $product["brand"] = $row['brand'];
            }
            return $product;
        }
    }

    public function getProductPrice($id) {
        /* CODE ADDED BY JIJI
         * 
         * to get product basic price from 9_product_prices
         * 
         */

        /* $qry = "SELECT pro_value FROM 9_product WHERE pro_id='$id'";
          $rslt = $this->selectData($qry, "Error Occured..!..141142143");
          $row = mysql_fetch_array($rslt);
          $price = $row["pro_value"]; */
        $products = $this->table_prefix . "products";
        $this->db->select("price");
        $query = $this->db->get_where($products, array('id' => $id));
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $price = $row->price;
            }
            return $price;
        }
    }

    public function updateCart($id, $qty) {
        //echo "id==>".$id."qty==>".$qty;        
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $ecom_cart = $this->table_prefix . 'ecom_cart';

        $user_id = "";
        $exist = $this->checkProductExistance($id, $user_id);

        if ($exist > 0) {

            $q1 = $this->getQuantity($id, $user_id);
            $q = $q1 + $qty;

            if ($user_id == "") {

                $j = 0;
                $sess_arr = $this->session->userdata('inf_user_cart');

                $i = $sess_arr["count"];

                while ($j <= $i) {

                    $sess_arr1 = $this->session->userdata("inf_user_product$j");

                    if ($sess_arr1["product_id"] == $id) {

                        $details = $this->getProductDetails($id);

                        $this->session->set_userdata("inf_user_product$j", array('price' => $details["price"], 'qty' => $q, 'product_id' => $sess_arr1["product_id"]));

                        $this->session->set_userdata("inf_user_cart", array('count' => $sess_arr["count"], 'amount' => $this->getTotalAmount($user_id)));
                        $sess_arr2 = $this->session->userdata("inf_user_cart");
                        $items['count'] = $this->getShoppingInfo($user_id);
                        $items['total'] = $sess_arr2["amount"];
                    }
                    $j++;
                }
            } else {
                
            }
        } else {

            if ($user_id == "") {

                $sess_arr = $this->session->userdata('inf_user_cart');

                if (isset($sess_arr["count"]) > 0) {

                    $i = $sess_arr["count"];

                    $details = $this->getProductDetails($id);


                    $this->session->set_userdata("inf_user_product$i", array('price' => $details["price"], 'product_id' => $id, 'qty' => $qty));

                    $cart_cnt = $this->getShoppingInfo($user_id) + 1;

                    $this->session->set_userdata("inf_user_cart", array('count' => $cart_cnt, 'amount' => $sess_arr["amount"]));

                    $cart_amt = $this->getTotalAmount($user_id);
                    $this->session->set_userdata("inf_user_cart", array('count' => $cart_cnt, 'amount' => $cart_amt));

                    $items['count'] = $cart_cnt;
                    $items['total'] = $cart_amt;
                }
                if (isset($sess_arr["count"]) == 0) {

                    $details = $this->getProductDetails($id);


                    $this->session->set_userdata("inf_user_product0", array('product_id' => $id, 'qty' => $qty, 'price' => $details["price"]));

                    $this->session->set_userdata("inf_user_cart", array('count' => 1, 'amount' => $details["price"]));
                    $cart_amt = $this->getTotalAmount($user_id);
                    $this->session->set_userdata("inf_user_cart", array('count' => 1, 'amount' => $cart_amt));
                    $items_arr = $this->session->userdata('inf_user_cart');
                    $items['count'] = $items_arr['count'];
                    $items['total'] = $items_arr['amount'];
                }
            }
        }

        $tmp_path = base_url() . "public_html/";
        $img = $tmp_path . "images/sucess.png";
        $close_img = $tmp_path . "images/clse.png";
        $meessage = "<div id='message_box'  class='success_message'><div id='message_note'>";
        $meessage .= "<table>
                      <tr>
                         <td>
                            <img src='$img' border='0' />
                          </td>
                          <td>
                              Successfully Added One Item in Cart ...
                          </td>
                      </tr></table>";
        $meessage .= '</div> 
                    <a  id= "close_link_ajax" ><div id="home_image1"  ><img  src="' . $close_img . '" border="0" align="right" onclick= "close_msg()"/></div></a>
                    </div> ';

        $items['message'] = $meessage;

        $result = json_encode($items);

        return $result;
    }

    /**
     * ecom_cart Where this from??
     */
    function checkProductExistance($id, $user_id) {

        $sess_arr = $this->session->userdata('inf_user_cart');

        if ($user_id == "") {
            $cnt = 0;
            if (isset($sess_arr["count"])) {
                $i = $sess_arr["count"];
                $j = 0;
                while ($j <= $i) {

                    $sess_arr1 = $this->session->userdata("inf_user_product$j");
                    if (($sess_arr1["product_id"]) == $id) {
                        $cnt++;
                    }
                    $j++;
                }
            }
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $this->session->userdata("inf_user_table_prefix");
            }
            $ecom_cart = $this->table_prefix . 'ecom_cart';

            $cntQry = "SELECT COUNT(product_id) AS cnt FROM $ecom_cart WHERE product_id='$id' AND customer_id='$user_id'";
            $res = $this->selectData($cntQry, 'Error on existance');
            $row = mysql_fetch_array($res);
            $cnt = $row['cnt'];
        }
        return $cnt;
    }

    function getQuantity($id, $user_id) {
        $qty = 0;
        if ($user_id == "") {
            $sess_arr = $this->session->userdata('inf_user_cart');
            if (isset($sess_arr["count"])) {
                $i = $sess_arr["count"];
                $j = 0;
                while ($j <= $i) {
                    $sess_arr = $this->session->userdata("inf_user_product$j");
                    if (($sess_arr["product_id"]) == $id) {
                        $qty = $sess_arr["qty"];
                    }
                    $j++;
                }
            } else {
                $qty = 0;
            }
        } else {
            
        }
        return $qty;
    }

    function getShoppingInfo($user_id) {
        $user_id = $this->session->userdata('inf_ecom_user_id');

        if ($user_id == "") {
            $sess_arr = $this->session->userdata('inf_user_cart');

            if (isset($sess_arr["count"])) {
                $cnt = $sess_arr['count'];
            } else {
                $cnt = 0;
            }
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $ecom_cart = $this->table_prefix . 'ecom_cart';

            $selQry = "SELECT COUNT(customer_id) AS cnt FROM $ecom_cart WHERE customer_id='$user_id'";

            $res = $this->selectData($selQry, 'Error on selecting count of items');

            $row = mysql_fetch_array($res);
            $cnt = $row['cnt'];
        }
        return $cnt;
    }

    function getTotalAmount($user_id) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $sess_arr = $this->session->userdata('inf_user_cart');
        if ($user_id == "") {
            $i = $sess_arr["count"];
            if ($i == 0) {
                $grand_total = 0;
            } else {
                if (isset($sess_arr["amount"])) {
                    $i = $sess_arr["count"];
                    $j = 0;
                    $grand_total = 0;
                    while ($j < $i) {
                        $sess_arr1 = $this->session->userdata("inf_user_product$j");
                        $pdt["pdt"]['product_id'] = $sess_arr1["product_id"];
                        $pdt["pdt"]['qty'] = $sess_arr1["qty"];
                        $amount = $this->getProductDetails($pdt["pdt"]['product_id']);
                        $price = $amount['price'];
                        $tax = "0";
                        $total_amt = $pdt["pdt"]['qty'] * $price;
                        $total_tax = ($total_amt * $tax) / 100;
                        $grand_total = $grand_total + ($total_amt + $total_tax);
                        $j++;
                    }
                } else {

                    $sess_arr2 = $this->session->userdata("inf_user_product0");
                    $pdt["pdt"]['product_id'] = $sess_arr2["product_id"];
                    $pdt["pdt"]['qty'] = $sess_arr2["qty"];
                    $amount = $this->getProductDetails($pdt["pdt"]['product_id']);
                    $price = $amount['price'];
                    $tax = $amount['tax'];
                    $total_amt = $pdt["pdt"]['qty'] * $price;
                    $total_tax = ($total_amt * $tax) / 100;
                    $grand_total = $grand_total + ($total_amt + $total_tax);
                }
            }
        } else {
            $ecom_cart = $this->pos_prefix . 'ecom_cart';
            $selQry = "SELECT * FROM $ecom_cart WHERE customer_id='$user_id'";
            $res = $this->selectData($selQry, "Error : D11012012T1455PML116");
            $i = 0;
            while ($row = mysql_fetch_array($res)) {
                $pdt["pdt$i"]['product_id'] = $row['product_id'];
                $pdt["pdt$i"]['qty'] = $row['qty'];
                $amount = $this->getProductDetails($pdt["pdt$i"]['product_id']);
                $price = $amount['price'];
                $tax = $amount['tax'];
                $total_amt = $pdt["pdt$i"]['qty'] * $price;
                $total_tax = ($total_amt * $tax) / 100;
                $grand_total = $grand_total + ($total_amt + $total_tax);
                $i++;
            }
        }
        return $grand_total;
    }

    function getCartDetails($invoice_no, $user_id = "") {
        $pdt = array();
        $sess_arr1 = array();
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        if ($user_id == "") {
            $sess_arr = $this->session->userdata('inf_user_cart');

            if (isset($sess_arr["count"])) {
                $i = 0;
                $c = $sess_arr["count"];
                while ($i < $c) {
                    $sess_arr1 = $this->session->userdata("inf_user_product$i");

                    $pdt["pdt$i"]['product_id'] = $sess_arr1['product_id'];
                    $pdt["pdt$i"]['qty'] = $sess_arr1["qty"];
                    $productdet = $this->getProductDetails($pdt["pdt$i"]['product_id']);
                    $pdt["pdt$i"]['product'] = $productdet['product'];
                    $pdt["pdt$i"]['price'] = $productdet['price'];
                    $pdt["pdt$i"]['tax'] = $productdet['tax'];
                    $pdt["pdt$i"]['thumb'] = $productdet['thumb1'];
                    $i++;
                }
            }
        } else {
            $ecom_cart = $this->table_prefix . 'ecom_cart';
            echo $selQry = "SELECT * FROM $ecom_cart WHERE customer_id='$user_id'";
            $res = $this->selectData($selQry, "Error : D11012012T1455PML116");
            $i = 0;
            while ($row = mysql_fetch_array($res)) {
                $pdt["pdt$i"]['product_id'] = $row['product_id'];
                $pdt["pdt$i"]['qty'] = $row['qty'];
                $product = $this->getProductDetails($pdt["pdt$i"]['product_id']);
                $pdt["pdt$i"]['product'] = $product['product'];
                $pdt["pdt$i"]['price'] = $product['price'];
                $pdt["pdt$i"]['tax'] = $product['tax'];
                $pdt["pdt$i"]['thumb'] = $product['thumb1'];
                $i++;
            }
        }
        return $pdt;
    }

    function removeItems($id = "", $user_id = "") {

        if ($user_id == "") {
            if ($id == "") {
                $this->session->unset_userdata("inf_user_cart");
                $res = 1;
            } else {
                $j = 0;
                $sess_arr = $this->session->userdata('inf_user_cart');
                $i = $sess_arr["count"];
                while ($j < $i) {


                    if ($this->session->userdata["inf_user_product$j"]["product_id"] == $id) {

                        for ($k = $j + 1; $k < $i; $k++, $j++) {
                            $sess_arr3 = $this->session->userdata("inf_user_product$k");

                            $this->session->set_userdata("inf_user_product$j", array('qty' => $sess_arr3["qty"], 'product_id' => $sess_arr3["product_id"]));
                        }


                        $this->session->set_userdata("inf_user_cart", array('count' => $sess_arr["count"] - 1, 'amount' => $this->getTotalAmount($user_id)));

                        $status['status'] = 0;
                    }
                    $j++;
                }
                $res = 1;
            }
        }
        return $res;
    }

    function updateQuantity($pdt_id, $qty, $user_id = "") {
        $user_id = $this->session->userdata("inf_ecom_user_id");
        if ($user_id == "") {
            if ($qty != 0) {
                $j = 0;
                $sess_arr = $this->session->userdata('inf_user_cart');
                $i = $sess_arr["count"];
                while ($j < $i) {
                    $sess_arr1 = $this->session->userdata("inf_user_product$j");
                    if ($sess_arr1["product_id"] == $pdt_id) {
                        $this->session->set_userdata("inf_user_product$j", array('qty' => $qty));

                        $this->session->set_userdata("inf_user_cart", array('amount' => $this->getTotalAmount($user_id)));
                        $items['total'] = $sess_arr["amount"];
                        $status['status'] = 1;
                    }
                    $j++;
                }
            }
            if ($qty == 0) {
                $j = 0;
                $sess_arr = $this->session->userdata('inf_user_cart');
                $i = $sess_arr["count"];
                while ($j < $i) {
                    $sess_arr1 = $this->session->userdata("inf_user_product$j");
                    if ($sess_arr1["product_id"] == $pdt_id) {
                        for ($k = $j + 1; $k < $i; $k++, $j++) {
                            $sess_arr2 = $this->session->userdata("inf_user_product$k");
                            $this->session->set_userdata("inf_user_product$j", array('qty' => $sess_arr2["qty"]));
                            $this->session->set_userdata("inf_user_product$j", array('product_id' => $sess_arr2["product_id"]));
                        }
                        $this->session->set_userdata("inf_user_cart", array('count' => $sess_arr["count"] - 1));
                        $this->session->set_userdata("inf_user_cart", array('amount' => $this->getTotalAmount($user_id)));
                        $status['status'] = 0;
                    }
                    $j++;
                }
            }
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $this->session->userdata("inf_table_prefix");
            }
            $ecom_cart = $this->table_prefix . 'ecom_cart';
            if ($qty != 0) {
                $updtQry = "UPDATE $ecom_cart SET qty='$qty' WHERE product_id='$pdt_id' AND customer_id='$user_id'";
                $res = $this->updateData($updtQry, 'Error : D16012012T1657SM239');
                if ($res) {
                    $status['status'] = 1;
                }
            }
            if ($qty == 0) {
                $delQry = "DELETE FROM $ecom_cart WHERE product_id='$pdt_id' AND customer_id='$user_id'";
                $res = $this->deleteData($delQry, 'Error : D16012012T1657SM239');
                if ($res) {
                    $status['status'] = 0;
                }
            }
        }
        $status['total'] = $this->getTotalAmount($user_id);
        $status['sub'] = $this->getUpdatedDetails($pdt_id, $user_id);

        $result = json_encode($status);
        return $result;
    }

    function getUpdatedDetails($pdt_id, $user_id) {
        if ($user_id != "") {
            $ecom_products = $this->table_prefix . 'ecom_products';
            $selQry1 = "SELECT price, tax  FROM $ecom_products WHERE id='$pdt_id'";
            $res = $this->selectData($selQry1, 'Error : D17012012T1006SM263');
            while ($row = mysql_fetch_array($res)) {
                $price = $row["price"];
                $tax = $row["tax"];
            }
        }
        if ($user_id == "") {
            $j = 0;
            $sess_arr = $this->session->userdata("inf_user_cart");
            $i = $sess_arr["count"];
            while ($j < $i) {
                $sess_arr1 = $this->session->userdata("inf_user_product$j");
                if ($sess_arr1["product_id"] == $pdt_id) {
                    $qty = $sess_arr1["qty"];
                }
                $j++;
            }
        } else {
            $ecom_cart = $this->table_prefix . 'ecom_cart';
            $selQry2 = "SELECT qty  FROM $ecom_cart WHERE customer_id='$user_id' AND product_id='$pdt_id'";
            $res = $this->selectData($selQry2, 'Error : D17012012T1006SM263');
            while ($row = mysql_fetch_array($res)) {
                $qty = $row["qty"];
            }
        }
        $value = $price * $qty;
        $tax = ($value * $tax) / 100;
        $total = $value + $tax;
        return $total;
    }

    public function getNextProductId($crr_id) {

        $res = $this->db->select("id")->where("id >", $crr_id)->where("stock_count !=", 0)->like("product_type", "ecommerce")->order_by("id", "ASC")->limit(1)->get("products");

        foreach ($res->result() AS $row) {
            return $row->id;
        }
    }

    public function getMaxProductId($cat_id, $subcat_id) {

        $res = $this->db->select_max("id")->where("stock_count !=", 0)->like("product_type", "ecommerce")->get("products");

        foreach ($res->result() AS $row) {
            return $row->id;
        }
    }

    public function getMinProductId() {

        $res = $this->db->select_min("id")->where("stock_count !=", 0)->like("product_type", "ecommerce")->get("products");

        foreach ($res->result() AS $row) {
            return $row->id;
        }
    }

    public function getPreviousProductId($crr_id) {

        $res = $this->db->select("id")->where("id <", $crr_id)->where("stock_count !=", 0)->like("product_type", "ecommerce")->order_by("id", "DESC")->limit(1)->get("products");

        foreach ($res->result() AS $row) {
            return $row->id;
        }
    }

    public function getItemDetails($id, $cat_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata("inf_pos_prefix");
        }
        $ecom_products = $this->table_prefix . 'ecom_products';
        $selQry = "SELECT * FROM $ecom_products WHERE id='$id' AND category_id='$cat_id'";
        $res = $this->SelectData($selQry, 'Error : D19012012T0957SM334');
        while ($row = mysql_fetch_array($res)) {
            $pdt['product'] = $row['product'];
            $pdt['brand'] = $row['brand'];
            $pdt['price'] = $row['price'];
            $pdt['tax'] = $row['tax'];
            $pdt['featurs'] = $row['featurs'];
            $pdt['description'] = $row['description'];
            $pdt['thumb'] = $row['thumb'];
        }
        $pdt['id'] = $id;
        $pdt['next_id'] = $this->getNextProductId($id, $cat_id);
        $pdt['prev_id'] = $this->getPreviousProductId($id, $cat_id);
        $details = json_encode($pdt);
        return $details;
    }

    function checkout($method, $status) {

        $this->session->set_userdata('inf_shipping_address', "NA");
        $total_price = 0;
        $profit_total = 0;
        $product_price_total = 0;
        $date = date("Y-m-d H:i:s");
        $pos_order = $this->table_prefix . 'pos_e_commerce_order';
        $products = $this->table_prefix . 'products';
        $invoice = $this->getInvoiceNo();
        $aff_id = $this->session->userdata['inf_logged_in']['user_id'];
        $reff_id = $this->getReferalId($aff_id);

        $sess_arr = $this->session->userdata("inf_user_cart");


        if (isset($sess_arr["count"]) > 0) {
            $i = $sess_arr["count"];
            try {
                for ($j = 0; $j < $i; $j++) {

                    $sess_arr4 = $this->session->userdata("inf_user_product$j");

                    $id = $sess_arr4["product_id"];
                    $qty = $sess_arr4["qty"];
                    $profit = $this->getProductPriceDetails($id, $qty, $aff_id);
                    $profit_total = $profit_total + $profit;

                    $shipping_price = "No Shipping Available";

                    $price = $this->getProductPrice($id);
                    $t_price = $price * $qty;
                    $total_price = $total_price + $t_price;
                    if ($shipping_price == "No Shipping Available" || !(is_numeric($shipping_price)))
                        $shipping_price = 0;

                    $this->db->set('pos_e_commerce_order_product_ref_id', $id);
                    $this->db->set('pos_e_commerce_order_price', $t_price);
                    $this->db->set('pos_e_commerce_order_shipping_price', $shipping_price);
                    $this->db->set('pos_e_commerce_order_quantity', $qty);
                    $this->db->set('pos_e_commerce_order_payment_method', $method);
                    $this->db->set('pos_e_commerce_order_status', $status);
                    $this->db->set('pos_e_commerce_order_date', $date);
                    $this->db->set('pos_e_commerce_order_invoice', $invoice);
                    $this->db->set('pos_e_commerce_order_delivery_date', '0000-00-00 00:00:00');
                    $this->db->set('pos_e_commerce_order_affiliate_ref_id', $aff_id);
                    $this->db->set('pos_e_commerce_order_shipping_address', $this->session->userdata('inf_shipping_address'));
                    $res = $this->db->insert($pos_order);

                    if ($res) {
                        $stock_count = $this->getProductStockCount($id);
                        $new_stock_count = $stock_count - $qty;
                        $this->db->set('stock_count', $new_stock_count);
                        $this->db->where('id', $id);
                        $updt = $this->db->update($products);
                        if ($updt) {
                            $this->db->set('shipping_address', $this->session->userdata('inf_shipping_address'));
                            $this->db->set('product_purchase_user', $aff_id);
                            $this->db->set('product_id', $id);
                            $this->db->set('qty', $qty);
                            $this->db->set('date', $date);
                            $this->db->insert('product_purchase_history');
                        }
                    }

                    $pos_invoice = $this->checkFirstPurchase($aff_id);
                    $product_price = $this->getPurchaseProductPrice($id);
                    $product_price_total = $product_price_total + $product_price;
                    $this->session->unset_userdata("inf_user_product$j");
                }

                $this->session->unset_userdata("inf_user_cart");
                $this->session->unset_userdata("inf_user_shipping_address");

                $this->session->set_userdata("inf_user_invoice_no", $invoice);

                $shipp_arr = $this->session->userdata("inf_user_shipping");


                $this->session->unset_userdata("inf_user_shipping");

                return TRUE;
            } catch (Exception $e) {
                return FALSE;
            }
        }
    }

    function getFPRPConfig() {
        $fprp_config = array();
        $FPRP_config = $this->table_prefix . 'fprp_config';
        $this->db->select('*');
        $this->db->from($FPRP_config);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $fprp_config["$i"]["range_start"] = $row['product_price_range_start'];
            $fprp_config["$i"]["range_end"] = $row['product_price_range_end'];
            $fprp_config["$i"]["commission"] = $row['commission'];
            $i++;
        }
        return $fprp_config;
    }

    function checkFirstPurchase($user_id) {
        $pos_e_commerce_order = $this->table_prefix . 'pos_e_commerce_order';
        $this->db->distinct();
        $this->db->select('pos_e_commerce_order_invoice');
        $this->db->where('pos_e_commerce_order_affiliate_ref_id', $user_id);
        $this->db->where('pos_e_commerce_order_sale_type', 'ecommerce');
        $this->db->from($pos_e_commerce_order);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $pos_invoice[$i] = $row['pos_e_commerce_order_invoice'];
            $i++;
        }

        return $pos_invoice;
    }

    function getPurchaseProductPrice($pro_id) {
        $products = $this->table_prefix . 'products';
        $this->db->select('price');
        $this->db->where('id', $pro_id);
        $this->db->from($products);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $retail_price = $row->price;
        }
        return $retail_price;
    }

    function getProductPriceDetails($pro_id, $count) {
        $product = array();
        $ir_discount = 0;
        $products = $this->table_prefix . 'products';
        $this->db->select('retail_price,ir_discount');
        $this->db->where('id', $pro_id);
        $this->db->from($products);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product['retail_price'] = $row['retail_price'];
            $ir_discount = $row['ir_discount'];
        }
        $profit = $count * $ir_discount;
        return $profit;
    }

    function getInvoiceNo() {
        $invoice = 0;
        $pos_order = $this->table_prefix . 'pos_e_commerce_order';
        $this->db->select("max(pos_e_commerce_order_invoice) as pos_e_commerce_invoice");
        $query = $this->db->get($pos_order);
        echo "hhh>>" . $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $invoice = $row["pos_e_commerce_invoice"];
            }
        }
        return $invoice + 1;
    }

    public function getProductImages($product_id) {
        $product_image = "9_product_image";

        $qr = "SELECT * FROM $product_image WHERE pro_image_product_id='$product_id' ORDER BY pro_image_index";
        $res = $this->selectData($qr, "Error on selecting product images.");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $product_images["$i"]["image_name"] = $row["pro_image_file_name"];
            $i++;
        }
        return $product_images;
    }

    public function getPaymentMethodDetails($method) {

        if ($this->pos_prefix == "") {
            $this->pos_prefix = $_SESSION['pos_prefix'];
        }
        $pos_payment_config = $this->pos_prefix . 'pos_payment_config';


        $qr = "select * from $pos_payment_config";
        $res = $this->selectData($qr, "ERR1032223245665265562");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $gateway_type = $row["pos_payment_config_payment_type"];
            if ($gateway_type == "paypal") {
                $payment_config["paypal"]["id"] = $row["pos_payment_config_id"];
                $payment_config["paypal"]["login_id"] = $row["pos_payment_config_login_id"];
                $payment_config["paypal"]["transaction_key"] = $row["pos_payment_config_transaction_key"];
                $payment_config["paypal"]["mode"] = $row["pos_payment_config_payment_mode"];
                $payment_config["paypal"]["signature"] = $row["pos_payment_config_signature"];
                $payment_config["$i"]["type_name"] = "Payment Gateway";
            } else if ($gateway_type == "firstdata") {
                $payment_config["firstdata"]["id"] = $row["pos_payment_config_id"];
                $payment_config["firstdata"]["login_id"] = $row["pos_payment_config_login_id"];
                $payment_config["firstdata"]["transaction_key"] = $row["pos_payment_config_transaction_key"];
                $payment_config["firstdata"]["mode"] = $row["pos_payment_config_payment_mode"];
                $payment_config["$i"]["type_name"] = "Payment Gateway";
            } else if ($gateway_type == "bank") {
                $payment_config["bank"]["bank_name"] = $row["pos_payment_config_bank_name"];
                $payment_config["bank"]["branch"] = $row["pos_payment_config_branch_name"];
                $payment_config["bank"]["accno"] = $row["pos_payment_config_acc_no"];
                $payment_config["bank"]["ifsc"] = $row["pos_payment_config_ifsc_code"];
                $payment_config["bank"]["swift"] = $row["pos_payment_config_swift_code"];
                $payment_config["bank"]["acctype"] = $row["pos_payment_config_acc_type"];
                $payment_config["bank"]["name"] = $row["pos_payment_config_name"];
                $payment_config["bank"]["mode"] = $row["pos_payment_config_payment_mode"];
                $payment_config["$i"]["type_name"] = "Bank Transfer";
            }
            $payment_config["$i"]["type"] = $gateway_type;


            $i++;
        }
        return $payment_config;
    }

    public function getPaymentDetails() {
        if ($this->pos_prefix == "") {
            $this->pos_prefix = $_SESSION['pos_prefix'];
        }
        $ecom_products = $this->table_prefix . 'pos_payment_config';
        $i = 0;
        $qry = "SELECT pos_payment_config_payment_type FROM $ecom_products";
        $res = $this->selectData($qry, 'Error: 14787747fgf452152365gop');
        while ($row = mysql_fetch_array($res)) {
            $previous[$i] = $row['pos_payment_config_payment_type'];
            $i++;
        }

        return $previous;
    }

    public function processCurlPayemnt($post_arr) {
        $url = "https://goso2.com/soft/pay/formit_max.php";

        $cardnumber = $post_arr["cardnumber"];
        $cardexpmonth = $post_arr["cardexpmonth"];
        $host = $post_arr["host"];
        $port = $post_arr["port"];
        $keyfile = $post_arr["keyfile"];
        $configfile = $post_arr["configfile"];

        $result = $post_arr["result"];
        $ordertype = $post_arr["ordertype"];

        $transactionorigin = $post_arr["transactionorigin"];
        $oid = $post_arr["oid"];
        $ponumber = $post_arr["ponumber"];
        $taxexempt = $post_arr["taxexempt"];
        $terminaltype = $post_arr["terminaltype"];
        $ip = $post_arr["ip"];

        $subtotal = $post_arr["subtotal"];
        $tax = $post_arr["tax"];
        $shipping = $post_arr["shipping"];
        $vattax = $post_arr["vattax"];
        $chargetotal = $post_arr["chargetotal"];

        $cardexpyear = $post_arr["cardexpyear"];
        $cvmindicator = $post_arr["cvmindicator"];
        $cvmvalue = $post_arr["cvmvalue"];

        $name = $post_arr["name"];
        $address1 = $post_arr["address1"];
        $address2 = $post_arr["address2"];
        $city = $post_arr["city"];
        $state = $post_arr["state"];
        $country = $post_arr["country"];
        $phone = $post_arr["phone"];
        $email = $post_arr["email"];
        $addrnum = $post_arr["addrnum"];
        $zip = $post_arr["zip"];

        $sname = $post_arr["sname"];
        $saddress1 = $post_arr["saddress1"];
        $saddress2 = $post_arr["saddress2"];
        $scity = $post_arr["scity"];
        $sstate = $post_arr["sstate"];
        $szip = $post_arr["szip"];
        $scountry = $post_arr["scountry"];
        $comments = $post_arr["comments"];

        $debugging = $post_arr["debugging"];
        $debug = $post_arr["debug"];
        $fields = array(
            'cardnumber' => urlencode($cardnumber),
            'cardexpmonth' => urlencode($cardexpmonth),
            'host' => urlencode($host),
            'port' => urlencode($port),
            'keyfile' => urlencode($keyfile),
            'configfile' => urlencode($configfile),
            'result' => urlencode($result),
            'ordertype' => urlencode($ordertype),
            'transactionorigin' => urlencode($transactionorigin),
            'oid' => urlencode($oid),
            'ponumber' => urlencode($ponumber),
            'taxexempt' => urlencode($taxexempt),
            'terminaltype' => urlencode($terminaltype),
            'ip' => urlencode($ip),
            'subtotal' => urlencode($subtotal),
            'tax' => urlencode($tax),
            'shipping' => urlencode($shipping),
            'vattax' => urlencode($vattax),
            'chargetotal' => urlencode($chargetotal),
            'cardexpyear' => urlencode($cardexpyear),
            'cvmindicator' => urlencode($cvmindicator),
            'cvmvalue' => urlencode($cvmvalue),
            'name' => urlencode($name),
            'address1' => urlencode($address1),
            'address2' => urlencode($address2),
            'city' => urlencode($city),
            'state' => urlencode($state),
            'country' => urlencode($country),
            'phone' => urlencode($phone),
            'email' => $email,
            'addrnum' => urlencode($addrnum),
            'zip' => urlencode($zip),
            'sname' => urlencode($sname),
            'saddress1' => urlencode($saddress1),
            'saddress2' => urlencode($saddress2),
            'scity' => urlencode($scity),
            'sstate' => urlencode($sstate),
            'szip' => urlencode($szip),
            'scountry' => urlencode($scountry),
            'comments' => urlencode($comments),
            'debugging' => urlencode($debugging),
            'debug' => urlencode($debug)
        );

        $_SESSION["fields"] = $fields;
        $curl_result = $this->doCurl($url, $fields);
        return $curl_result;
    }

    public function doCurl($url, $datatopost) {
        $jsonheader = array("Accept: application/json", "Content-type:application/json");
        $ch = curl_init();
        $timeout = 5;
        $strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';
        session_write_close();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $strCookie);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $jsonheader);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getShippingAmount($country_id) {
        $i = $_SESSION["cart"]["count"];
        if ($i == 0) {
            $grand_total = 0;
        } else {
            $j = 0;
            while ($j < $i) {
                $pdt["pdt"]['product_id'] = $_SESSION["product$j"]["product_id"];
                $product_id = $pdt["pdt"]['product_id'];
                $pdt["pdt"]['qty'] = $_SESSION["product$j"]["qty"];
                unset($_SESSION["product$j"]["shipping_price"]);
                $details = $this->getProductDetails($pdt["pdt"]['product_id']);
                $weight = $details['weight'];

                $qr1 = "SELECT pro_ship_price,pro_ship_weight,pro_ship_weight_symbol FROM 9_product_shipping WHERE pro_ship_country_ref_id='$country_id' AND pro_ship_config_type LIKE 'weight' AND pro_ship_product_ref_id='$product_id'";
                $res1 = $this->selectData($qr1, "Error on selecting shipping price.");
                while ($row1 = mysql_fetch_array($res1)) {
                    $config_weight = $row1["pro_ship_weight"];
                    if ($weight == $config_weight) {
                        $symbol = "=";
                    } else if ($weight < $config_weight) {
                        $symbol = "<";
                    } else if ($weight > $config_weight) {
                        $symbol = ">";
                    }

                    if ($symbol == $row1["pro_ship_weight_symbol"]) {
                        $_SESSION["product$j"]["shipping_price"] = $row1["pro_ship_price"];
                    }
                }
                if ($_SESSION["product$j"]["shipping_price"] == "") {
                    $_SESSION["product$j"]["shipping_price"] = "No Shipping Available";
                }
                $j++;
            }
        }
    }

    function getTotalShippingAmount($country_id, $user_id = "") {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        if ($user_id == "") {
            $i = $_SESSION["cart"]["count"];
            if ($i == 0) {
                $grand_total = 0;
            } else {
                if (isset($_SESSION["cart"]["amount"])) {
                    $i = $_SESSION["cart"]["count"];
                    $j = 0;
                    while ($j < $i) {
                        $pdt["pdt"]['product_id'] = $_SESSION["product$j"]["product_id"];
                        $pdt["pdt"]['qty'] = $_SESSION["product$j"]["qty"];
                        $amount = $_SESSION["product$j"]["shipping_price"];
                        $grand_total = $grand_total + $amount;
                        $j++;
                    }
                }
            }
        }
        return $grand_total;
    }

    public function insertPaymentDetails($fields, $invoiceno) {
        $cardnumber = $fields["cardnumber"];
        $cardexpmonth = $fields["cardexpmonth"];
        $host = $fields["host"];
        $port = $fields["port"];
        $keyfile = $fields["keyfile"];
        $configfile = $fields["configfile"];

        $result = $fields["result"];
        $ordertype = $fields["ordertype"];

        $transactionorigin = $fields["transactionorigin"];
        $oid = $fields["oid"];
        $ponumber = $fields["ponumber"];
        $taxexempt = $fields["taxexempt"];
        $terminaltype = $fields["terminaltype"];
        $ip = $fields["ip"];

        $subtotal = $fields["subtotal"];
        $tax = $fields["tax"];
        $shipping = $fields["shipping"];
        $vattax = $fields["vattax"];
        $chargetotal = $fields["chargetotal"];

        $cardexpyear = $fields["cardexpyear"];
        $cvmindicator = $fields["cvmindicator"];
        $cvmvalue = $fields["cvmvalue"];

        $name = $fields["name"];
        $address1 = $fields["address1"];
        $address2 = $fields["address2"];
        $city = $fields["city"];
        $state = $fields["state"];
        $country = $fields["country"];
        $phone = $fields["phone"];
        $email = $fields["email"];
        $addrnum = $fields["addrnum"];
        $zip = $fields["zip"];

        $sname = $fields["sname"];
        $saddress1 = $fields["saddress1"];
        $saddress2 = $fields["saddress2"];
        $scity = $fields["scity"];
        $sstate = $fields["sstate"];
        $szip = $fields["szip"];
        $scountry = $fields["scountry"];
        $comments = $fields["comments"];

        $debugging = $fields["debugging"];
        $debug = $fields["debug"];
        if ($this->pos_prefix == "") {
            $this->pos_prefix = $_SESSION['pos_prefix'];
        }
        $cc_details = $this->pos_prefix . 'cc_details';
        $qr = "INSERT INTO $cc_details(cc_details_invoice_no,cc_details_cardnumber,cc_details_cardexpmonth,cc_details_host,cc_details_port,cc_details_keyfile,cc_details_configfile,cc_details_result,cc_details_ordertype,cc_details_transactionorigin,cc_details_oid,cc_details_ponumber,cc_details_taxexempt,cc_details_terminaltype,cc_details_ip,cc_details_subtotal,cc_details_tax,cc_details_shipping,cc_details_vattax,cc_details_chargetotal,cc_details_cardexpyear,cc_details_cvmindicator,cc_details_cvmvalue,cc_details_name,cc_details_address1,cc_details_address2,cc_details_city,cc_details_state,cc_details_country,cc_details_phone,cc_details_email,cc_details_addrnum,cc_details_zip,cc_details_sname,cc_details_saddress1,cc_details_saddress2,cc_details_scity,cc_details_sstate,cc_details_szip,cc_details_scountry,cc_details_comments,cc_details_debugging,cc_details_debug) VALUES ('$invoiceno','$cardnumber','$cardexpmonth','$host','$port','$keyfile','$configfile','$result','$ordertype','$transactionorigin','$oid','$ponumber','$taxexempt','$terminaltype','$ip','$subtotal','$tax','$shipping','$vattax','$chargetotal','$cardexpyear','$cvmindicator','$cvmvalue','$name','$address1','$address2','$city','$state','$country','$phone','$email','$addrnum','$zip','$sname','$saddress1','$saddress2','$scity','$sstate','$szip','$scountry','$comments','$debugging','$debug')";
        $res = $this->insertData($qr, "ERROR on insertIntoPurchaseDetails");
    }

    public function getBankDetails() {
        if ($this->pos_prefix == "") {
            $this->pos_prefix = $_SESSION['pos_prefix'];
        }
        $ecom_products = $this->pos_prefix . 'pos_payment_config';
        $qry = "SELECT * FROM $ecom_products where pos_payment_config_payment_type='bank'";
        $res = $this->selectData($qry, 'Error: 14787747fgf452152365gop');

        $row = mysql_fetch_array($res);

        return $row;
    }

    function getPurchaseDetails($invoice_no) {
        $invoice_details = array();
        $pos_ecommerce_order = $this->table_prefix . "pos_e_commerce_order";
        $qr = $this->db->get_where($pos_ecommerce_order, array('pos_e_commerce_order_invoice' => $invoice_no));

        if ($qr->num_rows() > 0) {
            $i = 0;
            foreach ($qr->result_array() as $row) {
                $invoice_details["$i"]["order_id"] = $row["pos_e_commerce_order_id"];
                $invoice_details["$i"]["quantity"] = $row["pos_e_commerce_order_quantity"];
                $invoice_details["$i"]["price"] = $row["pos_e_commerce_order_price"];
                $invoice_details["$i"]["shipping_price"] = $row["pos_e_commerce_order_shipping_price"];
                $product_ref_id = $row["pos_e_commerce_order_product_ref_id"];
                $invoice_details["$i"]["product_name"] = $this->getProductName($product_ref_id);
                $invoice_details["$i"]["shipping_address"] = $row['pos_e_commerce_order_shipping_address'];
                $i++;
            }
            return $invoice_details;
        }
    }

    public function getShippingDetails($invoice_no) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $shipping_details = $this->table_prefix . "shipping_details";
        $sql = "SELECT * FROM $shipping_details WHERE invoice_ref_id='$invoice_no'";
        $res = $this->selectData($sql, "ERROR OCCURED.......get shipping details");
        $row = mysql_fetch_array($res);
        $ship_details["full_name"] = $row["shipping_full_name"];
        $ship_details["last_name"] = $row["shipping_last_name"];
        $ship_details["address"] = $row["shipping_address"];
        $ship_details["city"] = $row["shipping_city"];
        $ship_details["state"] = $row["shipping_state"];
        $ship_details["country"] = $row["shipping_country"];
        $ship_details["pincode"] = $row["shipping_zipcode"];
        $ship_details["phone"] = $row["shipping_phone"];
        $ship_details["email"] = $row["shipping_email"];
        $ship_details["land_line"] = $row["shipping_land_line"];
        return $ship_details;
    }

    public function getPerDetails($invoice_no) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $personal_details = $this->table_prefix . "personal_details";
        $sql = "SELECT * FROM $personal_details WHERE  invoice_ref_id='$invoice_no'";
        $res = $this->selectData($sql, "ERROR OCCURED.......afghfgjfg");
        $row = mysql_fetch_array($res);
        $details["full_name"] = $row["full_name"];
        $details["last_name"] = $row["last_name"];
        $details["address"] = $row["address"];
        $details["city"] = $row["city"];
        $details["state"] = $row["state"];
        $details["country"] = $row["country"];
        $details["pincode"] = $row["zipcode"];
        $details["phone"] = $row["phone"];
        $details["email"] = $row["email"];
        $details["land_line"] = $row["land_line"];

        return $details;
    }

    function getProductname($ref_id) {
        $res = $this->db->select("*")->where("id", $ref_id)->get("products");

        foreach ($res->result() AS $row) {
            return $row->product;
        }
    }

    public function getCountryNameFromCode($country_code) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $country = $this->table_prefix . "country";
        $qr = "SELECT country_name FROM $country WHERE country_code='$country_code' ";
        $grpres2 = $this->selectData($qr, "Error on selecting count country_code");
        $group2 = mysql_fetch_array($grpres2);
        $country_name = $group2["country_name"];
        return $country_name;
    }

    public function addPurchaseDetails($user_id, $pro_id, $quantity, $sale_type) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $purchase_details = $this->table_prefix . "purchase_details";

        $type = "product";
        $date = date("Y-m-d H:i:s");
        $purchase_pv = $this->getPurchasePV($pro_id);
        $total_purchase_pv = $purchase_pv * $quantity;

        $qr = "INSERT INTO $purchase_details  SET user_id='$user_id',product_id='$pro_id',qty='$quantity',
            purchase_pv='$total_purchase_pv',purchase_date='$date',type='$type'";
        $result = $this->insertData($qr, "ERROR OCCURED >>>>>> add purchase details");

        if ($result) {
            $this->updatePersonelPV($total_purchase_pv, $user_id);
            if ($this->isUnilevel($user_id)) {
                $this->updateMonthlyPointDetails($user_id, $total_purchase_pv);
                $this->updateUnilevelCVDetails($user_id, $total_purchase_pv);
            }
            if ($sale_type == "ecommerce")
                $this->insertWholesaleRetailCutting($user_id, $pro_id, $quantity);
        }
    }

    public function insertWholesaleRetailCutting($user_id, $pro_id, $quantity) {
        $country_id = $this->getUserCountryId($user_id);
        $whole_price = $this->getProductCountryPrice($pro_id, $country_id, "whole_sale");
        $retail_price = $this->getProductCountryPrice($pro_id, $country_id, "retail");
        if ($whole_price && $retail_price) {
            $total_whole_price = $whole_price * $quantity;
            $total_retail_price = $retail_price * $quantity;
            $cutting_amount = $total_retail_price - $total_whole_price;
            $release_date = date("Y-m-t 23:59:59");
            $this->insertAmountToLegAmount($user_id, $cutting_amount, 0, "cutting", $release_date);
        }
    }

    public function insertAmountToLegAmount($user_id, $level_amount, $level, $amount_type, $release_date) {

        $obj_arr = $this->getSettings();
        $date_of_sub = date("Y-m-d H:i:s");
        $tds_db = $obj_arr["tds"];
        $service_charge_db = $obj_arr["service_charge"];
        $tds_amount = ($level_amount * $tds_db) / 100;
        $service_charge = ($level_amount * $service_charge_db) / 100;
        $amount_payable = $level_amount - ($tds_amount + $service_charge);
        if ($user_id != 0) {
            $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $release_date);
            $this->updateBalanceAmount($user_id, $amount_payable);
        }
    }

    public function getSettings() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $configuration = $this->table_prefix . "configuration";
        $qr = "SELECT tds,service_charge FROM $configuration";
        $res = $this->selectData($qr, "Error on selecting setting...44545.");
        $row = mysql_fetch_array($res);
        $obj_arr["tds"] = $row['tds'];
        $obj_arr["service_charge"] = $row['service_charge'];
        return $obj_arr;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $release_date) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $leg_amount = $this->table_prefix . "leg_amount";
        $sql = "INSERT INTO $leg_amount SET
                user_id='$user_id',
                total_amount='$total_amount',
                amount_payable='$amount_payable',
                date_of_submission='$date_of_sub',
                user_level='$level',
                amount_type = '$amount_type'";
        $result = $this->insertData($sql, "Error on insert/update member 1");
        return $result;
    }

    public function getProductStockCount($pd_id) {
        $products = $this->table_prefix . "products";
        $this->db->select('stock_count');
        $qry = $this->db->get_where($products, array('id' => $pd_id));
        if ($qry->num_rows() == 1) {
            foreach ($qry->result() as $row) {
                return $row->stock_count;
            }
        }
    }

    public function updateBalanceAmount($user_id, $total_amount) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $total_amount = round($total_amount, 2);
        $user_balance_amount = $this->table_prefix . "user_balance_amount";
        $qr = "UPDATE  $user_balance_amount SET balance_amount=balance_amount+ '$total_amount' WHERE user_id='$user_id' ";
        $this->insertData($qr, "Error on inserting balance amount 16575253mmm");
    }

    public function getUserCountryId($user_id) {
        $qr = "SELECT user_detail_country FROM 9_user_details WHERE user_detail_refid='$user_id'";
        $res = $this->selectData($qr, "ERROR on selecting country name");
        $row = mysql_fetch_array($res);
        $country = $row['user_detail_country'];

        $qr1 = "SELECT country_id FROM 9_country WHERE country_name='$country'";
        $res1 = $this->selectData($qr1, "ERROR on selecting country name");
        $row1 = mysql_fetch_array($res1);
        $country_id = $row1['country_id'];
        return $country_id;
    }

    public function getProductCountryPrice($pro_id, $country_id, $type) {

        $qr = "SELECT pro_prices_price FROM 9_product_prices WHERE pro_prices_product_ref_id='$pro_id' 
						AND pro_prices_user_type='$type' AND pro_prices_country_id='$country_id'";
        $res = $this->selectData($qr, 'ERR ON price country product');
        $row = mysql_fetch_array($res);
        $price = $row['pro_prices_price'];
        return $price;
    }

    public function updateUnilevelCVDetails($user_id, $purchase_pv) {
        $users = $this->getNineLevelUplineUsers($user_id, 0, 9);
        for ($i = 0; $i < count($users); $i++) {
            $uid = $users[$i];
            $level = $i + 1;
            $this->updateUnilevelCV($uid, $purchase_pv, $level);
        }
    }

    public function updateUnilevelCV($user_id, $purchase_pv, $level) {
        $month_end_date = date("Y-m-t 23:59:59");
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $monthly_unilevel_cv = $this->table_prefix . "monthly_unilevel_cv";
        $qr1 = "SELECT count(*) AS cnt FROM $monthly_unilevel_cv WHERE
                    user_id='$user_id' AND month_end_date='$month_end_date'";
        $res = $this->selectData($qr1, "ERROR on update points");
        $row = mysql_fetch_array($res);
        $cnt = $row['cnt'];
        if ($cnt > 0) {
            $qr = "UPDATE $monthly_unilevel_cv SET level$level = level$level+'$purchase_pv',total_cv=total_cv+'$purchase_pv'
                    WHERE user_id='$user_id' AND month_end_date='$month_end_date'";
            $this->updateData($qr, "ERROR ON update uni points123");
        } else {
            $qr = "INSERT INTO $monthly_unilevel_cv SET level$level = '$purchase_pv'
                    , user_id='$user_id' , month_end_date='$month_end_date',total_cv='$purchase_pv'";
            $this->insertData($qr, "ERROR ON insert uni points123");
        }
    }

    public function getPurchasePV($pro_id) {

        /*         * *************************** CODE ADDED BY JIJI **************************** */
        /*         * ************* To get purchase pv of a product ************** */

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $table = $this->table_prefix . "product";

        $qr = "SELECT pro_bv FROM $table WHERE pro_id='$pro_id'";
        $result = $this->selectData($qr, "ERROR OCCURED >>>>>> getPurchasePV");
        $row = mysql_fetch_array($result);
        $purchase_pv = $row["pro_bv"];

        return $purchase_pv;
    }

    public function updatePersonelPV($total_purchase_pv, $user_id) {

        $month_end_date = date("Y-m-t 23:59:59");
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $monthly_point_details = $this->table_prefix . "monthly_point_details";
        $qr1 = "SELECT count(*) AS cnt FROM $monthly_point_details WHERE
                    user_id='$user_id' AND month_end_date='$month_end_date'";
        $res1 = $this->selectData($qr1, "ERROR on update points");
        $row = mysql_fetch_array($res1);
        $cnt = $row['cnt'];
        if ($cnt > 0) {
            $qr = "UPDATE $monthly_point_details SET pv = pv+$total_purchase_pv  WHERE user_id='$user_id'
							AND month_end_date='$month_end_date'";
            $res = $this->updateData($qr, "ERROR OCCURED >>>>>> update personel PV ");
        } else {
            $qr = "INSERT INTO $monthly_point_details SET pv = '$total_purchase_pv'  , user_id='$user_id'
							, month_end_date='$month_end_date'";
            $res = $this->insertData($qr, "ERROR OCCURED >>>>>> insert personel PV ");
        }
        if ($res && !$this->isUnilevel($user_id))
            $this->updateUplineCvDetails($user_id, $total_purchase_pv);
    }

    public function updateMonthlyPointDetails($user_id, $package_pv) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $table = $this->table_prefix . "monthly_point_details";

        $sponsor_id = $this->getSponsorID($user_id);

        while ($sponsor_id != "" && $sponsor_id != 0) {

            $this->updateMonthlyPoints($sponsor_id, $package_pv);

            $sponsor_id = $this->getSponsorID($sponsor_id);
        }
    }

    public function updateMonthlyPoints($user_id, $package_pv) {
        $month_end_date = date("Y-m-t 23:59:59");
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $monthly_point_details = $this->table_prefix . "monthly_point_details";
        $qr = "SELECT count(*) AS cnt FROM $monthly_point_details WHERE 
                    user_id='$user_id' AND month_end_date='$month_end_date'";
        $res = $this->selectData($qr, "ERROR on update points");
        $row = mysql_fetch_array($res);
        $cnt = $row['cnt'];
        if ($cnt > 0) {
            $qr = "UPDATE $monthly_point_details SET gqv = gqv+'$package_pv'
                    WHERE user_id='$user_id' AND month_end_date='$month_end_date'";
            $this->updateData($qr, "ERROR ON updatepoints123");
        } else {
            $qr = "INSERT INTO $monthly_point_details SET gqv = '$package_pv'
                    , user_id='$user_id' , month_end_date='$month_end_date'";
            $this->insertData($qr, "ERROR ON insert points123");
        }
    }

    public function getSponsorID($user_id) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $table = $this->table_prefix . "sponsor_details";

        $qr = "SELECT sponsor_id FROM $table WHERE user_id='$user_id'";
        $result = $this->selectData($qr, "ERROR OCCURED >>>>>> getSponsorID");
        $row = mysql_fetch_array($result);

        $sponsor_id = $row["sponsor_id"];


        return $sponsor_id;
    }

    public function isUnilevel($user_id) {
        $flag = FALSE;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";

        $qr = "SELECT count(id) as cnt FROM $ft_individual  WHERE id='$user_id' ";
        $result = $this->selectData($qr, "ERROR OCCURED >>>>>> is unilevel");

        $row = mysql_fetch_array($result);

        if ($row["cnt"] > 0)
            $flag = TRUE;
        return $flag;
    }

    public function updateUplineCvDetails($user_id, $total_purchase_pv) {

        $arr = $this->getPositionFatherID($user_id);
        $father_id = $arr['father_id'];

        $user_position = $arr['position'];
        while ($father_id != "" && $father_id != 0) {
            if (!$this->isUnilevel($father_id)) {
                $week_end_date = $this->getNextWeekEndDate();
                $this->updateLeftRightCv($father_id, $user_position, $total_purchase_pv);
                $this->updateCurrentCV($father_id, $user_position, $total_purchase_pv);
                $arr = $this->getPositionFatherID($father_id);
                $father_id = $arr['father_id'];
                $user_position = $arr['position'];
            } else
                return TRUE;
        }
    }

    public function getPositionFatherID($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $table = $this->table_prefix . "ft_individual";
        $qr = "SELECT father_id,position FROM $table WHERE id='$user_id'";
        $result = $this->selectData($qr, "ERROR OCCURED >>>>>> getFatherID");
        $row = mysql_fetch_array($result);
        $arr['father_id'] = $row["father_id"];
        $arr['position'] = $row["position"];
        return $arr;
    }

    public function updateCurrentCV($father_id, $user_position, $total_purchase_pv) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $table = $this->table_prefix . "sponsor_details";
        if ($user_position == "L") {
            $left_cv = $total_purchase_pv;
            $right_cv = 0;
        } else if ($user_position == "R") {
            $left_cv = 0;
            $right_cv = $total_purchase_pv;
        }
        $qr = "UPDATE $table SET current_left_cv = current_left_cv+$left_cv ,
                            current_right_cv = current_right_cv+$right_cv WHERE user_id='$father_id'";
        $res = $this->updateData($qr, "ERROR OCCURED >>>>>> update personel PV ");
    }

    public function updateLeftRightCv($user_id, $user_leg, $total_cv) {
        $week_end_date = $this->getNextWeekEndDate();
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $weekly_cv_details = $this->table_prefix . "weekly_cv_details";
        $qr = "SELECT count(*) AS cnt FROM $weekly_cv_details WHERE user_id='$user_id' AND weak_end_date='$week_end_date'";
        $res = $this->selectData($qr, "ERROR on update l r cv");
        $row = mysql_fetch_array($res);
        $cnt = $row['cnt'];
        if ($user_leg == "L") {
            $left_cv = $total_cv;
            $right_cv = 0;
        } else if ($user_leg == "R") {
            $left_cv = 0;
            $right_cv = $total_cv;
        }
        if ($cnt > 0) {
            $qr = "UPDATE $weekly_cv_details SET  left_cv=left_cv+'$left_cv',right_cv=right_cv+'$right_cv' 
                                WHERE user_id='$user_id' AND weak_end_date='$week_end_date'";
            $res = $this->insertData($qr, "ERROR OCCURED >>>>>> insert lrcvdet");
        } else {
            $qr = "INSERT INTO $weekly_cv_details SET user_id='$user_id', left_cv='$left_cv',
                                right_cv='$right_cv', weak_end_date='$week_end_date'";
            $res = $this->insertData($qr, "ERROR OCCURED >>>>>> insert lrcvdet");
        }
    }

    public function getNextWeekEndDate() {
        $date = date("Y-m-d");
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $week_end_dates = $this->table_prefix . "week_end_dates";
        $sql = "SELECT week_end_date FROM  $week_end_dates  WHERE week_end_date > '$date' LIMIT 1";
        $rs = $this->selectData($sql, "Error on selection getNextWeekEndDate123");
        $row = mysql_fetch_array($rs);
        $week_end_date = $row["week_end_date"];
        return $week_end_date;
    }

    public function getNineLevelUplineUsers($id, $i, $limit) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $select = "SELECT sponsor_id
					FROM $ft_individual
					WHERE id='$id'";
        $result = $this->selectData($select, "Error on selction 9 upline users");
        $cnt = mysql_num_rows($result);
        if ($cnt > 0) {
            $row = mysql_fetch_array($result);
            $father_id = $row['sponsor_id'];
            if ($father_id) {
                $this->uplines[$i] = $father_id;
                $i = $i + 1;
                if ($i < $limit) {
                    $this->getNineLevelUplineUsers($father_id, $i, $limit);
                }
            }
        }
        return $this->uplines;
    }

    public function insertShippingDetails($invoice, $regr) {
        $flag = false;
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $shipping_details = $this->table_prefix . "shipping_details";

        $data = array('invoice_ref_id' => $invoice,
            'shipping_full_name' => $regr['shipping_name'],
            'shipping_last_name' => $regr['shipping_last_name'],
            'shipping_address' => $regr['shipping_address'],
            'shipping_city' => $regr['shipping_city'],
            'shipping_state' => $regr['shipping_state'],
            'shipping_country' => $regr['shipping_country'],
            'shipping_zipcode' => $regr['shipping_pincode'],
            'shipping_phone' => $regr['shipping_phone'],
            'shipping_land_line' => $regr['shipping_land_line'],
            'shipping_email' => $regr['shipping_email']
        );
        $reg_res = $this->db->insert('9_shipping_details', $data);
        if ($reg_res > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function insertPersonalDetails($invoice, $regr) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata['inf_table_prefix'];
        }
        $personal_details = $this->table_prefix . "personal_details";

        $data = array('invoice_ref_id' => $invoice,
            'full_name' => $regr['name'],
            'last_name' => $regr['last_name'],
            'address' => $regr['address'],
            'city' => $regr['city'],
            'state' => $regr['state'],
            'country' => $regr['country'],
            'zipcode' => $regr['pincode'],
            'phone' => $regr['phone'],
            'land_line' => $regr['land_line'],
            'email' => $regr['email']);
        $reg_res = $this->db->insert('9_personal_details', $data);
        return $reg_res;
    }

    public function getCategory() {
        $category = array();
        $category_tbl = $this->table_prefix . 'category_tbl';
        $this->db->select("*");
        $this->db->from("$category_tbl");
        $this->db->order_by("category", "asc");
        $qr = $this->db->get();

        $i = 1;
        foreach ($qr->result_array() as $row) {
            $category["cat$i"]['id'] = $row['id'];
            $category["cat$i"]['category'] = $row['category'];
            $category["cat$i"]['image'] = $row['image'];
            $category["cat$i"]['date_of_entry'] = $row['date'];
            $i++;
        }
        return $category;
    }

    public function userNameToID($username) {
        $ft_individual = $this->table_prefix . 'ft_individual';
        $user_id = "";
        $this->db->select('id');
        $this->db->from($ft_individual);
        $this->db->where('user_name', $username);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }

        return $user_id;
    }

    public function updateUserStatus($user_id) {

        $current_status = $this->getUserCurrentStatus($user_id);
        if ($current_status == "TC") {
            $user_status_table = $this->table_prefix . 'user_status_table';
            $this->db->set('user_status', 'QUV');
            $this->db->where('user_id', $user_id);
            $res = $this->db->update($user_status_table);
            $reff_id = $this->getReferalId($user_id);
            $reff_id_status = $this->getUserCurrentStatus($reff_id);
            $active_status = $this->getUserActiveStatus($reff_id);
            if ($active_status == 'no') {
                $this->selectInactiveUserCount($reff_id);
            }
        }
    }

    public function selectInactiveUserCount($user_id) {
        $act_date = date("Y-m-d H:i:s");
        $ft_individual = $this->table_prefix . 'ft_individual';
        $this->db->select('id');
        $this->db->select('date_of_joining');
        $this->db->where('sponsor_id', $user_id);
        $this->db->from($ft_individual);
        $this->db->group_by("id");
        $query = $this->db->get();
        $count = 0;
        $i = 0;
        foreach ($query->result_array() as $row) {
            $id["$i"] = $row['id'];
            $date_of_joining = $row['date_of_joining'];
            $user_status = $this->checkUserStatus($id["$i"]);
            if ($user_status == 'QUV') {
                $count++;
            }
            $i++;
        }

        if ($count == 2) {
            $this->updateCurrentStatus($user_id);
            $res1 = $this->activateUser($user_id);
            $res2 = $this->activateUnilevelUser($user_id);
            $date_diff_sec = abs(strtotime($act_date) - strtotime($date_of_joining));
            $date_diff_day = floor($date_diff_sec / (60 * 60 * 24));
            $date_diff = $date - $date_of_joining;
            if ($res2 AND $res1 AND $date_diff_day <= 28) {

                $this->insertAmountToLegAmount($user_id, 50, 0, "QSC", $act_date);
            }
        }
    }

    public function updateCurrentStatus($user_id) {
        $user_status_table = $this->table_prefix . 'user_status_table';

        $this->db->set('user_status', 'Active');
        $this->db->where('user_id', $user_id);
        $res = $this->db->update($user_status_table);
        return $res;
    }

    public function checkUserStatus($id) {
        $user_status_table = $this->table_prefix . 'user_status_table';
        $this->db->select('user_status');
        $this->db->where('user_id', $id);
        $this->db->from($user_status_table);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_status = $row->user_status;
        }
        return $user_status;
    }

    public function activateUnilevelUser($user_id) {
        $ft_individual = $this->table_prefix . 'ft_individual';

        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update($ft_individual);
        return $res;
    }

    public function activateUser($user_id) {
        $ft_individual = $this->table_prefix . 'ft_individual';

        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update($ft_individual);
        return $res;
    }

    public function getUserCurrentStatus($user_id) {
        $user_status = "";
        $user_status_table = $this->table_prefix . 'user_status_table';
        $this->db->select('user_status');
        $this->db->where('user_id', $user_id);
        $this->db->from($user_status_table);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_status = $row->user_status;
        }
        return $user_status;
    }

    public function getUserActiveStatus($user_id) {
        $user_active_status = "";
        $ft_individual = $this->table_prefix . 'ft_individual';
        $this->db->select('active');
        $this->db->where('id', $user_id);
        $this->db->from($ft_individual);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_active_status = $row->active;
        }
        return $user_active_status;
    }

    public function getReferalId($user_id) {

        $referal_id = "";
        $ft_individual = 'ft_individual';
        $this->db->select('sponsor_id');
        $this->db->where('id ', $user_id);
        $this->db->from("$ft_individual");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_id = $row->sponsor_id;
        }
        return $referal_id;
    }

    public function getUserFatherAndPosition($user_id) {
        $user_det = array();
        $res = $this->db->select("father_id,position")->where('id', $user_id)->get("ft_individual");
        foreach ($res->result() AS $row) {
            $user_det['father_id'] = $row->father_id;
            $user_det['position'] = $row->position;
        }
    }

    public function updateUserCUV($user_id, $position, $product_id, $product_qty) {
        $product_cuv = $this->getProductCUV($product_id);
        $i = 0;
        $this->getAllUplineId($user_id, $i, $position);
        $product_cuv_tot = $product_cuv * $product_qty;
        $this->updateAllUpline($product_cuv_tot);
    }

    public function getProductCUV($product_id) {
        $res = $this->db->select("cuv_value")->where('id', $product_id)->get("products");
        foreach ($res->result() AS $row)
            return $row->cuv_value;
    }

    public function getAllUplineId($id, $i = 0, $child_position = '') {
        $father_id = 0;
        $query = $this->db->select("father_id,position")->where("id", "$id")->get("ft_individual");

        $cnt = $query->num_rows();
        if ($cnt > 0) {
            foreach ($query->result_array() AS $row) {

                $father_id = $row['father_id'];
                $this->upline_id_arr["detail$i"]["id"] = $id;
                $this->upline_id_arr["detail$i"]["position"] = $row['position'];

                if ($i == 0) {
                    $this->upline_id_arr["detail$i"]["child_position"] = $child_position;
                } else {
                    $k = $i - 1;
                    $this->upline_id_arr["detail$i"]["child_position"] = $this->upline_id_arr["detail$k"]["position"];
                }
                $i = $i + 1;
            }
            if ($father_id != 0) {
                $this->getAllUplineId($father_id, $i);
            }
        }
    }

    public function getUserCurrentCUVCarry($id, $leg = 'left') {
        $CUV_field = '';
        if ($leg == "left")
            $CUV_field = 'total_left_CUV_carry';
        else
            $CUV_field = 'total_right_CUV_carry';
        $query = $this->db->select("$CUV_field")->where("id", "$id")->get("leg_details");
        foreach ($query->result() AS $row)
            return $row->$CUV_field;
    }

    public function updateAllUpline($product_cuv) {

        $total_len = count($this->upline_id_arr);
        $user_left_id = array();
        $user_right_id = array();
        $split_arr_left = array();
        $split_arr_right = array();
        $all_id = array();

        for ($i = 0; $i <= $total_len; $i++) {
            if (array_key_exists("detail$i", $this->upline_id_arr)) {
                $user_id = $this->upline_id_arr["detail$i"]["id"];
                $position = $this->upline_id_arr["detail$i"]["child_position"];
                if ($position == "L") {
                    $user_left_id[] = $user_id;
                } else if ($position == "R") {
                    $user_right_id[] = $user_id;
                }
            }
        }

        $letf_id_count = count($user_left_id);

        if ($letf_id_count > 0) {

            if ($letf_id_count >= 5000) {
                $input_array = $user_left_id;
                $split_arr_left = array_chunk($input_array, intval($letf_id_count / 4));

                for ($i = 0; $i < count($split_arr_left); $i++) {

                    $all_id = $split_arr_left[$i];
                    for ($i = 0; $i < count($all_id); $i++) {
                        if ($i == 0)
                            $this->db->where("id", $all_id[$i]);
                        else
                            $this->db->or_where("id", $all_id[$i]);
                    }

                    $this->db->set("total_left_CUV", 'ROUND(total_left_CUV + ' . $product_cuv . ',2)', FALSE);
                    $this->db->set("total_left_CUV_carry", 'ROUND(total_left_CUV_carry +' . $product_cuv . ',2)', FALSE);
                    $result = $this->db->update("leg_details");
                }
            } else {
                $all_id = $user_left_id;
                for ($i = 0; $i < count($all_id); $i++) {
                    if ($i == 0)
                        $this->db->where("id", $all_id[$i]);
                    else
                        $this->db->or_where("id", $all_id[$i]);
                }
                $this->db->set("total_left_CUV", 'ROUND(total_left_CUV +' . $product_cuv . ',2)', FALSE);
                $this->db->set("total_left_CUV_carry", 'ROUND(total_left_CUV_carry +' . $product_cuv . ',2)', FALSE);

                $result = $this->db->update("leg_details");
            }
        }



        $right_id_count = count($user_right_id);
        if ($right_id_count > 0) {

            if ($right_id_count >= 5000) {
                $input_array = $user_right_id;
                $split_arr_right = array_chunk($input_array, intval($right_id_count / 4));
                for ($i = 0; $i < count($split_arr_right); $i++) {
                    $all_id = $split_arr_right[$i];
                    for ($i = 0; $i < count($all_id); $i++) {
                        if ($i == 0)
                            $this->db->where("id", $all_id[$i]);
                        else
                            $this->db->or_where("id", $all_id[$i]);
                    }

                    $this->db->set("total_right_CUV", 'ROUND(total_right_CUV +' . $product_cuv, '2)', FALSE);
                    $this->db->set("total_right_CUV_carry", 'ROUND(total_right_CUV_carry +' . $product_cuv, '2)', FALSE);
                    $result = $this->db->update("leg_details");
                }
            } else {
                $all_id = $user_right_id;
                for ($i = 0; $i < count($all_id); $i++) {
                    if ($i == 0)
                        $this->db->where("id", $all_id[$i]);
                    else
                        $this->db->or_where("id", $all_id[$i]);
                }
                $this->db->set("total_right_CUV", 'ROUND(total_right_CUV +' . $product_cuv . ',2)', FALSE);
                $this->db->set("total_right_CUV_carry", 'ROUND(total_right_CUV_carry +' . $product_cuv . ',2)', FALSE);
                $result = $this->db->update("leg_details");
            }
        }
    }

    public function calculateUserRSP($user_id, $product_id, $prodcut_qty) {

        $product_price = $this->getProductPrice($product_id);
        $RSP_tot = floor(($product_price * $prodcut_qty) * (10 / 100)); //RSP=10% of product price 

        $this->getAllUplineIdUnilevel($user_id, 0);
        $this->updateAllUplineUnilevel($RSP_tot);
    }

    public function getAllUplineIdUnilevel($id, $i = 0) {
        if ($i < 3) {
            $father_id = 0;
            $query = $this->db->select("sponsor_id")->where("id", "$id")->get("ft_individual");

            $cnt = $query->num_rows();
            if ($cnt > 0) {
                foreach ($query->result_array() AS $row) {

                    $father_id = $row['sponsor_id'];
                    if ($father_id != 0)
                        $this->upline_id_arr_unilevel["detail$i"]["id"] = $father_id;

                    $i = $i + 1;
                }
                if ($father_id != 0) {
                    $this->getAllUplineIdUnilevel($father_id, $i);
                }
            }
        }
    }

    public function updateAllUplineUnilevel($product_rsp) {

        $total_len = count($this->upline_id_arr_unilevel);
        $date = date("Y-m-d H:i:s");
        for ($i = 0; $i <= $total_len; $i++) {
            if (array_key_exists("detail$i", $this->upline_id_arr_unilevel)) {
                $user_id = $this->upline_id_arr_unilevel["detail$i"]["id"];

                $data = array("user_id" => "$user_id",
                    "total_rsp_commission" => "$product_rsp",
                    "rsp_date" => "$date");
                $result = $this->db->insert("rsp_commission_details", $data);
            }
        }
    }

}

?>
