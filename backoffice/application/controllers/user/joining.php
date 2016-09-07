<?php

require_once 'Inf_Controller.php';

/**
 * @property-read joining_model $joining_model 
 * @property-read joining_class_model $joining_class_model 
 */
class Joining extends Inf_Controller {

    function joining_status() {

        /////////////////////  CODE ADDED BY JIJI  //////////////////////////

        $this->set("action_page", $this->CURRENT_URL);
        $title=$this->lang->line('joining_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        
        $this->load_langauge_scripts();

        $this->load_langauge_scripts();

        $total_count = $this->joining_model->totalJoiningpage();
        $this->set("total_count", $total_count);

        if ($this->input->post('dailydate')) {
            if (!$this->input->post("date")) {
                $date1 = $this->session->userdata('inf_date1');
            } else {
                $date1 = strip_tags($this->input->post("date"));
                $this->session->set_userdata('inf_date1', $date1);
                $this->session->unset_userdata('inf_date2');
            }
        }
        if ($this->input->post('weekdate')) {
            if (!$this->input->post('week_date1') && !$this->input->post('week_date2') && !$this->input->post('plan2')) {
                $from = $this->session->userdata('inf_date1') . " 00:00:00";
                $to = $this->session->userdata('inf_date2') . " 23:59:59";
            } else {
                $from = strip_tags($this->input->post("week_date1"));
                $to = strip_tags($this->input->post("week_date2"));
                $this->session->set_userdata('inf_date1', $from . " 00:00:00");
                $this->session->set_userdata('inf_date2', $to . " 23:59:59");
            }
        }

  ////////////////////////// code for language translation  ///////////////////////////////

        ///////////////////////////////////// pagination //////////////////////////////////////

        $date1 = $this->session->userdata('inf_date1');
        $date2 = $this->session->userdata('inf_date2');
        $this->set("date1", $date1);
        $this->set("date2", $date2);

        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4);
        else
            $page = 0;
        $limit = 25;

        $this->load->model('joining_class_model');
        if ($date1 != "" && $date2 == "") {
            
            $daily_joinings = $this->joining_class_model->getJoinings($date1, null, $page, $limit);
            $this->set("daily_joinings", $daily_joinings);
            $daily_joinings_count = $this->joining_class_model->todaysJoiningCount($date1);

            $config['total_rows'] = $daily_joinings_count;
            $base_url = base_url() . "joining/joining_status";
            $config['base_url'] = $base_url;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $this->set("result_per_page", $result_per_page);
        }
        if ($date1 != "" && $date2 != "") {

            $weekly_joinings = $this->joining_class_model->getJoinings($date1, $date2, $page, $limit);
            $this->set("weekly_joinings", $weekly_joinings);

            $weekly_joinings_count = $this->joining_class_model->allJoiningpage($date1, $date2);
            $config['total_rows'] = $weekly_joinings_count;
            $base_url = base_url() . "joining/joining_status";
            $config['base_url'] = $base_url;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $this->set("result_per_page", $result_per_page);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->setView();
    }

}

?>
