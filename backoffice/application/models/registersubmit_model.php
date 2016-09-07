<?php

Class registersubmit_model extends inf_model {

    public $obj_module;

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('configuration_model');
    }

    public function insertLoginUser($user_id, $username, $password) {
        $data = array(
            'user_id' => $user_id,
            'user_name' => $username,
            'password' => md5($password),
            'user_type' => 'distributor',
            'addedby' => 'code'
        );
        $query = $this->db->insert('login_user', $data);
        return $query;
    }

    public function updateFTIndividual($father_id, $sponsor_id, $position, $username, $user_id, $order_id = 'NA', $reg_by_using = 'NA', $user_level = 'NA', $product_id = '0', $date = '', $customer_id = '') {
        if ($date == '') {
            $date = date('Y-m-d H:i:s');
        }
        $left_father = $this->getUserLeftValue($father_id, 'father');
        $right_father = $left_father + 1;


        $left_sponsor = $this->getUserLeftValue($sponsor_id, 'sponsor');
        $right_sponsor = $left_sponsor + 1;

        $product_id = 1;

        $this->db->set('father_id', $father_id);
        $this->db->set('order_id', $order_id);
        $this->db->set('position', $position);
        $this->db->set('user_name', $username);
        $this->db->set('active', 'yes');
        $this->db->set('user_level', $user_level);
        $this->db->set('register_by_using', $reg_by_using);
        $this->db->set('sponsor_id', $sponsor_id);
        $this->db->set('date_of_joining', $date);
        $this->db->set('left_father', $left_father);
        $this->db->set('right_father', $right_father);
        $this->db->set('left_sponsor', $left_sponsor);
        $this->db->set('right_sponsor', $right_sponsor);

        if ($product_id != '') {
            $this->db->set('product_id', $product_id);
        }
        if ($customer_id != '') {
            $this->db->set('oc_customer_ref_id', $customer_id);
        }
        $this->db->where('id', $user_id);
        $query = $this->db->update('ft_individual');
        return $query;
    }

    public function insertBalanceAmount($user_id) {
        $this->db->set('balance_amount', '0');
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert('user_balance_amount');
        return $result;
    }

    public function savePassCodes($user_id, $tran_code) {
        $this->db->set('user_id', $user_id);
        $this->db->set('tran_password', $tran_code);
        $res = $this->db->insert('tran_password');
        return $res;
    }

    public function tmpInsert($father_id, $new_position) {
        $user_name1 = $this->str_rand(5, 9);
        $user_name = $user_name1 . $father_id;
        return $this->insertInToFtIndividual($father_id, $new_position, $user_name);
    }

    public function insertInToFtIndividual($father_id, $position, $username) {
        $MODULE_STATUS = $this->trackModule();
        $mlm_plan = $MODULE_STATUS["mlm_plan"];

        $next_order_id = $this->getMaxOrderID() + 1;
        $data = array(
            'father_id' => $father_id,
            'position' => $position,
            'active' => 'server',
            'user_name' => $username,
            'order_id' => $next_order_id,
            'oc_customer_ref_id' => '0',
            'sponsor_id' => '0',
        );
        $res = $this->db->insert('ft_individual', $data);
        $insert_id = $this->db->insert_id();

        if ($mlm_plan == "Binary") {
            $data = array(
                'id' => $insert_id,
            );
            $result = $this->db->insert('leg_details', $data);
        }

        return $insert_id;
    }

    public function str_rand($minlength, $maxlength, $useupper = true, $usenumbers = true) {
        $key = '';
        $charset = '';
        if ($useupper)
            $charset .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($usenumbers)
            $charset .= '0123456789';
        if ($minlength > $maxlength)
            $length = mt_rand($maxlength, $minlength);
        else
            $length = mt_rand($minlength, $maxlength);
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        return $key;
    }

    public function insertUserDetails($regr) {
        $flag = false;
        $data = array(
            'user_detail_refid' => $regr['userid'],
            'user_details_ref_user_id' => $regr['sponsor_id'],
//            'user_detail_name' => $regr['first_name'],
//            'user_detail_second_name' => $regr['last_name'],
//            'user_detail_gender' => $regr['gender'],
//            'user_detail_dob' => $regr['date_of_birth'],
//            'user_detail_address' => $regr['address'],
//            'user_detail_address2' => $regr['address_line2'],
//            'user_detail_pin' => $regr['pin'],
            'user_detail_country' => $regr['country'],
//            'user_detail_state' => ($regr['state']!='')?$regr['state']:0,
//            'user_detail_city' => $regr['city'],
            'user_detail_email' => $regr['email'],
//            'user_detail_land' => $regr['land_line'],
//            'user_detail_mobile' => $regr['mobile'],
//            'user_detail_nbank' => $regr['bank_name'],
//            'user_detail_nbranch' => $regr['bank_branch'],
//            'user_detail_acnumber' => $regr['bank_acc_no'],
//            'user_detail_ifsc' => $regr['ifsc'],
//            'user_detail_pan' => $regr['pan_no'],
            'join_date' => $regr['joining_date'],
            'user_detail_second_name' =>'',
        );
        $res = $this->db->insert('user_details', $data);
        if ($res) {
            if ($regr['userid'] != '') {
                $user_id = $regr['userid'];
            } else {
                $user_id = $regr['sponsor_id'];
            }
            $serialized_data = serialize($data);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'new user registered', $regr['userid'], $serialized_data);
            $flag = true;
        }
        return $flag;
    }

    public function updateUserDetails($regr, $uid) {
        $flag = false;
        $this->db->where('user_detail_refid', $uid);
        $reg_update = array('user_detail_name' => $regr['full_name'],
            'user_detail_second_name' => $regr['second_name'],
            'user_detail_address' => $regr['address'],
            'user_detail_address2' => $regr['address_line2'],
            'user_detail_country' => $regr['country'],
            'user_detail_state' => $regr['state'],
            'user_detail_city' => $regr['city'],
            'user_detail_mobile' => $regr['mobile'],
            'user_detail_land' => $regr['land_line'],
            'user_detail_email' => $regr['email'],
            'user_detail_pin' => $regr['pin'],
            'user_detail_acnumber' => $regr['bank_acc_no'],
            'user_detail_ifsc' => $regr['ifsc'],
            'user_detail_nbank' => $regr['bank_name'],
            'user_detail_nbranch' => $regr['bank_branch'],
            //'user_detail_pan' => $regr['pan_no'],
            'user_detail_dob' => $regr['date_of_birth'],
            'user_detail_gender' => $regr['gender'],
            'user_detail_facebook' => $regr['facebook'],
            'user_detail_twitter' => $regr['twitter'],
            'passport_id' => $regr['passport_id'],
            'id_expire' => $regr['id_expire'],
            'user_detail_bank_country' => $regr['bank_country'],
            'tax_id' => $regr['tax_id'],
            'tax_number' => $regr['tax_number'],
        );

        $reg_res = $this->db->update('user_details', $reg_update);
        if ($reg_res) {
            $flag = true;
        }
        return $flag;
    }

    public function insertInToLoginUser($id) {
        $pwd = '';
        $pwd = md5($pwd);
        $data = array(
            'user_id' => $id,
            'user_name' => 'InfiniteMLM' . $id,
            'password' => $pwd,
            'addedby' => 'server',
        );
        $result = $this->db->insert('login_user', $data);
        return $result;
    }

    public function getMaxOrderID() {
        $max_order_id = 0;
        $this->db->select_max('order_id', 'order_id');
        $this->db->where('active !=', 'server');
        $this->db->from('ft_individual');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_order_id = $row->order_id;
        }
        return $max_order_id;
    }

    public function getUsername() {

        $config = $this->configuration_model->getUsernameConfig();
        $length = $config['length'];
        $u_name = $this->getRandId($length);
        if ($config['prefix_status'] == 'yes') {
            $prefix = $config['prefix'];
            $u_name = $prefix . $u_name;
        }
        return $u_name;
    }

    public function getUsernameConfig() {
        $query = $this->db->get('username_config');
        foreach ($query->result_array() as $row) {
            $config["length"] = $row["length"];
            $config["prefix_status"] = $row["prefix_status"];
            $config["prefix"] = $row["prefix"];
        }
        return $config;
    }

    public function getLevel($id) {
        $this->db->select('user_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_level = $row->user_level;
        }
        return $user_level;
    }

    public function getRandId($length) {

        $key = "";
        $charset = "0123456789";
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;



        $config = $this->getUsernameConfig();
        if ($config["prefix_status"] == "yes") {

            $prefix = $config["prefix"];
            $randum_id = $prefix . $randum_id;
        }

        $this->db->select('*');
        $this->db->from('login_user');
        $this->db->where('user_name', $randum_id);
        $query = $this->db->get();
        $count = $query->num_rows();
        if ($count == 0)
            return $key;
        else
            $this->getRandId($length);
    }

    public function getRandTransPasscode($length) {
        $key = '';
        $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;

        $this->db->select('*');
        $this->db->from('tran_password');
        $this->db->where('tran_password', $randum_id);
        $qr = $this->db->get();
        $count = $qr->num_rows();
        if (!$count)
            return $key;
        else
            $this->getRandTransPasscode($length);
    }

    public function insertUserActivity($login_id, $activity, $done_by) {

        $date = date('Y-m-d H:i:s');
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $this->db->set('user_id', $login_id);
        $this->db->set('activity', $activity);
        $this->db->set('done_by', $done_by);
        $this->db->set('ip', $ip_adress);
        $this->db->set('date', $date);
        $result = $this->db->insert('activity_history');
        return $result;
    }

    public function getNewPositionOfUser($user_id) {
        $this->db->select_max('position', 'new_position');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $new_position = $row->new_position;
        }

        return $new_position;
    }

    public function isUserLevelFull($father_id, $width_ceiling) {

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("ft_individual");
        $this->db->where('father_id', $father_id);
        $qr = $this->db->get();

        foreach ($qr->result() as $row) {
            $cnt = $row->cnt;
        }
        $current_users = $cnt;
        if ($current_users >= $width_ceiling) {
            $flag = true;
        } else {
            $flag = false;
        }

        return $flag;
    }

    public function insertToUnilevelTree($regr, $unilevel_arr) {


        $data = array(
            'id' => $regr['userid'],
            'user_name' => $regr['username'],
            'father_id' => $regr['referral_id'],
            'order_id' => $unilevel_arr['order_id'],
            'active' => 'yes',
            'position' => $unilevel_arr['position'],
            'product_id' => $regr['product_id'],
            'user_level' => $unilevel_arr['user_level'],
            'date_of_joining' => $regr['joining_date']
        );
        $res = $this->db->insert('ft_individual_unilevel', $data);
        return $res;
    }

    public function getUserLeftValue($father_id, $postfix_variable) {
        $left = "left_" . $postfix_variable;
        $right = "right_" . $postfix_variable;
        $this->db->select("$left, $right");
        $this->db->where('id', $father_id);
        $result = $this->db->get('ft_individual');
        $result = $result->result_array();


        $difference = $result['0']["$right"] - $result['0'][$left];
        if ($difference > 1) {
            $predecessor = $this->getRightMostChild($father_id, $postfix_variable);
            $position = $right;
        } else {
            $predecessor = $father_id;
            $position = $left;
        }
        $predecessor_value = $this->getPredecessorValue($predecessor, $position, $postfix_variable);
        $user_left = $predecessor_value + 1;
        return $user_left;
    }

    public function getPredecessorValue($predecessor, $position, $postfix_variable) {
        $this->db->select("$position");
        $this->db->where('id', $predecessor);
        $result = $this->db->get('ft_individual');
        $result = $result->result_array();
        $predecessor_value = $result[0]["$position"];

        $count = 2;
        $right = "right_" . $postfix_variable;
        $left = "left_" . $postfix_variable;
        $this->db->query("UPDATE `" . $this->db->dbprefix . "ft_individual` SET `$right` = `$right` + $count WHERE `$right` > '$predecessor_value'");

        $this->db->query("UPDATE `" . $this->db->dbprefix . "ft_individual` SET `$left` = `$left` + $count WHERE `$left` > '$predecessor_value'");

        return $predecessor_value;
    }

    public function getRightMostChild($id, $postfix_variable) {
        $right = "right_" . $postfix_variable;
        $user_field = $postfix_variable . "_id";
        $this->db->select('id');
        $this->db->where("$user_field", $id);
        $this->db->order_by("$right", 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('ft_individual');
        $result = $result->result_array();

        return $result[0]['id'];
    }

}
