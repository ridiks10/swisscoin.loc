<?php

require_once 'Inf_Controller.php';

class Default_Data extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->register_model = new register_model();
        $this->obj_config = new configuration_model();
        $this->epin_model = new epin_model();
        $this->product_model = new product_model();
    }

    function index() {

        $user_id = $this->LOG_USER_ID;
        $module_status = $this->MODULE_STATUS;

        if ($module_status['product_status'] == 'yes')
            $prdt_st = $this->generate_products();
        else
            $prdt_st = TRUE;

        $user_st = $this->generate_users();

        if ($module_status['employee_status'] == 'yes')
            $emp_st = $this->generate_employees();
        else
            $emp_st = TRUE;

        if ($module_status['pin_status'] == 'yes')
            $epin_st = $this->generate_epins();
        else
            $epin_st = TRUE;

        if (!$user_st) {
            $msg = lang('user_generation_filed');
            $this->redirect($msg, 'home', FALSE);
        } elseif (!$emp_st) {
            $msg = lang('emp_generation_failed');
            $this->redirect($msg, 'home', FALSE);
        } elseif (!$epin_st) {
            $msg = lang('epin_generation_failed');
            $this->redirect($msg, 'home', FALSE);
        } elseif (!$prdt_st) {
            $redirect_msg = lang('error_on_adding_product');
            $this->redirect($redirect_msg, 'home', FALSE);
        } else {
            $mail_st = $this->default_data_model->sendMesageToAdmin($user_id);
            $redirect_msg = lang('default_data_added');
            $this->redirect($redirect_msg, 'home', TRUE);
        }
    }

    function generate_users() {

        $module_status = $this->MODULE_STATUS;
        $username_config = $this->obj_config->getUsernameConfig();
        $flag = TRUE;
        $regr = array();

        $regr['user_name_type'] = $username_config["type"];
        $regr['address'] = "Test ioss Address";
        $regr['post_office'] = "Test PO";
        $regr['town'] = "Town";
        $regr['country_id'] = 99;
        $regr['country'] = $this->country_state_model->countryNameFromID($regr['country_id']);
        $regr['state'] = 1490;
        $regr['pin'] = "671310";
        $regr['land_line'] = "0000000";
        $regr['email'] = "testmail@gmail.com";
        $regr['date_of_birth'] = "1900-01-1";
        $regr['nominee'] = '';
        $regr['relation'] = '';
        $regr['pan_no'] = '';
        $regr['bank_acc_no'] = '';
        $regr['ifsc'] = '';
        $regr['bank_name'] = '';
        $regr['bank_branch'] = '';
        $regr['joining_date'] = date('Y-m-d H:i:s');
        $regr['year'] = '1900';
        $regr['month'] = '01';
        $regr['day'] = '1';
        $regr['mobile_code'] = '+93';
        $regr['active_tab'] = '';
        $regr['is_pin'] = 0;

        $regr['referral_name'] = "admin";
        $regr['product_id'] = 1;
        $regr['product_name'] = 'Product1';
        $regr['pswd'] = '123456';
        $regr['cpswd'] = '123456';
        $regr['gender'] = 'M';
        $regr['mobile'] = '54545454';
        $regr['by_using'] = 'free join';

        $fatherid = $this->validation_model->userNameToID($regr['referral_name']);
        $regr['referral_id'] = $regr['referral_name'];
        $placement_det = $this->register_model->getPlacementUnilevel($regr['referral_id']);

        $last_user_id = $placement_det['id'];
        $last_position = $placement_det['position'];
        $regr['pos'] = $last_position;

        for ($i = 0; $i < 10; $i++) {

            $regr['full_name'] = "Test" . ($i + 1);
            $regr['user_name_entry'] = "testioss" . ($i + 1);
            if ($this->validation_model->isUserNameAvailable($regr['user_name_entry'])) {
                $regr['user_name_entry'] = $this->default_data_model->getUsername();
                $regr['full_name'] = "User" . ($i + 1);
            }
            if ($i % 2 == 0)
                $regr['position'] = 'L';
            else
                $regr['position'] = 'R';

            $last_user_id = $this->register_model->getPlacement($fatherid, $regr['position']);
            $last_user_name = $this->validation_model->IdToUserName($last_user_id);
            $regr['fatherid'] = $last_user_name;
            $last_insert_id = $last_user_id;

            $status = $this->default_data_model->confirmRegister($regr, $module_status);


            if (!$status['status']) {
                $flag = FALSE;
                return $flag;
            } else {
                $lang_id = $this->LANG_ID;
                $user_id = $this->validation_model->userNameToID($status['user']);
                $subject = "Welcome " . $this->validation_model->getUserFullName($user_id);
                $letter_arr = $this->obj_config->getLetterSetting($lang_id);
                $date = date('Y-m-d-h:i:s');
                $message = $letter_arr['main_matter'];
                $res = $this->default_data_model->sendMessageToUser($user_id, $subject, $message, $date, $regr['fatherid']);
                $regr['referral_name'] = $regr['user_name_entry'];
            }
        }
        if ($flag) {
            return $flag;
        }
    }

    function generate_epins() {

        $uploded_date = date('Y-m-d H:i:s');
        $pin_alloc_date = date('Y-m-d H:i:s');

        $status = 'yes';
        $cnt = 10;

        $expiry_date = date_add(date_create($uploded_date), date_interval_create_from_date_string("10 days"));
        $expiry_date = date_format($expiry_date, "Y-m-d");

        for ($i = 0; $i < 3; $i++) {
            $pin_amount = ($i + 1) * 100;
            $result = $this->epin_model->generatePasscode($cnt, $status, $uploded_date, $pin_amount, $expiry_date, $pin_alloc_date);
            if (!$result) {
                return FALSE;
            }
        }
        if ($result) {
            $login_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type == 'employee') {

                $login_id = $this->validation_model->getAdminId();
            }
            $this->validation_model->insertUserActivity($login_id, 'epin added', $login_id);
            return TRUE;
        }
    }

    function generate_employees() {

        $user_id = $this->LOG_USER_ID;
        $reg_arr = array();
        $reg_arr['pswd'] = '456123';
        $reg_arr['mobile'] = '1234567890';
        $reg_arr['email'] = 'test@empmail.com';
        $reg_arr['address'] = 'Employee Ioss address';
        $reg_arr['pin'] = '671310';
        $reg_arr['land_line'] = '04985222444';
        $reg_arr['date_of_birth'] = '1900-01-1';

        for ($i = 0; $i < 3; $i++) {

            $reg_arr['full_name'] = "EmpIoss$i";
            $reg_arr['ref_username'] = "Employee$i";
            if ($this->default_data_model->isUserNameAvailable($reg_arr['ref_username'])) {
                $reg_arr['ref_username'] = 'emp' . $this->default_data_model->getUsername();
            }

            $result = $this->default_data_model->confirmRegistration($reg_arr);
            if (!$result) {
                return FALSE;
            }
        }
        if ($result) {
            $this->validation_model->insertUserActivity($user_id, 'default employees added', $user_id);
            return TRUE;
        }
    }

    function generate_products() {

        $user_id = $this->LOG_USER_ID;
        for ($i = 0; $i < 5; $i++) {
            $prod_arr['prod_name'] = "IProduct$i";
            $prod_arr['product_id'] = $i + 1;
            $prod_arr['product_value'] = ($i + 1) * 100;
            $prod_arr['pair_value'] = 25;
            $prod_arr['bv_value'] = 0;
            $prod_arr['user_id'] = $user_id;
            if ($i % 2 == 0)
                $prod_arr['active'] = 'yes';
            else
                $prod_arr['active'] = 'no';
            if ($this->MODULE_STATUS ['mlm_plan'] == 'Board')
                $pair_value = 0;
            $result = $this->default_data_model->addProduct($prod_arr);

            if (!$result) {
                return FALSE;
            }
        }
        if ($result) {
            $this->validation_model->insertUserActivity($user_id, 'default products added', $user_id);
            return TRUE;
        }
    }

}
