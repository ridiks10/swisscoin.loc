<?php

require_once 'Inf_Controller.php';

class backup_restore extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function back_up() {
        $title = lang('restore_defaults');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "upload-document";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('restore_defaults');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('restore_defaults');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('restore')) {
            $res = $this->backup_restore_model->restore($this->MLM_PLAN);
            if ($res) {                
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'database restored', $this->LOG_USER_ID);
                $msg = $this->lang->line('restore_done_successfully');
                $this->redirect($msg, "backup_restore/back_up", true);
            } else {
                $msg = $this->lang->line('restore_failed_try_again');
                $this->redirect($msg, "backup_restore/back_up", false);
            }
        }
        if ($this->input->post('backup')) {
            $res = $this->backup_restore_model->backup_tables();
            if ($res) {                
                $msg = $this->lang->line('backup_done_successfully');
                $this->redirect($msg, "backup_restore/back_up", true);
            } else {
                $msg = $this->lang->line('backup_failed_try_again');
                $this->redirect($msg, "backup_restore/back_up", false);
            }
        }
        $this->setView();
    }
}
