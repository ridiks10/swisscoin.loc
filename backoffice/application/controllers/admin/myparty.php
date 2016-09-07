<?php

require_once 'Inf_Controller.php';

class myparty extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function party_portal() {

        $title = lang('my_party_portal');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('my_party_portal');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('my_party_portal');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->set("action_page", $this->CURRENT_URL);

        $help_link = "party_portal";
        $this->set("help_link", $help_link);

        $current_date = strtotime(date('Y-m-d H:i A'));
        $this->myparty_model->closeTimeOutParties($current_date);

        if ($this->input->post('process')) {/////to process order 
            $tot_process_amount = 0;
            $select_process_count = FALSE;
            $process_post_array = $this->input->post();
            $process_post_array = $this->validation_model->stripTagsPostArray($process_post_array);
            $process_post_array = $this->validation_model->escapeStringPostArray($process_post_array);
            $count = $process_post_array['count'];
            $j = 0;
            for ($i = 1; $i < $count; $i++) {
                if ($this->input->post("select" . $i) == "yes") {
                    $select_process_count = TRUE;
                    $party_id = $process_post_array['party_id' . $i];
                    $guest_id = $process_post_array['guest_id' . $i];
                    $total_amount = $process_post_array['total_amount' . $i];
                    $tot_process_amount+=$total_amount;
                    $j++;
                    $res = $this->myparty_model->processOrder($party_id, $guest_id);
                }
            }

            if ($j == 0) {
                $this->redirect('Please Select order', 'myparty/party_portal', FALSE);
            }

            if ($select_process_count == FALSE) {
                $this->redirect('Please Select order', 'myparty/party_portal', FALSE);
            }

            $res = $this->myparty_model->evaluatePartyCommission($this->LOG_USER_ID, $tot_process_amount, $party_id);

            if ($res) {
                $this->redirect('Order Processed', 'myparty/party_portal', TRUE);
            } else {
                $this->redirect('Order Not Processed', 'myparty/party_portal', FALSE);
            }
        }

        $id = $this->LOG_USER_ID;
        $party_available = $this->myparty_model->getAvailableParties($id);
        $this->set('party_available', $party_available);
        $party_id = $this->session->userdata('inf_party_id');
        $guest_data = $this->myparty_model->getInvitedGuestDetails($id, $party_id);
        $this->set('guest_data', $guest_data);
        $selected_party = $this->myparty_model->selectedPartyDetails($party_id);
        $this->set('selected_party', $selected_party);
        $this->set('count', count($selected_party));
        $this->set('party', $party_id);

        $party_url = "http:party_url/party_details.php?pid=$party_id"; ////give exact party url link
        $this->set('party_url', $party_url);

        $pro_order = $this->myparty_model->getProcessedOrders($party_id);
        $this->set('pro_order', $pro_order);
        $unpro_order = $this->myparty_model->getUnprocessedOrders($party_id);
        $this->set('unpro_order', $unpro_order);

        $this->setView();
    }

    public function setSessionPartyId($party_id = '') {    /////////////set 
        //selected party id in session//////////
        $this->session->set_userdata('inf_party_id', $party_id);
        $this->redirect("", "myparty/party_portal", TRUE);
    }

    public function delete_party($id = '') {
/////////////close party//////it will check whether all orders are processed before close a party/////

        $res = $this->myparty_model->checkAllOrdersProcesed($id);
        if ($res == "yes") {
            $this->redirect("You can't close this party until all orders  are processed", "myparty/party_portal", FALSE);
        } else {

            $this->myparty_model->closeParty($id, 'user');
            // $this->myparty_model->evaluateUserRank($this->LOG_USER_NAME);
            $this->session->unset_userdata('inf_party_id');
            $this->redirect("Party Closed", "myparty/party_portal", TRUE);
        }
    }

}

?>
