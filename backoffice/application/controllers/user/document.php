<?php

require_once 'Inf_Controller.php';

class Document extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function show_document() {
        $title = lang('information_center');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('show_document');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('show_document');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $file_details = $this->document_model->getAllDocuments();
        $this->set("file_details", $file_details);
        $this->set("file_details_count", count($file_details));
        $help_link = "show_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }

////////////Code added By Sreelakshmi////////////////////
    function download_document() {
        $title = lang('information_center');
        $this->set('action_page', $this->CURRENT_URL);
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load_langauge_scripts();
        $this->HEADER_LANG['page_top_header'] = lang('information_center');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('information_center');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        $file_details = $this->document_model->getAllDocuments();
        $this->set("file_details", $file_details);
        $this->set("arr_count", count($file_details));
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }
    function view_document($action='',$id='') {
        $title = lang('info/news');
        $this->set('action_page', $this->CURRENT_URL);
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->load_langauge_scripts();
        $this->HEADER_LANG['page_top_header'] = lang('info/news');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('info/news');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        if($action == "view"){
        $file_details = $this->document_model->getDocumentsDetails($id);
        }
        $this->set("file_details", $file_details);
        $this->set("arr_count", count($file_details));
        $help_link = "downlaod_document";
        $this->set("help_link", $help_link);
        $this->setView();
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
}
