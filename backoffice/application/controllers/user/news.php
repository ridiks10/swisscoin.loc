<?php

require_once 'Inf_Controller.php';

class News extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function view_news() {
        $title = lang('info/news');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $help_link = 'news-management';
        $this->set('help_link', $help_link);
        $this->HEADER_LANG['page_top_header'] = lang('info/news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/news');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $news_details = $this->news_model->getAllNews();
        $this->set('news_details', $news_details);
        $this->set('news_count', count($news_details));
        $this->setView();
    }

    function view_newsletter($action = '', $edit_id = '') {
        $title = lang('view_subscribers');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load_langauge_scripts();
        $this->HEADER_LANG['page_top_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "news-management";
        $this->set("help_link", $help_link);

        $this->set("edit_id", null);
        $this->set("news_id", null);
        $this->set("news_title", null);
        $this->set("news_desc", null);
        $this->set("news_date", null);
        $msg = "";
        if ($action == "delete") {
            $result = $this->news_model->deleteNewsLetter($delete_id);
            if ($result) {
                $msg = 'News Letter Deleted Successfully';
                $this->redirect($msg, "news/view_newsletter", TRUE);
            } else {
                $msg = 'Error on Deleting News Letter';
                $this->redirect($msg, "news/view_newsletter", FALSE);
            }
        }
        $user_id = $this->LOG_USER_ID;
        $news_details = $this->news_model->getAllNewsLetters($user_id);
        $this->set("news_details", $news_details);
        $this->set("arr_count", count($news_details));
        $this->setView();
    }

    function send_newsletter() {

        $title = lang('send_newsletter');
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
                $user_id_avail = $this->news_model->checkMailId($email_id, $owner_id);
                if (!$user_id_avail) {
                    $msg = "Submitted E-Mail is not Subscribed";
                    $this->redirect($msg, "news/send_newsletter", FALSE);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $res = $this->news_model->sendNewsLetterToSubscribers($email_id, $subject, $message);
                }
            } else if ($mail_status == 'all') {
                $email_exp = $this->news_model->getAllNewsLettersMailId($owner_id);
                for ($i = 0; $i < count($email_exp); $i++) {
                    $email_id = $email_exp[$i];
                    $res = $this->news_model->sendNewsLetterToSubscribers($email_id, $subject, $message);
                }
            }
            if ($res) {
                if ($mail_status == 'all')
                    $this->news_model->insertNewsletterHistory('All', $subject, $message, $owner_id);
                if ($mail_status != 'all')
                    $this->news_model->insertNewsletterHistory($email_id, $subject, $message, $owner_id);
                $msg = "Newletter Send Successfully";
                $this->redirect($msg, "news/send_newsletter", TRUE);
            } else {
                $msg = "Newsletter Sending Failed";
                $this->redirect($msg, "news/send_newsletter", FALSE);
            }
        }
        $this->HEADER_LANG['page_top_header'] = lang('send_newsletter');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('send_newsletter');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $help_link = "mail-management";
        $this->set("help_link", $help_link);
        $this->setView();
    }
     function view_all_news($action = '', $id = '') {
        $title = lang('info/news');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $help_link = "view_news";
        $this->set("help_link", $help_link);
        $this->load_langauge_scripts();
        
        $this->HEADER_LANG['page_top_header'] = lang('info/news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/news');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();  
        if($action=="view"){
           $det = $this->news_model->getNewsDetails($id); 
           $this->set("details", $det);
        }
        $this->setView();
    }

}
