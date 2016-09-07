<?php

require_once 'Inf_Controller.php';

class Package extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function my_packs($action = '', $package_id = '') { 
       
        $title = $this->lang->line('view_package');
        $this->set("title", $this->COMPANY_NAME . " | $title");

       // $help_link = "package-management";
       // $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_package');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_package');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id=$this->LOG_USER_ID;
        $package_details = $this->package_model->getAllPackage($user_id);
        $this->set("package_details", $package_details);
        $this->set("arr_count", count($package_details));
        $this->setView();
    }
}
