<?php



class password_model extends inf_model {

    public function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
        $this->load->model('profile_class_model');
    }

    public function isUserNameAvailable($user_name) {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function selectPassword($id, $user_type = '') {
        $this->db->select('password');
        $this->db->from('login_user');
        $this->db->where('user_id', $id);
        $this->db->where('addedby !=', 'server');
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $dbpassword = $row['password'];
        }
        $cnt = $res->num_rows();
        $pass_arr['dbpassword'] = $dbpassword;
        $pass_arr['cnt'] = $cnt;
        return $pass_arr;
    }

    public function updatePassword($new_pwd, $id = "", $user_name = "", $user_type = "", $user_ref_id = "", $table_prefix = "") {
        if ($user_name != "") {
            $id = $this->validation_model->userNameToID($user_name);
        }
        $this->db->set('password', $new_pwd);
        $this->db->where('user_id', $id);
        $res = $this->db->update($table_prefix . 'login_user');
        return $res;
    }


    public function getPassword($user_id) {
        $this->db->select('password');
        $this->db->from('login_user');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $dbpassword = $row['password'];
        }
        return $dbpassword;
    }

    public function getLetterSetting() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $letter_config = $this->table_prefix . "letter_config";

        $qr = "SELECT * FROM $letter_config";
        $res = $this->selectData($qr, "ERROR ON SELECTING LETTER-21324537522222222");
        while ($row = mysql_fetch_array($res)) {
            $arr['company_name'] = $row['company_name'];
            $arr['address_of_company'] = $row['address_of_company'];
            $arr['main_matter'] = $row['main_matter'];
            $arr['logo'] = $row['logo'];
            $arr['productmatter'] = $row['productmatter'];
            $arr['place'] = $row['place'];
        }
        return $arr;
    }

    //----------------------------------------------------
}
