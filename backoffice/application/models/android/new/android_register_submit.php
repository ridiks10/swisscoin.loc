<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of androidRegisterSubmit
 *
 * @author ioss
 */
class AndroidRegisterSubmit extends CI_Model{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function getMaxOrderID($tprefix) {

        $max_order_id = "";
        $this->db->select_max('order_id', 'order_id');
        $this->db->from($tprefix.'_ft_individual');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_order_id = $row->order_id;
        }
        return $max_order_id;
    }
    public function getChildNodeId($tprefix, $father_id, $postion, $active = 'server') {
        
        $ft_individual = $tprefix . "_ft_individual";
        $this->db->select('id');
        $this->db->from($ft_individual);
        $this->db->where('father_id', $father_id);
        $this->db->where('position',$postion);
        $this->db->where('active',$active);
        $query = $this->db->get();
        $row = $query->row();
        $id_child = $row->id;
        return $id_child;
    }
    public function updateLoginUser($tprefix, $username, $pwd, $id_up) {
        $data = array(
            'user_name' => $username,
            'password' => $pwd,
            'user_type' => 'distributor',
            'addedby' => 'code'
        );
        $this->db->where('user_id', $id_up);
        $result1 = $this->db->update($tprefix.'_login_user', $data);
        return $result1;
    }
    
    public function getLevel($tprefix,$id) {
        $this->db->select("user_level");
        $this->db->from($tprefix."_ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_level = $row->user_level;
        }
        return $user_level;
    }
    
    public function updateFTIndividual($tprefix, $father_id, $position, $username, $id_up, $user_level = '', $product_id='', $order_id, $reg_by_using) {
        $time_now = date("Y-m-d H:i:s");
        $this->db->set('father_id', $father_id);
        $this->db->set('position', $position);
        $this->db->set('user_name', $username);
        $this->db->set('order_id', $order_id);
        $this->db->set('active', 'yes');
        $this->db->set('date_of_joining', $time_now);
        $this->db->set('user_level', $user_level);
        if ($product_id == '') {
            $this->db->set('register_by_using', $reg_by_using);
        } else {
            $this->db->set('product_id', $product_id);
            
        }
        $this->db->where('id', $id_up);
        $result = $this->db->update($tprefix.'_ft_individual');
        return $result;
    }
    
    public function insertToUnilevelTree($tprefix, $regr) {
        
        $order_id = $this->getMaxOrderIDUnilevel($tprefix);
        $new_order_id = $order_id + 1;
        
        $position = $this->getPositionUnilevel($tprefix,$regr['referral_id']);
        $new_position = $position + 1;
        
        $level = $this->getFatherLevelUni($tprefix,$regr['referral_id']);
        $new_level = $level + 1;
        
        $product_id = $regr['product_id'];
        $data = array(
            'id' => $regr['userid'],
            'user_name' => $regr['username'],
            'father_id' => $regr['referral_id'],
            'order_id' => "$new_order_id",
            'active' => 'yes',
            'position' => "$new_position",
            'product_id' => "$product_id",
            'user_level' => "$new_level",
            'date_of_joining' => $regr['joining_date']
        );
        $res = $this->db->insert($tprefix.'_ft_individual_unilevel', $data);
        return $res;
    }
    
    public function getMaxOrderIDUnilevel($tprefix) {
        $max_order_id = "";
        $this->db->select_max('order_id', 'order_id');
        $this->db->from($tprefix.'_ft_individual_unilevel');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $max_order_id = $row->order_id;
        }
        return $max_order_id;
    }
    public function getPositionUnilevel($tprefix,$father_id) {
        $position = "";
        $this->db->select_max('position', 'position');
        $this->db->where('father_id', $father_id);
        $this->db->from($tprefix.'_ft_individual_unilevel');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $position = $row->position;
        }
        return $position;
    }
    public function getFatherLevelUni($tprefix,$father_id) {
        $user_level = "";
        $this->db->select_max('user_level', 'user_level');
        $this->db->from($tprefix.'_ft_individual_unilevel');
        $this->db->where('id', $father_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_level = $row->user_level;
        }
        return $user_level;
    }
    
     public function insertUserDetails($tprefix,$regr, $details) {
         
        $flag = false;
        $done_by = $details["loginuser"];
        $this->insertUserActivity($tprefix,$regr['userid'], 'Register new member', $done_by);
       
        $data = array(
            'user_detail_refid' => $regr['userid'],
            'user_detail_name' => $details["name"],
            'user_details_ref_user_id' => $regr['referral_id'],
            'user_detail_address' =>$details["address"],
            'user_detail_nominee' => "NA",
            'user_detail_pan' =>  $details["pan"],
            'user_detail_town' => "NA",
            'user_detail_country' =>  $details["country"] ,
            'user_detail_state' => $details["state"],
            'user_detail_pin' => $details["pin"] ,
            'user_detail_mobile' => $details["mobile"],
            'user_detail_land' => $details["landphone"],
            'user_detail_email' =>  $details["email"],
            'user_detail_dob' => $details["dob"],
            'user_detail_gender' => $details["gender"],
            'join_date' =>  $regr['joining_date'],
            'user_detail_relation' =>"NA",
            'user_detail_acnumber' =>  $details["banckacno"],
            'user_detail_ifsc' => $details["ifsc"],
            'user_detail_nbank' => $details["bankname"],
            'user_detail_nbranch' =>$details["branchname"] 
        );
        $res = $this->db->insert($tprefix.'_user_details', $data);
        if ($res > 0) {
            $flag = true;
        }
        return $flag;
    }
     public function insertUserActivity($tprefix,$login_id, $activity, $done_by) {

        $date = date("Y-m-d H:i:s");
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $this->db->set('user_id', $login_id);
        $this->db->set('activity', $activity);
        $this->db->set('done_by', $done_by);
        $this->db->set('ip', $ip_adress);
        $this->db->set('date', $date);
        $result = $this->db->insert($tprefix.'_activity_history');
        return $result;
    }

    public function tmpInsert($tprefix, $father_id, $newpos) {
        $user_name1 = $this->str_rand(5, 9);
        $user_name = $user_name1 . $father_id;
        $insert_id = $this->insertInToFtIndividual($tprefix,$father_id, $newpos, $user_name);
        return $this->insertInToLoginUser($tprefix, $insert_id);
    }
    
     public function str_rand($minlength, $maxlength, $useupper = true, $usenumbers = true) {
        $key = "";
        $charset = "";
        if ($useupper)
            $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        if ($usenumbers)
            $charset .= "0123456789";
        if ($minlength > $maxlength)
            $length = mt_rand($maxlength, $minlength);
        else
            $length = mt_rand($minlength, $maxlength);
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        return $key;
    }
    
    public function insertInToFtIndividual($tprefix,$father_id, $position, $username) {
        $date = date("Y-m-d H:i:s");
        $data = array(
            'father_id' => $father_id,
            'position' => $position,
            'active' => 'server',
            'user_name' => $username,
        );
        $res = $this->db->insert($tprefix.'_ft_individual', $data);
        $insert_id = $this->db->insert_id();
        $data = array(
            'id' => $insert_id,
        );
        $result = $this->db->insert($tprefix.'_leg_details', $data);
        return $insert_id;
    }
    
     public function insertInToLoginUser($tprefix, $id) {
        $pwd = "";
        $pwd = md5($pwd);
        $data = array(
            'user_id' => $id,
            'user_name' => 'InfiniteMLM' . $id,
            'password' => $pwd,
            'addedby' => 'server',
        );
        $result = $this->db->insert($tprefix.'_login_user', $data);
        return $result;
    }
    
    public function getRandTransPasscode($tprefix,$length) {
        $key = "";
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];
        $randum_id = $key;

        $this->db->select("*");
        $this->db->from($tprefix."_tran_password");
        $this->db->where('tran_password', $randum_id);
        $qr = $this->db->get();
        $count = $qr->num_rows();
        if (!$count)
            return $key;
        else
            $this->getRandTransPasscode($tprefix,$length);
    }
    public function savePassCodes($tprefix,$user_id, $tran_code) {
        $this->db->set("user_id", $user_id);
        $this->db->set("tran_password", $tran_code);
        $res = $this->db->insert($tprefix."_tran_password");
        return $res;
    }
    public function getMailBody($tprefix) {

        $this->db->select('reg_mail_content');
        $this->db->from($tprefix.'_mail_settings');
        $res = $this->db->get();
        foreach ($res->result() as $row) {

            $reg_mail_content = $row->reg_mail_content;
        }
        return $reg_mail_content;
    }
      public function sendEmail($tprefix,$mailBodyDetails, $user_id, $subject) {
          
        $this->load->model("android/phpmailer");
        $mailObj = new PHPMailerAndroid();
        $email_details = $this->getCompanyEmail($tprefix);
       
        $email = $this->getUserEmailId($tprefix,$user_id);
        
        
        /*
    $config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.gmail.com',
  'smtp_port' => 465,
  'smtp_user' => 'infintemlm@gmail.com', // change it to yours
  'smtp_pass' => '123Infini?', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);

        $message = '';
        $this->load->library('email', $config);
      $this->email->set_newline("\r\n");
      $this->email->from('infintemlm@gmail.com'); // change it to yours
      $this->email->to($email);// change it to yours
      $this->email->subject($subject);
      $this->email->message($mailBodyDetails);
      if($this->email->send())
     {
      //echo 'Email sent.';
     }
     else
    {
     show_error($this->email->print_debugger());
    }
             */

        $mailObj->From = $email_details["id"];
        $mailObj->FromName = $email_details["name"];
        $mailObj->Subject = $subject;
        $mailObj->IsHTML(true);


        $mailObj->ClearAddresses();
        $mailObj->AddAddress($email);

        $mailObj->Body = $mailBodyDetails;
        $res = $mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $mailObj->ErrorInfo;
    }
    public function insertBalanceAmount($tprefix,$user_id) {
        $this->db->set('balance_amount', '0');
        $this->db->set('user_id', $user_id);
        $result = $this->db->insert($tprefix.'_user_balance_amount');
        return $result;
    }
     public function getCompanyEmail($tprefix) {
        $email = array();
        $this->db->select('email');
        $this->db->select('company_name');
        $this->db->from($tprefix.'_site_information');
        $this->db->where('id', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email["id"] = $row->email;
            $email["name"] = $row->company_name;
        }
        return $email;
    }
     public function getUserEmailId($tprefix,$user_id) {
        $email_id = NULL;
        $this->db->select("user_detail_email");
        $this->db->from($tprefix."_user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_id = $row->user_detail_email;
        }
        return $email_id;
    }


}
