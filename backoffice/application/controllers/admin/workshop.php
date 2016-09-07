<?php

require_once 'Inf_Controller.php';

/**
 * @property-read workshop_model $workshop_model 
 */
class Workshop extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function add_workshop($action = '', $workshop_id = '') {
        //$title = $this->lang->line('add_workshop_and_events');
        $title = $this->lang->line('info/workshop');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "workshop-management";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('info/workshop');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/workshop');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set("edit_id", null);
        $this->set("workshop_id", null);
        $this->set("workshop_title", null);
       // $this->set("workshop_desc", null);
        $this->set("workshop_date", null);
        if ($action == "edit") {
            $row = $this->workshop_model->editWorkshop($workshop_id);
            $this->set("edit_id", $workshop_id);
            $this->set("workshop_id", $row['workshop_id']);
            $this->set("workshop_title", $row['workshop_title']);
           // $this->set("workshop_desc", $row['workshop_desc']);
            $this->set("workshop_date", $row['workshop_date']);
        }
        $msg = "";
        if ($action == "delete") {
            $result = $this->workshop_model->deleteWorkshop($workshop_id);
            if ($result) {
                $data_array['workshop_id'] = $workshop_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'workshop deleted', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('workshop_deleted_successfully');
                $this->redirect($msg, "workshop/add_workshop", TRUE);
            } else {
                $msg = $this->lang->line('error_on_deleting_workshop');
                $this->redirect($msg, "workshop/add_workshop", FALSE);
            }
        }
        if ($this->input->post('workshop_submit') && $this->validate_add_workshop()) {
             $image['file_name'] = "";
             $workshop_title = $this->input->post('workshop_title');
            // $workshop_desc = $this->input->post('workshop_desc');
             $link = $this->input->post('link');
             
             //$result1 = $this->workshop_model->addWorkshop($workshop_title, $workshop_desc);
             //$file_title = $this->input->post('file_title');
            
              if ($_FILES['userfile']['error'] != 4) {

                //$user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/workshop/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = "Image not selected";
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'workshop/add_workshop', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/workshop/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }

                    
                    if ($image['file_name']=="") {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'workshop/add_workshop', FALSE);
                    }
                }
            }
       
            $result1 = $this->workshop_model->addWorkshop($workshop_title, $image['file_name'],$link);
            if ($result1) {
                $data_array['workshop_title'] = $workshop_title;
               // $data_array['workshop_description'] = $workshop_desc;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'workshop added', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('workshop_added_successfully');
                $this->redirect($msg, "workshop/add_workshop", TRUE);
            } else {
                $msg = $this->lang->line('error_on_adding_workshop');
                $this->redirect($msg, "workshop/add_workshop", FALSE);
            }
            
        }
        if ($this->input->post('workshop_update') && $this->validate_add_workshop()) {
            $image['file_name'] = "";
            $workshop_id1 = strip_tags($this->input->post('workshop_id'));
            $workshop_title1 = $this->input->post('workshop_title');
            $workshop_link1 = $this->input->post('link');
           // $workshop_desc1 = strip_tags($this->input->post('workshop_desc'));
                if ($_FILES['userfile']['error'] != 4) {

                //$user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/workshop/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '6000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = "Image not selected";
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'workshop/add_workshop', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/workshop/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                    $result = $this->workshop_model->updateWorkshopImage($workshop_id1,$image['file_name']);
                    
                    if ($image['file_name']=="") {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'workshop/add_workshop', FALSE);
                    }
                }
            }
           $result2 = $this->workshop_model->updateWorkshop($workshop_id1, $workshop_title1, $workshop_link1);
            if ($result2) {
                $data_array['workshop_title'] = $workshop_title1;
               // $data_array['workshop_description'] = $workshop_desc1;
                $data_array['workshop_id'] = $workshop_id1;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'workshop updated', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('workshop_updated_successfully');
                $this->redirect($msg, "workshop/add_workshop", TRUE);
            } else {
                $msg = $this->lang->line('error_on_updating_workshop');
                $this->redirect($msg, "workshop/add_workshop", FALSE);
            }
        }
        $workshop_details = $this->workshop_model->getAllWorkshop();
        $this->set("workshop_details", $workshop_details);
        $this->set("arr_count", count($workshop_details));
        $this->setView();
    }

    function validate_add_workshop() {
        $this->form_validation->set_rules('workshop_title', lang('workshop_title'), 'trim|required|strip_tags');
       $this->form_validation->set_rules('link', 'Link', 'trim|callback_valid_url');
        
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
   public function valid_url($str)
      {
          return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
      }
    function upload_materials($action = '', $delete_id = '') {
//        $title = lang('Upload_Materials');
        $title = lang('information_center');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('information_center');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('information_center');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($action == "delete") {
            $result = $this->workshop_model->deleteDocument($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'upload material deleted', $this->LOG_USER_ID, $data);
                $msg = lang('Material_Deleted_Successfully');
                $this->redirect($msg, "workshop/upload_materials", TRUE);
            } else {
                $msg = lang('Error_On_Deleting_Material');
                $this->redirect($msg, "workshop/upload_materials", FALSE);
            }
        }
        if ($this->input->post('upload_submit') && $this->validate_upload_materials()) {
            $file_title = $this->input->post('file_title');
            $file_name = 'upload_doc';
            $config['upload_path'] = './public_html/images/document/';
            $config['allowed_types'] = 'pdf|ppt|docs|xls|xlsx|doc|jpg|jpeg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '3000';
            $config['max_height'] = '3000';
            $this->load->library('upload', $config);
            $result = '';
            if ($this->upload->do_upload($file_name)) {
                $data = array('upload_data' => $this->upload->data());
                $doc_file_name = $data['upload_data']['file_name'];
                $result = $this->workshop_model->addDocuments($file_title, $doc_file_name);
            }
            if ($result) {
                $data_array['file_title'] = $file_title;
                $data_array['file_name'] = $doc_file_name;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'material uploaded', $this->LOG_USER_ID, $data);
                $msg = lang('File_Uploaded_Successfully');
                $this->redirect($msg, "workshop/upload_materials", TRUE);
            } else {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                } else if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_2MB');
                } else if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('filetype_not_allowed');
                } else {
                    $msg = lang('error_uploading_file');
                }
                $this->redirect($msg, "workshop/upload_materials", FALSE);
            }
        }
        $file_details = $this->workshop_model->getAllDocuments();
        $this->set("file_details", $file_details);
        $this->set("arr_count", count($file_details));
        $this->setView();
    }

    public function validate_upload_materials() {
        $this->form_validation->set_rules('file_title', lang('File_Title'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function view_workshopletter($action = '', $edit_id = '') {
        $title = lang('view_subscribers');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[1]["name"] = "ckeditor/ckeditor.js";
        $this->ARR_SCRIPT[1]["type"] = "plugins/js";
        $this->ARR_SCRIPT[1]["loc"] = "footer";

        $this->ARR_SCRIPT[2]["name"] = "ckeditor/adapters/jquery.js";
        $this->ARR_SCRIPT[2]["type"] = "plugins/js";
        $this->ARR_SCRIPT[2]["loc"] = "footer";

        $this->ARR_SCRIPT[3]["name"] = "ckeditor/contents.css";
        $this->ARR_SCRIPT[3]["type"] = "plugins/css";
        $this->ARR_SCRIPT[3]["loc"] = "header";

        $this->ARR_SCRIPT[4]["name"] = "validate_workshop.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        $this->ARR_SCRIPT[4]["loc"] = "footer";

        $this->load_langauge_scripts();

        $this->HEADER_LANG['page_top_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "workshop-management";
        $this->set("help_link", $help_link);

        $this->set("edit_id", null);
        $this->set("workshop_id", null);
        $this->set("workshop_title", null);
       // $this->set("workshop_desc", null);
        $this->set("workshop_date", null);
        $delete_id = $edit_id;
        $msg = "";
        if ($action == "delete") {
            $result = $this->workshop_model->deleteWorkshopLetter($delete_id);
            if ($result) {
                $msg = 'Workshop Letter Deleted Successfully';
                $this->redirect($msg, "workshop/view_workshopletter", TRUE);
            } else {
                $msg = 'Error on Deleting Workshop Letter';
                $this->redirect($msg, "workshop/view_workshopletter", FALSE);
            }
        }
        $user_id = $this->LOG_USER_ID;
        $workshop_details = $this->workshop_model->getAllWorkshopLetters($user_id);
        $this->set("workshop_details", $workshop_details);
        $this->set("arr_count", count($workshop_details));
        $this->setView();
    }

    function send_workshopletter() {

        $title = lang('send_workshopletter');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[4]["name"] = "validate_workshop.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        $this->ARR_SCRIPT[4]["loc"] = "footer";

        $this->ARR_SCRIPT[5]["name"] = "custom.js";
        $this->ARR_SCRIPT[5]["type"] = "js";
        $this->ARR_SCRIPT[5]["loc"] = "header";

        $this->ARR_SCRIPT[6]["name"] = "style-popup.css";
        $this->ARR_SCRIPT[6]["type"] = "css";
        $this->ARR_SCRIPT[6]["loc"] = "header";

        $this->ARR_SCRIPT[7]["name"] = "website.css";
        $this->ARR_SCRIPT[7]["type"] = "css";
        $this->ARR_SCRIPT[7]["loc"] = "header";

        $this->ARR_SCRIPT[9]["name"] = "ajax-dynamic-list.js";
        $this->ARR_SCRIPT[9]["type"] = "js";
        $this->ARR_SCRIPT[9]["loc"] = "header";

        $this->ARR_SCRIPT[11]["name"] = "MailBox.js";
        $this->ARR_SCRIPT[11]["type"] = "js";
        $this->ARR_SCRIPT[11]["loc"] = "header";

        $this->ARR_SCRIPT[12]["name"] = "autoComplete.css";
        $this->ARR_SCRIPT[12]["type"] = "css";
        $this->ARR_SCRIPT[12]["loc"] = "header";

        $this->ARR_SCRIPT[13]["name"] = "ajax.js";
        $this->ARR_SCRIPT[13]["type"] = "js";
        $this->ARR_SCRIPT[13]["loc"] = "header";


        $this->load_langauge_scripts();
        $this->set("reply", $this->lang->line('reply'));

        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $date = date('Y-m-d H:i:s');
        $owner_id = $this->LOG_USER_ID;
        if ($this->input->post('adminsend')) {
            $send_post_array = $this->input->post();
            $send_post_array = $this->validation_model->stripTagsPostArray($send_post_array);
            $send_post_array = $this->validation_model->escapeStringPostArray($send_post_array);
            $send_post_array['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $mail_status = $send_post_array['mail_status'];
            $subject = $send_post_array['subject'];
            $message = $send_post_array['message'];
            if ($mail_status == 'single') {
                $msg = "";
                $email_id = $send_post_array['email_id'];
                $user_id_avail = $this->workshop_model->checkMailId($email_id, $owner_id);
                if (!$user_id_avail) {
                    $msg = "Submitted E-Mail is not Subscribed";
                    $this->redirect($msg, "workshop/send_workshopletter", FALSE);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $res = $this->workshop_model->sendWorkshopLetterToSubscribers($email_id, $subject, $message);
                }
            } else if ($mail_status == 'all') {
                $email_exp = $this->workshop_model->getAllWorkshopLettersMailId($owner_id);
                for ($i = 0; $i < count($email_exp); $i++) {
                    $email_id = $email_exp[$i];
                    $res = $this->workshop_model->sendWorkshopLetterToSubscribers($email_id, $subject, $message);
                }
            }
            if ($res) {
                if ($mail_status == 'all')
                    $this->workshop_model->insertWorkshopletterHistory('All', $subject, $message, $owner_id);
                if ($mail_status != 'all')
                    $this->workshop_model->insertWorkshopletterHistory($email_id, $subject, $message, $owner_id);
                $msg = "Newletter Send Successfully";
                $this->redirect($msg, "workshop/send_workshopletter", TRUE);
            } else {
                $msg = "Workshopletter Sending Failed";
                $this->redirect($msg, "workshop/send_workshopletter", FALSE);
            }
        }
        $this->HEADER_LANG['page_top_header'] = lang('send_workshopletter');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('send_workshopletter');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $help_link = "mail-management";
        $this->set("help_link", $help_link);
        $this->setView();
    }
    function view_workshop($action = '', $id = '') {
        $title ='Workshop';
        $this->set("title", $this->COMPANY_NAME . " | Workshop");
        $help_link = "view_workshop";
        $this->set("help_link", $help_link);
        $this->load_langauge_scripts();
        
        $this->HEADER_LANG['page_top_header'] = 'Workshop';
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = 'Workshop';
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();  
        if($action=="view"){
           $det = $this->workshop_model->getWorkshopDetails($id); 
           $this->set("details", $det);
        }
        $this->setView();
    }

}