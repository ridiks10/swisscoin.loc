<?php

class document_model extends inf_model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function getAllDocuments()
    {
        $file_details=array();
        $this->db->order_by("uploaded_date", "desc");
        $query = $this->db->get('documents');
        $i=0;
        foreach ($query->result_array() as $row)
        {
            $file_details[$i]["id"]=$row['id'];
            $file_details[$i]["file_title"]=$row['file_title'];
            $file_details[$i]["doc_file_name"]=$row['doc_file_name'];
            $file_details[$i]["uploaded_date"]=$row['uploaded_date'];
            $i++;
        }
        return $file_details;
    }
    public function getDocumentsDetails($id){
        $file_details=array();
        $this->db->order_by("uploaded_date", "desc");
        $this->db->where('id',$id);
        $query = $this->db->get('documents');
        $i=0;
        foreach ($query->result_array() as $row)
        {
            $file_details[$i]["id"]=$row['id'];
            $file_details[$i]["file_title"]=$row['file_title'];
            $file_details[$i]["doc_file_name"]=$row['doc_file_name'];
            $file_details[$i]["uploaded_date"]=$row['uploaded_date'];
            $i++;
        }
        return $file_details;
    }
    
}

