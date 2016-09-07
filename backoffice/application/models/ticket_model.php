<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ticket_model extends inf_model {

//    public $OBJ_MISC;
//    private $mailObj;

    public function __construct() {

        parent::__construct();
    }

    public function getCategory() {
        $cat_arr = array();
        $this->db->select('id');
        $this->db->select('category_name');
        $this->db->from('ticket_categories');
        $this->db->where('status', 1);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['cat_id'] = $row['id'];
            $cat_arr["details$i"]['cat_name'] = $row['category_name'];
            $i++;
        }
        return $cat_arr;
    }

    public function createTicketId() {
        $length = 6;
        $key = '';
        $charset = '0123456789';
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;

        $this->db->select('*');
        $this->db->where('trackid', $randum_id);
        $qr = $this->db->get('tickets');
        $count = $qr->num_rows();
        if (!$count)
            return 'SW' . $key;
        else
            $this->createTicketId();
    }


    function createNewTicket($ticket) {
        $admin_id = $this->validation_model->getAdminId();
        $admin_name = $this->getAdminName($admin_id);
        $user_name =$this->LOG_USER_ID;
        global $hesk_settings, $hesklang, $hesk_db_link;
        $data_ticket = array(
            'trackid' => $ticket['trackid'],
            'name' => $user_name,
            'email' => '',
            'user_id' => $ticket['user_id'],
            'category' => $ticket['category'],
            'priority' => $ticket['priority'],
//            'assignee_id' => $admin_id,
//            'assignee_name' => $admin_name,
            'assignee_id' => $ticket['category_assignee_id'],
            'assignee_name' => $ticket['category_assignee_name'],
            'assignee_read_ticket' => "no",
            'subject' => $ticket['subject'],
            'message' => $ticket['message'],
            'dt' => date("Y-m-d H:i:s"),
            'lastchange' => date("Y-m-d H:i:s"),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'language' => '',
            'status' => '1',
            'owner' => '0',
            'attachments' => $ticket['file_name'],
            'merged' => 'ss',
            'history' => 'ss'
        );

        $res = $this->db->insert('tickets', $data_ticket);
        return $res;
    }

    /**
     * @todo Optimization required
     * @param int $ticket_id
     * @param int $user_id
     * @param string $resolved_status
     * @param int $limit
     * @param int $start 
     * @return type
     */
    public function getTicketData($ticket_id = '', $user_id = '', $resolved_status = '', $limit = '10', $start = '0') {
      
        $ticket_arr = array();
        if ($ticket_id) {

         
            $this->db->where('trackid', $ticket_id);
            $this->db->where('user_id', $user_id);
            if ($resolved_status != '') {
                $this->db->where('status !=', $resolved_status);
            }
            $this->db->from('tickets');
            $this->db->order_by('lastchange', 'desc');

            $this->db->limit($limit, $start);
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
                    if ($row1['read'] == 0)
                        $ticket_arr["details$i"]['read'] = $row1['read'];
                }
                $ticket_arr["details$i"]['ticket_id'] = $row['trackid'];
                $ticket_arr["details$i"]['status'] = $this->getTicketStatus($row['status']);
                $ticket_arr["details$i"]['created_date'] = $row['dt'];
                $ticket_arr["details$i"]['updated_date'] = $row['lastchange'];
                $ticket_arr["details$i"]['subject'] = $row['subject'];
                $ticket_arr["details$i"]['user'] = $this->validation_model->IdToUserName($row['user_id']);
                if ($row['last_replier_type'] != "employee")
                    $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->IdToUserName($row['lastreplier']);
                else {
                    $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
                }

                $ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
                $ticket_arr["details$i"]['priority'] = $row['priority'];
                $ticket_arr["details$i"]['priority_name'] = $this->getPriority($row['priority']);
                $ticket_arr["details$i"]['name'] = $row['name'];
                $i++;
            }

            return $ticket_arr;
        } else {
           
            $this->db->where('user_id', $user_id);
            if ($resolved_status != '') {
                $this->db->where('status !=', $resolved_status);
            }
            $this->db->from('tickets');
            $this->db->order_by('lastchange', 'desc');
            $this->db->limit($limit, $start);
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
                    if ($row1['read'] == 0)
                        $ticket_arr["details$i"]['read'] = $row1['read'];
                }
                $ticket_arr["details$i"]['ticket_id'] = $row['trackid'];
                $ticket_arr["details$i"]['status'] = $this->getTicketStatus($row['status']);
                $ticket_arr["details$i"]['created_date'] = $row['dt'];
                $ticket_arr["details$i"]['updated_date'] = $row['lastchange'];

                $ticket_arr["details$i"]['subject'] = $row['subject'];
                $ticket_arr["details$i"]['user'] = $this->validation_model->IdToUserName($row['user_id']);
                if ($row['last_replier_type'] != "employee")
                    $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->IdToUserName($row['lastreplier']);
                else {
                    $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->EmployeeIdToUserName($row['lastreplier']);
                }
               
                $ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
                $ticket_arr["details$i"]['priority'] = $row['priority'];
                $ticket_arr["details$i"]['priority_name'] = $this->getPriority($row['priority']);
                $ticket_arr["details$i"]['name'] = $row['name'];
                $i++;
            }
            return $ticket_arr;
        }
    }

    public function getTicketDataCount($ticket_id = '', $user_id = '', $resolved_status = '') {
       
        $ticket_arr = array();
        if ($ticket_id) {

            $this->db->where('trackid', $ticket_id);
            $this->db->where('user_id', $user_id);
            if ($resolved_status != '') {
                $this->db->where('status !=', $resolved_status);
            }
            $this->db->from('tickets');
            $this->db->order_by('lastchange', 'desc');

         
            $res = $this->db->get();
            return $res->num_rows();
        } else {

            $this->db->where('user_id', $user_id);
            if ($resolved_status != '') {
                $this->db->where('status !=', $resolved_status);
            }
            $this->db->from('tickets');
            $this->db->order_by('lastchange', 'desc');
            $res = $this->db->get();
            return $res->num_rows();
        }
    }

    public function getCategoryTicket($cat_id) {
        $cat_name = '';
        $this->db->select('category_name');
        $this->db->from('ticket_categories');
        $this->db->where('id', $cat_id);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_name = $row['category_name'];
        }
        return $cat_name;
    }

    public function replyTicket($details, $message, $user_id, $file_name, $replier_type = '') {
       
        $data_ticket = array(
            'replyto' => $details['details0']['id'],
            'user_id' => $user_id,
            'reply_user_type' => $replier_type,
            'message' => $message,
            'attachments' => $file_name,
            'dt' => date('Y-m-d H:i:s'),
            'read' => '1');
        $res = $this->db->insert('ticket_replies', $data_ticket);
        if ($res) {
            $this->db->set('lastreplier', $user_id);
            if ($replier_type != "")
                $this->db->set('last_replier_type', $replier_type);
            $this->db->set('lastchange', date('Y-m-d H:i:s'));
            $this->db->where('id', $details['details0']['id']);
            $res = $this->db->update('tickets');
        }
        return $res;
    }

    public function markedAsResolved($ticket_id) {
        $this->db->set('lastchange', date('Y-m-d H:i:s'));
        $this->db->set('status', '3');
        $this->db->where('id', $ticket_id);
        $res = $this->db->update('tickets');
        return $res;
    }

    public function getAllReply($ticket_id) {
        $details = array();

        $this->db->select('*');
        $this->db->order_by('id', 'asc');
        $this->db->from('ticket_replies');
        $this->db->where('replyto', $ticket_id);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details[$i]['message'] = $row['message'];
            $details[$i]['reply_user_type'] = $row['reply_user_type'];
            if ($row['reply_user_type'] != 'employee') {

                $details[$i]['profile_pic'] = $this->validation_model->getProfilePicture($row['user_id']);
            } else {
                $details[$i]['profile_pic'] = 'nophoto.jpg';
            }
            $details[$i]['date'] = $row['dt'];
            $details[$i]['file'] = $row['attachments'];
            $details[$i]['user'] = $this->validation_model->IdToUserName($row['user_id']);
            $details[$i]['user_id'] = $row['user_id'];
            $i++;
        }
        return $details;
    }

    public function insertIntoAttachment($ticket_id, $file_details, $saved_name = '') {

        $data_ticket = array(
            'ticket_id' => $ticket_id,
            'saved_name' => $saved_name,
            'real_name' => $file_details['original_name'],
            'size' => $file_details['file_size']);

        $res = $this->db->insert('attachments', $data_ticket);
        return $this->db->insert_id();
    }

    public function readTicket($id) {

        $this->db->set('read', '1');
        $this->db->where('replyto', $id);
        $res = $this->db->update('ticket_replies');
    }

    public function replyTicketFromMail($details, $reply_msg, $user_id, $file_name, $date, $read) {
        $res = '';
        //for($i=0;$i<count($reply_msg);$i++){
        $data_ticket = array(
            'replyto' => $details["details0"]['id'],
            'user_id' => $user_id,
            'message' => $reply_msg,
            'attachments' => $file_name,
            'dt' => $date,
            'read' => $read);
        $res = $this->db->insert('ticket_replies', $data_ticket);
        if ($res) {
            $this->db->set('lastreplier', $user_id);
            $this->db->set('lastchange', date('Y-m-d H:i:s'));
            $this->db->where('id', $details["details0"]['id']);
            $res = $this->db->update('tickets');
        }
        // }
        return $res;
    }

    public function getTicketRepliesToUser($ticket) {
        $subject = explode("/", $ticket['subject']);
        $i = 0;
        $ticket_reply = array();
        for ($j = 0; $j < count($subject); $j++) {
            $this->db->select('mailtousmsg,file_name,mailtousdate');
            $this->db->from('mailtouser');
            $this->db->where('mailtoususer', $ticket['user_id']);
            $this->db->like("mailtoussub", $subject[$j]);
            $res = $this->db->get();

            foreach ($res->result_array() as $row) {
                $ticket_reply[$i]['msg'] = $row['mailtousmsg'];
                $ticket_reply[$i]['img'] = $row['file_name'];
                $ticket_reply[$i]['date'] = $row['mailtousdate'];
                $i++;
            }
        }
        return $ticket_reply;
    }

    function createNewTicketFromOld($ticket) {
        $user_name = $this->validation_model->IdToUserName($ticket['user_id']);
        ;
        global $hesk_settings, $hesklang, $hesk_db_link;
        $data_ticket = array(
            'trackid' => $ticket['trackid'],
            'name' => $user_name,
            'email' => '',
            'user_id' => $ticket['user_id'],
            'category' => $ticket['category'],
            'priority' => $ticket['priority'],
            'subject' => $ticket['subject'],
            'message' => $ticket['message'],
            'dt' => $ticket['date'],
            'lastchange' => date("Y-m-d H:i:s"),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'language' => '',
            'status' => $ticket['mail_status'],
            'owner' => '0',
            'attachments' => $ticket['file_name'],
            'merged' => 'ss',
            'history' => 'ss',
            'custom1' => '',
            'custom2' => '',
            'custom3' => '',
            'custom4' => '',
            'custom5' => '',
            'custom6' => '',
            'custom7' => '',
            'custom8' => '',
            'custom9' => '',
            'custom10' => '',
            'custom11' => '',
            'custom12' => '',
            'custom13' => '',
            'custom14' => '',
            'custom15' => '',
            'custom16' => '',
            'custom17' => '',
            'custom18' => '',
            'custom19' => '',
            'custom20' => ''
        );

        $res = $this->db->insert('tickets', $data_ticket);
        return $res;
    }

    public function getTicketId($ticket) {
        $ticket_id = '';
        $this->db->select('id');
        $this->db->from('tickets');
        $this->db->where('trackid', $ticket);
        $res = $this->db->get();
        // $i=0;
        foreach ($res->result_array() as $row) {
            $ticket_id = $row['id'];
        }
        return $ticket_id;
    }

    public function getTicketRepliesToAdmin($ticket) {
        $ticket_reply = array();
        $this->db->select('mailadidmsg,mailaduser,image_name,mailadiddate');
        $this->db->from('mailtoadmin');
        $this->db->where('mailaduser', $ticket['user_id']);
        $this->db->like("mailadsubject", $ticket['subject']);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $ticket_reply[$i]['msg'] = $row['mailadidmsg'];
            $ticket_reply[$i]['img'] = $row['image_name'];
            $ticket_reply[$i]['date'] = $row['mailadiddate'];
            $i++;
        }
        return $ticket_reply;
    }

    public function updateTicket($tkt_id, $image) {
        $this->db->set('attachments', $image);
        $this->db->where('trackid', $tkt_id);
        $res = $this->db->update('tickets');
    }

    public function getResolvedTicketData($user_id = '', $status = '', $limit = '10', $start = '0') {
        $ticket_arr = array();
        $this->db->where('user_id', $user_id);
        $this->db->where('status', $status);
        $this->db->from('tickets');
        $this->db->limit($limit, $start);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $ticket_arr["details$i"]['id'] = $row['id'];
            $ticket_arr["details$i"]['read'] = 1;
            //$this->db->select('count(id) AS cnt');
            $this->db->select('read');
            $this->db->where('replyto', $row['id']);

            $res1 = $this->db->get('ticket_replies');
            foreach ($res1->result_array() as $row1) {
                //$ticket_arr["details$i"]['count']=$row1['cnt'];
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

            //$ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
            $ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
            $ticket_arr["details$i"]['priority'] = $row['priority'];
            $ticket_arr["details$i"]['priority_name'] = $this->getPriority($row['priority']);
            $ticket_arr["details$i"]['name'] = $row['name'];
            $i++;
        }
        return $ticket_arr;
    }

    public function getResolvedTicketDataCount($user_id = '', $status = '') {
        $ticket_arr = array();
        $this->db->where('user_id', $user_id);
        $this->db->where('status', $status);
        $this->db->from('tickets');
        $res = $this->db->get();
        return $res->num_rows();
    }

    public function getSearchedTicketData($user_id, $status, $category, $priority) {
        $ticket_arr = array();
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        if ($status != '')
            $this->db->where('status', $status);
        if ($priority != '')
            $this->db->where('priority', $priority);
        if ($category != '')
            $this->db->where('category', $category);
        $this->db->from('tickets');
        //$this->db->order_by('lastchange', 'desc');

        $res = $this->db->get();
        //echo $this->db->last_query();die();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $ticket_arr["details$i"]['id'] = $row['id'];
            $ticket_arr["details$i"]['read'] = 1;
            $this->db->select('read');
            $this->db->where('replyto', $row['id']);
            $this->db->from('ticket_replies');
            $res1 = $this->db->get();
            foreach ($res1->result_array() as $row1) {
                if ($row1['read'] == 0)
                    $ticket_arr["details$i"]['read'] = $row1['read'];
            }
            $ticket_arr["details$i"]['ticket_id'] = $row['trackid'];
            $ticket_arr["details$i"]['status'] = $this->getStatus($row['status']);
            $ticket_arr["details$i"]['created_date'] = $row['dt'];
            $ticket_arr["details$i"]['updated_date'] = $row['lastchange'];
            $ticket_arr["details$i"]['subject'] = $row['subject'];
            $ticket_arr["details$i"]['user'] = $this->validation_model->IdToUserName($row['user_id']);
            $ticket_arr["details$i"]['lastreplier'] = $this->validation_model->IdToUserName($row['lastreplier']);
            $ticket_arr["details$i"]['category'] = $this->getCategoryTicket($row['category']);
            $ticket_arr["details$i"]['priority'] = $row['priority'];
            $ticket_arr["details$i"]['priority_name'] = $this->getPriority($row['priority']);
            $ticket_arr["details$i"]['name'] = $row['name'];
            $i++;
        }
        return $ticket_arr;
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

    public function getTicketStatusIdBasedOnStatus($status) {
        $status_id = "";
        $this->db->select('id');
        $this->db->from('ticket_status');
        $this->db->where('status', $status);
        $this->db->where('active', 1);
        $res = $this->db->get();

        foreach ($res->result() as $row1) {
            $status_id = $row1->id;
        }
        return $status_id;
    }

    public function reopenTicket($ticket_id, $status) {
        $res = "";
        $this->db->set('status', $status);
        $this->db->where('trackid', $ticket_id);
        $res = $this->db->update('tickets');
        return $res;
    }

    public function getPriority($priority_id) {
        $priority = "";
        $this->db->select('priority');
        $this->db->from('ticket_priority');
        $this->db->where('id', $priority_id);
        $this->db->where('active', 1);
        $res = $this->db->get();

        foreach ($res->result() as $row1) {
            $priority = $row1->priority;
        }
        return $priority;
    }

    public function insertToHistory($ticket_id = '', $user_id = '', $user_type = '', $activity = '', $comments = '') {

        $date = date('Y-m-d H:i:s');
        $res = "";

        $this->db->set('ticket_id', $ticket_id);
        $this->db->set('done_by', $user_id);
        $this->db->set('done_by_user_type', $user_type);
        $this->db->set('activity', $activity);
        $this->db->set('date', $date);
        if ($comments != "")
            $this->db->set('if_comments', $comments);
        $res = $this->db->insert('ticket_activity');
        return $res;
    }

    public function insertToEmployeeHistory($ticket_id = '', $user_id = '', $user_type = '', $activity = '', $comments = '') {
        $res = "";
        $date = date('Y-m-d H:i:s');
        $this->db->set('ticket_id', $ticket_id);
        $this->db->set('done_by', $user_id);
        $this->db->set('user_type', $user_type);
        $this->db->set('activity', $activity);
        $this->db->set('date', $date);
        if ($comments != "")
            $this->db->set('if_comments', $comments);
        $res = $this->db->insert('employee_ticket_activity');
        return $res;
    }

    public function getTicketStatus($status_id) {
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

    public function getAdminName($admin_id) {
        $user_name = "";
        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_id', $admin_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAssigneeDetails($category_id) {
        $assignee = array();
        $this->db->select('assignee_id');
        $this->db->from('ticket_categories');
        $this->db->where('id', $category_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $assignee['id'] = $row->assignee_id;
            $assignee['name'] = $this->validation_model->EmployeeIdToUserName($row->assignee_id);
        }
        return $assignee;
    }

}

?>
