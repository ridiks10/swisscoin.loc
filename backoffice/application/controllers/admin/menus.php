<?php

require_once 'Inf_Controller.php';

class Menus extends Inf_Controller {

    function __construct() {
	parent::__construct();
    }

    function add_menu_item() {
	$this->ARR_SCRIPT[0]["name"] = "validate_menu_item.js";
	$this->ARR_SCRIPT[0]["type"] = "js";
	$menu_arr = array();
	if ($this->input->post('submit')) {

	    //======code edited by Aparna=========//
	    $this->load->library('upload');
	    $user_file_name = "";
	    $document3 = $_FILES['userfile']['name'];
	    $userfile = 'userfile';
	    $post = $this->input->post();
	    if ($_FILES['userfile']['error'] != 4) {

		$config['upload_path'] = './public_html/images/menuitems/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this->upload->initialize($config);
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($userfile)) {

		    $error = array('error' => $this->upload->display_errors());
		    $msg = $this->lang->line('image_not_selected');
		    $this->redirect($msg, "menus/add_menu_item", FALSE);
		    $post['logo_name'] = "";
		} else {
		    $data = array('upload_data' => $this->upload->data());
		    $post['logo_name'] = $data['upload_data']['file_name'];
		}
	    }
	    if (empty($_FILES["userfile"]["name"])) {
		$post["logo_name"] = "";
	    }
	    //=========code ends============//
	    $res = $this->menus_model->addMainMenuItem($post);
	    if ($res) {
		$msg = $this->lang->line('add_menu_item_added');

		$this->redirect($msg, "menus/add_menu_item", TRUE);
	    } else {
		$msg = $this->lang->line('add_menu_item_cannot_be_added');
		$this->redirect($msg, "menus/add_menu_item", FALSE);
	    }
	}
	if ($this->input->post('update')) {
	    $post = $this->input->post();
	    $total_count = $menu_arr['total_count'] = $this->input->post('total_count');
	    for ($i = 0; $i < $total_count; $i++) {
		$key = "userfile$i";
		$key1 = "active$i";
		if (array_key_exists($key, $_FILES) && array_key_exists($key1, $post)) {
		    $flag = 0;

		    if ($_FILES["userfile$i"]["error"] != 4) {
			$config['upload_path'] = './public_html/images/menuitems/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '2000000';
			$config['max_width'] = '1024';
			$config['max_height'] = '768';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload("userfile$i")) {

			    $error = array('error' => $this->upload->display_errors());
			    $msg = $this->lang->line('image_not_selected');
			    $this->redirect($msg, "menus/add_menu_item", FALSE);
			} else {
			    $data = array('upload_data' => $this->upload->data());
			    $post["logo_name$i"] = $data['upload_data']['file_name'];
			    $flag = 1;
			}
		    }
		}
	    }

	    $res = $this->menus_model->updateMainMenuItem($menu_arr, $post, $flag);

