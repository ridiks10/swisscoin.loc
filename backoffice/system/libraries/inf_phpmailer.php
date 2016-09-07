<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inf_PHPMailer {

    public $mail;

    function __construct() {
        require_once('PHPMailer/PHPMailerAutoload.php');
        $this->mail = new CI_PHPMailer();
    }

    public function send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type = "normal", $smtp_data = array(), $attachments = array()) {

        if ($mail_type == "smtp") {
            $this->mail->IsSMTP(); // we are going to use SMTP
            $this->mail->SMTPAuth = $smtp_data['SMTPAuth']; // enabled SMTP authentication
            $this->mail->SMTPSecure = $smtp_data['SMTPSecure'];  // prefix for secure protocol to connect to the server
            $this->mail->Host = $smtp_data['Host'];      // setting SMTP server
            $this->mail->Port = $smtp_data['Port'];                   // SMTP port to connect to GMail
            $this->mail->Username = $smtp_data['Username'];  // user email address
            $this->mail->Password = $smtp_data['Password'];            // password in GMail
            $this->mail->Timeout = $smtp_data['Timeout']; // The SMTP server timeout in seconds.
            if (isset($smtp_data['SMTPDebug'])) {
                $this->mail->SMTPDebug = $smtp_data['SMTPDebug']; 
            }
            $this->mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        } else {
            $this->mail->isSendmail();
        }

        $this->mail->setFrom($mail_from['email'], $mail_from['name']);  //Who is sending the email
        $this->mail->addReplyTo($mail_reply_to['email'], $mail_reply_to['name']);  //email address that receives the response
        $this->mail->Subject = $mail_subject;
        $this->mail->Body = $mail_body;
        $this->mail->AltBody = $mail_altbody;
        $this->mail->AddAddress($mail_to['email'], $mail_to['name']); // Who is addressed the email to

        if (count($attachments)) {
            foreach ($attachments AS $attachment) {
                $this->mail->AddAttachment("$attachment");      // some attached files
            }
        }

        if (!$this->mail->Send()) {
            $data["status"] = false;
            $data["ErrorInfo"] = "Error: " . $this->mail->ErrorInfo;
        } else {
            $data["status"] = true;
        }
        return $data;
    }

}
