<?php

require_once 'Inf_Controller.php';

class Ticket_system extends Inf_Controller {

    function __construct() {
        parent::__construct();
//      $this->load->model('ticket_system_model');
//      $this->load->model('ticket_model');
    }

    function home($tab = '') {

        $title = $this->lang->line('ticket_system');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $config = array();
        $config["per_page"] = 10;
        $config["uri_segment"] = 5;

        $category_submit = '';
        $ticket_search = '';

        if ($tab == "") {
            $this->session->unset_userdata('ticket_search');
            $this->session->unset_userdata('category_submit');
        }

        if ($this->input->post('category_submit')) {
            $page = 0;
            $category_submit = array();
            $category_submit['category_id'] = $this->input->post('category_name');
            $category_submit['tag_id'] = $this->input->post('tag-name');

            $this->session->set_userdata('category_submit', $category_submit);

            if ($this->session->userdata('ticket_search')) {
                $this->session->unset_userdata('ticket_search');
            }
        } elseif ($this->input->post('ticket_search')) {
            $page = 0;
            $ticket_search = array();
            $ticket_search['loged_user_id'] = $this->LOG_USER_ID;
            $ticket_search['search_based_on'] = $this->input->post('search_item');
            $ticket_search['search_text'] = $this->input->post('search_text');
            $ticket_search['tickt_category'] = $this->input->post('tckt_category');
            $ticket_search['dispaly'] = $this->input->post('total_tickets');
            $ticket_search['assigned_to_me'] = $this->input->post('s_my');
            $ticket_search['assigned_to_other'] = $this->input->post('s_ot');
            $ticket_search['un_assigned'] = $this->input->post('s_un');
            $ticket_search['tagged_ticket'] = $this->input->post('archive');
            $ticket_search['ticket_date'] = $this->input->post('week_date');

            $this->session->set_userdata('ticket_search', $ticket_search);
            if ($this->session->userdata('category_submit')) {
                $this->session->unset_userdata('category_submit');
            }
        } else {
            $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        }


        if ($this->session->userdata('category_submit')) {

            $base_url = base_url() . "admin/ticket_system/home/t1";
            $config['base_url'] = $base_url;

            $category_submit = $this->session->userdata('category_submit');
            $category_id = $category_submit['category_id'];
            $tag_id = $category_submit['tag_id'];

            if ($category_id && $tag_id) {

                $config["total_rows"] = $this->ticket_system_model->showTicketsCount($category_id, $tag_id);
                $this->pagination->initialize($config);
                $tickets = $this->ticket_system_model->showTickets($category_id, $tag_id, $config["per_page"], $page);
                $categoty_name = $this->ticket_system_model->getCategory($category_id);

                $panel_title = 'Category- <strong>' . $categoty_name . ' & Tag- ' . $tag_id . '</strong>';
            } elseif ($category_id) {
                $config["total_rows"] = $this->ticket_system_model->showTicketsCount($category_id);
                $this->pagination->initialize($config);
                $tickets = $this->ticket_system_model->showTickets($category_id, '', $config["per_page"], $page);
                $categoty_name = $this->ticket_system_model->getCategory($category_id);
                $panel_title = 'Category- <strong>' . $categoty_name . '</strong>';
            } elseif ($tag_id) {
                $config["total_rows"] = $this->ticket_system_model->showTicketsCount('', $tag_id);
                $this->pagination->initialize($config);
                $tickets = $this->ticket_system_model->showTickets('', $tag_id, $config["per_page"], $page);
                $panel_title = 'Tag- <strong>' . $tag_id . '</strong>';
            } else {


                $config["total_rows"] = $this->ticket_system_model->showResolvedTicketsCount();
                $this->pagination->initialize($config);

                $panel_title = 'Open Tickets';
                $tickets = $this->ticket_system_model->getAllUnresolvedTickets($config["per_page"], $page);
            }
            $this->set("panel_title", $panel_title);
        } else if ($this->session->userdata('ticket_search')) {

            $base_url = base_url() . "admin/ticket_system/home/t1";
            $config['base_url'] = $base_url;


            $ticket_search = $this->session->userdata('ticket_search');

            $loged_user_id = $ticket_search['loged_user_id'];
            $search_based_on = $ticket_search['search_based_on'];
            $search_text = $ticket_search['search_text'];
            $tickt_category = $ticket_search['tickt_category'];
            $dispaly = $ticket_search['dispaly'];
            $assigned_to_me = $ticket_search['assigned_to_me'];
            $assigned_to_other = $ticket_search['assigned_to_other'];
            $un_assigned = $ticket_search['un_assigned'];
            $tagged_ticket = $ticket_search['tagged_ticket'];
            $ticket_date = $ticket_search['ticket_date'];

            if ($search_text == "") {
                $msg = 'Please Enter Your search query';
                $this->redirect($msg, "ticket_system/home", FALSE);
            }
            if ($search_based_on == "") {
                $msg = 'You should select type for search';
                $this->redirect($msg, "ticket_system/home", FALSE);
            }


            $config["total_rows"] = $this->ticket_system_model->getAllTicketSearchCount($search_based_on, $search_text, $loged_user_id, $tickt_category, $ticket_date, $dispaly, $assigned_to_me, $assigned_to_other, $un_assigned, $tagged_ticket);
            $this->pagination->initialize($config);

            $tickets = $this->ticket_system_model->getAllTicketsBasedSearchType($search_based_on, $search_text, $loged_user_id, $tickt_category, $ticket_date, $dispaly, $assigned_to_me, $assigned_to_other, $un_assigned, $tagged_ticket, $config["per_page"], $page);
        } else {
            $base_url = base_url() . "admin/ticket_system/home/t1";
            $config['base_url'] = $base_url;

            $config["total_rows"] = $this->ticket_system_model->showResolvedTicketsCount();
            $this->pagination->initialize($config);
            $tickets = $this->ticket_system_model->getAllUnresolvedTickets($config["per_page"], $page);
        }

        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $category = $this->ticket_system_model->getCategoryList();
        $this->set("category", $category);
        $tags = $this->ticket_system_model->getTicketTags();
        $this->set("tags", $tags);

        $total_ticket = $this->ticket_system_model->getTotalTicketCount();
        $inprogress_ticket = $this->ticket_system_model->getInprogressTickets();
        $critical_ticket = $this->ticket_system_model->getCriticalTickets();
        $new_ticket = $this->ticket_system_model->getNewTickets();

        $this->set("total_ticket", $total_ticket);
        $this->set("inprogress_ticket", $inprogress_ticket);
        $this->set("critical_ticket", $critical_ticket);
        $this->set("new_ticket", $new_ticket);

        $this->set("tags", $tags);
        $count = count($tickets);

        $this->set("tickets", $tickets);
        $this->set("count", $count);

        $this->setView();
    }

