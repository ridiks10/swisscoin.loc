<?php

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('inf_model');
    }
    
    public function get_notifications()
    {
        $session = $this->session->userdata('inf_logged_in');
        if (!$session || empty($session['user_type']) || $session['user_type'] != 'admin') {
            echo json_encode([]);
            exit;
        }
        $this->load->model('ajax_model');
        try {
            $notifications = $this->ajax_model->getNotifications();

            echo json_encode($notifications);
        } catch (Exception $ex) {
            log_message('error', $ex->getMessage());
            show_error('Server error');
        }
    }
    
}