<?php

require_once 'Inf_Controller.php';

class Cleanup extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function clean_up() {

        //$title = $this->lang->line('clean_up');
        //$this->set("title", $this->COMPANY_NAME . " | $title");

        //$res = $this->cleanup_model->clean($this->MODULE_STATUS);

        //if ($res) {
        //   $msg = $this->lang->line('Cleanup_done_successfully');
        //    $this->redirect($msg, "home/index", true);
        //} else {
        //    $msg = $this->lang->line('Clean_up_failed_try_again');
        //    $this->redirect($msg, "home/index", false);
        //}
    }
function clean_up_tickets() {
       
        $res = $this->cleanup_model->clean_tickets();
        if ($res) {
            $msg = $this->lang->line('Cleanup_done_successfully');
            $this->redirect($msg, "home/index", TRUE);
        } else {
            $msg = $this->lang->line('Clean_up_failed_try_again');
            $this->redirect($msg, "home/index", FALSE);
        }
    }
}

?>