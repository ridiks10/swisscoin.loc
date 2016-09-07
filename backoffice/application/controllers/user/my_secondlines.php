<?php

require_once 'Inf_Controller.php';

class My_secondlines extends Inf_Controller { 

    function __construct() {
        parent::__construct();
    }

    
    
    function second_lines() { 
        $title = lang('secondlines');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('secondlines');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('secondlines');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $secondline = array();
        $user_id = $this->LOG_USER_ID;
        if ($user_id != 0) {
            $secondline_users='';
            $secondline = $this->my_secondlines_model->getAllSecondlineUser($user_id);
            array_pop($secondline);
            if(count($secondline)>0){
            $secondline_users=$this->my_secondlines_model->getAllSecondlineUserDetails($secondline);
            }
        }
        $this->set("secondline_users", $secondline_users);
        $this->setView();
    }

    

}

?>
