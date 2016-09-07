<?php

class Android_inf_model extends Core_Inf_Model {

    function __construct() {
        parent::__construct();
    }

    public function login_user($username, $password = '') {
        if ($username) {
            $this->db->select('user_id, user_name, password,user_type');
            $this->db->from('login_user');
            $this->db->where('user_name = ' . "'" . $username . "'");
            if ($password != '') {
                $this->db->where('password = ' . "'" . MD5($password) . "'");
            }
            $this->db->where('addedby', "code");
            $this->db->limit(1);
            $query = $this->db->get();
        } else {
            return false;
        }
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getAdminDetails($username) {

        $login_details = array();
        $this->db->select('user_id, user_name');
        $this->db->from('login_user');
        $this->db->where('user_name = ' . "'" . $username . "'");
        $this->db->where('addedby', "code");
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() AS $row) {
            $login_details ['id'] = $row["user_id"];
            $login_details ['user_name'] = $row["user_name"];
        }

        return $login_details;
    }

    public function getUserDetails($user_id) {
        $details = array();

        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];

        $this->load->model('home_model');

        $details['user_id'] = $user_id;
        $details['table_prifix'] = $table_prefix;
        $details['email'] = $this->validation_model->getUserEmailId($user_id);
        //JOINING DETAILS
        $details['total_joining'] = $this->home_model->totalJoiningUsers($user_id);
        $details['today_joining'] = $this->home_model->todaysJoiningCount($user_id);
        $details['balance_amount'] = $this->validation_model->getUserBalanceAmount($user_id);

        //AMOUNT DETAILS
        $ewallet_status = $this->MODULE_STATUS['ewallet_status'];
        if ($ewallet_status == 'yes') {
            $details['total_amount'] = $this->home_model->getGrandTotalEwallet($user_id);
            $details['requested_amount'] = $this->home_model->getTotalRequestAmount($user_id);
            $details['total_request'] = $this->home_model->getGrandTotalEwallet($user_id);
            $details['total_released'] = $this->home_model->getTotalReleasedAmount($user_id);
            if ($details['total_released'] == '') {
                $details['total_released'] = 0;
            }
            if ($details['requested_amount'] == '') {
                $details['requested_amount'] = 0;
            }
        } else {
            $details['total_amount'] = 0;
            $details['requested_amount'] = 0;
            $details['total_request'] = 0;
            $details['total_released'] = 0;
        }
        //epin
        $pin_status = $this->MODULE_STATUS['pin_status'];
        if ($pin_status == 'yes') {
            $details['total_pin'] = $this->home_model->getAllPinCount($user_id);
            $details['used_pin'] = $this->home_model->getUsedPinCount($user_id);
            $details['requested_pin'] = $this->home_model->getRequestedPinCount($user_id);
        } else {
            $details['total_pin'] = 0;
            $details['used_pin'] = 0;
            $details['requested_pin'] = 0;
        }
        //mail
        $details['read_mail'] = $this->home_model->getAllReadMessages('user');
        $details['unread_mail'] = $this->home_model->getAllUnreadMessages('user');
        $details['mail_today'] = $this->home_model->getAllMessagesToday('user');
        //user photo
        $details['photo_name'] = $this->userPhoto($user_id);

