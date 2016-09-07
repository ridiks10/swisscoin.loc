<?php

class inf_model extends Core_inf_model {

    public $MODULE_STATUS;

    function __construct() {
        parent::__construct();
        $this->MODULE_STATUS = array();
    }

    public function trackModule() {

        $this->db->from('module_status');
        $query1 = $this->db->get();
        foreach ($query1->result_array() as $rows1) {
            $this->MODULE_STATUS = $rows1;
        }

        $payment_status = array();
        $i = 0;
        $this->db->select('status');
        $this->db->from("payment_methods");
        $query2 = $this->db->get();

        foreach ($query2->result_array() as $rows2) {
            $payment_status[$i] = $rows2['status'];
            $i++;
        }

        $this->MODULE_STATUS['credit_card'] = $payment_status[0];
        $this->MODULE_STATUS['free_joining_status'] = $payment_status[3];
    }

    public function getAllLanguages() {
        $lang_arr = array();
        $query = $this->db->where("status", "yes")->get("infinite_languages");

        foreach ($query->result_array() as $rows) {
            $lang_arr[] = $rows;
        }
        return $lang_arr;
    }

    public function checkUpgrade($user_ref_id) {
        $res = $this->db->query("SELECT account_status FROM infinite_mlm_user_detail WHERE id='$user_ref_id'");
        foreach ($res->result() as $row) {
            $upgrade_cond = $row->account_status;
        }
        return $upgrade_cond;
    }

    public function getURLScripts($url_link) {
        $script_arr = array();
        $url_ref_id = $this->menu->UrlToId($url_link);

        $this->db->select('script_name,script_type,script_loc');
        $this->db->from('infinite_scripts');
        $this->db->where('url_ref_id', $url_ref_id);
        $this->db->where('script_status', 'yes');
        $this->db->order_by('script_order', 'ASC');
        $query = $this->db->get();

        $i = 0;
        foreach ($query->result_array() as $rows) {
            $script_arr[$i]['name'] = $rows['script_name'];
            $script_arr[$i]['type'] = $rows['script_type'];
            $script_arr[$i]['loc'] = $rows['script_loc'];
            $i++;
        }

        return $script_arr;
    }

    /**
     * @deprecated 1.21 use $this->menu->UrlToId instead
     * @param string $url_link
     * @return int
     */
    public function getURLID($url_link) {
        return $this->menu->UrlToId($url_link);
    }

