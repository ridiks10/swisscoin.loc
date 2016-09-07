<?php

require_once 'Inf_Controller.php';

class Tokens extends Inf_Controller {

    function __construct() {
        parent::__construct(); 
    }

    function more() { 
      
        $title = 'Tokens';
        $this->set("title", $this->COMPANY_NAME . " | $title");
     
        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';
        
        $this->load_langauge_scripts();

        $user_id=  $this->LOG_USER_ID;
        $package_details = $this->tokens_model->getAllTokens($user_id);
		$has_open = in_array('NO', array_column( $package_details, 'package_mining') );
		$this->set('has_open', $has_open );
        $this->set("package_details", $package_details);
        $this->set("arr_count", count($package_details));
        $this->setView();
    }

     function my_token() {
         
        $title = lang('tokens');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('tokens');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('tokens');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $mlm_plan = $this->MLM_PLAN;
        $this->set('mlm_plan', $mlm_plan);
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {
            $employee_view_permission = 'no';
        } else {
            $employee_view_permission = 'yes';
        }
//         $lang_id = $this->LANG_ID;
        $userid = $this->LOG_USER_ID;
        $user_name = $this->LOG_USER_NAME;
        $product_status = $this->MODULE_STATUS['product_status'];
        $msg = '';
        $user_id = $userid;
        $is_valid_username = false;
        
//        $info_box=$this->validation_model->getInfoDetails('cash_account',$lang_id);
        
        if ($this->input->post('user_name') && $this->validate_my_ewallet()) {
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if (!$is_valid_username) {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, "tokens/my_token", false);
            }
            $this->set('ewallet_view_permission', 'yes');
            $user_id = $this->validation_model->userNameToID($user_name);
        }

         
        $token_details = $this->tokens_model->getAllPackage($user_id);
        
        $details_count = count($token_details);
        $this->set('details_count', $details_count);
        $this->set('token_details', $token_details);
        $this->set('user_name', $user_name);
        $this->set('is_valid_username', $is_valid_username);
        $this->setView();
    }
   
    
     function validate_my_ewallet() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    

}
