<?php

require_once 'Inf_Controller.php';

class Career extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }
    
    function show_career() {
       $title = $this->lang->line('careers');
       $this->set("title", $this->COMPANY_NAME . " | $title");

       $help_link = "show_career";
       $this->set("help_link", $help_link);
       $user_id = $this->LOG_USER_ID;

       $this->HEADER_LANG['page_top_header'] = lang('careers');
       $this->HEADER_LANG['page_top_small_header'] = '';
       $this->HEADER_LANG['page_header'] = lang('careers');
       $this->HEADER_LANG['page_small_header'] = '';

       $this->load_langauge_scripts();
       $det = $this->career_model->getAllCareers();
       $this->set("career_details", $det);
       $stat = $this->career_model->getCarrerStat($user_id);

       $this->set("user_bv", $stat['aq_team_bv']);
       $cr = '';
       foreach ($det as $career) {
           if ($career['id'] == $stat['career']) {
               $cr = $career['leadership_rank'];
           }
       }
       $this->set("user_rank", $cr);
       $this->setView();
    }


}