    /**
     * @deprecated 1.21 use $this->menu->IdToUrl instead
     * @param int $url_id
     * @return string
     */
    public function getURLName($url_id) {
        return $this->menu->IdToUrl($url_id);
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getLeftMenu($user_id, $user_type, $current_url, $plan) {
        log_message('error', 'Usage of deprecated android->inf_model->getLeftMenu()');
        $permission_type = 'perm_dist';
        if ($user_type == 'admin') {
            $permission_type = 'perm_admin';
        } else if ($user_type == 'employee') {
            $permission_type = 'perm_emp';
        }

        $path_root_reg = base_url();
        $path_root = base_url() . "user/";

        if ($user_type == "admin" || $user_type == "employee") {
            $path_root = base_url() . "admin/";
        }

        $menu_array = $this->getMenuArray($user_id, $permission_type, $current_url, $path_root, $path_root_reg);

        return $menu_array;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getMenuArray($user_id, $permission_type, $current_url, $path_root, $path_root_reg) {
        log_message('error', 'Usage of deprecated android->inf_model->getMenuArray()');
        $menu_array = array();
        $this->db->select('*');
        $this->db->from('infinite_mlm_menu');
        $this->db->where("status", "yes");
        $this->db->where($permission_type, "1");
        $this->db->order_by("main_order_id");
        $qry = $this->db->get();

        $i = 0;
        foreach ($qry->result_array() as $row) {
            $menu_flag = TRUE;
            $is_selected = FALSE;
            $menu_id = $row['id'];
            if ($menu_id == 36)
                continue;
            $menu_link = $row['link_ref_id'];

            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkMenuPermitted($user_id, $menu_link, $permission_type, $menu_id);
            }

            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $menu_link, $current_url);
                if ($menu_link == 19) {//register/user_register
                    $menu_link = $this->getURLName($menu_link);
                    $menu_link = $path_root_reg . $menu_link;
                } else if ($menu_link != '#') {
                    $menu_link = $this->getURLName($menu_link);
                    $menu_link = $path_root . $menu_link;
                } elseif ($menu_link == "#") {
                    $menu_link = 'javascript:void(0);';
                }
                $menu_array[$i]["link"] = $menu_link;
                $menu_array[$i]["icon"] = $row['icon'];
                $menu_array[$i]["link_ref_id"] = $row['link_ref_id'];
                $menu_array[$i]["text"] = lang($menu_id . '_' . $row['link_ref_id']);
                $menu_array[$i]["sub_menu"] = $this->getAllSubMenu($user_id, $menu_id, $permission_type, $current_url, $path_root);
                $menu_array[$i]["is_selected"] = $is_selected;
                $i++;
            }
        }
        return $menu_array;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function isMenuSelected($menu_id, $menu_link, $current_url) {
        log_message('error', 'Usage of deprecated android->inf_model->isMenuSelected()');
        $flag = FALSE;
        $current_url = $this->getURLID($current_url);
        if ($menu_link == "#") {
            $current_menu_id = $this->getMainMenuIdFromSubLink($current_url);
            if ($current_menu_id == $menu_id) {
                $flag = TRUE;
            }
        } else {
            if ($current_url == $menu_link) {
                $flag = TRUE;
            }
        }
        return $flag;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getMainMenuIdFromSubLink($menu_link) {
        log_message('error', 'Usage of deprecated android->inf_model->getMainMenuIdFromSubLink()');
        $sub_refid = 0;
        $this->db->select('sub_refid');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where('sub_link_ref_id', $menu_link);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $sub_refid = $row->sub_refid;
        }
        return $sub_refid;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getAllSubMenu($user_id, $menu_id, $permission_type, $current_url, $path_root) {
        log_message('error', 'Usage of deprecated android->inf_model->getSubMenuArray()');
        $sub_menu = array();

        $this->db->select('*');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_refid", $menu_id);
        $this->db->where("sub_status", "yes");
        $this->db->where($permission_type, "1");
        $this->db->order_by("sub_order_id");
        $qry = $this->db->get();

        $i = 0;
        foreach ($qry->result_array() as $row) {
            $menu_flag = TRUE;
            $sub_menu_id = $row['sub_id'];

            $sub_menu_link = $this->getURLName($row['sub_link_ref_id']);
            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkMenuPermitted($user_id, $sub_menu_link, $permission_type, $menu_id, $sub_menu_id);
            }

            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $sub_menu_link, $current_url);
                $sub_menu_link = $path_root . $sub_menu_link;
                $sub_menu[$i]["link"] = $sub_menu_link;
                $sub_menu[$i]["icon"] = $row['icon'];
                $sub_menu[$i]["text"] = lang($menu_id . '_' . $sub_menu_id . '_' . $row['sub_link_ref_id']);
                $sub_menu[$i]["is_selected"] = $is_selected;
                $i++;
            }
        }
        return $sub_menu;
    }

    public function isValidMenu($link_id) {
        $menu_id = $this->getMenuID($link_id);
        if (!$menu_id) {
            $menu_id = $this->getSubMenuID($link_id);
        }
        return $menu_id;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getMenuID($link_id, $perm_type = '') {
        log_message('error', 'Usage of deprecated android->inf_model->getMenuID()');
        $menu_id = '';
        $this->db->select("id");
        $this->db->from("infinite_mlm_menu");
        $this->db->where('link_ref_id', $link_id);
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $menu_id = $row->id;
        }
        return $menu_id;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getSubMenuID($link_id, $perm_type = '') {
        log_message('error', 'Usage of deprecated android->inf_model->getSubMenuID()');
        $submenu_id = '';
        $this->db->select("sub_id");
        $this->db->from("infinite_mlm_sub_menu");
        $this->db->where('sub_link_ref_id', $link_id);
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $submenu_id = $row->sub_id;
        }
        return $submenu_id;
    }

    public function getMenuIDFromSubMenu($link_id, $perm_type = '') {
        $menu_id = '';
        $this->db->select("sub_refid");
        $this->db->from("infinite_mlm_sub_menu");
        $this->db->where("sub_status", "yes");
        $this->db->where('sub_link_ref_id', $link_id);
        if ($perm_type != '') {
            $this->db->where($perm_type, 1);
        }
        $this->db->limit(1);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $menu_id = $row->sub_refid;
        }
        return $menu_id;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function checkMenuPermitted($user_id, $link_id, $perm_type = '', $menu_id = '') {
        log_message('error', 'Usage of deprecated android->inf_model->checkMenuPermitted()');
        $flag = FALSE;
        $session_module = $this->getAllAssignedMenus($user_id);
        $module_status_arr = explode(",", $session_module);
        if ($menu_id) {
            $menu_check = 'm#' . $menu_id;
            if (in_array($menu_check, $module_status_arr)) {
                $flag = TRUE;
            }
            if (!$flag) {
                $flag = $this->checkSubMenuPermitted($session_module, $menu_id, $perm_type);
            }
        } else {
            if ($link_id != '#') {
                $menu_id = $this->getMenuID($link_id, $perm_type);

                if (!$menu_id) {
                    $submenu_id = $this->getSubMenuID($link_id, $perm_type);
                    $menu_id = $this->getMainMenuIdFromSubLink($link_id);
                    $menu_check = $menu_id . "#" . $submenu_id;
                } else {
                    $menu_check = 'm#' . $menu_id;
                }
                if (in_array($menu_check, $module_status_arr)) {
                    $flag = TRUE;
                }
            } else {
                $flag = TRUE;
            }
        }
        return $flag;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function checkSubMenuPermitted($session_module, $menu_id, $perm_type, $submenu_id = '') {
        log_message('error', 'Usage of deprecated android->inf_model->checkSubMenuPermitted()');
        $flag = FALSE;
        $module_status_arr = explode(",", $session_module);
        if ($submenu_id) {
            $menu_check = $menu_id . "#" . $submenu_id;
            if (in_array($menu_check, $module_status_arr)) {
                $flag = TRUE;
            }
        } else {
            $menu_arr = $this->getAllSubMenus($menu_id, $perm_type);
            foreach ($menu_arr AS $menu_check) {
                if (in_array($menu_check, $module_status_arr)) {
                    $flag = TRUE;
                    break;
                }
            }
        }
        return $flag;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getAllAssignedMenus($user_id) {
        log_message('error', 'Usage of deprecated android->inf_model->getAllAssignedMenus()');
        $user_menus = '';
        $this->db->select("module_status");
        $this->db->from("login_employee");
        $this->db->where('user_id', $user_id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $user_menus = $row->module_status;
        }
        return $user_menus;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getAllSubMenus($menu_id, $perm_type) {
        log_message('error', 'Usage of deprecated android->inf_model->getAllSubMenus()');
        $menu_arr = array();
        $this->db->select('sub_id');
        $this->db->from('infinite_mlm_sub_menu');
        $this->db->where("sub_refid", $menu_id);
        $this->db->where("sub_status", "yes");
        $this->db->where($perm_type, "1");
        $this->db->order_by("sub_order_id");
        $query = $this->db->get();
        foreach ($query->result_array()AS $row) {
            $menu_arr[] = $menu_id . "#" . $row['sub_id'];
        }
        return $menu_arr;
    }

}
