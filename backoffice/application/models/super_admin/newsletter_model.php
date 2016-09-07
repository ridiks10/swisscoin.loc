<?php

class newsletter_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function selectUser($letters) {

        $query = $this->db->query("SELECT id, user_name FROM infinite_mlm_user_detail WHERE subscription_status='yes'");
        foreach ($query->result_array() AS $row) {
            $user_detail.= $row['id'] . "###" . $row['user_name'] . "|";
        }

        return $user_detail;
    }

    public function getAllNewsLettersMailId() {

        $user_detail = array();
        $query = $this->db->query("SELECT email,user_name FROM infinite_mlm_user_detail WHERE subscription_status='yes'");
        $i = 0;
        foreach ($query->result_array() AS $row) {
            $user_detail[$i]['user_email'] = $row['email'];
            $user_detail[$i]['user_name'] = $row['user_name'];
            $i++;
        }
        return $user_detail;
    }

    public function getSingleNewsLettersMailId($user_name) {

        $email_id = "NA";
        $query = $this->db->query("SELECT email FROM infinite_mlm_user_detail WHERE subscription_status='yes' AND user_name='$user_name'");

        foreach ($query->result() AS $row) {
            $email_id = $row->email;
        }
        return $email_id;
    }

    public function sendSubscriptonMails($email, $mail_subject, $type, $message = '',$user_name,$email_id) {
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();
        $regr['email'] = $email_id;
        $regr['name'] = $user_name;

        $site_info = $this->validation_model->getSiteInformation();
        $mailBodyHeaderDetails = $this->mail_model->getHeaderDetails($site_info);
        if ($type == 'news_letter') {
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

        $mailBodyFooterDetails = $this->getFooterDetails($site_info, $regr['email']);

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

    public function insertNewsletterHistory($user_name, $type, $subject, $message) {
        $date = date('Y-m-d H:i:s');
        $query = "INSERT INTO inf_news_letter_history (mlm_user_name, type, subject, message ,date)
VALUES ('$user_name', '$type', '$subject' ,'$message' ,'$date')";

        $result = mysql_query($query);
        return $result;
    }

    public function getUserCount($user_name) {
        $result = mysql_query("SELECT count(*) as total from infinite_mlm_user_detail WHERE user_name = '$user_name'");
        $data = mysql_fetch_assoc($result);
        return $data['total'];
    }

    public function getFooterDetails($site_info, $email) {

        $email = $this->encrypt->encode($email);
        $email = str_replace("/", "_", $email);
        $email = urlencode($email);
        $company_name = $site_info['company_name'];
        $company_mail = $site_info['email'];
        $company_phone = $site_info['phone'];
        $mailBodyFooterDetails = '</td>
                            </tr>
                        </tbody>       
                    </table> 
                    </br><b>Sincerely</b></br></br>Admin</b></br>.
                    <hr>         
                    <p style="margin-top: 0px; margin-bottom: 20px; font-size:small;">
               Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For all other    questions please contact our member support department by email <a href="mailto:' . $company_mail . '">' . $company_mail . '</a    >     or by phone at ' . $company_phone . '.If you do not wish to receive further emails from Infinite MLM Software, Please .<a href="' . $this->BASE_URL . 'super_admin/login/unsubscribe_user/' . $email . '"> Click Here</a> to unsubscribe</br></br></p>

                    <p style="margin-top: 0px; margin-bottom: 20px; text-align : center;">Copyright &copy; ' . date("Y") . '&nbsp;<a href="' . $this->BASE_URL . '">' . $company_name . '</a> &nbsp;All Rights Reserved. 
                    </p>
                </div>
            </div>
        </body>
    </html>';

        return $mailBodyFooterDetails;
    }

}
