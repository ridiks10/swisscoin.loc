<?php

require_once 'Inf_Controller.php';

class Epin extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function request_epin() {

        $title = lang('request_e_pin');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "request-pin";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('request_e_pin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('request_e_pin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        $amount_details = $this->epin_model->getAllEwalletAmounts();
        $this->set("amount_details", $amount_details);

        $success = lang('pin_request_send_successfully');
        $error = lang('error_on_pin_request');

        if ($this->input->post('reqpasscode') && $this->validate_request_epin()) {
            $request_date = date('Y-m-d H:i:s');
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $cnt = $post_arr['count'];
            $pin_amount = $post_arr['amount1'];
            $expiry_date = date('Y-m-d', strtotime('+6 months'));  //pin valid for 6 months
            $req_user = $this->LOG_USER_ID;
            $res = $this->epin_model->insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount);
            if ($res) {
                $loggin_id = $this->LOG_USER_ID;
                $admin_id = $this->ADMIN_USER_ID;
                $this->validation_model->insertUserActivity($loggin_id, 'epin requested',$admin_id );
                $this->redirect($success, "epin/request_epin", TRUE);
            } else {
                $this->redirect($error, "epin/request_epin", FALSE);
            }
        }
        if ($pro_status == "yes") {
            $produc_details = $this->epin_model->getAllProducts('yes');
            $this->set("produc_details", $produc_details);
        }
        $this->set("pro_status", $pro_status);

        $this->setView();
    }

    function validate_request_epin() {
        if (!$this->input->post('amount1')) {
            $msg = lang('you_must_select_an_amount');
            $this->redirect($msg, "epin/request_epin", FALSE);
        } else if (!$this->input->post('count')) {
            $msg1 = lang('you_must_enter_count');
            $this->redirect($msg1, "epin/request_epin", FALSE);
        }
        $this->form_validation->set_rules('amount1', 'Amount', 'trim|required|strip_tags');
        $this->form_validation->set_rules('count', 'Count', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function my_epin($page = "", $limit = "") {

        $title = lang('my_e_pin');
        $this->set("title", $this->COMPANY_NAME . " | $title ");

        $help_link = "view-my-pin";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('my_e_pin');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('my_e_pin');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $pro_status = $this->MODULE_STATUS['product_status'];
        $pin_count = $this->epin_model->getUserFreePinCount();

        $config['total_rows'] = $pin_count;
        $base_url = base_url() . "user/epin/my_epin";
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;
        $page = 0;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        }

        $pin_details = $this->epin_model->pinSelector($page, $config['per_page'], "generate");
        $this->set('start_id', $page);
        $this->pagination->initialize($config);
        $page_footer = $this->pagination->create_links();
        $pin_numbers = $pin_details["pin_numbers"];

        $this->set("pin_numbers", $pin_numbers);
        $this->set("page_footer", $page_footer);
        $this->set("pro_status", $pro_status);
        $this->load_langauge_scripts();
        $this->setView();
    }

}

?>
