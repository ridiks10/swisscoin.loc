<?php

require_once 'Inf_Controller.php';

class Configuration extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('epin_model');
        $this->load->model('profile_model');
    }

    function configuration_view($arg = NULL) {

        $title = lang('settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();

        $obj_arr_board = array();
        $arr_level = array();
        $board_count = '';
        $this->load->model('currency_model');
        if ($this->MLM_PLAN == "Board") {
            $obj_arr_board = $this->configuration_model->getBoardSettings();
            $board_count = count($obj_arr_board);
        }
        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            $arr_level = $this->configuration_model->getLevelSettings();
        }

        if ($arg == 'level') {
            $tab2 = ' active';
            $tab3 = $tab1 = $tab4 = $tab5 = $tab6 = NULL;
            $current_active_tab = 'tab2';
        } else if ($this->MODULE_STATUS ['referal_status'] == 'yes') {
            $tab3 = ' active';
            $tab1 = $tab2 = $tab4 = $tab5 = $tab6 = NULL;
            $current_active_tab = 'tab3';
        } else {
            $tab2 = ' active';
            $tab1 = $tab3 = $tab4 = $tab5 = $tab6 = NULL;
            $current_active_tab = 'tab2';
        }
        if ($this->input->post('active_tab')) {
            $current_active_tab = $this->input->post('active_tab');
        }

        if ($this->input->post('setting') && ($this->validate_configuration_view($current_active_tab))) {
            $conf_post_array = $this->input->post();
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $conf_post_array = $this->validation_model->escapeStringPostArray($conf_post_array);

            if ($this->MODULE_STATUS['opencart_status_demo'] == 'yes') {
                $conf_post_array['reg_amount'] = '0';
            }
            if ($conf_post_array['trans_fee'] < 0) {
                $msg = $this->lang->line('values_positive_amount');
                $this->redirect($msg, "configuration/configuration_view", FALSE);
            }
            $result = $this->configuration_model->updateConfigurationSettings($conf_post_array, $this->MODULE_STATUS, $board_count);

            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/configuration_view", true);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/configuration_view", FALSE);
            }
        }

        if ($this->session->userdata(' inf_config_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_config_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_config_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_config_tab_active_arr']['tab3'];
            $tab4 = $this->session->userdata['inf_config_tab_active_arr']['tab4'];
            $tab5 = $this->session->userdata['inf_config_tab_active_arr']['tab5'];
            $tab6 = $this->session->userdata['inf_config_tab_active_arr']['tab6'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }
        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);
        $this->set('tab6', $tab6);

        $this->set('obj_arr', $obj_arr);
        $this->set('obj_arr_board', $obj_arr_board);
        $this->set('arr_level', $arr_level);
        $this->set('project_default_currency', $project_default_currency);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_configuration_view($current_active_tab) {

        if ($current_active_tab == 'tab1') {
            $tab1 = ' active';
            $tab2 = $tab3 = $tab4 = $tab5 = $tab6 = NULL;
        } else if ($current_active_tab == 'tab2') {
            $tab2 = ' active';
            $tab1 = $tab3 = $tab4 = $tab5 = $tab6 = NULL;
        } else if ($current_active_tab == 'tab3') {
            $tab3 = ' active';
            $tab2 = $tab1 = $tab4 = $tab5 = $tab6 = NULL;
        } else if ($current_active_tab == 'tab4') {
            $tab4 = ' active';
            $tab2 = $tab3 = $tab1 = $tab5 = $tab6 = NULL;
        } else if ($current_active_tab == 'tab5') {
            $tab5 = ' active';
            $tab2 = $tab3 = $tab1 = $tab4 = $tab6 = NULL;
        } else if ($current_active_tab == 'tab6') {
            $tab6 = ' active';
            $tab2 = $tab3 = $tab1 = $tab4 = $tab5 = NULL;
        } else {
            $tab1 = ' active';
            $tab2 = $tab3 = $tab4 = $tab5 = $tab6 = NULL;
        }

        $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3, 'tab4' => $tab4, 'tab5' => $tab5, 'tab6' => $tab6));

        if ($current_active_tab == 'tab1') {
            if ($this->MLM_PLAN == "Binary") {
                $this->form_validation->set_rules('pair_ceiling', 'Pair Ceiling', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('pair_value', 'Pair Value', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('product_point_value', 'Product Point Value', 'trim|required|numeric|xss_clean');
                if ($this->MODULE_STATUS['sponsor_commission_status'] == "yes") {
                    $this->form_validation->set_rules('depth_ceiling', 'Depth Ceiling', 'trim|required|numeric|xss_clean|greater_than[0]|less_than[100]');
                }
            } else if ($this->MLM_PLAN == "Board") {
                $obj_arr_board = $this->configuration_model->getBoardSettings();
                $board_count = count($obj_arr_board);
                for ($i = 0; $i < $board_count; $i++) {
                    $this->form_validation->set_rules("board" . $i . "_name", 'Board 1 Name', 'trim|required|xss_clean');
                    $this->form_validation->set_rules("board" . $i . "_width", 'Board 1 Width', 'trim|required|numeric|xss_clean|greater_than[0]');
                    $this->form_validation->set_rules("board" . $i . "_depth", 'Board 1 Depth', 'trim|required|numeric|xss_clean|greater_than[0]');
                }
                if ($this->MODULE_STATUS['sponsor_commission_status'] == "yes") {
                    $this->form_validation->set_rules('depth_ceiling', 'Depth Ceiling', 'trim|required|numeric|xss_clean|greater_than[0]|less_than[100]');
                }
            } else if ($this->MLM_PLAN == "Unilevel") {
                $this->form_validation->set_rules('depth_ceiling', 'Depth Ceiling', 'trim|required|numeric|xss_clean|greater_than[0]|less_than[100]');
            } else if ($this->MLM_PLAN == "Matrix") {
                $this->form_validation->set_rules('depth_ceiling', 'Depth Ceiling', 'trim|required|numeric|xss_clean|greater_than[0]|less_than[100]');
                $this->form_validation->set_rules('width_ceiling', 'Width Ceiling', 'trim|required|numeric|xss_clean|greater_than[0]|less_than[100]');
            }
        } else if ($current_active_tab == 'tab2') {
            if ($this->MLM_PLAN == "Binary") {
                $this->form_validation->set_rules('pair_price', 'Pair Price', 'trim|required|numeric|xss_clean');
            }
            if ($this->MLM_PLAN == "Board") {
                $this->form_validation->set_rules('board1_commission', 'Board 1 Commission', 'trim|required|numeric|xss_clean');
                $this->form_validation->set_rules('board2_commission', 'Board 2 Commission', 'trim|required|numeric|xss_clean');
            } else
                return true;
        } else if ($current_active_tab == 'tab3') {
            $this->form_validation->set_rules('referal_amount', 'Amount', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab4') {
            $this->form_validation->set_rules('reg_amount', 'Registration Amount', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab5') {
            $this->form_validation->set_rules('tds', 'TDS', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('service_charge', 'Service Charge', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab6') {
            $this->form_validation->set_rules('trans_fee', 'Transaction Fee', 'trim|required|numeric|xss_clean');
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function payout_setting() {
        $title = lang('payout_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payout_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payout_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getSettings();
        $this->set('obj_arr', $obj_arr);

        if ($this->input->post('setting') && $this->validate_payout_setting($this->input->post())) {
            $payout_post_array = $this->input->post();
            $payout_post_array = $this->validation_model->stripTagsPostArray($payout_post_array);
            $payout_post_array = $this->validation_model->escapeStringPostArray($payout_post_array);

            $payout_status = $payout_post_array['payout_status'];
            $min_payout = round((floatval($payout_post_array['min_payout']) / $this->DEFAULT_CURRENCY_VALUE), 2);
            $max_payout = round((floatval($payout_post_array['max_payout']) / $this->DEFAULT_CURRENCY_VALUE), 2);
            $payout_validity = $payout_post_array['payout_validity'];

            if ($payout_validity == 0) {
                $payout_validity = 30;
            }

            $result = $this->configuration_model->updatePayoutSettng($min_payout, $payout_validity, $payout_status, $max_payout);
            if ($result) {
                $data = serialize($payout_post_array);
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'payout config updated', $login_id, $data);

                $module_name = 'payout_release_status';
                $this->configuration_model->setModuleStatus($module_name, $payout_status);

                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, 'configuration/payout_setting', true);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, 'configuration/payout_setting', FALSE);
            }
        }

        $help_link = 'network-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_payout_setting($post) {

        $min_payout = $post['min_payout'];
        $this->form_validation->set_rules('min_payout', 'Minimum Payout Amount', 'trim|required|numeric|xss_clean|greater_than[-1]');
        $this->form_validation->set_rules('max_payout', 'Maximum Payout Amount', "trim|required|numeric|xss_clean|greater_than[0]|callback_check_database_maximum[$min_payout]");
        $this->form_validation->set_rules('payout_validity', 'Payout Request', 'trim|required|numeric|xss_clean|greater_than[0]');
        $this->form_validation->set_rules('payout_status', 'Payout Method ', 'required');


        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('greater_than', 'The %s field should be greater than 0');
        $this->form_validation->set_message('greater_than', 'The %s field should be greater than 0');
        $this->form_validation->set_message('max_length', 'The %s field can not exceed 10 digits.');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function check_database_maximum($max_payout, $min_payout) {

        if ($min_payout < $max_payout) {
            $flag = true;
        } else {
            $msg = $this->lang->line('maximum_payout_bellow_minimum_payout');
            $this->redirect($msg, 'configuration/payout_setting', FALSE);
            $flag = false;
        }

        return $flag;
    }

    function stat_counter_settings() {
        $title = lang('stat_counter_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('stat_counter_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('stat_counter_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $obj_arr = $this->configuration_model->getStatcountSettings();
        $this->set('obj_arr', $obj_arr);

        if ($this->input->post('stat_submit') && $this->validate_stat_counter_setting()) {

            $stat_post_array = $this->input->post();
            $stat_post_array = $this->validation_model->stripTagsPostArray($stat_post_array);
            $stat_post_array = $this->validation_model->escapeStringPostArray($stat_post_array);

            $sc_project = $stat_post_array['project'];
            $sc_invisible = $stat_post_array['invisible'];
            $sc_security = $stat_post_array['security'];
            $res = $this->configuration_model->updateStatcountSettngs($sc_project, $sc_invisible, $sc_security);
            if ($res) {
                $msg = $this->lang->line('stat_count_updated_successfully');
                $this->redirect($msg, 'configuration/stat_counter_settings', true);
            } else {
                $msg = $this->lang->line('error_on_stat_count_updation');
                $this->redirect($msg, 'configuration/stat_counter_settings', FALSE);
            }
        }

        $help_link = 'network-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_stat_counter_setting() {
        $this->form_validation->set_rules('security', 'Payout Method ', 'required');
        $this->form_validation->set_rules('invisible', 'Payout Method ', 'required');
        $this->form_validation->set_rules('project', 'Payout Method ', 'required');
        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function my_referal() {

        $title = $this->lang->line('view_my_refferals');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'view-my-referrals';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $basurl = base_url() . 'admin/configuration/my_referal';
        $config['base_url'] = $basurl;
        $config['per_page'] = 100;
        $config['num_links'] = 5;
        $config['uri_segment'] = 4;

        $is_valid_username = false;
        $view = 'yes';

        if ($this->input->post('user_name') && $this->validate_my_referal()) {

            $referal_post_array = $this->input->post();
            $referal_post_array = $this->validation_model->stripTagsPostArray($referal_post_array);
            $referal_post_array = $this->validation_model->escapeStringPostArray($referal_post_array);

            $view = 'no';
            $user_name = $referal_post_array['user_name'];
            $this->set('user_name', $user_name);
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if ($this->validation_model->isUserNameAvailable($user_name)) {
                $user_id = $this->validation_model->userNameToID($user_name);
                $this->session->set_userdata('inf_user_id', $user_id);
            } else {
                $msg = $this->lang->line('invalid_user_name');
                $this->redirect($msg, 'configuration/my_referal', false);
            }
        }

        $user_id = $this->session->userdata('inf_user_id');
        $total_rows = $this->configuration_model->getReferalDetailscount($user_id);

        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $res = $this->configuration_model->getReferalDetails($user_id, $config['per_page'], $page);
        $result_per_page = $this->pagination->create_links();
        $count = count($res);

        $this->set('arr', $res);
        $this->set('count', $count);
        $this->set('result_per_page', $result_per_page);
        $this->set('view', $view);
        $this->set('is_valid_username', $is_valid_username);

        $this->setView();
    }

    function validate_my_referal() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function set_referal_status() {

        $title = lang('referal_income_status');
        $this->set("title", "$this->COMPANY_NAME | $title");

        $this->HEADER_LANG['page_top_header'] = lang('referral_status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('referral_status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post('set_referal_status') && $this->validate_set_referal_status()) {
            $ref_status = $this->input->post('referal_status');

            $res = $this->configuration_model->setReferalStatus($ref_status);
            if ($res) {
                $msg = $this->lang->line('Referral_status_Updated_Successfully');
                $this->redirect($msg, 'configuration/set_referal_status', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_referral_status_please_try_again');
                $this->redirect($msg, 'configuration/set_referal_status', false);
            }
        }

        $help_link = 'set_referal_status';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_set_referal_status() {


        $this->form_validation->set_rules('referal_status', 'Referral Status ', 'required');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function set_module_status() {

        $title = lang('Set_Module_Status');
        $this->set("title", "$this->COMPANY_NAME | $title");

        $this->HEADER_LANG['page_top_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $payout_release = $this->configuration_model->getPayOutTypes();

        if ($this->input->post('set_module_status')) {

            $module_name = $this->input->post('module_name');
            $new_module_status = $this->input->post('module_status');

            $res = $this->configuration_model->setModuleStatus($module_name, $new_module_status);

            if ($res) {
                $msg = $this->lang->line('Module_Status_Updated_Successfully');
                $this->redirect($msg, 'configuration/set_module_status', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_Module_status_please_try_again');
                $this->redirect($msg, 'configuration/set_module_status', false);
            }
        }

        $help_link = 'module-status';
        $this->set('help_link', $help_link);


        $this->setView();
    }

    function preview($lang_id = NULL) {

        $title = $this->lang->line('letter_preview');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();

        if ($lang_id == NULL) {
            $lang_id = $this->LANG_ID;
        }
        $this->set('lang_id', $lang_id);
        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $this->set('letter_arr', $letter_arr);
        $date = date('Y-m-d');
        $this->set('Date', $date);

        $help_link = 'Preview';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function pin_config() {

        $title = lang('epin_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('epin_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $pin_status = $this->MODULE_STATUS['pin_status'];

        if ($pin_status == 'yes') {
            $pin_config = $this->configuration_model->getPinConfig();
            $this->set('pin_config', $pin_config);

            if ($this->input->post('update') && ($this->validate_pin_config())) {

                $pin_post_array = $this->input->post();
                $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
                $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

                $pin_value = isset($pin_post_array['pin_value']) ? $pin_post_array['pin_value'] : '';
                $pin_character_set = $pin_post_array['pin_character'];
                $pin_maxcount = $pin_post_array['pin_maxcount'];
                $pin_length = 10;
                if (is_numeric($pin_maxcount)) {
                    $res = $this->configuration_model->setPinConfig($pin_value, $pin_length, $pin_maxcount, $pin_character_set);
                }
                if ($res) {
                    $data = serialize($pin_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin configuration updated', $this->LOG_USER_ID, $data);
                    $msg = $this->lang->line('pin_configuration_updated_sucessfully');
                    $this->redirect($msg, 'configuration/pin_config', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/pin_config', false);
                }
            }
        }

////////////////////////////////////////////////////////////
        if ($this->input->post('add_amount') && $this->validate_add_new_epin_amount()) {

            $pin_post_array = $this->input->post();
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

            $res = $this->epin_model->addPinAmount($pin_post_array['pin_amount']);
            if ($res == true) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'new epin added', $this->LOG_USER_ID, $data);
                $msg = lang('pin_amount_added_sucess');
                $this->redirect($msg, 'configuration/pin_config', true);
            } else {
                $msg = lang('unable_to_add_pin_amount');
                $this->redirect($msg, 'configuration/pin_config', false);
            }
        }

        if ($this->input->post('delete_amount')) {

            $pin_post_array = $this->input->post();
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

            $res = $this->epin_model->deletePinAmount($pin_post_array['pin_id']);
            if ($res) {
                $data = serialize($pin_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin deleted', $this->LOG_USER_ID, $data);
                $msg = lang('pin_amount_deleted_sucess');
                $this->redirect($msg, 'configuration/pin_config', true);
            } else {
                $msg = lang('unable_to_delete_pin_amount');
                $this->redirect($msg, 'configuration/pin_config', false);
            }
        }

        $pin_amounts = $this->epin_model->getAllEwalletAmounts();
        $count = count($pin_amounts);
        $this->set('pin_amounts', $pin_amounts);
        $this->set('count', $count);
/////////////////////////////////////////////////////////////
        $help_link = 'e-pin-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_add_new_epin_amount() {
        if (!$this->input->post('pin_amount')) {
            $msg = lang('add_new_epin_amount');
            $this->redirect($msg, 'configuration/pin_config', FALSE);
        } else {

            $pin_post_array = $this->input->post();
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

            if ($this->input->post('pin_amount') > 0) {
                $check = $this->epin_model->check_pin_amount($pin_post_array['pin_amount']);
                if ($check) {
                    $msg = lang('epin_amount_allready_available');
                    $this->redirect($msg, 'configuration/pin_config', false);
                } else {
                    return TRUE;
                }
            } else {
                $msg = lang('you_must_enter_number');
                $this->redirect($msg, 'configuration/pin_config', FALSE);
            }
        }
    }

///---------Form Validation -----------////////


    function validate_pin_config() {
        $this->form_validation->set_rules('pin_maxcount', 'Maximum Active E-Pin', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('pin_character', 'E-Pin Character  ', 'required');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('numeric', '%s is Numeric');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function username_config() {

        $title = lang('username_setting');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('username_setting');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('username_setting');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $username_config = $this->configuration_model->getUsernameConfig();
        $this->set('username_config', $username_config);

        if ($this->input->post('update') && $this->validate_username_config()) {

            $name_post_array = $this->input->post();
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            ;
            $name_post_array = $this->validation_model->escapeStringPostArray($name_post_array);

            $user_name_type = $name_post_array['user_name_type'];
            if ($name_post_array['user_name_type'] == 'static') {
                $res = $this->configuration_model->setUserNameType($user_name_type);
                if ($res) {
                    $data = serialize($name_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'username config changed to static', $this->LOG_USER_ID, $data);
                    $msg = $this->lang->line('user_name_configuration_updated_succesfully');
                    $this->redirect($msg, 'configuration/username_config', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_user_name_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/username_config', false);
                }
            } else {
                $length = $name_post_array['length'];
                $prefix_status = $name_post_array['prefix_status'];
                if ($prefix_status == 'yes') {
                    $prefix = $name_post_array['prefix'];
                } else {
                    $prefix = NULL;
                }
                if ($length != NULL && is_numeric($length) && $length >= 6 && $length <= 10) {
                    if ($prefix_status == 'yes') {
                        if (strlen($prefix) >= 2 && strlen($prefix) <= 5) {
                            $res = $this->configuration_model->setUsernameConfig($length, $prefix_status, $prefix, $user_name_type);
                        } else {
                            $msg = $this->lang->line('username_prefix_must_be_2_to_5_characters_long');
                            $this->redirect($msg, 'configuration/username_config', false);
                        }
                    } else {
                        $res = $this->configuration_model->setUsernameConfig($length, $prefix_status, $prefix, $user_name_type);
                    }
                    if ($res) {
                        $data = serialize($name_post_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'username config changed to dynamic', $this->LOG_USER_ID, $data);
                        $msg = $this->lang->line('user_name_configuration_updated_succesfully');
                        $this->redirect($msg, 'configuration/username_config', true);
                    } else {
                        $msg = $this->lang->line('error_on_updating_user_name_configuration_please_try_again');
                        $this->redirect($msg, 'configuration/username_config', false);
                    }
                } else {
                    $msg = $this->lang->line('username_must_be_at_least_6_characters_long');
                    $this->redirect($msg, 'configuration/username_config', false);
                }
            }
        }
        $help_link = 'username-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_username_config() {

        $res_val = FALSE;
        $this->form_validation->set_rules('user_name_type', 'Select A Username Type', 'required');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        if ($res_val && ($this->input->post('user_name_type') == 'dynamic')) {

            $this->form_validation->set_rules('length', 'Username Length', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('prefix_status', 'Username Prefix', 'required');

            $this->form_validation->set_message('required', '%s is Required');
            $this->form_validation->set_message('numeric', '%s is Numeric');
            $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
            $res_val = $this->form_validation->run();
        }

        return $res_val;
    }

    function content_management($lang_id = NULL) {

        $title = $this->lang->line('content_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load->model('swisscoin_model');
        $this->HEADER_LANG['page_top_header'] = lang('content_management');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('content_management');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;

        $this->set('lang_id', $lang_id);
        $terms = $this->configuration_model->getTermsConditionsSettings($lang_id);
        $this->set('terms', $terms);
        $tab1 = ' active';
        $tab2 = $tab3 = $tab4 = "";
		$tab5 = "";

        if ($this->input->post('content_submit')) {
            $tab1 =$tab3 =$tab4 = $tab5 = '';
            $tab2 = ' active';
            $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2,'tab3' => $tab3,'tab4' => $tab4, 'tab5' => $tab5  ));
            $post = $this->input->post();
            $post = $this->validation_model->stripTagsPostArray($post);
            $post = $this->validation_model->escapeStringPostArray($post);
            $post['txtDefaultHtmlArea1'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea1'));
            $lang_id = $post['lang_id'];
            $resu = $this->configuration_model->updateTermsConditionsSettings($post);
            if ($resu) {
                $data = serialize($post);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'terms and conditions updated', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('terms_and_conditions_successfull');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('error_on_terms_and_conditions_updation');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }

        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;
//        $this->set('lang_id', $lang_id);

        $letter_arr = $this->configuration_model->getLetterSetting($lang_id);
        $this->set('letter_arr', $letter_arr);

        $lang_arr = $this->configuration_model->getLanguages();
        $this->set('lang_arr', $lang_arr);
        if ($this->input->post('setting') && $this->validate_content_management('tab1')) {
            $post = $this->input->post();
            $post = $this->validation_model->stripTagsPostArray($post);
            $post = $this->validation_model->escapeStringPostArray($post);
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea'));
            $post['product_matter'] = $this->validation_model->stripTagTextArea($this->input->post('product_matter'));
            $site_info = $this->validation_model->getSiteInformation();
            $post['logo_name'] = $site_info['logo'];
            $lang_id = $post['lang_id'];
            $res = $this->configuration_model->updateLetterSetting($post);
            if ($res) {
                $data = serialize($post);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'welcome letter updated', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }
        
        
        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;
        $this->set('lang_id', $lang_id);

        $info_box_cash = $this->configuration_model->getInfoBoxDetails($lang_id,'cash_account');
        $info_box_trading = $this->configuration_model->getInfoBoxDetails($lang_id,'trading_account');
        $info_box_feedback = $this->configuration_model->getInfoBoxDetails($lang_id,'feedback');
        $this->set('info_box_cash', $info_box_cash);
        $this->set('info_box_trading', $info_box_trading);
        $this->set('info_box_feedback', $info_box_feedback);
      
        if ($this->input->post('info_submit')) {
            $tab1 =$tab2 = $tab4 = $tab5 = "";
            $tab3 = ' active';
              $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2,'tab3' => $tab3,'tab4' => $tab4, 'tab5' => $tab5  ));
            
            $post = $this->input->post();
            $post = $this->validation_model->stripTagsPostArray($post);
            $post = $this->validation_model->escapeStringPostArray($post);
            
            
            $post['lang_id'] = $this->input->post('lang_id');
            $lang_id = $post['lang_id'];
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea1'));
            $post['type']='cash_account';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea2'));
            $post['type']='trading_account';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea3'));
            $post['type']='feedback';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
           
            
           
            if ($res) {

                $msg = $this->lang->line('info_box_updated_successfully');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('info_failed_to_updated');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }
        // had to change cause of php version
        $__i = $this->input->post('footer_impressum_content');
		if( ! empty( $__i ) ) {
			$tab1 = $tab3 = $tab4 = $tab2 = '';
			$tab5 = ' active';
			$this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2,'tab3' => $tab3,'tab4' => $tab4, 'tab5' => $tab5  ));
			$content = $this->validation_model->stripTagTextArea($this->input->post('footer_impressum_content'));
			$this->swisscoin_model->updateImpressumContent( addslashes( $content ) );
		}
        $info_box_con_payza = $this->configuration_model->getInfoBoxDetails($lang_id,'con_payza');
        $info_box_con_payeer = $this->configuration_model->getInfoBoxDetails($lang_id,'con_payeer');
        $info_box_con_sepa = $this->configuration_model->getInfoBoxDetails($lang_id,'con_sepa');
        $info_box_con_swift = $this->configuration_model->getInfoBoxDetails($lang_id,'con_swift');
        $info_box_bitcoin = $this->configuration_model->getInfoBoxDetails($lang_id,'bitcoin');
        $info_box_con_e_wallet = $this->configuration_model->getInfoBoxDetails($lang_id,'con_e_wallet');
        $info_box_con_cash_acc = $this->configuration_model->getInfoBoxDetails($lang_id,'con_cash_acc');
        $info_box_con_trade_acc = $this->configuration_model->getInfoBoxDetails($lang_id,'con_trade_acc');
        $footer_impressum = $this->swisscoin_model->getImpressumContent();
        $this->set('info_box_con_payza', $info_box_con_payza);
        $this->set('info_box_con_payeer', $info_box_con_payeer);
        $this->set('info_box_con_sepa', $info_box_con_sepa);
        $this->set('info_box_con_swift', $info_box_con_swift);
        $this->set('info_box_bitcoin', $info_box_bitcoin);
        $this->set('info_box_con_e_wallet', $info_box_con_e_wallet);
        $this->set('info_box_con_cash_acc', $info_box_con_cash_acc);
        $this->set('info_box_con_trade_acc', $info_box_con_trade_acc);
        $this->set('footer_impressum', $footer_impressum );
        
        if ($this->input->post('info_con_submit')) {
            $tab1 = $tab2 = $tab3 = $tab5 = "";
            $tab4 = 'active';
              $this->session->set_userdata('inf_content_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2,'tab3' => $tab3,'tab4' => $tab4, 'tab5' => $tab5  ));
            
            $post = $this->input->post();
            $post = $this->validation_model->stripTagsPostArray($post);
            $post = $this->validation_model->escapeStringPostArray($post);
            
            
            $post['lang_id'] = $this->input->post('lang_id');
            $lang_id = $post['lang_id'];
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea1'));
            $post['type']='con_payza';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea2'));
            $post['type']='con_payeer';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea3'));
            $post['type']='con_sepa';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea4'));
            $post['type']='con_swift';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea5'));
            $post['type']='bitcoin';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea6'));
            $post['type']='con_e_wallet';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea7'));
            $post['type']='con_cash_acc';
            $res = $this->configuration_model->updateInfoBoxSetting($post);
            
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea8'));
            $post['type']='con_trade_acc';
            $res = $this->configuration_model->updateInfoBoxSetting($post);

            if ($res) {

                $msg = $this->lang->line('info_box_updated_successfully');
                $this->redirect($msg, "configuration/content_management/$lang_id", TRUE);
            } else {
                $msg = $this->lang->line('info_failed_to_updated');
                $this->redirect($msg, "configuration/content_management/$lang_id", FALSE);
            }
        }

		if ($this->session->userdata('inf_content_tab_active_arr')) {

            $tab1 = $this->session->userdata['inf_content_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_content_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_content_tab_active_arr']['tab3'];
            $tab4 = $this->session->userdata['inf_content_tab_active_arr']['tab4'];
            $this->session->unset_userdata('inf_content_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
		$this->set('tab5', $tab5);

        $help_link = 'content-management';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////


    function validate_content_management($active_tab) {

        if ($active_tab == 'tab1') {
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('company_add', 'Company Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('place', 'Place', 'trim|required|xss_clean');
        } else if ($active_tab == 'tab2') {

            $this->form_validation->set_rules(' lang_selector', 'Select a Language', 'trim|required|xss_clean');
      
        } else if ($active_tab == 'tab3') {

//            $this->form_validation->set_rules(' lang_selector', 'Select a Language', 'trim|required|xss_clean');
        }

        $this->form_validation->set_message('required', '%s is Required');

        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function set_payout_release_date() {

        $title = lang('Set_Module_Status');
        $this->set("title", $this->COMPANY_NAME . " | $title");


        $this->HEADER_LANG['page_top_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('Set_Module_Status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $payout_release = $this->configuration_model->getPayOutTypes();
        if ($this->input->post('payoutdate') && $this->validate_set_payout_release_date($payout_release)) {

            $payout_post_array = $this->input->post();
            $payout_post_array = $this->validation_model->stripTagsPostArray($payout_post_array);
            $payout_post_array = $this->validation_model->escapeStringPostArray($payout_post_array);

            $mdate1 = $payout_post_array['mdate1'];
            $mdate2 = $payout_post_array['mdate2'];
            $date1 = $payout_post_array['date1'];
            $date2 = $payout_post_array['date2'];

            if ($payout_release == 'monthly') {
                $mntharr = $this->configuration_model->getmonth($mdate1, $mdate2);
                $res = $this->configuration_model->insertmonth($mntharr);
            }
            if ($payout_release == 'week') {
                $weekdayNumber = 0;
                $s = $this->configuration_model->getDateForSpecificDayBetweenDates($date1, $date2, $weekdayNumber);
                $res = $this->configuration_model->insertdate($s);
            }
            if ($res) {

                $msg = $this->lang->line('payout_release_set_successfully');
                $this->redirect($msg, 'configuration/set_payout_release_date', true);
            } else {

                $msg = $this->lang->line('failed_to_set_payout_release_date');
                $this->redirect($msg, 'configuration/set_payout_release_date', false);
            }
        }
        $this->set('payout_release', $payout_release);

        $help_link = 'set_payout_release_date';
        $this->set('help_link', $help_link);
        $this->setView();
    }

    function validate_set_payout_release_date($payout_release) {

        if ($payout_release == 'monthly') {
            $this->form_validation->set_rules('mdate1', 'Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mdate2', 'Start Date', 'trim|required|xss_clean');
        } else if ($payout_release == 'week') {
            $this->form_validation->set_rules('date1', 'Start Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date2', 'Start Date', 'trim|required|xss_clean');
        }

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('numeric', '%s is Numeric');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function site_information() {

        $title = lang('site_information');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "site-information";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('site_information');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('site_information');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $tab1 = ' active';
        $tab2 = NULL;
        $current_active_tab = 'tab1';

        $def_admin_theme = $this->configuration_model->getThemeFolder();
        $admin_themes = array();
        $admin_directories = glob(APPPATH . 'views/admin/layout/themes/*');
        foreach ($admin_directories as $directory) {
            $name = basename($directory);
            $admin_themes[] = array("name" => $name,
                "default" => ($def_admin_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png");
        }
        rsort($admin_themes);

        $def_user_theme = $this->configuration_model->getUserThemeFolder();
        $user_themes = array();
        $user_directories = glob(APPPATH . 'views/user/layout/themes/*');
        foreach ($user_directories as $user_directory) {
            $name = basename($user_directory);
            $user_themes[] = array("name" => $name,
                "default" => ($def_user_theme == $name) ? 1 : 0,
                "icon" => $name . "/theme.png",
                "image" => $name . "/theme.png");
        }
        rsort($user_themes);

        $lang = $this->configuration_model->getLanguages();

        $site_info_arr = $this->configuration_model->getSiteConfiguration();
        $def_lang = $site_info_arr['default_lang'];
        $thumbnail_logo = $site_info_arr["logo"];
        $thumbnail_favicon = $site_info_arr["favicon"];

        if ($this->input->post('active_tab')) {
            $current_active_tab = $this->input->post('active_tab');
        }

        $preset_demo = 'no';
        // UNCOMMENT FOLLOWING LINES OF CODE WHEN UPLOADING TO infinitemlmsoftware.com
//        $table_prefix = substr($this->db->dbprefix, 0, -1);
//        if ((DEMO_STATUS == 'yes') && (($table_prefix == 5604) || ($table_prefix == 5553) || ($table_prefix == 5605) || ($table_prefix == 5606) || ($table_prefix == 5607))) {
//            $preset_demo = 'yes';
//        }

        if (($this->input->post('site'))) {
            if ($preset_demo == 'yes') {
                $msg = lang('this_option_is_not_available_in_preset_demos');
                $this->redirect($msg, 'configuration/site_information', FALSE);
            }
            $site_post_array = $this->input->post();
            $site_post_array = $this->validation_model->stripTagsPostArray($site_post_array);
            $site_post_array = $this->validation_model->escapeStringPostArray($site_post_array);

            $nam = $site_post_array['co_name'];
            $address = htmlentities($site_post_array['company_address']);
            $email = $site_post_array['email'];
            $phone = $site_post_array['phone'];
            $lead_url = $site_post_array['lead_url'];

            $url_pattern = "(http:\\|https\:\\)?([a-z0-9][a-z0-9\-]*\.)+[a-z0-9][a-z0-9\-]";
            if (!preg_match("%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i", $lead_url)) {
                $this->redirect("Invalid Url", "configuration/site_information", FALSE);
            } else {
                $admin_user_id = $this->ADMIN_USER_ID;
                $random_number = floor($admin_user_id * rand(1000, 9999));
                $config['file_name'] = "logo_" . $random_number;
                $config['upload_path'] = './public_html/images/logos/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
                $config['max_size'] = '2000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = "";

                if (!$this->upload->do_upload('img_logo')) {
                    $msg = $this->lang->line('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    //thumbnail creation start
                    $config1['image_library'] = 'gd2';
                    $config1['source_image'] = $image['full_path'];
                    $config1['create_thumb'] = TRUE;
                    $config1['maintain_ratio'] = FALSE;
                    $config1['width'] = 178;
                    $config1['height'] = 73;

                    $active_tab = $this->input->post('active_tab');
                    if ($active_tab == 'tab1') {
                        $tab1 = ' active';
                        $tab2 = NULL;
                    } else if ($active_tab == 'tab2') {
                        $tab2 = ' active';
                        $tab1 = NULL;
                    }
                    $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
                    $this->load->library('image_lib', $config1);
                    $this->image_lib->initialize($config1);
                    if (!$this->image_lib->resize()) {
                        $msg = $this->lang->line('image_cannot_be_uploaded');
                        $this->redirect($msg, "configuration/site_information", FALSE);
                    } else {
                        // get file THUMBNAIL image name //
                        $thumbnail_logo = $image_arr['upload_data']['raw_name'] . '_thumb' . $image_arr['upload_data']['file_ext'];
                    }
                    //THUMBNAIL ENDS
                }

                $config['file_name'] = "fav_" . $random_number;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('favicon')) {
                    $msg = $this->lang->line('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    //thumbnail creation start
                    $config1['image_library'] = 'gd2';
                    $config1['source_image'] = $image['full_path'];
                    $config1['create_thumb'] = TRUE;
                    $config1['maintain_ratio'] = FALSE;
                    $config1['width'] = 16;
                    $config1['height'] = 16;

                    $this->load->library('image_lib', $config1);
                    $this->image_lib->initialize($config1);
                    if (!$this->image_lib->resize()) {
                        $msg = $this->lang->line('image_cannot_be_uploaded');
                        $this->redirect($msg, "configuration/site_information", FALSE);
                    } else {
                        // get file THUMBNAIL image name //
                        $thumbnail_favicon = $image_arr['upload_data']['raw_name'] . '_thumb' . $image_arr['upload_data']['file_ext'];
                    }
                    //THUMBNAIL ENDS
                }

                $res = $this->configuration_model->siteConfiguration($nam, $address, $def_lang, $email, $phone, $thumbnail_logo, $thumbnail_favicon, $lead_url);
                if ($res) {
                    $data = serialize($site_post_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'site information updated', $this->LOG_USER_ID, $data);
                    $msg = $this->lang->line('site_configuration_completed');
                    $this->redirect($msg, "configuration/site_information", TRUE);
                } else {
                    $msg = $this->lang->line('error_on_site_configuration');
                    $this->redirect($msg, "configuration/site_information", FALSE);
                }
            }
        }
        if (($this->input->post('update_theme'))) {
            $active_tab = 'tab2';
            if ($active_tab == 'tab2') {
                $tab2 = ' active';
                $tab1 = NULL;
            }

            $this->session->set_userdata('inf_config_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $admin_folder = $this->input->post('admin_def_theme');
            $user_folder = $this->input->post('user_def_theme');
            $res = $this->configuration_model->updateThemeFolder($admin_folder, $user_folder);
            $active_tab = $this->input->post('active_tab');

            if ($res) {
                $msg = $this->lang->line('site_configuration_completed');
                $this->redirect($msg, "configuration/site_information", TRUE);
            } else {

                $msg = $this->lang->line('error_on_site_configuration');
                $this->redirect($msg, "configuration/site_information", FALSE);
            }
        }

        if ($this->session->userdata('inf_config_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_config_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_config_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_config_tab_active_arr');
        }

        $this->set('preset_demo', $preset_demo);
        $this->set('lang', $lang);
        $this->set('default_lang', $def_lang);
        $this->set("site_info_arr", $site_info_arr);

        $this->set('def_admin_theme_folder', $def_admin_theme);
        $this->set('admin_themes', $admin_themes);
        $this->set('def_user_theme_folder', $def_user_theme);
        $this->set('user_themes', $user_themes);

        $this->set('baseurl', base_url());
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);

        $this->setView();
    }

    function site_status() {

        $title = $this->lang->line('site_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('site_status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('site_status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->input->post('setting') && $this->validate_site_status()) {
            $status = $this->input->post('site_status');
            $content = $this->input->post('content');

            $res = $this->configuration_model->updateSiteStatus($status, $content);
            if ($res) {
                $msg = $this->lang->line('Site_Status_Updated_Successfully');
                $this->redirect($msg, 'configuration/site_status', true);
            } else {
                $msg = $this->lang->line('Error_on_site_status_updation');
                $this->redirect($msg, 'configuration/site_status', false);
            }
        }

        $help_link = 'site_status';
        $this->set('help_link', $help_link);
        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_site_status() {

        $this->form_validation->set_rules('site_status', 'Site status', 'required|xss_clean');
        $this->form_validation->set_rules('content', 'Maintenance Content', 'trim|required|xss_clean');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('numeric', '%s is Numeric');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function mail_settings() {

        $title = $this->lang->line('mail_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('mail_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('mail_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mail_details = $this->configuration_model->getMailDetails();
        $this->set('mail_details', $mail_details);
        if ($this->input->post('update') && $this->validate_mail_settings($mail_details)) {

            $settings_post_array = $this->input->post();
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);
            $settings_post_array = $this->validation_model->escapeStringPostArray($settings_post_array);

            $mail_setting['reg_mail_type'] = $settings_post_array['reg_mail_type'];
            $mail_setting['smtp_host'] = $settings_post_array['smtp_host'];
            $mail_setting['smtp_username'] = $settings_post_array['smtp_username'];
            $mail_setting['smtp_password'] = $settings_post_array['smtp_password'];
            $mail_setting['smtp_port'] = $settings_post_array['smtp_port'];
            $mail_setting['smtp_timeout'] = $settings_post_array['smtp_timeout'];
            $mail_setting['smtp_authentication'] = $settings_post_array['smtp_auth_type'];
            $mail_setting['smtp_protocol'] = $settings_post_array['smtp_protocol'];

            $res = $this->configuration_model->updateMailSettings($mail_setting);
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                $data = serialize($mail_setting);
                $this->validation_model->insertUserActivity($login_id, 'mail config updated', $login_id, $data);
                $msg = $this->lang->line('mail_settings_updated_successfully');
                $this->redirect($msg, 'configuration/mail_settings', true);
            } else {
                $msg = $this->lang->line('Error_on_mail_settings_updation');
                $this->redirect($msg, 'configuration/mail_settings', false);
            }
        }

        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_mail_settings($mail_details) {
        $this->form_validation->set_rules('reg_mail_type', 'Registration mail type', 'required');
        if ($mail_details["reg_mail_type"] == "smtp") {
            $this->form_validation->set_rules('smtp_host', 'smtp host', 'required');
            $this->form_validation->set_rules('smtp_username', 'smtp Username', 'required');
            $this->form_validation->set_rules('smtp_password', 'smtp Password', 'required');
            $this->form_validation->set_rules('smtp_port', 'smtp Port', 'required');
            $this->form_validation->set_rules('smtp_timeout', 'smtp Timeout', 'required');
            $this->form_validation->set_rules('smtp_auth_type', 'SMTP authentication', 'required');
            $this->form_validation->set_rules('smtp_protocol', 'SMTP Protocol', 'required');
        }
        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function general_mail($id = NULL) {

        $title = $this->lang->line('mail_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('mail_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('mail_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $letter_arr = array();

        $letter_arr = $this->configuration_model->getMailHistory();
        $this->set('letter_arr', $letter_arr);

        if ($this->input->post('send') && $this->validate_general_mail()) {
            $post = $this->input->post();
            $post = $this->validation_model->stripTagsPostArray($post);
            $post = $this->validation_model->escapeStringPostArray($post);
            $post['txtDefaultHtmlArea'] = $this->validation_model->stripTagTextArea($this->input->post('txtDefaultHtmlArea'));
            for ($i = 0; $i < 3; $i++) {
                if ($_FILES['userfile' . $i]['error'] != 4) {
                    $config['upload_path'] = './public_html/images/general_mail/';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|txt';
                    $config['max_size'] = '2000000000';
                    $config['max_width'] = '1024000';
                    $config['max_height'] = '768000';
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('userfile' . $i)) {

                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $data = array('upload_data' => $this->upload->data());
                        $post['userfile' . $i] = $data['upload_data']['file_name'];
                    }
                }
            }
            if ($post['send'] == 'send') {
                $res = $this->configuration_model->insertGeneralMail($post);
                $this->validation_model->sendMail($post);
            }

            if ($res) {
                $msg = $this->lang->line('General mail Successfully send');
                $this->redirect('General mail Successfully send', 'configuration/general_mail', TRUE);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg . '3', 'configuration/general_mail', FALSE);
            }
        }

        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_general_mail() {

        $this->form_validation->set_rules('send_from', 'Send From', 'trim|required|xss_clean');
        $this->form_validation->set_rules('txtDefaultHtmlArea', 'Main Matter', 'trim|required|xss_clean');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function board_configuration($action = NULL, $edit_id = NULL) {

        $title = $this->lang->line('board_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('board_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('board_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->set('edit_id', null);
        $this->set('board_id', null);
        $this->set('board_width', null);
        $this->set('board_depth', null);
        $this->set('board_name', null);
        $this->set('board_commission', null);
        $this->set('sponser_follow_status', null);
        $this->set('re_entry_status', null);
        $this->set('re_entry_to_next_status', null);
        if ($action == 'edit') {

            $row = $this->configuration_model->selectBoardDetails($edit_id);
            $this->set('edit_id', $edit_id);
            $this->set('board_width', $row['board_width']);
            $this->set('board_depth', $row['board_depth']);
            $this->set('board_name', $row['board_name']);
            $this->set('board_commission', $row['board_commission']);
            $this->set('sponser_follow_status', $row['sponser_follow_status']);
            $this->set('re_entry_status', $row['re_entry_status']);
            $this->set('re_entry_to_next_status', $row['re_entry_to_next_status']);
        }

        if ($this->input->post('board_update') && $this->validate_board_configuration()) {
            $this->set('edit_id', $edit_id);

            $board_post_array = $this->input->post();
            $board_post_array = $this->validation_model->stripTagsPostArray($board_post_array);
            $board_post_array = $this->validation_model->escapeStringPostArray($board_post_array);

            $board_width = $board_post_array['board_width'];
            $board_depth = $board_post_array['board_depth'];
            $board_name = $board_post_array['board_name'];
            $board_commission = $board_post_array['board_commission'];
            $re_entry_status = $board_post_array['re_entry_status'];
            $sponser_follow_status = $board_post_array['sponser_follow_status'];
            $re_entry_to_next_status = $board_post_array['re_entry_to_next_status'];
            $res = $this->configuration_model->updateBoard($edit_id, $board_width, $board_depth, $board_name, $board_commission, $re_entry_status, $sponser_follow_status, $re_entry_to_next_status);
            if ($res) {
                $msg = $this->lang->line('board_updated_successfully');
                $this->redirect($msg, 'configuration/board_configuration', TRUE);
            } else {
                $msg = $this->lang->line('Error_On_Updating_board');
                $this->redirect($msg, 'configuration/board_configuration', FALSE);
            }
        }

        $board_details = $this->configuration_model->getAllBoardDetails();
        $count = count($board_details);
        $this->set('board_details', $board_details);
        $this->set('count', $count);

        $help_link = 'board-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function validate_board_configuration() {

        $this->form_validation->set_rules('board_commission', 'Board Commission', 'trim|required|xss_clean');

        $this->form_validation->set_rules('board_width', 'Board Width', 'trim|required|xss_clean');
        $this->form_validation->set_rules('board_depth', 'Board Depth', 'trim|required|xss_clean');

        $this->form_validation->set_rules('board_name', 'Board Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('re_entry_status', 'Re Entry Status', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sponser_follow_status', 'Sponser Follow Status', 'trim|required|xss_clean');

        $this->form_validation->set_rules('re_entry_to_next_status', 'Re Entry To Next Status', 'trim|required|xss_clean');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('greater_than', 'The %s should be greater than or equal to 0');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function rank_configuration($action = NULL, $edit_id = NULL) {

        $title = $this->lang->line('rank_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('rank_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');
        $this->load_langauge_scripts();

        $this->set('edit_id', null);
        $this->set('rank_id', null);
        $this->set('rank_name', null);
        $this->set('referal_count', null);
        $this->set('rank_bonus', null);
        if ($action == 'edit') {
            $row = $this->configuration_model->selectRankDetails($edit_id);
            $this->set('edit_id', $edit_id);
            $this->set('rank_id', $row['rank_id']);
            $this->set('rank_name', $row['rank_name']);
            $this->set('referal_count', $row['referal_count']);
            $this->set('rank_bonus', $row['rank_bonus']);
        }
        if ($action == 'inactivate') {
            $msg = '';
            $result = $this->configuration_model->inactivate_rank($rank_id);
            if ($result) {
                $msg = $this->lang->line('rank_inactivated_successfully');
                $this->redirect($msg, 'configuration/rank_configuration', TRUE);
            } else {
                $msg = $this->lang->line('error_on_inactivating_rank');
                $this->redirect($msg, 'configuration/rank_configuration', FALSE);
            }
        }
        if ($action == 'delete_rank') {
            $result = $this->configuration_model->delete_rank($edit_id);
            if ($result) {
                $msg = $this->lang->line('rank_deted_sucessfully');
                $this->redirect($msg, 'configuration/rank_configuration', TRUE);
            } else {
                $msg = $this->lang->line('error_rank_deletion');
                $this->redirect($msg, 'configuration/rank_configuration', FALSE);
            }
        }

        if ($this->input->post('rank_update') && $this->validate_rank_configuration()) {
            $rank_post_array = $this->input->post();
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $rank_post_array = $this->validation_model->escapeStringPostArray($rank_post_array);

            $rank_id1 = $rank_post_array['rank_id'];
            $rank_name1 = $rank_post_array['rank_name'];
            $referal_count1 = $rank_post_array['ref_count'];
            $rank_bonus1 = $rank_post_array['rank_achievers_bonus'];

            $res = $this->configuration_model->updateRank($rank_id1, $rank_name1, $referal_count1, $rank_bonus1);
            if ($res) {
                $msg = $this->lang->line('rank_updated_successfully');
                $this->redirect($msg, 'configuration/rank_configuration', TRUE);
            } else {
                $msg = $this->lang->line('Error_On_Updating_Rank');
                $this->redirect($msg, 'configuration/rank_configuration', FALSE);
            }
        }
        if ($this->input->post('rank_submit') && $this->validate_rank_configuration()) {
            $rank_post_array = $this->input->post();
            $rank_post_array = $this->validation_model->stripTagsPostArray($rank_post_array);
            $rank_post_array = $this->validation_model->escapeStringPostArray($rank_post_array);

            $rank_name = $rank_post_array['rank_name'];
            $ref_count = $rank_post_array['ref_count'];
            $rank_bonus = $rank_post_array['rank_achievers_bonus'];
            if ($rank_name == NULL || $ref_count == NULL) {
                $this->redirect('Enter All Details', 'configuration/rank_configuration', false);
            } else {

                $res = $this->configuration_model->insertRankDetails($rank_name, $ref_count, $rank_bonus);
                if ($res) {
                    $msg = $this->lang->line('Rank_Details_Inserted_Successfully..');
                    $this->redirect($msg, 'configuration/rank_configuration', true);
                } else {
                    $msg = $this->lang->line('error_on_adding_rank_details');
                    $this->redirect($msg, 'configuration/rank_configuration', false);
                }
            }
        }

        $rank_details = $this->configuration_model->getAllRankDetails();
        $count = count($rank_details);
        $this->set('rank_details', $rank_details);
        $this->set('count', $count);

        $help_link = 'rank-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function inactivate_rank($rank_id = '') {
        $msg = '';
        $result = $this->configuration_model->inactivate_rank($rank_id);
        if ($result) {
            $msg = $this->lang->line('rank_inactivated_successfully');
            $this->redirect($msg, 'configuration/rank_configuration', TRUE);
        } else {
            $msg = $this->lang->line('error_on_inactivating_rank');
            $this->redirect($msg, 'configuration/rank_configuration', FALSE);
        }
    }

    function activate_rank($rank_id = '') {
        $msg = '';
        $result = $this->configuration_model->activate_rank($rank_id);
        if ($result) {
            $msg = $this->lang->line('rank_activated_successfully');
            $this->redirect($msg, 'configuration/rank_configuration', TRUE);
        } else {
            $msg = $this->lang->line('error_on_inactivating_rank');
            $this->redirect($msg, 'configuration/rank_configuration', FALSE);
        }
    }

///---------Form Validation -----------////////
    function validate_rank_configuration() {
        $this->form_validation->set_rules('rank_name', 'Rank Name', 'trim|required|xss_clean|strip_tags|max_length[32]|callback_alpha_dash_space');
        $this->form_validation->set_rules('ref_count', 'Referral Count', 'trim|required|xss_clean|greater_than[-1]');
        $this->form_validation->set_rules('rank_achievers_bonus', 'Rank achievers bonus', 'trim|required|xss_clean|greater_than[-1]');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('greater_than', 'The %s should be greater than or equal to 0');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function alpha_dash_space($str) {
        return (!preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
    }

    function paypal_config() {

        $title = $this->lang->line('paypal_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('paypal_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('paypal_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $paypal_details = array();
        $paypal_details = $this->configuration_model->getPaypalConfigDetails();
        $this->set('paypal_details', $paypal_details);

        if ($this->input->post('update_paypal') && $this->validate_paypal_config()) {
            $update_post_array = $this->input->post();
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);

            $api_username = $update_post_array['api_username'];
            $api_password = $update_post_array['api_password'];
            $api_signature = $update_post_array['api_signature'];
            $mode = $update_post_array['mode'];
            $currency = $update_post_array['currency'];
            $return_url = $update_post_array['return_url'];
            $cancel_url = $update_post_array['cancel_url'];

            $res = $this->configuration_model->updatePaypalConfig($api_username, $api_password, $api_signature, $mode, $currency, $return_url, $cancel_url);

            if ($res) {
                $msg = $this->lang->line('paypal_configuration_updated_successfully');
                $this->redirect($msg, 'configuration/paypal_config', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_paypal_status_please_try_again');
                $this->redirect($msg, 'configuration/paypal_config', false);
            }
        }

        $help_link = 'paypal-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_paypal_config() {

        $this->form_validation->set_rules('api_username', 'API Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_password', 'API Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_signature', 'API Signature', 'trim|required|xss_clean');
        $this->form_validation->set_rules('mode', 'Mode', 'trim|required|xss_clean');
        $this->form_validation->set_rules('currency', 'Currency', 'trim|required|xss_clean');
        $this->form_validation->set_rules('return_url', 'Return URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cancel_url', 'Cancel URL', 'trim|required|xss_clean');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function payment_gateway_configuration() {

        $title = lang('payment_gateway_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payment_gateway_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payment_gateway_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $card_status = array();
        $update_array_check = array();
        $card_status = $this->configuration_model->getCreditCardStatus();
        $this->set('card_status', $card_status);
        if ($this->input->post('update')) {
            $loop_count = $this->input->post('number');
            for ($i = 1; $i <= $loop_count; $i++) {
                if ($this->input->post("sort_order$i")) {
                    $update_array_check["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["srt_order$i"] = $this->input->post("sort_order$i");
                    $update_array["id$i"] = $this->input->post("id$i");
                }
            }
            if (!array_diff_key($update_array_check, array_unique($update_array_check))) {
                for ($i = 1; $i <= $loop_count; $i++) {
                    $this->configuration_model->updateSortOrder($update_array["id$i"], $update_array["srt_order$i"]);
                }
            }
        }
        $help_link = 'credit-card-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function payment_view() {

        $title = $this->lang->line('payment_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('payment_view');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('payment_view');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $payment_methods = $this->configuration_model->getPaymentMethods();
        $this->set('payment_methods', $payment_methods);

        $help_link = 'payment-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function change_module_status() {

        $login_id = $this->LOG_USER_ID;
        $module_name = $this->input->post('module_name');
        $new_status = $this->input->post('module_status');
        if ($new_status == 'no') {
            $payment_active_count = 1;
            if ($module_name == 'ewallet_status') {
                $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive(3);
                if ($payment_active_count) {
                    $this->configuration_model->setPaymentStatus(3, $new_status);
                }
            }
            if ($module_name == 'pin_status') {
                $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive(2);
                if ($payment_active_count) {
                    $this->configuration_model->setPaymentStatus(2, $new_status);
                }
            }
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setModuleStatus($module_name, $new_status);
        if ($res) {
            $login_id = $this->LOG_USER_ID;
            $data_array = array();
            $data_array['module_name'] = $module_name;
            $data_array['new_module_status'] = $new_module_status;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($login_id, 'module status changed', $login_id, $data);
            $msg = $this->lang->line('Module_Status_Updated_Successfully');
            $this->redirect($msg, 'configuration/set_module_status', true);
        } else {
            $msg = $this->lang->line('error_on_updation');
            $this->redirect($msg, 'configuration/set_module_status', true);
        }
    }

    function change_language_status() {
        $lang_id = $this->input->post('lang_id');
        $new_status = $this->input->post('status');
        $this->configuration_model->setLanguageStatus($lang_id, $new_status);
    }

    function sms_settings() {

        $title = $this->lang->line('sms_setting');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('sms_settings');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('sms_settings');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $result = $this->configuration_model->getSmsConfigDetails();

        if ($this->input->post('sms_config') && $this->validate_sms_settings()) {

            $sms_post_array = $this->input->post();
            $sms_post_array = $this->validation_model->stripTagsPostArray($sms_post_array);
            $sms_post_array = $this->validation_model->escapeStringPostArray($sms_post_array);

            $details['sender_id'] = $sms_post_array['sender_id'];
            $details['user_name'] = $sms_post_array['user_name'];
            $details['password'] = $sms_post_array['password'];

            $rec = $this->configuration_model->setSmsConfig($details);

            if ($rec) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'sms config updated', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('successfully_inserted');
                $this->redirect($msg, 'configuration/sms_settings', true);
            } else {

                $msg = $this->lang->line('insertion_failed');
                $this->redirect($msg, 'configuration/sms_settings', false);
            }
        }

        $help_link = 'sms_setting';
        $this->set('help_link', $help_link);
        $this->setView();
    }

///---------Form Validation -----------////////


    function validate_sms_settings() {

        $this->form_validation->set_rules('sender_id', lang('sender_id'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required|xss_clean');


        $this->form_validation->set_message('required', '%s' . " " . lang('is_required'));
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();

        return $res_val;
    }

    function language_settings() {

        $title = lang('set_language_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('set_language_status');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('set_language_status');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $help_link = 'multi_language';
        $this->set('help_link', $help_link);

        $language_array = $this->configuration_model->getLanguageStatus();
        $this->set('language_array', $language_array);

        $this->set('tran_yes', $this->lang->line('yes'));
        $this->set('tran_no', $this->lang->line('no'));

        $this->setView();
    }

    function epdq_config() {

        $title = $this->lang->line('epdq_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('epdq_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('epdq_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $epdq_details = array();
        $epdq_details = $this->configuration_model->getEpdqConfigDetails();

        $this->set('epdq_details', $epdq_details);

        if ($this->input->post('update_epdq') && $this->validate_epdq_config()) {

            $settings_post_array = $this->input->post();
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);
            $settings_post_array = $this->validation_model->escapeStringPostArray($settings_post_array);

            $api_pspid = $settings_post_array['api_pspid'];
            $api_password = $settings_post_array['api_password'];
            $language = $settings_post_array['language'];
            $currency = $settings_post_array['currency'];
            $accept_url = $settings_post_array['accept_url'];
            $decline_url = $settings_post_array['decline_url'];
            $exception_url = $settings_post_array['exception_url'];
            $cancel_url = $settings_post_array['cancel_url'];
            $api_url = $settings_post_array['api_url'];

            $res = $this->configuration_model->updateEpdqConfig($api_pspid, $api_password, $language, $currency, $accept_url, $decline_url, $exception_url, $cancel_url, $api_url);

            if ($res) {
                $msg = $this->lang->line('epdq_configuration_updated_successfully');
                $this->redirect($msg, 'configuration/epdq_config', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_epdq_status_please_try_again');
                $this->redirect($msg, 'configuration/epdq_config', false);
            }
        }

        $help_link = 'epdq-settings';
        $this->set('help_link', $help_link);

        $this->setView();
    }

///---------Form Validation -----------////////

    function validate_epdq_config() {

        $this->form_validation->set_rules('api_pspid', 'API PSPID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_password', 'API Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('language', 'API Language', 'trim|required|xss_clean');
        $this->form_validation->set_rules('currency', 'Currency', 'trim|required|xss_clean');
        $this->form_validation->set_rules('accept_url', 'Accept URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('decline_url', 'Decline URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('exception_url', 'Exception URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cancel_url', 'Cancel URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('api_url', 'API URL', 'trim|required|xss_clean');


        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function authorize_config() {

        $title = $this->lang->line('authorize_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('authorize_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('authorize_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $authorize_details = $this->configuration_model->getAuthorizeConfigDetails();
        $this->set('authorize_details', $authorize_details);

        if ($this->input->post('update_authorize') && $this->validate_authorize_config()) {
            $settings_post_array = $this->input->post();
            $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);
            $settings_post_array = $this->validation_model->escapeStringPostArray($settings_post_array);

            if ($this->input->post('merchant_log_id')) {
                $merchant_id = $settings_post_array['merchant_log_id'];
            } else {
                $msg = $this->lang->line('you_must_enter_merchant_id');
                $this->redirect($msg, 'configuration/authorize_config', false);
            }
            if ($this->input->post('transaction_key')) {

                $transaction_key = $settings_post_array['transaction_key'];
            } else {
                $msg = $this->lang->line('you_must_enter_transaction_password');
                $this->redirect($msg, 'configuration/authorize_config', false);
            }
            $res = $this->configuration_model->updateAuthorizeConfig($merchant_id, $transaction_key);

            if ($res) {
                $msg = $this->lang->line('paypal_configuration_updated_successfully');
                $this->redirect($msg, 'configuration/authorize_config', true);
            } else {
                $msg = $this->lang->line('Error_on_updating_paypal_status_please_try_again');
                $this->redirect($msg, 'configuration/authorize_config', false);
            }
        }

        $help_link = NULL;
        $this->set('help_link', $help_link);
        $this->setView();
    }

///---------Form Validation -----------////////


    function validate_authorize_config() {

        $this->form_validation->set_rules('transaction_key', 'Cancel URL', 'trim|required|xss_clean');
        $this->form_validation->set_rules('merchant_log_id', 'API URL', 'trim|required|xss_clean');


        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function setting_depth() {

        $title = $this->lang->line('setting_depth');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('setting_depth');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('setting_depth');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];

        $obj_arr = $this->configuration_model->getSettings();
        $depth_no = $obj_arr['depth_ceiling'];

        if ($mlm_plan == 'Binary') {

            if ($this->input->post('update') && $this->validate_setting_depth()) {

                $depth = $this->input->post('depth_value');
                $width = 0;

                $result2 = $this->configuration_model->setLevel($depth, $depth_no);
                $result = $this->configuration_model->updateDepth($depth, $width);
                if ($result) {
                    $msg = $this->lang->line('updated_successfully');
                    $this->redirect($msg, 'configuration/setting_depth', true);
                } else {
                    $msg = $this->lang->line('updation_failed');
                    $this->redirect($msg, 'configuration/setting_depth', false);
                }
            }
        }

        $obj_arr = $this->configuration_model->getSettings();

        $this->set('mlm_plan', $mlm_plan);
        $this->set('obj_arr', $obj_arr);

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);
        $this->setView();
    }

///---------Form Validation -----------////////


    function validate_setting_depth() {

        $this->form_validation->set_rules('depth_value', 'API URL', 'trim|required|xss_clean|numeric');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function delete_message($redirect, $id) {

        $res = $this->configuration_model->deleteMessage($id);
        if ($res) {
            $msg = $this->lang->line('message_deleted_successfully');
            $this->redirect($msg, 'configuration/$redirect', TRUE);
        } else {
            $msg = $this->lang->line('error_on_deletion');
            $this->redirect($msg, 'configuration/$redirect', TRUE);
        }
    }

    function change_credit_card_status() {

        $id = $this->input->post('id');
        $new_status = $this->input->post('module_status');

        if ($new_status == 'no') {
            $payment_active_count = $this->configuration_model->checkAtleastOneCreditCardActive($id);
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setCreditCardStatus($id, $new_status);
    }

    function change_payment_status() {

        $id = $this->input->post('id');
        $new_status = $this->input->post('module_status');

        if ($new_status == 'no') {
            $payment_active_count = $this->configuration_model->checkAtleastOnePaymentActive($id);
            if (!$payment_active_count) {
                $this->redirect('Atleast one payment method should be active. Please select one option', 'configuration/payment_view', false);
            }
        }

        $res = $this->configuration_model->setPaymentStatus($id, $new_status);
        if ($res) {
            $msg = lang('Payment_Status_Updated_Successfully');
            $this->redirect($msg, 'configuration/payment_view', TRUE);
        } else {
            $msg = lang('Error_on_updating_payment_status_please_try_again');
            $this->redirect($msg, 'configuration/payment_view', FALSE);
        }
    }

//Call from validate_cofiguration.js

    function getUsernamePrefix() {

        $prefix = $this->configuration_model->getUsernamePrefix();
        if ($prefix != NULL) {
            echo $prefix;
        }
        exit();
    }

    function get_product_value() {
        $product_point_value = $this->input->post('reg_mail_type');
        echo $product_point_value;
    }

    function email_management($lang_id ='') {
        $title = lang('email_configuration');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $this->HEADER_LANG['page_top_header'] = lang('email_configuration');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('email_configuration');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        
        
        if ($lang_id == NULL)
            $lang_id = $this->LANG_ID;

        $this->set('lang_id', $lang_id);
        $lang_arr = $this->configuration_model->getLanguages();
        $this->set('lang_arr', $lang_arr);
        
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('mail_content', 'Mail Content', 'required');

        $tab1 = 'active';
        $tab2 = $tab3 = '';

        $reg_mail = $this->configuration_model->getEmailManagementContent('registration',$lang_id);
        $reg_mail['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $reg_mail['content']);
        $this->set('reg_mail', $reg_mail);

        $payout_release = $this->configuration_model->getEmailManagementContent('payout_release');
        $payout_release['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $payout_release['content']);
        $this->set('payout_release', $payout_release);

        $forgot_password = $this->configuration_model->getEmailManagementContent('Forgot_pswd');
        $forgot_password['content'] = str_replace("{banner_img}", $this->PUBLIC_URL . 'images/banners/banner.jpg', $forgot_password['content']);
        $this->set('forgot_password', $forgot_password);

        if ($this->input->post('reg_update')) {
            $tab1 = " active";
            $tab2 = $tab3 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3));

            $val = $this->form_validation->run();
            if ($val) {
                $reg_mail_arr = $this->input->post();
                $reg_mail_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                $res = $this->configuration_model->updateEmailManagement($reg_mail_arr, 'registration',$lang_id);
                if ($res) {
                    $data = serialize($reg_mail_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'registration email updated', $this->LOG_USER_ID, $data);
                    $msg = lang('registration_mail_updated');
                    $this->redirect($msg, 'configuration/email_management', TRUE);
                } else {
                    $msg = lang('registration_mail_not_updated');
                    $this->redirect($msg, 'configuration/email_management', FALSE);
                }
            }
        }
        if ($this->input->post('forgot_pswd')) {
            $tab3 = " active";
            $tab1 = $tab2 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3));

            $val = $this->form_validation->run();
            if ($val) {
                $forgot_password_arr = $this->input->post();
                $forgot_password_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                $res = $this->configuration_model->updateEmailManagement($forgot_password_arr, 'Forgot_pswd');
                if ($res) {
                    $msg = lang('forgot_password_mail_updated');
                    $this->redirect($msg, 'configuration/email_management', TRUE);
                } else {
                    $msg = lang('forgot_password_not_updated');
                    $this->redirect($msg, 'configuration/email_management', FALSE);
                }
            }
        }
        if ($this->input->post('payout_release')) {
            $tab2 = " active";
            $tab1 = $tab3 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3));

            $val = $this->form_validation->run();
            if ($val) {
                $payout_release_arr = $this->input->post();
                $payout_release_arr = $this->validation_model->stripTagsPostArray($payout_release_arr);
                $payout_release_arr = $this->validation_model->escapeStringPostArray($payout_release_arr);
                $payout_release_arr['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                $res = $this->configuration_model->updateEmailManagement($payout_release_arr, 'payout_release');
                if ($res) {
                    $data = serialize($payout_release_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'payout release email updated', $this->LOG_USER_ID, $data);
                    $msg = lang('payout_release_mail_updated');
                    $this->redirect($msg, 'configuration/email_management', TRUE);
                } else {
                    $msg = lang('payout_release_mail_not_updated');
                    $this->redirect($msg, 'configuration/email_management', FALSE);
                }
            }
        }
        if ($this->session->userdata("inf_content_tab_active_arr")) {

            $tab1 = $this->session->userdata['inf_content_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_content_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_content_tab_active_arr']['tab3'];
            $this->session->unset_userdata("inf_content_tab_active_arr");
        }

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);

        $help_link = 'e-pin-configuration';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function auto_responder_settings($action = '', $id = '') {

        $title = lang('auto_responder_settings');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('auto_responder_settings');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('auto_responder_settings');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "AutoResponder";
        $this->set("help_link", $help_link);

        $mail_details = $this->configuration_model->getAutoResponderData();
        $count = count($mail_details);
        $mail_data = $this->configuration_model->getAuto();
        $this->set("mail_data", $mail_data);
        $this->set('mail_details', $mail_details);
        $this->set('count', $count);

        if ($this->input->post('update')) {
            $this->form_validation->set_rules('mail_content', 'Mail Content', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('mail_num', 'Mail Number', 'required');
            $this->form_validation->set_rules('date_to_send', 'Date To Send', 'required');

            $val = $this->form_validation->run();

            if ($val) {
                $settings_post_array = $this->input->post();
                $settings_post_array = $this->validation_model->stripTagsPostArray($settings_post_array);
                $settings_post_array = $this->validation_model->escapeStringPostArray($settings_post_array);
                $settings_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));

                $mail_setting['mail_content'] = $settings_post_array['mail_content'];
                $mail_setting['subject'] = $settings_post_array['subject'];
                $mail_setting['mail_number'] = $settings_post_array['mail_num'];
                $mail_setting['date_to_send'] = $settings_post_array['date_to_send'];

                $res = $this->configuration_model->insertIntoAutoResponder($mail_setting);
                if ($res) {
                    $data = serialize($mail_setting);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'auto responder settings updated', $this->LOG_USER_ID, $data);
                    $msg = lang('auto_responder_details_updated');
                    $this->redirect($msg, "configuration/auto_responder_settings", true);
                } else {
                    $msg = lang('unable_to_update_auto_responder_details');
                    $this->redirect($msg, "configuration/auto_responder_settings", false);
                }
            }
        }

        if ($action == 'edit') {
            $edit_id = $id;
            $mail_details = $this->configuration_model->getAutoResponderData($edit_id);
            $this->set('mail_details', $mail_details);
        }
        if ($action == 'delete') {
            $delete_id = $id;
            $mail_details = $this->configuration_model->DeleteAutoResponderData($delete_id);
            if ($mail_details) {
                $data_array['mail_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'auto responder deleted', $this->LOG_USER_ID, $data);
                $msg = lang('mail_deleted');
                $this->redirect($msg, "configuration/auto_responder_settings", TRUE);
            } else {
                $msg = lang('mail_not_deleted');
                $this->redirect($msg, "configuration/auto_responder_settings", FALSE);
            }
        }


        $this->setView();
    }

    function board_view_config() {

        $title = lang('board_view_config');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('board_view_config');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('board_view_config');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $board_config = $this->configuration_model->getBoardViewConfig();
        $this->set('board_config', $board_config);

        for ($i = 0; $i < count($board_config); $i++) {
            if ($this->input->post("update$i")) {
                $depth[$i] = $this->input->post("depth$i");
                $width[$i] = $this->input->post("width$i");
                $amount[$i] = $this->input->post("amount$i");

                if ($depth[$i] != "" && is_numeric($depth[$i]) && $width[$i] != "" && is_numeric($width[$i]) && $amount[$i] != "" && is_numeric($amount[$i])) {

                    $res = $this->configuration_model->updateBoardConfig($i + 1, $depth[$i], $width[$i], $amount[$i]);
                } else {
                    $msg = $this->lang->line('invalid');
                    $this->redirect($msg, 'configuration/board_view_config', true);
                }

                if ($res) {
                    $msg = $this->lang->line('board_configuration_updated_succesfully');
                    $this->redirect($msg, 'configuration/board_view_config', true);
                } else {
                    $msg = $this->lang->line('error_on_updating_board_configuration_please_try_again');
                    $this->redirect($msg, 'configuration/board_view_config', false);
                }
            }
        }

        $help_link = 'board_view_config';
        $this->set('help_link', $help_link);

        $this->setView();
    }

    function opencart() {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = "../../../store/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = "../../../store";
        }
        header("location:$store_url");
    }

    function plan_settings() {
        $title = lang('plan_setting');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('plan_setting');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('plan_setting');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();
        $obj_arr_board = array();
        $board_count = '0';
        if ($this->MLM_PLAN == "Board") {
            $obj_arr_board = $this->configuration_model->getBoardSettings();
            $board_count = count($obj_arr_board);
        }
        $this->set('board_count', $board_count);
        $this->set('obj_arr', $obj_arr);
        $this->set('obj_arr_board', $obj_arr_board);

        $this->setView();
    }

    function check_plan_variables($post_array) {
        $flag = false;
        if ($this->MLM_PLAN == "Matrix") {
            $depth_ceiling = $post_array['depth_ceiling'];
            $width_ceiling = $post_array['width_ceiling'];
            $obj_arr = $this->configuration_model->getSettings();
            if ($depth_ceiling != $obj_arr['depth_ceiling'] || $width_ceiling != $obj_arr['width_ceiling']) {
                $flag = true;
            }
        } else if ($this->MLM_PLAN == "Board") {
            $board_array = $this->configuration_model->getBoardSettings();
            $board_count = count($board_array);
            for ($i = 0; $i < $board_count; $i++) {
                $board_width = $post_array["board" . $i . "_width"];
                $board_depth = $post_array["board" . $i . "_depth"];
                $board_reentry_to_next_status = $post_array["board" . $i . "_reentry_to_next_status"];

                if ($board_width != $board_array[$i]['board_width'] || $board_depth != $board_array[$i]['board_depth']) {
                    $flag = true;
                } else if ($board_reentry_to_next_status != $board_array[$i]['re_entry_to_next_status']) {
                    $flag = true;
                }
            }
        }
        return $flag;
    }

    function confirm_plan_update() {
        if ($this->validate_configuration_view('tab1')) {
            $conf_post_array = $this->input->post();
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $conf_post_array = $this->validation_model->escapeStringPostArray($conf_post_array);
            $obj_arr = $this->configuration_model->getSettings();
            $board_count = '';
            if ($this->MLM_PLAN == "Binary" && $conf_post_array['pair_ceiling_type'] != 'none') {
                $pair_celing = $conf_post_array['pair_ceiling'];
                if ($pair_celing == 0) {
                    $msg = $this->lang->line('pair_ceiling_must_be_greater_than_zero');
                    $this->redirect($msg, "configuration/plan_settings", FALSE);
                }
            }

            if ($this->MLM_PLAN == "Board") {
                $board_count = $conf_post_array['board_count'];
                for ($i = 0; $i < $board_count; $i++) {
                    $board_depth = $conf_post_array["board" . $i . "_depth"];
                    $board_width = $conf_post_array["board" . $i . "_width"];
                    if ($board_width > 10) {
                        $msg = $this->lang->line('board_width_cannot_be_greater_than_three');
                        $this->redirect($msg, "configuration/plan_settings", FALSE);
                    }
                    if ($board_depth > 10) {
                        $msg = $this->lang->line('10');
                        $this->redirect($msg, "configuration/plan_settings", FALSE);
                    }
                }
            }
            $res = $this->check_plan_variables($conf_post_array);
            $result = $this->configuration_model->updatePlanSettings($conf_post_array, $this->MODULE_STATUS, $board_count);
            if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {

                $this->configuration_model->setLevel($conf_post_array['depth_ceiling'], $obj_arr['depth_ceiling']);
            }

            if ($result) {
                if ($this->MLM_PLAN == "Matrix" || $this->MLM_PLAN == "Board") {
                    if ($conf_post_array['cleanup_flag'] == "do_clean" && $res) {
                        $this->load->model('cleanup_model');
                        $this->cleanup_model->clean($this->MODULE_STATUS);
                    }
                }
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/plan_settings", true);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/plan_settings", FALSE);
            }
        } else {
            $msg = $this->lang->line('form_errors');
            $this->redirect($msg, "configuration/plan_settings", FALSE);
        }
    }

    function bonus_view($arg = NULL) {
        $title = lang('bonus');
        $this->set("title", $this->COMPANY_NAME . " | $title");

//      $help_link = 'network-configuration ';
//      $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('bonus');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('bonus');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        $this->load->model('currency_model');

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);

        $obj_arr = $this->configuration_model->getSettings();
        $package_arr = $this->configuration_model->getPackages();
        $project_default_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

        $obj_arr_board = array();
        $arr_level = array();
        $board_count = '';

        if ($this->MLM_PLAN == "Board") {
            $obj_arr_board = $this->configuration_model->getBoardSettings();
            $board_count = count($obj_arr_board);
        }
        if ($this->MLM_PLAN == "Unilevel" || $this->MLM_PLAN == "Matrix" || $this->MODULE_STATUS['sponsor_commission_status'] == 'yes') {
            $arr_level = $this->configuration_model->getLevelSettings();
        }

        $tab1 = 'active';
        $tab2 = $tab3 = $tab4 = $tab5 = '';

        if ($this->input->post('active_tab')) {
            $current_active_tab = $this->input->post('active_tab');
        }

        if ($this->input->post('setting') && ($this->validate_bonus_view($current_active_tab))) {
            $conf_post_array = $this->input->post();
            $conf_post_array = $this->validation_model->stripTagsPostArray($conf_post_array);
            $conf_post_array = $this->validation_model->escapeStringPostArray($conf_post_array);

//         
            if ($this->MODULE_STATUS['opencart_status_demo'] == 'yes') {
                $conf_post_array['reg_amount'] = '0';
            }
            $result = $this->configuration_model->updateConfigurationSettingsBonus($conf_post_array, $this->MODULE_STATUS, $board_count);

            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($login_id, 'configuration change', $login_id);
                $msg = $this->lang->line('configuration_updated_successfully');
                $this->redirect($msg, "configuration/bonus_view", true);
            } else {
                $msg = $this->lang->line('error_on_configuration_updation');
                $this->redirect($msg, "configuration/bonus_view", FALSE);
            }
        }

        if ($this->session->userdata("inf_content_tab_active_arr")) {

            $tab1 = $this->session->userdata['inf_content_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_content_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_content_tab_active_arr']['tab3'];
            $tab4 = $this->session->userdata['inf_content_tab_active_arr']['tab4'];
            $tab5 = $this->session->userdata['inf_content_tab_active_arr']['tab5'];
            $this->session->unset_userdata("inf_content_tab_active_arr");
        }

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);

        $pack_count = 0;
        $pack_count = count($package_arr);
        $this->set('obj_arr', $obj_arr);
        $this->set('package_arr', $package_arr);
        $this->set('pack_count', $pack_count);
        $this->set('obj_arr_board', $obj_arr_board);
        $this->set('arr_level', $arr_level);
        $this->set('project_default_currency', $project_default_currency);

        $this->setView();
    }

	public function manage_tokens() {

		$title = lang('manage_tokens');
		$this->set( "title", $this->COMPANY_NAME . " | $title" );
		$this->load->model('validation_model');
		$this->HEADER_LANG['page_top_header']       = $title;//lang( 'bonus' );
		$this->HEADER_LANG['page_top_small_header'] = lang( '' );
		$this->HEADER_LANG['page_header']           = $title;//lang( 'bonus' );
		$this->HEADER_LANG['page_small_header']     = lang( '' );

		$this->load_langauge_scripts();
		if( ! ( $user_id = $this->session->userdata('token_chosen_account') ) ) {
			$user_id = $this->LOG_USER_ID;
		}

		if ($this->input->post('user_name') && $this->validate_username() ) {
			$user_name = $this->input->post('user_name');
			$is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
			if (!$is_valid_username) {
				$msg = lang('Username_not_Exists');
				$this->redirect($msg, "configuration/manage_tokens", false);
			}
			$user_id = $this->validation_model->userNameToID($user_name);
			$this->session->set_userdata('token_chosen_account', $user_id );
		}
		if( $this->input->post('deduct_token_amount') && $this->validate_deduct_form() ) {
			$flag = $this->validation_model->addDeductedTokenAmount( intval( $this->input->post('user_id') ), intval( $this->input->post('amount') ) );

		}
		$user_data = [];
		$user_data['id'] = $user_id;
		$user_data['name']            = $this->validation_model->getUserName($user_id);
		$user_data['deducted_tokens'] = $this->validation_model->getUserDeductedTokens( $user_id );
		$user_data['total_tokens']    = $this->validation_model->getUserTotalTokens( $user_id );
		$user_data['result_tokens']   = $this->validation_model->getUserResultTokens( $user_id );

		$this->set('user', $user_data );
		$this->setView();

	}

    function dashboard_preferences() {
		$this->load->model('validation_model');
		$title = 'Dashboard Preferences';
		$this->set( "title", $this->COMPANY_NAME . " | $title" );

		$this->HEADER_LANG['page_top_header']       = $title;//lang( 'bonus' );
		$this->HEADER_LANG['page_top_small_header'] = lang( '' );
		$this->HEADER_LANG['page_header']           = $title;//lang( 'bonus' );
		$this->HEADER_LANG['page_small_header']     = lang( '' );

		$this->load_langauge_scripts();

		$description = [
			'tab1' => 'swisscoin_value',
			'tab2' => 'splitindicator_value',
			'tab3' => 'ac_skg_v'
		];
		$tabs = [
			'tab1' => '',
			'tab2' => '',
			'tab3' => ''
		];
		if( ( $active_tab = $this->input->post('active_tab') ) && $this->validate_dashboard_preferences( $active_tab ) ) {
			if( isset( $description[$active_tab] ) ) {
				$this->validation_model->updateColumnFromConfig( [ $description[$active_tab] => $this->input->post( $description[$active_tab ] ) ] );
				$tabs[$active_tab] = 'active';
				$this->session->set_userdata( "active_tabs_DP", $tabs );
			}
		}

		$swisscoin_value      = $this->validation_model->getColumnFromConfig('swisscoin_value');
		$splitindicator_value = $this->validation_model->getColumnFromConfig('splitindicator_value');
		$skg_value            = $this->validation_model->getColumnFromConfig('ac_skg_v');

		$this->set('_data', [
			'swiss_val' => $swisscoin_value,
			'split_val' => $splitindicator_value,
			'skg_value' => $skg_value
		]);
		$key = 'tab1';
		if( isset( $this->session->userdata['active_tabs_DP'] ) ) {
			$key = array_search('active', $this->session->userdata['active_tabs_DP'] );
		}
		$tabs[$key] = 'active';
		$this->set('_tabs', $tabs );

		$this->setView();
    }

	function validate_dashboard_preferences( $active_tab ) {
		switch( $active_tab ) {
			case 'tab1' :
				$this->form_validation->set_rules('swisscoin_value', 'Swisscoin Value', 'trim|required|numeric|xss_clean');
				break;
			case 'tab2':
				$this->form_validation->set_rules('splitindicator_value', 'Splitindicator Value', 'trim|required|numeric|xss_clean');
				break;
			case 'tab3':
				$this->form_validation->set_rules('ac_skg_v', 'Splitindicator Value', 'trim|required|numeric|xss_clean');
				break;

			default:
				return false;
		}
		return $this->form_validation->run();
	}
    function validate_bonus_view($current_active_tab) {

        if ($current_active_tab == 'tab1') {

            $tab1 = " active";
            $tab2 = $tab3 = $tab4 = $tab5 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5));
            $this->form_validation->set_rules('db_percentage', 'Direct Bonus ', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab2') {

            $tab2 = " active";
            $tab1 = $tab3 = $tab4 = $tab5 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5));



            $this->form_validation->set_rules('fsb_percentage', 'Fast Start Bonus Percentage', 'trim|required|numeric|xss_clean');

            $this->form_validation->set_rules('fsb_required_firstliners', 'Fast Start Bonus First Line Number', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('fsb_firstliners_pack', 'Fast Start Bonus First Line Pack', 'trim|required|xss_clean');
            $this->form_validation->set_rules('fsb_accumulated_turn_over_1', 'Fast Start Bonus Accumulated Trun Over', 'trim|required|xss_clean');
            $this->form_validation->set_rules('fsb_accumulated_turn_over_2', 'Fast Start Bonus Accumulated Trun Over', 'trim|required|xss_clean');
        } else if ($current_active_tab == 'tab3') {
            $tab3 = " active";
            $tab1 = $tab2 = $tab4 = $tab5 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5));


            $this->form_validation->set_rules('mb_minimum_pack', 'Matching Bonus Minimum Pack', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mb_required_firstliners', 'Matching Bonus required First Line', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('mb_first_line_minimum_pack', 'Matching Bonus First Line Minimum Pack', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab4') {

            $tab4 = " active";
            $tab2 = $tab3 = $tab1 = $tab5 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5));
            $this->form_validation->set_rules('dp_percentage', 'Diamod Pool', 'trim|required|numeric|xss_clean');
        } else if ($current_active_tab == 'tab5') {

            $tab5 = "active";
            $tab1 = $tab3 = $tab4 = $tab2 = "";
            $this->session->set_userdata("inf_content_tab_active_arr", array("tab1" => $tab1, "tab2" => $tab2, "tab3" => $tab3, "tab4" => $tab4, "tab5" => $tab5));
            $this->form_validation->set_rules('tb_required_firstliners', 'Team Bonus Firstliners', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_first_line_minimum_pack', 'Team Bonus Percentage', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tb_1000', 'Team Bonus 1000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_5000', 'Team Bonus 1000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_10000', 'Team Bonus 10000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_25000', 'Team Bonus 25000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_50000', 'Team Bonus 50000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_100000', 'Team Bonus 100000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_250000', 'Team Bonus 250000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_500000', 'Team Bonus 500000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_1000000', 'Team Bonus 1000000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_5000000', 'Team Bonus 5000000 BV', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('tb_10000000', 'Team Bonus 10000000 BV', 'trim|required|numeric|xss_clean');
        }
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    public function video($id = 0, $action = null) {
        /* some crappy required stuff */
        $title = lang($id ? 'edit video' : 'add video');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);
        /* look like this all defaults */
        
        $this->load->model('video_model');
        
        if ($id) {
            $video = $this->video_model->getVideo($id, true);
        }

        $this->form_validation->set_rules('video[title]', 'Video title', 'trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('video[url]', 'Video link', 'trim|required|max_length[50]|callback_youtubevideo|xss_clean');
        switch ($action) {
            case 'delete' : {
                $this->video_model->removeVideo($id);
                $this->redirect($this->lang->line('Video delete successfully'), 'configuration/video_list', false);
            } break;
            
            case 'activate' : {
                $this->video_model->activateVideo($id);
                $this->redirect($this->lang->line('Video added to dashboard'), 'configuration/video_list', false);
            } break;
        
            case 'deactivate' : {
                $this->video_model->deactivateVideo($id);
                $this->redirect($this->lang->line('Video removed from dashboard'), 'configuration/video_list', false);
            } break;
        
            default : {
                if ($this->form_validation->run()) {
                    $vars = $this->input->post('video');
                    if ($id) {
                        $r = $this->video_model->editVideo($id, $vars['title'], $vars['url'], (empty($vars['on_dashboard']) ? 0 : 1));
                    } else {
                        $r = $this->video_model->addVideo($vars['title'], $vars['url'], (empty($vars['on_dashboard']) ? 0 : 1));
                    }
                    $this->redirect($this->lang->line($r ? 'Video inserted successfully' : ($id ? 'Video update error' : 'Video insert error')), 'configuration/video_list', !$r);
                }
            } break;
        }
        
        $this->set('update_button', !empty($video) ? $this->lang->line('update') : $this->lang->line('insert'));
        $this->set('video_info', !empty($video) ? $video : $this->input->post('video'));
        $this->setView();
    }
    
    public function youtubevideo($url) {
        if ($this->video_model->_parseVideoUrl($url)) {
            return true;
        } 
        $this->form_validation->set_message('youtubevideo', 'Invalid Youtube video link, check it please');
        return false;
    }

    public function video_list() {
        /* some crappy required stuff */
        $title = $this->lang->line('videos list');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);
        /* look like this all defaults */
        
        $this->load->model('video_model');
        
        $this->set('videos', $this->video_model->getVideos());
        $this->setView();
    }
    
    public function translation_list($lang = null) {
        if ($lang == 'csvempty') {
            return $this->_csvempty($this->input->get('lang'));
        } elseif (is_null($lang)) {
            $this->redirect(null, 'configuration/translation_list/en');
        }
        /* some crappy required stuff */
        $title = $this->lang->line('translation list');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);
        /* look like this all defaults */
        
        $this->set('langName', $lang ? ($lang . '/') : '');
        
        if (!$lang) {
            $lang = $this->LANG_NAME == 'english' ? $this->LANG_ID : 'en';
        } else {
            $lang = $this->translation_model->getLangId($lang);
        }

        $this->set('langId', $lang);
        $this->set('langDefault', $this->LANG_ID);
        $this->set('languages', $this->translation_model->getLanguages());
        $this->set('translation', $this->translation_model->getAdminTranslation($lang));
        $this->setView();
    }
    
    public function translation($id)
    {
        /* some crappy required stuff */
        $title = $this->lang->line('videos list');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'network-configuration ';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        $mlm_plan = $this->MODULE_STATUS['mlm_plan'];
        $this->set('MLM_PLAN', $mlm_plan);
        /* look like this all defaults */
        
        $this->setView();
    }
    
    protected function _csvempty($lang)
    {
        $data = $this->translation_model->emptyTranslation($lang, true);
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=empty.csv");
        // Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        //manually save csv file
//        ob_start();
//        echo 'Tag,Key,Language,English,Translation' . PHP_EOL;
//        foreach ($data as $row) {
//            echo $row->key . ',"' . $row->english . '",' . (!is_null($row->text) ? '"' . $row->text . '"' : '') . PHP_EOL;
//        }
//        echo ob_get_clean();
        
        //auto file generate
        $output = fopen("php://output", "w");
        fputcsv($output, ['Tag', 'Key', 'Language', 'English', 'Translation'], ',', '"');
        foreach ($data as $row) {
            fputcsv($output, $row, ',', '"'); // here you can change delimiter/enclosure
        }
        fclose($output);
        
    }
    
    public function importlanguage()
    {
        $file = $_FILES['translationfile'];
        if ($file['error'] && $file['error'] == UPLOAD_ERR_NO_FILE) {
            $this->redirect($this->lang->line('upload_no_file_selected'), 'configuration/translation_list/en');
        }
        if ($file['error'] == UPLOAD_ERR_INI_SIZE || $file['error'] == UPLOAD_ERR_FORM_SIZE) {
            $this->redirect($this->lang->line('upload_file_exceeds_form_limit'), 'configuration/translation_list/en');
        }
        if ($file['error'] == UPLOAD_ERR_INI_SIZE || $file['error'] == UPLOAD_ERR_FORM_SIZE) {
            $this->redirect($this->lang->line('upload_file_exceeds_form_limit'), 'configuration/translation_list/en');
        }
        if ($file['error'] == UPLOAD_ERR_PARTIAL) {
            $this->redirect($this->lang->line('upload_file_partial'), 'configuration/translation_list/en');
        }
        if ($file['error'] == UPLOAD_ERR_NO_TMP_DIR) {
            $this->redirect($this->lang->line('upload_no_temp_directory'), 'configuration/translation_list/en');
        }
        if ($file['type'] != 'text/csv') {
            $this->redirect($this->lang->line('only csv files supported'), 'configuration/translation_list/en');
        }
        if (!$file['size']) {
            $this->redirect($this->lang->line('empty file uploaded'), 'configuration/translation_list/en');
        }
        
        $delimeters = [',', "\t", ';'];

        $escape = '"';
        
        ini_set('auto_detect_line_endings', true);
        $fhandle = fopen($file['tmp_name'], 'r');
        $header = strtolower(fgets($fhandle, 100));
        $i = 0;
        $fields = str_getcsv($header, $delimeters[$i], $escape);
        while (count($fields) < 3 || $i >= count($delimeters)) {
            $fields = str_getcsv($header, $delimeters[++$i], $escape);
        }
        if (count($fields) < 3) {
            $this->redirect($this->lang->line('invalid csv file, please check format'), 'configuration/translation_list/en');
        }
        $delimeter = $delimeters[$i];
        $update = true;
        while ($data = fgetcsv($fhandle, 1000, $delimeter, $escape)) {
            $update = $update && $this->translation_model->translationUpdate(array_combine($fields, $data));
        }
        fclose($fhandle);
        ini_set('auto_detect_line_endings', false);
        $this->redirect($this->lang->line($update ? 'csv import ok' : 'csv import partly'), 'configuration/translation_list/en', true);
    }
    
    public function readoldtranslation()
    {
        $this->lang->ImportOld();
        $this->redirect($this->lang->line('old files import ok'), 'configuration/translation_list/en', true);
    }
    
	function validate_username() {
		$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
		$validate_form = $this->form_validation->run();
		return $validate_form;
	}
	private function validate_deduct_form() {
		$this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
		$this->form_validation->set_rules('user_id', 'User id', 'trim|numeric|required');
		return $this->form_validation->run();
	}
}

?>
