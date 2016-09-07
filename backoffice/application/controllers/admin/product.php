<?php

require_once 'Inf_Controller.php';

/**
 * @property-read product_model $product_model 
 */
class Product extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function product_management($action = '', $edit_id = '') {

        $msg = lang('product_management');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $msg);

        $help_link = 'product-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('product_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('product_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = ' active';
        $tab2 = '';
        $pro_status = 'yes';
        if ($this->input->post('refine')) {
            $pro_status = strip_tags($this->input->post('pro_status'));
            $this->session->set_userdata('inf_pro_status', $pro_status);
        } else if ($this->session->userdata('inf_pro_status')) {
            $pro_status = $this->session->userdata('inf_pro_status');
        }

        $pair_value_visible = 'no';
        $bv_value_visible = 'no';
        if ($this->MLM_PLAN == 'Binary') {
            $pair_value_visible = 'yes';
        }
        if ($this->MLM_PLAN == 'Unilevel' || $this->MLM_PLAN == 'Matrix' || ($this->MODULE_STATUS['sponsor_commission_status'] == 'yes' && $this->MLM_PLAN != 'Binary' )) {
            $bv_value_visible = 'yes';
        }

        $user_id = $this->LOG_USER_ID;
        $base_url = base_url() . 'admin/product/product_management';
        $config['base_url'] = $base_url;
        $config['per_page'] = 200;
        $tot_rows = $this->product_model->getAllProductsCount($pro_status);

        $config['total_rows'] = $tot_rows;
        $config['uri_segment'] = 4;
        $config['num_links'] = 5;

        $this->pagination->initialize($config);
        $page = 0;
        if ($this->uri->segment(4) != '') {
            $page = $this->uri->segment(4);
        }

        $product_details = $this->product_model->getAllProducts($pro_status, $config['per_page'], $page);
        $this->set('product_details', $product_details);
        $this->set('sub_status', $pro_status);

        $product_image_details = $this->product_model->getAllProducts($pro_status);
        $this->set('product_image_details', $product_image_details);
        $result_per_page = $this->pagination->create_links();
        $this->set('result_per_page', $result_per_page);
        if ($this->input->post('submit_prod') && $this->validate_product_management()) {
            $tab1 = ' active';
            $tab2 = '';
            $this->session->set_userdata('inf_prod_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $prod_name = $post_arr['prod_name'];
            $no_of_token = $post_arr['no_of_token'];
            $splits = $post_arr['splits'];
            $academy_level = $post_arr['academy_level'];
            if ($no_of_token == "") {
                $redirect_msg = lang('you_should_enter_token_no');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($splits == "") {
                $redirect_msg = lang('you_should_enter_splits');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($academy_level == "") {
                $redirect_msg = lang('you_should_enter_academy_level');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $product_availability = $this->product_model->checkProductNameAvailability($prod_name);
            if (!$product_availability) {
                $redirect_msg = lang('product_name_already_exists');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 2);
            if ($pair_value_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            } /* else {
              $pair_value = 0;
              } */
            if ($bv_value_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            } /* else {
              $bv_value = 0;
              } */
            $result = $this->product_model->addProduct($prod_name, $product_amount, $pair_value, $bv_value, $no_of_token, $splits, $academy_level);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($user_id, 'package added', $user_id, $data);
                $redirect_msg = lang('product_added_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_adding_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($this->input->post('update_prod') && $this->validate_product_management()) {
            
            
            $new_file_name='';
            if ($_FILES['userfile']['error'] != 4) {
                $config['upload_path'] = './public_html/images/package/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = lang('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($error['error'], 'product/product_management', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/profile_picture/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }
                }
            }

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $prod_name = $post_arr['prod_name'];
            $product_amount = $post_arr['product_amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);
            $prod_id = $post_arr['prod_id'];
            if ($pair_value_visible == 'yes') {
                $pair_value = $post_arr['pair_value'];
                $bv_value = $pair_value;
            } /* else {
              $pair_value = 0;
              } */
            if ($bv_value_visible == 'yes') {
                $bv_value = $post_arr['bv_value'];
                $pair_value = $bv_value;
            } /* else {
              $bv_value = 0;
              } */
            $no_of_token = $post_arr['no_of_token'];
            $splits = $post_arr['splits'];
            $academy_level = $post_arr['academy_level'];
            if ($no_of_token == "") {
                $redirect_msg = lang('you_should_enter_token_no');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($splits == "") {
                $redirect_msg = lang('you_should_enter_splits');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($academy_level == "") {
                $redirect_msg = lang('you_should_enter_academy_level');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $result = $this->product_model->updateProduct($prod_id, $prod_name, $product_amount, $pair_value, $bv_value, $no_of_token, $splits, $academy_level,$new_file_name);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($user_id, 'package updated', $user_id, $data);
                $redirect_msg = lang('product_updated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_updating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($action == 'edit') {
            $row = $this->product_model->editProduct($edit_id);
            $product_id = $row->product_id;
            $product_name = $row->product_name;
            $prod_id = $row->prod_id;
            $product_value = $row->product_value;
            $pair_value = $row->pair_value;
            $bv_value = $row->bv_value;
            $no_of_token = $row->num_of_tokens;
            $splits = $row->splits;
            $academy_level = $row->academy_level;

            $this->set('pr_id', $product_id);
            $this->set('pr_id_no', $prod_id);
            $this->set('pr_name', $product_name);
            $this->set('pr_value', $product_value);
            $this->set('action', $action);
            $this->set('pair_value', $pair_value);
            $this->set('bv_value', $bv_value);
            $this->set('no_of_token', $no_of_token);
            $this->set('splits', $splits);
            $this->set('academy_level', $academy_level);
        } else {
            $this->set('pr_id_no', '');
            $this->set('pr_name', '');
            $this->set('pr_id', '');
            $this->set('pr_value', '');
            $this->set('action', '');
            $this->set('pair_value', '');
            $this->set('bv_value', '');
            $this->set('no_of_token', '');
            $this->set('splits', '');
            $this->set('academy_level', '');
        }

        if ($action == 'delete') {
            $result = $this->product_model->deleteProduct($id);

            if ($result) {
                $redirect_msg = lang('product_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_inactivating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($this->session->userdata('inf_prod_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_prod_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_prod_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_prod_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('pair_value_visible', $pair_value_visible);
        $this->set('bv_value_visible', $bv_value_visible);

        $this->set('mlm_plan', $this->MLM_PLAN);

        $this->setView();
    }

    function validate_product_management() {

        $this->form_validation->set_rules('prod_name', lang('product_name'), 'trim|required');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'trim|required|numeric');
        if ($this->MODULE_STATUS ['mlm_plan'] == "Binary")
            $this->form_validation->set_rules('pair_value', lang('pair_value'), 'trim|required|numeric');

        return $this->form_validation->run();
    }

    function validate_product_management_upload() {

        $tab1 = '';
        $tab2 = ' active';
        $this->session->set_userdata('inf_prod_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $this->form_validation->set_rules('prod_id', lang('product_name'), 'trim|strip_tags|required|numeric');

        return $this->form_validation->run();
    }

    function edit_product() {

        if ($this->input->post('update_prod') && $this->validate_edit_product()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $prod_name = $post_arr['prod_name'];
            $product_id = $post_arr['product_id'];
            $product_amount = $post_arr['product_amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);
            $prod_id = $post_arr['prod_id'];
            if ($this->MODULE_STATUS ['mlm_plan'] != 'Binary') {
                $pair_value = 0;
            } else {
                $pair_value = $post_arr['pair_value'];
            }

            $result = $this->product_model->updateProduct($prod_id, $prod_name, $product_id, $product_amount, $product_value);
            $redirect_msg = '';
            if ($result) {
                $redirect_msg = lang('product_updated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_updating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }
    }

    function validate_edit_product() {

        $tab1 = '';
        $tab2 = ' active';
        $this->session->set_userdata('inf_prod_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));

        $this->form_validation->set_rules('product_id', lang('product_id'), 'trim|required');
        $this->form_validation->set_rules('prod_name', lang('product_name'), 'trim|required');
        $this->form_validation->set_rules('product_amount', lang('product_amount'), 'trim|required|numeric');
        $this->form_validation->set_rules('product_value', lang('product_amount'), 'trim|required|numeric');
        $this->form_validation->set_rules('prod_id', lang('product_id'), 'trim|required|numeric');

        return $this->form_validation->run();
    }

    function inactivate_product($action = '', $prod_id = '') {

        if ($action == 'inactivate') {
            $redirect_msg = '';
            $result = $this->product_model->inactivateProduct($prod_id);

            if ($result) {
                $data_array['product_id'] = $prod_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'package deactivated', $this->LOG_USER_ID, $data);
                $redirect_msg = lang('product_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_inactivating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }
    }

    function active_product($action = '', $activate_id = '') {

        if ($action == 'activate') {
            $redirect_msg = '';
            $result = $this->product_model->activateProduct($activate_id);
            if ($result) {
                $data_array['product_id'] = $activate_id;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'package activated', $this->LOG_USER_ID, $data);
                $redirect_msg = lang('product_activated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_activating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }
    }

    function sales_facilities($action = '', $edit_id = '') {

        $msg = lang('sales_facilities');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $msg);

        $this->HEADER_LANG['page_top_header'] = lang('sales_facilities');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('sales_facilities');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $tab1 = 'active';
        $tab2 = '';

        $user_id = $this->LOG_USER_ID;
        $product_details = $this->product_model->getAllProd();

        $this->set('product_details', $product_details);


        if ($this->input->post('submit_prod') && $this->validate_product_management()) {
            $tab1 = ' active';
            $tab2 = '';
            $this->session->set_userdata('inf_prod_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2));
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $prod_name = $post_arr['prod_name'];
            $no_of_token = $post_arr['no_of_token'];
            $splits = $post_arr['splits'];
            $academy_level = $post_arr['academy_level'];
            if ($no_of_token == "") {
                $redirect_msg = lang('you_should_enter_token_no');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($splits == "") {
                $redirect_msg = lang('you_should_enter_splits');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($academy_level == "") {
                $redirect_msg = lang('you_should_enter_academy_level');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $product_availability = $this->product_model->checkProductNameAvailability($prod_name);
            if (!$product_availability) {
                $redirect_msg = lang('product_name_already_exists');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $product_amount = round((floatval($post_arr['product_amount']) / $this->DEFAULT_CURRENCY_VALUE), 2);
            if ($pair_value_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['pair_value'];
            } /* else {
              $pair_value = 0;
              } */
            if ($bv_value_visible == 'yes') {
                $pair_value = $bv_value = $post_arr['bv_value'];
            } /* else {
              $bv_value = 0;
              } */
            $result = $this->product_model->addProduct($prod_name, $product_amount, $pair_value, $bv_value, $no_of_token, $splits, $academy_level);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($user_id, 'package added', $user_id, $data);
                $redirect_msg = lang('product_added_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_adding_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($this->input->post('update_prod') && $this->validate_product_management()) {

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $prod_name = $post_arr['prod_name'];
            $product_amount = $post_arr['product_amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);
            $prod_id = $post_arr['prod_id'];
            if ($pair_value_visible == 'yes') {
                $pair_value = $post_arr['pair_value'];
                $bv_value = $pair_value;
            } /* else {
              $pair_value = 0;
              } */
            if ($bv_value_visible == 'yes') {
                $bv_value = $post_arr['bv_value'];
                $pair_value = $bv_value;
            } /* else {
              $bv_value = 0;
              } */
            $no_of_token = $post_arr['no_of_token'];
            $splits = $post_arr['splits'];
            $academy_level = $post_arr['academy_level'];
            if ($no_of_token == "") {
                $redirect_msg = lang('you_should_enter_token_no');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($splits == "") {
                $redirect_msg = lang('you_should_enter_splits');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            if ($academy_level == "") {
                $redirect_msg = lang('you_should_enter_academy_level');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
            $result = $this->product_model->updateProduct($prod_id, $prod_name, $product_amount, $pair_value, $bv_value, $no_of_token, $splits, $academy_level);
            if ($result) {
                $data = serialize($post_arr);
                $this->validation_model->insertUserActivity($user_id, 'package updated', $user_id, $data);
                $redirect_msg = lang('product_updated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_updating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($action == 'edit') {
            $row = $this->product_model->editProduct($edit_id);
            $product_id = $row->product_id;
            $product_name = $row->product_name;
            $prod_id = $row->prod_id;
            $product_value = $row->product_value;
            $pair_value = $row->pair_value;
            $bv_value = $row->bv_value;
            $no_of_token = $row->num_of_tokens;
            $splits = $row->splits;
            $academy_level = $row->academy_level;

            $this->set('pr_id', $product_id);
            $this->set('pr_id_no', $prod_id);
            $this->set('pr_name', $product_name);
            $this->set('pr_value', $product_value);
            $this->set('action', $action);
            $this->set('pair_value', $pair_value);
            $this->set('bv_value', $bv_value);
            $this->set('no_of_token', $no_of_token);
            $this->set('splits', $splits);
            $this->set('academy_level', $academy_level);
        } else {
            $this->set('pr_id_no', '');
            $this->set('pr_name', '');
            $this->set('pr_id', '');
            $this->set('pr_value', '');
            $this->set('action', '');
            $this->set('pair_value', '');
            $this->set('bv_value', '');
            $this->set('no_of_token', '');
            $this->set('splits', '');
            $this->set('academy_level', '');
        }

        if ($action == 'delete') {
            $result = $this->product_model->deleteProduct($id);

            if ($result) {
                $redirect_msg = lang('product_inactivated_successfully');
                $this->redirect($redirect_msg, 'product/product_management', TRUE);
            } else {
                $redirect_msg = lang('error_on_inactivating_product');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            }
        }

        if ($this->input->post('upload') && $this->validate_product_management_upload()) {

            $product_id = $this->input->post('prod_id');
            $document1 = $_FILES['userfile']['name'];

            $config['upload_path'] = './public_html/images/product/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPG';
            $config['max_size'] = '2000000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                $redirect_msg = lang('image_ratio') . ' ' . $config['max_width'] . ' * ' . $config['max_height'] . ' ' . lang('pixels');
                $this->redirect($redirect_msg, 'product/product_management', FALSE);
            } else {
                $data = array('upload_data' => $this->upload->data());

                $res = $this->product_model->InsertProductImage($product_id, $document1);
                if ($res) {
                    $this->validation_model->insertUserActivity($user_id, 'product image added', $user_id);
                    $redirect_msg = lang('image_added_successfully');
                    $this->redirect($redirect_msg, 'product/product_management', TRUE);
                } else {
                    $redirect_msg = lang('image_cannot_be_uploaded');
                    $this->redirect($redirect_msg, 'product/product_management', FALSE);
                }
            }
        }
        if ($this->session->userdata('inf_prod_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_prod_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_prod_tab_active_arr']['tab2'];
            $this->session->unset_userdata('inf_prod_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);

        $this->setView();
    }

}
