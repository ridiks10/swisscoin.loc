<?php

require_once 'Inf_Controller.php';

class Mail extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("android/new/android_model");
    }

    function compose_email() {
// add two extra fields message and subject
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $post_array['message'] = $this->validation_model->stripTagTextArea($post_array['message']);

        $user_id = $this->LOG_USER_ID;
        if (!$user_id) {
            $user_details['status'] = false;
            $user_details['message'] = 'Invalid Login details';
        } else {
            $subject = $post_array['subject'];
            $message = $post_array['message'];
            $message = addslashes($message);
            $dt = date('Y-m-d H:i:s');
            $res = $this->mail_model->sendMesageToAdmin($user_id, $post_array['message'], $post_array['subject'], $dt);
            $msg = '';
            if ($res) {
                $data_array = array();
                $data_array['mail_subject'] = $post_array['subject'];
                $data_array['mail_body'] = $post_array['subject'];
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail sent mobile', $this->ADMIN_USER_ID, $data);
            }

            $user_details['status'] = true;
            $user_details['message'] = 'Message Send Sucessfully';
        }
        echo json_encode($user_details);
        exit();
    }

    function get_all_emails() {
        $user_id = $this->LOG_USER_ID;
        $this->load->model('income_details_model');
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {
            $json_response['status'] = true;
            $json_response['message'] = 'Success';
            $data1 = $this->mail_model->getUserMessages($user_id, $page = '', $config['per_page'] = '');
            $data2 = $this->mail_model->getUserContactMessages($user_id, $page = '', $config['per_page'] = '');
            $json_response['data'] = array_merge($data1, $data2);
        }
        echo json_encode($json_response);
        exit();
    }

    function delete_email() {
        //add delete_id as extra field
        $user_id = $this->LOG_USER_ID;
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $msg_id = $post_array['delete_id'];
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {

            $check_mail_exist = $this->android_model->checkMailexist($msg_id);
            if (!$check_mail_exist) {
                $json_response['status'] = false;
                $json_response['message'] = 'Invalid Message Id';
            } else {
                $res = $this->android_model->deleteUserMail($msg_id);
                if ($res) {
                    $data_array = array();
                    $data_array['msg_id'] = $msg_id;
                    $data_array['msg_type'] = 'mail_deleted_mob';
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail read status changed', $this->LOG_USER_ID, $data);
                    $json_response['status'] = true;
                    $json_response['message'] = 'Mail read status changed ';
                } else {
                    $json_response['status'] = false;
                    $json_response['message'] = 'Failed';
                }
            }
        }
        echo json_encode($json_response);
        exit();
    }
    
    function change_mail_read_status() {
        //add delete_id as extra field
        $user_id = $this->LOG_USER_ID;
        $post_array = $this->input->post();
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);
        $msg_id = $post_array['mail_id'];
        if (!$user_id) {
            $json_response['status'] = false;
            $json_response['message'] = 'Invalid user';
        } else {

            $check_mail_exist = $this->android_model->checkMailexist($msg_id);
            if (!$check_mail_exist) {
                $json_response['status'] = false;
                $json_response['message'] = 'Invalid Message Id';
            } else {
                $res = $this->mail_model->updateUserOneMessage($msg_id);
                if ($res) {
                    $data_array = array();
                    $data_array['msg_id'] = $msg_id;
                    $data_array['msg_type'] = 'mail_read_staus_changed_mob';
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'mail read status changed mob', $this->LOG_USER_ID, $data);
                    $json_response['status'] = true;
                    $json_response['message'] = 'Mail read status change Success';
                } else {
                    $json_response['status'] = false;
                    $json_response['message'] = 'Failed';
                }
            }
        }
        echo json_encode($json_response);
        exit();
    }

}

?>
