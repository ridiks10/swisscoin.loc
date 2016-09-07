<?php

require_once 'Inf_Controller.php';

class Epin extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function epin_management($from = '', $action = '', $delete_id = '', $page = '', $limit = '') {
        $title = lang('epin_management');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'e-pin-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = ' active';
        $tab2 = '';

        $total_pin = $this->epin_model->getUnallocatedPinCount();
        $amount_details = $this->epin_model->getAllEwalletAmounts();

        $search_pin_flag = 0;
        $search_pin_amount_flag = 0;
        $search_pin_details = array();
        $pin_status = 'active';
        $empty_msg = lang('your_account_have_no_active_epin');

        if ($this->input->post('view_pin')) {
            $pin_status = $this->input->post('pin_status');
            $this->session->set_userdata('inf_pin_status', $pin_status);
        }
        if ($this->session->userdata('inf_pin_status')) {
            $pin_status = $this->session->userdata('inf_pin_status');
            if ($pin_status == 'inactive') {
                $empty_msg = $this->lang->line('no_inactive_pin_found');
            }
        }

        $base_url = base_url() . 'admin/epin/epin_management';
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config['num_links'] = 5;
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }
        $pin_details = $this->epin_model->pinSelector($page, $config['per_page'], $pin_status);
        $pin_numbers = $pin_details['pin_numbers'];
        $num_rows = $pin_details['numrows'];
        $config['total_rows'] = $num_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        if ($this->input->post('addpasscode') && $this->validate_generate_epin()) {
            $add_post_array = $this->input->post();
            $add_post_array = $this->validation_model->stripTagsPostArray($add_post_array);
            $add_post_array = $this->validation_model->escapeStringPostArray($add_post_array);

            $uploded_date = date('Y-m-d H:i:s');
            $pin_alloc_date = date('Y-m-d H:i:s');
            $status = 'yes';
            $cnt = $add_post_array['count'];
            $pin_amount = $add_post_array['amount1'];
            $expiry_date = $add_post_array['date'];
            $res = $this->epin_model->generatePasscode($cnt, $status, $uploded_date, $pin_amount, $expiry_date, $pin_alloc_date);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($add_post_array);
                $this->validation_model->insertUserActivity($login_id, 'epin added', $login_id, $data);
                $msg = lang('epin_added_successfully');
                $this->redirect($msg, 'epin/epin_management', TRUE);
            } else {
                $msg = lang('error_on_adding_epin');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }

        if ($this->input->post('search_pin') && $this->validate_search_epin()) {
            $search_pin_flag = 1;
            $pin_number = strip_tags($this->input->post('keyword'));
            $search_pin_details = $this->epin_model->getPinDetails($pin_number, 'yes');
            if (count($search_pin_details) == 0) {
                $msg = lang('no_epin_found');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }

        if ($this->input->post('search_pin_pro') && $this->validate_search_pin_amount()) {
            $search_pin_amount_flag = 1;
            $amount = strip_tags($this->input->post('amount'));
            $search_pin_details = $this->epin_model->getPinSearch($amount, 'yes');
        }

        if ($this->session->userdata('inf_epin_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_epin_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_epin_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_epin_tab_active_arr');
        }

        $this->set('pin_numbers', $pin_numbers);
        $this->set('count', count($pin_numbers));
        $this->set('result_per_page', $result_per_page);
        $this->set('page', $page);
        $this->set('un_allocated_pin', $total_pin);
        $this->set('amount_details', $amount_details);
        $this->set('from', $from);
        $this->set('display', 'no-display');
        $this->set('search_pin_count', count($search_pin_details));
        $this->set('search_pin_details', $search_pin_details);
        $this->set('search_pin_flag', $search_pin_flag);
        $this->set('search_pin_amount_flag', $search_pin_amount_flag);
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('empty_msg', $empty_msg);
        $this->set('status', $pin_status);

        $this->setView();
    }

    function view_epin_request() {
        $title = lang('view_epin_request');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'view-pin-request';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_epin_request');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_epin_request');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        if ($this->input->post('allocate')) {
            $pin_post_array = $this->input->post();
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

            $total_count = $pin_post_array['total_count'];
            $admin_id = $this->LOG_USER_ID;
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type == 'employee') {
                $admin_id = $this->validation_model->getAdminId();
            }
            $uploded_date = date('Y-m-d H:i:s');
            $pin_alloc_date = date('Y-m-d H:i:s');
            $status = 'yes';
            $res = 0;
            $flag = 0;
            for ($i = 1; $i < $total_count; $i++) {
                $id = $pin_post_array['id' . $i];
                if (isset($pin_post_array['active' . $i])) {
                    $checked = $pin_post_array['active' . $i];
                } else {
                    $checked = 'no';
                }
                $pin_count = $pin_post_array['count' . $i];
                $allocate_id = $pin_post_array['user_id' . $i];
                $rem_count = $pin_post_array['rem_count' . $i];
                $expiry_date = $pin_post_array['expiry_date' . $i];
                $amount = $pin_post_array['amount' . $i];
                if ($checked == 'yes') {
                    $flag = 1;
                    if ($pin_count <= $rem_count) {
                        $this->epin_model->begin();
                        $res = $this->epin_model->ifChecked($id, $pin_count, $pin_alloc_date, $status, $uploded_date, $admin_id, $allocate_id, $rem_count, $amount, $expiry_date);
                    }
                }
            }
            if ($flag == '0') {
                $msg = lang('please_select_checkbox');
                $this->redirect($msg, 'epin/view_epin_request', FALSE);
            }
            if ($res) {
                $this->epin_model->commit();
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin requests granted', $this->LOG_USER_ID, $data);
                $msg = lang('epin_allocated_successfully');
                $this->redirect($msg, 'epin/view_epin_request', true);
            } else {
                $this->epin_model->rollback();
                $msg = lang('error_on_epin_allocation');
                $this->redirect($msg, 'epin/view_epin_request', false);
            }
        }
        /*         * ***********pagination************ */

        $base_url = base_url() . 'admin/epin/view_epin_request';
        $config['base_url'] = $base_url;

        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        } else
            $page = 0;
        $tot_rows = $this->epin_model->getAllPinRequestCount();
        $config['total_rows'] = $tot_rows;
        $this->pagination->initialize($config);
        /*         * ***********pagination************ */

        $pin_detail_arr = $this->epin_model->viewEPinRequest($pro_status, $config['per_page'], $page);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);

        $this->set('pin_detail_arr', $pin_detail_arr);
        $this->set('pro_status', $pro_status);
        $this->setView();
    }

    function allocate_pin_user() {
        $title = lang('epin_allocation_to_user');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'allocate-pin-to-user';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('epin_allocation_to_user');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('epin_allocation_to_user');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $amount_details = $this->epin_model->getAllEwalletAmounts();
        if ($this->input->post('insert') && $this->validate_allocate_pin_user()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            if (strtotime($post_arr['date']) <= strtotime('now')) {
                $msg = lang('you_must_select_a_to_date_greater_than_fromdate');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            }
            $user = strip_tags($this->validation_model->userNameToID($post_arr['user_name']));
            $res = $this->epin_model->generateEpin($post_arr['user_name'], $post_arr['amount1'], $post_arr['count'], $post_arr['date']);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $user_type = $this->LOG_USER_TYPE;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                }
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($login_id, 'epin allocated', $user, $data);
                $msg = lang('epin_allocated_successfully');
                $this->redirect($msg, 'epin/allocate_pin_user', TRUE);
            } else {
                $msg = lang('error_please_try_again');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            }
        }
        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    function validate_allocate_pin_user() {
        if ($this->input->post('insert')) {
            if (!$this->input->post('user_name')) {
                $msg = lang('you_must_enter_user_name');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            } else {
                $val_user = $this->epin_model->isUserNameAvailable($this->input->post('user_name'));
                if (!$val_user) {
                    $msg = lang('invalid_user');
                    $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
                }
            } if (!$this->input->post('amount1')) {
                $msg = lang('you_must_select_an_amount');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            } elseif (!$this->input->post('count')) {
                $msg = lang('you_must_enter_count');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            } elseif (!is_numeric($this->input->post('count'))) {
                $msg = lang('you_must_enter_number');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            } elseif (!$this->input->post('date')) {
                $msg = lang('you_must_select_a_date');
                $this->redirect($msg, 'epin/allocate_pin_user', FALSE);
            } else {
                return TRUE;
            }
        }
    }

    function view_pin() {
        $title = lang('view_pin_numbers');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'view-allocated-pin';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_pin_numbers');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_pin_numbers');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $flag = false;
        $base_url = base_url() . 'admin/epin/view_pin/tab';
        $product_status = $this->MODULE_STATUS['product_status'];

        if ($this->input->post('date_submit') && $this->validate_view_pin()) {
            $flag = true;
            $view_post_array = $this->input->post();
            $view_post_array = $this->validation_model->stripTagsPostArray($view_post_array);
            $view_post_array = $this->validation_model->escapeStringPostArray($view_post_array);
            $week_date1 = $view_post_array['week_date1'];
            $week_date2 = $view_post_array['week_date2'];
            $this->session->set_userdata('inf_week_date1', $week_date1);
            $this->session->set_userdata('inf_week_date2', $week_date2);
        }
        /*         * ***************pagination************** */
        $config['base_url'] = $base_url;
        $config['per_page'] = 200;
        $config['uri_segment'] = 5;
        $config['num_links'] = 5;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(5);
            $flag = true;
        } else
            $page = 0;
        $tot_row = $this->epin_model->getPinDetailsBasedData11Count($this->session->userdata('inf_week_date1'), $this->session->userdata('inf_week_date2'));
        $config['total_rows'] = $tot_row;
        $this->pagination->initialize($config);
        /*         * ***************pagination************** */
        $details_arr = $this->epin_model->getPinDetailsBasedData11($this->session->userdata('inf_week_date1'), $this->session->userdata('inf_week_date2'), $config['per_page'], $page);

        $this->set('product_status', $product_status);
        $this->set('date_submit', $this->input->post('date_submit'));
        $this->set('details_arr', $details_arr);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('flag', $flag);
        $this->setView();
    }

    function validate_view_pin() {
        if (!$this->input->post('week_date1')) {
            $msg = lang('you_must_enter_a_date');
            $this->redirect($msg, 'epin/view_pin', FALSE);
        } elseif (!$this->input->post('week_date2')) {
            $msg = lang('you_must_enter_a_date');
            $this->redirect($msg, 'epin/view_pin', FALSE);
        } elseif ($this->input->post('week_date1') > $this->input->post('week_date2')) {
            $msg = lang('you_must_select_a_to_date_greater_than_fromdate');
            $this->redirect($msg, 'epin/view_pin', FALSE);
        } else {
            return TRUE;
        }
    }

    function view_pin_user($action = '', $delete_id = '') {

        $title = lang('user_wise_epin');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'view-user-pin';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('user_wise_epin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_wise_epin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $mlm_plan = $this->MLM_PLAN;
        $flag = false;
        $base_url = base_url() . 'admin/epin/view_pin_user/tab';
        $product_status = $this->MODULE_STATUS['product_status'];
        $path_root = base_url() . 'admin/';

        $config['base_url'] = $base_url;
        $config['per_page'] = 200;
        $config['uri_segment'] = 5;
        $config['num_links'] = 5;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(5);
            $flag = true;
        } else
            $page = 0;
        $is_valid_username = false;
        if ($this->input->post('user_name') && $this->validate_view_pin_user()) {
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if (!$is_valid_username) {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'epin/view_pin_user', false);
            }
            $user = strip_tags($this->input->post('user_name'));
            $this->session->set_userdata('inf_username', $user);
            $flag = true;
        }
        $user_name = $this->session->userdata('inf_username');
        $total_rows = $this->epin_model->getPinDetailsForUser11Count($user_name);
        $pin_arr = $this->epin_model->getPinDetailsForUser11($user_name, $config['per_page'], $page);
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set('mlm_plan', $mlm_plan);
        $this->set('root', $path_root);
        $this->set('product_status', $product_status);
        $this->set('view', $this->input->post('view'));
        $this->set('is_valid_username', $is_valid_username);
        $this->set('username', $user_name);
        $this->set('pin_arr', $pin_arr);
        $this->set('result_per_page', $result_per_page);
        $this->set('flag', $flag);
        $this->set('user_name', $user_name);

        $this->setView();
    }

    function validate_view_pin_user() {
        if (!$this->input->post('user_name')) {
            $msg = lang('you_must_enter_user_name');
            $this->redirect($msg, 'epin/view_pin_user', false);
        } else {
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
            $validate_form = $this->form_validation->run();
            return $validate_form;
        }
    }

    function delete($delete_id = '') {

        $result = $this->epin_model->deleteEPin($delete_id);
        if ($result) {
            $data_array['delete_id'] = $delete_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);
            $msg = lang('epin_deleted_successfully');
            $this->redirect($msg, 'profile/user_account', TRUE);
        } else {
            $msg = lang('error_on_deleting_epin');
            $this->redirect($msg, 'profile/user_account', FALSE);
        }
    }

    function validate_generate_epin() {

        if ($this->input->post('addpasscode')) {
            $tab1 = 'active';
            $tab2 = '';
            $this->session->set_userdata('inf_epin_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $this->form_validation->set_rules('amount1', 'Amount', 'trim|required');
            $this->form_validation->set_rules('count', 'Count', 'trim|required');
            $this->form_validation->set_rules('date', 'Date', 'required');
            $this->form_validation->set_message('required', '%s Required');
            $val = $this->form_validation->run();
            if ($val) {
                $exp = $this->input->post('date');
                if ($exp < date("Y-m-d")) {
                    $msg1 = lang('old_date');
                    $this->redirect($msg1, 'epin/epin_management', FALSE);
                }
                $cnt = $this->input->post('count');
                $max_pincount = $this->epin_model->getMaxPinCount();
                $rec = $this->epin_model->getAllActivePinspage();
                if ($rec < $max_pincount) {
                    $errorcount = $max_pincount - $rec;
                    if ($cnt <= $errorcount) {
                        return TRUE;
                    } else {
                        $msg1 = lang('you_are_permitted_to_add');
                        $msg2 = lang('epin_only');
                        $this->redirect($msg1 . ' ' . $errorcount . ' ' . $msg2, 'epin/epin_management', FALSE);
                    }
                } else {
                    $msg1 = lang('already');
                    $msg2 = lang('epin_present');
                    $this->redirect($msg1 . ' ' . $rec . ' ' . $msg2, 'epin/epin_management', FALSE);
                }
            } else {
                $error = $this->form_validation->error_array();
                if (isset($error['amount1'])) {
                    $this->redirect($error['amount1'], 'epin/epin_management', FALSE);
                } elseif (isset($error['count'])) {
                    $this->redirect($error['count'], 'epin/epin_management', FALSE);
                } elseif (isset($error['date'])) {
                    $this->redirect($error['date'], 'epin/epin_management', FALSE);
                }
            }
        }
    }

    function validate_search_epin() {
        if ($this->input->post('search_pin')) {
            $tab1 = '';
            $tab2 = ' active';
            $this->session->set_userdata('inf_epin_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $this->form_validation->set_rules('keyword', 'Epin', 'trim|required');
            $this->form_validation->set_message('required', '%s Required');
            $val = $this->form_validation->run();
            if ($val) {
                return TRUE;
            } else {
                $error = $this->form_validation->error_array();
                if (isset($error['keyword'])) {
                    $this->redirect($error['keyword'], 'epin/epin_management');
                }
            }
        }
    }

    function validate_search_pin_amount() {
        if ($this->input->post('search_pin_pro')) {
            $tab1 = '';
            $tab2 = ' active';
            $this->session->set_userdata('inf_epin_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
            $this->form_validation->set_message('required', '%s Required');
            $val = $this->form_validation->run();
            if ($val) {
                return TRUE;
            } else {
                $error = $this->form_validation->error_array();
                if (isset($error['amount'])) {
                    $this->redirect($error['amount'], 'epin/epin_management');
                }
            }
        }
    }

    function active_epin($action = '', $delete_id = '') {

        if ($action == 'block') {
            $result = $this->epin_model->updateEPin($delete_id, 'no');
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deactivated', $this->LOG_USER_ID, $data);
                $msg = lang('epin_updated_successfully');
                $this->redirect($msg, 'epin/epin_management', TRUE);
            } else {
                $msg = lang('error_on_updating_epin');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }
    }

    function delete_epin($action = '', $delete_id = '') {

        if ($action == 'delete') {
            $result = $this->epin_model->deleteEPin($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);
                $msg = lang('epin_deleted_successfully');
                $this->redirect($msg, 'epin/epin_management', TRUE);
            } else {
                $msg = lang('error_on_deleting_epin');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }
    }

    function inactive_epin($action = '', $delete_id = '') {

        if ($action == 'activate') {
            $result = $this->epin_model->updateEPin($delete_id, 'yes');
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin activated', $this->LOG_USER_ID, $data);
                $msg = lang('epin_updated_successfully');
                $this->redirect($msg, 'epin/epin_management', TRUE);
            } else {
                $msg = lang('error_on_updating_epin');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }
    }

    function delete_all_epin($action = '', $pin_status = 'active', $page = '') {
        if ($action == 'delete') {
            $limit = 10;
            if ($page == '') {
                $page = 0;
            }
            $result = $this->epin_model->deleteAllEPin($pin_status, $page, $limit);
            if ($result) {
                $msg = lang('epin_deleted_successfully');
                $this->redirect($msg, 'epin/epin_management', TRUE);
            } else {
                $msg = lang('error_on_deleting_epin');
                $this->redirect($msg, 'epin/epin_management', FALSE);
            }
        }
    }

    function paging_footer() {
        $footer = $this->epin_model->setFooter();
        $this->set('footer', $footer);
    }

}

?>