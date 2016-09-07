<?php

require_once 'Inf_Controller.php';

class Swisscoin extends Inf_Controller {

    function __construct() {
        parent::__construct(); 
    }

    function academy() {
        $this->load->library('moodle_api');
        $this->load->model('moodle_model');

        $user_data = $this->session->userdata('inf_logged_in');
        $user_detail = $this->moodle_model->getUserDetail($user_data['user_id']);
        $user_data['email'] = $user_detail->user_detail_email;

        $credentials = $this->moodle_api->getUserToken($user_data);
        if (!$credentials->success) {
            $user = $this->moodle_model->getUserById($user_data['user_id']);
            $new_user = $this->moodle_model->createUser($user, $user_detail);
            if (!empty($new_user)) {
                $credentials = $this->moodle_api->getUserToken($user_data);
            }
        }

        $this->moodle_api->loginUser($credentials);
    }

    function foundation() {
        $title = lang('foundation');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('foundation');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('foundation');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $content = ($row = $this->swisscoin_model->getFoundationContent()) ? $row['content'] : '';

        if($this->input->post('foundation_submit')){
            $content = $this->input->post('content');
            $this->swisscoin_model->updateFoundationContent($content);
        }

        $this->set('content', $content);

        $this->setView();
    }
     function swisscoin_account() {

        $title = lang('swisscoin_account');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('swisscoin_account');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('swisscoin_account');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
       
        $this->setView();
    }
     function exchange() {

        $title = lang('exchange');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('exchange');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('exchange');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
       
        $this->setView();
    }
}
