<?php

require_once 'Inf_Controller.php';

/**
 * @property-read news_model $news_model
 */
class News extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function add_news($action = '', $news_id = '') {
        //$title = $this->lang->line('add_news_and_events');
        $title = $this->lang->line('info/news');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "news-management";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('info/news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/news');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set("edit_id", null);
        $this->set("news_id", null);
        $this->set("news_title", null);
        $this->set("news_desc", null);
        $this->set("news_date", null);
        if ($action == "edit") {
            $row = $this->news_model->editNews($news_id);
            $this->set("edit_id", $news_id);
            $this->set("news_id", $row['news_id']);
            $this->set("news_title", $row['news_title']);
            $this->set("news_desc", $row['news_desc']);
            $this->set("news_date", $row['news_date']);
        }
        $msg = "";
        if ($action == "delete") {  
            $result = $this->news_model->deleteNews($news_id);
            if ($result) {
                $data_array['news_id'] = $news_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news deleted', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('news_deleted_successfully');
                $this->redirect($msg, "news/add_news", TRUE);
            } else {
                $msg = $this->lang->line('error_on_deleting_news');
                $this->redirect($msg, "news/add_news", FALSE);
            }
        }
        if ($this->input->post('news_submit') && $this->validate_add_news()) {
             $image['file_name'] = "";
             $news_title = $this->input->post('news_title');
             $news_desc = $this->input->post('news_desc');
             $link = $this->input->post('link');
             
             //$result1 = $this->news_model->addNews($news_title, $news_desc);
             //$file_title = $this->input->post('file_title');
            
              if ($_FILES['userfile']['error'] != 4) {

                //$user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/news/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = "Image not selected";
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'news/add_news', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/news/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }

                    
                    if ($image['file_name']=="") {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'news/add_news', FALSE);
                    }
                }
            }
       
            $result1 = $this->news_model->addNews($news_title, $news_desc,$image['file_name'],$link);
            if ($result1) {
                $data_array['news_title'] = $news_title;
                $data_array['news_description'] = $news_desc;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news added', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('news_added_successfully');
                $this->redirect($msg, "news/add_news", TRUE);
            } else {
                $msg = $this->lang->line('error_on_adding_news');
                $this->redirect($msg, "news/add_news", FALSE);
            }
            
        }
        if ($this->input->post('news_update') && $this->validate_add_news(true)) {
            $image['file_name'] = "";
            $news_id1 = $this->input->post('news_id');
            $news_title1 = $this->input->post('news_title');
            $news_desc1 = $this->input->post('news_desc');
                if ($_FILES['userfile']['error'] != 4) {

                
                $config['upload_path'] = './public_html/images/news/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = "Image not selected";
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'news/add_news', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/news/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }

                    
                    if ($image['file_name']=="") {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'news/add_news', FALSE);
                    }
                }
            }
           $result2 = $this->news_model->updateNews($news_id1, $news_title1, $news_desc1,$image['file_name']);
            if ($result2) {
                $data_array['news_title'] = $news_title1;
                $data_array['news_description'] = $news_desc1;
                $data_array['news_id'] = $news_id1;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'news updated', $this->LOG_USER_ID, $data);
                $msg = $this->lang->line('news_updated_successfully');
                $this->redirect($msg, "news/add_news", TRUE);
            } else {
                $msg = $this->lang->line('error_on_updating_news');
                $this->redirect($msg, "news/add_news", FALSE);
            }
        }
        $news_details = $this->news_model->getAllNews();
        $this->set("news_details", $news_details);
        $this->set("arr_count", count($news_details));
        $this->setView();
    }

    function validate_add_news($id) {
        $this->form_validation->set_rules('news_title', lang('news_title'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('news_desc', lang('news_description'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('news_id', lang('news_id'), 'trim|required|strip_tags|numeric');
//      $this->form_validation->set_rules('link', 'link', 'trim|callback_valid_url');
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
            $result = $this->news_model->deleteDocument($delete_id);
            if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'upload material deleted', $this->LOG_USER_ID, $data);
                $msg = lang('Material_Deleted_Successfully');
                $this->redirect($msg, "news/upload_materials", TRUE);
            } else {
                $msg = lang('Error_On_Deleting_Material');
                $this->redirect($msg, "news/upload_materials", FALSE);
            }
        }
        if ($this->input->post('upload_submit') && $this->validate_upload_materials()) {
            $file_title = $this->input->post('file_title');
            $file_name = 'upload_doc';
            $config['upload_path'] = './public_html/images/document/';
            $config['allowed_types'] = 'pdf|ppt|docs|xls|xlsx|doc|jpg|jpeg|png';
            $config['max_size'] = '2048';
//            $config['max_width'] = '3000';
//            $config['max_height'] = '3000';
            $this->load->library('upload', $config);
            $result = '';
            if ($this->upload->do_upload($file_name)) {
                $data = array('upload_data' => $this->upload->data());
                $doc_file_name = $data['upload_data']['file_name'];
                $result = $this->news_model->addDocuments($file_title, $doc_file_name);
            }
//            else{
//                $error =$this->upload->display_errors();
//                print_r($error);die();
//            }
            if ($result) {
                $data_array['file_title'] = $file_title;
                $data_array['file_name'] = $doc_file_name;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'material uploaded', $this->LOG_USER_ID, $data);
                $msg = lang('File_Uploaded_Successfully');
                $this->redirect($msg, "news/upload_materials", TRUE);
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
                $this->redirect($msg, "news/upload_materials", FALSE);
            }
        }
        $file_details = $this->news_model->getAllDocuments();
        $this->set("file_details", $file_details);
        $this->set("arr_count", count($file_details));
        $this->setView();
    }

    public function validate_upload_materials() {
        $this->form_validation->set_rules('file_title', lang('File_Title'), 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function view_newsletter($action = '', $edit_id = '') {
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

        $this->ARR_SCRIPT[4]["name"] = "validate_news.js";
        $this->ARR_SCRIPT[4]["type"] = "js";
        $this->ARR_SCRIPT[4]["loc"] = "footer";

        $this->load_langauge_scripts();

        $this->HEADER_LANG['page_top_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_subscribers');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "news-management";
        $this->set("help_link", $help_link);

        $this->set("edit_id", null);
        $this->set("news_id", null);
        $this->set("news_title", null);
        $this->set("news_desc", null);
        $this->set("news_date", null);
        $delete_id = $edit_id;
        $msg = "";
        if ($action == "delete") {
            $result = $this->news_model->deleteNewsLetter($delete_id);
            if ($result) {
                $msg = 'News Letter Deleted Successfully';
                $this->redirect($msg, "news/view_newsletter", TRUE);
            } else {
                $msg = 'Error on Deleting News Letter';
                $this->redirect($msg, "news/view_newsletter", FALSE);
            }
        }
        $user_id = $this->LOG_USER_ID;
        $news_details = $this->news_model->getAllNewsLetters($user_id);
        $this->set("news_details", $news_details);
        $this->set("arr_count", count($news_details));
        $this->setView();
    }

    function send_newsletter() {

        $title = lang('send_newsletter');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[4]["name"] = "validate_news.js";
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
                $user_id_avail = $this->news_model->checkMailId($email_id, $owner_id);
                if (!$user_id_avail) {
                    $msg = "Submitted E-Mail is not Subscribed";
                    $this->redirect($msg, "news/send_newsletter", FALSE);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $res = $this->news_model->sendNewsLetterToSubscribers($email_id, $subject, $message);
                }
            } else if ($mail_status == 'all') {
                $email_exp = $this->news_model->getAllNewsLettersMailId($owner_id);
                for ($i = 0; $i < count($email_exp); $i++) {
                    $email_id = $email_exp[$i];
                    $res = $this->news_model->sendNewsLetterToSubscribers($email_id, $subject, $message);
                }
            }
            if ($res) {
                if ($mail_status == 'all')
                    $this->news_model->insertNewsletterHistory('All', $subject, $message, $owner_id);
                if ($mail_status != 'all')
                    $this->news_model->insertNewsletterHistory($email_id, $subject, $message, $owner_id);
                $msg = "Newletter Send Successfully";
                $this->redirect($msg, "news/send_newsletter", TRUE);
            } else {
                $msg = "Newsletter Sending Failed";
                $this->redirect($msg, "news/send_newsletter", FALSE);
            }
        }
        $this->HEADER_LANG['page_top_header'] = lang('send_newsletter');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('send_newsletter');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $help_link = "mail-management";
        $this->set("help_link", $help_link);
        $this->setView();
    }
    function view_news($action = '', $id = '') {
        $title = lang('view_news');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $help_link = "view_news";
        $this->set("help_link", $help_link);
        $this->load_langauge_scripts();
        
        $this->HEADER_LANG['page_top_header'] = lang('view_news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_news');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();  
        if($action=="view"){
           $det = $this->news_model->getNewsDetails($id); 
           $this->set("details", $det);
        }
        $this->setView();
    }

}