    function faq($action = '', $id = '') {

        $title = $this->lang->line('faq');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('new_faq')) {
            $category = $this->input->post('category');
            $question = $this->input->post('question');
            $answer = $this->input->post('answer');

            if ($category && $question && $answer) {
                $ins_status = $this->ticket_system_model->insertFAQ($category, $question, $answer);
                if ($ins_status) {
                    $activity = 'Creating faq';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'FAQ created successfully...';
                    $this->redirect($msg, "ticket_system/faq", TRUE);
                } else {
                    $msg = 'Unable to created this FAQ...';
                    $this->redirect($msg, "ticket_system/faq", FALSE);
                }
            } else {
                $msg = 'Insufficiant content...';
                $this->redirect($msg, "ticket_system/faq", FALSE);
            }
        }
        if ($action == 'delete') {
            if ($id == '') {
                $this->redirect('', "ticket_system/faq", FALSE);
            } else {
                $del_status = $this->ticket_system_model->deleteFAQ($id);
                if ($del_status) {
                    $activity = 'delete faq';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'FAQ deleted successfully...';
                    $this->redirect($msg, "ticket_system/faq", TRUE);
                } else {
                    $msg = 'Unable to delete this FAQ...';
                    $this->redirect($msg, "ticket_system/faq", FALSE);
                }
            }
        }

