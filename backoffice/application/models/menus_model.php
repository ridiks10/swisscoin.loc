<?php

class menus_model extends inf_model {

    public function __construct() {
	parent::__construct();
    }

    public function addMainMenuItem($menu_arr) {

	$order_id = $menu_arr['menu_id'];

	$link = $menu_arr['link'];

	$text = $menu_arr['text'];

	$per_admin = $menu_arr['perm_admin'];

	$per_emp = $menu_arr['perm_emp'];

	$per_user = $menu_arr['perm_user'];

	$target = $menu_arr['target'];

	$logo_name = $menu_arr['logo_name'];

	$this->changeOrder($order_id);

	$order_id = $order_id + 1;

	$this->db->set('link', $link);
	$this->db->set('text', $text);
	$this->db->set('status', 'yes');
	$this->db->set('perm_admin', $per_admin);
	$this->db->set('perm_dist', $per_emp);
	$this->db->set('perm_emp', $per_user);
	$this->db->set('main_order_id', $order_id);
	$this->db->set('image', $logo_name);
	$res = $this->db->insert('infinite_mlm_menu');
	return $res;
    }

    public function updateMainMenuItem($menu_arr, $post, $flag) {

	$total_count = $menu_arr['total_count'];
	for ($i = 0; $i < $total_count; $i++) {
	    $key = "active$i";
	    if (array_key_exists($key, $post)) {
		$perm_dist = "";
		if ($post["active$i"] == 'yes') {
		    if ($flag == 1) {
			$menu_id = $post["menu_id$i"];
			$menu_text = $post["menu_text$i"];
			$perm_admin = $post["perm_admin$i"];
			$perm_emp = $post["perm_emp$i"];
			$perm_dist = $post["perm_dist$i"];
			$menu_link = $post["menu_link$i"];
			$logo_name = $post["logo_name$i"];

			$this->db->set('link', $menu_link);
			$this->db->set('text', $menu_text);
			$this->db->set('perm_admin', $perm_admin);
			$this->db->set('perm_emp', $perm_emp);
			$this->db->set('perm_dist', $perm_dist);
			$this->db->set('image', $logo_name);
		    } else {
			$menu_id = $post["menu_id$i"];
			$menu_text = $post["menu_text$i"];
			$perm_admin = $post["perm_admin$i"];
			$perm_emp = $post["perm_emp$i"];
			$perm_dist = $post["perm_dist$i"];
			$menu_link = $post["menu_link$i"];

			$this->db->set('link', $menu_link);
			$this->db->set('text', $menu_text);
			$this->db->set('perm_admin', $perm_admin);
			$this->db->set('perm_emp', $perm_emp);
			$this->db->set('perm_dist', $perm_dist);
		    }



		    $this->db->where('id', $menu_id);
		    $res = $this->db->update('infinite_mlm_menu');
		}
	    }
	}
	return $res;
    }

    public function getMainMenuItems() {
	$menu_item = array();
	$this->db->select('*');
	$this->db->where('status', 'yes');
	$this->db->order_by('main_order_id');
	$this->db->from('infinite_mlm_menu');
	$query = $this->db->get();
	$i = 0;
	foreach ($query->result_array() as $row) {
	    $menu_item["$i"]["id"] = $row['id'];
	    $menu_item["$i"]["link"] = $row['link'];
	    $menu_item["$i"]["text"] = $row['text'];
	    $menu_item["$i"]["status"] = $row['status'];
	    $menu_item["$i"]["perm_admin"] = $row['perm_admin'];
	    $menu_item["$i"]["perm_emp"] = $row['perm_emp'];
	    $menu_item["$i"]["perm_dist"] = $row['perm_dist'];
	    $menu_item["$i"]["order_id"] = $row['main_order_id'];
	    $i++;
	}
	return $menu_item;
    }

    public function addSubMenuItem($post) {
	$menu_id = $post['menu_id'];
	$ref_id_post = $post['refrence_id'];
	$link = $post['link'];
	$text = $post['text'];
	$per_admin = $post['perm_admin'];
	$per_emp = $post['perm_emp'];
	$per_user = $post['perm_user'];
	$target = $post['target'];
	$logo_name = $post['logo_name'];

	$order_id = $menu_id + 1;
	$this->changeOtherSubMenuOrder($order_id, $ref_id_post);

	$this->db->set('sub_link', $link);
	$this->db->set('sub_text', $text);
	$this->db->set('sub_status', 'yes');
	$this->db->set('perm_admin', $per_admin);
	$this->db->set('perm_dist', $per_emp);
	$this->db->set('perm_emp', $per_user);
	$this->db->set('sub_order_id', $order_id);
	$this->db->set('sub_refid', $ref_id_post);
	$this->db->set('sub_image', $logo_name);
	$res = $this->db->insert('infinite_mlm_sub_menu');

	return $res;
    }

