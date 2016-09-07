<?php

require_once 'Inf_Controller.php';

class Career extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('epin_model');
    }

    function add_careers($action = '', $id = '') {
        $title = lang('career_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = 'add_careers';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('career_management');
        $this->HEADER_LANG['page_top_small_header'] = lang('');
        $this->HEADER_LANG['page_header'] = lang('career_management');
        $this->HEADER_LANG['page_small_header'] = lang('');

        $this->load_langauge_scripts();
        if ($this->input->post('career_submit')) {

            $leadership_rank = $this->input->post('leadership_rank');
            $leadership_award = $this->input->post('leadership_award');
            $qualifying_personal_pv = $this->input->post('qualifying_personal_pv');
            $qualifying_weaker_leg_bv = $this->input->post('qualifying_weaker_leg_bv');
            $qualifying_terms = $this->input->post('qualifying_terms');
            if ($leadership_rank == "") {
                $msg = lang('you_should_enter_leadership_rank');
                $this->redirect($msg, 'career/add_careers', FALSE);
            }
            if ($leadership_award == "") {
                $msg = lang('you_should_enter_leadership_award');
                $this->redirect($msg, 'career/add_careers', FALSE);
            }
            if ($qualifying_terms == "") {
                $msg = lang('you_should_enter_qualifying_terms');
                $this->redirect($msg, 'career/add_careers', FALSE);
            }

            if ($_FILES['userfile']['error'] != 4) {

                //$user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/careers/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '40000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = "Image not selected";
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'career/add_careers', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/careers/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                 if( $this->input->post('career_submit')=='update')  {
                     $updateid=$this->input->post('update_id');
                 }else{
                  $updateid='';
                 }
                    
                    
                    $result1 = $this->career_model->addCarrer($leadership_rank, $leadership_award, $qualifying_personal_pv, $qualifying_weaker_leg_bv, $qualifying_terms, $image['file_name'],$updateid);
                    if (!$result1) {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'career/add_careers', FALSE);
                    } else {
                        $msg = lang('careers_added_successfully');
                        $this->redirect($msg, 'career/add_careers', TRUE);
                    }
                }
            }
        }

        if ($action == 'edit') {
            if ($id != '') {
                $edit_det = $this->career_model->getAllCareers($id);
                $this->set("edit_career_details", $edit_det);
            } else {
                $this->redirect($msg, 'career/add_careers', FALSE);
            }
        }
        $det = $this->career_model->getAllCareers();


        $this->set("career_details", $det);

        $this->setView();
    }

}
