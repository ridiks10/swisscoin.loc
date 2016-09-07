<?php

require_once 'Inf_Controller.php';

/**
 * @property-read mail_model $mail_model 
 */
class Mail extends Inf_Controller {

    function __construct() {
        parent::__construct();
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

        $user_id = $this->LOG_USER_ID;
        $admin_username = $this->mail_model->getAdminUsername();
        if ($this->input->post('usersend') && $this->validate_compose_mail()) {
            $send_post_array = $this->input->post();
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array = $this->validation_model->escapeStringPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
            $message = addslashes($message);
            $dt = date('Y-m-d H:i:s');
            $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $dt);
            $msg = '';
            if ($res) {
                $data_array = array();
                $data_array['mail_subject'] = $subject;
                $data_array['mail_body'] = $message;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail sent',$this->ADMIN_USER_ID,$data);
                $msg = lang('message_send_successfully');
                $this->redirect($msg, 'mail/mail_management', TRUE);
            } else {
                $msg = lang('error_on_message_sending');
                $this->redirect($msg, 'mail/mail_management', FALSE);
            }
        }
        $this->set('tran_admin', $admin_username);
        $this->setView();
    }

    function inbox() {
        $this->setView();
    }

    function reply_mail($mail_id = '') {
        $title = lang('reply_mail');
        $this->set('title', $this->COMPANY_NAME . " | $title");
        $help_link = 'reply-mail';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('mail_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('reply_mail');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $mail_details = $this->mail_model->getUserOneMessage($mail_id, $this->LOG_USER_ID)->result_array();
        if(count($mail_details) <= 0 || $mail_details[0]['mailtoususer'] != $this->LOG_USER_ID) {
            $this->redirect(lang('invalid_mail_id'), 'mail/mail_management', FALSE);
        }
        $reply_user_id = $mail_details[0]['mailtoususer'];
        $reply_user = $this->validation_model->idToUserName($reply_user_id);
        $reply_msg = $mail_details[0]['mailtoussub'];
        
        $admin_username = $this->mail_model->getAdminUsername();
        $this->set('reply_user', $admin_username);
        if (preg_match('/([\w\-]+\:[\w\-]+)/', $reply_msg)) {
            $string = explode(":", $reply_msg);
            $reply_msg = $string[1];
        }
        $reply_msg = str_replace('%20', ' ', $reply_msg);
        $reply_msg = trim($reply_msg);
        $this->set('reply_msg', $reply_msg);
        if ($this->input->post('send') && $this->validate_reply_mail()) {
            $send_post_array = $this->input->post();
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array = $this->validation_model->escapeStringPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $user_name = $send_post_array['user_name'];
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
            $message = addslashes($message);
            $user_id = $this->mail_model->userNameToId($user_name);
            $dt = date('Y-m-d H:i:s');
            $admin_username = $this->mail_model->getAdminUsername();
            if ($user_name == $admin_username) {
                $user_id = $this->LOG_USER_ID;
                $res = $this->mail_model->sendMesageToAdmin($user_id, $message, $subject, $dt);
            } else {
                $res = $this->mail_model->sendMessageToUser($user_id, $subject, $message, $dt);
            }
            $msg = "";
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
        $this->mail_model->updateUserOneMessage($msg_id);
        echo "OK";
        exit();
    }

    function deleteMessage($msg_id = "", $msg_type = "") {
        $this->AJAX_STATUS = true;
        if ($msg_type == 'user') {
            $res = $this->mail_model->updateUserMessage($msg_id);
        }
        if ($msg_type == 'contact') {
            $res = $this->mail_model->updateuserContactMessage($msg_id);
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

    function deleteDownlineSendMessage($msg_id = "", $msg_type = "") {

        $this->AJAX_STATUS = true;
        $res = $this->mail_model->updateDownlineSendMessage($msg_id);
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail to downline deleted ', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_to_downlines', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_to_downlines', FALSE);
        }
    }

    function deleteDownlineFromMessage($msg_id = "", $msg_type = "") {

        $this->AJAX_STATUS = true;
        $res = $this->mail_model->updateDownlineFromMessage($msg_id);
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail from downline deleted ', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_to_downlines', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_to_downlines', FALSE);
        }
    }

    function deleteSentMessage($msg_id = "", $msg_type = "") {
        $this->AJAX_STATUS = true;
        $res = $this->mail_model->updateUserMessageSent($msg_id);
        $msg = '';
        if ($res) {
            $data_array = array();
            $data_array['msg_id'] = $msg_id;
            $data_array['msg_type'] = $msg_type;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail deleted', $this->LOG_USER_ID, $data);
            $msg = lang('message_deleted_successfully');
            $this->redirect($msg, 'mail/mail_sent', TRUE);
        } else {
            $msg = lang('message_deletion_failed');
            $this->redirect($msg, 'mail/mail_sent', FALSE);
        }
    }

    function readMessage() {
        $msg_id = strip_tags($this->input->post('id'));
        $msg_type = strip_tags($this->input->post('type'));

        $res = $this->mail_model->updateMsgStatus($msg_id);

        $msg = '';
        if ($res) {
            echo $res;
        }
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
        $user_id = $this->LOG_USER_ID;
        $admin_username = $this->mail_model->getAdminUsername();

        $this->set('tran_admin', $admin_username);
        $base_url = base_url() . 'user/mail/mail_management';
        $config['base_url'] = $base_url;
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        $page = 0;

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        }

        $data1 = $this->mail_model->getUserMessages($user_id, $page, $config['per_page']);
        $data2 = $this->mail_model->getUserContactMessages($user_id, $page, $config['per_page']);
        $mail = array_merge($data1, $data2);
        $num_mail1 = $this->mail_model->getCountUserMessages($user_id);
        $num_mail2 = $this->mail_model->getCountUserContactMessages($user_id);
        $config['total_rows'] = $num_mail1 + $num_mail2;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $cnt_mails = count($mail);

        if ($this->session->userdata('inf_mail_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_mail_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_mail_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_mail_tab_active_arr');
        }

        $this->set('page', $page);
        $this->set('result_per_page', $result_per_page);
        $this->set('row', $mail);
        $this->set('cnt_mails', $cnt_mails);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->setView();
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

        $user_id = $this->LOG_USER_ID;

        $base_url = base_url() . 'user/mail/mail_sent';
        $config['base_url'] = $base_url;
        $config['per_page'] = 5;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;

        $page = 0;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);

        $mail = $this->mail_model->getUserMessagesSent($user_id, $page, $config['per_page']);

        $num_mails = $this->mail_model->getUserMessagesSentCount($user_id);
        $config['total_rows'] = $num_mails;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $cnt_mails = count($mail);

        $this->set('page', $page);
        $this->set('result_per_page', $result_per_page);
        $this->set('row', $mail);
        $this->set('cnt_mails', $cnt_mails);
        $this->setView();
    }

    function ticket_system($tab = '') {

        $title = lang('ticket_system');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('ticket_system');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ticket_system');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $tab1 = " active";
        $tab2 = "";
        $tab3 = "";
        $current_active_tab = 'tab2';
        if ($tab == 'tab2') {
            $tab1 = "";
            $tab2 = " active";
            $tab3 = "";
            $current_active_tab = 'tab2';
        }if ($tab == 'tab3') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = " active";
            $current_active_tab = '$tab3';
        }
        if ($this->input->post('active_tab')) {
            $current_active_tab = $this->input->post('active_tab');
        }

        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $admin_username = $this->mail_model->getAdminUsername();
        $this->load->model('ticket_model');

        $validation_error = array();
        if ($this->input->post('usersend') && $this->validate_ticket_system($current_active_tab)) {

            $ticket['trackid'] = $this->ticket_model->createTicketId();

            $current_active_tab = $this->input->post('active_tab');
            if ($current_active_tab == 'tab1') {
                $tab1 = ' active';
                $tab2 = $tab3 = $tab4 = NULL;
            } else if ($current_active_tab == 'tab2') {
                $tab2 = ' active';
                $tab1 = $tab3 = NULL;
            } else if ($current_active_tab == 'tab3') {
                $tab3 = ' active';
                $tab2 = $tab1 = NULL;
            }

            $this->session->set_userdata("inf_mail_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3));

            $user_name = $this->LOG_USER_ID;
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $subject = $post_arr['subject'];
            $message = $post_arr['message'];
            $ticket['subject'] = $post_arr['subject'];
            $ticket['user_id'] = $this->LOG_USER_ID;
            $ticket['message'] = $post_arr['message'];
            $ticket['category'] = $post_arr['category'];
            $ticket['priority'] = $post_arr['priority'];
            $doc_file_name = "";
            if ($subject == "" || $message == "") {
                $msg = $this->lang->line('enter_mandatory_fields');
                $this->redirect($msg, "mail/ticket_system", FALSE);
            } else {
                $file_details['saved_name'] = "";

                $document1 = $_FILES['upload_doc']['name'];
                if ($document1) {
                    $upload_doc = 'upload_doc';
                    $config['upload_path'] = './public_html/images';
                    $config['allowed_types'] = 'jpg|png|jpeg|JPG|gif';
                    $config['max_size'] = '2000000';
                    $this->load->library('upload', $config);
                    $msg = '';

                    if ($this->upload->do_upload($upload_doc)) {
                        $file_arr = $this->upload->data();
                        $file_details['original_name'] = $file_arr['orig_name'];
                        $file_details['saved_name'] = $file_arr['file_name'];
                        $file_details['file_size'] = $file_arr['file_size'];

                        $data = array('upload_data' => $this->upload->data());
                        $config1['upload_path'] = '../ticket_system/attachments';

                        $config1['allowed_types'] = 'jpg|png|jpeg|JPG|gif';
                        $config1['max_size'] = '2000000';
                        $this->load->library('upload', $config1);
                        $this->upload->initialize($config1);
                        if ($this->upload->do_upload($upload_doc)) {
                            $data = array('upload_data' => $this->upload->data());
                            $doc_file_name = $data['upload_data']['file_name'];
                            $msg = "Uploaded and ";
                        } else {
                            $msg = $this->upload->display_errors();
                            $this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                        }
                    } else {
                        $msg = $this->upload->display_errors();
                        $this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                    }
                }
            }

            $ticket['file_name'] = $doc_file_name;
            $this->ticket_model->createNewTicket($ticket);
            $details = $this->ticket_model->getTicketData($ticket['trackid'], $this->LOG_USER_ID);
            $dt = date('Y-m-d H:i:s');
            $msg = "";

            if ($document1)
                $res1 = $this->ticket_model->insertIntoAttachment($ticket['trackid'], $file_details, $doc_file_name);
            if ($document1) {
                if ($res1)
                    $doc_file_name = $res1 . "#" . $doc_file_name;
            }
            $res = $this->ticket_model->replyTicket($details, $ticket['message'], $ticket['user_id'], $doc_file_name);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $data_array = array();
                $data_array['mail_subject'] = $subject;
                $data_array['mail_body'] = $message;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($login_id, 'ticket created',$this->ADMIN_USER_ID, $data);
                $msg = lang('ticket_created') . ": " . $ticket['trackid'];
                $this->redirect($msg, "mail/ticket_system", TRUE);
            } else {
                $msg = $this->lang->line('error_on_message_sending');
                $this->redirect($msg, "mail/ticket-system", FALSE);
            }
        } else {
            $validation_error = $this->form_validation->error_array();
        }
        $this->set("validation_error", $validation_error);
        $this->set("ticket_count", 0);

        $ticket_arr = array();

        if ($this->input->post('view')) {
            $login_id = $this->LOG_USER_ID;
            $tab1 = "";
            $tab2 = "";
            $tab3 = " active";
            $tab4 = "";
            $ticket_id = strip_tags($this->input->post('ticket'));
            if (!$ticket_id) {
                $msg = lang('please_enter_ticket_id');
                $this->redirect($msg, "mail/ticket_system", FALSE);
            }

            $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $login_id);
            if (!$ticket_arr) {
                $msg = lang('invalid_ticket_id');
                $this->redirect($msg, "mail/view_ticket_details", FALSE);
            }
            $this->set("ticket_arr", $ticket_arr);
            $this->set("ticket_count", count($ticket_arr));
            $msg = "";
            $this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
        }

        $user_id = $this->LOG_USER_ID;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('user_id', $user_id);
        $this->set('user_type', $user_type);
        $this->set('admin_id', $admin_id);
        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $help_link = "mail-management";
        $this->set("help_link", $help_link);

        $base_url = base_url() . "user/mail/mail_management";
        $config['base_url'] = $base_url;
        $config['per_page'] = 200;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;

        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;
        $this->set("page", $page);
        $res = $this->mail_model->getUserMessages($user_id, $page, $config['per_page']);
        $this->load->model('ticket_model');
        $row = $this->ticket_model->getTicketData('', $this->LOG_USER_ID);
        $numrows = $this->mail_model->getCountUserMessages($user_id);
        $config['total_rows'] = $numrows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $i = 0;
        $c = 0;
        $user_name_arr = array();
        $category_arr = $this->mail_model->getTicketsCategories();
        $this->set("category_arr", $category_arr);
        $this->set("row", $row);
        $cnt_row = count($row);
        $this->set("cnt_row", $cnt_row);
        $this->set("user_name_arr", $user_name_arr);
        $this->set("num_rows", $c);
        if ($this->session->userdata("inf_mail_tab_active_arr")) {
            $tab1 = $this->session->userdata['inf_mail_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_mail_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_mail_tab_active_arr']['tab3'];
            $this->session->unset_userdata("inf_mail_tab_active_arr");
        }
        $this->set("tab1", $tab1);
        $this->set("tab2", $tab2);
        $this->set("tab3", $tab3);
        $this->setView();
    }

    function validate_ticket_system($active_tab) {

        $create_ticket_arr = $this->input->post();
        $create_ticket_arr['category_name'] = $this->mail_model->getCategoryName($create_ticket_arr['category']);

        $this->session->set_userdata('inf_create_ticket_arr', $create_ticket_arr);
        if ($this->session->userdata("inf_create_ticket_arr")) {
            $create_ticket_arr = $this->session->userdata("inf_create_ticket_arr");
        }
        $this->set('create_ticket_arr', $create_ticket_arr);

        if ($active_tab == 'tab2') {
            $this->set('create_ticket_arr', $create_ticket_arr);
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|strip_tags');
            $this->form_validation->set_rules('priority', 'Priority', 'trim|required');
            $this->form_validation->set_rules('category', 'Category', 'trim|required');
            $this->form_validation->set_rules('message', 'Message To Admin', 'trim|required|alpha_numeric');
        }
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function create_ticket() {
        $this->setView();
    }

    function ticket_inbox() {

        $this->setView();
    }

    function view_ticket() {
        $this->setView();
    }

    function view_ticket_details($ticket_id = '') {

        $title = $this->lang->line('support_center');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('support_center');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('support_center');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $subjects = $this->mail_model->getSubjects();
        $this->set('subjects', $subjects);

        $cat_arr = $this->mail_model->getCategory();
        $this->set("cat_arr", $cat_arr);

        $this->load->model('ticket_model');
        $this->set("ticket_count", 0);

        $tab1 = "";
        $tab2 = "";
        $tab4 = "";
        $tab3 = "active";

        if (!$ticket_id) {
            $msg = "Please enter Ticket ID";
            $this->redirect($msg, "mail/ticket_system", FALSE);
        }

        $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $this->LOG_USER_ID);
        $ticket_reply = $this->ticket_model->getAllReply($ticket_arr['details0']['id']);
        $this->ticket_model->readTicket($ticket_arr['details0']['id']);
        $tick_count = count($ticket_reply);
        $admin_name = $this->validation_model->getAdminUsername();

        for ($i = 0; $i < $tick_count; $i++) {
            $file = $ticket_reply["$i"]['attachments'];
            $file = $this->getBetween($file, '#', ',');
            $ticket_reply["$i"]['attachments'] = $file;
        }

        $this->set("ticket_reply", $ticket_reply);
        $this->set("cnt_row", count($ticket_reply));

        if (!$ticket_arr) {
            $msg = lang('invalid_ticket_id');
            $this->redirect($msg, "mail/support_center", FALSE);
        }

        $this->set("ticket_arr", $ticket_arr);
        $this->set("ticket_count", count($ticket_arr));

        if ($this->input->post('reply')) {
            $reply_post_array = $this->input->post();
            $reply_post_array = $this->validation_model->stripTagsPostArray($reply_post_array);
            $reply_post_array = $this->validation_model->escapeStringPostArray($reply_post_array);
            $ticket_id = $reply_post_array['ticket_id'];
            $message = $reply_post_array['message'];
            if (!$message) {
                $msg = lang('please_enter_a_message');
                $this->redirect($msg, "mail/view_ticket_details/" . $ticket_id, FALSE);
            }
            $msg = '';
            $document1 = $_FILES['upload_doc']['name'];
            $doc_file_name = '';
            $file_details = array();
            if ($document1) {
                $upload_doc = 'upload_doc';
                $config['upload_path'] = './public_html/images';
                $config['allowed_types'] = 'jpg|png|jpeg|JPG|gif';
                $config['max_size'] = '2000000';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload($upload_doc)) {
                    $file_arr = $this->upload->data();
                    $file_details['original_name'] = $file_arr['orig_name'];
                    $file_details['saved_name'] = $file_arr['file_name'];
                    $file_details['file_size'] = $file_arr['file_size'];

                    $data = array('upload_data' => $this->upload->data());
                    $config1['upload_path'] = '../ticket_system/attachments';

                    $config1['allowed_types'] = 'jpg|png|jpeg|JPG|gif';
                    $config1['max_size'] = '2000000';
                    $this->load->library('upload', $config1);
                    $this->upload->initialize($config1);
                    if ($this->upload->do_upload($upload_doc)) {
                        $data = array('upload_data' => $this->upload->data());
                        $doc_file_name = $data['upload_data']['file_name'];
                        $msg = "Uploaded and ";
                    } else {
                        $msg = $this->upload->display_errors();
                        $this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                    }
                } else {
                    $msg = $this->upload->display_errors();
                    $this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                }
            }
            $user_id = $this->LOG_USER_ID;
            $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $user_id);
            if ($document1)
                $res1 = $this->ticket_model->insertIntoAttachment($ticket_id, $file_details, $doc_file_name);
            if ($document1) {
                if ($res1)
                    $doc_file_name = $res1 . "#" . $doc_file_name;
            }
            $res = $this->ticket_model->replyTicket($ticket_arr, $message, $user_id, $doc_file_name);

            if ($res) {
                        $data_array = array();
                        $data_array['reply_post_array'] = $reply_post_array;
                        $data = serialize($data_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'ticket reply sent', $this->ADMIN_USER_ID, $data);
                $msg = $msg . lang('reply_sent');
                $this->redirect($msg, "mail/view_ticket_details/$ticket_id", TRUE);
            }
        }

        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('user_id', $user_id);
        $this->set('user_type', $user_type);
        $this->set('admin_id', $admin_id);
        $this->set("tran_attachment", $this->lang->line('attachment'));
        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $help_link = "mail-management";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    public function getBetween($content, $start, $end) {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    function validate_compose_mail() {
        $tab2 = 'active';
        $tab1 = '';
        $this->session->set_userdata('inf_tranpass_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function validate_reply_mail() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('subject', lang('subject'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('message', lang('message'), 'trim|required');
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function mail_to_downlines($tab = '', $page = '') {
        $title = 'Mail To Downlines';
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        $this->load->model('ft_individual_model');

        $this->HEADER_LANG['page_top_header'] = lang('mail_sent');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('mail_sent');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $tab1 = " active";
        $tab2 = "";
        $tab3 = "";

        if ($tab == '2') {
            echo "kkkkk";
            die();
            $tab1 = "";
            $tab2 = " active";
            $tab3 = "";
        }
        if ($tab == '3') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = " active";
        }

        $this->session->set_userdata("inf_mail_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2));
        $user_id = $this->LOG_USER_ID;
        $user_downlines = $this->ft_individual_model->getFirstliners($user_id);
        if ($this->input->post('mail_submit')) {
            $tab1 = " active";
            $tab2 = "";
            $tab3 = "";
            $this->session->set_userdata("inf_mail_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3));
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            $res_val = $this->form_validation->run();
            if ($res_val) {
                $mail_post_array = $this->input->post();
                $mail_post_array = $this->validation_model->stripTagsPostArray($mail_post_array);
                $mail_post_array = $this->validation_model->escapeStringPostArray($mail_post_array);
                $mail_post_array['content'] = $this->validation_model->stripTagTextArea($this->input->post('content'));
                $content = $mail_post_array['content'];
                $subject = $mail_post_array['subject'];
                if ($mail_post_array['user'] == 'individual') {
                    $to_user_id = $mail_post_array['username'];
                    if ($to_user_id != '') {
                        $username = $this->validation_model->idToUserName($to_user_id);
                        if ($username) {
                            //$email = $this->mail_model->getUserEmail($username);
                            $this->mail_model->sendMessageToDownlines($subject, $user_id, $to_user_id, $content);
                            $this->mail_model->sendMessageToDownlinesCumulative($subject, $user_id, $to_user_id, $content, 'individual');
                            //$res = $this->mail_model->sendEmail($content, $email, $subject, '');
                            $msg = "";
                            $res = true;
                            if ($res) {
                                $login_id = $this->LOG_USER_ID;
                                $data_array = array();
                                $data_array['mail_subject'] = $subject;
                                $data_array['mail_body'] = $message;
                                $data = serialize($data_array);
                                $this->validation_model->insertUserActivity($login_id, 'mail to downline sent',$this->ADMIN_USER_ID,$data);
                                $msg = $this->lang->line('message_send_successfully');
                                $this->redirect($msg, "mail/mail_to_downlines", TRUE);
                            } else {
                                $msg = $this->lang->line('error_on_message_sending');
                                $this->redirect($msg, "mail/mail_to_downlines", FALSE);
                            }
                        } else {
                            $msg = lang('invalid_user');
                            $this->redirect($msg, "mail/mail_to_downlines", FALSE);
                        }
                    } else {
                        $msg = lang('you_must_select_a_user');
                        $this->redirect($msg, "mail/mail_to_downlines", FALSE);
                    }
                } else if ($mail_post_array['user'] == 'all') {
                    if (count($user_downlines)) {
                        $this->mail_model->sendMessageToDownlinesCumulative($subject, $user_id, 'team', $content, 'team');
                        $res = $this->mail_model->sendEmailToDownlines($content, $user_id, $user_downlines, $subject);
                        $msg = "";
                        if ($res) {
                            $login_id = $this->LOG_USER_ID;
                            $data_array = array();
                            $data_array['mail_subject'] = $subject;
                            $data_array['mail_body'] = $content;
                            $data = serialize($data_array);
                            $this->validation_model->insertUserActivity($login_id, 'mail sent',$this->ADMIN_USER_ID,$data);
                            $msg = $this->lang->line('message_send_successfully');
                            $this->redirect($msg, "mail/mail_to_downlines", TRUE);
                        } else {
                            $msg = $this->lang->line('error_on_message_sending');
                            $this->redirect($msg, "mail/mail_to_downlines", FALSE);
                        }
                    } else {
                        $msg = lang('your_team_is_empty');
                        $this->redirect($msg, "mail/mail_to_downlines", FALSE);
                    }
                }
            }
        }


        $base_url = base_url() . "user/mail/mail_to_downlines/2";
        $config['base_url'] = $base_url;

        $config['per_page'] = 100;
        $config['uri_segment'] = 5;
        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;
        $this->set("page", $page);
        $res_send = $this->mail_model->getUserSendMessagesDownlines($user_id, $page, $config['per_page']);
        $res_inbox = $this->mail_model->getUserInboxMessagesDownlines($user_id, $page, $config['per_page']);

        $numrows_send = $this->mail_model->getCountUserSendMessagesDownlines($user_id);
        $config['total_rows'] = $numrows_send;
        $this->pagination->initialize($config);
        $result_per_page_send = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page_send);

        $i = 0;
        $j = 0;
        $c = 0;
        $d = 0;
        $user_name_arr_send = array();
        $user_name_arr_inbox = array();
        while ($i < count($res_send)) {
            $user_name_arr_send[$c] = $res_send[$i];
            $user_name_arr_send[$c]['user_name'] = $this->mail_model->idToUserName($res_send[$i]['mailaduser']);
            $i++;
            $c++;
        }

        while ($j < count($res_inbox)) {
            $user_name_arr_inbox[$d] = $res_inbox[$j];
            $user_name_arr_inbox[$d]['user_name'] = $this->mail_model->idToUserName($res_inbox[$j]['mailadfromuser']);
            $j++;
            $d++;
        }

        $this->set("row_send", $res_send);
        $cnt_row_send = count($res_send);
        $this->set("cnt_row_send", $cnt_row_send);
        $this->set("user_name_arr_send", $user_name_arr_send);
        $this->set("num_rows", $c);

        $this->set("row_inbox", $res_inbox);
        $cnt_row_inbox = count($res_inbox);
        $this->set("cnt_row_inbox", $cnt_row_inbox);
        $this->set("user_name_arr_inbox", $user_name_arr_inbox);
        $this->set("num_rows_from", $d);


        $this->set("user_downlines", $user_downlines);
        $this->set("page_top_header", 'Mail To Downlines');
        $this->set("page_top_small_header", "");
        $this->set("page_header", 'Mail To Downlines');
        $this->set("page_small_header", "");
        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        if ($this->session->userdata("inf_mail_tab_active_arr")) {
            $tab1 = $this->session->userdata['inf_mail_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_mail_tab_active_arr']['tab2'];
            // $tab3 = $this->session->userdata['inf_mail_tab_active_arr']['tab3'];
            $this->session->unset_userdata("inf_mail_tab_active_arr");
        }


        $this->set("tab1", $tab1);
        $this->set("tab2", $tab2);
        $this->set("tab3", $tab3);
        $help_link = 'mail_sent';
        $this->set('help_link', $help_link);
        $this->setView();
    }

}

?>