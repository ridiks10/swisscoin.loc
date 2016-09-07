<?php

require_once 'Inf_Controller.php';

class Income_Details extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function income() {

        $title = lang('income_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        $help_link='income_details';
        $this->set('help_link',$help_link);
        
        $this->HEADER_LANG['page_top_header'] = lang('income_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income_details');
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();
        
        $user_id = $this->LOG_USER_ID;
        $arr = $this->income_details_model->add_income($user_id);
        $this->set("amount", $arr);
        $this->setView();
    }

}

?>