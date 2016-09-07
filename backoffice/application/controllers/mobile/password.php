<?php

require_once 'Inf_Controller.php';

class Password extends Inf_Controller {

    public $display_tree = "";

    function __construct() {
        parent::__construct();
    }

   
    function forgot_password() {
// add one extra fields email
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $this->load->model('login_model');
        $user_id = $this->LOG_USER_ID;
        $user_name_details=array();
        $is_valid_email = $this->login_model->checkEmail($user_id, $post_array['email']);
        if (!$user_id) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Login details';
        } else {

            if (!filter_var($post_array['email'], FILTER_VALIDATE_EMAIL)) {
                $user_details['status'] = false;
                $user_details['message'] = 'Invalid Email';
            } else if (!$is_valid_email) {
                $user_details['status'] = false;
                $user_details['message'] = 'User email  does not exist';
            } else {
                $user_name_details=$this->android_inf_model->getUserDetailsNames($user_id);
                $key = $this->android_inf_model->sendAllEmails($type = 'notification', $user_name_details, $attachments = array(),$user_id,$post_array['email']);
                
                if ($key) {
                    $user_details['status'] = true;
                    $user_details['message'] = 'Your request has been accepted and your password changed sucessfully.Please check your mail';
                } else {
                    $user_details['status'] = false;
                    $user_details['message'] = 'Email Failed';
                }
            }
        }
        echo json_encode($user_details);
        exit();
    }

}
