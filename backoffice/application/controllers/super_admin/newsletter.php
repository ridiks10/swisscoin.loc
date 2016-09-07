<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'Inf_Controller.php';

class Newsletter extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    public function send_newsletter() {

        $title = lang('send_news_letter');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('send_news_letter');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('send_news_letter');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post('send_newsleteer') && $this->validate_super_admin_newsletter()) {
            $newsletter_post_array = $this->input->post();
            $newsletter_post_array = $this->validation_model->stripTagsPostArray($newsletter_post_array);
            $newsletter_post_array = $this->validation_model->escapeStringPostArray($newsletter_post_array);
            $mail_status = $newsletter_post_array['mail_status'];
            $subject = $newsletter_post_array['subject'];
            $message = $newsletter_post_array['message'];
            $mail_subject = 'News Letter';
            $type = 'news_letter';
            if ($mail_status == 'single') {
                $msg = "";
                $user_name = $newsletter_post_array['user_name'];
                $email_id = $this->newsletter_model->getSingleNewsLettersMailId($user_name);
                $result = $this->newsletter_model->sendSubscriptonMails($email_id, $mail_subject, $type, $message,$user_name,$email_id);
                if ($result) {
                    $result = $this->newsletter_model->insertNewsletterHistory($user_name, 'single', $subject, $message);
                } else {
                    $msg = lang('newsletter_sending_failed');
                    $this->redirect($msg, "newsletter/send_newsletter", FALSE);
                }
            } else if ($mail_status == 'all') {
                $email_exp = $this->newsletter_model->getAllNewsLettersMailId('all', 'all', $subject, $message);
                for ($i = 0; $i < count($email_exp); $i++) {
                    $email_id = $email_exp[$i]['user_email'];
                    $user_name = $email_exp[$i]['user_name'];
                    $result = $this->newsletter_model->sendSubscriptonMails($email_id, $mail_subject, $type, $message,$user_name,$email_id);
                }
                if ($result) {
                    $result = $this->newsletter_model->insertNewsletterHistory('all', 'all', $subject, $message);
                } else {
                    $msg = lang('newsletter_sending_failed');
                    $this->redirect($msg, "newsletter/send_newsletter", FALSE);
                }
            }
            if ($result) {
                $msg = lang('newsletter_send_sucessfully');
                $this->redirect($msg, "newsletter/send_newsletter", TRUE);
            } else {
                $msg = lang('newsletter_sending_failed');
                $this->redirect($msg, "newsletter/send_newsletter", FALSE);
            }
        }
        $this->setView();
    }

    public function validate_super_admin_newsletter() {
        $mail_status = $this->input->post('mail_status');
        $this->session->set_userdata('status', 'all');
        if ($mail_status == 'single') {
            $this->session->set_userdata('status', 'single');
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags|xss_clean|htmlentities');
        }
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|strip_tags|xss_clean|min_length[2]|max_length[500]|htmlentities');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|strip_tags|xss_clean|min_length[2]|htmlentities');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function super_mlm_users($user_name = "") {
        $this->load->model('select_report_model');
        $letters = preg_replace("/[^a-z0-9 ]/si", "", $user_name);
        $user_detail = $this->newsletter_model->selectUser($letters);
        echo $user_detail;
    }

}
