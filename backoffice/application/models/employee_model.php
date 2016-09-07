<?php

class employee_model extends inf_model {

    public function __construct() {
        
    }

    public function confirmRegistration($reg_arr) {
        $result = "";
        $reg_arr1['ref_username'] = $reg_arr['ref_username'];
        $reg_arr1['pswd'] = $reg_arr['pswd'];
        $user_id = $this->updateEmployeeLogin($reg_arr1);

        if ($user_id != "") {
            $reg_arr['user_id'] = $user_id;
            $result = $this->updateEmployeeDetails($reg_arr);
        }
        return $result;
    }

    public function updateEmployeeLogin($reg_arr1) {
        $user_id = 0;
        $user_name = $reg_arr1['ref_username'];
        $password = md5($reg_arr1['pswd']);

        $this->db->set('user_name', $user_name);
        $this->db->set('password', $password);
        $this->db->set('user_type', "employee");
        $this->db->set('addedby', "code");
        $this->db->set('module_status', "m#24");
        $query1 = $this->db->insert('login_employee');

        if ($query1) {
            $this->db->select("user_id");
            $this->db->where("user_name", $user_name);
            $this->db->from("login_employee");
            $query2 = $this->db->get();

            foreach ($query2->result() as $row) {
                return $user_id = $row->user_id;
            }
        }
        return $user_id;
    }

    public function updateEmployeeDetails($reg_arr) {
        $first_name = $reg_arr['first_name'];
        $last_name = $reg_arr['last_name'];
        $mobile = $reg_arr['mobile'];
        $email = $reg_arr['email'];
        $user_id = $reg_arr['user_id'];

        $this->db->set("user_detail_refid", $user_id);
        $this->db->set("user_detail_name", $first_name);
        $this->db->set("user_detail_second_name", $last_name);
        $this->db->set("user_detail_mobile", $mobile);
        $this->db->set("user_detail_email", $email);
        $query = $this->db->insert("employee_details");
        return $query;
    }

    public function insertIntoUserPermission($arr_post) {
        if (!in_array("m#24", $arr_post)) {
            $len = count($arr_post);
            $arr_post[$len] = "m#24";
        }
        $rr = array_keys($arr_post);
        $module_permission = "";
        $user_name = $arr_post['user'];
        for ($i = 0; $i < count($arr_post); $i++) {
            if ($rr[$i] != "user" AND $rr[$i] != "permission") {
                $module_permission.= $arr_post[$rr[$i]] . ",";
            }
        }
        $module_permission = substr($module_permission, 0, strlen($module_permission) - 1);

        $this->db->set('module_status', $module_permission);
        $this->db->where('user_name', $user_name);
        $query = $this->db->update("login_employee");
        return $query;
    }

