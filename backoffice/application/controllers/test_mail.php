<?php

require_once 'admin/Inf_Controller.php';

class test_mail extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    public function send_mail() {
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $mail_type = "smtp"; //normal/smtp
        $smtp_data = array();
        if ($mail_type == "smtp") {
            $smtp_data = array("SMTPAuth" => true,
                "SMTPSecure" => "tls",
                "Host" => "mail.ioss.in",
                "Port" => 25 ,
                "Username" => "iossmlm@ioss.in",
                "Password" => "ceadecs001",
                "Timeout" => 300,
                "SMTPDebug" => 3,
            );
        }
        $mail_to = array("email" => "jiji@ioss.in", "name" => "Jiji P");
        $mail_from = array("email" => "info@ioss.in", "name" => "Infinite Open Source Solutions LLP");
        $mail_reply_to = $mail_from;
        $mail_subject = "Email subject";
        $mail_body = "It's a test message!!! With ssl";
        $mail_altbody = "Plain text message";
        $attachments = array(BASEPATH . "../public_html/images/logos/logo.png");

        $send_mail = $mail->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status']) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }
        print_r($data);
        return $send_mail;
    }

}
