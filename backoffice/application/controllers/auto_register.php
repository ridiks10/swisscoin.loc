<?php

require_once 'user/Inf_Controller.php';

/**
 * @property-read product_model $product_model 
 * @property-read register_model $register_model 
 */
class Auto_Register extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('configuration_model', '', TRUE);
        $this->lang->load('register', $this->LANG_NAME);
    }

    function user_register($placement_id_encrypted = "", $position = "") {

        $sponsor_user_name = $this->LOG_USER_NAME;
        $user_id = $this->LOG_USER_ID;

        $reg_from_tree = 0;
        $placement_id = '';
        $placement_user_name = '';
        $placement_full_name = '';
        if ($placement_id_encrypted != '') {
            $reg_from_tree = 1;
            $placement_id_decoded = urldecode($placement_id_encrypted);
            $placement_id_replaced = str_replace("_", "/", $placement_id_decoded);
            $placement_id = $this->encrypt->decode($placement_id_replaced);
            if (!$this->validation_model->idToUserName($placement_id)) {
                $this->redirect("Invalid Placement", "tree/genology_tree", FALSE);
            } else {
                $placement_user_name = $this->validation_model->IdToUserName($placement_id);
                $placement_full_name = $this->validation_model->getFullName($placement_id);
            }
        } else {
            $placement_user_name = $this->validation_model->IdToUserName($user_id);
            $placement_full_name = $this->validation_model->getFullName($user_id);
        }
        if ($this->MODULE_STATUS['opencart_status_demo'] == "yes" || $this->MODULE_STATUS['opencart_status'] == "yes") {
            $this->session->set_userdata("inf_placement_array", array("reg_from_tree" => $reg_from_tree, "placement_user_name" => $placement_user_name, "placement_full_name" => $placement_full_name, "position" => $position, "mlm_plan" => $this->MLM_PLAN));
            $table_prefix = str_replace("_", "", $this->table_prefix);
            $store_path = "../store/index.php?route=account/register&id=" . $table_prefix;
            $this->redirect("", $store_path);
        }

        $title = lang('new_user_signup');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('new_user_signup');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $countries = $this->country_state_model->viewCountry();
        $states = '';
        $products = '';
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $products = $this->register_model->viewProducts();
        }

        $reg_post_array = array();
        $reg_count = 0;
        $pin_count = 0;
        if ($this->session->userdata("inf_reg_post_array")) {
            $reg_post_array = $this->session->userdata("inf_reg_post_array");
            $reg_from_tree = $reg_post_array['reg_from_tree'];
            $pin_count = $reg_post_array['pin_count'];
            $sponsor_user_name = $reg_post_array['sponsor_user_name'];
            $placement_user_name = $reg_post_array['placement_user_name'];
            $placement_full_name = $reg_post_array['placement_full_name'];
            $reg_count = count($this->session->userdata("inf_reg_post_array"));
            $countries = $this->country_state_model->viewCountry($reg_post_array['country']);
            $states = $this->country_state_model->viewState($reg_post_array['country'], $reg_post_array['state']);
            if ($this->MODULE_STATUS['product_status'] == "yes") {
                $products = $this->register_model->viewProducts($reg_post_array['product_id']);
            }
            $this->session->unset_userdata("inf_reg_post_array");
        }

        $is_product_added = "";
        if ($this->MODULE_STATUS['product_status'] == "yes") {
            $is_product_added = $this->register_model->isProductAdded();
        }

        $is_pin_added = "";
        if ($this->MODULE_STATUS['pin_status'] == "yes") {
            $is_pin_added = $this->register_model->isPinAdded();
        }

        if ($this->session->userdata('inf_error')) {
            $error = $this->session->userdata('inf_error');
            $this->set('error', $error);
            $this->session->unset_userdata('inf_error');
        }

        $payment_methods_tab = false;
        $payment_gateway_array = array();
        $payment_module_status_array = array();
        $registration_fee = $this->register_model->getRegisterAmount();
        if ($registration_fee || $this->MODULE_STATUS ['product_status'] == 'yes') {
            $payment_methods_tab = TRUE;
            $payment_gateway_array = $this->register_model->getPaymentGatewayStatus();
            $payment_module_status_array = $this->register_model->getPaymentModuleStatus();
        }

        $termsconditions = $this->register_model->getTermsConditions($this->LANG_ID);
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $this->set('reg_from_tree', $reg_from_tree);
        $this->set('pin_count', $pin_count);
        $this->set('reg_post_array', $reg_post_array);
        $this->set('reg_count', $reg_count);
        $this->set("sponsor_user_name", $sponsor_user_name);
        $this->set("user_id", $user_id);
        $this->set('position', $position);
        $this->set("placement_full_name", $placement_full_name);
        $this->set("placement_user_name", $placement_user_name);
        $this->set('user_name_type', $user_name_type);
        $this->set('payment_methods_tab', $payment_methods_tab);
        $this->set('payment_gateway_array', $payment_gateway_array);
        $this->set('payment_module_status_array', $payment_module_status_array);
        $this->set("registration_fee", $registration_fee);
        $this->set('termsconditions', $termsconditions);
        $this->set('countries', $countries);
        $this->set("states", $states);
        $this->set("products", $products);
        $this->set("is_pin_added", $is_pin_added);
        $this->set('is_product_added', $is_product_added);

        $this->setView();
    }

    function register_submit() {
        $regr = array();

        $reg_post_array = $this->input->post();
        $this->session->set_userdata('inf_reg_post_array', $reg_post_array);

        if ($this->validate_register_submit()) {

            $payment_status = false;
            $payment_type = 'free_join';

            $module_status = $this->MODULE_STATUS;
            $product_status = $this->MODULE_STATUS['product_status'];
            $username_config = $this->configuration_model->getUsernameConfig();

            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            $reg_post_array = $this->validation_model->escapeStringPostArray($reg_post_array);

            $user_count = $reg_post_array['user_count'];

            if (is_numeric($user_count) && $user_count > 0) {

                for ($i = 0; $i < $user_count; $i++) {

                    $reg_from_tree = $reg_post_array['reg_from_tree'];
                    $active_tab = $reg_post_array['active_tab'];

                    $regr = $reg_post_array;

                    $regr['position'] = "";

                    if ($this->LOG_USER_TYPE != "admin" && $this->LOG_USER_TYPE != "employee") {
                        $regr['placement_user_name'] = $regr["sponsor_user_name"] = $this->LOG_USER_NAME;
                        $regr['placement_full_name'] = $regr["sponsor_full_name"] = $this->validation_model->getUserFullName($this->LOG_USER_ID);
                    }

                    if ($this->MLM_PLAN == "Binary") {
                        $regr['position'] = $reg_post_array["position"];
                    } elseif ($this->MLM_PLAN == "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["sponsor_full_name"];
                    }

                    if ($reg_from_tree && $this->MLM_PLAN != "Unilevel") {
                        $regr['placement_user_name'] = $reg_post_array["placement_user_name"];
                        $regr['placement_full_name'] = $reg_post_array["placement_full_name"];
                        $regr['position'] = $regr["position"];
                    }

                    $regr['reg_amount'] = $this->register_model->getRegisterAmount();

                    $product_id = 0;
                    $product_name = 'NA';
                    $product_pv = '0';
                    $product_amount = '0';
                    if ($product_status == "yes") {
                        $product_id = $reg_post_array['product_id'];
                        $this->load->model('product_model');
                        $product_details = $this->product_model->getProductDetails($product_id, 'yes');
                        $product_name = $product_details[0]['product_name'];
                        $product_pv = $product_details[0]['pair_value'];
                        $product_amount = $product_details[0]['product_value'];
                    }
                    $regr['product_status'] = $product_status;
                    $regr['product_id'] = $product_id;
                    $regr['product_name'] = $product_name;
                    $regr['product_pv'] = $product_pv;
                    $regr['product_amount'] = $product_amount;
                    $regr['total_amount'] = $regr['reg_amount'] + $regr['product_amount'];

                    $regr['country_name'] = $this->country_state_model->getCountryNameFromID($regr['country']);
                    $regr['state_name'] = $this->country_state_model->getStateNameFromId($regr['state']);

                    $regr['user_name_type'] = $username_config["type"];
                    $regr['user_name_entry'] = $reg_post_array['user_name_entry'] . (($i > 0) ? $i : '');
                    $regr['joining_date'] = date('Y-m-d H:i:s');
                    $regr['active_tab'] = $active_tab;
                    $regr['reg_from_tree'] = $reg_from_tree;

                    $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                    $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
                    $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);

                    $regr['payment_type'] = $payment_type;
                    $regr['by_using'] = 'free join';
                    $this->register_model->begin();
                    $status = $this->register_model->confirmRegister($regr, $module_status);
                    if ($status['status']) {
                        $payment_status = true;
                    }

                    $msg = '';
                    if ($payment_status) {
                        $user = $status['user'];
                        $pass = $status['pwd'];
                        $encr_id = $status['id'];
                        $tran_code = $status['tran'];

                        if ($product_status == "yes") {
                            $user_id = $this->validation_model->userNameToID($user);
                            $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_type);
                        }
                        $this->register_model->commit();
                    } else {
                        $this->register_model->rollback();
                        $msg = lang('registration_failed') . "$i";
                        $this->redirect($msg, 'auto_register/user_register', false);
                    }
                }
                $this->redirect("Registration successful", "auto_register/user_register", true);
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('inf_error', $error);

                $msg = "Enter a valid count";
                $this->redirect($msg, "auto_register/user_register", FALSE);
            }
        } else {
            $error = $this->form_validation->error_array();
            $this->session->set_userdata('inf_error', $error);

            $msg = $this->lang->line('errors_check');
            $this->redirect($msg, "auto_register/user_register", FALSE);
        }
    }

    public function validate_register_submit() {
        $product_status = $this->MODULE_STATUS['product_status'];
        $username_config = $this->configuration_model->getUsernameConfig();
        $user_name_type = $username_config["type"];

        $active_tab = $this->input->post('active_tab');
        $reg_from_tree = $this->input->post('reg_from_tree');
        $pin_count = $this->input->post('pin_count');

        if ($reg_from_tree) {
            $this->form_validation->set_rules('placement_user_name', 'Placement Username', 'required|callback_validate_username|trim');
            $this->form_validation->set_rules('placement_full_name', 'Placement FullName', 'required|trim');
        }
        $this->form_validation->set_rules('sponsor_user_name', 'Sponsor Username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('sponsor_full_name', 'Sponsor FullName', 'required|trim');

        if ($this->MLM_PLAN == 'Binary') {
            $this->form_validation->set_rules('position', 'Position', 'trim|required');
        }

        if ($product_status == "yes") {
            $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        }

        if ($user_name_type == 'static') {
            $this->form_validation->set_rules('user_name_entry', 'User Name', 'trim|required|alpha_numeric|min_length[6]|callback_check_username_availability');
        }
        $this->form_validation->set_rules('pswd', 'Password', 'trim|required|alpha_dash|matches[cpswd]|min_length[6]');
        $this->form_validation->set_rules('cpswd', 'Confirm Password', 'trim|required|alpha_dash');

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|callback__alpha_dash_space');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|callback__alpha_dash_space');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('year', 'Date of Borth', 'trim|required');
        $this->form_validation->set_rules('month', 'Date of Borth', 'trim|required');
        $this->form_validation->set_rules('day', 'Date of Borth', 'trim|required');
        $this->form_validation->set_rules('address', 'Address Line 1', 'required');
        $this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($active_tab == "credit_card_tab") {
            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|numeric');
            $this->form_validation->set_rules('credit_currency', 'Credit currency', 'trim|required');
            $this->form_validation->set_rules('credit_card_type', 'Credit Card Type', 'trim|required');
            $this->form_validation->set_rules('card_cvn', 'CVN number', 'trim|required|numeric');
            $this->form_validation->set_rules('card_expiry_date', 'Credit card expiry date', 'trim|required');
            $this->form_validation->set_rules('bill_to_forename', 'Account Holder First name', 'trim|required');
            $this->form_validation->set_rules('bill_to_surname', 'Account Holder Last name', 'trim|required');
            $this->form_validation->set_rules('bill_to_email', 'Account Holder Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('bill_to_phone', 'Account Holder Phone number', 'trim|required|numeric');
        }
        if ($active_tab == 'epin_tab') {
            $temp_pin_array = "";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            for ($i = 1; $i <= $pin_count; $i++) {
                if ($this->input->post("epin$i")) {
                    $this->form_validation->set_rules("epin$i", "Epin$i ", " trim|required|callback_has_match");
                }
            }
            $this->session->unset_userdata("inf_temp_pin_array");
        }
        if ($active_tab == 'ewallet_tab') {
            $this->form_validation->set_rules('user_name_ewallet', 'Ewallet User Nmae', 'trim|required');
            $this->form_validation->set_rules('tran_pass_ewallet', 'Transaction Password', 'trim|required');
        }

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('exact_length', 'The %s field must be exactly 10 digit.');
        $this->form_validation->set_message('validate_username', 'The Sponsor Username is Not Available');
        $this->form_validation->set_message('check_username_availability', 'The Username is Not Available');

        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", "</div>");

        $validation_status = $this->form_validation->run();

        return $validation_status;
    }

    function validate_username($ref_user = '') {
        if ($ref_user != '') {
            $flag = false;
            if ($this->register_model->isUserAvailable($ref_user)) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $echo = 'no';
            $username = $this->input->post('username');
            if ($this->register_model->isUserAvailable($username)) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }

    function check_leg_availability() {
        $echo = 'no';
        if ($this->input->post('sponsor_leg') && $this->input->post('sponsor_user_name')) {
            if ($this->register_model->checkLeg($this->input->post('sponsor_leg'), $this->input->post('sponsor_user_name'), $this->MLM_PLAN)) {
                $echo = "yes";
            }
        }
        echo $echo;
        exit();
    }

    function get_sponsor_full_name() {
        $username = $this->input->post('sponsor_user_name');
        $user_id = $this->validation_model->userNameToID($username);
        $referral_name = $this->register_model->getReferralName($user_id);
        echo $referral_name;
        exit();
    }

    function get_total_registration_fee() {
        $product_id = $this->input->post('product_id');
        $product_amount = 0;
        if ($product_id) {
            $product_amount = $this->register_model->getProductAmount($product_id);
        }
        $registration_fee = $this->register_model->getRegisterAmount();
        $total_fee = $product_amount + $registration_fee;
        echo "$registration_fee==$product_amount==$total_fee";
        exit();
    }

    function checkPassAvailability() {

        if ($this->register_model->checkPassCode($this->input->post('prodcutpin'), $this->input->post('prodcutid'))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    function checkSponsorAvailability() {

        if ($this->register_model->checkSponser($this->input->post('sponser_name'), $this->input->post('user_id'))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    function check_username_availability($user = '') {
        if ($user != '') {
            $flag = false;
            if (!$this->register_model->isUserAvailable($user)) {
                $flag = TRUE;
            }
            return $flag;
        } else {
            $echo = 'no';
            if ($this->register_model->checkUser($this->input->post('user_name'))) {
                $echo = "yes";
            }
            echo $echo;
            exit();
        }
    }

    function get_states($country_id) {
        $state_select = '';

        $state_string = $this->country_state_model->viewState($country_id);
        if ($state_string != '') {
            $state_select.="<option value =''>" . $this->lang->line('select_state') . "</option>";
            $state_select.=$state_string;
        } else {
            $state_select.="<option value='0'>--No data Available--</option>";
        }
        $state_select .= '</select></div>';
        echo $state_select;
        exit();
    }

    function get_phone_code($country_id) {
        $country_telephone_code = $this->country_state_model->getCountryTelephoneCode($country_id);
        echo "+$country_telephone_code";
    }

    function epin_submited() {
        $input = file_get_contents('php://input');

        $jsonData = json_decode($input, TRUE);
        $pin_details = Array();

        foreach ($jsonData as $key => $value) {
            $pin_details = $value;
        }
        $pin_number = array();
        $arr_length = count($pin_details);

        for ($i = 0; $i < $arr_length; $i++) {

            $pin_number[$i]['pin'] = ($pin_details[$i]['used_pin']);
            $pin_number[$i]['bal_amount'] = ($pin_details[$i]['bal_amount']);
            $pin_number[$i]['pin_ok'] = ($pin_details[$i]['pin_ok']);
            $pin_number[$i]['pin_amount'] = ($pin_details[$i]['pin_amount']);

            if ($pin_number[$i]['pin_ok'] == 1) {
                echo 1;
            }
        }
    }

    public function pay_now() {
        $regr = $this->session->userdata["inf_regr"];
        $product_status = $regr["product_status"];
        $product_name = $regr["product_name"];
        $product_amount = $regr["product_amount"];
        $reg_amount = $regr["reg_amount"];

        $total_amount = $product_amount + $reg_amount;
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();

        $this->load->library('merchant');
        $this->merchant->load('paypal_express');

        $description = "New Membership to " . $this->COMPANY_NAME;
        $description .= "\nMembership Fee : $reg_amount";
        if ($product_status == "yes") {
            $description .= ", $product_name : $product_amount";
        }
        $mode = FALSE;
        if ($paypal_details['mode'] == 'test') {
            $mode = TRUE;
        }
        $settings = array(
            'username' => $paypal_details['api_username'],
            'password' => $paypal_details['api_password'],
            'signature' => $paypal_details['api_signature'],
            'test_mode' => $mode);
        $this->merchant->initialize($settings);

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'item' => "New Membership",
            'description' => $description,
            'currency' => $paypal_details['currency'],
            'return_url' => $base_url . $paypal_details ['return_url'],
            'cancel_url' => $base_url . $paypal_details ['cancel_url']
        );

        $response = $this->merchant->purchase($params);
    }

    public function payment_success() {

        $p_id = $this->session->userdata["inf_regr"]["product_id"];
        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $total_amount = $product_amount + $register_amount;
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $this->load->library('merchant');
        $this->merchant->load('paypal_express');

        $mode = FALSE;
        if ($paypal_details['mode'] == 'test') {
            $mode = TRUE;
        }

        $settings = array(
            'username' => $paypal_details['api_username'],
            'password' => $paypal_details['api_password'],
            'signature' => $paypal_details['api_signature'],
            'test_mode' => $mode);
        $this->merchant->initialize($settings);

        $base_url = base_url();
        $params = array(
            'amount' => $total_amount,
            'currency' => $paypal_details['currency'],
            'return_url' => $base_url . $paypal_details ['return_url'],
            'cancel_url' => $base_url . $paypal_details ['cancel_url']
        );

        $response = $this->merchant->purchase_return($params);
        if ($response->success()) {
            $paypal_output = $this->input->get();
            $regr = $this->session->userdata('inf_regr');
            $referral_id = $regr["sponsor_id"];
            $payment_details = array(
                'payment_method' => 'paypal',
                'token_id' => $paypal_output['token'],
                'currency' => $paypal_details['currency'],
                'amount' => $total_amount,
                'acceptance' => '',
                'payer_id' => $paypal_output['PayerID'],
                'user_id' => $referral_id,
                'status' => '',
                'card_number' => '',
                'ED' => '',
                'card_holder_name' => '',
                'submit_date' => date("Y-m-d H:i:s"),
                'pay_id' => '',
                'error_status' => '',
                'brand' => '');

            $this->register_model->insertintoPaymentDetails($payment_details);
            $module_status = $this->MODULE_STATUS;
            $regr['by_using'] = 'paypal';

            $this->register_model->begin();
            $status = $this->register_model->confirmRegister($regr, $module_status);

            $msg = '';
            if ($status['status']) {
                $this->register_model->commit();
                $user = $status['user'];
                $pass = $status['pwd'];
                $tran_code = $status['tran'];

                $product_status = $this->MODULE_STATUS['product_status'];
                $payment_method = "paypal";
                if ($product_status == "yes") {
                    $user_id = $this->validation_model->userNameToID($user);
                    $insert_into_sales = $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method);
                }

                $id_encode = $this->encrypt->encode($user);
                $id_encode = str_replace("/", "_", $id_encode);
                $user1 = urlencode($id_encode);

                $this->session->unset_userdata('inf_regr');
                $this->session->unset_userdata('inf_reg_post_array');
                $msg = lang('registration_completed_successfully');
                $this->redirect("<span><b>$msg!</b>  Username : $user &nbsp;&nbsp; Password : $pass &nbsp; Transaction Password : $tran_code</span>", "auto_register/preview/" . $user1, true);
            } else {
                $this->register_model->rollback();
                $msg = lang('registration_failed');
                $this->redirect($msg, 'tree/select_tree', false);
            }
        } else {
            $msg = 'Payment Failed';
            $this->redirect($msg, 'tree/select_tree', false);
        }
    }

    function preview($user_name = "", $pass = "", $id = "") {

        $title = lang('letter_preview');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "register_downline";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('letter_preview');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $userid = urldecode($user_name);
        $id_decode = str_replace("_", "/", $userid);
        $user_name = $this->encrypt->decode($id_decode);
        $user_id = $this->validation_model->userNameToID($user_name);
        if (!$user_id) {
            $this->redirect("Invalid User Details.", "home", FALSE);
        }

        $session_data = $this->session->userdata('inf_logged_in');
        $user_type = $this->LOG_USER_TYPE;
        if ($this->MODULE_STATUS['footer_demo_status'] == "yes") {
            $admin_user_name = $session_data['admin_user_name'];
            $this->set("admin_user_name", $admin_user_name);
        }
        if ($user_type != "admin") {
            $user_type = 'user';
        }

        $date = date('Y-m-d H:i:s');
        $lang_id = $this->LANG_ID;
        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $product_status = $this->MODULE_STATUS['product_status'];
        $referal_status = $this->MODULE_STATUS['referal_status'];

        $father_id = $this->validation_model->getFatherId($user_id);
        $product_id = $this->validation_model->getProductId($user_id);
        $reg_amount = $this->register_model->getRegisterAmount();
        if ($product_status == "yes") {
            $product_details = $this->register_model->getProduct($product_id);
            $this->set("product_details", $product_details);
            $this->set("product_status", $product_status);
        }
        $user_registration_details = $this->register_model->getUserRegistrationDetails($user_id);

        $user_details = $this->register_model->getUserDetails($user_id);
        $user_details['user_details_ref_user_id'] = $this->validation_model->getSponsorId($user_id);

        $user_details_ref_user_id = $user_details['user_details_ref_user_id'];
        if ($referal_status == "yes") {
            $sponsorname = $this->validation_model->IdToUserName($user_details_ref_user_id);
            $this->set("sponsorname", $sponsorname);
            $this->set("referal_status", $referal_status);
        }
        $adjusted_id = $this->validation_model->IdToUserName($father_id);

        $this->set("date", $date);
        $this->set("pass", $pass);
        $this->set("id", $id);
        $this->set("user_name", $user_name);
        $this->set("user_type", $user_type);
        $this->set("letter_arr", $letter_arr);
        $this->set("reg_amount", $reg_amount);
        $this->set("product_status", $product_status);
        $this->set("adjusted_id", $adjusted_id);
        $this->set("referal_status", $referal_status);
        $this->set("user_details", $user_details);
        $this->set("user_registration_details", $user_registration_details);

        $this->setView();
    }

    function validate_pswd($password) {
        if (!preg_match('/^[a-z0-9A-Z_~\-!@#\$%\^&\*\(\)?,.:<>|\\+\/\[\]{}\'";`~]*$/', $password)) {
            return false;
        } else
            return true;
    }

    public function check_epin_validity() {
        $input = file_get_contents('php://input');
        $jsonData = json_decode($input, TRUE);
        $product_id = $jsonData['product_id'];
        $pin_details = $jsonData['pin_array'];
        $product_status = $this->MODULE_STATUS["product_status"];
        $pin_array = $this->register_model->checkAllEpins($pin_details, $product_id, $product_status);
        $value = json_encode($pin_array);
        echo $value;
        exit();
    }

    public function getProductAmount() {
        $pin = $this->input->post('product_id');
        $res = $this->register_model->getProductAmount($pin);
        if ($res) {
            echo $res;
            exit();
        } else {
            echo "no";
            exit();
        }
    }

    public function checkBalanceAvailable() {
        $ewallet_user = $this->input->post('user_name');
        $balance = $this->input->post('balance');
        $user_name_ewallet = $this->validation_model->userNameToID($ewallet_user);
        $user_bal_amount = $this->register_model->getBalanceAmount($user_name_ewallet, $balance);
        echo $user_bal_amount;
    }

    public function check_ewallet_balance() {
        $status = "no";
        $ewallet_user = $this->input->post('user_name');
        $ewallet_pass = $this->input->post('ewallet');
        $product_id = $this->input->post('product_id');

        $user_id = $this->validation_model->userNameToID($ewallet_user);
        if ($user_id) {
            $user_password = $this->register_model->checkEwalletPassword($user_id, $ewallet_pass);
            if ($user_password == 'yes') {
                $user_bal_amount = $this->register_model->getBalanceAmount($user_id);
                if ($user_bal_amount > 0) {
                    $reg_amount = $this->register_model->getRegisterAmount();
                    $product_amount = 0;
                    $product_status = $this->MODULE_STATUS['product_status'];
                    if ($product_status == "yes") {
                        $product_details = $this->register_model->getProduct($product_id);
                        $product_amount = $product_details["product_value"];
                    }
                    $total_amount = $reg_amount + $product_amount;

                    if ($user_bal_amount >= $total_amount) {
                        $status = "yes";
                    }
                }
            }
        } else {
            $status = "invalid";
        }
        echo $status;
        exit();
    }

    public function getRegisterAmount() {
        $res = $this->register_model->getRegisterAmount();
        echo $res;
    }

    public function epdqPayment() {
        $regr = $this->session->userdata["inf_regr"];

        $product_amount = $regr['product_amount'];
        $register_amount = $regr['reg_amount'];
        $total_amount = $product_amount + $register_amount;
        $epdq_details = $this->configuration_model->getEpdqConfigDetails();
        $fullname = $regr['first_name'] . " " . $regr['last_name'];
        $order_id = $this->register_model->generateOrderid($fullname, 'user_register');

        if (!$order_id) {
            echo "<script> alert('error on registration')</script>";
            $this->redirect('', 'auto_register/user_register');
        }
        $base_url = base_url();
        $sha_array = array(
            'AMOUNT' => $total_amount * 100,
            'CURRENCY' => $epdq_details['api_currency'],
            'LANGUAGE' => $epdq_details['api_language'],
            'ORDERID' => $order_id,
            'PSPID' => $epdq_details['api_pspid'],
            'ACCEPTURL' => $base_url . $epdq_details ['accept_url'],
            'DECLINEURL' => $base_url . $epdq_details ['decline_url'],
            'EXCEPTIONURL' => $base_url . $epdq_details ['exception_url'],
            'CANCELURL' => $base_url . $epdq_details ['cancel_url']
        );

        $pass = $epdq_details['api_password'];
        ksort($sha_array);
        $string_to_hash = '';
        foreach ($sha_array as $key => $val) {

            $string_to_hash.=sprintf("%s=%s%s", $key, $val, $pass);
        }
        $sha_sign = sha1($string_to_hash);

        strtoupper($sha_sign);

        $curl = curl_init();
        $order_details["PSPID"] = $epdq_details['api_pspid'];
        $order_details["ORDERID"] = $order_id;
        $order_details["AMOUNT"] = $total_amount * 100;
        $order_details["CURRENCY"] = $epdq_details['api_currency'];
        $order_details["LANGUAGE"] = $epdq_details['api_language'];
        $order_details["SHASIGN"] = $sha_sign;
        $order_details["ACCEPTURL"] = $base_url . $epdq_details ['accept_url'];
        $order_details["DECLINEURL"] = $base_url . $epdq_details ['decline_url'];
        $order_details["EXCEPTIONURL"] = $base_url . $epdq_details ['exception_url'];
        $order_details["CANCELURL"] = $base_url . $epdq_details ['cancel_url'];

        $url = $epdq_details['api_url'];
        curl_setopt($curl, CURLOPT_URL, $url);
        $field_string = http_build_query($order_details);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $field_string);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
    }

    public function edpqPaymentSuccess() {

        $detail_array = $this->input->get();
        $regr = $this->session->userdata("inf_regr");
        $referral_id = $regr["sponsor_id"];
        $payment_details = array(
            'payment_method' => 'epdq',
            'token_id' => $detail_array['orderID'],
            'currency' => $detail_array['currency'],
            'amount' => $detail_array['amount'],
            'acceptance' => $detail_array['ACCEPTANCE'],
            'payer_id' => "",
            'user_id' => $referral_id,
            'status' => $detail_array['STATUS'],
            'card_number' => $detail_array['CARDNO'],
            'ED' => $detail_array['ED'],
            'card_holder_name' => $detail_array['CN'],
            'submit_date' => date("Y-m-d H:i:s"),
            'pay_id' => $detail_array['PAYID'],
            'error_status' => $detail_array['ED'],
            'brand' => $detail_array['BRAND']);

        $this->register_model->insertintoPaymentDetails($payment_details);
        if ($detail_array['STATUS'] == 9) {
            $module_status = $this->MODULE_STATUS;
            $regr['by_using'] = 'epdq';

            $this->register_model->begin();
            $status = $this->register_model->confirmRegister($regr, $module_status);
            $user = $status['user'];
            $pass = $status['pwd'];
            $tran_code = $status['tran'];
            $msg = '';
            if ($status['status']) {
                $this->register_model->commit();
                $id_encode = $this->encrypt->encode($user);
                $id_encode = str_replace("/", "_", $id_encode);
                $user1 = urlencode($id_encode);

                $this->session->unset_userdata('inf_regr');
                $this->session->unset_userdata('inf_reg_post_array');
                $msg = lang('registration_completed_successfully');

                $this->redirect("<span><b>$msg!</b>  Username : $user &nbsp;&nbsp; Password : $pass &nbsp; Transaction Password : $tran_code</span>", "auto_register/preview/" . $user1, true);
            } else {
                $this->register_model->rollback();
                $msg = lang('registration_failed');
                $this->redirect($msg, 'tree/select_tree', false);
            }
        } else {
            $this->session->unset_userdata('inf_regr');
            $this->session->unset_userdata('inf_reg_post_array');
            $msg = 'Payment Failed';
            $this->redirect($msg, 'tree/select_tree', false);
        }
    }

    public function epdqPaymentFailure() {
        $this->redirect('..ERROR ON REGISTRATION!! Payment failed..', 'auto_register/user_register');
    }

    public function authorizeNetPayment() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('authorize_authentication');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('authorize_authentication');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $p_id = $this->session->userdata["inf_regr"]["product_id"];
        $product_amount = $this->register_model->getProductAmount($p_id);
        $register_amount = $this->register_model->getRegisterAmount();
        $total_amount = $product_amount + $register_amount;

        $merchant_details = $this->register_model->getAuthorizeDetails();
        $api_login_id = $merchant_details['merchant_id'];
        $transaction_key = $merchant_details['transaction_key'];

        $fp_timestamp = time();
        $fp_sequence = "123" . time(); // Enter an invoice or other unique number.
        $fingerprint = $this->register_model->authorizePay($api_login_id, $transaction_key, $total_amount, $fp_sequence, $fp_timestamp);

        $this->set('user_type', $this->LOG_USER_TYPE);
        $this->set('api_login_id', $api_login_id);
        $this->set('transaction_key', $transaction_key);
        $this->set('amount', $total_amount);
        $this->set('fp_timestamp', $fp_timestamp);
        $this->set('fingerprint', $fingerprint);
        $this->set('fp_sequence', $fp_sequence);

        $this->setView();
    }

    public function payment_done() {

        $response = $this->input->post();
        $regr = $this->session->userdata('inf_regr');

        $product_status = $this->MODULE_STATUS['product_status'];
        $module_status = $this->MODULE_STATUS;

        $insert_id = $this->register_model->insertAuthorizeNetPayment($response);

        $this->register_model->begin();
        $status = $this->register_model->ConfirmRegister($regr, $module_status);

        if ($status['status']) {
            $this->register_model->commit();

            $user = $status['user'];
            $pass = $status['pwd'];
            $tran_code = $status['tran'];

            $payment_method = 'Authorize.Net';
            $user_id = $this->validation_model->userNameToID($user);
            $this->register_model->updateAuthorizeNetPayment($insert_id, $user_id);
            if ($product_status == "yes") {
                $this->register_model->insertIntoSalesOrder($user_id, $regr['product_id'], $payment_method);
            }

            $id_encode = $this->encrypt->encode($user);
            $id_encode = str_replace("/", "_", $id_encode);
            $user1 = urlencode($id_encode);

            $this->session->unset_userdata('inf_regr');
            $this->session->unset_userdata('inf_reg_post_array');
            $msg = lang('registration_completed_successfully');

            $this->redirect("<span><b>$msg!</b>  Username : $user &nbsp;&nbsp; Password : $pass &nbsp; Transaction Password : $tran_code</span>", "auto_register/preview/" . $user1, true);
        } else {
            $this->register_model->rollback();
            $msg = lang('registration_failed');
            $this->redirect($msg, 'tree/select_tree', false);
        }
    }

    /* form validation rule* 
     *    Method is used to validate strings to allow alpha
     *    numeric spaces underscores and dashes ONLY.
     *    @param $str    String    The item to be validated.
     *    @return BOOLEAN   True if passed validation false if otherwise.
     */

    function _alpha_dash_space($str_in = '') {
        if (!preg_match("/^([-a-z0-9_ ])+$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function has_match($post_epin) {
        $flag = false;
        $temp_pin_array = $this->session->userdata("inf_temp_pin_array");
        $split_arr = explode("==", $temp_pin_array);

        if (!in_array($post_epin, $split_arr)) {
            $temp_pin_array.="==$post_epin";
            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
            $flag = true;
        }

        return $flag;
    }

    /* form validation rule ends */
}

?>