<?php
/**
 * @deprecated most likely do not used
 */
Class board_registersubmit_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    public function validateRegisterData($regr) {

        $this->MODULE_STATUS = $this->menu->MODULE_STATUS;

        $product_status = $this->MODULE_STATUS['product_status'];
        $pin_status = $this->MODULE_STATUS['pin_status'];

        $username = $regr['username'];
        $position = $regr['position'];
        $passcode = $regr['passcode'];
        $fatherid = $regr['fatherid'];
        $product_id = $regr['product_id'];
        $flag = true;
        //for pin avail
        if ($this->validation_model->isUserNameAvailable($username)) {
            $flag = false;
            echo "<script>alert('Error on registration. User already registered 69')</script>";
            $this->redirect("", "home", true);
        } else
        if (!$this->validation_model->isLegAvailable($fatherid, $position)) { // User already registered
            $flag = false;
            echo "<script>alert('Error on registration. User already registered in this position')</script>";
            $this->redirect("", "home", true);
        } else
        if ($product_status == 'yes') {
            
        }
        if ($pin_status == "yes") {
            if (!$this->validation_model->checkUserPin($passcode)) {
                $flag = false;
                echo "<script>alert('Error on registration. E-pin is already used')</script>";
                $this->redirect("", "home", true);
                
            }
        }
        return $flag;
    }

    public function updateLoginUser($username, $pwd, $id_up) {

        $data = array(
            'user_name' => $username,
            'password' => $pwd,
            'user_type' => 'distributor',
            'addedby' => 'code'
        );
        $this->db->where('user_id', $id_up);
        $result1 = $this->db->update('login_user', $data);
        //echo"<br/>lu qry>>>>" . $this->db->last_query();
        return $result1;
    }

    public function updateFTIndividual($father_id, $position, $username, $id_up, $order_id, $reg_by_using = '', $user_level = '', $product_id = '') {

        $time_now = date("Y-m-d H:i:s");

        if ($product_id == '') {
            $this->db->set('father_id', $father_id);
            $this->db->set('order_id', $order_id);
            $this->db->set('position', $position);
            $this->db->set('user_level', $user_level);
            $this->db->set('user_name', $username);
            $this->db->set('active', 'yes');
            $this->db->set('date_of_joining', $time_now);
            $this->db->set('register_by_using', $reg_by_using);
            $this->db->set('order_id', $order_id);
            $this->db->where('id', $id_up);
            $result = $this->db->update('ft_individual');
            $this->session->set_userdata('inf_active', 'yes');
        } else {
            $this->db->set('father_id', $father_id);
            $this->db->set('order_id', $order_id);
            $this->db->set('position', $position);
            $this->db->set('user_name', $username);
            $this->db->set('active', 'yes');
            $this->db->set('date_of_joining', $time_now);
            $this->db->set('product_id', $product_id);
            $this->db->set('user_level', $user_level);
            $this->db->set('register_by_using', $reg_by_using);
            $this->db->set('order_id', $order_id);
            $this->db->where('id', $id_up);
            $result = $this->db->update('ft_individual');
            $this->session->set_userdata('inf_active', 'yes');
        }
        //echo"<br/>qry>>>>" . $this->db->last_query();
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

    public function insertBalanceAmount($user_id) {

        $this->db->set('balance_amount', '0');
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert('user_balance_amount');
        return $result;
    }

    public function savePassCodes($user_id, $tran_code) {
        $this->db->set("user_id", $user_id);
        $this->db->set("tran_password", $tran_code);
        $res = $this->db->insert("tran_password");

        return $res;
    }

    public function getlastInsertId() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_user = $this->table_prefix . "login_user";
        $get_id = $this->selectData("SELECT MAX(user_id) as id FROM $login_user");
        $get_id = mysql_fetch_array($get_id);
        $id1 = $get_id['id'];
        return $id1;
    }

    public function tmpInsert($father_id, $newpos) {

        $user_name1 = $this->str_rand(5, 9);

        $user_name = $user_name1 . $father_id;

        return $this->insertInToFtIndividual($father_id, $newpos, $user_name);;
    }

    public function str_rand($minlength, $maxlength, $useupper = true, $usenumbers = true) {
        $key = "";
        $charset = "";
        if ($useupper)
            $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers)
            $charset .= "0123456789";
        if ($minlength > $maxlength)
            $length = mt_rand($maxlength, $minlength);
        else
            $length = mt_rand($minlength, $maxlength);
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        return $key;
    }

    public function insertInToFtIndividual($father_id, $position, $username) {
        $date = date("Y-m-d H:i:s");


        $data = array(
            'father_id' => $father_id,
            'position' => $position,
            'active' => 'server',
            'user_name' => $username,
        );

        $res = $this->db->insert('ft_individual', $data);
        $insert_id = $this->db->insert_id();


        $datas = array(
            'id' => $insert_id,
        );
        $result = $this->db->insert('leg_details', $datas);
        return $insert_id;
    }

    public function insertUserDetails($regr) {
        $flag = false;


        $data = array(
            'user_detail_refid' => $regr['userid'],
            'user_detail_name' => $regr['full_name'],
            'user_details_ref_user_id' => $regr['referral_id'],
            'user_detail_address' => $regr['address'],
            'user_detail_nominee' => $regr['nominee'],
            'user_detail_pan' => $regr['pan_no'],
            'user_detail_town' => $regr['town'],
            'user_detail_country' => $regr['country'],
            'user_detail_state' => $regr['state'],
            'user_detail_pin' => $regr['pin'],
            'user_detail_mobile' => $regr['mobile'],
            'user_detail_land' => $regr['land_line'],
            'user_detail_email' => $regr['email'],
            'user_detail_dob' => $regr['date_of_birth'],
            'user_detail_gender' => $regr['gender'],
            'join_date' => $regr['joining_date'],
            'user_detail_relation' => $regr['relation'],
            'user_detail_acnumber' => $regr['bank_acc_no'],
            'user_detail_ifsc' => $regr['ifsc'],
            'user_detail_nbank' => $regr['bank_name'],
            'user_detail_nbranch' => $regr['bank_branch']
        );

        $res = $this->db->insert('user_details', $data);
        if ($res > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function updateUserDetails($regr, $uid) {
        $flag = false;
        $this->db->where('user_detail_refid', $uid);

        $reg_update = array('user_detail_name' => $regr['full_name'],
            'user_detail_address' => $regr['address'],
            'user_detail_country' => $regr['country'],
            'user_detail_nric_no' => $regr['nric_no'],
            'user_detail_mobile' => $regr['mobile'],
            'user_detail_email' => $regr['email'],
            'user_detail_acnumber' => $regr['bank_acc_no'],
            'user_detail_nbank' => $regr['bank_name'],
            'user_detail_swift_code' => $regr['swift_code'],
            'user_detail_dob' => $regr['date_of_birth'],
            'user_detail_bank_code' => $regr['bank_code'],
            'user_detail_branch_code' => $regr['branch_code'],
            'user_detail_gender' => $regr['gender'],
        );
        $reg_res = $this->db->update('user_details', $reg_update);
        if ($reg_res) {
            $flag = true;
        }

        return $flag;
    }

    public function insertInToLoginUser($id) {

        $pwd = "";
        $pwd = md5($pwd);

        $data = array(
            'user_id' => $id,
            'user_name' => 'InfiniteMLM' . $id,
            'password' => $pwd,
            'addedby' => 'server',
        );

        $result = $this->db->insert('login_user', $data);
        //echo"<br/luysr qry>>>>" . $this->db->last_query();
        return $result;
    }

    public function viewProducts() {
        require_once 'Product.php';
        $obj_product = new Product();
        $obj_product->getAllProducts('yes');

        echo "<option value='' selected='selected'>Select Product</option>";
        for ($i = 0; $i < count($obj_product->product_detail); $i++) {
            $id = $obj_product->product_detail["details$i"]["id"];
            $product_name = $obj_product->product_detail["details$i"]["name"];
            echo "<option value='$id' >$product_name</option>";
        }
    }


    public function updatePinNumber($pin_no, $user_name = '') {
        if ($user_name == '') {

            $this->db->set('status', 'no');
            $this->db->where('pin_numbers', $pin_no);
            $result = $this->db->update('pin_numbers');
        } else {

            $date = date('Y-m-d');
            $this->db->set('status', 'no');
            $this->db->set('pin_alloc_date', $date);
            $this->db->set('used_user', $user_name);
            $this->db->where('pin_numbers', $pin_no);
            $result = $this->db->update('pin_numbers');
        }
        //echo"<br/>upin qry>>>>" . $this->db->last_query();
        return $result;
    }

    public function getLevel($id) {
        $user_level = '';
        $this->db->select("user_level");
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_level = $row->user_level;
        }
        return $user_level;
    }

    public function getMaxOrderID() {

        $this->db->select_max('order_id', 'order_id');
        $this->db->from('ft_individual');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_order_id = $row->order_id;
        }
        return $max_order_id;
    }

    public function getUsername() {

        $config = $this->getUsernameConfig();
        $length = $config["length"];
        $u_name = $this->getRandId($length);
        if ($config["prefix_status"] == "yes") {
            $prefix = $config["prefix"];
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
        $key = "";
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;

        $this->db->select("*");
        $this->db->from("tran_password");
        $this->db->where('tran_password', $randum_id);
        $qr = $this->db->get();
        $count = $qr->num_rows();

        if (!$count)
            return $key;
        else
            $this->getRandTransPasscode($length);
    }

}
