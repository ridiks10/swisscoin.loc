<?php

require_once 'Inf_Controller.php';

class Webinars extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function new_webinars($webinar_id = 0) {
        $title = lang('webinars');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->HEADER_LANG['page_top_header'] = lang('webinars');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('add_new_webinars');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        if ($webinar_id != 0) {
            $status = $this->webinars_model->isWebinarValid($webinar_id);
            if ($status) {
                $webinar = $this->webinars_model->getWebinar($webinar_id);
                $this->set('webinar', $webinar);
                $this->set('edit', TRUE);
            } else {
                $msg = lang(' please_select_valid_webinar');
                $this->redirect($msg, 'webinars/webinar_list', FALSE);
            }
        } else {
            $this->set('edit', FALSE);
        }

        if ($this->input->post('add_webinar') && ($this->validate_webinar())) {
            $post = $this->input->post();

            $new_file_name = $post['video'];
            if ($_FILES['userfile']['error'] == 4) {
                $msg = lang('image_not_selected');
                $this->redirect($msg, 'webinars/new_webinars', FALSE);
                die();
            }
            if ($_FILES['userfile']['error'] != 4) {

               
                $config['upload_path'] = './public_html/images/webinar_images/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '6000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = lang('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($error['error'], 'webinars/new_webinars', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name1 = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];
                }
            }



            $this->db->trans_start();
            $this->webinars_model->insertWebinar($post, $new_file_name, $_FILES['userfile']['name']);
            $this->db->trans_complete();
            if ($this->db->trans_status() == TRUE) {
                $msg = lang('webinar_success');
                $this->redirect($msg, 'webinars/new_webinars', TRUE);
            } else {
                $msg = lang('webinar_fail');
                $this->redirect($msg, 'webinars/new_webinars', FALSE);
            }
        }
        if ($this->input->post('edit_webinar') && ($this->validate_webinar())) {



            $post = $this->input->post();
            //print_r($post);die();
            $new_file_name = $post['video'];
            
            if ($_FILES['userfile']['error'] != 4) {

                //$user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/webinar_images/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = lang('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($error['error'], 'webinars/new_webinars/'.$webinar_id, FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name1 = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];
                }
                 $result = $this->webinars_model->updateWebinarImage($webinar_id,$_FILES['userfile']['name']);
            }
            $this->db->trans_start();
            $this->webinars_model->updateWebinar($post, $webinar_id, $new_file_name);
            $this->db->trans_complete();
            if ($this->db->trans_status() == TRUE) {
                $msg = lang('webinar_success_update');
                $this->redirect($msg, 'webinars/webinar_list', TRUE);
            } else {
                $msg = lang('webinar_fail_update');
                $this->redirect($msg, 'webinars/webinar_list/'.$webinar_id, FALSE);
            }
        }

        //$this->set('file_name', $file_name);

        $this->setView();
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
        // print_r($webinars);die();
        $this->set('webinars', $webinars);
        $this->set('user_name', $this->LOG_USER_NAME);
        $this->setView();
    }

    function validate_webinar() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('date', 'Date', 'required|xss_clean|xss_clean');
        $this->form_validation->set_rules('url', 'Url', 'required|xss_clean');
        $this->form_validation->set_rules('user_name', 'Username', 'required|max_length[50]|xss_clean');
        //$this->form_validation->set_rules('password', 'password', 'required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('topic', 'topic', 'required|xss_clean|max_length[50]');
        $this->form_validation->set_rules('txtDefaultHtmlArea', 'description', 'required|xss_clean');
        $this->form_validation->set_rules('video', 'Video', 'required|xss_clean|callback_check_video_upload');
        $this->form_validation->set_message('check_video_upload', 'Invalid Embeded Format');
//        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');

    
        $validate_form = $this->form_validation->run();

        return $validate_form;
    }

    function check_video_upload($video = '') {
       $flag = false;
       if (preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/', htmlspecialchars_decode($video))) {
           $flag = TRUE;
       }

       return $flag;
   }
    public function remove_webinar($webinar_id = 0) {
        if ($webinar_id == 0) {
            $msg = lang('please_select_valid_webinar');
            $this->redirect($msg, 'webinars/webinar_list', FALSE);
        }
        $status = $this->webinars_model->isWebinarValid($webinar_id);
        if ($status) {
            $this->db->trans_start();
            $this->webinars_model->deleteWebinar($webinar_id);
            $this->db->trans_complete();
            if ($this->db->trans_status() == TRUE) {
                $msg = lang('webinar_delete_success');
                $this->redirect($msg, 'webinars/webinar_list', TRUE);
            } else {
                $msg = lang('webinar_delete_fail');
                $this->redirect($msg, 'webinars/webinar_list', FALSE);
            }
        } else {
            $msg = lang('please_select_valid_webinar');
            $this->redirect($msg, 'webinars/webinar_list', FALSE);
        }
    }

}
