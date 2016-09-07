<?php

class home_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getDemoDetails($demo_id) {
        $details = array();
        $query = $this->db->get_where('inf_project_info', array('id' => $demo_id));
        foreach ($query->result_array() as $row) {
            $details["mlm_plan"] = $row["mlm_plan"];
            $details["user_name"] = $row["user_name"];
            $details["account_status"] = $row["account_status"];
            $details["full_name"] = $row["full_name"];
            $details["phone"] = $row["phone"];
            $details["email"] = $row["email"];
            $details["reg_date"] = $row["reg_date"];
        }
        return $details;
    }

    public function blockDataBase($demo_id) {
        $this->db->set('account_status', 'blocked');
        $this->db->where('id', $demo_id); 
        $result = $this->db->update('project_info');
       if($result)
       {
           $details['demo_id'] = $demo_id;     
            $mail_subject = "Block Software";
            $type = 'block_software';
            $result = $this->sendSuperAdminMails($details, $mail_subject, $type,'',$demo_id);  
       }
        
        return $result;
    }

    public function unBlockDataBase($demo_id) {
        $this->db->set('account_status', 'active');
        $this->db->where('id', $demo_id);
        $result = $this->db->update('project_info');
         if($result)
       {
           $details['demo_id'] = $demo_id;
            $mail_subject = "Un Block Software";
            $type = 'un_block_software';
            $result = $this->sendSuperAdminMails($details, $mail_subject, $type,'',$demo_id);
       }
        return $result;
    }

    public function deleteDemo($demo_id, $delete_reason) {
        $result = $this->backupTables($demo_id);
        if ($result) {
            $result = $this->deleteTable($demo_id, $delete_reason);
        }
        if($result)
       {
           $details['demo_id'] = $demo_id;
            $mail_subject = "Delete Software";
            $type = 'delete_software';
            $result = $this->sendSuperAdminMails($details, $mail_subject, $type,'',$demo_id);
       }
        
        return $result;
    }

    public function changePassword($demo_id, $random_num) {
        $details = array();
        $result = $this->changePasswordSuperAdmin($demo_id, $random_num);
        if ($result) {
            $details['demo_id'] = $demo_id;
            $details['random_num'] = $random_num;
            $mail_subject = "Super admin change password";
            $type = 'change_password';
            $result = $this->sendSuperAdminMails($details, $mail_subject, $type,'',$demo_id);
        }
        return $result;
    }

    public function changePasswordSuperAdmin($demo_id, $random_num) {
        $random_number = md5($random_num);
        $this->db->set('signature', $random_number);
        $this->db->where('id', $demo_id);
        $result = $this->db->update('project_info');
        return $result;
    }

    public function backupTables($table_prefix) {

        $output = '';

        $database_name = 'revamp_plans';


        $query = $this->db->query("SHOW TABLES LIKE '$table_prefix%'");

        foreach ($query->result_array() AS $row) {

            $table = $row['Tables_in_' . $database_name . ' (' . $table_prefix . '%)'];

            if ($table_prefix) {
                if (strpos($table, $table_prefix) === false) {
                    $status = false;
                } else {
                    $status = true;
                }
            } else {
                $status = true;
            }

            if ($status) {
                $output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

                $query = $this->db->query("SELECT * FROM `" . $table . "`");

                foreach ($query->result_array() as $result) {
                    $fields = '';

                    foreach (array_keys($result) as $value) {
                        $fields .= '`' . $value . '`, ';
                    }

                    $values = '';

                    foreach (array_values($result) as $value) {
                        $value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
                        $value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
                        $value = str_replace('\\', '\\\\', $value);
                        $value = str_replace('\'', '\\\'', $value);
                        $value = str_replace('\\\n', '\n', $value);
                        $value = str_replace('\\\r', '\r', $value);
                        $value = str_replace('\\\t', '\t', $value);

                        $values .= '\'' . $value . '\', ';
                    }

                    $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
                }

                $output .= "\n\n";
            }
        }

        header("Pragma: public", true);
        header("Expires: 0", true);
        header("Content-Description: File Transfer", true);
        header("Content-Type: application/octet-stream", true);
        header("Content-Disposition: attachment; filename=" . $table_prefix . '_' . date('Y-m-d_H-i-s', time()) . "_backup.sql", true);
        header("Content-Transfer-Encoding: binary", true);

        echo $output;

        return true;
    }

    public function deleteTable($table_prifix, $delete_reason) {
        $query = $this->db->query("SELECT CONCAT('DROP TABLE `',t.table_schema,'`.`',t.table_name,'`;') AS stmt
   FROM information_schema.tables t
  WHERE t.table_schema = 'revamp_plans'
    AND t.table_name LIKE '$table_prifix\_%'");
        foreach ($query->result_array() AS $row) {
            $result = $this->db->query($row['stmt']);
        }

        if ($result) {
            $result = $this->updateInfDemoStatus($table_prifix, $delete_reason);
        }
        return $result;
    }

    public function updateInfDemoStatus($demo_id, $delete_reason) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('account_status', 'deleted');
        $this->db->set('delete_reason', $delete_reason);
        $this->db->set('date_deleted', $date);
        $this->db->where('id', $demo_id);
        $result = $this->db->update('project_info');
        return $result;
    }

    public function getActiveStatus($demo_id) {
        $this->db->select('account_status');
        $this->db->from('project_info');
        $this->db->where('id', $demo_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $active_status = $row->account_status;
        }
        return $active_status;
    }

    public function sendSuperAdminMails($details, $mail_subject, $type, $message = '',$demo_id) {

        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();
        $demodetails = $this->getEmailDetails($demo_id);
        $regr['email'] = $demodetails['email'];
        $regr['name'] = $demodetails['user_name'];

        $site_info = $this->validation_model->getSiteInformation();
        $mailBodyHeaderDetails = $this->mail_model->getHeaderDetails($site_info);
        if ($type == 'change_password') {
            $mailBodyDetails = $this->getPasswordUpdateMail($details['demo_id'], $details['random_num']);
        } else if ($type == 'block_software') {
            $mailBodyDetails = $this->blockMail($details['demo_id']);
        } else if ($type == 'un_block_software') {
            $mailBodyDetails = $this->UnblockMail($details['demo_id']);
        } else if ($type == 'delete_software') {
            $mailBodyDetails = $this->deleteSoftware($details['demo_id']);
        } else if ($type == 'news_letter') {
            $mailBodyDetails = $message;
        }

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

        $mailBodyFooterDetails = $this->mail_model->getFooterDetails($site_info);
        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";
        $site_info['name'] = 'Admin';
        $send_mail = $mail->send_mail($site_info, $regr, $site_info, $mail_subject, $mail_body, $mail_body, $mail_type, $smtp_data = array(), $attachments = array());

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    public function getPasswordUpdateMail($demo_id, $random_number) {
        $content = "Your superadmin password changed Sucessfully Your current Password is <b>$random_number </b></br>Demo id is <b>$demo_id</b>";
        return $content;
    }

    public function blockMail($demo_id) {
        $content = "Your System Blocked Your System ID is $demo_id";
        return $content;
    }

    public function UnblockMail($demo_id) {
        $content = "Your System UnBlocked Your System ID is $demo_id";
        return $content;
    }

    public function deleteSoftware($demo_id) {
        $content = "Your System Deleted Sucessfully Your System ID is $demo_id";
        return $content;
    }

    public function getEmailDetails($demo_id) {
     
        $details = array();
        $this->db->select('email,user_name');
        $this->db->from('project_info');
        $this->db->where('id', $demo_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details['email'] = $row['email'];
            $details['user_name'] = $row['user_name'];
        }
        return $details;
    }

}
