<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mail
 *
 * @author pavanan
 */
class mail_model extends inf_model {

    public $MEMBER_DETAILS;
    public $mailObj;
    public $user_downlines;

    public function __construct() {
        parent::__construct();

        $this->load->model('validation_model');
        $this->load->model('page_model');
        $this->load->model('configuration_model');
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function setFooter($page, $limit, $current_url) {

        return $this->page_model->setFooter($page, $limit, $current_url);
    }

    public function paging($page, $limit, $pages_selection) {
        $pag_arr = array();
        $num_rows = $this->getMessagesPages($pages_selection);
        $first = $this->page_model->paging($page, $limit, $num_rows);
        $pag_arr['first'] = $first;
        return $pag_arr;
    }

    public function getMessagesPages($pages_selection) {
        switch ($pages_selection) {
            case 'admin' :
                $num_rows = $this->getAdminMessagesPages();
                break;

            case 'distributter' :
                $num_rows = $this->getUserMessagesPages($_SESSION['user_id']);
                break;
        }
        return $num_rows;
    }

    public function getAdminMessagesPages() {

        $mailtoadmin = "mailtoadmin";

        $this->db->select('*');
        $this->db->from($mailtoadmin);
        $this->db->where('status', 'yes');
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getUserMessagesPages($user_id) {
        $mailtouser = "mailtouser";

        $this->db->select('*');
        $this->db->from($mailtouser);
        $this->db->where('status', 'yes');
        $this->db->where('mailtoususer', $user_id);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getUsers() {

        $user_arr = array();
        $this->db->select('user_id');
        $this->db->from('login_user');
        $this->db->NOT_LIKE('addedby', 'server');
        $this->db->NOT_LIKE('user_type', 'admin');
        $this->db->order_by('user_id', 'asc');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_arr[] = $row->user_id;
        }
        return $user_arr;
    }

    public function userNameToId($user_name) {

        return $this->validation_model->userNameToID($user_name);
    }

    public function sendMessageToUser($user_id, $subject, $message, $dt) {
        $data = array(
            'mailtoususer' => $user_id,
            'mailtoussub' => $subject,
            'mailtousmsg' => $message,
            'mailtousdate' => $dt
        );
        $res = $this->db->insert('mailtouser', $data);
        return $res;
    }

    public function sendMessageToUserCumulative($user_id, $subject, $message, $dt, $type) {
        $data = array(
            'mailtoususer' => $user_id,
            'mailtoussub' => $subject,
            'mailtousmsg' => $message,
            'mailtousdate' => $dt,
            'type' => $type
        );
        $res = $this->db->insert('mailtouser_cumulativ', $data);
        return $res;
    }

    public function sendMesageToAdmin($from, $message, $subject, $dt, $table_prefix = '') {

        $data = array(
            'mailaduser' => $from,
            'mailadsubject' => $subject,
            'mailadidmsg' => $message,
            'status' => 'yes',
            'mailadiddate' => $dt
        );
        $res = $this->db->insert($table_prefix . 'mailtoadmin', $data);
        return $res;
    }

    public function getAdminMessages($page, $limit) {
        $message = array();
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['id'] = $row['mailadid'];
            $message[$i]['mailaduser'] = $row['mailaduser'];
            $message[$i]['mailadsubject'] = $row['mailadsubject'];
            $message[$i]['mailadiddate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['mailadidmsg'] = stripslashes($row['mailadidmsg']);
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "admin";
            $message[$i]['flag'] = 1;

            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailaduser']);

            $i++;
        }
        return $message;
    }

    public function getContactMessages($page, $limit, $logged_id) {
        $message = array();
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $logged_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['id'] = $row['id'];
            $message[$i]['mailaduser'] = $row['contact_name'];
            $message[$i]['mailadsubject'] = $row['contact_name'] . " Contacted You";
            $message[$i]['mailadiddate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            if ($row['contact_info'] == '') {
                $message[$i]['mailadidmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone'] . "<br>Describtion:NA";
            } else {
                $message[$i]['mailadidmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone'] . "<br>Describtion:" . $row['contact_info'];
            }
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "contact";
            $message[$i]['flag'] = '';
            $message[$i]['user_name'] = $row['contact_name'] . " Contacted You";
            $i++;
        }
        return $message;
    }

    public function getAdminMessagesSent($page, $limit) {
        $message = array();
        $this->db->select('*');
        $this->db->from('mailtouser_cumulativ');
        $this->db->where('status', 'yes');
        $this->db->order_by('mailtousdate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['id'] = $row['mailtousid'];
            $message[$i]['mailtoususer'] = $row['mailtoususer'];
            $message[$i]['mailtoussub'] = $row['mailtoussub'];
            $message[$i]['mailtousdate'] = $row['mailtousdate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['type'] = $row['type'];
            $message[$i]['mailtousmsg'] = stripslashes($row['mailtousmsg']);
            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailtoususer']);

            $i++;
        }
        return $message;
    }

    public function getCountAdminMessages() {
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('status', 'yes');
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountContactMessages() {

        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', '53');
        $this->db->where('status', 'yes');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountAdminMessagesSent() {

        $this->db->select('*');
        $this->db->from('mailtouser_cumulativ');
        $this->db->where('status', 'yes');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountUserMessages($user_id) {

        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('status', 'yes');
        $this->db->where('mailtoususer', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getAdminOneMessage($id) {
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('mailadid', $id);
        $this->db->where('status', 'yes');
        $res = $this->db->get();
        return $res;
    }

    public function updateAdminOneMessage($msg_id) {
        $data = array(
            'read_msg' => 'yes',
        );
        $this->db->where('mailadid', $msg_id);
        $this->db->where('status', 'yes');
        $this->db->update('mailtoadmin', $data);
    }

    public function updateUserOneMessage($msg_id, $this_prefix = '') {
        $data = array(
            'read_msg' => 'yes',
        );
        $this->db->where('mailtousid', $msg_id);
        $this->db->where('status', 'yes');
        $this->db->update($this_prefix . 'mailtouser', $data);
    }

    public function getUserOneMessage($id, $user_id) {
        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('mailtousid', $id);
        $this->db->where('mailtoususer', $user_id);
        $this->db->where('status', 'yes');
        $res = $this->db->get();
        return $res;
    }

    public function getUserOneMessageForAdmins($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtouser = $this->table_prefix . "mailtouser";
        $qr = "SELECT * FROM $mailtouser where mailtousid='$id'";
        $res = $this->selectData($qr, "Error on 12324234");
        return $res;
    }

    public function getUserOneMessageForUser($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtouser = $this->table_prefix . "mailtouser";
        $qr = "SELECT * FROM $mailtouser where mailadid='$id'";
        $res = $this->selectData($qr);
        return $res;
    }

    public function getUserMessages($user_id, $page, $limit = '', $table_prefix = '') {
        $message = array();
        $this->db->select('*');
        $this->db->from($table_prefix . 'mailtouser');
        $this->db->where('mailtoususer', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailtousdate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['mailtousid'] = $row['mailtousid'];
            $message[$i]['mailtoususer'] = $row['mailtoususer'];
            $message[$i]['mailtoussub'] = $row['mailtoussub'];
            $message[$i]['mailtousmsg'] = $row['mailtousmsg'];
            $message[$i]['mailtousdate'] = $row['mailtousdate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "user";
            $message[$i]['flag'] = 1;
            $message[$i]['user_name'] = $this->validation_model->idToUserName($row['mailtoususer']);
            $i++;
        }
        return $message;
    }

    public function getUserContactMessages($user_id, $page, $limit = '', $table_prefix = '') {
        $message = array();
        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('owner_id', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        $this->db->limit($limit, $page);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $message[$i]['mailtousid'] = $row['id'];
            $message[$i]['mailtoususer'] = $row['contact_name'];
            $message[$i]['mailtoussub'] = $row['contact_name'] . " Contacted You";
            if ($row['contact_info'] == '') {
                $message[$i]['mailtousmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone']
                        . "<br>Describtion:NA";
            } else {
                $message[$i]['mailtousmsg'] = "Name:" . $row['contact_name'] . "<br>Email:" . $row['contact_email'] . "<br>Address:" . $row['contact_address'] . "<br>Phone:" . $row['contact_phone']
                        . "<br>Describtion:" . $row['contact_info'];
            }
            $message[$i]['mailtousdate'] = $row['mailadiddate'];
            $message[$i]['status'] = $row['status'];
            $message[$i]['read_msg'] = $row['read_msg'];
            $message[$i]['type'] = "contact";
            $message[$i]['flag'] = '';
            $message[$i]['user_name'] = $row['contact_name'] . " Contacted You";
            $i++;
        }
        return $message;
    }

    public function getCountUserContactMessages($user_id) {

        $this->db->select('*');
        $this->db->from('contacts');
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserMessagesSent($user_id, $page, $limit = '', $table_prefix = '') {
        $mails = array();
        $this->db->select('*');
        $this->db->from($table_prefix . 'mailtoadmin');
        $this->db->where('mailaduser', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mailadiddate', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $page);
        }
        $res = $this->db->get();
        foreach ($res->result_array() AS $row) {
            $row['mailadidmsg'] = stripslashes($row['mailadidmsg']);
            $row['user_name'] = $this->validation_model->idToUserName($row['mailaduser']);
            $mails[] = $row;
        }
        return $mails;
    }

    public function getUserMessagesSentCount($user_id) {
        $this->db->select('*');
        $this->db->from('mailtoadmin');
        $this->db->where('status', 'yes');
        $this->db->where('mailaduser', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserName($user_id) {
        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $row = $res->result_array();
        $user_name = $row[0]['user_name'];
        return $user_name;
    }

    public function getAdminSendItem() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtouser = $this->table_prefix . "mailtouser";
        $qr = "SELECT * FROM  $mailtouser WHERE mailtoususer='12346'";
        $res = $this->selectData($qr, "Error on 23557");
        return $res;
    }

    public function getUserSendItem($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtoadmin = $this->table_prefix . "mailtoadmin";
        $qr = "SELECT * FROM  $mailtoadmin WHERE mailaduser='$user_id'";
        $res = $this->selectData($qr);
        return $res;
    }

    public function updateAdminMessage($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('mailadid', $msg_id);
        $res = $this->db->update('mailtoadmin', $data);
        return $res;
    }

    public function updateContactMessage($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('id', $msg_id);
        $res = $this->db->update('contacts', $data);
        return $res;
    }

    public function updateAdminSentMessage($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('mailtousid', $msg_id);
        $res = $this->db->update('mailtouser_cumulativ', $data);
        return $res;
    }

    public function updateUserMessage($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('mailtousid', $msg_id);
        $res = $this->db->update('mailtouser', $data);
        return $res;
    }

    public function updateDownlineSendMessage($msg_id) {
        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('mail_id', $msg_id);
        $res = $this->db->update('mail_from_lead_cumulative', $data);
        return $res;
    }

    public function updateDownlineFromMessage($msg_id) {

        $data = array(
            'status' => 'deleted'
        );
        $this->db->where('mail_id', $msg_id);
        $res = $this->db->update('mail_from_lead', $data);
        return $res;
    }

    public function updateuserContactMessage($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('id', $msg_id);
        $res = $this->db->update('contacts', $data);
        return $res;
    }

    public function updateUserMessageSent($msg_id) {
        $data = array(
            'status' => 'no'
        );
        $this->db->where('mailadid', $msg_id);
        $res = $this->db->update('mailtoadmin', $data);
        return $res;
    }

    public function updateMsgStatus($msg_id) {
        $count = "";
        $user_name = $this->LOG_USER_NAME;
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $reslt_admin_read = "";
        $reslt_user_read = "";
        if ($user_type == 'admin') {
            $data = array(
                'read_msg' => 'yes'
            );

            $this->db->where('mailadid', $msg_id);
            $reslt_admin_read = $this->db->update('mailtoadmin', $data);
        } else {
            $data = array(
                'read_msg' => 'yes'
            );
            $this->db->where('mailtousid', $msg_id);
            $reslt_user_read = $this->db->update('mailtouser', $data);
        }
        if ($reslt_admin_read) {
            $this->db->select('mailaduser');
            $this->db->where('read_msg', 'no');
            $this->db->from('mailtoadmin');
            $count = $this->db->count_all_results();
            return $count;
        }
        if ($reslt_user_read) {
            $this->db->select('mailtoususer');
            $this->db->where('read_msg', 'no');
            $this->db->where('mailtoususer', $user_id);
            $this->db->from('mailtouser');
            $count = $this->db->count_all_results();
            return $count;
        }
    }

    public function deleteAdminMessage($msg_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtoadmin = $this->table_prefix . "mailtoadmin";
        $qr = "DELETE FROM $mailtoadmin  WHERE mailadid='$msg_id'";
        $res = $this->deleteData($qr, "Message Delete Failed");
        return $res;
    }

    public function deleteUserMessage($msg_id) {

        $qr = "DELETE mailtouser  WHERE mailtousid='$msg_id'";
        $res = $this->deleteData($qr, "Message Delete Failed");
        return $res;
    }

    public function getAdminMessageStatus($msg_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtoadmin = $this->table_prefix . "mailtoadmin";
        $qr = "SELECT status FROM  $mailtoadmin WHERE mailadid='$msg_id'";
        $res = $this->selectData($qr, "Error on selecting message satatus");
        $row = mysql_fetch_array($res);
        $status = $row['status'];
        return $status;
    }

    public function getUSerMessageStatus($msg_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $mailtouser = $this->table_prefix . "mailtouser";
        $qr = "SELECT status FROM  $mailtouser WHERE  mailtousid='$msg_id'";
        $res = $this->selectData($qr, "Error on selecting message satatus");
        $row = mysql_fetch_array($res);
        $status = $row['status'];
        return $status;
    }

    public function getAdminId() {
        return $this->validation_model->getAdminId();
    }

    public function idToUserName($user_id) {
        return $this->validation_model->IdToUserName($user_id);
    }

    public function getEmailId($user_id, $mailBodyDetails = '', $subject = '') {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $user_details = $this->table_prefix . "user_details";

        $qr = "SELECT user_detail_email FROM $user_details WHERE user_detail_refid='$user_id'";
        $res = $this->selectData($qr, "Error on selecting user email");
        $row = mysql_fetch_array($res);

        if ($row["user_detail_email"])
            $this->sendEmail($mailBodyDetails, $row["user_detail_email"], $subject);
    }

    public function sendEmail($mailBodyDetails, $email, $subject = '') {
        $this->mailObj->From = "info@ioss.in";
        $this->mailObj->FromName = "MLM@IOSS";
        if ($subject == '')
            $this->mailObj->Subject = "InfiniteMLM Notification";
        else
            $this->mailObj->Subject = "InfiniteMLM " . $subject;
        $this->mailObj->IsHTML(true);

        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);

        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;
        return $arr;
    }

    /////////////////______________________________|\


    public function getAllReadMessages($type) {
        $user_name = $this->session->userdata['inf_logged_in']['user_name'];
        $id = $this->userNameToId($user_name);
        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'yes');
        } else if ($type == "user") {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->from($mail);
            $this->db->where('mailtoususer', $id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'yes');
        }
        $query = $this->db->get();
        $numrows = $query->num_rows(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getAllUnreadMessages($type) {
        $user_name = $this->session->userdata['inf_logged_in']['user_name'];
        $id = $this->userNameToId($user_name);

        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->from($mail);
        } else {
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->where('mailtoususer', $id);
            $this->db->where('status', 'yes');
            $this->db->where('read_msg', 'no');
            $this->db->from($mail);
        }
        $query = $this->db->get();
        $numrows = $query->num_rows(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getCountUserUnreadMessages($type, $id) {

        $mail = 'mailtouser';
        $this->db->select('*');
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->where('mailtoususer', $id);
        $this->db->from('mailtouser');

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUnreadMessages($type) {

        $this->db->select('*');
        $this->db->from('mailtouser');
        $this->db->where('status', 'yes');
        $this->db->where('read_msg', 'no');
        $this->db->where('mailtoususer', $type);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getAllMessagesToday($type) {
        $count = 0;
        $date = date("Y-m-d");

        if ($type == "admin") {
            $mail = 'mailtoadmin';
            $this->db->select('mailadid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->like('mailadiddate', $date);
        } else if ($type == "user") {
            $user_name = $this->session->userdata['inf_logged_in']['user_name'];
            $id = $this->userNameToId($user_name);
            $mail = 'mailtouser';
            $this->db->select('mailtousid');
            $this->db->from($mail);
            $this->db->where('status', 'yes');
            $this->db->where('mailtoususer', $id);
            $this->db->like('mailtousdate', $date);
        }
        $query = $this->db->get();
        $numrows = $query->num_rows(); // Number of rows returned from above query.
        return $numrows;
    }

    public function getAdminUsername() {

        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_type', 'admin');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getTicketsCategories() {
        $cat_arr = array();
        $this->db->select('id,name');
        $this->db->from('ticket_categories');
        $this->db->order_by("cat_order");
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['cat_id'] = $row['id'];
            $cat_arr["details$i"]['cat_name'] = $row['name'];
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

    public function getCategory() {
        $cat_arr = array();
        $this->db->select('id');
        $this->db->select('name');
        $this->db->from('ticket_ticket_categories');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $cat_arr["details$i"]['cat_id'] = $row['id'];
            $cat_arr["details$i"]['cat_name'] = $row['name'];
            $i++;
        }
        return $cat_arr;
    }

    function getUserDownlinesAll($user_id) {
        $arr1[] = $user_id;
        $this->referals = null;
        //$limit = $this->getDepthCeiling();
        $i = 0;
        $level_arr = $this->getAllReferrals($arr1, $i);

        return $level_arr;
    }

    public function getDepthCeiling() {


        $depth_cieling = 0;
        $this->db->select("depth_cieling");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $depth_cieling = $row['depth_cieling'];
        }
        return $depth_cieling;
    }

    public function getAllReferrals($user_id_arr, $i) {
        $temp_user_id_arr = array();
        $temp = 0;
        if (count($user_id_arr)) {
            $qr = $this->createQuery($user_id_arr);
            $res = $this->db->query("$qr");
            foreach ($res->result_array() AS $row) {
                $user_array = array(
                    "user_id" => $row['id'],
                    //"customer_id" => $row['oc_customer_ref_id'],
                    "user_name" => $row['user_name'],
                );
                $this->user_downlines[$i][] = $user_array;
                $temp_user_id_arr[] = $row['id'];
                $temp = $row['id'];
            }
        }
        $i = $i + 1;

        if ($temp) {
            $this->getAllReferrals($temp_user_id_arr, $i);
        }

        return $this->user_downlines;
    }

    public function createQuery($user_id_arr) {
        $this->load->database();
        $db_prefix = $this->db->dbprefix;
        $ft_individual = $db_prefix . "ft_individual";
        $arr_len = count($user_id_arr);
        for ($i = 0; $i < $arr_len; $i++) {
            $user_id = $user_id_arr[$i];
            if ($i == 0) {
                $where_qr = "father_id = '$user_id'";
            } else {
                $where_qr .= " OR father_id = '$user_id'";
            }
        }
        $qr = "Select id, user_name from $ft_individual where ($where_qr) and active NOT LIKE 'server' ";

        return $qr;
    }

    function sendEmailToDownlines($mailBodyDetails, $from_user_id, $user_downlines, $subject) {
        foreach ($user_downlines AS $users) {
            $to_user_id = $users['user_id'];
            //$user_name = $this->validation_model->IdToUserName($to_user_id);
            //$email = $this->getUserEmail($user_name);
            //$this->sendMailUser($email, $mailBodyDetails, $subject);
            $this->sendMessageToDownlines($subject, $from_user_id, $to_user_id, $mailBodyDetails);
        }
        return TRUE;
    }

    public function sendMessageToDownlines($subject, $from_id, $to_id, $message) {
        $data = array(
            'mail_sub' => $subject,
            'mail_from' => $from_id,
            'mail_to' => $to_id,
            'message' => $message,
            'mail_date' => date("Y-m-d H:i:s")
        );
        $res = $this->db->insert('mail_from_lead', $data);
        return $res;
    }

    public function sendMessageToDownlinesCumulative($subject, $from_id, $to_id, $message, $type) {
        $data = array(
            'mail_sub' => $subject,
            'mail_from' => $from_id,
            'mail_to' => $to_id,
            'message' => $message,
            'type' => $type,
            'mail_date' => date("Y-m-d H:i:s")
        );
        $res = $this->db->insert('mail_from_lead_cumulative', $data);
        return $res;
    }

    public function getUserSendMessagesDownlines($user_id, $page, $limit) {
        $arr = array();
        $this->db->select('*');
        $this->db->from('mail_from_lead_cumulative');
        $this->db->where('mail_from', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mail_date', 'desc');
        $this->db->limit($limit, $page);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $arr[$i]["mailadid"] = $row["mail_id"];
            $arr[$i]["mailaduser"] = $row["mail_to"];
            $arr[$i]["mailadsubject"] = $row["mail_sub"];
            $arr[$i]["mailadiddate"] = $row["mail_date"];
            $arr[$i]["status"] = $row["status"];
            $arr[$i]["mailadidmsg"] = $row["message"];
            $arr[$i]["read_msg"] = 'NA';
            $arr[$i]["type"] = $row["type"];
            $i++;
        }
        return $arr;
    }

    public function getUserInboxMessagesDownlines($user_id, $page, $limit) {
        $arr = array();
        $this->db->select('*');
        $this->db->from('mail_from_lead');
        $this->db->where('mail_to', $user_id);
        $this->db->where('status', 'yes');
        $this->db->order_by('mail_date', 'desc');
        $this->db->limit($limit, $page);
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $arr[$i]["mailadid"] = $row["mail_id"];
            $arr[$i]["mailaduser"] = $row["mail_to"];
            $arr[$i]["mailadfromuser"] = $row["mail_from"];
            $arr[$i]["mailadsubject"] = $row["mail_sub"];
            $arr[$i]["mailadiddate"] = $row["mail_date"];
            $arr[$i]["status"] = $row["status"];
            $arr[$i]["mailadidmsg"] = $row["message"];
            $arr[$i]["read_msg"] = 'NA';
            $arr[$i]["type"] = $row["type"];
            $i++;
        }

        return $arr;
    }

    public function getCountUserSendMessagesDownlines($user_id) {

        $this->db->select('*');
        $this->db->from('mail_from_lead_cumulative');
        $this->db->where('status', 'yes');
        $this->db->where('mail_from', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCategoryName($category_id) {
        $category_name = "NA";
        $this->db->select('name');
        $this->db->from('ticket_tickets_categories');
        $this->db->where('id', $category_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $category_name = $row['name'];
        }
        return $category_name;
    }

    public function sendAllEmails($type = 'notification', $regr = array(), $attachments = array()) {

        //$attachments = array(BASEPATH . "../public_html/images/logos/logo.png");

        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();

        //$mail_type = $common_mail_settings['reg_mail_type']; //normal/smtp
        $mail_type = 'normal'; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array(
                "SMTPAuth" => $common_mail_settings['smtp_authentication'],
                "SMTPSecure" => ($common_mail_settings['smtp_protocol'] == "none") ? "" : $common_mail_settings['smtp_protocol'],
                "Host" => $common_mail_settings['smtp_host'],
                "Port" => $common_mail_settings['smtp_port'],
                "Username" => $common_mail_settings['smtp_username'],
                "Password" => $common_mail_settings['smtp_password'],
                "Timeout" => $common_mail_settings['smtp_timeout'],
                    //"SMTPDebug" => 3 //uncomment this line to check for any errors
            );
        }
        $mail_to = array("email" => $regr['email'], "name" =>"". " " . "");
        $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        $mail_reply_to = $mail_from;
        $mail_subject = "Notification";

        $mailBodyHeaderDetails = $this->getHeaderDetails($site_info);
        if ($type == "registration") {
            $content = $this->configuration_model->getEmailManagementContent($type,$regr['cur_lang_id']);
            $mail_altbody = html_entity_decode($content['content']);
            $mailBodyDetails = $this->getRegisterationMailDetails($mail_altbody, $regr);
//            $mailBodyDetails = str_replace("{fullname}", $regr['first_name'] . " " . $regr['last_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{username}", $regr['user_name_entry'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_name}", $site_info['company_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_address}", $site_info['company_address'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{sponsor_username}", $regr['sponsor_user_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{payment_type}", $regr['payment_type'], $mailBodyDetails);
            $mail_subject = $content['subject'] . ' ' . $site_info['company_name'];
        } else if ($type == "payout_release") {
            $content = $this->configuration_model->getEmailManagementContent($type);
            $mail_altbody = html_entity_decode($content['content']);
            $mailBodyDetails = $mail_altbody;
            $mailBodyDetails = str_replace("{fullname}", $regr['first_name'] . " " . $regr['last_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_name}", $site_info['company_name'], $mailBodyDetails);
            $mailBodyDetails = str_replace("{company_address}", $site_info['company_address'], $mailBodyDetails);
            $mail_subject = $content['subject'];
        } else if ($type == "change_password") {
            $content = "Your password has been sucessfully changed, Your new password is";
            $mail_altbody = $content;
            $mailBodyDetails = $this->getPasswordDetails($content, $regr);
            $mail_subject = 'Change Password';
        } else if ($type == "send_tranpass") {
            $content = "Your new Transaction Password is ";
            $mail_altbody = $content;
            $mailBodyDetails = $this->getTransactionPasswordDetails($content, $regr);
            $mail_subject = 'Transaction Password';
        }
        $mailBodyDetails = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $mailBodyDetails);
        $mailBodyFooterDetails = $this->getFooterDetails($site_info);
        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";

        $send_mail = $mail->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    public function getHeaderDetails($site_info) {
        $current_date = date('M d,Y H:i:s');
        $company_address = $site_info['company_address'];
        $company_name = $site_info['company_name'];
        $site_logo = $site_info['logo'];

        $mailBodyHeaderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
         <title>'.$company_name.'</title>
    
    </head>

    <body style="margin:0px;">
        <div class="container" style="font-family: roboto;
                width:830px;
                margin-left:auto;
                margin-right:auto;
                background:#f9f9f9;
                border-top:20px solid #ed0000;">
        
            <div class="header" style="height:117px;">
                <div style="float: left;">
                    <img src="'.$this->PUBLIC_URL.'images/logos/'.$site_logo.'" style="margin: 15px 0px 10px 19px;"/>
                </div>              
            </div>
            <div>
                <p style="font-size: 17px; line-height: 27px; color: ##353535;">'.$site_info["company_name"].', '.$site_info["company_address"].'
                </p>
            </div>';
        return $mailBodyHeaderDetails;
    }

    public function getFooterDetails($site_info) {
        $company_name = $site_info['company_name'];
        $company_mail = $site_info['email'];
        $company_phone = $site_info['phone'];
        $mailBodyFooterDetails = '<br><br><br><br><br>
        <div class="footer" style="text-align:center;
                            padding: 13px 0px 13px 0px;
                            background: #0A0A0A;
                            color:white;
                            border-top:1px solid #ed0000;
                            font-size:13px;">
            Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For all other    questions please contact our member support department by email <a href="mailto:' . $company_mail . '">' . $company_mail . '</a    >     or by phone at ' . $company_phone . '.</br>

        </div>
            
        </div>
    </body>

</html>';

        return $mailBodyFooterDetails;
    }

    public function getRegisterationMailDetails($mailDetails, $regr) {

        $date = date('Y M d');
        $username = $regr['username'];
        $mailBodyDetails = '<div class="table_inner" style="width:757px;
                            border:1px solid #eaeaea;
                            margin-left:auto;
                            margin-right:auto;">
                <div class="table_top_head" style="height:28px;
                            background:#dc3c30;
                            text-align:center;
                            color:white;
                            padding: 6px 0px 0px 0px;
                            text-transform:uppercase;
                            font-size:15px;">
                    LOGIN DETAILS
                </div>
                <div class="table_icon" style="height:40px;
                            padding-top: 22px;
                            text-align:center;
                            color:#fff;
                            padding: 15px 0px 0px 0px;
                            font-size: 20px;
                            background:#f54337;">' . $username . '</div>
                <div class="table_field"  style="background:#f8f8f8; height:31px;
                            font-size: 15px;
                            font-weight: 300;
                            padding: 8px 0px 0px 0px;
                            border-bottom:1px solid #eaeaea;">
                    <div class="table_fld_1" style="float: left; width: 278px; padding: 0px 0px 0px 100px;">Username </div>
                    <div class="table_fld_1" style="float: left; width: 278px; padding: 0px 0px 0px 100px;">' . $username . '</div>
                </div>
                <div class="table_field"  style="background:#fff; height:31px;
                            font-size: 15px;
                            font-weight: 300;
                            padding: 8px 0px 0px 0px;
                            border-bottom:1px solid #eaeaea;">
                    <div class="table_fld_1" style="float: left; width: 278px; padding: 0px 0px 0px 100px;">Password </div>
                    <div class="table_fld_1" style="float: left; width: 278px; padding: 0px 0px 0px 100px;">' . $regr["pswd"] . '</div>
                </div>
                <div class="table_field"  style="background:#f8f8f8; height:31px;
                            font-size: 15px;
                            font-weight: 300;
                            padding: 8px 0px 0px 0px;
                            border-bottom:1px solid #eaeaea;">
                    <div class="table_fld_1" style="text-align: center;"><a style="text-decoration:none; color: #F7763D; text-decoration: underline;" href="' . $this->BASE_URL . 'login/index/user/' . $this->ADMIN_USER_NAME . '/' . $username . '" target="_blank">Click Here </a> To Login </div>
                    
                </div>';
        $mailBodyDetails = $mailDetails . $mailBodyDetails;
        return $mailBodyDetails;
    }

    public function checkMailStatus($type) {
        $mail_status = 'no';
        $this->db->select('mail_status');
        $this->db->from('common_mail_settings');
        $this->db->where('mail_type', $type);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mail_status = $row->mail_status;
        }
        return $mail_status;
    }

    public function getPayoutDetails($mailDetails, $regr) {

        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
                      height: 58px;
                      color: #fff;
                      font-size: 21px;
                      padding: 43px 20px 20px 40px;">
                Payout released successfully!!!
            </div>
            <div class="body_text" style="padding:25px 65px 25px 45px;">
                <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">{fullname},</span></h1>
                <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; <p>Your payout has been released successfully</p></p>
            </div>';
        return $mailBodyDetails;
    }

    public function getPasswordDetails($mailDetails, $regr) {
        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
                      height: 58px;
                      color: #fff;
                      font-size: 21px;
                      padding: 43px 20px 20px 40px;">
                Password changed successfully!!!
            </div>
            <div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
                <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">'.$regr["full_name"].',</span></h1>
                <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; '.$mailDetails.' '.$regr["new_password"].'</p>
            </div>';
        return $mailBodyDetails;
    }

    public function getTransactionPasswordDetails($content, $regr) {

        $mailBodyDetails = '<div class="banner" style="background: url({banner_img});
                      height: 58px;
                      color: #fff;
                      font-size: 21px;
                      padding: 43px 20px 20px 40px;">
                Transaction password changed successfully!!!
            </div>
            <div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
                <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">'.$regr["first_name"].',</span></h1>
                <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp; '.$content.' '.$regr["tranpass"].'</p>
            </div>';
        return $mailBodyDetails;
    }

}
