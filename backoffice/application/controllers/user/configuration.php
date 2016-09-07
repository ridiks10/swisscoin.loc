<?php

require_once 'Inf_Controller.php';

class Configuration extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function my_referal() {
        $title = $this->lang->line('view_my_refferals');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $help_link = "view-my-referrals";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_my_refferals');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $res = array();
        $user_id = $this->LOG_USER_ID;

        /*         * *pagination**** */

        $basurl = base_url() . "user/configuration/my_referal";
        $config['base_url'] = $basurl;
        $config['per_page'] = 100;

        $total_rows = $this->configuration_model->getReferalDetailscount($user_id);
        $config['total_rows'] = $total_rows;
        $config["uri_segment"] = 4;

        $config['num_links'] = 5;
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $res = $this->configuration_model->getReferalDetails($user_id, $config['per_page'], $page);

        $this->set("arr", $res);
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $count = count($res);
        $this->set("count", $count);

        $this->setView();
    }

    function getUsernamePrefix() {
        $prefix = $this->configuration_model->getUsernamePrefix();
        if ($prefix != "") {
            echo $prefix;
        }
        exit();
    }

    function opencart() {
        $table_prefix = str_replace("_", "", $this->table_prefix);
        $store_url = "../../../store/?id=$table_prefix";
        if (DEMO_STATUS == "no") {
            $store_url = "../../../store";
        }
        header("location:$store_url");
    }

}

?>
