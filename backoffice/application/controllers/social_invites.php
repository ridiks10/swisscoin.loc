<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once 'admin/Inf_Controller.php';

class social_invites extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('member_model');
    }

    function facebook($id = '') {
        $title = 'Facebook Invite';
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        $help_link = "facebook-invite";
        $this->set("help_link", $help_link);
        
        $this->load_langauge_scripts();
        
        $fb_share = $this->social_invites_model->getSocialInviteData($id);
        $this->set('subject', $fb_share['subject']);
        $this->set('content', $fb_share['content']);
        $this->setView();
    }

}
