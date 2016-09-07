<?php

require_once 'Inf_Controller.php';

class employee extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function employee_register() {
        $title = lang('New_Employee_Registration');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('New_Employee_Registration');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('New_Employee_Registration');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $employee_reg_arr = array();
        if ($this->input->post('register') && $this->validate_employee_register()) {
            $reg_post_array = $this->input->post();
            $reg_post_array = $this->validation_model->stripTagsPostArray($reg_post_array);
            $reg_post_array = $this->validation_model->escapeStringPostArray($reg_post_array);
            $reg_arr['first_name'] = $reg_post_array['first_name'];
            $reg_arr['last_name'] = $reg_post_array['last_name'];
            $reg_arr['email'] = $reg_post_array['email'];
            $reg_arr['mobile'] = $reg_post_array['mobile_no'];
            $reg_arr['ref_username'] = $reg_post_array['ref_username'];
            if ($this->employee_model->isUserNameAvailable($reg_arr['ref_username'])) {
                $msg = lang('username_already_exists');
                $this->redirect($msg, 'employee/employee_register', FALSE);
            }
            $reg_arr['pswd'] = $reg_post_array['pswd'];
            $result = $this->employee_model->confirmRegistration($reg_arr);
            if ($result) {
//                $msg = lang('employee_registered');
                $msg = lang('registered');
                $this->redirect($msg, 'employee/employee_register', TRUE);
            } else {
                $msg = lang('You_must_enter_your_email');
                $this->redirect($msg, 'employee/employee_register', FALSE);
            }
        }
        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_employee_register() {
        $employee_reg_arr = $this->input->post();
        $this->session->set_userdata('inf_employee_reg_arr', $employee_reg_arr);
        if ($this->session->userdata("inf_employee_reg_arr")) {
            $employee_reg_arr = $this->session->userdata("inf_employee_reg_arr");
        }

        $this->set('employee_reg_arr', $employee_reg_arr);

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('ref_username', 'User Name', 'trim|required|strip_tags|min_length[6]');
        $this->form_validation->set_rules('pswd', 'Password', 'trim|required|strip_tags|min_length[6]|max_length[30]|alpha_numeric');
        $this->form_validation->set_rules('cpswd', 'Confirm Password', 'trim|required|strip_tags|min_length[6]|max_length[30]|matches[pswd]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|strip_tags|valid_email');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required|strip_tags|numeric|exact_length[10]');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function set_employee_permission() {
        $title = lang('set_employee_modules');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('set_employee_modules');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('set_employee_modules');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('permission') && $this->validate_set_employee_permission()) {
            $arr_post = $this->input->post();
            $arr_post = $this->validation_model->stripTagsPostArray($arr_post);
            $arr_post = $this->validation_model->escapeStringPostArray($arr_post);
            $user_name = $arr_post['user'];
            $result = $this->employee_model->insertIntoUserPermission($arr_post);
            if ($result) {
                $msg = lang('successfully_added');
                $this->redirect($msg, 'employee/set_employee_permission', TRUE);
            } else {
                $msg = lang('error_on_setting_permission');
                $this->redirect($msg, 'employee/set_employee_permission', FALSE);
            }
        }
        $user_name_submit = FALSE;
        if ($this->input->post('user_name_submit') && $this->validate_user_name_submit()) {

            $user_name_submit = TRUE;

            $emp_post_array = $this->input->post();
            $emp_post_array = $this->validation_model->stripTagsPostArray($emp_post_array);
            $emp_post_array = $this->validation_model->escapeStringPostArray($emp_post_array);

            $user_name = $emp_post_array['user_name'];

            if ($this->employee_model->isUserValid($user_name)) {
                $permission = $this->employee_model->viewPermission($user_name);

                $arr = explode(",", $permission);
                $c = 0;
                $main_menu = "";
                $other_menu = "";
                $main_count = 0;
                $other_count = 0;
                $other_menu_arr = Array();
                $menu_arr = Array();
                $main_menu2 = Array();
                $sub_menu_arr = Array();
                for ($i = 0; $i < count($arr); $i++) {
                    $menu = explode("#", $arr[$i]);
                    $m = "m";

                    if ($menu[0] == $m) {

                        $menu_arr[$main_count++] = $menu[1];
                    } else if ($menu[0] == "o") {

                        $other_menu_arr[$other_count++] = $menu[1];
                    } else {

                        $sub_menu_main_arr[$c] = $menu[0];
                        if (count($menu) == 2)
                            $sub_menu_arr[$c++] = $menu[1];
                    }
                }

                $menu_id = $this->employee_model->getMenuId();

                foreach ($menu_id->result_array() as $row) {
                    $menu_id = $row['id'];
                    $link = $this->employee_model->getMenuTextId($menu_id);
                    $menu_text = lang($menu_id . "_" . $link);
                    $sub_row = $this->employee_model->getsubMenuId($menu_id);
                    $c = $sub_row->num_rows();
                    $sub_menu = "";
                    $i = 0;
                    $flage = "b";
                    $count = 0;

                    foreach ($sub_row->result_array() as $row1) {
                        $sub_menu_id = $row1['sub_id'];
                        $sub_link = $this->employee_model->getSubmenuText($sub_menu_id);
                        $sub_text = lang($menu_id . "_" . $sub_menu_id . "_" . $sub_link);
                        if (in_array($row1['sub_id'], $sub_menu_arr)) {

                            $sub_menu.="<td></td> 
                                  <td>
                                        <input type='checkbox' name='" . $row1['sub_id'] . "' id='" . $row1['sub_id'] . "' value='" .
                                    $row['id'] . "#" . $row1['sub_id'] . "' checked='checked' />
                                        <label for='" . $row1['sub_id'] . "'></label>
                                        <font color ='#0000'> $sub_text</font>
                                  </td>";
                        } else {
                            $sub_menu.="<td></td> 
                                  <td>
                                        <input type='checkbox' name='" . $row1['sub_id'] . "' id='" . $row1['sub_id'] . "' value='" .
                                    $row['id'] . "#" . $row1['sub_id'] . "'/> 
                                        <label for='" . $row1['sub_id'] . "'></label>
                                        <font color ='#0000'> $sub_text </font>
                                  </td>";
                        }
                        $i++;
                        $count++;
                        if ($count == 3) {
                            $sub_menu.="</tr><tr>";
                            $count = 0;
                        }
                    }

                    if ($c != 0) {
                        $main_menu.= "<table>
                                <tr id='enq_main'>
                                  <td>
                                     <b> <font color ='#0000'>$menu_text</font></b>
                                  </td>
                                </tr> 
                                <tr id='enq'>" . $sub_menu . "</tr>
                              </table>";
                    } else {

                        if (in_array($row['id'], $menu_arr)) {
                            $main_menu.="<table>
                                    <tr>
                                        <td>
                                            <input type='checkbox' name='m" . $row['id'] . "k' id='" . $row['id'] . "' value='" .
                                    "m#" . $row['id'] . "' checked='checked' />
                                        <label for='" . $row['id'] . "'></label>
                                            <b><font color ='#0000'> $menu_text </font></b>
                                        </td>
                                    </tr>
                                </table>";
                        } else {
                            $main_menu.=" <table>
                                    <tr>
                                        <td>
                                            <input type='checkbox' name='m" . $row['id'] . "' id='m" . $row['id'] . "k' value='" .
                                    "m#" . $row['id'] . "' />
                                        <label for='m" . $row['id'] . "k'></label>
                                           <b> <font color ='#0000'> $menu_text</font> </b>
                                        </td>
                                    </tr>
                                </table>";
                        }
                    }
                }

                $submit_button = " <div class='form-group'>
                        <div class='col-sm-2 col-sm-offset-2'>
                            <button class='btn btn-bricky'  type='submit' align='center' name='permission' id='permission' value='Set Permission'>
                              Set Permission
                            </button>
                        </div>
                               </div>";

                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $this->set('main_menu', $main_menu);
                $this->set('other_menu', $other_menu);
                $this->set('submit_button', $submit_button);
                $this->set('user_name', $user_name);
            } else {
                $msg = lang('employee_not_found');
                $this->redirect($msg, 'employee/set_employee_permission', FALSE);
            }
        }