    public function viewPermission($user) {
        $permission = "";
        $this->db->select('module_status');
        $this->db->from("login_employee");
        $this->db->where('user_name', $user);
        $this->db->or_where('user_id', $user);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $permission = $row->module_status;
        }
        return $permission;
    }

    public function getMenuId() {
        $this->db->select('id');
        $this->db->where('perm_emp', 1);
        $this->db->where('status', 'yes');
        $this->db->order_by("main_order_id");
        $this->db->from("infinite_mlm_menu");
        $query = $this->db->get();
        return $query;
    }

    public function getMenuTextId($menu_id) {
        $link = "";
        $this->db->select('link_ref_id');
        $this->db->where('id', $menu_id);
        $this->db->from("infinite_mlm_menu");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $link = $row->link_ref_id;
        }
        return $link;
    }

    public function getsubMenuId($id) {

        $this->db->select('sub_id,sub_refid');
        $this->db->where("sub_refid ='$id' AND perm_emp = 1");
        $this->db->where('sub_status', 'yes');
        $this->db->order_by("sub_order_id");
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();
        return $query;
    }

    public function getSubmenuText($menu_id) {
        $sub_link = "";

        $this->db->select('sub_link_ref_id');
        $this->db->where('sub_id', $menu_id);
        $this->db->from("infinite_mlm_sub_menu");
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sub_link = $row->sub_link_ref_id;
        }
        return $sub_link;
    }

    public function getOtherId() {
        $this->db->select('id');
        $this->db->from("module_names");
        $query = $this->db->get();
        return $query;
    }

    public function getOtherLink($menu_id) {
        $arr = array();
        $this->db->select('module_name');
        $this->db->from("module_names");
        $this->db->where('id', $menu_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $arr = explode("/", $row->module_name);
        }
        return $arr;
    }

    public function getEmployeeDetails($letters) {
        $details = "";
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $letters);

        $this->db->select('user_id,user_name');
        $this->db->from("login_employee");
        $this->db->where("user_name LIKE '$letters%'");
        $this->db->where("emp_status", "yes");
        $this->db->order_by("user_id");
        $qry = $this->db->get();
        //echo $this->db->last_query();
        foreach ($qry->result_array() as $row) {

            $details .= $row['user_id'] . "###" . $row['user_name'] . "|";
        }

        return $details;
    }

    public function isUserValid($user_name) {
        $flag = FALSE;
        $this->db->where('user_name', $user_name);
        $this->db->from('login_employee');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            $flag = TRUE;
        }
        return $flag;
    }

    public function getDetails($keyword, $limit = '', $page = '') {
        $i = 0;
        $page_no = $page + 1;
        $detail = array();

        $this->db->select('*');
        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->select('ed.user_detail_name as user_detail_name');
        $this->db->select('ed.user_detail_mobile as user_detail_mobile');
        $this->db->select('ed.user_detail_second_name as user_detail_second_name');
        $this->db->select('ed.user_detail_email as user_detail_email');
        $this->db->from('login_employee as l');
        $this->db->join('employee_details as ed', 'ed.user_detail_id=l.user_id');
        $where = "(l.user_name LIKE '%$keyword%' OR ed.user_detail_name LIKE '%$keyword%' OR ed.user_detail_second_name LIKE '%$keyword%' OR ed.user_detail_email LIKE '%$keyword%' OR ed.user_detail_mobile LIKE '%$keyword%') AND l.emp_status= 'yes'";
        $this->db->where($where);
        $this->db->limit($limit, $page);

        $query = $this->db->get();
        if ($query->num_rows > 0) {
            foreach ($query->result_array() AS $row) {
                if ($row['emp_status'] == 'yes') {
                    $detail[$i]['page_no'] = $page_no;
                    $detail[$i]['user_name'] = $row['user_name'];
                    $detail[$i]['user_detail_name'] = $row['user_detail_name'];
                    $detail[$i]['user_detail_second_name'] = $row['user_detail_second_name'];
                    $detail[$i]['user_detail_email'] = $row['user_detail_email'];
                    $detail[$i]['user_id'] = $row['user_id'];
                    $detail[$i]['user_detail_mobile'] = $row['user_detail_mobile'];
                    $i++;
                    $page_no = $page_no + 1;
                }
            }
        }

        return $detail;
    }

    public function getCountMembers($keyword) {

        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->select('ed.user_detail_name as user_detail_name');
        $this->db->select('ed.user_detail_mobile as user_detail_mobile');
        $this->db->select('ed.user_detail_pin as user_detail_pin');
        $this->db->select('ed.user_detail_address as user_detail_address');
        $this->db->select('ed.user_detail_email as user_detail_email');
        $this->db->from('login_employee as l');
        $this->db->join('employee_details as ed', 'ed.user_detail_id=l.user_id');

        $where = "(l.user_name LIKE '%$keyword%' OR ed.user_detail_name LIKE '%$keyword%') AND l.emp_status= 'yes'";
        $this->db->where($where);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getEmployeDetails($limit = '', $page = '') {
        $detail = array();
        $i = 0;
        $page_no = $page + 1;

        $this->db->select('u.*');
        $this->db->select('l.user_name as user_name');
        $this->db->select('l.user_id as user_id');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("l.emp_status", 'yes');
        $this->db->limit($limit, $page);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            foreach ($query->result_array() as $row) {
                $detail[$i]['page_no'] = $page_no;
                $detail[$i]['user_detail_name'] = $row['user_detail_name'];
                $detail[$i]['user_detail_second_name'] = $row['user_detail_second_name'];
                $detail[$i]['user_detail_mobile'] = $row['user_detail_mobile'];
                $detail[$i]['user_detail_email'] = $row['user_detail_email'];
                $detail[$i]['user_detail_id'] = $row['user_detail_id'];
                $detail[$i]['user_name'] = $row['user_name'];
                $detail[$i]['user_id'] = $row['user_id'];
                $i++;
                $page_no = $page_no + 1;
            }
        }
        return $detail;
    }

    public function getEmployeeDetailsCount() {
        $this->db->select('count(*) as cnt');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("l.emp_status", 'yes');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function deleteEmployeeDetails($delete_id) {

        $this->db->set('emp_status', "no");
        $this->db->where('user_id', $delete_id);
        $query = $this->db->update('login_employee');
        return $query;
    }

    public function editEmployeeDetails($id) {
        $details = array();
        $i = 0;

        $this->db->select('u.*');
        $this->db->select('l.user_name as user_name');
        $this->db->from("employee_details as u");
        $this->db->join('login_employee as l', 'l.user_id=u.user_detail_id');
        $this->db->where("u.user_detail_id", $id);
        $query = $this->db->get();

        if ($query->num_rows > 0) {
            foreach ($query->result_array() as $row) {
                $details[] = $row;
            }
        }
        return $details;
    }

    public function updateContent($editdetails_id, $first_name, $last_name, $emp_mob, $email) {
        $this->db->set('user_detail_name', $first_name);
        $this->db->set('user_detail_second_name', $last_name);
        $this->db->set('user_detail_mobile', $emp_mob);
        $this->db->set('user_detail_email', $email);
        $this->db->where('user_detail_id', $editdetails_id);
        $result = $this->db->update("employee_details");
        return $result;
    }

    function updatePassword($new_pswd, $user_name) {

        $this->db->set('password', md5($new_pswd));
        $this->db->where('user_name', $user_name);
        $query = $this->db->update('login_employee');
        return $query;
    }

    function isUserNameAvailable($user_name) {
        $flag = false;
        $count = 0;

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("login_employee");
        $this->db->where('user_name', $user_name);
        $this->db->where('emp_status', 'yes');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function changeProfilePicture($id, $file_name) {
        $this->db->set('user_photo', $file_name);
        $this->db->where('user_detail_id', $id);
        $res = $this->db->update('employee_details');
        return $res;
    }

    public function getUserPhoto($id) {
        $this->db->select('user_photo');
        $this->db->from('employee_details');
        $this->db->where('user_detail_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->user_photo;
        }
    }

    public function getAllAssignedTickets($employee_id) {

        $this->load->model('ticket_model');
        $status = $this->ticket_model->getTicketStatusIdBasedOnStatus('Resolved');
        $details = array();
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('assignee_id', $employee_id);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['id'] = $row['id'];
            $details[$i]['ticket_id'] = $row['trackid'];
            $details[$i]['name'] = $row['name'];
            $details[$i]['subject'] = $row['subject'];
            $details[$i]['status'] = $this->ticket_model->getStatus($row['status']);
            $details[$i]['status_id'] = $row['status'];
            $details[$i]['last_replier_type'] = $row['last_replier_type'];
            if ($row['last_replier_type'] != "employee")
                $details[$i]['last_replier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            else {
                $details[$i]['last_replier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
            }
            $details[$i]['lastchange'] = $row['lastchange'];
            $details[$i]['priority'] = $this->ticket_model->getPriority($row['priority']);
            $details[$i]['category'] = $this->getCategory($row['category']);
            $details[$i]['read'] = $row['assignee_read_ticket'];

            $i++;
        }

        return $details;
    }

    public function getCategory($category_id) {
        $category = "";
        $this->db->select('category_name');
        $this->db->from('ticket_categories');
        $this->db->where('id', $category_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $category = $row->category_name;
        }
        return $category;
    }

    public function changeStatusToRead($ticket_id) {
        $date = date('Y-m-d H:i:s');
        $res = "";
        $this->db->set('assignee_read_ticket', "yes");
        $this->db->set('lastchange', $date);
        $this->db->where('trackid', $ticket_id);
        $res = $this->db->update('tickets');
        return $res;
    }

    public function getAllCategory() {
        $cat_arr = array();
        $this->db->select('id');
        $this->db->select('category_name');
        $this->db->from('ticket_categories');
        $this->db->where('status', 1);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr[$i]['cat_id'] = $row['id'];
            $cat_arr[$i]['cat_name'] = $row['category_name'];
            $i++;
        }
        return $cat_arr;
    }

    public function getAllStatus() {
        $cat_arr = array();
        $this->db->select('*');
        $this->db->where('active', 1);
        $this->db->from('ticket_status');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr[$i]['status_id'] = $row['id'];
            $cat_arr[$i]['status'] = $row['status'];
            $i++;
        }
        return $cat_arr;
    }

    public function getAllPriority() {
        $cat_arr = array();
        $this->db->select('*');
        $this->db->where('active', 1);
        $this->db->from('ticket_priority');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr[$i]['priority_id'] = $row['id'];
            $cat_arr[$i]['priority'] = $row['priority'];
            $i++;
        }
        return $cat_arr;
    }

    public function getAssignedTicketData($ticket_id, $employee_id) {
        $this->load->model('ticket_model');
        $ticket_arr = array();
        $this->db->select('*');
        $this->db->where('trackid', $ticket_id);
        $this->db->where('assignee_id', $employee_id);
        $this->db->from('tickets');
        $this->db->order_by('lastchange', 'desc');
        $res = $this->db->get();

        $i = 0;
        foreach ($res->result_array() as $row) {
            $ticket_arr["details$i"]['id'] = $row['id'];
            $ticket_arr["details$i"]['read'] = 1;
            $this->db->select('read');
            $this->db->where('replyto', $row['id']);
            $this->db->from('ticket_replies');
            $res1 = $this->db->get();
            foreach ($res1->result_array() as $row1) {
                // $ticket_arr["details$i"]['count']=$row1['cnt'];
                if ($row1['read'] == 0)
                    $ticket_arr["details$i"]['read'] = $row1['read'];
            }
            $ticket_arr["details$i"]['ticket_id'] = $row['trackid'];
            $ticket_arr["details$i"]['status'] = $this->getStatus($row['status']);
            $ticket_arr["details$i"]['created_date'] = $row['dt'];
            $ticket_arr["details$i"]['updated_date'] = $row['lastchange'];
            $ticket_arr["details$i"]['subject'] = $row['subject'];
            $ticket_arr["details$i"]['user'] = $this->validation_model->IdToUserName($row['user_id']);
            if ($row['last_replier_type'] != "employee")
                $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            else {
                $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
            }

            // $ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
            $ticket_arr["details$i"]['category'] = $this->getCategory($row['category']);
            $ticket_arr["details$i"]['priority'] = $row['priority'];
            $ticket_arr["details$i"]['priority_name'] = $this->ticket_model->getPriority($row['priority']);
            $ticket_arr["details$i"]['name'] = $row['name'];
            $i++;
        }

        return $ticket_arr;
    }

    public function getStatus($status_id) {
        $status = "";
        $this->db->select('status');
        $this->db->from('ticket_status');
        $this->db->where('id', $status_id);
        $this->db->where('active', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }
  public function getAllReplyByEmployee($ticket_id, $employee_id) {
        $details = array();
        
        $this->db->select('*');
        $this->db->order_by('id', 'asc');
        $this->db->from('ticket_replies');
        $this->db->where('replyto', $ticket_id);
        //$this->db->where('user_id', $employee_id);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['message'] = $row['message'];
            if ($row['reply_user_type']!= 'employee') {
                
                $details[$i]['profile_pic'] = $this->validation_model->getProfilePicture($row['user_id']);
            } else {
                $details[$i]['profile_pic'] = 'nophoto.jpg';
            }
            $details[$i]['profile_pic'] = 'nophoto.jpg';
            $details[$i]['date'] = $row['dt'];
            $details[$i]['file'] = $row['attachments'];
            $details[$i]['user'] = $this->validation_model->IdToUserName($row['user_id']);
            $details[$i]['user_id'] = $row['user_id'];
            $i++;
        }
        //print_r($details);die();
        return $details;
    }
    
     public function ticketCreatedBy($ticket_id){
        $user_id = "";
        $this->db->select('user_id');
        $this->db->where('trackid',$ticket_id);
        $this->db->from('tickets');
        $res = $this->db->get();
       
        foreach ($res->result() as $row) {
         $user_id = $row->user_id;
        }
        return $user_id; 
    }
}