	    if ($res) {
		$msg = $this->lang->line('add_menu_update');
		$this->redirect($msg, "menus/add_menu_item", TRUE);
	    } else {
		$msg = $this->lang->line('add_menu_cannot_update');
		$this->redirect($msg, "menus/add_menu_item", FALSE);
	    }
	}
	$this->load_langauge_scripts();
	$menu_item = $this->menus_model->getMainMenuItems();
	$len = count($menu_item);
	$title = $this->lang->line('Main_Menu');
	$this->set("title", $this->COMPANY_NAME . " | $title");
	$this->set("menu_item", $menu_item);
	$this->set("len", $len);

	//for language translation///
	$this->set("tran_menu_name", $this->lang->line('menu_name'));
	$this->set("tran_link", $this->lang->line('link'));
	$this->set("tran_admin", $this->lang->line('admin'));
	$this->set("tran_user", $this->lang->line('user'));
	$this->set("tran_icon", $this->lang->line('icon'));
	$this->set("tran_add_item", $this->lang->line('add_item'));
	$this->set("tran_add_one_item", $this->lang->line('add_one_item'));
	$this->set("tran_menu_link", $this->lang->line('menu_link'));
	$this->set("tran_menu_text", $this->lang->line('menu_text'));
	$this->set("tran_target", $this->lang->line('target'));
	$this->set("tran_permision_admin", $this->lang->line('permision_admin'));
	$this->set("tran_permision_emp", $this->lang->line('permision_emp'));
	$this->set("tran_permision_user", $this->lang->line('permision_user'));
	$this->set("tran_submit", $this->lang->line('submit'));
	$this->set("tran_update", $this->lang->line('update'));
	$this->set("tran_select_one", $this->lang->line('select_one'));
	$this->set("tran_add_menu_item", $this->lang->line('add_menu_item'));
	$this->set("tran_you_must_select_a_link", $this->lang->line('you_must_select_a_link'));
	$this->set("tran_you_must_enter_the_text", $this->lang->line('you_must_enter_the_text'));
	$this->set("tran_you_must_select_one_option", $this->lang->line('you_must_select_one_option'));
	$this->set("page_top_header", $this->lang->line('add_menu_item'));
	$this->set("page_top_small_header", "");
	$this->set("page_header", $this->lang->line('add_menu_item'));
	$this->set("page_small_header", "");

	$this->setView();
    }

    function add_sub_menu_item() {
	$this->ARR_SCRIPT[0]["name"] = "validate_menu_item.js";
	$this->ARR_SCRIPT[0]["type"] = "js";
	$menu_arr = array();
	if ($this->input->post('submit')) {
	    //======code edited by Aparna=========//
	    $this->load->library('upload');
	    $user_file_name = "";
	    $document3 = $_FILES['userfile']['name'];
	    $userfile = 'userfile';
	    $post = $this->input->post();
	    if ($_FILES['userfile']['error'] != 4) {

		$config['upload_path'] = './public_html/images/submenuitems/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = '2000000';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';

		$this->upload->initialize($config);
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($userfile)) {

		    $error = array('error' => $this->upload->display_errors());
		    $msg = $this->lang->line('image_not_selected');
		    $this->redirect($msg, "menus/add_menu_item", FALSE);
		    $post['logo_name'] = "";
		} else {
		    $data = array('upload_data' => $this->upload->data());
		    $post['logo_name'] = $data['upload_data']['file_name'];
		}
	    }
	    if (empty($_FILES["userfile"]["name"])) {
		$post["logo_name"] = "";
	    }
	    //=========code ends============//
	    $res = $this->menus_model->addSubMenuItem($post);
	    if ($res) {
		$msg = $this->lang->line('sub_menu_item_added');
		$this->redirect($msg, "menus/add_sub_menu_item", TRUE);
	    } else {
		$msg = $this->lang->line('sub_menu_item_cannot_added');
		$this->redirect($msg, "menus/add_sub_menu_item", FALSE);
	    }
	}


	if ($this->input->post('update')) {

	    $post = $this->input->post();
	    $total_count = $menu_arr['total_count'] = $this->input->post('total_count');
	    for ($i = 0; $i < $total_count; $i++) {
		$key = "userfile$i";
		$key1 = "active$i";
		if (array_key_exists($key1, $post)) {
		    if (array_key_exists($key, $_FILES)) {
			$this->load->library('upload');
			if ($_FILES["userfile$i"]["error"] != 4) {

			    $config['upload_path'] = './public_html/images/';
			    $config['allowed_types'] = 'gif|jpg|png|jpeg';
			    $config['max_size'] = '2000000';
			    $config['max_width'] = '1024';
			    $config['max_height'] = '768';

			    $this->upload->initialize($config);
			    $this->load->library('upload', $config);

			    if (!$this->upload->do_upload("userfile$i")) {

				$error = array('error' => $this->upload->display_errors());
				$msg = $this->lang->line('image_not_selected');
				$this->redirect($msg, "menus/add_menu_item", FALSE);
				$post["logo_name$i"] = $this->input->post("current_image$i");
			    } else {
				$data = array('upload_data' => $this->upload->data());
				$post["logo_name$i"] = $data['upload_data']['file_name'];
			    }
			}
		    }

		    if (empty($_FILES["userfile$i"]["name"])) {
			$post["logo_name$i"] = $this->input->post("current_image$i");
		    }
		}
	    }


	    $res = $this->menus_model->updateSubMenuItem($menu_arr, $post);
	    if ($res) {
		$msg = $this->lang->line('add_menu_update');
		$this->redirect($msg, "menus/add_sub_menu_item", TRUE);
	    } else {
		$msg = $this->lang->line('add_menu_cannot_update');
		$this->redirect($msg, "menus/add_sub_menu_item", FALSE);
	    }
	}
	$menu_item = $this->menus_model->getSubMenuItems();
	$main_menu_item = $this->menus_model->getMainMenuItems();
	$new_menu_item = $this->menus_model->getAvailableMainMenuItems('Dashboard', 'Logout');
	$title = $this->lang->line('Sub_Menu');
	$this->set("title", $this->COMPANY_NAME . " | $title");
	$this->set("menu_item", $menu_item);
	$this->set("new_menu_item", $new_menu_item);
	$this->set("main_menu_item", $main_menu_item);
	$this->load_langauge_scripts();

	//for language translation///
	$this->set("tran_menu_name", $this->lang->line('menu_name'));
	$this->set("tran_link", $this->lang->line('link'));
	$this->set("tran_admin", $this->lang->line('admin'));
	$this->set("tran_user", $this->lang->line('user'));
	$this->set("tran_icon", $this->lang->line('icon'));
	$this->set("tran_add_item", $this->lang->line('add_item'));
	$this->set("tran_add_one_item", $this->lang->line('add_one_item'));
	$this->set("tran_menu_link", $this->lang->line('menu_link'));
	$this->set("tran_menu_text", $this->lang->line('menu_text'));
	$this->set("tran_target", $this->lang->line('target'));
	$this->set("tran_permision_admin", $this->lang->line('permision_admin'));
	$this->set("tran_permision_emp", $this->lang->line('permision_emp'));
	$this->set("tran_permision_user", $this->lang->line('permision_user'));
	$this->set("tran_icon", $this->lang->line('icon'));
	$this->set("tran_submit", $this->lang->line('submit'));
	$this->set("tran_update", $this->lang->line('update'));
	$this->set("tran_update", $this->lang->line('update'));
	$this->set("tran_select_one", $this->lang->line('select_one'));
	$this->set("tran_add_sub_menu_item", $this->lang->line('add_sub_menu_item'));
	$this->set("tran_you_must_select_a_link", $this->lang->line('you_must_select_a_link'));
	$this->set("tran_you_must_enter_the_text", $this->lang->line('you_must_enter_the_text'));
	$this->set("tran_you_must_select_one_option", $this->lang->line('you_must_select_one_option'));
	$this->set("page_top_header", $this->lang->line('add_sub_menu_item'));
	$this->set("page_top_small_header", "");
	$this->set("page_header", $this->lang->line('add_sub_menu_item'));
	$this->set("page_small_header", "");

	$this->setView();
    }

    function add_new_scripts($action = NULL, $script_id = NULL) {
	$title = lang('add_new_scripts');
	$this->set("title", $this->COMPANY_NAME . " | $title");

	$this->HEADER_LANG['page_top_header'] = lang('add_new_scripts');
	$this->HEADER_LANG['page_top_small_header'] = '';
	$this->HEADER_LANG['page_header'] = lang('add_new_scripts');
	$this->HEADER_LANG['page_small_header'] = '';

	$this->load_langauge_scripts();

	$help_link = "search-member";
	$this->set("help_link", $help_link);

	$flag = FALSE;
	$script_flag = FALSE;
	$scripts = array();

	if ($this->input->post('search') && $this->validate_add_new_scripts_link_search()) {
	    $flag = true;
	    $link_name = $this->input->post('link_name');
	    $this->session->set_userdata('inf_url_link', $link_name);
	}
	if ($this->input->post('add_link') && $this->validate_add_new_scripts_link_add()) {
	    $flag = true;
	    $link_name = $this->input->post('link_name');
	    $result = $this->menus_model->addLink($link_name);
	    if ($result) {
		$this->session->set_userdata('inf_url_link', $link_name);
		$msg = lang('Link_Details_Inserted_Successfully.');
		$this->redirect($msg, 'menus/add_new_scripts', true);
	    } else {
		$msg = lang('error_on_adding_link_details');
		$this->redirect($msg, 'menus/add_new_scripts', false);
	    }
	}

	$link_name = '';
	$script_name = '';
	$script_type = '';
	$script_loc = '';
	$script_order = '';
	$script_status = '';

	if ($this->session->userdata('inf_url_link')) {
	    $flag = true;
	    $link_name = $this->session->userdata('inf_url_link');
	    $link_ref_id = $this->menus_model->getLinkRefId($link_name);
	    $scripts = $this->menus_model->getScripts($link_ref_id);
	}

	if ($this->input->post('add_script')) {
	    $script_flag = true;
	    $flag = true;
	}

	if ($action == 'edit') {
	    $flag = true;
	    $script_flag = true;
	    $script_details = $this->menus_model->selectScriptDetails($script_id);
	    $link_name = $this->menus_model->getLinkName($script_details['link_ref_id']);
	    $script_name = $script_details['script_name'];
	    $script_type = $script_details['script_type'];
	    $script_loc = $script_details['script_loc'];
	    $script_order = $script_details['script_order'];
	    $script_status = $script_details['script_status'];
	}

	if ($this->input->post('script_update')) {
	    $script_flag = true;
	    if ($this->validate_add_new_scripts_update()) {
		$script_id = $this->input->post('script_id');
		$script_name = $this->input->post('script_name');
		$script_type = $this->input->post('script_type');
		$script_loc = $this->input->post('script_loc');
		$script_order = $this->input->post('script_order');
		$script_status = $this->input->post('script_status');

		$res = $this->menus_model->updateScript($script_id, $script_name, $script_type, $script_loc, $script_order, $script_status);
		if ($res) {
		    $msg = lang('script_updated_successfully');
		    $this->redirect($msg, 'menus/add_new_scripts', TRUE);
		} else {
		    $msg = lang('Error_On_Updating_script');
		    $this->redirect($msg, 'menus/add_new_scripts', FALSE);
		}
	    } else {
		$script_id = $this->input->post('script_id');
		$script_name = $this->input->post('script_name');
		$script_type = $this->input->post('script_type');
		$script_loc = $this->input->post('script_loc');
		$script_order = $this->input->post('script_order');
		$script_status = $this->input->post('script_status');
	    }
	}

	if ($this->input->post('script_submit')) {
	    $script_flag = true;
	    if ($this->validate_add_new_scripts()) {
		$link_ref_id = $this->menus_model->getLinkRefId($this->input->post('link_name'));
		$script_name = $this->input->post('script_name');
		$script_type = $this->input->post('script_type');
		$script_loc = $this->input->post('script_loc');
		$script_order = $this->input->post('script_order');
		$script_status = $this->input->post('script_status');

		$res = $this->menus_model->insertScriptDetails($link_ref_id, $script_name, $script_type, $script_loc, $script_order, $script_status);
		if ($res) {
		    $msg = lang('script_Details_Inserted_Successfully..');
		    $this->redirect($msg, 'menus/add_new_scripts', true);
		} else {
		    $msg = lang('error_on_adding_script_details');
		    $this->redirect($msg, 'menus/add_new_scripts', false);
		}
	    } else {
		$script_name = $this->input->post('script_name');
		$script_type = $this->input->post('script_type');
		$script_loc = $this->input->post('script_loc');
		$script_order = $this->input->post('script_order');
		$script_status = $this->input->post('script_status');
	    }
	}

	$this->set('script_id', $script_id);
	$this->set('link_name', $link_name);
	$this->set('script_name', $script_name);
	$this->set('script_type', $script_type);
	$this->set('script_loc', $script_loc);
	$this->set('script_order', $script_order);
	$this->set('script_status', $script_status);
	$this->set("flag", $flag);
	$this->set("script_flag", $script_flag);
	$this->set("scripts", $scripts);
	$this->setView();
    }

    public function validate_add_new_scripts_link_add() {
	$this->form_validation->set_rules('link_name', lang('link_name'), 'trim|required|strip_tags');
	$validate_form = $this->form_validation->run();
	if ($validate_form) {
	    $link_name = $this->input->post('link_name');
	    $result = $this->menus_model->isLinkAvailable($link_name);
	    if ($result) {
		$msg = lang('link_already_exist');
		$this->redirect($msg, 'menus/add_new_scripts', false);
	    } else {
		return true;
	    }
	}
    }

    public function validate_add_new_scripts_link_search() {
	$this->form_validation->set_rules('link_name', lang('link_name'), 'trim|required|strip_tags');
	$validate_form = $this->form_validation->run();
	if ($validate_form) {
	    $link_name = $this->input->post('link_name');
	    $result = $this->menus_model->isLinkAvailable($link_name);
	    if ($result) {
		return true;
	    } else {
		$this->session->unset_userdata('inf_url_link');
		$msg = lang('link_not_exist');
		$this->redirect($msg, 'menus/add_new_scripts', false);
	    }
	}
    }

    public function validate_add_new_scripts() {
	$this->form_validation->set_rules('link_name', lang('link_name'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_name', lang('script_name'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_type', lang('script_type'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_loc', lang('script_loc'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_order', lang('script_order'), 'trim|required|strip_tags|numeric');
	$this->form_validation->set_rules('script_status', lang('script_status'), 'trim|required|strip_tags');
	$validate_form = $this->form_validation->run();
	if ($validate_form) {
	    if ($validate_form) {
		$script_name = $this->input->post('script_name');
		$result = $this->menus_model->isScriptAvailable($script_name);
		if ($result) {
		    $msg = lang('script_already_exist');
		    $this->redirect($msg, 'menus/add_new_scripts', false);
		} else {
		    return true;
		}
	    }
	}
    }

    public function validate_add_new_scripts_update() {
	$this->form_validation->set_rules('link_name', lang('link_name'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_name', lang('script_name'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_type', lang('script_type'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_loc', lang('script_loc'), 'trim|required|strip_tags');
	$this->form_validation->set_rules('script_order', lang('script_order'), 'trim|required|strip_tags|numeric');
	$this->form_validation->set_rules('script_status', lang('script_status'), 'trim|required|strip_tags');
	$validate_form = $this->form_validation->run();
	return $validate_form;
    }

}

?>