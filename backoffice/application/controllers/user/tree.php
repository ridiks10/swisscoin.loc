<?php

require_once 'Inf_Controller.php';

class Tree extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->redirect("", "genology_tree");
    }

    public function genology_tree() {

        $title = lang('graphic');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "genealogy_tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
		$this->load->model('validation_model');
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        if ($this->input->post('go_submit')) {
            $user_name = strip_tags($this->input->post('go_id'));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/genology_tree', FALSE);
            }
            $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'father');
            $logged_user_left_right = $this->tree_model->getUserLeftAndRight($this->LOG_USER_ID, 'father');
            if (($user_left_right['left_father'] < $logged_user_left_right['left_father']) || ($user_left_right['right_father'] > $logged_user_left_right['right_father'])) {
                $msg = lang('you_are_not_permitted_to_view_upline_users');
                $this->redirect($msg, 'tree/genology_tree', FALSE);
            }
			if( ! in_array( $user_id, $this->validation_model->getFirstAndSecondLineIds($this->LOG_USER_ID) ) ) {
				$msg = lang('no_users_in_first_and_secondline');
				$this->redirect($msg, 'tree/genology_tree', FALSE);
			}
        }

        $this->set('user_name', $user_name);
        $this->set('user_id', $user_id);

        $this->setView();
    }

    function tree_view() {
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $user_id = $post_array['user_id'];

        if ( $this->validation_model->isUserAvailable($user_id ) ) {
            $this->tree_model->getAllTreeUsers($user_id);
            $display_tree = $this->tree_model->display_tree;
            $tooltip_array = $this->tree_model->tree_tooltip_array;

            $this->set('tooltip_array', $tooltip_array);
            $this->set('display_tree', $display_tree);
            $this->set('user_id', $user_id);
            $this->setView();
        } else {
            echo 'Invalid User Name...';
            die();
        }
    }

    public function sponsor_tree($user_id = "") {

        $title = lang('tree_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "sponsor-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        if ($this->input->post('go_submit')) {
            $user_name = strip_tags($this->input->post('go_id'));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/sponsor_tree', FALSE);
            }
            $user_left_right = $this->tree_model->getUserLeftAndRight($user_id, 'sponsor');
            $logged_user_left_right = $this->tree_model->getUserLeftAndRight($this->LOG_USER_ID, 'sponsor');
            if (($user_left_right['left_sponsor'] < $logged_user_left_right['left_sponsor']) || ($user_left_right['right_sponsor'] > $logged_user_left_right['right_sponsor'])) {
                $msg = lang('you_are_not_permitted_to_view_upline_users');
                $this->redirect($msg, 'tree/sponsor_tree', FALSE);
            }
        }
        $this->set('user_name', $user_name);
        $this->set('user_id', $user_id);

        $this->setView();
    }

    function tree_view_sponsor() {

        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);

        $user_id = $post_array['user_id'];

        if ($this->validation_model->isUserAvailable($user_id)) {
            $this->tree_model->getAllTreeUsers($user_id, "sponsor_tree");
            $display_tree = $this->tree_model->display_tree;
            $tooltip_array = $this->tree_model->tree_tooltip_array;

            $this->set('tooltip_array', $tooltip_array);
            $this->set('display_tree', $display_tree);
            $this->set('user_id', $user_id);
            $this->setView();
        } else {
            echo 'Invalid User Name...';
            die();
        }
    }

    public function select_tree($user_id = "") {

        $title = $this->lang->line('tree_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "tabular-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('tabular_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('tabular_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        $this->set('user_name', $user_name);
        $this->set('user_id', $user_id);

        $this->setView();
    }

    public function get_children($id = "") {
        echo $this->tree_model->getChildren($id);
    }

    function getEncrypt($string) {
        $id_encode = $this->encrypt->encode($string);
        $id_encode = str_replace("/", "_", $id_encode);
        return $encrypt_id = urlencode($id_encode);
    }

    public function board_view($board_id = '', $encrypted_id = "") {
        $title = $this->lang->line('board_view');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $this->load->model('configuration_model');
        $board_config = $this->configuration_model->getBoardSettings($board_id);

        $this->HEADER_LANG['page_top_header'] = $board_config[0]['board_name'];
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $board_config[0]['board_name'];
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = "Board View";
        $this->set("help_link", $help_link);

        $this->load_langauge_scripts();

        $user_id = "";
        $id = urldecode($encrypted_id);
        $id_decode = str_replace("_", "/", $id);
        $id_decrypt = $this->encrypt->decode($id_decode);

        if ($this->validation_model->isUserAvailableinBoard($id_decrypt, $board_id)) {
            $user_id = $id_decrypt;
            if (isset($this->MODULE_STATUS['table_status']) && $this->MODULE_STATUS['table_status'] == "yes") {
                $this->load->model('configuration_model');
                $board_config = $this->configuration_model->getBoardSettings($board_id);
                $user_board_details = $this->tree_model->getUserBoard($user_id, $board_id);
                $tooltip_array = $this->tree_model->board_tooltip_array;

                $this->set("board_config", $board_config[0]);
                $this->set("user_board_details", $user_board_details);
                $this->set("tooltip_array", $tooltip_array);
            } else {
                $this->load->model('boardview_model');
                $this->boardview_model->getAllBoardUsers($user_id, $board_id);
                $display_tree = $this->boardview_model->display_tree;
                $tooltip_array = $this->boardview_model->tree_tooltip_array;

                $this->set('tooltip_array', $tooltip_array);
                $this->set('display_tree', $display_tree);
                $this->set('user_id', $user_id);
            }
        } else {
            $this->redirect("Invalid User", "boardview/board_view_management/$board_id", FALSE);
        }

        $this->set('user_id', $user_id);
        $this->set("board_id", $board_id);
        $this->set("board_config", $board_config[0]);
        $this->set("board_name", $board_config[0]['board_name']);

        $this->setView();
    }

}

?>