        $this->set('user_name_submit', $user_name_submit);

        $help_link = 'set-employee-permission';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_user_name_submit() {
        $this->form_validation->set_rules('user_name', 'Select User', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function validate_set_employee_permission() {
        $this->form_validation->set_rules('user', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function employee_auto($letters = '') {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////

        $employee_details = $this->employee_model->getEmployeeDetails($letters);
        echo $employee_details;
    }

    public function employee_username_availability() {
        $user_post_array = $this->input->post();
        //$user_post_array = $this->validation_model->stripTagsPostArray($user_post_array);
        //$user_post_array = $this->validation_model->escapeStringPostArray($user_post_array);
        $username = $user_post_array['user_name'];
        $flag = $this->employee_model->isUserValid($username);
        if ($flag || !ctype_alnum($username))
            echo "no"; //user already exists, hence username not available
        else
            echo "yes";
    }

    //-----------------------------------------------edited by amrutha
    function search_employee() {
        $title = lang('search_employee');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('search_employee');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('search_employee');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $flag = false;

        $base_url = base_url() . "admin/employee/search_employee/tab";
        $config['uri_segment'] = 5;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(5);
            $flag = TRUE;
        } else {
            $page = 0;
        }
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config['num_links'] = 5;

        $keyword = "";

        if ($this->input->post('search_employee')) {
            $flag = TRUE;
            $search_post_array = $this->input->post();
            $search_post_array = $this->validation_model->stripTagsPostArray($search_post_array);
            $search_post_array = $this->validation_model->escapeStringPostArray($search_post_array);
            $keyword = $search_post_array['keyword'];
            if ($keyword == '') {
                $msg = lang('please_search_atleast_a_character');
                $this->redirect($msg, 'employee/search_employee', FALSE);
            }
            $this->session->set_userdata('inf_ser_keyword', $keyword);
        } else if ($this->input->post('view_all')) {
            $this->redirect("", 'employee/view_all_employee');
        }

        $numrows = $this->employee_model->getCountMembers($this->session->userdata('inf_ser_keyword'));
        $config['total_rows'] = $numrows;
        $this->pagination->initialize($config);

        $emp_detail = $this->employee_model->getDetails($this->session->userdata('inf_ser_keyword'), $config['per_page'], $page);
        $count = count($emp_detail);

        $this->set('count', $count);
        $this->set('keyword', $keyword);
        $this->set('emp_detail', $emp_detail);
        $this->set('flag', $flag);

        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_search_employee() {

        $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function view_all_employee($action = '', $id = '') {

        $title = lang('view_all_employee');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_all_employee');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_all_employee');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set('visible', "none");
        $this->set('keyword', "");
        $this->set('visibility', "none");
        $keyword = 'all';

        $base_url = base_url() . "admin/employee/view_all_employee";
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $total_rows = $this->employee_model->getEmployeeDetailsCount();
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;
        $file_name = 'nophoto.jpg';

        $this->pagination->initialize($config);
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        $emp_detail = $this->employee_model->getEmployeDetails($config['per_page'], $page);
        $count = count($emp_detail);

        $config['total_rows'] = $count;
        $this->set('count', $count);
        $this->set('keyword', $keyword);
        $this->set('emp_detail', $emp_detail);

        $pagination = $this->pagination->create_links();
        $this->set('pagination', $pagination);

        $this->set('action', $action);
        $editdetails = array();

        $this->set('visibility', "none");
        if (($action == 'delete') && ($id != '')) {
            $result = $this->employee_model->deleteEmployeeDetails($id);
            if ($result) {
                $msg = lang('employee_details_deleted');
                $this->redirect($msg, 'employee/view_all_employee', TRUE);
            } else {
                $msg = lang('error_on_deleting_employee_details');
                $this->redirect($msg, 'employee/view_all_employee', FALSE);
            }
        } else if ($action == 'edit') {
            $this->set('visibility', "block");
            $this->set('visible', "");
            $editdetails = $this->employee_model->editEmployeeDetails($id);
            $edit_id = $editdetails[0]['user_detail_id'];
        }

        if (isset($edit_id)) {
            $file_name = $this->employee_model->getUserPhoto($edit_id);
        }
        if (!file_exists('public_html/images/employee/' . $file_name)) {
            $file_name = 'nophoto.jpg';
        }
        $this->set('editdetails', $editdetails);
        $this->set("file_name", $file_name);

        if ($this->input->post("update") && $this->validate_view_all_employee()) {

            $update_post_array = $this->input->post();
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);

            $first_name = $update_post_array["first_name"];
            $last_name = $update_post_array["last_name"];
            $emp_mob = $update_post_array["mobile"];
            $email = $update_post_array["email"];

            if ($_FILES['userfile']['error'] != 4) {
                $config['upload_path'] = './public_html/images/employee/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = lang('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'profile/profile_view', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/employee/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                    $res = $this->employee_model->changeProfilePicture($edit_id, $new_file_name);
                    if (!$res) {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'employee/view_all_employee', FALSE);
                    }
                }
            }

            $this->employee_model->updateContent($edit_id, $first_name, $last_name, $emp_mob, $email);
            $this->redirect("Employee Details updated", "employee/view_all_employee/edit/$edit_id", TRUE);
        }

        $this->setView();
    }

    function validate_view_all_employee() {
        $this->form_validation->set_rules('first_name', 'First Namekkkk', 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|strip_tags|alpha_numeric|max_length[32]|min_length[2]');
        $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|strip_tags|numeric|exact_length[10]');
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|strip_tags|valid_email');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function change_password() {
        $title = lang('change_employee_password');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('change_employee_password');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_employee_password');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_type = $this->LOG_USER_TYPE;
        $user_name = $this->LOG_USER_NAME;
        if ($this->input->post('change_pass_button') && $this->validate_change_password()) {

            $password_post_array = $this->input->post();
            $password_post_array = $this->validation_model->stripTagsPostArray($password_post_array);
            $password_post_array = $this->validation_model->escapeStringPostArray($password_post_array);
            $employee_name = $password_post_array['user_name'];
            if ($user_type != 'employee') {
                if ($this->employee_model->isUserNameAvailable($employee_name)) {
                    $new_pswd = $password_post_array['new_pwd'];
                    $result = $this->employee_model->updatePassword($new_pswd, $employee_name);
                    if ($result) {
                        $msg = lang('password_updated_successfully');
                        $this->redirect($msg, 'employee/change_password', TRUE);
                    } else {
                        $msg = lang('error_on_updating_password');
                        $this->redirect($msg, 'employee/change_password', FALSE);
                    }
                } else {
                    $msg = lang('employee_not_found');
                    $this->redirect($msg, 'employee/change_password', FALSE);
                }
            } else {
                if ($user_name == $employee_name) {
                    $new_pswd = $password_post_array['new_pwd'];
                    $result = $this->employee_model->updatePassword($new_pswd, $employee_name);
                    if ($result) {
                        $msg = lang('password_updated_successfully');
                        $this->redirect($msg, 'employee/change_password', TRUE);
                    } else {
                        $msg = lang('error_on_updating_password');
                        $this->redirect($msg, 'employee/change_password', FALSE);
                    }
                } else {
                    $msg = "You Dont Have Permission To Change Password";
                    $this->redirect($msg, 'employee/change_password', FALSE);
                }
            }
        }

        $help_link = 'employee-registration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_change_password() {

        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $this->form_validation->set_rules('new_pwd', 'Password', 'trim|required|strip_tags|min_length[6]|max_length[30]|alpha_numeric');
        $this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|strip_tags|min_length[6]|max_length[30]|matches[new_pwd]');

        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function ticket_system() {

        $title = $this->lang->line('ticket_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $emp_name = $this->LOG_USER_NAME;
        $emp_id = $this->LOG_USER_ID;
        $assigned_tickets = $this->employee_model->getAllAssignedTickets($emp_id);
        
        
//        print_r($assigned_tickets);die();
        $count = count($assigned_tickets);
        $this->set("assigned_tickets", $assigned_tickets);
        $this->set("count", $count);
        $this->setView();
    }

    function view_ticket_details($ticket_id = '') {

        $title = $this->lang->line('support_center');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $change_read_status = $this->employee_model->changeStatusToRead($ticket_id);
        if ($this->input->post('update_status')) {
            $status = $this->input->post('status');
            if ($status == "") {
                $msg = "You must select ticket status";
                $this->redirect($msg, "employee/view_ticket_details/$ticket_id", FALSE);
            }
            $update_tkt_status = $this->employee_model->updateTicketStatus($ticket_id, $status);
            if ($update_tkt_status) {
                $status_name = $this->employee_model->getStatus($status);
                $activity = "Changing status to  " . $status_name;
                $details = $this->ticket_model->insertToHistory($ticket_id, $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
                $msg = "Status changed successfully";
                $this->redirect($msg, "employee/view_ticket_details/$ticket_id", TRUE);
            }
        }

        $all_category = $this->employee_model->getAllCategory();
        $this->set("all_category", $all_category);
        $all_status = $this->employee_model->getAllStatus();

        $this->set("all_status", $all_status);
        $all_priority = $this->employee_model->getAllPriority();

        $this->set("all_priority", $all_priority);

        $this->load->model('mail_model');
        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);

        $this->load->model('ticket_model');

        $this->set("ticket_count", 0);
        $ticket_arr = array();
        $ticket_arr = $this->employee_model->getAssignedTicketData($ticket_id, $this->LOG_USER_ID);

        $ticket_reply = $this->employee_model->getAllReplyByEmployee($ticket_arr['details0']['id'], $this->LOG_USER_ID);
        $this->ticket_model->readTicket($ticket_arr['details0']['id']);
        $tick_count = count($ticket_reply);
        $admin_name = $this->mail_model->getAdminUsername();
        for ($i = 0; $i < $tick_count; $i++) {
            $file = $ticket_reply["$i"]['file'];
            $file = $this->getBetween($file, '#', ',');
            $ticket_reply["$i"]['file'] = $file;
        }
        $this->set("ticket_reply", $ticket_reply);
        $this->set("cnt_row", count($ticket_reply));
        if (!$ticket_arr) {
            
        }
        $this->set("ticket_arr", $ticket_arr);
        $this->set("ticket_count", count($ticket_arr));
        $this->set("ticket_track_id", $ticket_id);
//        $this->set("tran_email", $this->lang->line('email'));
//        $this->set("tran_category", $this->lang->line('category'));
//        $this->set("tran_priority", 'Priority');
//        $this->set("tran_subject", $this->lang->line('subject'));
//        $this->set("tran_submit_ticket", "Submit Ticket");
//        $this->set("tran_message", $this->lang->line('message'));
//        $this->set("tran_attachment", $this->lang->line('attachment'));
//        $this->set("tran_messagetoadmin", $this->lang->line('Message_to_Admin'));
//        $this->set("tran_sendmessage", $this->lang->line('send_message'));
//        $this->set("tran_compose_message", $this->lang->line('compose_message'));
//        $this->set("tran_compose_mail_user", $this->lang->line('compose_mail_user'));
//        $this->set("tran_user_name", $this->lang->line('user_name'));
//        $this->set("tran_kb", $this->lang->line('kb'));
//        $this->set("tran_sent_messages", $this->lang->line('sent_messages'));
//        $this->set("tran_Allowed_types_are_gif_jpg_png_jpeg_JPG", $this->lang->line('Allowed_types_are_gif_jpg_png_jpeg_JPG'));
//        $this->set("tran_user_message", $this->lang->line('user_message'));
//        $this->set("tran_All_Users", $this->lang->line('All_Users'));
//        $this->set("tran_select_type", $this->lang->line('select_type'));
//        $this->set("tran_support_center", $this->lang->line('support_center'));
//        $this->set("tran_you_must_select_user", $this->lang->line('you_must_select_user'));
//        $this->set("tran_you_must_enter_subject_here", $this->lang->line('you_must_enter_subject_here'));
//        $this->set("tran_you_must_enter_message_here", $this->lang->line('you_must_enter_message_here'));
//        $this->set("tran_You_have_no_messages", $this->lang->line('You_have_no_messages'));
//        $this->set("tran_inbox", $this->lang->line('inbox'));
//        $this->set("tran_no", $this->lang->line('no'));
//        $this->set("tran_from", $this->lang->line('from'));
//        $this->set("tran_to", $this->lang->line('to'));
//        $this->set("tran_subject", $this->lang->line('subject'));
//        $this->set("tran_date", $this->lang->line('date'));
//        $this->set("tran_action", $this->lang->line('action'));
//        $this->set("tran_admin", $this->lang->line('admin'));
//        $this->set("tran_message_details", $this->lang->line('message_details'));
//        $this->set("close", $this->lang->line('close'));
//        $this->set("reply", $this->lang->line('reply'));
//        $this->set("tran_change_status", $this->lang->line('change_status'));
//        $this->set("tran_update_status", $this->lang->line('update_status'));
//        $this->set("tran_change_priority", $this->lang->line('change_priority'));
//        $this->set("tran_update_priority", $this->lang->line('update_priority'));
//        $this->set("tran_move_ticket_to", $this->lang->line('move_ticket_to'));
//        $this->set("tran_update_category", $this->lang->line('update_category'));
//        $this->set("tran_Sure_you_want_to_Delete_There_is_NO_undo", $this->lang->line('Sure_you_want_to_Delete_There_is_NO_undo'));
        $user_id = $this->LOG_USER_ID;
        $user_type = $this->LOG_USER_TYPE;
        $admin_id = $this->mail_model->getAdminId();
        $this->set('user_id', $user_id);
        $this->set('user_type', $user_type);
        $this->set('admin_id', $admin_id);

        $base_url = base_url() . "admin/employee/view_ticket_details";
        $config['base_url'] = $base_url;
        $config['per_page'] = 200;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;

        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;
        $this->set("page", $page);
        $this->setView();
    }

    public function reply_ticket() {
        $ticket_id = $this->input->post('ticket_pass_id');
        $category = $this->input->post('category');

        $message = $this->input->post('message');
        if (!$message) {
            $msg = "Please enter a message";
            $this->redirect($msg, "employee/view_ticket_details/" . $ticket_id, FALSE);
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
                    $this->redirect($msg, "employee/view_ticket_details/$ticket_id", FALSE);
                }
            } else {
                $msg = $this->upload->display_errors();

                $this->redirect($msg, "employee/view_ticket_details/$ticket_id", FALSE);
            }
        }
        $user_id = $this->LOG_USER_ID;
        $ticket_arr = $this->employee_model->getAssignedTicketData($ticket_id, $user_id);
        if ($document1)
            $res1 = $this->ticket_model->insertIntoAttachment($ticket_id, $file_details, $doc_file_name);
        if ($document1) {
            if ($res1)
                $doc_file_name = $res1 . "#" . $doc_file_name;
        }
        $res = $this->ticket_model->replyTicket($ticket_arr, $message, $user_id, $doc_file_name, "employee");

        if ($res) {
            $ticket_created_user = $this->employee_model->ticketCreatedBy($ticket_arr["details0"]['ticket_id']);
            $user_name = $this->validation_model->IdToUserName($ticket_created_user);
            $activity = "Send reply to  " . $user_name;
            $details = $this->ticket_model->insertToHistory($ticket_arr["details0"]['ticket_id'], $this->LOG_USER_ID, $this->LOG_USER_TYPE, $activity);
            $msg = $msg . "Reply Send";
            $this->redirect($msg, "employee/view_ticket_details/$ticket_id", TRUE);
        }
    }

    public function getBetween($content, $start, $end) {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    function status_change() {

        $this->load->model('ticket_system_model');
        $id = $this->input->post('id');
        $option = $this->input->post('option');
        
       
        
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketStatus($id, $option);

            if ($stat) {
                echo $stat;
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function category_change() {

        $id = $this->input->post('id');
        $option = $this->input->post('option');
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketCategory($id, $option);
            if ($stat) {
                echo $stat;
            } else {
                echo 'false';
            }
        }
        exit;
    }

    function priority_change() {

        $id = $this->input->post('id');
        $option = $this->input->post('option');
        if ($id && $option) {
            $stat = $this->ticket_system_model->changeTicketPriority($id, $option);
            if ($stat) {
                echo $stat;
            } else {
                echo 'false';
            }
        }
        exit;
    }

}

?>