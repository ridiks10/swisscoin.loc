<?php

require_once 'Inf_Controller.php';

class feedback extends Inf_Controller {

    function __construct() {
	parent::__construct();
    }

    function feedback_view($action = '', $delete_id = '') {
	$title = $this->lang->line('feedback_view');
	$this->set("title", $this->COMPANY_NAME . " | $title");

	$help_link = "feedback";
	$this->set("help_link", $help_link);

	$this->HEADER_LANG['page_top_header'] = lang('feedback_view');
	$this->HEADER_LANG['page_top_small_header'] = '';
	$this->HEADER_LANG['page_header'] = lang('feedback_view');
	$this->HEADER_LANG['page_small_header'] = '';
	
	$this->load_langauge_scripts();
	$msg = "";
	if ($action == "delete") {
	    $result = $this->feedback_model->deleteFeedback($delete_id);
	    if ($result) {
                $data_array['delete_id'] = $delete_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'feedback deleted', $this->LOG_USER_ID, $data);
		$msg = lang('feedback_deleted_successfully');
		$this->redirect($msg, "feedback/feedback_view", TRUE);
	    } else {
		$msg = lang('error_on_deleting_feedback');
		$this->redirect($msg, "feedback/feedback_view", FALSE);
	    }
	}
	$feedback = $this->feedback_model->getAllfeedback();
	$this->set("feedback", $feedback);

	$this->setView();
    }

}