<?php

class cleanup_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function clean($module_status = array()) {

        $this->load->model('validation_model');
        $this->load->model('registersubmit_model');

        $MODULE_STATUS = $this->trackModule();
        $mlm_plan = $MODULE_STATUS["mlm_plan"];

        $session_data = $this->session->userdata('inf_logged_in');
        $admin_pass = $this->validation_model->getAdminPassword();

        $admin_id = $this->validation_model->getAdminId();
        $user_details = $this->getUserDetails($admin_id);
        $user_name = $session_data['user_name'];

        $tables_array = array();
        $database_name = $this->db->database;
        $dbprefix = $this->db->dbprefix;
        $ocprefix = $this->db->ocprefix;

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '$dbprefix%' ");

        foreach ($table_query->result_array() AS $rows) {
            $tables_array[] = $rows['TABLE_NAME'];
        }

        $this->begin();

        $current_date = date("Y-m-d H:i:s");

        if (in_array($dbprefix . 'login_user', $tables_array)) {
            $this->db->truncate('login_user');

            $login_user = $dbprefix . "login_user";
            $set_auto_increment_login_user = "ALTER TABLE $login_user AUTO_INCREMENT=1";
            $this->db->query($set_auto_increment_login_user);

            $login_data = array(
                'user_id' => $admin_id,
                'user_type' => 'admin',
                'addedby' => 'code',
                'user_name' => $user_name,
                'password' => $admin_pass
            );
            $this->db->insert('login_user', $login_data);
        }
        if (in_array($dbprefix . 'ft_individual', $tables_array)) {
            $this->db->truncate('ft_individual');

            $ft_individual = $dbprefix . "ft_individual";
            $set_auto_increment_ft_individual = "ALTER TABLE $ft_individual AUTO_INCREMENT=$admin_id";
            $this->db->query($set_auto_increment_ft_individual);

            $ft_details = array(
                'id' => $admin_id,
                'father_id' => '0',
                'oc_customer_ref_id' => '0',
                'sponsor_id' => '0',
                'position' => '',
                'user_name' => $user_name,
                'active' => 'yes',
                'date_of_joining' => $current_date,
                'product_id' => '1',
                'left_father' => '1',
                'right_father' => '2',
                'left_sponsor' => '1',
                'right_sponsor' => '2'
            );
            $this->db->insert('ft_individual', $ft_details);
        }
        if (in_array($dbprefix . 'user_details', $tables_array)) {
            $this->db->truncate('user_details');

            $user_details['join_date'] = $current_date;
            $this->db->insert('user_details', $user_details);
        }


        if (in_array($dbprefix . 'infinite_user_registration_details', $tables_array)) {
            $this->db->truncate('infinite_user_registration_details');

            $login_user = $dbprefix . "infinite_user_registration_details";
            $set_auto_increment_login_user = "ALTER TABLE $login_user AUTO_INCREMENT=1";
            $this->db->query($set_auto_increment_login_user);
        }
        if (in_array($dbprefix . 'leg_amount', $tables_array)) {
            $this->db->truncate('leg_amount');

            $leg_amount = $dbprefix . "leg_amount";
            $set_auto_increment_leg_amount = "ALTER TABLE $leg_amount AUTO_INCREMENT=$admin_id";
            $this->db->query($set_auto_increment_leg_amount);
        }

        if (in_array($dbprefix . 'user_balance_amount', $tables_array)) {
            $this->db->truncate('user_balance_amount');
            $user_balance_details = array(
                'user_id' => $admin_id,
                'balance_amount' => '0',
                'tokens' => '0'
            );
            $this->db->insert('user_balance_amount', $user_balance_details);
        }