    //=========added by aparna============//
    public function changeOtherSubMenuOrder($order_id, $ref_id) {
	$this->db->where('sub_order_id >=', $order_id);
	$this->db->where('sub_refid', $ref_id);
	$this->db->set('sub_order_id', 'sub_order_id+1', FALSE);
	$res = $this->db->update('infinite_mlm_sub_menu');
	return $res;
    }

    public function getAvailableMainMenuItems($dashboard, $logout) {
	$menu_item = array();
	$this->db->select('*');
	$this->db->where('status', 'yes');
	$this->db->where('text !=', $dashboard);
	$this->db->where('text !=', $logout);
	$this->db->order_by('main_order_id');
	$this->db->from('infinite_mlm_menu');
	$query = $this->db->get();
	$i = 0;
	foreach ($query->result_array() as $row) {
	    $menu_item["$i"]["id"] = $row['id'];
	    $menu_item["$i"]["text"] = $row['text'];

	    $i++;
	}
	return $menu_item;
    }

    //==========code ends===================//
    public function getSubMenuReferceId($id) {
	$sub_refid = "";
	$this->db->select('sub_refid');
	$this->db->where('sub_refid', $id);
	$this->db->from('infinite_mlm_sub_menu');
	$res = $this->db->get();
	foreach ($res->result() as $row) {
	    $sub_refid = $row->sub_refid;
	}
	return $sub_refid;
    }

    public function getSubMenuOrderId($menu_id) {
	$sub_order_id = "";
	$this->db->select('sub_order_id');
	$this->db->where('sub_id', $menu_id);
	$this->db->from('infinite_mlm_sub_menu');
	$res = $this->db->get();
	foreach ($res->result() as $row) {
	    $sub_order_id = $row->sub_order_id;
	}
	return $sub_order_id;
    }

    public function changeSubMenuOrder($new_order_id, $refrece_id) {
	$no_of_updation = $this->getNoOfSubMenuItem($refrece_id);
	$no_of_updation = $no_of_updation - $new_order_id;
	$new_order_id = $this->getNoOfSubMenuItem($refrece_id);

	for ($i = 0; $i < $no_of_updation; $i++) {
	    $id = $this->getSubMenuId($new_order_id, $refrece_id);
	    $this->db->set('sub_order_id', 'sub_order_id+1');
	    $this->db->where('sub_id', $id);
	    $res = $this->db->update('infinite_mlm_sub_menu');
	    $new_order_id = $new_order_id - 1;
	}
    }

