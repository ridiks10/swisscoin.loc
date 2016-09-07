<?php

require_once 'Inf_Controller.php';

class Ticket_system extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ticket_model');
    }

    function my_ticket($tab_pass = '', $tab = '', $action = "", $edit_ticket_id = "") {

        $title = $this->lang->line('ticket_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $page1 = 0;
        $page = 0;

        $base_url1 = base_url() . "user/ticket_system/my_ticket/t2";
        $config1['base_url'] = $base_url1;
        $config1['per_page'] = 10;
        $config1["uri_segment"] = 5;

        if ($tab_pass == 't1')
            $page1 = ($this->uri->segment($config1["uri_segment"])) ? $this->uri->segment($config1["uri_segment"]) : 0;

        $base_url = base_url() . "user/ticket_system/my_ticket/t1";
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config["uri_segment"] = 5;

        if ($tab_pass == 't2')
            $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;


        $tab1 = " active";
        $tab2 = "";
        $tab3 = "";
        $tab4 = "";
        $tab5 = "";
        $tab6 = "";
        if ($tab == 'tab2') {
            $tab1 = "";
            $tab2 = " active";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "";
            $tab6 = "";
        } else if ($tab == 'tab3') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = " active";
            $tab4 = "";
            $tab5 = "";
            $tab6 = "";
        } else if ($tab == 'tab4') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = "";
            $tab4 = "active";
            $tab5 = "";
            $tab6 = "";
        } else if ($tab == 'tab5') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "active";
            $tab6 = "";
        } else if ($tab == 'tab5') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "active";
            $tab6 = "";
        } else if ($tab == 'tab6') {
            $tab1 = "";
            $tab2 = "";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "";
            $tab6 = "active";
        }

        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $admin_username = $this->validation_model->getAdminUsername();
        $this->load->model('ticket_model');

        if ($this->input->post('usersend')) {
            $ticket['trackid'] = $this->ticket_model->createTicketId();

            $tab1 = "";
            $tab2 = " active";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "";
            $tab6 = "";
            $this->session->set_userdata("mail_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5, "tab6" => $tab6));

//          $user_name = $this->LOG_USER_ID;
            $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
            $subject = $post_arr['subject'];
            $message = $post_arr['message'];
            $ticket['subject'] = $post_arr['subject'];
            $ticket['user_id'] = $this->LOG_USER_ID;
            $ticket['message'] = $post_arr['message'];
            $ticket['category'] = $post_arr['category'];
            $assignee_details = $this->ticket_model->getAssigneeDetails($ticket['category']);

            $ticket['category_assignee_id'] = $assignee_details['id'];
            $ticket['category_assignee_name'] = $assignee_details['name'];
            $ticket['priority'] = $post_arr['priority'];
            $doc_file_name = "";
            if ($subject == "" || $message == "") {
                $msg = $this->lang->line('enter_mandatory_fields');
                $this->redirect($msg, "ticket_system/my_ticket", FALSE);
            } else {
                $file_details['saved_name'] = "";

                $document1 = $_FILES['upload_doc']['name'];
                if ($document1) {
                    $upload_doc = 'upload_doc';
                    $config['upload_path'] = 'public_html/images/ticket_system';
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
                        $config1['upload_path'] = 'public_html/images/ticket_system';

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
                            //$this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                            $this->redirect($msg, "ticket_system/my_ticket", FALSE);
                        }
                    } else {
                        $msg = $this->upload->display_errors();
                        //$this->redirect($msg, "mail/view_ticket_details/$ticket_id", FALSE);
                        $this->redirect($msg, "ticket_system/my_ticket", FALSE);
                    }
                }
            }

            $ticket['file_name'] = $doc_file_name;
            $create_tkt = $this->ticket_model->createNewTicket($ticket);
            if ($create_tkt) {
                $updt_count = $this->ticket_system_model->incrementCategoryCount($ticket['category']);
                $details = $this->ticket_model->insertToHistory($ticket['trackid'], $ticket['user_id'], $this->LOG_USER_TYPE, "Ticket Creation");
            }
            $details = $this->ticket_model->getTicketData($ticket['trackid'], $this->LOG_USER_ID);
            
            
            $dt = date('Y-m-d H:i:s');
            $msg = "";
            if ($document1)
                $res1 = $this->ticket_model->insertIntoAttachment($ticket['trackid'], $file_details, $doc_file_name);

            $res = $this->ticket_model->replyTicket($details, $ticket['message'], $ticket['user_id'], $doc_file_name);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                ;
