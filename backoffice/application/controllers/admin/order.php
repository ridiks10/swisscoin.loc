<?php

require_once 'Inf_Controller.php';

class order extends Inf_Controller {

    function order_history() {
        $title = lang('order_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);
        $this->set('action_page', $this->CURRENT_URL);

        $order_details = array();
        $shipping_details = array();
        $user_name = '';
        $customer_id = '';

        $base_url = base_url() . "admin/order/order_history";
        $config['base_url'] = $base_url;
        $config['per_page'] = 10;
        $page = 0;
        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(4);
        } else {
            $page = 0;
        }

        if ($this->input->post('view_order')) {
            $order_post_array = $this->input->post();
            $order_post_array = $this->validation_model->stripTagsPostArray($order_post_array);
            $order_post_array = $this->validation_model->escapeStringPostArray($order_post_array);
            $user_name = $order_post_array['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_exist = $this->validation_model->isUserAvailable($user_id);

            if (!$is_exist) {
                $msg = lang('user_name_does_not_exist');
                $this->redirect($msg, "order/order_history", FALSE);
            }
            $customer_id = $this->validation_model->getOcCustomerId($user_id);
            $page = 0;
        }

        $this->set("page", $page);
        $total_count = $this->order_model->getOrderHistoryCount($customer_id);

        $config['total_rows'] = $total_count;
        $this->pagination->initialize($config);

        $order_details = $this->order_model->getOrderDetails($page, $config['per_page'], $customer_id);
      
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);

        $count = count($order_details);
        $this->set("count", $count);
        $this->set("order_details", $order_details);
        $this->set("shipping_details", $shipping_details);
        $this->set("user_name", $user_name);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }

    function order_details($order_id) {
     
        $title = lang('order_details');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $help_link = lang('order_history');
        $this->set("help_link", $help_link);
        
        $this->load_langauge_scripts();

        $flag1 = TRUE;
        $is_order = $this->order_model->checkOrderExist($order_id);
        if (!is_numeric($order_id) || (!$is_order)) {
            $flag1 = FALSE;
            $msg = lang('invalid_order_id');
            $this->redirect($msg, "order/order_history", FALSE);
        }

        $customer_id = $this->order_model->getCustomerIdFromOrder($order_id);
        $user_id = $this->validation_model->getUserIDFromCustomerID($customer_id);
        $current_user = $this->validation_model->IdToUserName($user_id);
        $order_details = $this->order_model->getCurrentOrderHistoryDetails($customer_id, $order_id);
        $this->set("order_details", $order_details);

        $count = count($order_details);
        $this->set("flag1", $flag1);
        $this->set("count", $count);
        $this->set("current_user", $current_user);
        $this->set("order_id", $order_id);

        $this->set("tran_errors_check", $this->lang->line('errors_check'));

        $this->setView();
    }

}
