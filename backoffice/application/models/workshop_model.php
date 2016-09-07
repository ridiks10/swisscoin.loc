<?php

Class workshop_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function editWorkshop($id) {
        $this->db->where('workshop_id', $id);
        $query = $this->db->get('workshop');
        foreach ($query->result_array() as $rows) {
            $obj_arr["workshop_id"] = $rows['workshop_id'];
            $obj_arr["workshop_title"] = $rows['workshop_title'];
          //  $obj_arr["workshop_desc"] = $rows['workshop_desc'];
            $obj_arr["workshop_date"] = $rows['workshop_date'];
        }
        return $obj_arr;
    }

    public function deleteWorkshop($id) {
        $this->db->where('workshop_id', $id);
        $result = $this->db->delete('workshop');
        return $result;
    }

    /**
     * 
     * @param string $workshop_title This value will be escaped!
     * @param string $image This value will be escaped!
     * @param string $link This value will be escaped!
     * @return bool
     */
    public function addWorkshop($workshop_title, $image, $link) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('workshop_title', $workshop_title);
      //  $this->db->set('workshop_desc', $workshop_desc);
        $this->db->set('workshop_date', $date);
        $this->db->set('workshop_image', $image);
        $this->db->set('link', $link);
        $result = $this->db->insert('workshop');
        return $result;
    }

    /**
     * 
     * @param int $workshop_id This value will be escaped!
     * @param string $workshop_title This value will be escaped!
     * @param string $link This value will be escaped!
     * @return bool
     */
    public function updateWorkshop($workshop_id, $workshop_title, $link) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('workshop_title', $workshop_title);
       // $this->db->set('workshop_desc', $workshop_desc);
        $this->db->set('workshop_date', $date);
        
         $this->db->set('link', $link);
        $this->db->where('workshop_id', $workshop_id);
        $result = $this->db->update('workshop');
        return $result;
    }
    public function updateWorkshopImage($workshop_id,$image){
        $this->db->set('workshop_image', $image);
        $this->db->where('workshop_id', $workshop_id);
        $result = $this->db->update('workshop');
        return $result;
        
    }
    public function getAllWorkshop() {
        $obj_arr = array();
        $this->db->order_by("workshop_date", "desc");
        $query = $this->db->get('workshop');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["workshop_id"] = $row['workshop_id'];
            $obj_arr[$i]["workshop_title"] = $row['workshop_title'];
            //$obj_arr[$i]["workshop_desc"] = $row['workshop_desc'];
            $obj_arr[$i]["workshop_date"] = $row['workshop_date'];
            $obj_arr[$i]["workshop_image"] = $row['workshop_image'];
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

    public function getAllWorkshopLetters($user_id) {
        $obj_arr = array();
        $this->db->order_by("date", "desc");
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $user_id);
        $query = $this->db->get('workshopletter');
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

    public function deleteWorkshopLetter($id) {
        $this->db->set('status', 'no');
        $this->db->where('id', $id);
        $res = $this->db->update('workshopletter');
        return $res;
    }

    public function sendWorkshopLetterToSubscribers($email_id, $subject, $message) {
        $this->load->model('mail_model');
        $result = $this->mail_model->sendEmail($message, $email_id, $subject, '');
        return $result;
    }

    public function checkMailId($email_id, $owner_id) {
        $flag = false;
        $this->db->select("*");
        $this->db->from("workshopletter");
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

    public function getAllWorkshopLettersMailId($owner_id) {
        $obj_arr = array();
        $this->db->select('email');
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $owner_id);
        $query = $this->db->get('workshopletter');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i] = $row['email'];
            $i++;
        }
        return $obj_arr;
    }

    public function insertWorkshopletterHistory($email, $subject, $content, $owner_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('owner_id', $owner_id);
        $this->db->set('email', $email);
        $this->db->set('subject', $subject);
        $this->db->set('content', $content);
        $this->db->set('date', $date);
        $res = $this->db->insert('workshopletter_history');
        return $res;
    }
    public function getWorkshopDetails($workshop_id){
       
        $obj_arr = array();
        $this->db->select('*');
        $this->db->where('workshop_id', $workshop_id);
        $query = $this->db->get('workshop');
       
        foreach ($query->result() as $row) {
            $obj_arr['title'] =  $row->workshop_title;
            $obj_arr['link'] =  $row->link;
            $obj_arr['workshop_image'] =  $row->workshop_image;
            }
        return $obj_arr;
    }
      public function getWorkshop(){
        $workshop = array();
        $this->db->select('*');
        $this->db->order_by("workshop_date",'desc'); 
        $query = $this->db->get('workshop');
        
        $i = 0;
        foreach ($query->result_array() as $row){
            $workshop[$i] = $row;
            $i++;
        }
        return $workshop;
    }

}