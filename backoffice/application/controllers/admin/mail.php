<?php

require_once 'Inf_Controller.php';

/**
 * @property-read mail_model $mail_model
 */
class Mail extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function mail_management($tab = '') {

        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $tab1 = ' active';
        $tab2 = '';
        if ($tab == 'tab2') {
            $tab1 = '';
            $tab2 = ' active';
        }

        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('admin_id', $admin_id);

        if ($user_type == 'admin' || $user_type == "employee") {
            $base_url = base_url() . 'admin/mail/mail_management';
            $config['base_url'] = $base_url;
            $config['per_page'] = 5;
            $config['uri_segment'] = 4;
            $config['num_links'] = 5;
            if ($this->uri->segment(4) != '')
                $page = $this->uri->segment(4);
            else
                $page = 0;
            $this->set('page', $page);
            $messages = $this->mail_model->getAdminMessages($page, $config['per_page']);
            $cntctmsgs = $this->mail_model->getContactMessages($page, $config['per_page'], $this->LOG_USER_ID);
            $adminmsgs = array_merge($messages, $cntctmsgs);
            $cnt_adminmsgs = count($adminmsgs);
            $this->set('cnt_adminmsgs', $cnt_adminmsgs);
            $numrow1 = $this->mail_model->getCountAdminMessages();
            $numrow2 = $this->mail_model->getCountContactMessages();
            $numrows = $numrow1 + $numrow2;
            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);

            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('adminmsgs', $adminmsgs);
            $this->set('num_rows', $numrows);
        }
        if ($this->session->userdata('inf_mail_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_mail_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_mail_tab_active_arr']['tab2'];
            $this->session->unset_userdata("inf_mail_tab_active_arr");
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
    }

    function compose_mail() {

        $title = lang('compose_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('compose_mail');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $sender_id = $this->LOG_USER_ID;
        $date = date('Y-m-d H:i:s');
        $tab1 = ' active';
        $tab2 = '';
        $mail_status = 'single';

        if ($this->input->post('adminsend') && $this->validate_compose_mail()) {
            $mail_status = $this->input->post('mail_status');
            $subject = $this->input->post('subject');
            $message = addslashes($this->input->post('message1'));
            $user_id = $this->input->post('user_id');
            if ($mail_status == 'single') {
                $user_name_arr = $this->input->post('user_id');
                $user_id = $this->validation_model->userNameToID($user_name_arr);
                $user_name_exp = explode(',', $user_name_arr);
                $msg = '';
                for ($i = 0; $i < count($user_name_exp); $i++) {
                    $user_name = $user_name_exp[$i];
                    if ($user_id == 0) {
                        $msg = lang('invalid_user_name');
                        $this->redirect($msg, 'mail/compose_mail', FALSE);
                    } else {
                        $admin_username = $this->mail_model->getAdminUsername();
                        if ($user_name == $admin_username)
                            $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $date);
                        else
                            $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $sender_id);
                    }
                }
            }
            else if ($mail_status == 'all') {
                $user_name_exp = $this->mail_model->getUsers();
                for ($i = 0; $i < count($user_name_exp); $i++) {
                    $user_id = $user_name_exp[$i];
                    $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date, $sender_id);
                }
            }

            if ($res) {
                $data_array['subject'] = $subject;
                $data_array['message'] = $message;
                $login_id = $this->LOG_USER_ID;
                if ($mail_status == 'all') {
                    $data_array['sent_to'] = 'all';
                    $data = serialize($data_array);
                    $this->mail_model->sendMessageToUserCumulative('team', $subject, $message, $date, 'team');
                    $this->validation_model->insertUserActivity($login_id, 'message sent', $login_id, $data);
                }
                if ($mail_status != 'all') {
                    $data_array['sent_to'] = $user_id;
                    $data = serialize($data_array);
                    $this->mail_model->sendMessageToUserCumulative($user_id, $subject, $message, $date, 'individual');
                    $this->validation_model->insertUserActivity($login_id, 'message sent', $user_id, $data);
                }
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', TRUE);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/mail_management', FALSE);
            }
        }

        $this->set("mail_status", $mail_status);
        $this->setView();
    }

    function inbox() {

        $this->setView();
        //////////////////////////for pagination///////////////
    }

    function mail_sent() {

        $title = lang('mail_management');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_sent');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('admin_id', $admin_id);

        if ($user_type == 'admin' || $user_type == "employee") {
            $base_url = base_url() . 'admin/mail/mail_sent';
            $config['base_url'] = $base_url;
            $config['per_page'] = 5;
            $config['uri_segment'] = 4;
            $config['num_links'] = 5;
            if ($this->uri->segment(4) != '')
                $page = $this->uri->segment(4);
            else
                $page = 0;
            $this->set('page', $page);
            $adminmsgs = $this->mail_model->getAdminMessagesSent($page, $config['per_page']);
            $cnt_adminmsgs = count($adminmsgs);
            $this->set('cnt_adminmsgs', $cnt_adminmsgs);

            $numrows = $this->mail_model->getCountAdminMessagesSent();
            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);

            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('adminmsgs', $adminmsgs);
            $this->set('num_rows', $numrows);
        }

        $this->setView();
    }

    function reply_mail($mail_id = '') {

        $title = lang('reply_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'mail-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('reply_mail');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $user_type = $this->LOG_USER_TYPE;
        $mail_details = $this->mail_model->getAdminOneMessage($mail_id)->result_array();        
        if(count($mail_details) <= 0) {            
            $this->redirect(lang('invalid_mail_id'), 'mail/mail_management', FALSE);
        }
        $reply_user_id = $mail_details[0]['mailaduser'];
        $reply_user = $this->validation_model->idToUserName($reply_user_id);
        $reply_msg = $mail_details[0]['mailadsubject'];
        $this->set('reply_user', $reply_user);
        if (preg_match('/([\w\-]+\:[\w\-]+)/', $reply_msg)) {
            $string = explode(':', $reply_msg);
            $reply_msg = $string[1];
        }
        $reply_msg = trim(str_replace('%20', ' ', $reply_msg));
        $this->set('reply_msg', $reply_msg);
        if ($this->input->post('send') && $this->validate_reply_mail()) {
            $user_name = $this->input->post('user_id1');
            $subject = $this->input->post('subject');
            $message = addslashes($this->input->post('message'));
            $user_id = $this->mail_model->userNameToId($user_name);
            $date = date('Y-m-d H:i:s');
            $admin_username = $this->mail_model->getAdminUsername();
            if ($user_name == $admin_username) {
                $user_id = $this->LOG_USER_ID;
                $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $date);
            } else
                $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $date);
            $msg = '';
            if ($res) {
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', TRUE);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/reply_mail', FALSE);
            }
        }
        $this->setView();
    }

    function getMessage($msg_id, $user_id, $user_type) {

        $this->mail_model->updateAdminOneMessage($msg_id);
        echo "OK";
        exit();
    }

    function deleteMessage($msg_id = "", $msg_type = "") {
        $this->AJAX_STATUS = true;
        if ($msg_type == 'admin') {
            $res = $this->mail_model->updateAdminMessage($msg_id);
        }
        if ($msg_type == 'contact') {
            $res = $this->mail_model->updateContactMessage($msg_id);
        }
        $msg = '';
        if ($res) {
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_management', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_management', FALSE);
        }
    }

    function deleteSentMessage($msg_id = "", $msg_type = "") {
        $this->AJAX_STATUS = true;
        if ($msg_type == 'admin') {
            $res = $this->mail_model->updateAdminSentMessage($msg_id);
        }
        $msg = '';
        if ($res) {
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_sent', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_sent', FALSE);
        }
    }

    function readMessage() {
        $msg_id = $this->input->post('id');
        $msg_type = $this->input->post('type');
        if ($msg_type == 'admin') {
            $result = $this->mail_model->updateMsgStatus($msg_id);
            if ($result) {
                echo $result;
            }
        }
    }

    function reply_mail_name($user = '') {
        echo $user;
    }

    function ticket_system() {
        if ($this->MODULE_STATUS['ticket_system_status'] == "yes" && $this->MODULE_STATUS['ticket_system_status_demo'] == "yes") {
            $table_prefix = $this->table_prefix;
            $admin_id = $this->ADMIN_USER_ID;
            header("Location: " . base_url() . "../ticket_system/admin/index.php?a=ad_min&b=$table_prefix&id=$admin_id");
        } else {
            $message = lang('ticket_system_not_enabled');
            $this->redirect($message, 'home', FALSE);
        }
    }

    function validate_reply_mail() {
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function validate_compose_mail() {
        $tab2 = 'active';
        $tab1 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
        $mail_status = $this->input->post('mail_status');
        if ($mail_status == "single") {
            $this->form_validation->set_rules('user_id', lang('username'), 'trim|required|strip_tags');
        }
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message1', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}