        if (in_array($dbprefix . 'tran_password', $tables_array)) {
            $this->db->truncate('tran_password');

            $tran_password_details = array(
                'user_id' => $admin_id,
                'tran_password' => '12345678'
            );
            $this->db->insert('tran_password', $tran_password_details);
        }
        if (in_array($dbprefix . 'login_employee', $tables_array)) {
            $this->db->truncate('login_employee');
        }
        if (in_array($dbprefix . 'webinars', $tables_array)) {
            $this->db->truncate('webinars');
        }
        if (in_array($dbprefix . 'orders', $tables_array)) {
            $this->db->truncate('orders');
        }
        if (in_array($dbprefix . 'order_history', $tables_array)) {
            $this->db->truncate('order_history');
        }
        if (in_array($dbprefix . 'workshop', $tables_array)) {
            $this->db->truncate('workshop');
        }
        if (in_array($dbprefix . 'compensation', $tables_array)) {
            $this->db->truncate('compensation');
        }
        if (in_array($dbprefix . 'documents', $tables_array)) {
            $this->db->truncate('documents');
        }
        if (in_array($dbprefix . 'kyc_details', $tables_array)) {
            $this->db->truncate('kyc_details');
        }
//        if (in_array($dbprefix . 'leg_details', $tables_array)) {
//            $this->db->truncate('leg_details');
//        }
        if (in_array($dbprefix . 'amount_paid', $tables_array)) {
            $this->db->truncate('amount_paid');
        }
        if (in_array($dbprefix . 'ticket_complaint_query_table', $tables_array)) {
            $this->db->truncate('ticket_complaint_query_table');
        }
        if (in_array($dbprefix . 'ticket_complaint_ticket_table', $tables_array)) {
            $this->db->truncate('ticket_complaint_ticket_table');
        }
        if (in_array($dbprefix . 'events', $tables_array)) {
            $this->db->truncate('events');
        }
        if (in_array($dbprefix . 'feedback', $tables_array)) {
            $this->db->truncate('feedback');
        }
        if (in_array($dbprefix . 'fund_transfer_details', $tables_array)) {
            $this->db->truncate('fund_transfer_details');
        }
        if (in_array($dbprefix . 'investment', $tables_array)) {
            $this->db->truncate('investment');
        }
        if (in_array($dbprefix . 'mailtoadmin', $tables_array)) {
            $this->db->truncate('mailtoadmin');
        }
        if (in_array($dbprefix . 'mailtouser', $tables_array)) {
            $this->db->truncate('mailtouser');
        }
        if (in_array($dbprefix . 'news', $tables_array)) {
            $this->db->truncate('news');
        }
        if (in_array($dbprefix . 'password_reset_table', $tables_array)) {
            $this->db->truncate('password_reset_table');
        }
        if (in_array($dbprefix . 'pin_numbers', $tables_array)) {
            $this->db->truncate('pin_numbers');
        }
        if (in_array($dbprefix . 'pin_request', $tables_array)) {
            $this->db->truncate('pin_request');
        }
        if (in_array($dbprefix . 'payout_release_requests', $tables_array)) {
            $this->db->truncate('payout_release_requests');
        }
        if (in_array($dbprefix . 'sms_history', $tables_array)) {
            $this->db->truncate('sms_history');
        }

        if (in_array($dbprefix . 'product_image_table', $tables_array)) {
            $this->db->truncate('product_image_table');
        }
        if (in_array($dbprefix . 'rank_history', $tables_array)) {
            $this->db->truncate('rank_history');
        }
        if (in_array($dbprefix . 'sales_order', $tables_array)) {
            $this->db->truncate('sales_order');
        }
        if (in_array($dbprefix . 'activity_history', $tables_array)) {
            $this->db->truncate('activity_history');
        }
        if (in_array($dbprefix . 'ewallet_payment_details', $tables_array)) {
            $this->db->truncate('ewallet_payment_details');
        }
        if (in_array($dbprefix . 'credit_card_purchase_details', $tables_array)) {
            $this->db->truncate('credit_card_purchase_details');
        }
        if (in_array($dbprefix . 'pin_used', $tables_array)) {
            $this->db->truncate('pin_used');
        }
        if (in_array($dbprefix . 'username_change_history', $tables_array)) {
            $this->db->truncate('username_change_history');
        }
        if (in_array($dbprefix . 'payment_registration_details', $tables_array)) {
            $this->db->truncate('payment_registration_details');
        }
        if (in_array($dbprefix . 'authorize_payment_details', $tables_array)) {
            $this->db->truncate('authorize_payment_details');
        }
        if (in_array($dbprefix . 'employee_details', $tables_array)) {
            $this->db->truncate('employee_details');
        }
        if (in_array($dbprefix . 'mailtouser_cumulativ', $tables_array)) {
            $this->db->truncate('mailtouser_cumulativ');
        }
        if (in_array($dbprefix . 'mail_from_lead', $tables_array)) {
            $this->db->truncate('mail_from_lead');
        }
        if (in_array($dbprefix . 'mail_from_lead_cumulative', $tables_array)) {
            $this->db->truncate('mail_from_lead_cumulative');
        }
        if (in_array($dbprefix . 'pin_purchases', $tables_array)) {
            $this->db->truncate('pin_purchases');
        }
        if (in_array($dbprefix . 'capture_details', $tables_array)) {
            $this->db->truncate('capture_details');
        }
        if (in_array($dbprefix . 'invite_history', $tables_array)) {
            $this->db->truncate('invite_history');
        }
        if (in_array($dbprefix . 'invites_configuration', $tables_array)) {
            $this->db->truncate('invites_configuration');
        }
        if (in_array($dbprefix . 'user_activation_deactivation_history', $tables_array)) {
            $this->db->truncate('user_activation_deactivation_history');
        }
        if (in_array($dbprefix . 'mlm_curl_history', $tables_array)) {
            $this->db->truncate('mlm_curl_history');
        }

