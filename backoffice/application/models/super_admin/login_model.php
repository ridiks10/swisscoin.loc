<?php

class login_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function selectUser() {

        $query = $this->db->query("SELECT id, user_name FROM infinite_mlm_user_detail WHERE subscription_status='yes'");
        foreach ($query->result_array() AS $row) {
            $user_detail.= $row['id'] . "###" . $row['user_name'] . "|";
        }

        return $user_detail;
    }

    public function checkSuperAdmin($post_array) {
        $super_check = false;
        $user_name = $post_array["super_user_name"];
        $password = md5($post_array["super_password"]);

        $this->db->select('id,user_name,account_status,company_name,full_name,phone,email,subscription_status,reg_date,skype_id');
        $this->db->from('project_info');
        $this->db->where('key', $user_name);
        $this->db->where('signature', $password);
        //$this->db->where('account_status', 'active');
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $super_check = $row;
        }
        return $super_check;
    }

    public function setSuperAdminSession($super_logged_in) {
        $this->session->set_userdata("super_logged_in", $super_logged_in);
        $this->session->set_userdata("super_demo_id", $super_logged_in['id']);
    }

    public function blockDataBase($demo_id) {
        $this->db->set('active', 0);
        $this->db->where('admin_id', 1);
        $this->db->where('demo_id', $demo_id);
        $result = $this->db->update('super_admin');
        return $result;
    }

    public function unBlockDataBase($demo_id) {
        $this->db->set('active', 1);
        $this->db->where('admin_id', 1);
        $this->db->where('demo_id', $demo_id);
        $result = $this->db->update('super_admin');
        return $result;
    }

    public function deleteDemo($demo_id) {


        $result = $this->backupTables($demo_id);
        if ($result) {
            $result = $this->deleteTable($demo_id);
        }
        return $result;
    }

    public function changePassword($demo_id, $random_num) {

        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $random_number = md5($random_num);
        $this->db->set('password', $random_number);
        $this->db->where('admin_id', 1);
        $this->db->where('demo_id', $demo_id);
        $result = $this->db->update('super_admin');

        $this->load->model('mail_model');
        $regr['email'] = 'sanalpj90@gmail.com';
        $regr['name'] = 'sanalpj';
        $site_info = $this->validation_model->getSiteInformation();
        $mailBodyHeaderDetails = $this->mail_model->getHeaderDetails($site_info);

        $mailBodyDetails = $this->getSuperAdminPassword($demo_id, $random_num);

        $mail_subject = "Super admin change password";
        $mail_type = "Super admin change password";

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

    public function sendNotificationDeleteSystem($demo_id) {
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $this->load->model('mail_model');

        $mailBodyDetails = "Your System Deleted Your System ID is $demo_id";
        $mail_subject = "Delete Your System";
        $mail_type = "Delete Your System";

        $regr['email'] = 'sanalpj90@gmail.com';
        $regr['name'] = 'sanalpj';

        $regr_info['email'] = 'info@ioss.com';
        $regr_info['name'] = 'ioss';

        $site_info = $this->validation_model->getSiteInformation();
        $mailBodyHeaderDetails = $this->mail_model->getHeaderDetails($site_info);

        $mail_subject = "Super admin change password";
        $mail_type = "Super admin change password";

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

    public function getSuperAdminPassword($demo_id, $random_number) {
        $content = "Your superadmin password changed Sucessfully Your current Password is <b>$random_number </b></br>Demo id is <b>$demo_id</b>";
        return $content;
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

    public function deleteTable($table_prifix) {
        $query = $this->db->query("SELECT CONCAT('DROP TABLE `',t.table_schema,'`.`',t.table_name,'`;') AS stmt
   FROM information_schema.tables t
  WHERE t.table_schema = 'revamp_plans'
    AND t.table_name LIKE '$table_prifix\_%'");
        foreach ($query->result_array() AS $row) {
            $result = $this->db->query($row['stmt']);
        }

        if ($result) {
            $result = $this->updateInfDemoStatus($table_prifix);
        }
        return $result;
    }

    public function updateInfDemoStatus($demo_id) {
        $this->db->set('status', 'no');
        $this->db->where('demo_id', $demo_id);
        $result = $this->db->update('inf_super_admin');
        return $result;
    }

    public function getActiveStatus($demo_id) {
        $this->db->select('active');
        $this->db->from('super_admin');
        $this->db->where('demo_id', $demo_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $active_status = $row->active;
        }
        return $active_status;
    }

    public function insertDeleteReason($demo_id, $delete_reason) {
        $this->sendNotificationDeleteSystem($demo_id);
        $date = date('Y-m-d H:i:s');
        $this->db->set('demo_id', $demo_id);
        $this->db->set('reason', $delete_reason);
        $this->db->set('date', $date);
        $result = $this->db->insert('inf_super_admin_delete_reason');
        return $result;
    }

    public function sendNotificationMail($demo_id, $status = '') {
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $this->load->model('mail_model');
        if ($status == 'block') {
            $mailBodyDetails = "Your System Blocked Your System ID is $demo_id";
            $mail_subject = "Block Your System";
            $mail_type = "Block Your System";
        }
        if ($status == 'unblock') {
            $mailBodyDetails = "Your System UnBlocked Your System ID is $demo_id";
            $mail_subject = "UnBlock Your System";
            $mail_type = "UnBlock Your System";
        }

        $regr['email'] = 'sanalpj90@gmail.com';
        $regr['name'] = 'sanalpj';

        $regr_info['email'] = 'info@ioss.com';
        $regr_info['name'] = 'ioss';

        $site_info = $this->validation_model->getSiteInformation();
        $mailBodyHeaderDetails = $this->mail_model->getHeaderDetails($site_info);

        $mail_subject = "Super admin change password";
        $mail_type = "Super admin change password";

        $mailBodyFooterDetails = $this->mail_model->getFooterDetails($site_info);
        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";

        $site_info['name'] = 'Admin';
        $send_mail = $mail->send_mail($site_info, $regr, $site_info, $mail_subject, $mail_body, $mail_body, $mail_type, $smtp_data = array(), $attachments = array());

        $send_mail = $mail->send_mail($site_info, $regr_info, $site_info, $mail_subject, $mail_body, $mail_body, $mail_type, $smtp_data = array(), $attachments = array());

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }

        return $send_mail;
    }

    public function changeSubscriptionStatus($email) {
        $query = $this->db->query("UPDATE infinite_mlm_user_detail SET subscription_status='no' WHERE email = '$email'");
        return $query;
    }

}