        $category = $this->ticket_system_model->getCategoryList();
        $faq = $this->ticket_system_model->getFAQDetails();
        $this->set("category", $category);
        $this->set("faq", $faq);
        $this->setView();
    }

    function category($action = '', $id = '') {
        $title = $this->lang->line('category');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($action == 'delete') {
            if ($id != '') {
                $category_name = $this->ticket_system_model->getCategory($id);
                $del_status = $this->ticket_system_model->deleteCategory($id);
                if ($del_status) {
                    $activity = 'Inactivate category ' . '"' . $category_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Category inactivated successfully...';
                    $this->redirect($msg, "ticket_system/category", TRUE);
                } else {
                    $msg = 'Unable to inactivate this category...';
                    $this->redirect($msg, "ticket_system/category", FALSE);
                }
            }
        } elseif ($action == 'ativate') {
            if ($id != '') {
                $category_name = $this->ticket_system_model->getCategory($id);
                $del_status = $this->ticket_system_model->activateCategory($id);
                if ($del_status) {
                    $activity = 'Activate category ' . '"' . $category_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Category activated successfully...';
                    $this->redirect($msg, "ticket_system/category", TRUE);
                } else {
                    $msg = 'Unable to activate this category...';
                    $this->redirect($msg, "ticket_system/category", FALSE);
                }
            }
        } elseif ($action == 'new') {
            $this->set("create_new", true);
        } elseif ($action == 'edit') {
            if ($id != '') {
                $this->set("edit_status", true);
                $category = $this->ticket_system_model->getCategoryList($id);
                $assignee_name = $this->ticket_system_model->EmployeeIdToUserName($category[0]['assignee_id']);
                $this->set("edit_name", $category[0]['category_name']);
                $this->set("edit_assignee", $assignee_name);
                $this->set("edit_id", $category[0]['id']);
            }
        }

        if ($this->input->post('create')) {

            $category_name = $this->input->post('name');
            $emp_name = $this->input->post('employee');
            $valid_emp_name = $this->ticket_system_model->isEmployeeNameValid($emp_name);
            if ($valid_emp_name == 0) {
                $msg = 'Invalid employee name...';
                $this->redirect($msg, "ticket_system/category", FALSE);
            }
            $emp_id = $this->ticket_system_model->employeeNameToID($emp_name);

            if ($category_name) {
                $ins_status = $this->ticket_system_model->insertCategory($category_name, $emp_id);
                if ($ins_status) {

                    $activity = 'Added new category ' . '"' . $category_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Category created successfully...';
                    $this->redirect($msg, "ticket_system/category", TRUE);
                } else {
                    $msg = 'Unable to created this category...';
                    $this->redirect($msg, "ticket_system/category", FALSE);
                }
            }
        }
        if ($this->input->post('edit')) {

            $category_name = $this->input->post('name');
            $emp_name = $this->input->post('employee');
            $valid_emp_name = $this->ticket_system_model->isEmployeeNameValid($emp_name);
            if ($valid_emp_name == 0) {
                $msg = 'Invalid employee name...';
                $this->redirect($msg, "ticket_system/category", FALSE);
            }
            $emp_id = $this->ticket_system_model->employeeNameToID($emp_name);
            $id = $this->input->post('edit_id');
            if ($category_name && $id) {
                $upd_status = $this->ticket_system_model->updateCategory($category_name, $id, $emp_id);
                $activity = 'updating category';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($upd_status) {
                    $msg = 'Category updated successfully...';
                    $this->redirect($msg, "ticket_system/category", TRUE);
                } else {
                    $msg = 'Unable to updated this category...';
                    $this->redirect($msg, "ticket_system/category", FALSE);
                }
            }
        }

        $category = $this->ticket_system_model->getCategoryList();
        $this->set("category", $category);

        $this->setView();
    }

    function configuration($action = '', $id = '') {
        $title = $this->lang->line('configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = 'active';
        $tab2 = $tab3 = '';
        if ($action == 'delete') {
            $tab1 = 'active';
            $tab2 = $tab3 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            if ($id != '') {
                $status_name = $this->ticket_system_model->getStatus($id);
                $del_status = $this->ticket_system_model->deleteStatus($id);
                if ($del_status) {
                    $activity = 'Inactivate status ' . '"' . $status_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Status inactivated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to inactivated this status...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        } if ($action == 'activate') {
            $tab1 = 'active';
            $tab2 = $tab3 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            if ($id != '') {
                $status_name = $this->ticket_system_model->getStatus($id);
                $del_status = $this->ticket_system_model->activateStatus($id);
                if ($del_status) {
                    $activity = 'Activate status ' . '"' . $status_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Status activated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to activated this status...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        } elseif ($action == 'delete_tag') {
            $tab2 = 'active';
            $tab3 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

            if ($id != '') {
                $tag_name = $this->ticket_system_model->getTag($id);
                $del_status = $this->ticket_system_model->deleteTag($id);
                if ($del_status) {
                    $activity = 'Inactivate Tag ' . '"' . $tag_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Tag inactivated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to inactivate this tag...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        } elseif ($action == 'activate_tag') {
            $tab2 = 'active';
            $tab3 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

            if ($id != '') {
                $tag_name = $this->ticket_system_model->getTag($id);
                $del_status = $this->ticket_system_model->activateTag($id);
                if ($del_status) {
                    $activity = 'Activate Tag ' . '"' . $tag_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Tag activated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to activate this tag...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        } elseif ($action == 'delete_prio') {
            $tab3 = 'active';
            $tab2 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

            if ($id != '') {
                $priority_name = $this->ticket_system_model->getPriorityName($id);
                $del_status = $this->ticket_system_model->deletePriority($id);
                if ($del_status) {

                    $activity = 'inactivate priority' . '"' . $priority_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Priority inactivated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to inactivate this priority...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        } elseif ($action == 'activate_prio') {
            $tab3 = 'active';
            $tab2 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

            if ($id != '') {
                $priority_name = $this->ticket_system_model->getPriorityName($id);
                $del_status = $this->ticket_system_model->activatePriority($id);
                if ($del_status) {

                    $activity = 'activativate priority' . '"' . $priority_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'Priority activated successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'Unable to activate this priority...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        }


        if ($this->input->post('status_button')) {
            $tab1 = 'active';
            $tab2 = $tab3 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            $status_name = $this->input->post('status_name');
            if ($status_name) {
                $ins_status = $this->ticket_system_model->insertStatus($status_name);
                if ($ins_status) {
                    $activity = 'Created new status ' . '"' . $status_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'new status created successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'status is allready exist or invalid...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        }
        if ($this->input->post('tag_button')) {
            $tab2 = 'active';
            $tab3 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            $tag_name = $this->input->post('tag_name');
            if ($tag_name) {
                $ins_status = $this->ticket_system_model->insertTag($tag_name);
                if ($ins_status) {
                    $activity = 'Creating new tag ' . '"' . $tag_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'new tag created successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'tag is allready exist or invalid...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        }
        if ($this->input->post('priority_button')) {
            $tab3 = 'active';
            $tab2 = $tab1 = '';
            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            $prio_name = $this->input->post('priority_name');
            if ($prio_name) {
                $ins_status = $this->ticket_system_model->insertPriority($prio_name);
                if ($ins_status) {
                    $activity = 'Creating new priority ' . '"' . $prio_name . '"';
                    if ($this->LOG_USER_TYPE == "employee") {
                        $details = $this->ticket_model->insertToEmployeeHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    } else {
                        $details = $this->ticket_model->insertToHistory("", $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                    }
                    $msg = 'new priority created successfully...';
                    $this->redirect($msg, "ticket_system/configuration", TRUE);
                } else {
                    $msg = 'priority is allready exist or invalid...';
                    $this->redirect($msg, "ticket_system/configuration", FALSE);
                }
            }
        }

        $this->set("page_top_header", $this->lang->line('configuration'));
        $this->set("page_top_small_header", "");
        $this->set("page_header", $this->lang->line('configuration'));
        $this->set("page_small_header", "");
        $ticketstatus = $this->ticket_system_model->getTicketStatusList();
        $this->set("ticketstatus", $ticketstatus);
        $tickettags = $this->ticket_system_model->getTicketTagList();
        $this->set("tickettags", $tickettags);
        $ticketpriority = $this->ticket_system_model->getTicketPriorityList();
        $this->set("ticketpriority", $ticketpriority);



        if ($this->session->userdata('inf_config_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_config_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_config_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_config_tab_active_arr']['tab3'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->setView();
    }

    function status_change() {

        $id = $this->input->post('id');
       
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $option = $this->input->post('option');
        $status_descritpion = $this->ticket_system_model->getStatus($option);
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketStatus($id, $option);

            if ($stat) {
                $activity = 'Changing status of ticket to ' . '"' . $status_descritpion . '"';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($details)
                    echo $stat;
                else
                    echo 'false';
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function category_change() {
        $id = $this->input->post('id');
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $old_category_id = $this->ticket_system_model->getTicketCurrentCategory($ticket_id);

        $option = $this->input->post('option');
        $category = $this->ticket_system_model->getCategory($option);
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketCategory($id, $option);

            if ($stat) {
                $updt_count = $this->ticket_system_model->incrementCategoryCount($option);
                $decr_count = $this->ticket_system_model->decrementCategoryCount($old_category_id);
                $activity = 'Changing category of ticket to ' . '"' . $category . '"';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($details)
                    echo $stat;
                else
                    echo 'false';
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function priority_change() {

        $id = $this->input->post('id');
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $option = $this->input->post('option');
        $priority = $this->ticket_system_model->getPriority($option);
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketPriority($id, $option);

            if ($stat) {
                $activity = 'Changing priority of ticket to ' . '"' . $priority . '"';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($details)
                    echo $stat;
                else
                    echo 'false';
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function assignee_change() {
        $id = $this->input->post('id');
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $option = $this->input->post('option');
        $employee_name = $this->ticket_system_model->getEmployeeName($option);
        if ($id && $option) {
            $stat = $this->ticket_system_model->assignTicketToEmployee($id, $option);

            if ($stat) {
                $activity = 'Assigning ticket to' . '"' . $employee_name . '"';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($details)
                    echo $stat;
            }
            else {
                echo 'false';
            }
        }
        exit;
    }

    function update_tag() {

        $id = $this->input->post('id');
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $option = $this->input->post('option');
        $tag = $option;

        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketTag($id, $option);
            if ($stat) {
                $activity = 'Updating tag to ' . '"' . $tag . '"';
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                if ($details)
                    echo $stat;
                else {
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function ticket($id = '') {
        $title = $this->lang->line('ticket');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $msg = '';
        if ($id == '') {
            $this->redirect('', "ticket_system/home", FALSE);
        }

        if ($this->input->post('message_send')) {

            $message = $this->input->post('message');

            if (!$message) {
                if ($message == '') {
                    $msg = "Message field is empty";
                    $this->redirect($msg, "ticket_system/ticket/" . $id, FALSE);
                }
            }

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
                        $reply_to_user = $this->ticket_system_model->getTicketCreatedUser($id);
                        
                      
                        $msg = "Uploaded and ";
                    } else {
                        $msg = $this->upload->display_errors();
                        $this->redirect($msg, "ticket_system/ticket/$id", FALSE);
                    }
                } else {
                    $msg = $this->upload->display_errors();
                    $this->redirect($msg, "ticket_system/ticket/$id", FALSE);
                }
            }

            $user_id = $this->LOG_USER_ID;
            $ticket_id = $this->ticket_system_model->getTicketId($id);


            $res = $this->ticket_system_model->replyTicket($ticket_id, $message, $user_id, $doc_file_name, $this->LOG_USER_TYPE);
            if ($res) {
                $reply_to_user = $this->ticket_system_model->getTicketCreatedUser($ticket_id);
                $activity = 'Send reply to ' . $reply_to_user;
                $ticket_trackId = $this->ticket_system_model->getTicketTrackId($ticket_id);
                if ($this->LOG_USER_TYPE == "employee") {
                    $details = $this->ticket_model->insertToEmployeeHistory($ticket_trackId, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                } else {
                    $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                }
                $msg = $msg . "Reply Sent";
                $this->redirect($msg, "ticket_system/ticket/$id", TRUE);
            }
        }

        $ticket = $this->ticket_system_model->getTicketData($id);
        $ticket_id = $this->ticket_system_model->getTicketId($id);
        $ticket_replies = $this->ticket_system_model->getTicketReplies($ticket_id);

        
        
        $ticket_status = $this->ticket_system_model->getAllTicketStatus();
        $ticket_category = $this->ticket_system_model->getAllTicketCategory();
        $ticket_priority = $this->ticket_system_model->getAllTicketPriority();
        $ticket_tags = $this->ticket_system_model->getAllTicketTags();
        $employees = $this->ticket_system_model->getAllEmployees();
        $ticket_tags = '[\'' . implode('\',\'', $ticket_tags) . '\']';
        $this->set("ticket", $ticket);
        $this->set("ticket_status", $ticket_status);
        $this->set("ticket_category", $ticket_category);
        $this->set("ticket_priority", $ticket_priority);
        $this->set("ticket_replies", $ticket_replies);
        $this->set("ticket_tags", $ticket_tags);
        $this->set("employee_details", $employees);
        $this->setView();
    }

    function ticket_assign($action = '', $id = '') {
        $title = $this->lang->line('ticket_assign');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $flag = FALSE;

        $base_url = base_url() . "admin/ticket_system/ticket_assign";
        $config['base_url'] = $base_url;
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;
        $page = ($this->uri->segment($config["uri_segment"])) ? $this->uri->segment($config["uri_segment"]) : 0;
        $config["total_rows"] = $this->ticket_system_model->showResolvedTicketsCount();
        $this->pagination->initialize($config);

        $open_tickets = $this->ticket_system_model->getAllUnresolvedTickets($config["per_page"], $page);
        $count = count($open_tickets);
        $this->set("open_tickets", $open_tickets);
        $this->set("count", $count);
        if ($action == "assign") {
            $flag = TRUE;
            $this->set("ticket_id", $id);
        }
        if ($this->input->post('assign_employee')) {
            if ($this->input->post('employee') == "") {
                $msg = 'You must select an employee...';
                $this->redirect($msg, "ticket_system/ticket_assign/$action/$id", FALSE);
            }
            $employee_name = $this->input->post('employee');
            $is_employee_name_valid = $this->ticket_system_model->isEmployeeNameValid($employee_name);
            if ($is_employee_name_valid <= 0) {
                $msg = 'Invalid Employee name...';
                $this->redirect($msg, "ticket_system/ticket_assign/$action/$id", FALSE);
            }
            $ticket = $id;
            $assign_ticket = $this->ticket_system_model->assignTicketToEmployee($employee_name, $ticket);
            if ($assign_ticket) {
                $activity = "Assigning ticket to " . $employee_name;
                $details = $this->ticket_model->insertToHistory($ticket, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
            }
            if ($assign_ticket) {
                $msg = 'Ticket is assigned successfully';
                $this->redirect($msg, "ticket_system/ticket_assign", TRUE);
            }
        }

        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $this->set("flag", $flag);
        $this->setView();
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

    function tickets($type = 'all') {
        $title = "Tickets";
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $open_tickets = $this->ticket_system_model->getAllTickets($type);
        $count = count($open_tickets);
        $this->set("open_tickets", $open_tickets);
        $this->set("count", $count);

        if ($type == "critical")
            $ticket_type = "Critical Tickets";
        else if ($type == 'new')
            $ticket_type = "New Tickets";
        else if ($type == 'progress')
            $ticket_type = "In Progress Tickets";
        else
            $ticket_type = "Total Tickets";

        $this->set("ticket_type", $ticket_type);

        $this->setView();
    }

    function add_comments() {
        $id = $this->input->post('id');
        $ticket_id = $this->ticket_system_model->getTicketTrackId($id);
        $comments = $this->input->post('option');
        $user_id = $this->LOG_USER_ID;
        $add_comments = $this->ticket_system_model->addComments($user_id, $id, $ticket_id, $comments);
        if ($add_comments) {
            $activity = 'Added comment';
            if ($this->LOG_USER_TYPE == "employee") {
                $details = $this->ticket_model->insertToEmployeeHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity, $comments);
            } else {
                $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity, $comments);
            }
            echo 'true';
        } else
            echo 'false';
    }

}