        if ($mlm_plan == 'Party') {
            if (in_array($dbprefix . 'party', $tables_array)) {
                $this->db->truncate('party');
            }
            if (in_array($dbprefix . 'party_guest', $tables_array)) {
                $this->db->truncate('party_guest');
            }
            if (in_array($dbprefix . 'party_guest_invited', $tables_array)) {
                $this->db->truncate('party_guest_invited');
            }
            if (in_array($dbprefix . 'party_guest_orders', $tables_array)) {
                $this->db->truncate('party_guest_orders');
            }
            if (in_array($dbprefix . 'party_host', $tables_array)) {
                $this->db->truncate('party_host');
            }
        } else if ($mlm_plan == "Binary") {
            if (in_array($dbprefix . 'leg_details', $tables_array)) {
                $this->db->truncate('leg_details');

                $leg_details = array(
                    'id' => $admin_id
                );
                $this->db->insert('leg_details', $leg_details);
            }
            if (in_array($dbprefix . 'leg_carry_forward', $tables_array)) {
                $this->db->truncate('leg_carry_forward');
                $set_auto_increment_leg_carry_forward = "ALTER TABLE " . $dbprefix . "leg_carry_forward AUTO_INCREMENT=$admin_id";
                $this->db->query($set_auto_increment_leg_carry_forward);
            }
        } else if ($mlm_plan == "Board") {

            if (in_array($dbprefix . 'auto_board_1', $tables_array)) {
                $this->db->truncate("auto_board_1");

                $auto_board = $dbprefix . "auto_board_1";
                $set_auto_increment_auto_board = "ALTER TABLE $auto_board AUTO_INCREMENT=$admin_id";
                $this->db->query($set_auto_increment_auto_board);

                $auto_board_det = array(
                    "user_ref_id" => $admin_id,
                    "user_name" => "STARTER$user_name",
                    "position" => '',
                    "active" => 'yes',
                    "father_id" => '0',
                    "date_of_joining" => $current_date,
                    "user_level" => '0'
                );
                $this->db->insert('auto_board_1', $auto_board_det);
            }
            if (in_array($dbprefix . 'auto_board_2', $tables_array)) {
                $this->db->truncate("auto_board_2");

                $auto_board = $dbprefix . "auto_board_2";
                $set_auto_increment_auto_board = "ALTER TABLE $auto_board AUTO_INCREMENT=$admin_id";
                $this->db->query($set_auto_increment_auto_board);

                $auto_board_det = array(
                    "user_ref_id" => $admin_id,
                    "user_name" => "VIP$user_name",
                    "position" => '',
                    "active" => 'yes',
                    "father_id" => '0',
                    "date_of_joining" => $current_date,
                    "user_level" => '0'
                );
                $this->db->insert('auto_board_2', $auto_board_det);
            }
            if (in_array($dbprefix . 'board_view', $tables_array)) {
                $this->db->truncate("board_view");
                $board_view = $dbprefix . "board_view";
                $set_auto_increment_board_view = "ALTER TABLE $board_view AUTO_INCREMENT = 1";
                $this->db->query($set_auto_increment_board_view);

                $board_view_det = array(
                    "board_top_id" => $admin_id,
                    "board_table_name" => '1',
                    "board_no" => '1',
                    "board_view_status" => 'yes',
                    "board_split_status" => 'no',
                    "date_of_join" => $current_date
                );
                $this->db->insert('board_view', $board_view_det);

                $board_view_det = array(
                    "board_top_id" => $admin_id,
                    "board_table_name" => '2',
                    "board_no" => '1',
                    "board_view_status" => 'yes',
                    "board_split_status" => 'no',
                    "date_of_join" => $current_date
                );
                $this->db->insert('board_view', $board_view_det);
            }

            if (in_array($dbprefix . 'board_user_detail', $tables_array)) {
                $this->db->truncate("board_user_detail");
                $board_user_detail = $dbprefix . "board_user_detail";
                $set_auto_increment_board_user_detail = "ALTER TABLE $board_user_detail AUTO_INCREMENT=1";
                $this->db->query($set_auto_increment_board_user_detail);

                $board_user_details = array(
                    "board_table_name" => '1',
                    "user_id" => $admin_id,
                    "board_serial_no" => '1',
                    "date_of_join" => $current_date
                );
                $this->db->insert('board_user_detail', $board_user_details);

                $board_user_details = array(
                    "board_table_name" => '2',
                    "user_id" => $admin_id,
                    "board_serial_no" => '1',
                    "date_of_join" => $current_date
                );
                $this->db->insert('board_user_detail', $board_user_details);
            }
        }

