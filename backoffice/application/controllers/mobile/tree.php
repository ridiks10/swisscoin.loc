<?php

require_once 'Inf_Controller.php';

class Tree extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("android/new/android_model");
    }

    function index() {
        $this->redirect("", "tree_view");
    }

    public function genology_tree() {
        $title = lang('genealogy_tree');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "genealogy_tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('genealogy_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $user_name = $this->validation_model->getAdminUsername();
        }

        if ($this->input->post('go_submit')) {
            $user_name = strip_tags($this->input->post('go_id'));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
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

        if ($this->validation_model->isUserAvailable($user_id)) {

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

    public function sponsor_tree() {

        $title = lang('sponsor_tree');
        $this->set('title', $this->COMPANY_NAME . " | $title");

        $help_link = "sponsor-tree";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sponsor_tree');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;

        if ($user_type == 'employee') {
            $user_id = $this->validation_model->getAdminId();
            $user_name = $this->validation_model->getAdminUsername();
        }

        if ($this->input->post('profile_update')) {
            $user_name = strip_tags($this->input->post('user_name'));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/sponsor_tree', FALSE);
            }
        } else if ($this->input->post('go_submit')) {
            $user_name = strip_tags($this->input->post('go_id'));
            $user_id = $this->validation_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'tree/sponsor_tree', FALSE);
            }
        }
        $this->set('user_name', $user_name);
        $this->set('user_id', $user_id);

        $this->setView();
    }

    function tree_view_sponsor() {
        $post_array = $this->input->get();
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

}

?>
