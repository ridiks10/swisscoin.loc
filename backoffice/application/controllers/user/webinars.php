<?php

require_once 'Inf_Controller.php';

class Webinars extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    
     public function webinar_list() {
        $title = lang('webinars');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('webinars');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('webinar_list');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        

        $webinars = $this->webinars_model->getWebinars();
        $this->set('webinars', $webinars);
        $this->set('user_name', $this->LOG_USER_NAME);
        $this->setView();
    }

   
     

}
