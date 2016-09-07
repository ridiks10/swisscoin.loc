<?php

//require_once 'Inf_Model.php';

class webinars_model extends Inf_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function insertWebinar($post, $new_file_name = '',$img_name){
        $image=$img_name;
        $this->db->set('webinar_date',$post['date']);
        $this->db->set('url',$post['url']);
        $this->db->set('username',$post['user_name']);
        $this->db->set('password',$post['password']);
        $this->db->set('topic',$post['topic']);
        $this->db->set('description',$post['txtDefaultHtmlArea']);
        $this->db->set('date_added',date('Y-m-d H:i:s'));
        $this->db->set('image',$image);
        if($new_file_name){
            $this->db->set('video',$new_file_name);
        }
        $res = $this->db->insert('webinars');
    }
    public function updateWebinar($post, $webinar_id, $new_file_name){
        $this->db->set('webinar_date',$post['date']);
        $this->db->set('url',$post['url']);
        $this->db->set('username',$post['user_name']);
        $this->db->set('password',$post['password']);
        $this->db->set('topic',$post['topic']);
        $this->db->set('description',$post['txtDefaultHtmlArea']);
        $this->db->set('date_added',date('Y-m-d H:i:s'));
        if($new_file_name){
            $this->db->set('video',$new_file_name);
        }
        $this->db->where('webinar_id', $webinar_id);
        $this->db->limit(1);
        $res = $this->db->update('webinars');
        $a=  $this->db->last_query();        
    }
    public function updateWebinarImage($webinar_id, $img_name){
        $image=$img_name;
        $this->db->set('image',$image);
        $this->db->where('webinar_id', $webinar_id);
        $this->db->limit(1);
        $res = $this->db->update('webinars');
        $a=  $this->db->last_query();
        
    }
    public function getWebinars(){
        $webinars = array();
        $this->db->select('*');
        $this->db->where('deleted', 0);
        $this->db->order_by('date_added', 'desc');
        $query = $this->db->get('webinars');
        $i = 0;
        foreach ($query->result_array() as $row){
            $webinars[$i] = $row;
            $i++;
        }
        return $webinars;
    }
    public function getWebinar($webinar_id){
        $webinars = array();
        $this->db->select('*');
        $this->db->where('webinar_id', $webinar_id);
        $this->db->where('deleted', 0);
        $this->db->limit(1);
        $query = $this->db->get('webinars');
        foreach ($query->result_array() as $row){
            $webinars = $row;
        }
        return $webinars;
    }
    
    public function isWebinarValid($webinar_id){
        $count = 0;
        $this->db->where('webinar_id', $webinar_id);
        $this->db->where('deleted', 0);
        $this->db->limit(1);
        $query = $this->db->get('webinars');
        $count = $query->num_rows();
        if($count > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function deleteWebinar($webinar_id){
        $res = $this->db->set('deleted', 1);
        $res = $this->db->where('webinar_id', $webinar_id);
        $res = $this->db->limit(1);
        $res = $this->db->update('webinars');
        return $res;
    }

}