    public function getNoOfSubMenuItem($refrece_id) {
	$this->db->select("COUNT(*) AS cnt");
	$this->db->from('infinite_mlm_sub_menu');
	$this->db->where('sub_refid', $refrece_id);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    $cnt = $row->cnt;
	}
	return $cnt;
    }

    public function getSubMenuId($order_id, $refrece_id) {
	$menu_id = '';
	$this->db->select('sub_id');
	$this->db->where('sub_order_id', $order_id);
	$this->db->where('sub_refid', $refrece_id);
	$this->db->from('infinite_mlm_sub_menu');
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    $menu_id = $row->sub_id;
	}
	return $menu_id;
    }

    public function changeOrder($new_order_id) {

	$menu_arr = $this->getMainMenuItems();
	$len = count($menu_arr);
	$no_of_updation = $len - $new_order_id;
	$new_order_id = $new_order_id + $no_of_updation;

	for ($i = 0; $i < $no_of_updation; $i++) {
	    $id = $this->getMainMenuId($new_order_id);
	    $this->db->set('main_order_id', 'main_order_id + 1', FALSE);
	    $this->db->where('id', $id);
	    $this->db->update('infinite_mlm_menu');
	    $new_order_id = $new_order_id - 1;
	}
	return $new_order_id;
    }

    public function getMainMenuId($order_id) {
	$menu_id = "";
	$this->db->select('id');
	$this->db->from('infinite_mlm_menu');
	$this->db->where('main_order_id', $order_id);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    $menu_id = $row->id;
	}
	return $menu_id;
    }

    public function getSubMenuItems() {
	$menu_item = array();
	$this->db->select('*');
	$this->db->where('sub_status', 'yes');
	$this->db->order_by('sub_order_id');
	$this->db->from('infinite_mlm_sub_menu');
	$query = $this->db->get();
	$i = 0;
	foreach ($query->result_array() as $row) {
	    $menu_item["$i"]["id"] = $row['sub_id'];
	    $menu_item["$i"]["link"] = $row['sub_link'];
	    $menu_item["$i"]["text"] = $row['sub_text'];
	    $menu_item["$i"]["logo_name"] = $row['sub_image'];
	    $menu_item["$i"]["status"] = $row['sub_status'];
	    $menu_item["$i"]["perm_admin"] = $row['perm_admin'];
	    $menu_item["$i"]["perm_emp"] = $row['perm_emp'];
	    $menu_item["$i"]["perm_dist"] = $row['perm_dist'];
	    $menu_item["$i"]["order_id"] = $row['sub_order_id'];
	    $i++;
	}
	return $menu_item;
    }

    public function updateSubMenuItem($menu_arr, $post) {
	$total_count = $menu_arr['total_count'];
	for ($i = 0; $i < $total_count; $i++) {
	    $key = "active$i";
	    if (array_key_exists($key, $post)) {
		$perm_dist = "";
		if ($post["active$i"] == 'yes') {
		    $menu_id = $post["menu_id$i"];
		    $menu_text = $post["menu_text$i"];
		    $perm_admin = $post["perm_admin$i"];
		    $perm_emp = $post["perm_emp$i"];
		    $perm_dist = $post["perm_dist$i"];
		    $menu_link = $post["menu_link$i"];
		    $logo_name = $post["logo_name$i"];

		    $this->db->set('sub_link', $menu_link);
		    $this->db->set('sub_text', $menu_text);
		    $this->db->set('sub_image', $logo_name);
		    $this->db->set('perm_admin', $perm_admin);
		    $this->db->set('perm_emp', $perm_emp);
		    $this->db->set('perm_dist', $perm_dist);
		    $this->db->where('sub_id', $menu_id);
		    $res = $this->db->update('infinite_mlm_sub_menu');
		}
	    }
	}
	return $res;
    }

    public function getLinkRefId($link_name) {
	$link_id = "";
	$this->db->select('id');
	$this->db->from('infinite_urls');
	$this->db->where('link', $link_name);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    $link_id = $row->id;
	}
	return $link_id;
    }

    public function getScripts($link_ref_id) {
	$scripts_item = array();
	$this->db->select('*');
	$this->db->where('url_ref_id', $link_ref_id);
	$this->db->order_by('script_order');
	$this->db->from('infinite_scripts');
	$query = $this->db->get();
	$i = 0;
	foreach ($query->result_array() as $row) {
	    $scripts_item["$i"]["id"] = $row['id'];
	    $scripts_item["$i"]["script_name"] = $row['script_name'];
	    $scripts_item["$i"]["script_type"] = $row['script_type'];
	    $scripts_item["$i"]["script_loc"] = $row['script_loc'];
	    $scripts_item["$i"]["script_order"] = $row['script_order'];
	    $scripts_item["$i"]["script_status"] = $row['script_status'];
	    $i++;
	}
	return $scripts_item;
    }

    public function selectScriptDetails($script_id) {
	$scripts_item = array();
	$this->db->select('*');
	$this->db->where('id', $script_id);
	$this->db->limit(1);
	$this->db->from('infinite_scripts');
	$query = $this->db->get();
	foreach ($query->result_array() as $row) {
	    $scripts_item["id"] = $row['id'];
	    $scripts_item["link_ref_id"] = $row['url_ref_id'];
	    $scripts_item["script_name"] = $row['script_name'];
	    $scripts_item["script_type"] = $row['script_type'];
	    $scripts_item["script_loc"] = $row['script_loc'];
	    $scripts_item["script_order"] = $row['script_order'];
	    $scripts_item["script_status"] = $row['script_status'];
	}
	return $scripts_item;
    }

    public function updateScript($script_id, $script_name, $script_type, $script_loc, $script_order, $script_status) {

	$this->db->set('script_name', $script_name);
	$this->db->set('script_type', $script_type);
	$this->db->set('script_loc', $script_loc);
	$this->db->set('script_order', $script_order);
	$this->db->set('script_status', $script_status);
	$this->db->where('id', $script_id);
	$query = $this->db->update('infinite_scripts');
	return $query;
    }

    public function insertScriptDetails($link_ref_id, $script_name, $script_type, $script_loc, $script_order, $script_status) {
	$this->db->set('url_ref_id', $link_ref_id);
	$this->db->set('script_name', $script_name);
	$this->db->set('script_type', $script_type);
	$this->db->set('script_loc', $script_loc);
	$this->db->set('script_order', $script_order);
	$this->db->set('script_status', $script_status);
	$query = $this->db->insert('infinite_scripts');
	return $query;
    }

    public function addLink($link_name) {
	$this->db->set('link', $link_name);
	$query = $this->db->insert('infinite_urls');
	return $query;
    }

    public function getLinkName($link_id) {
	$link = "";
	$this->db->select('link');
	$this->db->from('infinite_urls');
	$this->db->where('id', $link_id);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    $link = $row->link;
	}
	return $link;
    }

    public function isLinkAvailable($link_name) {
	$this->db->select('count(*) as cnt');
	$this->db->from('infinite_urls');
	$this->db->where('link', $link_name);
	$this->db->limit(1);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    return $row->cnt;
	}
    }

    public function isScriptAvailable($link_name) {
	$this->db->select('count(*) as cnt');
	$this->db->from('infinite_scripts');
	$this->db->where('script_name', $link_name);
	$this->db->limit(1);
	$query = $this->db->get();
	foreach ($query->result() as $row) {
	    return $row->cnt;
	}
    }

}
