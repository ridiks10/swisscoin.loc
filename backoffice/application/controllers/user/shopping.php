<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'Inf_Controller.php';

class Shopping extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('shopping_model');
    }

    function index() {
        $title = $this->lang->line('Shopping');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[0]["name"] = "layout_ecom.css";
        $this->ARR_SCRIPT[0]["type"] = "css";
        $this->load_langauge_scripts();

        $category = $this->shopping_model->getCategory();
        $this->set('categories', $category);
        $count = $this->shopping_model->getShoppingInfo("");
        $this->set('items', $count);
        $amount = $this->shopping_model->getTotalAmount("");
        $this->set('amount', $amount);
        $base = base_url();
        $path = "$base../";
        $image_path = $path . "pos/public_html/images/products/";
        $this->set('image_path', $image_path);

        $this->set("tran_Product_Categories", $this->lang->line('Product_Categories'));
        $this->set("tran_No_Category_Found", $this->lang->line('No_Category_Found'));

        $this->setView();
    }

    function products($cal_id = "") {
        $base = base_url();
        $path = "$base../";
        $image_path = $path . "pos/public_html/images/products/";
        $this->set('image_path', $image_path);

        $title = $this->lang->line("Products");
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $pdts = $this->shopping_model->getProducts($cal_id);
        $this->set('products', $pdts);

        $this->ARR_SCRIPT[0]["name"] = "layer.css";
        $this->ARR_SCRIPT[0]["type"] = "css";

        $this->ARR_SCRIPT[1]["name"] = "jquery.uilock.js";
        $this->ARR_SCRIPT[1]["type"] = "js";

        $this->ARR_SCRIPT[2]["name"] = "jquery.uilock.min.js";
        $this->ARR_SCRIPT[2]["type"] = "js";

        $this->ARR_SCRIPT[3]["name"] = "shopping.js";
        $this->ARR_SCRIPT[3]["type"] = "js";

        $this->ARR_SCRIPT[4]["name"] = "layout_ecom.css";
        $this->ARR_SCRIPT[4]["type"] = "css";

        $this->load_langauge_scripts();

        //////////////////////////CODE ADDED BY JIJI----------for lang translation

        $this->set("tran_Products", $this->lang->line("Products"));
        $this->set("tran_Basic_Price", $this->lang->line("Basic_Price"));
        $this->set("tran_Please_Wait", $this->lang->line("Please_Wait"));
        $this->set("tran_No_items_found", $this->lang->line("No_items_found"));
        $this->set("tran_Back_to_Product_Categories", $this->lang->line('Back_to_Product_Categories'));
        ///////////////////////////////////////////////////////////////////////////

        $user_id = "";
        //$user_id =$this->session->userdata('inf_ecom_user_id');

        $count = $this->shopping_model->getShoppingInfo($user_id);
        $this->set('items', $count);

        $amount = $this->shopping_model->getTotalAmount($user_id);

        $this->set('amount', $amount);
        $MESSAGE_STATUS = "";
        $this->set('MESSAGE_STATUS', $MESSAGE_STATUS);

        $this->setView();
    }

    function view_details($id = "") {

        $base = base_url();
        $path = "$base../";
        $image_path = $path . "pos/public_html/images/products/";
        $this->set('image_path', $image_path);

        //echo  $id = $this->uri->segment(4); //$this->URL['product'];
        $subcatid = "";
        $catid = "";

        $pdts = $this->shopping_model->getProductDetails($id);
        $this->set('title', $this->COMPANY_NAME . ' | ' . $pdts['product']);

        $this->set('products_details', $pdts);
        $this->set('pid', $id);

        $nxt = $this->shopping_model->getNextProductId($id);
        $this->set('nxt', $nxt);
        $prv = $this->shopping_model->getPreviousProductId($id);
        $this->set('prv', $prv);
        $minId = $this->shopping_model->getMinProductId($catid, $subcatid);
        $this->set('minId', $minId);
        $maxId = $this->shopping_model->getMaxProductId($catid, $subcatid);
        $this->set('maxId', $maxId);

        $this->ARR_SCRIPT[0]["name"] = "shopping.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->ARR_SCRIPT[1]["name"] = "details_navigation.js";
        $this->ARR_SCRIPT[1]["type"] = "js";

        $this->ARR_SCRIPT[2]["name"] = "etalage.min.css";
        $this->ARR_SCRIPT[2]["type"] = "css";

        $this->ARR_SCRIPT[3]["name"] = "layout_ecom.css";
        $this->ARR_SCRIPT[3]["type"] = "css";

        $this->load_langauge_scripts();

        //$user_id = $this->session->userdata('inf_ecom_user_id');
        $user_id = "";

        $count = $this->shopping_model->getShoppingInfo($user_id);
        $this->set('items', $count);

        $amount = $this->shopping_model->getTotalAmount($user_id);
        $this->set('amount', $amount);

        /////////////////////////////

        $this->set("tran_Brand", $this->lang->line("Brand"));
        $this->set("tran_Price", $this->lang->line("Price"));
        $this->set("tran_Rate_of_Tax", $this->lang->line("Rate_of_Tax"));
        $this->set("tran_Quantity", $this->lang->line("Quantity"));
        $this->set("tran_Add_to_Cart", $this->lang->line("Add_to_Cart"));
        $this->set("tran_Description", $this->lang->line("description"));
        $this->set("tran_Features", $this->lang->line("Features"));
        $this->set("tran_Back_to_Product_Categories", $this->lang->line('Back_to_Product_Categories'));
        ////////////////////////////
        //echo $_SESSION["cart"]["count"];
        $this->setView('layout/header');

        $this->setView('shopping/view_details');
    }

    function my_cart() {

        $base = base_url();
        $path = "$base../";
        $image_path = $path . "pos/public_html/images/products/";
        $this->set('image_path', $image_path);

        $title = $this->lang->line("My_Cart");
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[0]["name"] = "shopping.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        $this->ARR_SCRIPT[1]["name"] = "layout_ecom.css";
        $this->ARR_SCRIPT[1]["type"] = "css";
        $this->load_langauge_scripts();
        ///////////////////////
        $this->set("tran_View_Cart", $this->lang->line("View_Cart"));
        $this->set("tran_Product", $this->lang->line("product"));
        $this->set("tran_Unit_Price", $this->lang->line("Unit_Price"));
        $this->set("tran_Tax", $this->lang->line("Tax"));
        $this->set("tran_Quantity", $this->lang->line("Quantity"));
        $this->set("tran_Sub_total", $this->lang->line("Sub_total"));
        $this->set("tran_Remove", $this->lang->line("Remove"));
        $this->set("tran_Update", $this->lang->line("update"));
        $this->set("tran_Remove_All", $this->lang->line("Remove_All"));
        $this->set("tran_Continue_Shopping", $this->lang->line("Continue_Shopping"));
        $this->set("tran_Grand_Total", $this->lang->line("Grand_Total"));
        $this->set("tran_Check_Out", $this->lang->line("Check_Out"));
        $this->set("tran_No_items_found_in_your_cart", $this->lang->line("No_items_found_in_your_cart"));
        $this->set("tran_Sure_you_want_to_remove_this_Product", $this->lang->line("Sure_you_want_to_remove_this_Product"));
        $this->set("tran_Sure_you_want_to_Check_out", $this->lang->line("Sure_you_want_to_Check_out"));
        $this->set("tran_Sure_you_want_to_remove_all_items", $this->lang->line("Sure_you_want_to_remove_all_items"));
        $this->set("tran_Back_to_Product_Categories", $this->lang->line('Back_to_Product_Categories'));
        ///////////////////////
        $cart_arr = $this->session->userdata('inf_user_cart');
        $user_id = $this->session->userdata('inf_ecom_user_id');
        if (isset($cart_arr["count"]) && ($cart_arr["count"] > 0)) {
            for ($i = 0; $i < $cart_arr["count"]; $i++) {

                if ($this->input->post("update_qty" . $i)) {
                    $POST = $this->input->post();
                    $POST = $this->validation_model->stripTagsPostArray($POST);
                    $POST = $this->validation_model->escapeStringPostArray($POST);
                    $qty = $POST["qty" . $i];
                    $pdt_id = $POST["pdtid" . $i];
                    $this->session->set_userdata("inf_user_product$i", array('qty' => $qty, 'product_id' => $pdt_id));

                    if ($qty <= 0) {
                        $this->session->set_userdata("inf_user_cart", array('count' => $cart_arr["count"] - 1, 'amount' => $this->shopping_model->getTotalAmount($user_id)));
                    }
                }
            }
        }

        $count = $this->shopping_model->getShoppingInfo($user_id);
        $this->set('items', $count);
        $amount = $this->shopping_model->getTotalAmount($user_id);
        $this->set('amount', $amount);
        $products = $this->shopping_model->getCartDetails($user_id);

        $this->set('products', $products);

        $this->setView();
    }

    function update_cart($id = '', $qty = '') {
        $this->AJAX_STATUS = true;

        /* $id = $this->uri->segment(4); //$this->URL['product_id'];
          $qty = $this->uri->segment(5); //$this->URL['qty']; */
        //echo "ID $id QTY $qty ";
        $details = $this->shopping_model->updateCart($id, $qty);
        echo $details;
    }

    function remove_item($id = '') {

        $result = $this->shopping_model->removeItems($id);
        if ($result) {
            $this->redirect("", "shopping/my_cart", true);
        }
    }

    function remove_all($status = '') {

        if ($status) {
            $result = $this->shopping_model->removeItems("");
            if ($result) {
                $this->redirect("", "shopping/my_cart", true);
            }
        } else {
            echo "<script>alert('error')</script>";
        }
    }

    function update_qty() {
        $this->AJAX_STATUS = true;

        $pdt_id = $this->URL['product_id'];
        $qty = $this->URL['qty'];
        $user_id = $_SESSION['ecom_user_id'];
        $status = $this->Shopping->updateQuantity($pdt_id, $qty, $user_id);
        echo $status;
    }

    function get_next_item() {
        $this->AJAX_STATUS = true;
        $crr_id = $this->URL['next'];
        $cat_id = $this->URL['cat'];
        $next = $this->Shopping->getNextProductId($crr_id, $cat_id);
        $detalis = $this->Shopping->getItemDetails($next, $cat_id);
        echo $detalis;
    }

    function get_previous_item() {
        $this->AJAX_STATUS = true;
        $crr_id = $this->URL['previous'];
        $cat_id = $this->URL['cat'];
        $prev = $this->Shopping->getPreviousProductId($crr_id, $cat_id);
        $detalis = $this->Shopping->getItemDetails($prev, $cat_id);
        echo $detalis;
    }

    public function shipping_address() {

        $title = $this->lang->line("Shipping_Address");
        $this->set('title', $this->COMPANY_NAME . " | $title");

        ////////////////////////
        $this->set("tran_Shipping_Address", $this->lang->line("Shipping_Address"));
        $this->set("tran_submit", $this->lang->line("submit"));
        ////////////////////////
        $user_id = $this->session->userdata('inf_ecom_user_id');
        $count = $this->shopping_model->getShoppingInfo($user_id);
        $this->set('items', $count);
        $amount = $this->shopping_model->getTotalAmount($user_id);
        $this->set('amount', $amount);
        if ($this->input->post('shipping_address_submit')) {
            $this->session->set_userdata('inf_user_shipping_adress', strip_tags($this->input->post('shipping_adress')));
            redirect('shopping/checkout');
        }
        $this->setView('layout/header');

        $this->setView('shopping/shipping_address');
    }

    public function checkout() {
        $this->session->set_userdata("inf_user_checkout", "checkout");
        $msg = '';
        $result = $this->shopping_model->checkout("CreditCard", "new_order");

        if ($result) {
            $ecom_user_id = $this->LOG_USER_ID;
            $msg = $this->lang->line("Your_Order_sent_successfully_please_make_the_payment_as_soon_as_possible");
            $this->redirect("$msg", "shopping/success_page", true);
        } else {
            $msg = $this->lang->line("Error_on_Purchase");
            $this->redirect("$msg", "shopping/my_cart", FALSE);
        }
    }

    public function checkout_order() {
        /*
         * CODE ADDED BY JIJI
         * 
         */
        $this->ARR_SCRIPT[0]["name"] = "shopping.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->load_langauge_scripts();

        $payment_config = $this->Shopping->getPaymentMethodDetails();
        $this->set("payment_config", $payment_config);
        $user_id = $_SESSION['ecom_user_id'];
        $count = $this->Shopping->getShoppingInfo($user_id);
        $this->set('items', $count);
        $amount = $this->Shopping->getTotalAmount($user_id);
        $this->set('amount', $amount);
    }

    public function payment_success() {
        /*
         * CODE ADDED BY JIJI
         * 
         */
        $this->ARR_SCRIPT[0]["name"] = "shopping.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->load_langauge_scripts();
        $pdt_id = $this->URL['product_id'];
        $qty = $this->URL['qty'];
        $user_id = $_SESSION['ecom_user_id'];
        $status = $this->Shopping->updateQuantity($pdt_id, $qty, $user_id);
        $this->set('status', $status);
    }

    function select_payment() {
        $this->set('title', $this->COMPANY_NAME . ' | Select Payment');
        $stat = array();
        $stat = $this->Shopping->getPaymentDetails();
        $count = $this->Shopping->getShoppingInfo($user_id);
        $this->set('items', $count);
        $amount = $this->Shopping->getTotalAmount($user_id);
        $this->set('amount', $amount);
        if ($this->input->post("submit")) {
            $POST = $this->input->post();
            $POST = $this->validation_model->stripTagsPostArray($POST);
            $POST = $this->validation_model->escapeStringPostArray($POST);
            if ($POST["pay"] == "card") {
                //$path = WEB_FOLDER . "shopping/shipping_details";
                //echo "<script>document.location.href='$path'</script>";    
                $path = WEB_FOLDER . "shopping/card_payment";
                header("location:$path");
                //echo "<script>document.location.href='$path'</script>";
            } else if ($POST["pay"] == "bank") {
                $result = $this->Shopping->checkout("Bank", "pending_payment");
                if ($result) {
//this code edited by vaisakh    
                    $msg = $this->lang->line("Your_Order_sent_successfully_please_make_the_payment_as_soon_as_possible");
                    $this->redirect("$msg", "shopping/bank_payment", true);
//vkp ends  
                }
            }
        }
    }

    function card_payment() {
        $title = $this->lang->line("Card_Payment");
        $this->set('title', $this->COMPANY_NAME . " |  $title");
        //vaisakh
        $this->ARR_SCRIPT[0]["name"] = "validate_cardpayment.js";
        $this->ARR_SCRIPT[0]["type"] = "js";

        $this->load_langauge_scripts();
        //vkp ends    
        $path = PATH_TO_ROOT_DOMAIN . "shopping/payment_data_submit";
        $this->set('payment_submit_form', $path);

        $country = $this->country_state_model->viewCountry();
        $this->set("country", $country);

        $purchase_amount = $this->Shopping->getTotalAmount();
        $this->set("purchase_amount", $purchase_amount);
        $this->set("shipping_amount", 0);

        $amount = $this->Shopping->getTotalAmount($user_id);
        $this->set('amount', $amount);

        $count = $this->Shopping->getShoppingInfo($user_id);
        $this->set('items', $count);
    }

    function payment_data_submit() {
        $str = strip_tags($this->input->post("cardnumber"));
        $cnt = strlen($str);
        $POST = $this->input->post();
        $POST = $this->validation_model->stripTagsPostArray($POST);
        $POST = $this->validation_model->escapeStringPostArray($POST);
        if ($cnt == 16) {
            $myorder["host"] = "secure.linkpt.net";
            $myorder["port"] = "1129"; //connection port
            $myorder["keyfile"] = realpath("1224190.pem"); //key file
            $myorder["configfile"] = "1224190"; //store number
            //$myorder["result"] = "LIVE";//Live is a live sale
            $myorder["result"] = "GOOD"; //Good is a test resulting in a successful transaction
            $myorder["ordertype"] = "SALE"; //This is default to sale
            //Sale information
            $myorder["transactionorigin"] = "ECI"; //Deafult transaction origin
            $myorder["oid"] = date("Ymd-hm") . "-" . rand(1, 999); //Order ID
            $myorder["ponumber"] = "p" . date("Ymd-hm") . "-" . rand(1, 999); //Product order number
            $myorder["taxexempt"] = "NO"; //Tax exemption
            $myorder["terminaltype"] = "UNSPECIFIED"; //The terminal type
            $myorder["ip"] = $POST["ip"]; //The ip of the transaction machine
            //Sale details
            $myorder["subtotal"] = $POST["subtotal"]; //Subtotal
            $myorder["tax"] = $POST["tax"]; //TAX
            $myorder["shipping"] = $POST["shipping"]; //Shipping
            $myorder["vattax"] = "0.00"; //Value Added Tax
            $myorder["chargetotal"] = $POST["chargetotal"]; //Charge Total sale
            //Card details
            $myorder["cardnumber"] = $POST["cardnumber"];
            $myorder["cardexpmonth"] = $POST["cardexpmonth"];
            $myorder["cardexpyear"] = $POST["cardexpyear"];
            $myorder["cvmindicator"] = "provided";
            $myorder["cvmvalue"] = $POST["cvmvalue"];

            //Affiliate information
            $myorder["name"] = $POST["name"];
            $myorder["address1"] = $POST["address1"];
            $myorder["address2"] = $POST["address2"];
            $myorder["city"] = $POST["city"];
            $myorder["state"] = $POST["state"];
            $myorder["country"] = $POST["country"];
            $myorder["phone"] = $POST["phone"];
            $myorder["email"] = $POST["email"];
            $myorder["addrnum"] = $POST["addrnum"];
            $myorder["zip"] = $POST["zip"];

            //Shipping information
            $myorder["sname"] = $POST["sname"];
            $myorder["saddress1"] = $POST["saddress1"];
            $myorder["saddress2"] = $POST["saddress2"];
            $myorder["scity"] = $POST["scity"];
            $myorder["sstate"] = $POST["sstate"];
            $myorder["szip"] = $POST["szip"];
            $myorder["scountry"] = $POST["scountry"];
            $myorder["comments"] = $POST["comments"];

            //Debugging (output on result)
            $myorder["debugging"] = "false";
            $myorder["debug"] = "false";
            $_SESSION['myorder'] = $myorder;
            $result = $this->Shopping->processCurlPayemnt($myorder);
            $json_data = json_decode($result, true);

            if ($json_data["r_approved"] == "APPROVED") {
                $res = $this->Shopping->checkout("CreditCard", "new_order");
                if ($res) {
                    $invoice_no = $this->session->userdata("inf_invoice_no");
                    $this->Shopping->insertPaymentDetails($_SESSION["fields"], $_SESSION['ino']);
                    $this->redirect("The transaction completed Sucsessfully.....", "shopping/success_page/inv_no:$invoice_no", true);
                } else {
                    $this->redirect("The transaction Failed!", "shopping/card_payment", false);
                }
            } else {
                $this->redirect("The transaction Failed!" + $json_data["r_error"], "shopping/card_payment", false);
            }
        } else {
            $this->redirect('Sorry! Transaction failed due to invalid card number entry!', 'shopping/card_payment', false);
        }
    }

    function success_page() {
        //$_SESSION['invoice_no'] = $this->URL['inv_no'];
        $this->redirect("The transaction completed Sucsessfully.....", "shopping/shipping_details", true);
    }

    function bank_payment() {
        $this->set('title', $this->COMPANY_NAME . ' | Bank Payment');
        $res = $this->Shopping->getBankDetails();
        $this->set('bankname', $res['pos_payment_config_bank_name']);
        $this->set('branch', $res['pos_payment_config_branch_name']);
        $this->set('accno', $res['pos_payment_config_acc_no']);
        $this->set('acctype', $res['pos_payment_config_acc_type']);
        $this->set('ifsccode', $res['pos_payment_config_ifsc_code']);
        $this->set('configname', $res['pos_payment_config_name']);
        $this->set('paymode', $res['pos_payment_config_payment_mode']);

        /* $amount = $this->Shopping->getTotalAmount($user_id);
          $this->set('amount', $amount);
          $count = $this->Shopping->getShoppingInfo($user_id);
          $this->set('items', $count); */
    }

    function shipping_details() {

        $title = $this->lang->line('Shipping_Details');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[0]["name"] = "layout_ecom.css";
        $this->ARR_SCRIPT[0]["type"] = "css";
        $this->load_langauge_scripts();

        $invoice_no = $this->session->userdata("inf_user_invoice_no");
        // echo "innnnn>>" . $invoice_no=13;
        $purchase_details = $this->shopping_model->getPurchaseDetails($invoice_no);

        $this->set('purchase_details', $purchase_details);
        $user_id = $this->session->userdata('inf_ecom_aff_id');
        $this->set('invoice_no', $invoice_no);

        $this->session->unset_userdata("inf_user_cart");
        $this->session->unset_userdata("inf_user_shipping_address");
        $this->session->unset_userdata("inf_user_invoice_no");


        $count = $this->shopping_model->getShoppingInfo("");
        $this->set('items', $count);
        $amount = $this->shopping_model->getTotalAmount("");
        $this->set('amount', $amount);

        $this->set("tran_Shipping_Details", $this->lang->line('Shipping_Details'));
        $this->set("tran_SHIP_TO", $this->lang->line('SHIP_TO'));
        $this->set("tran_Invoice_No", $this->lang->line('Invoice_No'));
        $this->set("tran_Date_Ordered", $this->lang->line('Date_Ordered'));
        $this->set("tran_Payment_method", $this->lang->line('Payment_method'));
        $this->set("tran_Credit_Card", $this->lang->line('Credit_Card'));
        $this->set("tran_product", $this->lang->line('product'));
        $this->set("tran_Quantity", $this->lang->line('Quantity'));
        $this->set("tran_Price", $this->lang->line('Price'));
        $this->set("tran_Shipping_Price", $this->lang->line('Shipping_Price'));
        $this->set("tran_total", $this->lang->line('total'));
        $this->set("tran_total_amount", $this->lang->line('total_amount'));
        $this->set("tran_Date_Added", $this->lang->line('Date_Added'));
        $this->set("tran_status", $this->lang->line('status'));
        $this->set("tran_comments", $this->lang->line('comments'));
        $this->set("tran_Processing", $this->lang->line('Processing'));
        $this->set("tran_English", $this->lang->line('English'));

        $this->setView('layout/header');

        $this->setView('shopping/shipping_details');
    }

    function get_shipping_amount() {
        $this->AJAX_STATUS = true;
        $country_code = $this->URL['country'];
        $country = $this->Shopping->obj_vali->getCountryId($country_code);
        $country_id = $country["country_id"];
        $this->Shopping->getShippingAmount($country_id);
        $shipping_amount = $this->Shopping->getTotalShippingAmount();
        echo $shipping_amount;
    }

    function personal_details() {
        $this->ARR_SCRIPT[0]["name"] = "validate_cardpayment.js";
        $this->ARR_SCRIPT[0]["type"] = "js";
        $this->load_langauge_scripts();
        $this->set('title', $this->COMPANY_NAME . ' | Personal Details');
        $count = $this->Shopping->getShoppingInfo($user_id);
        $this->set('items', $count);
        $amount = $this->Shopping->getTotalAmount($user_id);
        $this->set('amount', $amount);
        $products = $this->Shopping->getCartDetails($user_id);
        $this->set('products', $products);
        $country = $this->country_state_model->viewCountry();
        $this->set("country", $country);
        if ($this->input->post("submit_bt")) {
            $POST = $this->input->post();
            $POST = $this->validation_model->stripTagsPostArray($POST);
            $POST = $this->validation_model->escapeStringPostArray($POST);
            $regr['name'] = $POST['name'];
            $regr['last_name'] = $POST['last_name'];
            $regr['address'] = $POST['address'];
            $regr['city'] = $POST['city'];
            $regr['state'] = $POST['state'];
            $regr['pincode'] = $POST['pincode'];
            $regr['country'] = $POST['country'];
            $regr['phone'] = $POST['phone'];
            $regr['land_line'] = $POST['land_line'];
            $regr['email'] = $POST['email'];

            $regr['shipping_name'] = $POST['shipping_name'];
            $regr['shipping_last_name'] = $POST['shipping_last_name'];
            $regr['shipping_address'] = $POST['shipping_address'];
            $regr['shipping_city'] = $POST['shipping_city'];
            $regr['shipping_state'] = $POST['shipping_state'];
            $regr['shipping_pincode'] = $POST['shipping_pincode'];
            $regr['shipping_country'] = $POST['shipping_country'];
            $regr['shipping_phone'] = $POST['shipping_phone'];
            $regr['shipping_land_line'] = $POST['shipping_land_line'];
            $regr['shipping_email'] = $POST['shipping_email'];

            $_SESSION['shipping'] = $regr;
            header("Location:checkout");
        }
    }

}

?>
