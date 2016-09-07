<?php

require_once 'Inf_Controller.php';

class Compensation extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function view_compensation() {
        $title = lang('info/compensation');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $help_link = 'compensation-management';
        $this->set('help_link', $help_link);
        $this->HEADER_LANG['page_top_header'] = lang('info/compensation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/compensation');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $compensation_details = $this->compensation_model->getAllCompensation();
        $this->set('compensation_details', $compensation_details);
        $this->set('compensation_count', count($compensation_details));
        $this->setView();
    }

    function view_compensationletter($action = '', $edit_id = '') {
        $title = lang('view_subscribers');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load_langauge_scripts();
        $this->HEADER_LANG['page_top_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

       // $help_link = "compensation-management";
       // $this->set("help_link", $help_link);

        $this->set("edit_id", null);
        $this->set("compensation_id", null);
        $this->set("compensation_title", null);
        $this->set("compensation_desc", null);
        $this->set("compensation_date", null);
        $msg = "";
        if ($action == "delete") {
            $result = $this->compensation_model->deleteCompensationLetter($delete_id);
            if ($result) {
                $msg = 'Compensation Letter Deleted Successfully';
                $this->redirect($msg, "compensation/view_compensationletter", TRUE);
            } else {
                $msg = 'Error on Deleting Compensation Letter';
                $this->redirect($msg, "compensation/view_compensationletter", FALSE);
            }
        }
        $user_id = $this->LOG_USER_ID;
        $compensation_details = $this->compensation_model->getAllCompensationLetters($user_id);
        $this->set("compensation_details", $compensation_details);
        $this->set("arr_count", count($compensation_details));
        $this->setView();
    }

    function send_compensationletter() {

        $title = lang('send_compensationletter');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[5]["name"] = "custom.js";
        $this->ARR_SCRIPT[5]["type"] = "js";
        $this->ARR_SCRIPT[5]["loc"] = "header";

        $this->ARR_SCRIPT[6]["name"] = "style-popup.css";
        $this->ARR_SCRIPT[6]["type"] = "css";
        $this->ARR_SCRIPT[6]["loc"] = "header";

        $this->ARR_SCRIPT[7]["name"] = "website.css";
        $this->ARR_SCRIPT[7]["type"] = "css";
        $this->ARR_SCRIPT[7]["loc"] = "header";

        $this->ARR_SCRIPT[9]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[9]["type"] = "js";
        $this->ARR_SCRIPT[9]["loc"] = "header";

        $this->ARR_SCRIPT[11]["name"] = "MailBox.js";
        $this->ARR_SCRIPT[11]["type"] = "js";
        $this->ARR_SCRIPT[11]["loc"] = "header";

        $this->ARR_SCRIPT[12]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[12]["type"] = "css";
        $this->ARR_SCRIPT[12]["loc"] = "header";

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $date = date('Y-m-d H:i:s');
        $owner_id = $this->LOG_USER_ID;
        if ($this->input->post('adminsend')) {
            $send_post_array = $this->input->post();
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array = $this->validation_model->escapeStringPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $mail_status = $send_post_array['mail_status'];
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
            if ($mail_status == 'single') {
                $msg = "";
                $email_id = $send_post_array['email_id'];
                $user_id_avail = $this->compensation_model->checkMailId($email_id, $owner_id);
                if (!$user_id_avail) {
                    $msg = "Submitted E-Mail is not Subscribed";
                    $this->redirect($msg, "compensation/send_compensationletter", FALSE);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $res = $this->compensation_model->sendCompensationLetterToSubscribers($email_id, $subject, $message);
                }
            } else if ($mail_status == 'all') {
                $email_exp = $this->compensation_model->getAllCompensationLettersMailId($owner_id);
                for ($i = 0; $i < count($email_exp); $i++) {
                    $email_id = $email_exp[$i];
                    $res = $this->compensation_model->sendCompensationLetterToSubscribers($email_id, $subject, $message);
                }
            }
            if ($res) {
                if ($mail_status == 'all')
                    $this->compensation_model->insertCompensationletterHistory('All', $subject, $message, $owner_id);
                if ($mail_status != 'all')
                    $this->compensation_model->insertCompensationletterHistory($email_id, $subject, $message, $owner_id);
                $msg = "Newletter Send Successfully";
                $this->redirect($msg, "compensation/send_compensationletter", TRUE);
            } else {
                $msg = "Compensationletter Sending Failed";
                $this->redirect($msg, "compensation/send_compensationletter", FALSE);
            }
        }
        $this->HEADER_LANG['page_top_header'] = lang('send_compensationletter');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('send_compensationletter');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $help_link = "mail-management";
        $this->set("help_link", $help_link);
        $this->setView();
    }
     function view_all_compensation($action = '', $id = 1) {  
        $title = lang('info/compensation');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $help_link = "view_compensation";
        $this->set("help_link", $help_link);
        $this->load_langauge_scripts();
        
        $this->HEADER_LANG['page_top_header'] = lang('info/compensation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/compensation');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts(); 
        $action="view";
        if($action=="view"){
           $det = $this->compensation_model->getCompensationDetails($id); 
           $this->set("details", $det);
        }
        $this->setView();
    }

}
