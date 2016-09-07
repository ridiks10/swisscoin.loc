<?php

require_once 'Inf_Controller.php';

class Joining extends Inf_Controller {

    function joining_status() {

        $this->set("action_page", $this->CURRENT_URL);
        $title = lang('joining_status');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->load_langauge_scripts();

        $total_count = $this->joining_model->totalJoiningpage();
        $this->set("total_count", $total_count);
        $daily_joinings = 0;
        $weekly_joinings = 0;
        if (($this->input->post('dailydate')) && $this->validate_daily_joining()) {

            if (!strip_tags($this->input->post("date"))) {
                $date1 = $this->session->userdata('inf_date1');
            } else {
                $date1 = strip_tags($this->input->post("date"));
                $this->session->set_userdata('inf_date1', $date1);
                $this->session->unset_userdata('inf_date2');
            }
        }
        if (($this->input->post('weekdate')) && $this->validate_weekely_joining()) {
            if (!$this->input->post('week_date1') && !$this->input->post('week_date2')) {
                $from = $this->session->userdata('inf_date1') . " 00:00:00";
                $to = $this->session->userdata('inf_date2') . " 23:59:59";
            } else {
                $from = strip_tags($this->input->post("week_date1"));
                $to = strip_tags($this->input->post("week_date2"));
                $this->session->set_userdata('inf_date1', $from . " 00:00:00");
                $this->session->set_userdata('inf_date2', $to . " 23:59:59");
            }
        }
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

        if ($date1 != "" && $date2 == "") {

            $daily_joinings = $this->joining_model->todaysJoining($this->session->userdata('inf_date1'), $page, $limit);
            $daily_joinings_count = $this->joining_model->todaysJoiningCount($this->session->userdata('inf_date1'));
            $config['total_rows'] = $daily_joinings_count;
            $base_url = base_url() . "joining/joining_status";
            $config['base_url'] = $base_url;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();
            $this->set("result_per_page", $result_per_page);
        }
        if ($date1 != "" && $date2 != "") {

            $weekly_joinings = $this->joining_model->weeklyJoining($date1, $date2, $page, $limit);
            $weekly_joinings_count = $this->joining_model->allJoiningpage($date1, $date2);
            $config['total_rows'] = $weekly_joinings_count;
            $base_url = base_url() . "joining/joining_status";
            $config['base_url'] = $base_url;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);
            $result_per_page = $this->pagination->create_links();

            $this->set("result_per_page", $result_per_page);
        }
        $this->set("daily_joinings", $daily_joinings);
        $this->set("weekly_joinings", $weekly_joinings);

        $this->setView();
    }

    function validate_daily_joining() {
        // ;)
        if ($this->input->post('dailydate')) {
            $date1 = strip_tags($this->input->post("date"));
            if (empty($date1)) {
                $msg = lang('pls_select_joining_date');
                $this->redirect($msg, "joining/joining_status", FALSE);
            } else {
                return TRUE;
            }
        }
    }

    function validate_weekely_joining() {
        if ($this->input->post('weekdate')) {
            $from = strip_tags($this->input->post("week_date1"));
            $to = strip_tags($this->input->post("week_date2"));
            if (empty($from)) {
                $msg = lang('plese_select_from_date');
                $this->redirect($msg, "joining/joining_status", FALSE);
            } else if (empty($to)) {
                $msg = lang('plese_select_to_date');
                $this->redirect($msg, "joining/joining_status", FALSE);
            } else {
                return TRUE;
            }
        }
    }

}

?>