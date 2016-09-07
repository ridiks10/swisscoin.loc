<?php



class payment_model extends inf_model {

   
    public function updatePaymentMethod($id,$status) {
        
        $res="";
              
        if ($status == "yes") {
            
            $this->db->set('status', 'no');
            $this->db->where('id', $id);
            $res = $this->db->update("payment");
            
        } else if ($status == "no") {
            
            $this->db->set('status', 'yes');
            $this->db->where('id', $id);
            $res = $this->db->update("payment");
        }

        return $res;
    }
    
    public function getStatus() {

        $result = array();
        $this->db->select('*');
        $this->db->from("payment");
        $res = $this->db->get();
        $i = 0;
        
        foreach ($res->result_array() as $row) {
            
            $result[$i]['id'] = $row['id'];
            $result[$i]['status'] = $row['status'];
            $result[$i]['payment_type'] = $row['payment_type'];
            $i++;
        }
       
        
        return $result;
    }

    public function getModuleStatus() {

        $result = array();
        $this->db->select('pin_status');
        $this->db->select('ewallet_status');
        $this->db->from("module_status");
        $res = $this->db->get();
        $i = 0;
        
        foreach ($res->result_array() as $row) {
            
            $result[$i]['pin_status'] = $row['pin_status'];
            $result[$i]['ewallet_status'] = $row['ewallet_status'];           
            $i++;
        }
       
        return $result;
    }
}

?>
