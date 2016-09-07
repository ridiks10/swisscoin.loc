<?php

class member_model extends inf_model {

    private $mailObj;

    public function __construct() {
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();

        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
        $this->load->model('page_model');
    }

    public function blockMember($block_id, $status) {
        $res = $this->profile_class_model->blockMember($block_id, $status);
        return $res;
    }

    public function searchMembers($keyword, $page, $limit) {

        $mem_arr = $this->profile_class_model->searchMember($keyword, $page, $limit);
        return $mem_arr;
    }

    public function getCountMembers($keyword) {
        return $this->profile_class_model->getCountMembers($keyword);
    }

    public function activateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'activated');
        }
        return $result;
    }

    public function usertActivationDeactivationHistory($user_id, $type, $status = '') {
        $this->db->set('user_id', $user_id);
        $this->db->set('type', $type);
        $this->db->set('status', $status);
        $result = $this->db->insert('user_activation_deactivation_history');
        return $result;
    }

    public function inactivateAccount($user_id, $type = 'auto') {
        $result = FALSE;
        $this->db->set('active', 'no');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        if ($res) {
            $result = $this->usertActivationDeactivationHistory($user_id, $type, 'deactivated');
        }
        return $result;
    }

    public function isUserActive($user_id, $status) {
        $this->db->select('count(*) as cnt');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->where('active', $status);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function insertUpgradeHistory($user_id, $done_by, $status, $remarks) {
        $date = date('Y-m-d H:i:s');
        $this->db->set('user_id', $user_id);
        $this->db->set('done_by', $done_by);
        $this->db->set('status', $status);
        $this->db->set('remarks', $remarks);
        $this->db->set('date', $date);
        $result = $this->db->insert('upgrade_account_history');
        return $result;
    }

    public function activateAccountUser($user_id) {
        $this->db->set('active', 'yes');
        $this->db->where('id', $user_id);
        $res = $this->db->update('ft_individual');
        return $res;
    }

    public function isTranPass($user_id, $transaction_password) {
        $this->db->select('count(*) as cnt');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $this->db->where('tran_password', $transaction_password);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row->cnt;
        }
    }

    public function getUpgradationAmount() {
        $this->db->select('reg_amount');
        $query = $this->db->get('configuration');
        foreach ($query->result() as $row) {
            return $row->reg_amount;
        }
    }

    public function getUserBalanceAmount($user_id) {
        $this->db->select('balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_balance_amount');
        foreach ($query->result() as $row) {
            return $row->balance_amount;
        }
    }

    /**
     * Not sure was it used by real customers or not
     */
    public function updateUserBalanceAmount($user_id, $upgradeAmount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount-' . $upgradeAmount . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('user_balance_amount');
        return $res;
    }

    public function getLeadDetails($user_id = '', $keyword = '') {
        $leads = array();
        $this->db->select('id,user_id,name,email,phone,date,status');
        $this->db->from('capture_details');
        if ($keyword != '') {
            $keyword = $this->db->escape($keyword . '%');
            $where = "name LIKE {$keyword}  OR  email LIKE {$keyword} OR
          phone LIKE {$keyword}";
            $this->db->where($where);
        }
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        $res = $query = $this->db->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $leads["detail$i"]['id'] = $row->id;
            $leads["detail$i"]['sponser_name'] = $this->validation_model->IdToUserName($row->user_id);
            $leads["detail$i"]['name'] = $row->name;
            $leads["detail$i"]['email'] = $row->email;
            $leads["detail$i"]['phone'] = $row->phone;
            $leads["detail$i"]['date'] = $row->date;
            $leads["detail$i"]['status'] = $row->status;
            $i++;
        }

        return $leads;
    }

    public function getLeadDetailsById($id) {
        $this->db->select('*');
        $this->db->from('capture_details');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $res = $query = $this->db->get();
        foreach ($res->result() as $row) {
            $leads['id'] = $row->id;
            $leads['sponser_name'] = $this->validation_model->IdToUserName($row->user_id);
            $leads['name'] = $row->name;
            $leads['email'] = $row->email;
            $leads['phone'] = $row->phone;
            $leads['date'] = $row->date;
            $leads['status'] = $row->status;
            $leads['comment'] = $row->comment;
            $leads['admin_comment'] = $row->admin_comment;
        }

        return $leads;
    }

    public function updateLeadCapture($det) {
        $this->db->set('status', $det['status']);
        $this->db->set('admin_comment', $det['admin_comment']);
        $this->db->where('id', $det['lead_id']);
        return $this->db->update('capture_details');
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getadmin_name() {
        return $this->validation_model->getAdminUsername();
    }

    public function sendInvites($invite_details, $user_id) {
        $flag = 0;
        $myArray = explode(',', $invite_details['to_mail_id']);
        foreach ($myArray as $row) {
            $result = $this->sendInviteMails($invite_details['subject'], $invite_details['message'], $row);
            if ($result) {
                $date = date('Y-m-d H:i:s');
                $this->db->set('user_id', $user_id);
                $this->db->set('mail_id', $row);
                $this->db->set('subject', $invite_details['subject']);
                $this->db->set('message', $invite_details['message']);
                $this->db->set('date', $date);
                $this->db->insert('invite_history');
            }
        }
        if ($result) {

            $flag = 1;
        }

        return $flag;
    }

    public function sendInviteMails($subject, $message, $email) {
        $mailBodyDetails = '<table border="1" width="100%" align="center">            
                             <tr>
                               <td><b>Name: </b>' . $subject . '</td>
                             </tr>
                             <tr>
                               <td><b>Membership ID #: </b>USA' . $message . '</td>
                             </tr>
                            </table>';
        $result = $this->sendMail($mailBodyDetails, $subject, $email);
        return $result;
    }

    public function getInviteHistory($user_id) {
        $invite_history = array();
        $this->db->select('*');
        $this->db->from('invite_history');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }

        $res = $query = $this->db->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $invite_history["detail$i"]['mail_id'] = $row->mail_id;
            $invite_history["detail$i"]['subject'] = $row->subject;
            $invite_history["detail$i"]['message'] = $row->message;
            $invite_history["detail$i"]['date'] = $row->date;

            $i++;
        }

        return $invite_history;
    }

    public function sendMail($mailBodyDetails, $subject, $email = '') {
        $this->load->model('validation_model');
        $email_details = array();
        $email_details = $this->validation_model->getCompanyEmail();

        $this->mailObj->From = $email_details["from_email"];
        $this->mailObj->FromName = $this->validation_model->getAdminUsername();
        $this->mailObj->Subject = $subject;
        $this->mailObj->IsHTML(true);

        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);
        //if($FILE_NAME !="")
        //$this->mailObj->AddAttachment($FILE_NAME);

        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;

        return $res;
    }

    public function insertTextInvites($details) {


        $this->db->set('subject', $details['subject']);
        $this->db->set('content', $details['mail_content']);
        $this->db->set('type', 'text');
        $res = $this->db->insert('invites_configuration');

        return $res;
    }

    public function getTextInvitesData() {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'text');
        $this->db->order_by('id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $mail_details[$i]['id'] = $row['id'];
            $mail_details[$i]['subject'] = $row['subject'];
            $mail_details[$i]['content'] = $row['content'];
            $i++;
        }
        return $mail_details;
    }

    public function getTextInvitesDataById($id) {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'text');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->order_by('id');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $mail_details = $row;
        }
        return $mail_details;
    }

    public function editTextInvites($details) {
        $this->db->set('subject', $details['subject']);
        $this->db->set('content', $details['mail_content']);
        $this->db->set('type', 'text');
        $this->db->where('id', $details['id']);
        $res = $this->db->update('invites_configuration');

        return $res;
    }

    public function deleteInviteText($id) {
        $this->db->where('id', $id);
        return $this->db->delete('invites_configuration');
    }