        return $details;
    }

    public function getReferalDetails($user_id, $table_prefix = NULL) {

        $this->load->model('country_state_model');

        if ($user_id != NULL) {

            $this->db->select('user_detail_refid');
            $this->db->select('user_detail_name');
            $this->db->select('join_date');
            $this->db->select('user_detail_email');
            $this->db->select('user_detail_country');
            $this->db->from('user_details');
            $this->db->where('user_details_ref_user_id', $user_id);
            $query = $this->db->get();

            $i = 0;
            foreach ($query->result_array() as $row) {
                $user_id = $row['user_detail_refid'];
                $arr[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $arr[$i]['name'] = $row['user_detail_name'];
                $arr[$i]['join_date'] = $row['join_date'];
                $arr[$i]['email'] = $row['user_detail_email'];
                $arr[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
                $i++;
            }

            for ($j = 0; $j < count($arr); $j++) {
                if ($arr[$j]['email'] == NULL)
                    $arr[$j]['email'] = 'NA';
                if ($arr[$j]['country'] == NULL)
                    $arr[$j]['country'] = 'NA';
            }
            return $arr;
        }
    }

    public function getIncome($id) {
        $array = array();
        $tot_amount = 0;
        $this->db->select('amount_type,amount_payable,user_id,user_level,from_id');
        $this->db->from('leg_amount');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $view_amt_type = $this->validation_model->getViewAmountType($row["amount_type"]);
            $array["$i"]["amount_type"] = $view_amt_type;
            $array[$i]["amount_payable"] = $row["amount_payable"];
            if ($row["from_id"]) {
                $array[$i]["from_id"] = $this->userIdToName($row["from_id"]);
            } else {
                $array["det$i"]["from_id"] = "NA";
            }

            $array["$i"]["user_level"] = $row["user_level"];
            $tot_amount+=$array[$i]["amount_payable"];
            $array[$i]['tot_amount'] = $tot_amount;
            $i++;
        }
        return $array;
    }

    public function userIdToName($user_id) {
        $user_name = $this->validation_model->IdToUserName($user_id);
        return $user_name;
    }

    public function getIncomeCount($user_id) {
        $this->db->from('leg_amount');
        $this->db->where('user_id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function checkSponsorNameAvailability($user_id) {
        $this->db->from('leg_amount');
        $this->db->where('user_id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function checkSponsorExist($user_id) {
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    function validatePswd($password) {

        if (!preg_match('/^[a-z0-9A-Z_\-!@#\$%&\*\(\)?<>|\\+\/\[\]{}\'";=]*$/', $password)) {

            return false;
        } else
            return true;
    }

    function getAllProducts() {

        $product_details = array();
        $i = 0;
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('active', 'yes');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $product_details[$i]['product_id'] = $row['product_id'];
            $product_details[$i]['product_name'] = $row['product_name'];
            $product_details[$i]['date_of_insertion'] = $row['date_of_insertion'];
            $product_details[$i]['prod_id'] = $row['prod_id'];
            $product_details[$i]['product_value'] = $row['product_value'];
            $product_details[$i]['bv_value'] = $row['bv_value'];
            $product_details[$i]['pair_value'] = $row['pair_value'];
            $product_details[$i]['product_qty'] = $row['product_qty'];
            $i = $i + 1;
        }
        return $product_details;
    }

    public function getProductDetails($product_id = '', $status = 'yes') {
        $product_details = array();
        $this->load->model('product_model');
        $MODULE_STATUS = $this->product_model->trackModule();

        if ($MODULE_STATUS['opencart_status_demo'] != "yes") {
            $this->db->select('*');
            if ($product_id != '') {
                $this->db->where('product_id', $product_id);
            }
            if ($status != '') {
                $this->db->where('active', $status);
            }
            $query = $this->db->get('package');
            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        } else {
            $where = '';
            if ($product_id != '') {
                $where = ' WHERE product_id =' . $product_id;
            }
            $query = $this->db->query("SELECT product_id,model AS product_name,pair_value,price AS product_value FROM " . $this->db->ocprefix . "product $where");

            foreach ($query->result_array() as $row) {
                $product_details[] = $row;
            }
        }
        return $product_details;
    }

    public function userPhoto($user_id) {
        $user_photo = 'nophoto.jpg';
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_photo = $row->user_photo;
        }
        return $user_photo;
    }

    public function updateUserDetails($regr, $uid) {

        $this->db->where('user_detail_refid', $uid);
        $reg_update = array(
            'user_detail_second_name' => $regr['second_name'],
            'user_detail_name' => $regr['first_name'],
            'user_detail_address' => $regr['address'],
            'user_detail_address2' => $regr['address_line2'],
            'user_detail_country' => $regr['country'],
            'user_detail_state' => $regr['state'],
            'user_detail_city' => $regr['city'],
            'user_detail_mobile' => $regr['mobile'],
            'user_detail_land' => $regr['land_line'],
            'user_detail_email' => $regr['email'],
            'user_detail_pin' => $regr['pin'],
            'user_detail_acnumber' => $regr['bank_acc_no'],
            'user_detail_ifsc' => $regr['ifsc'],
            'user_detail_nbank' => $regr['bank_name'],
            'user_detail_nbranch' => $regr['bank_branch'],
            'user_detail_pan' => $regr['pan_no'],
            'user_detail_dob' => $regr['date_of_birth'],
            'user_detail_gender' => $regr['gender']
        );

        $reg_res = $this->db->update('user_details', $reg_update);
        return $reg_res;
    }

    public function sendAllEmails($type = 'notification', $regr = array(), $attachments = array(), $user_id, $email) {

        $attachments = array(BASEPATH . "../public_html/images/logos/logo.png");
        $this->load->library('Inf_PHPMailer');
        $mail = new Inf_PHPMailer();

        $this->load->model('login_model');
        $keyword = $this->login_model->getKeyWord($user_id);
        $site_info = $this->validation_model->getSiteInformation();
        $common_mail_settings = $this->configuration_model->getMailDetails();
        $reset_password = $this->resetUserPassword($user_id, $keyword);
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
        $mail_to = array("email" => $email, "name" => $regr['first_name'] . " " . $regr['last_name']);
        $mail_from = array("email" => $site_info['email'], "name" => $site_info['company_name']);
        $mail_reply_to = $mail_from;
        $mail_subject = "Notification";

        $mailBodyHeaderDetails = $this->getHeaderDetails($site_info);
        $mail_altbody = html_entity_decode('password_recovery');
        $mailBodyDetails = '<body>
<table border="0" width="800" height="700" align="center">
<tr>
<td    colspan="4"valign="top" ><br><br><br>
<br>
<font size="3" face="Trebuchet MS">
Dear  Customer,</b><br>
     <p syte="pading-left:20px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your password sucessfully changed.Your new password is ' . $keyword . '.Please use this password to login your account:<p>
  
  <br><br><br>
  </td>
</tr>
</font>
</table>
</body>';
        $mail_subject = 'Password Recovery';
        $mailBodyFooterDetails = $this->getFooterDetails($site_info);
        $mail_body = $mailBodyHeaderDetails . $mailBodyDetails . $mailBodyFooterDetails . "</br></br></br></br></br>";


        $send_mail = $mail->send_mail($mail_from, $mail_to, $mail_reply_to, $mail_subject, $mail_body, $mail_altbody, $mail_type, $smtp_data, $attachments);

        if (!$send_mail['status'] || !$reset_password) {
            $data["message"] = "Error: " . $send_mail['ErrorInfo'];
        } else {
            $data["message"] = "Message sent correctly!";
        }


        return $send_mail;
    }

    public function getHeaderDetails($site_info) {
        $current_date = date('M d,Y H:i:s');
        $company_address = $site_info['company_address'];
        $company_name = $site_info['company_name'];
        $site_logo = $site_info['logo'];

        $mailBodyHeaderDetails = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>' . $company_name . '</title>
    </head>
    <body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
        
        <div style="width: 680px;">
        
            <div style="padding: 20px; border:solid 5px #ccc; ">

                <div style="width:100%; left:0px; float:left;">
                
                    <a href=" " title="' . $company_name . '"> 
                        <img src="' . $this->BASE_URL . 'public_html/images/logos/' . $site_logo . '" alt="' . $company_name . '" style="margin-bottom:-6px; border: none; margin-right:-100px; margin-bottom:5px;float:left;" />
                    </a>
                    <br><br></br></br><br><br>
                    <span style="color:rgb(225, 0, 0);float:left;text-align:left;position:relative;">    
                        <b style=" word-break: break-all;">' . $company_name . "</br>" . $company_address . '</b>
                        <br><font color="blue">' . $current_date . '</font>
                    </span>          
                </div>
                <hr>
                <table style="margin-bottom: 20px;">
                    <tbody>
                        <tr>
                            <td style="font-size: 12px;text-align: left; padding: 7px;">';
        return $mailBodyHeaderDetails;
    }

    public function getFooterDetails($site_info) {
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
               Please do not reply to this email. This mailbox is not monitored and you will not receive a response. For all other    questions please contact our member support department by email <a href="mailto:' . $company_mail . '">' . $company_mail . '</a    >     or by phone at ' . $company_phone . '.</br></br></p>

                    <p style="margin-top: 0px; margin-bottom: 20px; text-align : center;">Copyright &copy; ' . date("Y") . '&nbsp;<a href="' . $this->BASE_URL . '">' . $company_name . '</a> &nbsp;All Rights Reserved.
                    </p>
                </div>
            </div>
        </body>
    </html>';

        return $mailBodyFooterDetails;
    }

    public function getUserDetailsNames($user_id) {
        $details = array();
        $this->db->select('user_detail_name,user_detail_second_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details['first_name'] = $row['user_detail_name'];
            $details['last_name'] = $row['user_detail_second_name'];
        }
        return $details;
    }

    public function resetUserPassword($user_id, $keyword) {
        $password = md5($keyword);
        $user_type = $this->LOG_USER_TYPE;
        $this->db->set("password", $password);
        $this->db->where("user_id", $user_id);
        $result_1 = $this->db->update("login_user");
        if ($user_type == 'admin' && DEMO_STATUS == 'yes') {
            $res = $this->db->query("update infinite_mlm_user_detail SET pswd ='$password' WHERE id='$user_id'");
        }

        $this->db->set("reset_status", 'yes');
        $this->db->where("keyword", $keyword);
        $result_2 = $this->db->update("password_reset_table");
        if ($result_1 && $result_2) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getCountEmail($email, $id = '') {
        $this->db->from('user_details');
        if ($id != '') {
            $this->db->where('user_detail_refid !=', $id);
        }
        $this->db->where('user_detail_email', $email);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getCountryIDFromName($country_name) {
        $country_id = 0;
        $this->db->select('country_id');
        $this->db->from('infinite_countries');
        $this->db->where('country_name', $country_name);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $country_id = $row->country_id;
        }
        return $country_id;
    }

    public function getStateIdFromName($state_name) {
        $state_id = 0;
        if ($state_name == 'NA') {
            return 0;
        }
        $this->db->select("state_id");
        $this->db->from("infinite_states");
        $this->db->where('state_name', $state_name);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $state_id = $row->state_id;
        }
        return $state_id;
    }

    public function updateUserProfileImage($user_id, $imagename) {
        $this->db->set('user_photo', $imagename);
        $this->db->where('user_detail_refid', $user_id);
        $result = $this->db->update('user_details');
        return $result;
    }

}
