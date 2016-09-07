<?php

require_once 'Inf_Controller.php';

class payment extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    //========================edited by Deepthy ====================//
    function payment_view() {

        $title = $this->lang->line('payment_view');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->ARR_SCRIPT[1]["name"] = "DataTables/media/js/DT_bootstrap.js";
        $this->ARR_SCRIPT[1]["type"] = "plugins/js";
        $this->ARR_SCRIPT[1]["loc"] = "footer";

        $this->ARR_SCRIPT[2]["name"] = "table-data.js";
        $this->ARR_SCRIPT[2]["type"] = "js";
        $this->ARR_SCRIPT[2]["loc"] = "footer";

        $this->ARR_SCRIPT[3]["name"] = "DataTables/media/js/jquery.dataTables.min.js";
        $this->ARR_SCRIPT[3]["type"] = "plugins/js";
        $this->ARR_SCRIPT[3]["loc"] = "footer";

        $this->load_langauge_scripts();

        $module_status = $this->payment_model->getModuleStatus();
        $this->set("module_status", $module_status);

        $details = $this->payment_model->getStatus();
        $this->set("details", $details);
        $i = 0;
        $post_arr = array();
        $post_arr = $this->input->post();
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
        for ($i = 0; $i < 4; $i++) {
            $id = $this->input->post('payment_type_id' . $i);
            $current_status = $post_arr['status' . $i];
            if ($this->input->post("activate$i")) {
                if (array_key_exists("activate$i", $post_arr)) {

                    $res = $this->payment_model->updatePaymentMethod($id, $current_status);
                    if ($res) {
                        $msg = $this->lang->line('Successfully_Completed');
                        $this->redirect($msg, "payment/payment_view", TRUE);
                    } else {
                        $msg = $this->lang->line('Action_Failed');
                        $this->redirect($msg, "payment/payment_view", FALSE);
                    }
                }
            } else if ($this->input->post("inactivate$i")) {
                if (array_key_exists("inactivate$i", $post_arr)) {
                    $res = $this->payment_model->updatePaymentMethod($id, $current_status);
                    if ($res) {
                        $msg = $this->lang->line('Successfully_Completed');
                        $this->redirect($msg, "payment/payment_view", TRUE);
                    } else {
                        $msg = $this->lang->line('Action_Failed');
                        $this->redirect($msg, "payment/payment_view", FALSE);
                    }
                }
            }
        }

        ////////////////////////// code for language translation  //////////////////////////

        $this->set("tran_payment", $this->lang->line('payment'));
        $this->set("tran_enable", $this->lang->line('enable'));
        $this->set("tran_disable", $this->lang->line('disable'));
        $this->set("tran_status", $this->lang->line('status'));
        $this->set("tran_payment_method", $this->lang->line('payment_method'));
        $this->set("tran_action", $this->lang->line('action'));
        $this->set("page_top_header", $this->lang->line('payment'));
        $this->set("page_top_small_header", "");
        $this->set("page_header", $this->lang->line('payment'));
        $this->set("page_small_header", "");
        $this->set("tran_Successfully_Completed", $this->lang->line('Successfully_Completed'));
        $this->set("tran_Action_Failed", $this->lang->line('Action_Failed'));

        ////////////////////////////////////////////////////////////////////////////////////

        $this->setView();
    }

    //=======================code ends Deepthy==================//
}

?>