        $opencart_status = $module_status['opencart_status_demo'];
        if ($opencart_status == 'yes') {
            $ip_adress = $_SERVER['REMOTE_ADDR'];
            $this->db->set_dbprefix($ocprefix);
            $this->db->set_ocprefix($ocprefix);

            $admin_oc_details = $this->getADMINOCDetails();
            $admin_oc_address_det = $this->getADMINOCAddressDetails();
            $user_det = $this->getStoreUserDetails();

            if (in_array($ocprefix . 'customer', $tables_array)) {
                $this->db->truncate('customer');

                if (!$admin_oc_details) {
                    $admin_oc_details = array(
                        "customer_group_id" => 1,
                        "store_id" => 0,
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "email" => $user_details['user_detail_email'],
                        "telephone" => $user_details['user_detail_land'],
                        "fax" => '',
                        "password" => $admin_pass,
                        "salt" => '',
                        "address_id" => 1,
                        "ip" => $ip_adress,
                        "status" => 1,
                        "approved" => 1,
                        "date_added" => $current_date
                    );
                }
                $this->db->insert('customer', $admin_oc_details);
                $customer_id = $this->db->insert_id();
            }
            if (in_array($ocprefix . 'address', $tables_array)) {
                $this->db->truncate('address');

                if (!$admin_oc_address_det) {
                    $admin_oc_address_det = array(
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "address_1" => $user_details['user_detail_address'],
                        "address_2" => $user_details['user_detail_address2'],
                        "city" => $user_details['user_detail_city'],
                        "postcode" => $user_details['user_detail_pin']
                    );
                }
                $admin_oc_address_det['customer_id'] = $customer_id;
                $this->db->insert('address', $admin_oc_address_det);
            }

            if (in_array($ocprefix . 'customer_activity', $tables_array)) {
                $this->db->truncate('customer_activity`');
            }
            if (in_array($ocprefix . 'customer_ip', $tables_array)) {
                $this->db->truncate('customer_ip');

                $customer_ip_det = array(
                    "customer_id" => $customer_id,
                    "ip" => "$ip_adress",
                    "date_added" => "$current_date"
                );
                $this->db->insert('customer_ip', $customer_ip_det);
            }
            if (in_array($ocprefix . 'coupon', $tables_array)) {
                $this->db->truncate('coupon');
            }
            if (in_array($ocprefix . 'coupon_history', $tables_array)) {
                $this->db->truncate('coupon_history');
            }
            if (in_array($ocprefix . 'order', $tables_array)) {
                $this->db->truncate('order');
            }
            if (in_array($ocprefix . 'order_history', $tables_array)) {
                $this->db->truncate('order_history');
            }
            if (in_array($ocprefix . 'order_total', $tables_array)) {
                $this->db->truncate('order_total');
            }
            if (in_array($ocprefix . 'order_product', $tables_array)) {
                $this->db->truncate('order_product');
            }

            if (in_array($ocprefix . 'store', $tables_array)) {
                $this->db->truncate('store');
            }
            if (in_array($ocprefix . 'user', $tables_array)) {
                $this->db->truncate('user');
                if (!$user_det) {
                    $user_det[] = array(
                        'user_id' => 1,
                        'user_group_id' => 1,
                        'username' => $user_name,
                        'password' => '93d73816952f63a4a4d744ff6572e38c116a1e14',
                        'salt' => '3bb59db46',
                        "firstname" => $user_details['user_detail_name'],
                        "lastname" => $user_details['user_detail_second_name'],
                        "email" => $user_details['user_detail_email'],
                        'image' => '',
                        'code' => '',
                        'ip' => $ip_adress,
                        'status' => 1,
                        'date_added' => $current_date,
                    );
                }
                foreach ($user_det AS $user) {
                    $this->db->insert('user', $user);
                }
            }

            $this->db->set_dbprefix($dbprefix);
            $this->db->set_ocprefix($ocprefix);
            $this->updateFTAdminCustomerRefID($customer_id, $user_name);
        }

