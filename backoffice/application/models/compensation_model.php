<?php

Class compensation_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function editCompensation($id) {
        $this->db->where('compensation_id', $id);
        $query = $this->db->get('compensation');
        foreach ($query->result_array() as $rows) {
            $obj_arr["compensation_id"] = $rows['compensation_id'];
            $obj_arr["compensation_title"] = stripslashes($rows['compensation_title']);
            $obj_arr["compensation_desc"] = stripslashes($rows['compensation_desc']);
            $obj_arr["compensation_date"] = $rows['compensation_date'];
            $obj_arr["compensation_link"] = $rows['link'];
        }
        return $obj_arr;
    }

    public function deleteCompensation($id) {
        $this->db->where('compensation_id', $id);
        $result = $this->db->delete('compensation');
        return $result;
    }

    public function addCompensation($compensation_title, $compensation_desc,$image,$link) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('compensation_title', $compensation_title);
        $this->db->set('compensation_desc', $compensation_desc);
        $this->db->set('compensation_date', $date);
        $this->db->set('compensation_image', $image);
        $this->db->set('link', $link);
        $result = $this->db->insert('compensation');
        return $result;
    }

    public function updateCompensation($compensation_id, $compensation_title, $compensation_desc,$link) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('compensation_title', $compensation_title);
        $this->db->set('compensation_desc', $compensation_desc);
        $this->db->set('compensation_date', $date);
        
        $this->db->set('link', $link);
        $this->db->where('compensation_id', $compensation_id);
        $result = $this->db->update('compensation');
        return $result;
    }
    public function updateCompensationImage($compensation_id,$image){
        $this->db->set('compensation_image', $image);
        $this->db->where('compensation_id', $compensation_id);
        $result = $this->db->update('compensation');
        return $result;
        
    }

    public function getAllCompensation() {
        $obj_arr = array();
        $this->db->order_by("compensation_date", "desc");
        $this->db->limit(1);
        $query = $this->db->get('compensation');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["compensation_id"] = $row['compensation_id'];
            $obj_arr[$i]["compensation_title"] =stripslashes($row['compensation_title']) ;
            $obj_arr[$i]["compensation_desc"] = stripslashes($row['compensation_desc']);
            $obj_arr[$i]["compensation_date"] = $row['compensation_date'];
            $obj_arr[$i]["compensation_image"] = $row['compensation_image'];
            $obj_arr[$i]["link"] = $row['link'];
            $i++;
        }
        return $obj_arr;
    }

    public function addDocuments($file_title, $doc_file_name) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('file_title', $file_title);
        $this->db->set('doc_file_name', $doc_file_name);
        $this->db->set('uploaded_date', $date);
        $result = $this->db->insert('documents');
        return $result;
    }

    public function getAllDocuments() {
        $obj_arr = array();
        $this->db->order_by("uploaded_date", "desc");
        $query = $this->db->get('documents');
        $i = 0;
        foreach ($query->result_array() as $rows) {
            $obj_arr[$i]["id"] = $rows['id'];
            $obj_arr[$i]["file_title"] = $rows['file_title'];
            $obj_arr[$i]["doc_file_name"] = $rows['doc_file_name'];
            $obj_arr[$i]["uploaded_date"] = $rows['uploaded_date'];
            $i++;
        }
        return $obj_arr;
    }

    public function deleteDocument($delete_id) {
        $this->db->where('id', $delete_id);
        $result = $this->db->delete('documents');
        return $result;
    }

    public function getAllCompensationLetters($user_id) {
        $obj_arr = array();
        $this->db->order_by("date", "desc");
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $user_id);
        $query = $this->db->get('compensationletter');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["id"] = $row['id'];
            $obj_arr[$i]["owner_id"] = $row['owner_id'];
            $obj_arr[$i]["email"] = $row['email'];
            $obj_arr[$i]["date"] = $row['date'];
            $obj_arr[$i]["status"] = $row['status'];
            $i++;
        }

        return $obj_arr;
    }

    public function deleteCompensationLetter($id) {
        $this->db->set('status', 'no');
        $this->db->where('id', $id);
        $res = $this->db->update('compensationletter');
        return $res;
    }

    public function sendCompensationLetterToSubscribers($email_id, $subject, $message) {
        $this->load->model('mail_model');
        $result = $this->mail_model->sendEmail($message, $email_id, $subject, '');
        return $result;
    }

    public function checkMailId($email_id, $owner_id) {
        $flag = false;
        $this->db->select("*");
        $this->db->from("compensationletter");
        $this->db->where('email', $email_id);
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $owner_id);
        $qr = $this->db->get();

        $email_avail = $qr->num_rows();
        if ($email_avail > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getAllCompensationLettersMailId($owner_id) {
        $obj_arr = array();
        $this->db->select('email');
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $owner_id);
        $query = $this->db->get('compensationletter');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i] = $row['email'];
            $i++;
        }
        return $obj_arr;
    }

    public function insertCompensationletterHistory($email, $subject, $content, $owner_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('owner_id', $owner_id);
        $this->db->set('email', $email);
        $this->db->set('subject', $subject);
        $this->db->set('content', $content);
        $this->db->set('date', $date);
        $res = $this->db->insert('compensationletter_history');
        return $res;
    }
    public function getCompensationDetails($compensation_id){
       
        $obj_arr = array();
        $this->db->order_by("compensation_date", "desc");
        $this->db->limit(1);
        $query = $this->db->get('compensation');
       
        foreach ($query->result_array() as $row) {
            $obj_arr['title'] =  $row['compensation_title'];
            $obj_arr['compensation_desc'] = stripslashes($row['compensation_desc']);
            $obj_arr['link'] =  $row['link'];
            $obj_arr['compensation_image'] =  $row['compensation_image'];
            }
            
            
        return $obj_arr;
    }

}