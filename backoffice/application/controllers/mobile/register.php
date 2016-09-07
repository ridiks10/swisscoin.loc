<?php

require_once 'Inf_Controller.php';

class Register extends Inf_Controller {

    public $display_tree = "";

    function __construct() {
        parent::__construct();
    }

    function registeration_step1() {
        //sponsor_user_name
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $sponsor_name = $post_array['sponsor_user_name'];
        $is_loggin = $this->LOG_USER_ID;
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid Login details';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $sponsor_id = $this->validation_model->userNameToID($sponsor_name);
            $count = $this->android_inf_model->checkSponsorExist($sponsor_id);

            if ($count == 0) {
                $json_response['message'] = 'Invalid Sponsor';
            } else {
                $json_response['message'] = 'Sponsor name Validated';
            }
        }

        echo json_encode($json_response);
        exit();
    }

    function registeration_submit() {
        //sponsor_user_name
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);

        $is_loggin = $this->LOG_USER_ID;
        if (!$is_loggin) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid Login details';
        } else {

            /////////////////


            $regr = array();

            $reg_post_array = $this->input->post();
            $reg_post_array = $this->validation_model->stripTagsPostArray($post_array);
            $reg_post_array = $this->validation_model->escapeStringPostArray($post_array);
            $this->session->set_userdata('inf_reg_post_array', $reg_post_array);
            if ($this->validate_register_submit()) {

                $payment_status = false;
                $payment_type = 'free_join';
                $is_free_join_ok = false;
                $is_pin_ok = false;
                $is_ewallet_ok = false;
                $is_paypal_ok = false;
                $is_epdq_ok = false;
                $is_authorize_ok = false;

                $module_status = $this->MODULE_STATUS;
                $product_status = $this->MODULE_STATUS['product_status'];
                $username_config = $this->configuration_model->getUsernameConfig();

                $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
                $reg_post_array = $this->validation_model->escapeStringPostArray($reg_post_array);

//                $reg_from_tree = $reg_post_array['reg_from_tree'];
                //$reg_from_tree = 0;
                // $active_tab = $reg_post_array['active_tab'];

                $regr['sponsor_user_name'] = $reg_post_array['sponsor_user_name'];
                $sponsor_id = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                //$regr['sponsor_full_name'] = $reg_post_array['sponsor_full_name'];
                $regr['sponsor_full_name'] = $this->validation_model->getUserFullName($sponsor_id);

                // if ($reg_from_tree && $this->MLM_PLAN != "Unilevel") {
                if ($this->MLM_PLAN != "Unilevel") {
                    $placement_details = $this->register_model->getPlacementBinary($sponsor_id, $reg_post_array['position']);
                    //$regr['placement_user_name'] = $reg_post_array["placement_user_name"];
                    $regr['placement_user_name'] = $this->validation_model->IdToUserName($placement_details['id']);
                    //$regr['placement_full_name'] = $reg_post_array["placement_full_name"];
                    $regr['placement_full_name'] = $this->validation_model->getUserFullName($placement_details['id']);
                    $regr['position'] = $reg_post_array['position'];
                } else {
                    $regr['placement_user_name'] = $reg_post_array["sponsor_user_name"];
                    $regr['placement_full_name'] = $reg_post_array["sponsor_full_name"];
                    $regr['position'] = ($this->MLM_PLAN == "Binary") ? $reg_post_array["position"] : "";
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

                $regr['user_name_entry'] = $reg_post_array['user_name_entry'];
                $regr['pswd'] = $reg_post_array['pswd'];
                $regr['cpswd'] = $reg_post_array['cpswd'];
                $regr['first_name'] = $reg_post_array['first_name'];
                $regr['last_name'] = $reg_post_array['last_name'];
                $regr['gender'] = $reg_post_array['gender'];
                $regr['year'] = $reg_post_array['year'];
                $regr['month'] = $reg_post_array['month'];
                $regr['day'] = $reg_post_array['day'];
                //$regr['date_of_birth'] = $reg_post_array['date_of_birth'];
                $regr['date_of_birth'] = $reg_post_array['year'] . '-' . $reg_post_array['month'] . '-' . $reg_post_array['day'];
                $regr['address'] = $reg_post_array['address'];
                $regr['address_line2'] = $reg_post_array['address_line2'];
                $regr['pin'] = $reg_post_array['pin'];
                $regr['country_name'] = $reg_post_array['country'];
                $regr['country'] = $this->android_inf_model->getCountryIDFromName($reg_post_array['country']);
                $regr['state_name'] = $reg_post_array['state'];
                $regr['state'] = $this->android_inf_model->getStateIdFromName($reg_post_array['state']);
                $regr['city'] = $reg_post_array['city'];
                $regr['email'] = $reg_post_array['email'];
                //$regr['mobile_code'] = $reg_post_array['mobile_code'];
                $regr['land_line'] = $reg_post_array['land_line'];
                $regr['mobile'] = $reg_post_array['mobile'];
                $regr['bank_name'] = $reg_post_array['bank_name'];
                $regr['bank_branch'] = $reg_post_array['bank_branch'];
                $regr['bank_acc_no'] = $reg_post_array['bank_acc_no'];
                $regr['ifsc'] = $reg_post_array['ifsc'];
                $regr['pan_no'] = $reg_post_array['pan_no'];

                $regr['user_name_type'] = $username_config["type"];
                $regr['joining_date'] = date('Y-m-d H:i:s');
                //$regr['active_tab'] = $active_tab;
                // $regr['reg_from_tree'] = $reg_from_tree;

                $regr['sponsor_id'] = $this->validation_model->userNameToID($regr['sponsor_user_name']);
                $regr['placement_id'] = $this->validation_model->userNameToID($regr['placement_user_name']);
                $regr['product_name'] = $this->register_model->getProductName($regr['product_id']);

//            if ($active_tab == 'epin_tab') {
//                $payment_type = 'epin';
//                $pin_count = $reg_post_array['pin_count'];
//                $pin_details = array();
//                for ($i = 1; $i <= $pin_count; $i++) {
//                    if ($reg_post_array["epin$i"]) {
//                        $pin_number = $reg_post_array["epin$i"];
//                        $pin_details[$i]['pin'] = $pin_number;
//                    }
//                }
//                $pin_array = $this->register_model->checkAllEpins($pin_details, $product_id, $product_status, true);
//
//                $is_pin_ok = $pin_array["is_pin_ok"];
//                if (!$is_pin_ok) {
//                    $msg = $this->lang->line('Invalid_Epins');
//                    $this->redirect($msg, "register/user_register", false);
//                }
//            } elseif ($active_tab == 'ewallet_tab') {
//                $payment_type = 'ewallet';
//                $used_amount = $regr['total_amount'];
//                $ewallet_user = $reg_post_array['user_name_ewallet'];
//                $ewallet_trans_password = $reg_post_array['tran_pass_ewallet'];
//                if ($ewallet_user != "") {
//                    $user_available = $this->register_model->isUserAvailable($ewallet_user);
//                    if ($user_available) {
//                        if ($ewallet_trans_password != "") {
//                            $ewallet_user_id = $this->validation_model->userNameToID($ewallet_user);
//                            $trans_pass_available = $this->register_model->checkEwalletPassword($ewallet_user_id, $ewallet_trans_password);
//                            if ($trans_pass_available == 'yes') {
//
//                                $ewallet_balance_amount = $this->register_model->getBalanceAmount($ewallet_user_id);
//                                if ($ewallet_balance_amount >= $used_amount) {
//                                    $is_ewallet_ok = true;
//                                } else {
//                                    $msg = $this->lang->line('insuff_bal');
//                                    $this->redirect($msg, "register/user_register", false);
//                                }
//                            } else {
//                                $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
//                                $this->redirect($msg, "register/user_register", false);
//                            }
//                        } else {
//                            $msg = $this->lang->line('invalid_transaction_password_ewallet_tab');
//                            $this->redirect($msg, "register/user_register", false);
//                        }
//                    } else {
//                        $msg = $this->lang->line('invalid_user_name_ewallet_tab');
//                        $this->redirect($msg, "register/user_register", false);
//                    }
//                } else {
//                    $msg = $this->lang->line('invalid_user_name_ewallet_tab');
//                    $this->redirect($msg, "register/user_register", false);
//                }
//            } elseif (($active_tab == "paypal_tab")) {
//                $payment_type = 'paypal';
//                $is_paypal_ok = true;
//            } else if (($active_tab == "epdq_tab")) {
//                $payment_type = 'epdq';
//                $is_epdq_ok = true;
//            } else if (($active_tab == "authorize_tab")) {
//                $payment_type = 'Athurize.Net';
//                $is_authorize_ok = true;
//            } else {
//                $payment_type = 'free_join';
//                $is_free_join_ok = true;
//            }

                $regr['payment_type'] = $payment_type;
                ///////////// 
                $is_free_join_ok = true;
                //////////////////
//                if ($is_pin_ok) {
//                    $this->register_model->begin();
//                    $regr['by_using'] = 'pin';
//                    $status = $this->register_model->confirmRegister($regr, $module_status);
//                    if ($status['status']) {
//                        $pin_array['user_id'] = $status['id'];
//                        $res = $this->register_model->UpdateUsedEpin($pin_array, $pin_count);
//                        if ($res) {
//                            $this->register_model->insertUsedPin($pin_array, $pin_count);
//                            $payment_status = true;
//                        }
//                    }
//                } elseif ($is_ewallet_ok) {
//                    $this->register_model->begin();
//                    $regr['by_using'] = 'ewallet';
//                    $status = $this->register_model->confirmRegister($regr, $module_status);
//                    if ($status['status']) {
//                        $user = $status['user'];
//                        $user_id = $status['id'];
//                        $used_user_id = $this->validation_model->userNameToID($ewallet_user);
//                        $res1 = $this->register_model->insertUsedEwallet($used_user_id, $user_id, $used_amount);
//                        if ($res1) {
//                            $res2 = $this->register_model->deductFromBalanceAmount($used_user_id, $used_amount);
//                            if ($res2) {
//                                $payment_status = true;
//                            }
//                        }
//                    }
//                } elseif ($is_paypal_ok) {
//                    $regr['by_using'] = 'paypal';
//                    $this->session->set_userdata('inf_regr', $regr);
//                    $msg = "";
//                    $this->redirect($msg, "register/pay_now/", FALSE);
//                } elseif ($is_epdq_ok) {
//                    $regr['by_using'] = 'epdq';
//                    $this->session->set_userdata('inf_regr', $regr);
//                    $msg = "";
//                    $this->redirect($msg, "register/epdqPayment/", FALSE);
//                } elseif ($is_authorize_ok) {
//                    $regr['by_using'] = 'Authorize.Net';
//                    $this->session->set_userdata('inf_regr', $regr);
//                    $msg = "";
//                    $this->redirect($msg, "register/authorizeNetPayment/", FALSE);
//                } 
                //else {
                $regr['by_using'] = 'free join';
                $regr['reg_from_tree'] = 0;
                $this->register_model->begin();
                $status = $this->register_model->confirmRegister($regr, $module_status);
                if ($status['status']) {
                    $payment_status = true;
                }
                //}

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

                    $id_encode = $this->encrypt->encode($user);
                    $id_encode = str_replace("/", "_", $id_encode);
                    $user1 = urlencode($id_encode);
                    $this->session->unset_userdata('inf_regr');
                    $this->session->unset_userdata('inf_reg_post_array');
                    $json_response['status'] = true;
                    $json_response['message'] = 'Registration sucessful';
                    echo json_encode($json_response);
                    exit();
                    $msg = lang('registration_completed_successfully');
                    $this->redirect("<span><b>$msg!</b>  " . lang("User_Name") . " : $user &nbsp;&nbsp; " . lang("password") . " : $pass &nbsp; " . lang("transaction_password") . " : $tran_code</span>", "register/preview/" . $user1, true);
                } else {
                    $this->register_model->rollback();
                    $json_response['status'] = true;
                    $json_response['message'] = 'Error on egistration';
                    echo json_encode($json_response);
                    exit();
                    $msg = lang('registration_failed');
                    $this->redirect($msg, 'tree/select_tree', false);
                }
            } else {
                $error = $this->form_validation->error_array();
                $this->session->set_userdata('inf_error', $error);

                $msg = $this->lang->line('errors_check');
                $this->redirect($msg, "register/user_register", FALSE);
            }


            //////////////////////



            $json_response['status'] = true;
            $json_response['message'] = 'Login Success';
            $sponsor_id = $this->validation_model->userNameToID($sponsor_name);
            $count = $this->android_inf_model->checkSponsorExist($sponsor_id);

            if ($count == 0) {
                $json_response['message'] = 'Invalid Sponsor';
            } else {
                $json_response['message'] = 'Sponsor name Validated';
            }
        }

        echo json_encode($json_response);
        exit();
    }

    function validate_register_submit() {
        $reg_post_array = $this->input->post();
        $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
        $reg_post_array = $this->validation_model->escapeStringPostArray($reg_post_array);
        $product_status = $this->MODULE_STATUS['product_status'];
        $username_config = $this->configuration_model->getUsernameConfig();

        $user_name_type = $username_config["type"];

        $active_tab = $this->input->post('active_tab');
        $reg_from_tree = $this->input->post('reg_from_tree');
        $pin_count = $this->input->post('pin_count');

        if ($reg_from_tree && $this->MLM_PLAN != "Unilevel") {
            $this->form_validation->set_rules('placement_user_name', 'Placement Username', 'required|callback_validate_username|trim');
            $this->form_validation->set_rules('placement_full_name', 'Placement FullName', 'required|trim');
        }
        $this->form_validation->set_rules('sponsor_user_name', 'Sponsor Username', 'required|callback_validate_username|trim');
        $this->form_validation->set_rules('sponsor_full_name', 'Sponsor FullName', 'required|trim');

        if ($this->MLM_PLAN == 'Binary') {
            if ($reg_post_array['position'] == "") {
                $json_response['status'] = false;
                $json_response['message'] = 'Position Not Found  ';
                echo json_encode($json_response);
                exit();
            }
//            $this->form_validation->set_rules('position', 'Position', 'trim|required');
        }

        if ($product_status == "yes") {
            $this->form_validation->set_rules('product_id', 'Product', 'trim|required');
        }

        if ($user_name_type == 'static') {
            $user_name_id = $this->validation_model->userNameToID($reg_post_array['user_name_entry']);
            $count = $this->android_inf_model->checkSponsorExist($user_name_id);
            if ($count) {
                $json_response['status'] = false;
                $json_response['message'] = 'User Already Exist';
                echo json_encode($json_response);
                exit();
            }
        }
        $val = $this->android_inf_model->validatePswd($reg_post_array['pswd']);
        $count_email = $this->android_inf_model->getCountEmail($reg_post_array['email']);

        if ($reg_post_array['pswd'] == "") {

            $user_details['status'] = false;
            $user_details['message'] = 'Password field is required';
            echo json_encode($user_details);
            exit();
        } else if (!$val) {
            $user_details['status'] = false;
            $user_details['message'] = 'Special character not allowed';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['cpswd'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Confirm Password field is required';
            echo json_encode($user_details);
            exit();
        } else if (strcmp($reg_post_array['pswd'], $reg_post_array['cpswd']) != 0 || strlen($reg_post_array['pswd']) < 6) {
            $user_details['status'] = false;
            $user_details['message'] = 'Password is mismatch or new password is too short';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['first_name'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'First Name field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['last_name'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Last Name field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['gender'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Gender field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['year'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Year field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['month'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Month field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['day'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Day field is required';
            echo json_encode($user_details);
            exit();
        }
//        else if ($reg_post_array['date_of_birth'] == "") {
//            $user_details['status'] = false;
//            $user_details['message'] = 'DOB field is required';
//            echo json_encode($user_details);
//            exit();
//        }
        else if ($reg_post_array['address'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Address Line 1 field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['country'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Country field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['city'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'City field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['mobile'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Mobile Number field is required';
            echo json_encode($user_details);
            exit();
        } else if ($reg_post_array['email'] == "") {
            $user_details['status'] = false;
            $user_details['message'] = 'Email Number field is required';
            echo json_encode($user_details);
            exit();
        } else if ($count_email) {
            $user_details['status'] = false;
            $user_details['message'] = 'This email already used';
            echo json_encode($user_details);
            exit();
        } else if (!filter_var($reg_post_array['email'], FILTER_VALIDATE_EMAIL)) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Email';
            echo json_encode($user_details);
            exit();
        }


//        $this->form_validation->set_rules('pswd', 'Password', 'trim|required|alpha_dash|matches[cpswd]|min_length[6]');
//        $this->form_validation->set_rules('cpswd', 'Confirm Password', 'trim|required|alpha_dash');
//        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|callback__alpha_dash_space');
//        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|callback__alpha_dash_space');
//        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
//        $this->form_validation->set_rules('year', 'Date of Borth', 'trim|required');
//        $this->form_validation->set_rules('month', 'Date of Borth', 'trim|required');
//        $this->form_validation->set_rules('day', 'Date of Borth', 'trim|required');
//        $this->form_validation->set_rules('address', 'Address Line 1', 'trim|required|callback_alpha_city_address');
//        $this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim|callback_alpha_city_address');
//        $this->form_validation->set_rules('country', 'Country', 'trim|required');
//        $this->form_validation->set_rules('city', 'City', 'trim|required|callback_alpha_city_address');
//        $this->form_validation->set_rules('agree', 'Terms and Conditions', 'trim|required');
//        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
//        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
//        if ($active_tab == "credit_card_tab") {
//            $this->form_validation->set_rules('card_number', 'Card Number', 'trim|required|numeric');
//            $this->form_validation->set_rules('credit_currency', 'Credit currency', 'trim|required');
//            $this->form_validation->set_rules('credit_card_type', 'Credit Card Type', 'trim|required');
//            $this->form_validation->set_rules('card_cvn', 'CVN number', 'trim|required|numeric');
//            $this->form_validation->set_rules('card_expiry_date', 'Credit card expiry date', 'trim|required');
//            $this->form_validation->set_rules('bill_to_forename', 'Account Holder First name', 'trim|required');
//            $this->form_validation->set_rules('bill_to_surname', 'Account Holder Last name', 'trim|required');
//            $this->form_validation->set_rules('bill_to_email', 'Account Holder Email', 'trim|required|valid_email');
//            $this->form_validation->set_rules('bill_to_phone', 'Account Holder Phone number', 'trim|required|numeric');
//        }
//        if ($active_tab == 'epin_tab') {
//            $temp_pin_array = "";
//            $this->session->set_userdata("inf_temp_pin_array", $temp_pin_array);
//            for ($i = 1; $i <= $pin_count; $i++) {
//                if ($this->input->post("epin$i")) {
//                    $this->form_validation->set_rules("epin$i", "Epin$i ", " trim|required|callback_has_match");
//                }
//            }
//            $this->session->unset_userdata("inf_temp_pin_array");
//        }
//        if ($active_tab == 'ewallet_tab') {
//            $this->form_validation->set_rules('user_name_ewallet', 'Ewallet User Nmae', 'trim|required');
//            $this->form_validation->set_rules('tran_pass_ewallet', 'Transaction Password', 'trim|required');
//        }
//        $this->form_validation->set_message('required', '%s is Required');
//        $this->form_validation->set_message('exact_length', 'The %s field must be exactly 10 digit.');
//        $this->form_validation->set_message('validate_username', 'The Sponsor Username is Not Available');
//        $this->form_validation->set_message('check_username_availability', 'The Username is Not Available');
//
//        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", "</div>");
//        $validation_status = $this->form_validation->run();
//        if ($validation_status) {
//            echo json_encode($user_details);
//            exit();
//        }
        //return $validation_status;
        return TRUE;
    }

}