//    public function getInviteTextOptions()
//    {
//        $message_array = $this->getTextInvitesData('yes');
//        $select_message = 'Select';
//        $messages = '<option value=' . ' ' . '>' . $select_message . '</option>';
//        for ($i = 0; $i < count($message_array); $i++) {
//            $id = $message_array[$i]['id'];
//            $subject = $message_array[$i]['subject'];
//            $messages.='<option value=' . $id . ' >' . $subject . '</option>';
//        }
//        return $messages;
//    
//    }
    public function insertsocialInvites($details, $type) {

        $this->db->select('id');
        $this->db->from('invites_configuration');
        $this->db->where('type', $type);

        $count = $this->db->count_all_results();

        if ($count) {
            $this->db->set('subject', $details['subject']);
            $this->db->set('content', $details['message']);
            $this->db->where('type', $type);
            $res = $this->db->update('invites_configuration');
        } else {
            $this->db->set('subject', $details['subject']);
            $this->db->set('content', $details['message']);
            $this->db->set('type', $type);
            $res = $this->db->insert('invites_configuration');
        }

        return $res;
    }

    public function insertsocialInvitesFb($details) {

        $this->db->select('id');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'social_fb');

        $count = $this->db->count_all_results();

        if ($count) {
            $this->db->set('subject', $details['caption']);
            $this->db->set('content', $details['description']);
            $this->db->where('type', 'social_fb');
            $res = $this->db->update('invites_configuration');
        } else {
            $this->db->set('subject', $details['caption']);
            $this->db->set('content', $details['description']);
            $this->db->set('type', 'social_fb');
            $res = $this->db->insert('invites_configuration');
        }

        return $res;
    }

    public function getSocialInviteData($type) {
        $social_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', $type);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $social_details = $row;
        }
        if ($query->num_rows == 0) {
            $social_details['subject'] = '';
            $social_details['content'] = '';
        }
        $social_details['subject'] = stripslashes($social_details['subject']);
        $social_details['content'] = stripslashes($social_details['content']);
        $social_details['subject'] = trim($social_details['subject']);
        $social_details['content'] = trim($social_details['content']);
        $social_details['subject'] = str_replace("\n", '', $social_details['subject']);
        $social_details['content'] = str_replace("\n", '', $social_details['content']);
        return $social_details;
    }

    public function insertBanner($file_name) {
        $this->db->set('subject', 'banner');
        $this->db->set('content', $file_name);
        $this->db->set('type', 'banner');
        return $res = $this->db->insert('invites_configuration');
    }

    public function getBanners() {
        $banner_details = array();
        $this->db->select('*');
        $this->db->from('invites_configuration');
        $this->db->where('type', 'banner');
        $this->db->order_by('id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $banner_details[$i]['id'] = $row['id'];
            $mail_details[$i]['subject'] = $row['subject'];
            $banner_details[$i]['content'] = $row['content'];
            $i++;
        }
        return $banner_details;
    }

    public function deleteBanner($id) {
        $this->db->where('id', $id);
        return $this->db->delete('invites_configuration');
    }

    public function getLeadUrl() {
        $this->db->select('lead_url');
        $this->db->from('site_information');
        $this->db->where('id', '1');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $lead_url = $row->lead_url;
        }
        return $lead_url;
    }

}
