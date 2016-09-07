<?php

class super_inf_model extends Core_inf_model {

    public $MODULE_STATUS;

    function __construct() {
        parent::__construct();
        $this->MODULE_STATUS = array();
    }


    public function getURLScripts($url_link) {

        $script_arr = array();
        if ($url_link == "login/index") {

            $script_arr[0]['name'] = "super_admin.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "footer";
        }
        if ($url_link == "login/index1") {

            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "validate_member.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
        }
        if ($url_link == "login/index2") {

            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "datepicker/css/datepicker.css";
            $script_arr[3]['type'] = "plugins/css";
            $script_arr[3]['loc'] = "header";
            $script_arr[4]['name'] = "bootstrap-timepicker/css/bootstrap-timepicker.min.css";
            $script_arr[4]['type'] = "plugins/css";
            $script_arr[4]['loc'] = "header";
            $script_arr[5]['name'] = "bootstrap-datepicker/js/bootstrap-datepicker.js";
            $script_arr[5]['type'] = "plugins/js";
            $script_arr[5]['loc'] = "footer";
            $script_arr[6]['name'] = "bootstrap-timepicker/js/bootstrap-timepicker.min.js";
            $script_arr[6]['type'] = "plugins/js";
            $script_arr[6]['loc'] = "footer";
            $script_arr[7]['name'] = "date_time_picker.js";
            $script_arr[7]['type'] = "js";
            $script_arr[7]['loc'] = "footer";
        }
        if ($url_link == "newsletter/unsubscribe_user") {

            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list-super.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "news_letter.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
        }
        if ($url_link == "newsletter/send_newsletter") {

            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list-super.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "news_letter.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
        }
        
        if ($url_link == "login/unsubscribe_user") {

            $script_arr[0]['name'] = "ajax.js";
            $script_arr[0]['type'] = "js";
            $script_arr[0]['loc'] = "header";
            $script_arr[1]['name'] = "ajax-dynamic-list-super.js";
            $script_arr[1]['type'] = "js";
            $script_arr[1]['loc'] = "header";
            $script_arr[2]['name'] = "autoComplete.css";
            $script_arr[2]['type'] = "css";
            $script_arr[2]['loc'] = "header";
            $script_arr[3]['name'] = "news_letter.js";
            $script_arr[3]['type'] = "js";
            $script_arr[3]['loc'] = "header";
        }

        return $script_arr;
    }

    public function getLeftMenu($current_url) {
        $base_path = base_url() . "super_admin/";
        $menu_array = array(
            array("link" => $base_path . "home/index",
                "target" => "none",
                "icon" => "clip-home-2",
                "sub_menu" => array(),
                "link_ref_id" => 5,
                "text" => "Dashboard",
                "is_selected" => ($current_url == "home/index") ? true : false
            ),

            array("link" => $base_path . "home/change_password",
                "target" => "none",
                "icon" => "clip-stack-2",
                "sub_menu" => array(),
                "link_ref_id" => 1,
                "text" => "Change Password",
                "is_selected" => ($current_url == "home/change_password") ? true : false
            ),
            array("link" => $base_path . "home/block_or_unblock",
                "target" => "none",
                "icon" => "clip-settings",
                "sub_menu" => array(),
                "link_ref_id" => 1,
                "text" => "Block/UnBlock",
                "is_selected" => ($current_url == "home/block_or_unblock") ? true : false
            ),
            array("link" => $base_path . "home/delete",
                "target" => "none",
                "icon" => "clip-stats",
                "sub_menu" => array(),
                "link_ref_id" => 1,
                "text" => "Delete",
                "is_selected" => ($current_url == "home/delete") ? true : false
            ),
        );
        if (DEMO_STATUS == "yes") {
            $menu_array[] = array("link" => $base_path . "newsletter/send_newsletter",
                "target" => "none",
                "icon" => "clip-stats",
                "sub_menu" => array(),
                "link_ref_id" => 1,
                "text" => "Send NewsLetter",
                "is_selected" => ($current_url == "newsletter/send_newsletter") ? true : false
            );
//            $menu_array[] = array("link" => $base_path . "newsletter/unsubscribe_user",
//                "target" => "none",
//                "icon" => "clip-stats",
//                "sub_menu" => array(),
//                "link_ref_id" => 1,
//                "text" => "Unsubscribe Users",
//                "is_selected" => ($current_url == "newsletter/unsubscribe_user") ? true : false
//            );
        }
        $menu_array[] = array("link" => $base_path . "login/logout",
            "target" => "none",
            "icon" => "clip-switch",
            "sub_menu" => array(),
            "link_ref_id" => 1,
            "text" => "LogOut",
            "is_selected" => false
        );
        return $menu_array;
    }

}
