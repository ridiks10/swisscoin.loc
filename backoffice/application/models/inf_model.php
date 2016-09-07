<?php

/**
 * @property translation_model $translation_model
 */
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
        return $this->MODULE_STATUS;
    }

    public function getAllLanguages()
    {
        return $this->translation_model->getActiveLanguages();
    }

    public function getProjectDefaultLang()
    {
        return $this->translation_model->getDefaultLanguage();
    }

    public function checkUpgrade($user_ref_id) {
        $account_status = 'inactive';
        $res = $this->db->query("SELECT account_status FROM infinite_mlm_user_detail WHERE id='$user_ref_id'");
        foreach ($res->result() as $row) {
            $account_status = $row->account_status;
        }
        return $account_status;
    }

    public function getURLScripts($url_link) {
        $script_arr = array();
        $url_ref_id = $this->menu->UrlToId($url_link);
        if ($url_ref_id) {
            $this->load->model('url_scripts_model');
            $script_arr = $this->url_scripts_model->getURLScripts($url_ref_id);
        }
        return $script_arr;
    }

    /**
     * @deprecated 1.21 use $this->menu->UrlToId instead
     * @param string $url_link
     * @return int
     */
    public function getURLID($url_link) {
        log_message('error', 'Usage of deprecated inf_model->getURLID()');
        return $this->menu->UrlToId($url_link);
    }

    /**
     * @deprecated 1.21 use $this->menu->IdToUrl instead
     * @param int $url_id
     * @return string
     */
    public function getURLName($url_id) {
        log_message('error', 'Usage of deprecated inf_model->getURLName()');
        return $this->menu->IdToUrl($url_id);
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getURLTarget($url_id) {
        log_message('error', 'Usage of deprecated inf_model->getURLTarget()');
        $target = 'none';
        $this->db->select('target');
        $this->db->from('infinite_urls');
        $this->db->where('id', $url_id);
        $this->db->where('status', 'yes');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $target = $row['target'];
        }
        return $target;
    }

    public function getThemeFolder() {
        $this->db->select('admin_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $data = $row->admin_theme_folder;
        }
        return $data;
    }

    public function getUserThemeFolder() {
        $this->db->select('user_theme_folder');
        $res = $this->db->get('site_information');
        foreach ($res->result() as $row) {
            $data = $row->user_theme_folder;
        }
        return $data;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getLeftMenu($user_id, $user_type, $current_url, $plan) {
        log_message('error', 'Usage of deprecated inf_model->getLeftMenu()');
        $assigned_menus = "";
        $permission_type = 'perm_dist';
        if ($user_type == 'admin') {
            $permission_type = 'perm_admin';
        } else if ($user_type == 'employee') {
            $permission_type = 'perm_emp';
            $assigned_menus = $this->getAllAssignedMenus($user_id);
        }

        $path_root_reg = base_url();
        $path_root = base_url() . "user/";

        if ($user_type == "admin" || $user_type == "employee") {
            $path_root = base_url() . "admin/";
        }

        $menu_array = $this->getMenuArray($permission_type, $current_url, $path_root, $path_root_reg, $assigned_menus);

        return $menu_array;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getMenuArray($permission_type, $current_url, $path_root, $path_root_reg, $assigned_menus = "") {
        log_message('error', 'Usage of deprecated inf_model->getMenuArray()');
        $router_class = $this->router->fetch_class();
        $current_url_id = $this->menu->UrlToId($current_url);
        $menu_array = array();
        $this->db->select('*');
        $this->db->from('infinite_mlm_menu');
        $this->db->where("status", "yes");
        $this->db->where($permission_type, "1");
        
        //new sree
        
        if ($permission_type == 'perm_admin' && $this->router->fetch_class() == 'ticket_system') {
            $this->db->where_in('id', array(66, 67, 68, 69, 70, 71, 72, 73,24));
        } elseif($permission_type != 'perm_emp') {
            $this->db->where_not_in('id', array(66, 67, 68, 69, 70, 71, 72, 73));
        }
        $this->db->order_by("main_order_id");
        $qry = $this->db->get();

        $i = 0;
        foreach ($qry->result_array() as $row) {
            $menu_flag = TRUE;
            $is_selected = FALSE;
            $menu_id = $row['id'];
            if ($menu_id == 36) {
                continue;
            }
            $link_ref_id = $row['link_ref_id'];

            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkMenuPermitted($link_ref_id, $permission_type, $menu_id, $assigned_menus);
            }
            if($row['icon']=='clip-cog') {
                $debugger = true;
            }
            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $link_ref_id, $current_url_id);
                $menu_link = $this->menu->IdToUrl($link_ref_id);
                $menu_target = $this->getURLTarget($link_ref_id);

                if ($link_ref_id == 19 || $link_ref_id == 4) {//register/user_register & login/logout
                    $menu_link = $path_root_reg . $menu_link;
                } else if ($link_ref_id != '#') {
                    $menu_link = $path_root . $menu_link;
                } elseif ($link_ref_id == "#") {
                    $menu_link = 'javascript:void(0);';
                }
                $menu_array[$i]["link"] = $menu_link;
                $menu_array[$i]["target"] = $menu_target;
                $menu_array[$i]["icon"] = $row['icon'];
                $menu_array[$i]["link_ref_id"] = $row['link_ref_id'];
                $menu_array[$i]["text"] = lang($menu_id . '_' . $row['link_ref_id']);
                $menu_array[$i]["sub_menu"] = $this->getSubMenuArray($menu_id, $permission_type, $current_url, $path_root, $assigned_menus);
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
    public function isMenuSelected($menu_id, $menu_link, $current_url_id) {
        log_message('error', 'Usage of deprecated inf_model->isMenuSelected()');
        $flag = FALSE;

        if ($menu_link == "#") {
            $current_menu_id = $this->getMainMenuIdFromSubLink($current_url_id);
            if ($current_menu_id == $menu_id) {
                $flag = TRUE;
            }
        } else {
            if ($current_url_id == $menu_link) {
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
        log_message('error', 'Usage of deprecated inf_model->getMainMenuIdFromSubLink()');
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
    public function getSubMenuArray($menu_id, $permission_type, $current_url, $path_root, $assigned_menus = "") {
        log_message('error', 'Usage of deprecated inf_model->getSubMenuArray()');
        $sub_menu = array();
        $current_url_id = $this->menu->UrlToId($current_url);

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
            $sub_link_ref_id = $row['sub_link_ref_id'];
            $sub_menu_link = $this->menu->IdToUrl($sub_link_ref_id);
            if ($permission_type == 'perm_emp') {
                $menu_flag = $this->checkSubMenuPermitted($assigned_menus, $menu_id, $permission_type, $sub_menu_id);
            }

            if ($menu_flag) {
                $is_selected = $this->isMenuSelected($menu_id, $sub_link_ref_id, $current_url_id);
                $sub_menu_link = $path_root . $sub_menu_link;
                $sub_menu[$i]["link"] = $sub_menu_link;
                $sub_menu[$i]["icon"] = $row['icon'];
                $sub_menu[$i]["text"] = lang($menu_id . '_' . $sub_menu_id . '_' . $sub_link_ref_id);
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
        log_message('error', 'Usage of deprecated inf_model->getMenuID()');
        $menu_id = 0;
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
        log_message('error', 'Usage of deprecated inf_model->getSubMenuID()');
        $submenu_id = 0;
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
        $menu_id = 0;
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
    public function checkMenuPermitted($link_id, $perm_type = '', $menu_id = '', $assigned_menus = '') {
        log_message('error', 'Usage of deprecated inf_model->checkMenuPermitted()');
        $flag = FALSE;
        $module_status_arr = explode(",", $assigned_menus);
        if ($menu_id) {
            $menu_check = 'm#' . $menu_id;
            if (in_array($menu_check, $module_status_arr)) {
                $flag = TRUE;
            }
            if (!$flag) {
                $flag = $this->checkSubMenuPermitted($assigned_menus, $menu_id, $perm_type);
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
    public function checkSubMenuPermitted($assigned_menus, $menu_id, $perm_type, $submenu_id = '') {
        log_message('error', 'Usage of deprecated inf_model->checkSubMenuPermitted()');
        $flag = FALSE;
        $module_status_arr = explode(",", $assigned_menus);
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

    public function isValidDemoID($demo_id) {
        $flag = FALSE;
        $count = 0;

        $query = $this->db->query("SELECT COUNT(*) AS `numrows` FROM (`infinite_mlm_user_detail`) WHERE `id` = '$demo_id' AND `account_status` != 'deleted'");
        foreach ($query->result() AS $row) {
            $count = $row->numrows;
        }
        if ($count) {
            $flag = TRUE;
        }
        return $flag;
    }

    /**
     * @deprecated 1.21 menu rewriten to menu library
     * @see backoffice/application/libraries/Menu.php
     */
    public function getAllAssignedMenus($user_id) {
        log_message('error', 'Usage of deprecated inf_model->getAllAssignedMenus()');
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
        log_message('error', 'Usage of deprecated inf_model->getAllSubMenus()');
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

    public function setDefaultLang($lang_code) {
        $user_id = $this->LOG_USER_ID;
        if ($user_id) {
            $this->db->set('default_lang', $lang_code);
            $this->db->where('user_id', $user_id);
            $this->db->update("login_user");
        }
    }

    public function getLanguageName($id)
    {
        return $this->translation_model->getLangName($id);
    }

    public function getDefaultLang($user) {
        $logged_in_arr = $this->session->userdata('inf_logged_in');
        $table_prefix = $logged_in_arr['table_prefix'];
        $lang = 1;
        $this->db->select('default_lang');
        $this->db->from($table_prefix . 'login_user');
        $this->db->where('user_id', $user);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $lang = $row['default_lang'];
        }
        return $lang;
    }

}
