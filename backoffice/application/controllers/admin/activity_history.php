<?php

require_once 'Inf_Controller.php';

class activity_history extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function activity_history_view() {
        $title = lang('activity_history');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'user-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('activity_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activity_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $base_url = base_url() . "admin/activity_history/activity_history_view";
        $config['base_url'] = $base_url;
        $config['per_page'] = 30;

        if ($this->uri->segment(4) != "")
            $page = $this->uri->segment(4) / $config['per_page'];
        else
            $page = 0;

        $total_rows = $this->activity_history_model->getActivityHistoryCount();
        $config['total_rows'] = $total_rows;
        $this->pagination->initialize($config);
        $start = $page * $config['per_page'];
        $end = $page * $config['per_page'] + $config['per_page'];
//        $activity_details =array_slice($activity_details,$start,$config['per_page']);
        $activity_details = $this->activity_history_model->getActivityHistory($start,$config['per_page']);
        $this->set('details_count', $total_rows);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        $this->set('start', $start+1);

       $this->set('activity_details', $activity_details);
       $this->setView();
    }

   

}
