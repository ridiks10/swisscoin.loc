<?php

require_once 'Inf_Controller.php';

/**
 * @property sms_model $sms_model 
 */
class Sms extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    public function send_sms() {

        $title = lang('upload_excel_files');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'send-sms';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('upload_excel_files');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upload_excel_files');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $select = $this->sms_model->echoAllUserSms('Select', 'Select User');
        $first_id = $this->sms_model->echoAllUserSms('Selectfirstid', 'First id');
        $last_id = $this->sms_model->echoAllUserSms('Selectlastid', 'Last id');

        $this->set('select', $select);
        $this->set('first_id', $first_id);
        $this->set('last_id', $last_id);
        if ($this->input->post('upload'))
            $this->set('upload', '1');
        else
            $this->set('upload', '0');
        $this->setView();
    }

    /**
     * @deprecated since version 1.21
     */
    function find_number()
    {
        log_message('error', 'sms->find_number() :: Deprecated call');
        $id = strip_tags($this->input->post('id'));
        if ($id == "Select")
            echo "Select a user...";
        else
            echo $this->sms_model->echoSingleNumber($id);
    }

    /**
     * @deprecated since version 1.21
     */
    function find_numbers() {
        log_message('error', 'sms->find_numbers() :: Deprecated call');
        $from = strip_tags($this->input->post('from'));
        $to = strip_tags($this->input->post('to'));
        if ($to == "Selectlastid" or $from == "Selectfirstid")
            echo "Select first and last ids...";
        else {
            if ($to < $from) {
                $tmp = $from;
                $from = $to;
                $to = $tmp;
            }
            echo $this->sms_model->echoAllNumber($from, $to);
        }
    }

    function ajax_sms() {

        if ($this->sms_model->checkSMSStatus()) {
            if ($this->input->post('numbers') != "All Numbers")
                $numbers = addslashes($this->input->post('numbers'));
            else {
                $no = $this->sms_model->getAllNumbers();
                $numbers = substr($no, 0, (strlen($no) - 1));
            }
            $message = $this->input->post('word_count');
            $sms_count = $this->input->post('sms_count');
            $sms = "404";
            $this->sms_model->phone_no_arr = $numbers;
            $this->sms_model->sms_msg = $message;
            $this->sms_model->setSMSAPI();
            $sms = $this->sms_model->sendSMS(); //$sms="";
            $res = $this->sms_model->insertsmsDeatails($numbers, $this->sms_model->sms_msg, $sms_count, $sms);
            echo $sms;
        }
    }

    function sms_balance() {
        $title = lang('sms_balance');
        $this->set("title", $this->COMPANY_NAME . ' | '.$title);
        
        $help_link = 'sms-details';
        $this->set('help_link', $help_link);
        
        $this->HEADER_LANG['page_top_header'] = lang('sms_balance');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sms_balance');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        
        $balance = '';
        $this->set("balance", $balance);
        
        $this->setView();
    }
}

?>