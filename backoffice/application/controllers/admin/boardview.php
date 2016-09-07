<?php

require_once 'Inf_Controller.php';

class BoardView extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function view_board_details($board_no = '1', $page = '', $limit = '') {
        $title = lang('board_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $langs = array();
        if ($this->MODULE_STATUS['table_status'] == 'yes') {
            $langs['view'] = lang('table_view');
            $langs['name'] = lang('table_name');
            $langs['show_all'] = lang('show_all_tables');
        } else {
            $langs['view'] = lang('board_view');
            $langs['name'] = lang('board_name');
            $langs['show_all'] = lang('show_all_boards');
        }
        $this->HEADER_LANG['page_top_header'] = $langs['view'];
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = $langs['view'];
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();

        if ($this->MODULE_STATUS['table_status'] == 'yes') {
            $langs['board_id'] = lang('table_id');
            $langs['board_username'] = lang('table_username');
            $langs['board_split'] = lang('table_split');
            $langs['view_board'] = lang('view_table');
        } else {
            $langs['board_id'] = lang('club_id');
            $langs['board_username'] = lang('club_username');
            $langs['board_split'] = lang('club_split');
            $langs['view_board'] = lang('view_club');
        }

        if ($board_no) {
            $this->load->model('configuration_model');
            $board_no = (int) $board_no;
            $board_config = $this->configuration_model->getBoardSettings($board_no);
            if (!$board_no || !count($board_config)) {
                $this->redirect("Invalid Board!", "boardview/view_board_details", FALSE);
            }
        }

        $board_details = $this->boardview_model->getSystemBoardDetails();

        $base_url = base_url() . 'admin/boardview/view_board_details/' . $board_no;
        $config['base_url'] = $base_url;
        $config['per_page'] = $limit = 10;
        $config['uri_segment'] = 5;
        $config['num_links'] = 5;
        $total_rows = $this->boardview_model->getAllBoardCount($board_no);
        $user_board = $this->boardview_model->getAllBoardDetails($board_no, $page, $limit);
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $result_per_page = $this->pagination->create_links();

        $this->set("user_board", $user_board);
        $this->set("result_per_page", $result_per_page);

        $this->set("langs", $langs);
        $this->set("board_details", $board_details);
        $this->set("board_no", $board_no);
        $this->set("page", $page);
        $this->set("limit", $limit);

        $help_link = "board_view";
        $this->set("help_link", $help_link);

        $this->setView();
    }

}
