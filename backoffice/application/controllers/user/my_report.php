<?php

require_once 'Inf_Controller.php';

class My_report extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function upline() {
        $title = lang('upine');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('upine');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upine');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $upline = array();
        $user_id = $this->LOG_USER_ID;
        $upline = $this->validation_model->getSponsorData($user_id);
        $this->set("upline", $upline);
       
        $this->setView();
    }
    
    function unilevel_history() {
        $title = lang('firstline');
        $this->set("title", $this->COMPANY_NAME . " | $title");

       
        $this->HEADER_LANG['page_top_header'] = lang('firstline');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('firstline');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $firstline = array();
        $user_id = $this->LOG_USER_ID;
        if ($user_id != 0) {
            $firstline = $this->validation_model->getFirstLine($user_id, 0, 0);
        }
        $this->set("firstline", $firstline);
        $this->setView();
    }

    function binary_history($param = "") {

        $title = lang('binary_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "binary_history";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('binary_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('binary_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $level_value = 'all';
        if ($this->input->post('user_details')) {
            $level_value = $this->input->post('level');
        }

        $binary = array();
        $binary_level = '';

        if ($user_id != 0) {
            $binary = $this->my_report_model->getDownlineDetailsBinary($user_id);
            $bin = $binary;
            $level_arr = array();
            foreach ($binary as $level) {
                array_push($level_arr, $level['level']);
            }
            $level_arr = array_unique($level_arr, SORT_STRING);

            $this->set("level_arr", $level_arr);
            $base_url = base_url() . "user/my_report/binary_history";

            $binary_level = 'all';
            $level = $level_value;
            $this->set('level', $level);
            $base_url = base_url() . "user/my_report/binary_history/?level=$level";
            if ($level != 'all') {
                $index = 0;
                foreach ($binary as $user) {
                    if ($user['level'] != $level) {
                        unset($binary[$index]);
                    }
                    $index++;
                }
            }

            $this->session->set_userdata("inf_binary_histroy_level", $level);
            $binary_level = $this->session->userdata('inf_binary_histroy_level');

            $base_url = base_url() . "admin/my_report/binary_history";
            $config['base_url'] = $base_url;
            $config['per_page'] = 10;

            if ($this->uri->segment(4) != "")
                $page = $this->uri->segment(4) / $config['per_page'];
            else
                $page = 0;

            $total_rows = count($binary);
            $config['total_rows'] = $total_rows;
            $this->pagination->initialize($config);
            $start = $page * $config['per_page'];
            $end = $page * $config['per_page'] + $config['per_page'];
            $binary = array_slice($binary, $start, $config['per_page']);
            $this->set('details_count', $total_rows);
            $result_per_page = $this->pagination->create_links();
            $this->set('result_per_page', $result_per_page);
            $this->set('start', $start);
        }
        $this->set('binary_level', $binary_level);
        $this->set("binary", $binary);
        
        $this->setView();
    }

}

?>