        $ticket_system_status = $module_status['ticket_system_status_demo'];
        if ($ticket_system_status == 'yes') {
            if (in_array($dbprefix . 'ticket_attachments', $tables_array)) {
                $this->db->truncate('ticket_attachments');
            }
            if (in_array($dbprefix . 'kb_attachments', $tables_array)) {
                $this->db->truncate('kb_attachments');
            }
            if (in_array($dbprefix . 'ticket_kb_articles', $tables_array)) {
                $this->db->truncate('ticket_kb_articles');
            }
            if (in_array($dbprefix . 'ticket_tickets', $tables_array)) {
                $this->db->truncate('ticket_tickets');
            }
            if (in_array($dbprefix . 'ticket_ticket_replies', $tables_array)) {
                $this->db->truncate('ticket_ticket_replies');
            }
        }

        $last_insert_id = 0;
        $this->db->select_max('user_id', 'user_id');
        $this->db->from('login_user');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_insert_id = $row->user_id;
        }
        if ($last_insert_id) {
            if ($mlm_plan == 'Board' || $mlm_plan == 'Matrix' || $mlm_plan == 'Unilevel' || $mlm_plan == 'Party') {
                $temp_result = $this->registersubmit_model->tmpInsert($last_insert_id, "1");
            } else if ($mlm_plan == 'Binary') {
                $temp_result = $this->registersubmit_model->tmpInsert($last_insert_id, "L");
                $this->registersubmit_model->tmpInsert($last_insert_id, "R");
            } else {
                $temp_result = true;
            }
        } else {
            $temp_result = false;
        }

        if ($temp_result) {
            $this->commit();
        } else {
            $this->rollBack();
        }
        return $temp_result;
    }

    function getUserDetails($id) {
        $user_details = array();
        $this->db->select("*");
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $user_details = $row;
        }
        return $user_details;
    }

    public function getADMINOCDetails() {
        $password_det = array();
        $this->db->from("customer");
        $this->db->where("customer_id", '1');
        $this->db->limit(1);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $password_det = $row;
        }
        return $password_det;
    }

    public function getADMINOCAddressDetails() {
        $password_det = array();
        $this->db->from("address");
        $this->db->where("customer_id", '1');
        $this->db->limit(1);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $password_det = $row;
        }
        return $password_det;
    }

    public function getStoreUserDetails() {
        $user_det = array();
        $this->db->select("*");
        $this->db->from("user");
        $this->db->where('username', 'admin');
        $this->db->or_where('username', 'store_admin');
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $user_det[] = $row;
        }
        return $user_det;
    }

    public function updateFTAdminCustomerRefID($customer_id, $user_name) {
        $this->db->set("oc_customer_ref_id", $customer_id);
        $this->db->where("user_name", $user_name);
        $this->db->update("ft_individual");
    }

  public function clean_tickets() {
        $res1 = $this->db->truncate('tickets');
        $res2 = $this->db->truncate('ticket_activity');
        $res3 = $this->db->truncate('ticket_assignee');
        $res4 = $this->db->truncate('ticket_comments');
        $res5 = $this->db->truncate('employee_ticket_activity');
        $res6 = $this->db->truncate('ticket_faq');
        $res7 = $this->db->truncate('ticket_replies');
        $res8 = $this->db->truncate('attachments');
//        $res6= $this->db->truncate('ticket_categories');
//        $res6= $this->db->truncate('ticket_priority');
//        $res6= $this->db->truncate('ticket_status');
//        $res6= $this->db->truncate('ticket_tag');
        if($res1 && $res2 && $res3 && $res4 && $res5 && $res6 && $res7 && $res8)
            return true;
        else
            return false;
    }
}