//              $this->val->insertUserActivity('12345', 'send mail', $login_id);
                $msg = "Ticket Created Successfully Your Ticket ID: " . $ticket['trackid'];
                $this->redirect($msg, "ticket_system/my_ticket", TRUE);
            } else {
                $msg = $this->lang->line('error_on_message_sending');
                $this->redirect($msg, "ticket_system/my_ticket", FALSE);
            }
        }

        $this->set("ticket_count", 0);
        $ticket_arr = array();

        if ($this->input->post('view')) {

            $login_id = $this->LOG_USER_ID;
            $tab1 = "";
            $tab2 = "";
            $tab3 = " active";
            $tab4 = "";
            $tab5 = "";
            $tab6 = "";
            $ticket_id = $this->input->post('ticket');
            if (!$ticket_id) {
                $msg = "Please enter Ticket ID";
                $this->redirect($msg, "ticket_system/my_ticket", FALSE);
            }

            $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $login_id);

            if (!$ticket_arr) {
                $msg = "Invalid Ticket ID";
                $this->redirect($msg, "ticket_system/my_ticket", FALSE);
            }
            $this->set("ticket_arr", $ticket_arr);
            $this->set("ticket_count", count($ticket_arr));
            $msg = "";
            $this->redirect($msg, "ticket_system/view_ticket_details/$ticket_id", FALSE);
        }
        $search_flag = FALSE;
        if ($this->input->post('search')) {
            $login_id = $this->LOG_USER_ID;
            $tab1 = "";
            $tab2 = "";
            $tab3 = "";
            $tab4 = "";
            $tab5 = "";
            $tab6 = " active";
            $category_id = $this->input->post('category');
            $priority_id = $this->input->post('priority');
            $status_id = $this->input->post('status');
            if ($category_id == '' && $priority_id == '' && $status_id == '') {
                $msg = "Please select a search criteria";
                $this->redirect($msg, "ticket_system/my_ticket", FALSE);
            } else {
                
//                echo $category_id.'-----'.$priority_id.'-----'.$status_id;die();
                $search_flag = TRUE;
                $searched_tickets = $this->ticket_model->getSearchedTicketData($login_id, $status_id, $category_id, $priority_id);
                $this->set("searched_tickets", $searched_tickets);
                $this->set("searched_ticket_count", count($searched_tickets));
//                
//                print_r($searched_tickets);die();
                
            }
        }
        $this->set("search_flag", $search_flag);

        $this->set("close", $this->lang->line('close'));
        $this->set("reply", $this->lang->line('reply'));

        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->validation_model->getAdminId();
        $this->set('user_id', $user_id);
        $this->set('user_type', $user_type);
        $this->set('admin_id', $admin_id);

        $this->set("page_top_header", 'Ticket Management');
        $this->set("page_top_small_header", "");
        $this->set("page_header", 'Ticket Management');
        $this->set("page_small_header", "");

        $help_link = "mail-management";
        $this->set("help_link", $help_link);


        $this->load->model('ticket_model');
        $resolved_status = $this->ticket_model->getTicketStatusIdBasedOnStatus("Resolved");



        $config["total_rows"] = $this->ticket_model->getTicketDataCount('', $this->LOG_USER_ID, $resolved_status);

        $row = $this->ticket_model->getTicketData('', $this->LOG_USER_ID, $resolved_status, $config["per_page"], $page);


        $i = 0;
        $c = 0;
        $user_name_arr = array();
        $category_arr = $this->ticket_system_model->getTicketsCategories();
        $this->set("category_arr", $category_arr);
        $priority_arr = $this->ticket_system_model->getTicketsPriority();
        $this->set("priority_arr", $priority_arr);
        $status_arr = $this->ticket_system_model->getTicketsStatus();
        $this->set("status_arr", $status_arr);
        $this->set("row", $row);
        $cnt_row = count($row);
        $this->set("cnt_row", $cnt_row);
        $this->set("user_name_arr", $user_name_arr);
        $this->set("num_rows", $c);
        if ($action == "reopen") {
            $reopen_status = $this->ticket_model->getTicketStatusIdBasedOnStatus("Reopen");

            $reopen_ticket = $this->ticket_model->reopenTicket($edit_ticket_id, $reopen_status);
            if ($reopen_ticket) {
                $details = $this->ticket_model->insertToHistory($edit_ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, "Ticket Reopened");
                $msg = "Ticket reopened successfully";
                $this->redirect($msg, "ticket_system/my_ticket", TRUE);
            }
        }

        $config1["total_rows"] = $this->ticket_model->getResolvedTicketDataCount($this->LOG_USER_ID, $resolved_status, $config1["per_page"]);

        $resolved_tickets = $this->ticket_model->getResolvedTicketData($this->LOG_USER_ID, $resolved_status, $config1["per_page"], $page1);
        $this->set("resolved_tickets", $resolved_tickets);


        $this->load->model('Ticket_system_model');
        $category = $this->Ticket_system_model->getCategoryList();
        $faq = $this->Ticket_system_model->getFAQDetails();
        $this->set("category", $category);
        $this->set("faq", $faq);

        $result_per_page1 = '';
        $result_per_page = '';
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();


        $this->pagination->initialize($config1);
        $result_per_page1 = $this->pagination->create_links();


        $this->set("result_per_page1", $result_per_page1);
        $this->set("result_per_page", $result_per_page);


        if ($this->session->userdata("mail_tab_active_arr")) {
            $tab1 = $this->session->userdata['mail_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['mail_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['mail_tab_active_arr']['tab3'];
            $tab4 = $this->session->userdata['mail_tab_active_arr']['tab4'];
            $tab5 = $this->session->userdata['mail_tab_active_arr']['tab5'];
            $this->session->unset_userdata("mail_tab_active_arr");
        }
        $this->set("tab1", $tab1);
        $this->set("tab2", $tab2);
        $this->set("tab3", $tab3);
        $this->set("tab4", $tab4);
        $this->set("tab5", $tab5);
        $this->set("tab6", $tab6);
        $this->setView();
    }

    function view_ticket_details($ticket_id = '') {

        if (!$ticket_id) {
            $msg = "Please enter Ticket ID";
            $this->redirect($msg, "ticket_system/my_ticket", FALSE);
        }
        $title = $this->lang->line('support_center');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $this->load->model('ticket_model');
        $admin_username = $this->validation_model->getAdminUsername();

//        $subjects = $this->ticket_system_model->getSubjects();
// 
//        $this->set('subjects', $subjects);
        $cat_arr = $this->ticket_model->getCategory();

        $this->set("cat_arr", $cat_arr);


        $this->set("ticket_count", 0);
        $ticket_arr = array();

        $tab1 = "";
        $tab2 = "";
        $tab4 = "";
        $tab3 = "active";


        $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $this->LOG_USER_ID);
        if (!$ticket_arr) {
            $msg = "Invalid Ticket ID";
            $this->redirect($msg, "ticket_system/my_ticket", FALSE);
        }
        $ticket_reply = $this->ticket_model->getAllReply($ticket_arr['details0']['id']);
        
        $this->ticket_model->readTicket($ticket_arr['details0']['id']);
        $tick_count = count($ticket_reply);
        $admin_name = $this->validation_model->getAdminUsername();
        for ($i = 0; $i < $tick_count; $i++) {
            $file = $ticket_reply["$i"]['file'];
            $ticket_reply["$i"]['file'] = $file;
        }
        $this->set("ticket_reply", $ticket_reply);
        $this->set("cnt_row", count($ticket_reply));
        
        $this->set("ticket_arr", $ticket_arr);
        $this->set("ticket_count", count($ticket_arr));


        if ($this->input->post('reply')) {
            $category = $this->input->post('category');
            $ticket_id = $this->input->post('ticket_id');
            $message = $this->input->post('message');
            if (!$message) {
                $msg = "Please enter a message";
                $this->redirect($msg, "ticket_system/view_ticket_details/" . $ticket_id, FALSE);
            }
            $msg = '';
            $document1 = $_FILES['upload_doc']['name'];
            $doc_file_name = '';
            $file_details = array();
            if ($document1) {
                $upload_doc = 'upload_doc';
                $config['upload_path'] = 'public_html/images/ticket_system';
                $config['allowed_types'] = 'jpg|png|jpeg|JPG|gif';
                $config['max_size'] = '2000000';
                $this->load->library('upload', $config);



                if ($this->upload->do_upload($upload_doc)) {
                    $file_arr = $this->upload->data();
                    $file_details['original_name'] = $file_arr['orig_name'];
                    $file_details['saved_name'] = $file_arr['file_name'];
                    $file_details['file_size'] = $file_arr['file_size'];

                    $data = array('upload_data' => $this->upload->data());
                    $config1['upload_path'] = 'public_html/images/ticket_system';

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
                        $this->redirect($msg, "ticket_system/view_ticket_details/$ticket_id", FALSE);
                    }
                } else {
                    $msg = $this->upload->display_errors();

                    $this->redirect($msg, "ticket_system/view_ticket_details/$ticket_id", FALSE);
                }
            }
            $user_id = $this->LOG_USER_ID;
            $ticket_arr = $this->ticket_model->getTicketData($ticket_id, $user_id);
            
               
            if ($document1) {
                 $res1 = $this->ticket_model->insertIntoAttachment($ticket_id, $file_details, $doc_file_name);
            }
          
            
            $res = $this->ticket_model->replyTicket($ticket_arr, $message, $user_id, $doc_file_name, "distributor");
          
            if ($res) {
                $msg = $msg . "Reply Sent";
                $this->redirect($msg, "ticket_system/view_ticket_details/$ticket_id", TRUE);
            }
        }

       
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->validation_model->getAdminId();
        $this->set('user_id', $user_id);
        $this->set('user_type', $user_type);
        $this->set('admin_id', $admin_id);

//        $base_url = base_url() . "user/ticket_system/my_ticket";
//        $config['base_url'] = $base_url;
//        $config['per_page'] = 10;
//        $config["uri_segment"] = 4;
//        $config['num_links'] = 5;
//
//        if ($this->uri->segment(4) != "")
//            $page = $this->uri->segment(4);
//        else
//            $page = 0;
//        $this->set("page", $page);
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

    function ticket_time_line($ticket_id = '') {

        $title = $this->lang->line('time_line');
    
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $ticket_status = $this->ticket_system_model->getTicketStatus($ticket_id);
        $this->set("ticket_status", $ticket_status);
        $ticket_activity_history = $this->ticket_system_model->getTicketActivityHistory($ticket_id);

        foreach ($ticket_activity_history as $key => $part) {

            $sort[$key] = strtotime($part['date']);
        }
        array_multisort($sort, SORT_DESC, $ticket_activity_history);
        $count = count($ticket_activity_history);
        $this->set("activity_history", $ticket_activity_history);
        $this->set("count", $count);
        $this->set("ticket_id", $ticket_id);

        $this->setView();
    }

}

?>