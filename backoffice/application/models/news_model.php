<?php

Class news_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function editNews($id) {
        $this->db->where('news_id', $id);
        $query = $this->db->get('news');
        foreach ($query->result_array() as $rows) {
            $obj_arr["news_id"] = $rows['news_id'];
            $obj_arr["news_title"] = $rows['news_title'];
            $obj_arr["news_desc"] = $rows['news_desc'];
            $obj_arr["news_date"] = $rows['news_date'];
        }
        return $obj_arr;
    }

    public function deleteNews($id) {
        $this->db->where('news_id', $id);
        $result = $this->db->delete('news');
        return $result;
    }

    public function addNews($news_title, $news_desc, $image, $link) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('news_title', $news_title);
        $this->db->set('news_desc', $news_desc);
        $this->db->set('news_date', $date);
        $this->db->set('news_image', $image);
        $this->db->set('link', $link);
        $result = $this->db->insert('news');
        return $result;
    }

    public function updateNews($news_id, $news_title, $news_desc, $image) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('news_title', $news_title);
        $this->db->set('news_desc', $news_desc);
        $this->db->set('news_date', $date);
        $this->db->set('news_image', $image);
        $this->db->where('news_id', $news_id);
        $result = $this->db->update('news');
        return $result;
    }

    public function getAllNews() {
        $obj_arr = array();
        $this->db->order_by("news_date", "desc");
        $query = $this->db->get('news');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i]["news_id"] = $row['news_id'];
            $obj_arr[$i]["news_title"] = $row['news_title'];
            $obj_arr[$i]["news_desc"] = $row['news_desc'];
            $obj_arr[$i]["news_date"] = $row['news_date'];
            $obj_arr[$i]["news_image"] = $row['news_image'];
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

    public function getAllNewsLetters($user_id) {
        $obj_arr = array();
        $this->db->order_by("date", "desc");
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $user_id);
        $query = $this->db->get('newsletter');
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

    public function deleteNewsLetter($id) {
        $this->db->set('status', 'no');
        $this->db->where('id', $id);
        $res = $this->db->update('newsletter');
        return $res;
    }

    public function sendNewsLetterToSubscribers($email_id, $subject, $message) {
        $this->load->model('mail_model');
        $result = $this->mail_model->sendEmail($message, $email_id, $subject, '');
        return $result;
    }

    public function checkMailId($email_id, $owner_id) {
        $flag = false;
        $this->db->select("*");
        $this->db->from("newsletter");
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

    public function getAllNewsLettersMailId($owner_id) {
        $obj_arr = array();
        $this->db->select('email');
        $this->db->where('status', 'yes');
        $this->db->where('owner_id', $owner_id);
        $query = $this->db->get('newsletter');
        $i = 0;
        foreach ($query->result_array() as $row) {
            $obj_arr[$i] = $row['email'];
            $i++;
        }
        return $obj_arr;
    }

    public function insertNewsletterHistory($email, $subject, $content, $owner_id) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('owner_id', $owner_id);
        $this->db->set('email', $email);
        $this->db->set('subject', $subject);
        $this->db->set('content', $content);
        $this->db->set('date', $date);
        $res = $this->db->insert('newsletter_history');
        return $res;
    }
    public function getNewsDetails($news_id){
       
        $obj_arr = array();
        $this->db->select('*');
        $this->db->where('news_id', $news_id);
        $query = $this->db->get('news');
       
        foreach ($query->result() as $row) {
            $obj_arr['title'] =  $row->news_title;
            $obj_arr['news_desc'] =  $row->news_desc;
            $obj_arr['link'] =  $row->link;
            $obj_arr['news_image'] =  $row->news_image;
        }
        return $obj_arr;
    }

    public function getLatestNews($user_id)
    {
        $news_entry = $this->db->from('news')->where(['DATE_ADD(news_date, INTERVAL 7 DAY) >' => date("Y-m-d H:i:s")])->order_by('news_date', 'DESC')->get()->first_row('array');
        if($news_entry){
            $is_viewed = $this->db->from('news_viewed')->where(['user_id' => $user_id, 'news_id' => $news_entry['news_id']])->get()->num_rows();
            return $is_viewed ? [] : $news_entry;
        }
        return [];
    }

    public function setViewedNews($news_id){
        return $this->db->insert('news_viewed', ['user_id' => $this->LOG_USER_ID, 'news_id' => $news_id]);
    }

    
}
