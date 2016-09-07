<?php

require_once 'Inf_Controller.php';

class myorder extends Inf_Controller {

    function order_history($page = 1) {
        $title = lang('order_history');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('order_history');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('order_history');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        /* pagination */
        $pagination['use_page_numbers'] = TRUE;
        $pagination['uri_segment'] = 4;
        $pagination['base_url'] = base_url() . "admin/myorder/order_history";
        $pagination['num_links'] = 5;
        $pagination['per_page'] = 100;
        $pagination['total_rows'] = $this->myorder_model->getCountOrders();
        $this->pagination->initialize($pagination);
        
        $package_details = $this->myorder_model->getMyOrders('', $page);
        $this->set("result_per_page", $this->pagination->create_links());
        $this->set("package_details", $package_details);
        $this->set("arr_count", count($package_details));
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
        $is_order = $this->myorder_model->checkOrderExist($order_id);
        if (!is_numeric($order_id) || (!$is_order)) {
            $flag1 = FALSE;
            $msg = lang('invalid_order_id');
            $this->redirect($msg, "myorder/order_history", FALSE);
        }

        $customer_id = $this->myorder_model->getCustomerIdFromOrder($order_id);
        $user_id = $this->validation_model->getUserIDFromCustomerID($customer_id);
        $current_user = $this->validation_model->IdToUserName($user_id);
        $order_details = $this->myorder_model->getCurrentOrderHistoryDetails($customer_id, $order_id);
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
