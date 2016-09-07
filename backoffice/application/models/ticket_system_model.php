<?php

class ticket_system_model extends Inf_Model {

    public function __construct() {
        parent::__construct();

        $this->load->model('ticket_model') ;
//        $this->obj_tckt = new ticket_model();
      
    }

    public function getTicketPriorityList($id = '') {

        $status = array();
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->limit(1);
        }
//        $this->db->where('active', 1);
        $query = $this->db->get('ticket_priority');

        foreach ($query->result_array() as $row) {
            $status[] = $row;
        }
        return $status;
    }

    public function getTicketTagList($id = '') {

        $status = array();
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->limit(1);
        }
//        $this->db->where('active', 1);
        $query = $this->db->get('ticket_tag');

        foreach ($query->result_array() as $row) {
            $status[] = $row;
        }
        return $status;
    }

    public function getTicketStatusList($id = '') {

        $status = array();
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->limit(1);
        }
//        $this->db->where('active', 1);
        $query = $this->db->get('ticket_status');

        foreach ($query->result_array() as $row) {
            $status[] = $row;
        }
        return $status;
    }

    public function getCategoryList($id = '') {
        $total_tickets = $this->getTotalTickets();

        $category = array();
        if ($id != '') {
            $this->db->where('id', $id);
            $this->db->limit(1);
        }
//        $this->db->where('status', 1);
        $query = $this->db->get('ticket_categories');

        foreach ($query->result_array() as $row) {
            if ($total_tickets != 0) {
                $row['ticket_per'] = $row['ticket_count'] * 100 / $total_tickets;
            } else {
                $row['ticket_per'] = 0;
            }

            $category[] = $row;
        }
        return $category;
    }

    public function getTotalTickets() {

        $ticket_count = 0;
        $this->db->select_sum('ticket_count');
        $this->db->where('status', 1);
        $query = $this->db->get('ticket_categories');

        if ($query->num_rows() > 0) {
            $ticket_count = $query->row()->ticket_count;
        }
        return $ticket_count;
    }

    public function deleteFAQ($id) {
        $this->db->where('id', $id);
        $this->db->delete('ticket_faq');
        return $this->db->affected_rows();
    }

    public function deleteCategory($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_categories', array('status' => 0));
        return $this->db->affected_rows();
    }
    public function activateCategory($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_categories', array('status' => 1));
        return $this->db->affected_rows();
    }

    public function deleteStatus($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_status', array('active' => 0));
        return $this->db->affected_rows();
    }
    public function activateStatus($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_status', array('active' => 1));
        return $this->db->affected_rows();
    }

    public function deleteTag($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_tag', array('active' => 0));
        return $this->db->affected_rows();
    }
    public function activateTag($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_tag', array('active' => 1));
        return $this->db->affected_rows();
    }

    public function deletePriority($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_priority', array('active' => 0));
        return $this->db->affected_rows();
    }
    public function activatePriority($id) {
        $this->db->where('id', $id);
        $this->db->update('ticket_priority', array('active' => 1));
        return $this->db->affected_rows();
    }

    public function insertCategory($name,$emp_id) {

        $this->db->set('category_name', $name);
        $this->db->set('assignee_id', $emp_id);
        $this->db->set('ticket_count', 0);
        $this->db->set('status', 1);
        $this->db->insert('ticket_categories');
        return $this->db->insert_id();
    }

    public function insertFAQ($category, $question, $answer) {

        $this->db->set('question', $question);
        $this->db->set('answer', $answer);
        $this->db->set('cateory', $category);
        $this->db->set('status', 1);
        $this->db->insert('ticket_faq');
        return $this->db->insert_id();
    }

    public function getFAQDetails() {
        $data = array();
        $res = $this->db->get('ticket_faq');

        foreach ($res->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    public function updateCategory($name, $id,$emp_id) {

        $this->db->set('category_name', $name);
        $this->db->set('ticket_count', 0);
        $this->db->set('assignee_id', $emp_id);
        $this->db->set('status', 1);
        $this->db->where('id', $id);
        $this->db->update('ticket_categories');
        return $this->db->affected_rows();
    }

    public function insertStatus($name) {

        $ql = $this->db->select('id')->from('ticket_status')->where('status', $name)->get();
        $data = array('status' => $name, 'active' => 1);
        if ($ql->num_rows() > 0) {
            $id = $ql->row()->id;

            $this->db->where('id', $id);
            $this->db->update('ticket_status', $data);
            return $this->db->affected_rows();
        } else {

            $this->db->insert('ticket_status',$data);
            return $this->db->insert_id();
        }
    }

    public function insertTag($name) {

        $ql = $this->db->select('id')->from('ticket_tag')->where('tag', $name)->get();
        $data = array('tag' => $name, 'active' => 1);

        if ($ql->num_rows() > 0) {
            $id = $ql->row()->id;

            $this->db->where('id', $id);
            $this->db->update('ticket_tag', $data);
            return $this->db->affected_rows();
        } else {
            $this->db->insert('ticket_tag', $data);
            return $this->db->insert_id();
        }
    }

    public function insertPriority($name) {

        $ql = $this->db->select('id')->from('ticket_priority')->where('priority', $name)->get();
        $data = array('priority' => $name, 'active' => 1);

        if ($ql->num_rows() > 0) {
            $id = $ql->row()->id;

            $this->db->where('id', $id);
            $this->db->update('ticket_priority', $data);
            return $this->db->affected_rows();
        } else {
            $this->db->insert('ticket_priority', $data);
            return $this->db->insert_id();
        }
    }

    public function showTickets($category_id = '', $tag_id = '', $limit = '10', $start = '0') {
        $date = date('Y-m-d H:i:s');
        $details = array();

        if ($category_id != '' && $tag_id != '') {
            $this->db->where('category', $category_id);
            $this->db->like('tags', $tag_id);
        } elseif ($category_id != '') {
            $this->db->where('category', $category_id);
        } elseif ($tag_id != '') {
            $this->db->like('tags', $tag_id);
        }

        $this->db->limit($limit, $start);
        $res = $this->db->get('tickets');
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['ticket_id'] = $row['trackid'];
            $details[$i]['name'] = $row['name'];
            $details[$i]['subject'] = $row['subject'];
            $details[$i]['status'] = $this->getStatus($row['status']);
            $details[$i]['status_id'] = $row['status'];
            $details[$i]['lastchange'] = $row['lastchange'];
            $details[$i]['priority'] = $row['priority'];
            $details[$i]['priority_name'] = $this->getPriorityName($row['priority']);
            $details[$i]['flag'] = $this->getPriorityFlag($row['priority']);
            $details[$i]['category'] = $row['category'];
            $details[$i]['category_name'] = $this->getCategory($row['category']);

            if ($row['last_replier_type'] != "employee")
                $details[$i]['last_replier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            else {
                $details[$i]['last_replier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
            }
            $date1 = date_create($row['lastchange']);
            $date2 = date_create($date);
            $diff = date_diff($date1, $date2);

            if (($diff->format("%d")) == 0) {
                $details[$i]['updated'] = $diff->format("%hh") . '' . $diff->format("%im");
            } else {
                $details[$i]['updated'] = $diff->format("%d days");
            }
            $i++;
        }
        return $details;
    }

    public function showTicketsCount($category_id = '', $tag_id = '') {

        if ($category_id != '' && $tag_id != '') {
            $this->db->where('category', $category_id);
            $this->db->like('tags', $tag_id);
        } elseif ($category_id != '') {
            $this->db->where('category', $category_id);
        } elseif ($tag_id != '') {
            $this->db->like('tags', $tag_id);
        }
        $query = $this->db->get('tickets');
        return $query->num_rows();
    }

    public function getAllUnresolvedTickets($limit = '10', $start = '0') {

        $status = $this->ticket_model->getTicketStatusIdBasedOnStatus('Resolved');
        $date = date('Y-m-d H:i:s');
        $details = array();
       // $this->db->where('status !=', $status);
        $this->db->limit($limit, $start);
        $this->db->order_by('lastchange', 'desc');
        $res = $this->db->get('tickets');
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['ticket_id'] = $row['trackid'];
            $details[$i]['name'] = $row['name'];
            if ($row['assignee_name'] == "")
                $details[$i]['assignee_name'] = "admin";
            else
                $details[$i]['assignee_name'] = $row['assignee_name'];
            $details[$i]['subject'] = $row['subject'];
            $details[$i]['status'] = $this->getStatus($row['status']);
            $details[$i]['status_id'] = $row['status'];
            if ($row['last_replier_type'] != "employee")
                $details[$i]['last_replier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            else {
                $details[$i]['last_replier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
            }

            $details[$i]['lastchange'] = $row['lastchange'];
            $details[$i]['priority'] = $row['priority'];
            $details[$i]['priority_name'] = $this->getPriorityName($row['priority']);
            $details[$i]['flag'] = $this->getPriorityFlag($row['priority']);
            $details[$i]['category'] = $row['category'];
            $details[$i]['category_name'] = $this->getCategory($row['category']);
            $date1 = date_create($row['lastchange']);
            $date2 = date_create($date);
            $diff = date_diff($date1, $date2);

            if (($diff->format("%d")) == 0) {
                $details[$i]['updated'] = $diff->format("%hh") . '' . $diff->format("%im");
            } else {
                $details[$i]['updated'] = $diff->format("%d days");
            }
            $i++;
        }
        return $details;
    }

    public function showResolvedTicketsCount() {

        $status = $this->ticket_model->getTicketStatusIdBasedOnStatus('Resolved');
        $this->db->where('status !=', $status);
        $query = $this->db->get('tickets');
        return $query->num_rows();
    }

    public function getPriorityFlag($priority_id) {
        $flag_img = "";
        $this->db->select('flag_img');
        $this->db->from('ticket_priority');
        $this->db->where('id', $priority_id);
        $this->db->where('active', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $flag_img = $row->flag_img;
        }
        return $flag_img;
    }

    public function getPriorityName($priority_id) {
        $flag_img = "";
        $this->db->select('priority');
        $this->db->from('ticket_priority');
        $this->db->where('id', $priority_id);
        $this->db->where('active', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $flag_img = $row->priority;
        }
        return $flag_img;
    }

    public function getEmployeeID($employee_name) {
        $employee_id = "";
        $this->db->select('user_id');
        $this->db->from('login_employee');
        $this->db->where('user_name', $employee_name);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $employee_id = $row->user_id;
        }
        return $employee_id;
    }

    public function getEmployeeName($employee_id) {
        $employee_name = "";
        $this->db->select('user_name');
        $this->db->from('login_employee');
        $this->db->where('user_id', $employee_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $employee_name = $row->user_name;
        }
        return $employee_name;
    }

    public function assignTicketToEmployee($ticket, $employee_id) {
        $res = "";
        $employee_name = $this->getEmployeeName($employee_id);
        $this->db->set('assignee_id', $employee_id);
        $this->db->set('assignee_name', $employee_name);
        $this->db->set('assignee_read_ticket', "no");
        
        $this->db->limit(1);
        $this->db->where('id', $ticket);
        $res = $this->db->update('tickets');
        if ($this->db->affected_rows()) {
            return $employee_name;
        } else {
            return NULL;
        }

        return $res;
    }

    public function isEmployeeNameValid($employee_name) {
        $employee_id = "";
        $this->db->select('user_id');
        $this->db->from('login_employee');
        $this->db->where('user_name', $employee_name);
        $res = $this->db->get();
        $count = $res->num_rows();

        return $count;
    }

    public function getCategory($id) {
        $category_name = "";
        $this->db->select('category_name');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->from('ticket_categories');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $category_name = $res->row()->category_name;
        }

        return $category_name;
    }

    public function getAllTicketCategory() {
        $category_name = array();
        $this->db->select('category_name,id');
        $this->db->where('status', 1);
        $res = $this->db->get('ticket_categories');
        foreach ($res->result_array() as $row) {
            $category_name[] = $row;
        }

        return $category_name;
    }

    public function getPriority($id) {
        $priority_name = "";
        $this->db->select('priority');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->from('ticket_priority');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $priority_name = $res->row()->priority;
        }

        return $priority_name;
    }

    public function getAllTicketPriority() {
        $priority_name = array();
        $this->db->select('priority,id');
        $this->db->where('active', 1);
        $res = $this->db->get('ticket_priority');
        foreach ($res->result_array() as $row) {
            $priority_name[] = $row;
        }

        return $priority_name;
    }

    public function getStatus($id) {
        $status_name = "";
        $this->db->select('status');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->from('ticket_status');
        $res = $this->db->get();

        if ($res->num_rows() > 0) {
            $status_name = $res->row()->status;
        }

        return $status_name;
    }

    public function changeTicketStatus($id, $option) {


        $status_name = $this->getStatus($option);
        $this->db->set('status', $option);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('tickets');
        if ($this->db->affected_rows()) {
            return $status_name;
        } else {
            return NULL;
        }
    }

    public function changeTicketCategory($id, $option) {


        $category_name = $this->getCategory($option);
        $this->db->set('category', $option);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('tickets');
        if ($this->db->affected_rows()) {
            return $category_name;
        } else {
            return NULL;
        }
    }

    public function changeTicketPriority($id, $option) {


        $priority_name = $this->getPriority($option);
        $this->db->set('priority', $option);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('tickets');
        if ($this->db->affected_rows()) {
            return $priority_name;
        } else {
            return NULL;
        }
    }

    public function changeTicketTag($id, $option) {
        $this->db->set('tags', $option);
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->update('tickets');
//        if($this->db->affected_rows()){
        return TRUE;
//        }else{
//            return NULL;
//        }
    }

    public function getAllTicketStatus() {
        $status_name = array();
        $this->db->select('id,status');
        $this->db->where('active', 1);
        $res = $this->db->get('ticket_status');
        foreach ($res->result_array() as $row) {
            $status_name[] = $row;
        }
        return $status_name;
    }

    public function getTicketTags() {
        $tag = array();
        $this->db->select('id,tag');
        $this->db->where('active', 1);
        $res = $this->db->get('ticket_tag');
        foreach ($res->result_array() as $row) {
            $tag[] = $row;
        }
        return $tag;
    }
    public function getTag($id){
        
        $tag = "";
        $this->db->select('tag');
        $this->db->where('id', $id);
        $this->db->from('ticket_tag');
        $res = $this->db->get();
       
        foreach ($res->result() as $row) {
            $tag = $row->tag;
        }
        return $tag;
    }
    public function getAllTicketTags() {
        $tag_name = array();
        $this->db->select('tag');
        $this->db->where('active', 1);
        $res = $this->db->get('ticket_tag');
        foreach ($res->result_array() as $row) {
            array_push($tag_name, $row['tag']);
        }

        return $tag_name;
    }

    public function getTicketReplies($id) {
        $data = array();
        $this->db->where('replyto', $id);
        $res = $this->db->get('ticket_replies');
        foreach ($res->result_array() as $row) {
            if ($row['reply_user_type'] != 'employee') {
                $row['profile_pic'] = $this->validation_model->getProfilePicture($row['user_id']);
            } else {
                $row['profile_pic'] = 'nophoto.jpg';
            }
            $data[] = $row;
        }
        return $data;
    }

    public function getTicketId($id) {
        $ticket_id = '';
        $this->db->select('id');
        $this->db->where('trackid', $id);
        $res = $this->db->get('tickets');
        if ($res->num_rows() > 0) {
            $ticket_id = $res->row()->id;
        }
        return $ticket_id;
    }

    public function getTotalTicketCount() {
        $res = $this->db->get('tickets');
        return $res->num_rows();
    }

    public function getResolvedTickets() {
        $this->db->where('status', 3);
        $res = $this->db->get('tickets');
        return $res->num_rows();
    }

    public function getInprogressTickets() {
        $this->db->where('status', 2);
        $res = $this->db->get('tickets');
        return $res->num_rows();
    }

    public function getCriticalTickets() {
        $this->db->where('priority', 3);
        $res = $this->db->get('tickets');
        return $res->num_rows();
    }

    public function getNewTickets() {
        $this->db->where('status', 1);
        $res = $this->db->get('tickets');
        return $res->num_rows();
    }

    public function getAssignee($id) {
        $assignee = "";
        $this->db->select('assignee');
        $this->db->where('ticket_id', $id);
        $this->db->limit(1);
        $this->db->from('ticket_assignee');
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            $assignee = $res->row()->assignee;
        }
        return $assignee;
    }

    public function getTicketData($ticket_id = '') {

        $ticket_arr = array();
        $this->db->where('trackid', $ticket_id);
        $this->db->limit(1);
        $this->db->from('tickets');
        $this->db->order_by('lastchange', 'desc');
        $res = $this->db->get();


        foreach ($res->result_array() as $row) {
            $ticket_arr['id'] = $row['id'];
            $ticket_arr['ticket_id'] = $row['trackid'];
            $ticket_arr['created_date'] = $row['dt'];
            $ticket_arr['updated_date'] = $row['lastchange'];
            $ticket_arr['subject'] = $row['subject'];
            $ticket_arr['message'] = $row['message'];
            $ticket_arr['attachments'] = $row['attachments'];
            $ticket_arr['tags'] = $row['tags'];
            $ticket_arr['user'] = $this->validation_model->IdToUserName($row['user_id']);
            $ticket_arr['user_id'] = $row['user_id'];
            $ticket_arr['lastreplier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            $ticket_arr['status'] = $this->getStatus($row['status']);
            $ticket_arr['category'] = $this->getCategory($row['category']);
            $ticket_arr['priority'] = $this->getPriority($row['priority']);
            $ticket_arr['assignee'] = $row['assignee_name'];
//            $ticket_arr['assignee'] = $this->getAssignee($row['trackid']);
        }

        return $ticket_arr;
    }

    public function replyTicket($ticket_id, $message, $user_id, $file_name, $replier_type = '') {
        $data_ticket = array(
            'replyto' => $ticket_id,
            'user_id' => $user_id,
            'message' => $message,
            'reply_user_type' =>$replier_type,
            'attachments' => $file_name,
            'dt' => date('Y-m-d H:i:s'),
            'read' => '1');
        $res = $this->db->insert('ticket_replies', $data_ticket);
        if ($res) {
            $this->db->set('lastreplier', $user_id);
            if ($replier_type != "")
                $this->db->set('last_replier_type', $replier_type);
            $this->db->set('lastchange', date('Y-m-d H:i:s'));
            $this->db->where('id', $ticket_id);
            $res = $this->db->update('tickets');
        }
        return $res;
    }

    public function getAssignedTicketData($ticket_id, $employee_id) {

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
            $ticket_arr["details$i"]['status'] = $row['status'];
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

    public function getAllTicketsBasedSearchType($search_based, $search_item, $user_id, $tickt_category = '', $ticket_date = '', $dispaly = '', $assigned_to_me = '', $assigned_to_other = '', $un_assigned = '', $tagged_ticket = '', $limit = '10', $start = '0') {

       // $status = $this->ticket_model->getTicketStatusIdBasedOnStatus('Resolved');
        $date = date('Y-m-d H:i:s');
        $details = array();
        $this->db->select('*');
        $this->db->from('tickets');
        //$this->db->where('status !=', $status);
        if ($ticket_date != "")
            $this->db->where("dt LIKE '$ticket_date%'");
        if ($tickt_category != "")
            $this->db->where('category', $tickt_category);

        if ($search_based == "ticket_id")
            $this->db->where('trackid', $search_item);

        elseif ($search_based == "name")
            $this->db->where('name', $search_item);
        elseif ($search_based == "assignee_name")
            $this->db->where('assignee_name', $search_item);
        elseif ($search_based == "email")
            $this->db->where('email', $search_item);
        elseif ($search_based == "subject")
            $this->db->where('subject', $search_item);
        if ($assigned_to_me == 1)
            $this->db->where('assignee_id', $user_id);
        if ($assigned_to_other == 1) {
            $this->db->where('assignee_id !=', 0);
            $this->db->where('assignee_id !=', $user_id);
        }
        if ($un_assigned == 1)
            $this->db->where('assignee_id', 0);
        if ($tagged_ticket == 1)
            $this->db->where('tags !=', "");

        if ($dispaly != "")
            $this->db->limit($dispaly, $start);
        else
            $this->db->limit($limit, $start);

        $res = $this->db->get();

        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['ticket_id'] = $row['trackid'];
            $details[$i]['name'] = $row['name'];
            if ($row['assignee_name'] == "")
                $details[$i]['assignee_name'] = "admin";
            else
                $details[$i]['assignee_name'] = $row['assignee_name'];
            $details[$i]['subject'] = $row['subject'];
            $details[$i]['status'] = $this->getStatus($row['status']);
            $details[$i]['status_id'] = $row['status'];
            $details[$i]['last_replier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            $details[$i]['lastchange'] = $row['lastchange'];
            $details[$i]['priority'] = $row['priority'];
            $details[$i]['priority_name'] = $this->getPriorityName($row['priority']);
            $details[$i]['category'] = $row['category'];
            $details[$i]['category_name'] = $this->getCategory($row['category']);
            $date1 = date_create($row['lastchange']);
            $date2 = date_create($date);
            $diff = date_diff($date1, $date2);

            if (($diff->format("%d")) == 0) {
                $details[$i]['updated'] = $diff->format("%hh") . '' . $diff->format("%im");
            } else {
                $details[$i]['updated'] = $diff->format("%d days");
            }
            $i++;
        }
        return $details;
    }

    public function getAllTicketSearchCount($search_based, $search_item, $user_id, $tickt_category = '', $ticket_date = '', $dispaly = '', $assigned_to_me = '', $assigned_to_other = '', $un_assigned = '', $tagged_ticket = '') {

//        echo $search_based.'-------'.$search_item;die();
////        
        $status = $this->ticket_model->getTicketStatusIdBasedOnStatus('Resolved');

        $this->db->where('status !=', $status);
        if ($ticket_date != "")
            $this->db->where("dt LIKE '$ticket_date%'");
        if ($tickt_category != "")
            $this->db->where('category', $tickt_category);
        if ($search_based == "ticket_id")
            $this->db->where('trackid', $search_item);
        elseif ($search_based == "name")
            $this->db->where('name', $search_item);
        elseif ($search_based == "assignee_name")
            $this->db->where('assignee_name', $search_item);
        elseif ($search_based == "email")
            $this->db->where('email', $search_item);
        elseif ($search_based == "subject")
            $this->db->where('subject', $search_item);
        if ($assigned_to_me == 1)
            $this->db->where('assignee_id', $user_id);
        if ($assigned_to_other == 1) {
            $this->db->where('assignee_id !=', 0);
            $this->db->where('assignee_id !=', $user_id);
        }
        if ($un_assigned == 1)
            $this->db->where('assignee_id', 0);
        if ($tagged_ticket == 1)
            $this->db->where('tags !=', "");

        $query = $this->db->get('tickets');

//        echo $this->db->last_query();die();
        return $query->num_rows();
    }
    
    public function getTicketActivityHistory($ticket_id) {

        $details = array();
        $this->db->select('*');
        $this->db->where('ticket_id', $ticket_id);
        $this->db->from('ticket_activity');
        $this->db->order_by('id', 'desc');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {

            $details[$i]['id'] = $row['id'];
            $details[$i]['ticket_id'] = $row['ticket_id'];
            $details[$i]['done_by'] = $row['done_by'];
            $details[$i]['done_by_user_type'] = $row['done_by_user_type'];
            if ($row['done_by_user_type'] != "employee")
                $details[$i]['done_by'] = $this->validation_model->IdToUserName($row['done_by']);
            else {
                $details[$i]['done_by'] = $this->validation_model->EmployeeIdToUserName($row['done_by']);
            }
            $details[$i]['date'] = $row['date'];
            $details[$i]['activity'] = $row['activity'];
            $details[$i]['comments'] = $row['if_comments'];

            $i++;
        }
      
        $this->db->select('*');
        $this->db->where('ticket_id', $ticket_id);
        $this->db->from('employee_ticket_activity');
        $this->db->order_by('id', 'desc');
        $res = $this->db->get();
        
        foreach ($res->result_array() as $row) {

            $details[$i]['id'] = $row['id'];
            $details[$i]['ticket_id'] = $row['ticket_id'];
            $details[$i]['done_by'] = $row['done_by'];
            $details[$i]['done_by_user_type'] = $row['user_type'];
            if ($row['user_type'] != "employee")
                $details[$i]['done_by'] = $this->validation_model->IdToUserName($row['done_by']);
            else {
                $details[$i]['done_by'] = $this->validation_model->EmployeeIdToUserName($row['done_by']);
            }
            $details[$i]['date'] = $row['date'];
            $details[$i]['activity'] = $row['activity'];
            $details[$i]['comments'] = $row['if_comments'];

            $i++;
        }
        
        return $details;
    }

    public function getAllTickets($type) {
        $date = date('Y-m-d H:i:s');
        $details = array();
        $this->db->select('*');
        $this->db->from('tickets');
        if ($type == 'progress')
            $this->db->where('status', "2");
        if ($type == 'critical')
            $this->db->where('priority', "3");
        if ($type == 'new')
            $this->db->where('status', "1");
        $this->db->order_by('dt', 'DESC');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['ticket_id'] = $row['trackid'];
            $details[$i]['name'] = $row['name'];
            if ($row['assignee_name'] == "")
                $details[$i]['assignee_name'] = "admin";
            else
                $details[$i]['assignee_name'] = $row['assignee_name'];
            $details[$i]['subject'] = $row['subject'];
            $details[$i]['status'] = $this->getStatus($row['status']);
            $details[$i]['status_id'] = $row['status'];
            $details[$i]['last_replier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            $details[$i]['lastchange'] = $row['lastchange'];
            $details[$i]['priority'] = $row['priority'];
            $details[$i]['priority_name'] = $this->getPriorityName($row['priority']);
            $details[$i]['flag'] = $this->getPriorityFlag($row['priority']);
            $details[$i]['category'] = $row['category'];
            $details[$i]['category_name'] = $this->getCategory($row['category']);
            $date1 = date_create($row['lastchange']);
            $date2 = date_create($date);
            $diff = date_diff($date1, $date2);

            if (($diff->format("%d")) == 0) {
                $details[$i]['updated'] = $diff->format("%hh") . '' . $diff->format("%im");
            } else {
                $details[$i]['updated'] = $diff->format("%d days");
            }
            $i++;
        }
        return $details;
    }

    public function getAllEmployees() {
        $details = array();
        $this->db->select('user_id,user_name');
        $this->db->where('emp_status', "yes");
        $res = $this->db->get('login_employee');
        foreach ($res->result_array() as $row) {
            $details[] = $row;
        }

        return $details;
    }

    public function getTicketTrackId($id) {
        $ticket_id = '';
        $this->db->select('trackid');
        $this->db->from('tickets');
        $this->db->where('id', $id);
        $res = $this->db->get();
        // $i=0;
        foreach ($res->result_array() as $row) {
            $ticket_id = $row['trackid'];
        }
        return $ticket_id;
    }
    public function getTicketCreatedUser($ticket_id) {
        $user_name = "";
        $this->db->select('user_id');
        $this->db->from('tickets');
        $this->db->where('trackid', $ticket_id);
        $res = $this->db->get();
       
        foreach ($res->result() as $row) {
            $user_name = $this->validation_model->IdToUserName($row->user_id);
        }
        return $user_name;
    }
    public function getTicketCurrentCategory($ticket_id){
        $category_id = "";
        $this->db->select('category');
        $this->db->where('trackid',$ticket_id);
        $this->db->from('tickets');
        $res = $this->db->get();
       
        foreach ($res->result() as $row) {
         $category_id = $row->category;
        }
        return $category_id;  
    }
     public function decrementCategoryCount($category){
       $this->db->set('ticket_count', 'ticket_count - 1', FALSE);
       $this->db->where('id', $category);
       $res = $this->db->update('ticket_categories');
       return $res; 
    }
    public function incrementCategoryCount($category){
       $this->db->set('ticket_count', 'ticket_count + 1', FALSE);
       $this->db->where('id', $category);
       $res = $this->db->update('ticket_categories');
       return $res; 
    }
    public function getTicketStatus($ticket_id){
        $status_name = "";
        $this->db->select('status');
        $this->db->where('trackid',$ticket_id);
        $this->db->from('tickets');
        $res = $this->db->get();
       
        foreach ($res->result() as $row) {
         $status_name = $this->getStatus($row->status);
        }
        return $status_name;  
    }
    public function addComments($user_id,$ticket_id,$ticket_trackid,$comments){
      $res = "";
      $this->db->set('ticket_id', $ticket_id); 
      $this->db->set('ticket_track_id', $ticket_trackid); 
      $this->db->set('comment', $comments); 
      $this->db->set('commented_by', $user_id); 
      $res = $this->db->insert('ticket_comments');
      return $res;
    }
    public function employeeNameToID($emp_name){
        return $this->validation_model->employeeNameToID($emp_name);
    }
    public function EmployeeIdToUserName($emp_id){
        return $this->validation_model->EmployeeIdToUserName($emp_id);
    }
    public function getTicketsCategories() {
        $cat_arr = array();
        $this->db->select('id,category_name');
        $this->db->from('ticket_categories');
//        $this->db->order_by("cat_order");
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['cat_id'] = $row['id'];
            $cat_arr["details$i"]['cat_name'] = $row['category_name'];
            $i++;
        }
        return $cat_arr;
    }
    public function getTicketsPriority(){
        $cat_arr = array();
        $this->db->select('id,priority');
        $this->db->from('ticket_priority');
        $this->db->where('active',1);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['priority_id'] = $row['id'];
            $cat_arr["details$i"]['priority'] = $row['priority'];
            $i++;
        }
        return $cat_arr;
    }
    public function getTicketsStatus(){
        $cat_arr = array();
        $this->db->select('id,status');
        $this->db->from('ticket_status');
        $this->db->where('active',1);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['status_id'] = $row['id'];
            $cat_arr["details$i"]['status'] = $row['status'];
            $i++;
        }
        return $cat_arr;
    }
      public function getSubjects() {
        $arr = array();
        $this->db->select('*');
        $this->db->from('mail_subjects');
        $this->db->where('status', 'yes');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $arr[$i]['id'] = $row['id'];
            $arr[$i]['subject'] = $row['subject'];
            $arr[$i]['date'] = $row['date'];
            $i++;
        }
        return $arr;
    }
   
}
