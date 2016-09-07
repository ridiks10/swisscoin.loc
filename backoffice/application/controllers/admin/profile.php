<?php

require_once 'Inf_Controller.php';

/**
 * @property-read profile_model $profile_model 
 */
class Profile extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function profile_view($url_username = '') {
        $help_link = 'profile-management';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('profile_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $from_page = 'link';
        $mlm_plan = $this->MLM_PLAN;
        $product_status = $this->MODULE_STATUS['product_status'];
        $pin_status = $this->MODULE_STATUS['pin_status'];
        $user_type = $this->LOG_USER_TYPE;

        $edit_profile = '';
        $lang_id = $this->LANG_ID;
        $tab1 = ' active';
        $tab2 = $tab3 = '';
        $prof_view = 'yes';

        $j = 0;
        $curr_date = date('Y');
        for ($i = 1900; $i <= $curr_date; $i++) {
            $aray[$j] = $i;
            $j++;
        }
        $j = 0;
        for ($i = 1; $i <= 31; $i++) {
            $aray1[$j] = $i;
            $j++;
        }


        if ($user_type == 'employee')
            $prof_view = 'no';

        $user_name = $this->LOG_USER_NAME;
        if ($user_type == 'employee') {
            $user_name = $this->validation_model->getAdminUsername();
        }
//        if ($this->input->post('from_page')) {
//            $from_page = 'user_account';
//        }

        if ($this->input->post('user_name')) {
            $prof_view = 'yes';
            $name_post_array = $this->input->post();
            $name_post_array = $this->validation_model->stripTagsPostArray($name_post_array);
            $name_post_array = $this->validation_model->escapeStringPostArray($name_post_array);
            $user_id = $this->validation_model->userNameToID($name_post_array['user_name']);
            if ($this->validation_model->isUserAvailable($user_id)) {
                $this->session->set_userdata('inf_usr_name', $name_post_array['user_name']);
                $user_name = $name_post_array['user_name'];
            } else {
                $msg = lang('invalid_user');
                $this->redirect($msg, 'profile/profile_view', false);
            }
        } else if ($url_username != '') {
            $u_name1 = $url_username;
            $decode_id = urldecode($u_name1);
            $decode_id = str_replace('_', '/', $decode_id);
            $user_name = $this->encrypt->decode($decode_id);

            $this->session->set_userdata('inf_usr_name', $user_name);
            $this->set('url_name', $user_name);
        } else if ($this->session->userdata('inf_usr_name')) {
            $user_name = $this->session->userdata('inf_usr_name');
        }
        if ($this->input->post('update_network2')) {
            $tab1 = '';
            $tab2 = '';
            $tab3 = ' active';
            $this->session->set_userdata('inf_prof_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            $network = array();
            $network['position'] = strip_tags($this->input->post('network'));
            $network['user'] = $user_name;
            $network['id'] = $this->profile_model->userNameToId($network['user']);

            $res = $this->profile_model->updateUserNetwork($network);

            $msg = '';
            if ($res) {
                $loggin_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($loggin_id, 'profile updated', $loggin_id);
                $msg = lang('user_profile_updated_successfully');
                $this->redirect($msg, 'profile/profile_view', TRUE);
            } else {
                $msg = lang('error_on_profile_updation');
                $this->redirect($msg, 'profile/profile_view', FALSE);
            }
        }
        if ($this->input->post('update_profile') && $this->validate_profile_view()) {
            $regr = array();

            $update_post_array = $this->input->post();
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);
            $no = $update_post_array['mobile'];
            $regr['mobile'] = $update_post_array['mobile'];
            $regr['username'] = $update_post_array['username'];
            $regr['full_name'] = $update_post_array['name'];
            $regr['address'] = $update_post_array['address'];
            $regr['country'] = $update_post_array['country'];
            if (array_key_exists('state', $update_post_array) && $update_post_array['state'] != '0') {
                $regr['state'] = $update_post_array['state'];
            } else {
                $regr['state'] = 'NA';
            }
            $regr['second_name'] = $update_post_array['second_name'];
            $regr['address_line2'] = $update_post_array['address_line2'];
            $regr['city'] = $update_post_array['city'];
            $regr['land_line'] = $update_post_array['land_line'];
            $regr['email'] = $update_post_array['email'];
            $year = $update_post_array['year'];
            $month = $update_post_array['month'];
            $day = $update_post_array['day'];
            $regr['date_of_birth'] = $year . '-' . $month . '-' . $day;
            $regr['gender'] = $update_post_array['gender'];
            $regr['pin'] = $update_post_array['pin'];
            $regr['bank_country'] = $update_post_array['bank_country'];
            $regr['id_expire'] = $update_post_array['id_expire'];
            $regr['passport_id'] = $update_post_array['passport_id'];
            $regr['bank_acc_no'] = $update_post_array['bank_acc_no'];
            $regr['ifsc'] = $update_post_array['ifsc'];
            $regr['bank_name'] = $update_post_array['bank_name'];
            $regr['bank_branch'] = $update_post_array['bank_branch'];
            $regr['facebook'] = $update_post_array['facebook'];
            $regr['twitter'] = $update_post_array['twitter'];
            $regr['name'] = $update_post_array['name'];
            $regr['tax_id'] = $update_post_array['tax-id'];
            $regr['tax_number'] = $update_post_array['tax-number'];

            if ($_FILES['userfile']['error'] != 4) {

                $user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/profile_picture/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '4000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload()) {
                    $msg = lang('image_not_selected');
                    $error = array('error' => $this->upload->display_errors());
                    $this->redirect($msg, 'profile/profile_view', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $new_file_name = $image_arr['upload_data']['file_name'];
                    $image = $image_arr['upload_data'];

                    if ($image['file_name']) {
                        $data['photo'] = 'public_html/images/profile_picture/' . $image['file_name'];
                        $data['raw'] = $image['raw_name'];
                        $data['ext'] = $image['file_ext'];
                    }

                    $res = $this->profile_model->changeProfilePicture($user_id, $new_file_name);
                    if (!$res) {
                        $msg = lang('image_cannot_be_uploaded');
                        $this->redirect($msg, 'profile/profile_view', FALSE);
                    }
                }
            }
            $user_ref_id = $this->profile_model->userNameToId($regr['username']);
            $res = $this->profile_model->updateUserDetails($regr, $user_ref_id);
            $msg = '';
            if ($res) {
                $login_id = $this->LOG_USER_ID;
                if ($user_type == 'employee') {
                    $login_id = $this->validation_model->getAdminId();
                    $user_name = $this->validation_model->getAdminUsername();
                }
                $done_id = $this->validation_model->userNameToID($user_name);

                $data = serialize($regr);
                $this->validation_model->insertUserActivity($login_id, 'profile updated', $done_id, $data);
                $msg = lang('user_profile_updated_successfully');
                $this->redirect($msg, 'profile/profile_view', TRUE);
            } else {
                $msg = lang('error_on_profile_updation');
                $this->redirect($msg, 'profile/profile_view', FALSE);
            }
        }

        $user_id = $this->profile_model->userNameToId($user_name);
        if ($user_id == '') {
            $user_id = $this->LOG_USER_ID;
            $user_name = $this->LOG_USER_NAME;
            if ($user_type == 'employee') {
                $user_id = $this->validation_model->getAdminId();
                $user_name = $this->valdation->getAdminUsername();
            }
        }
        $profile_arr = $this->profile_model->getProfileDetails($user_id, $user_name, $product_status, $lang_id);
        if ($profile_arr["details"]["detail1"]["dob"] != '0000-00-00') {
            $profile_arr['details']['detail1']['year'] = date("Y", strtotime($profile_arr["details"]["detail1"]["dob"]));
            $profile_arr['details']['detail1']['month'] = date("m", strtotime($profile_arr["details"]["detail1"]["dob"]));
            $profile_arr['details']['detail1']['day'] = date("d", strtotime($profile_arr["details"]["detail1"]["dob"]));
        } else {
            $profile_arr['details']['detail1']['year'] = 'YYYY';
            $profile_arr['details']['detail1']['month'] = 'MM';
            $profile_arr['details']['detail1']['day'] = 'DD';
        }
        $details = $profile_arr['details'];
        $country_id = $details['detail1']['country_code'];
        $countries = $this->country_state_model->viewCountry($country_id);
        $state = $this->country_state_model->viewState($country_id, $details['detail1']['state']);
        if ($details['detail1']['state'] == 'NA') {
            $state = "<option value='0' selected>" . lang('no_state_selected') . "</option>" . $state;
        }
        $product_name = '';
        $sponser = $profile_arr['sponser'];
        if ($product_status == 'yes') {
            $product_name = $profile_arr['product_name'];
        }
        $title = lang('s_profile');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $user_name . $title);
        $file_name = $this->profile_model->getUserPhoto($user_id);
        if (!file_exists('public_html/images/profile_picture/' . $file_name)) {
            $file_name = 'nophoto.jpg';
        }
        if ($this->session->userdata('inf_prof_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_prof_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_prof_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_prof_tab_active_arr']['tab3'];
            $this->session->unset_userdata('inf_prof_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);

        $this->set('user_type', $user_type);
        $this->set('mlm_plan', $mlm_plan);
        $this->set('lang_id', $lang_id);
        $this->set('profile_view_permission', $prof_view);

        $this->set('u_name', $user_name);
        $this->set('product_status', $product_status);
        $this->set('pin_status', $pin_status);
        $this->set('sponser', $sponser);
        $this->set('details', $details);
        $this->set('years', $aray);
        $this->set('month', $aray1);
        $replica_url = base_url();
        $replica_url = dirname($replica_url);
        $this->set('replica_url', $replica_url);

        $this->set('position', $details['detail1']['network']);
        $this->set('cur_country', $details['detail1']['country']);
        $this->set('cur_state', $details['detail1']['state']);
        $this->set('countries', $countries);
        $this->set('state', $state);
        $this->set('product_name', $product_name);
        $this->set('file_name', $file_name);
//        $this->set('from_page', $from_page);

        $this->setView();
    }

    function validate_profile_view() {
        $tab1 = $tab3 = '';
        $tab2 = ' active';
        $this->session->set_userdata('inf_prof_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));

        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|');
        $this->form_validation->set_rules('year', 'Year', 'trim|required');
        $this->form_validation->set_rules('month', 'Month', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');

        $this->form_validation->set_rules('second_name', 'Second Name', 'trim|required|alpha');
        $this->form_validation->set_rules('pin', 'Pin', 'trim|required|numeric');
//        $this->form_validation->set_rules('address_line2', 'Address Line2', 'trim|required|alpha_numeric|max_length[200]');
//        $this->form_validation->set_rules('city', 'City', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');

        $this->form_validation->set_rules('address', 'Address Line1', 'trim|required|max_length[200]');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|xss_clean|required|numeric');
        $this->form_validation->set_rules('land_line', 'Land Line No', 'trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pin', 'Zip Code', 'required|trim|alpha_numeric');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim');
        $this->form_validation->set_rules('bank_branch', 'Bank Branch', 'trim');
        $this->form_validation->set_rules('bank_acc_no', 'Bank Account Number', 'trim');
        $this->form_validation->set_rules('passport_id', 'Passport Id', 'trim|required');
        $this->form_validation->set_rules('id_expire', 'Expiry Date', 'trim|required');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('max_length', 'The %s field can not exceed 20 digits.');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');

        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function user_account() {

        $title = lang('user_account');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'user-details';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('user_account');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('user_account');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $mlm_plan = $this->MLM_PLAN;
        $posted = false;
        $is_valid_username = false;
        $user_name = '';

        if ($this->input->post('user_name') && $this->validate_user_account()) {
            $posted = true;
            $user_name = $this->input->post('user_name');
            $user_id = $this->validation_model->userNameToID($user_name);
            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'profile/user_account', FALSE);
            }
        }

        $this->set('mlm_plan', $mlm_plan);
        $this->set('posted', $posted);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('user_name', $user_name);

        $this->setView();
    }

    function validate_user_account() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function change_username() {
        $title = lang('change_username');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-username';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_username');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_username');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('change_username') && $this->validate_change_username()) {

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $user_name = $post_arr['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $new_user_name = $post_arr['new_username'];

            $admin_id = $this->validation_model->getAdminId();

            if ($user_id != $admin_id) {
                $res = $this->profile_model->changeUsername($user_id, $user_name, $new_user_name);
                if (!$res) {
                    $msg = lang('username_cannot_be_changed');
                    $this->redirect($msg, 'profile/change_username', FALSE);
                } else {
                    $data = serialize($post_arr);
                    $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'username changed', $user_id, $data);
                    $msg = lang('username_changed_successfully');
                    $this->redirect($msg, 'profile/change_username', TRUE);
                }
            } else {
                $msg = "You can't change ADMIN username.";
                $this->redirect($msg, 'profile/change_username', FALSE);
            }
        }
        $this->setView();
    }

    function validate_change_username() {

        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|callback_val_user_name[1]');
        $this->form_validation->set_rules('new_username', 'New User Name', 'trim|required|callback_val_user_name[0]|min_length[6]|alpha_numeric');
        $this->form_validation->set_message('val_user_name', $this->lang->line('invalid_username_or_new_username_exists'));

        $val = $this->form_validation->run();
        if (!$val) {
            $msg = validation_errors();
            $this->redirect($msg, 'profile/change_username', FALSE);
        } else
            return true;
    }

    function val_user_name($user_name, $k) {
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id && $k)
            return true;
        else if (!$user_id && !$k)
            return true;
        else
            return false;
    }

    function get_states($country_id) {
        $state = '';
        $state_txt = $this->lang->line('state');
        ;
        $state_string = $this->country_state_model->viewState($country_id);
        $state = "<div class='col-md-6'>
                 <div class='form-group'>
                       <label class='control-label'>
                               $state_txt                  
                         </label>
                   <div class='row'>
                        <div class='col-md-12'> 

                           <select name='state' id='state' tabindex='13' class='form-control'>";
        if ($state_string != '') {
            $state.="<option value='0'>" . lang('select_state_menu') . "</option>" . $state_string;
        } else {
            $state.="<option value='0'>" . lang('no_data_available') . "</option>";
        }
        $state.="</select>                                    
                        </div>
                    </div>
                </div> ";
        echo $state;
    }

    function user_career() {
        $title = 'User Career';
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-username';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = $title;
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = $title;
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $ranks = $this->profile_model->getDiamondRanks();

        $rank_count = count($ranks);

        $this->set("ranks", $ranks);
        
        $achievers = array();
           
        $career_id=$this->input->post("rank_id") ? $this->input->post("rank_id") : 8;
        $achievers = $this->profile_model->getAchievers($career_id);           

        $this->set("achievers", $achievers);
        $this->set("career_id", $career_id);

        $this->setView();
    }

    

    function bankdata() {
        $title = lang('verify_bankdata');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = "banking";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('verify_bankdata');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('verify_bankdata');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->get_post('confirm')) {

            $id = $this->input->get_post('confirm');

            if ($id) {
                $details = $this->profile_model->getUserVerificationDetails($id);

                $this->set("details", $details);
            }
//            else {
//                $user_name = $this->input->get('name');
//                $msg = 'does not provide any document to verify';
//                $this->redirect($user_name . '-' . $msg, 'profile/user_document', FALSE);
//            }
        } elseif ($this->input->post('confirm_doc')) {

//            print_r($this->input->post());die();
//            $doc_arr['passport']='no';
//            $doc_arr['address']='no';
            
             $doc_arr=array();
            
            $verify_id = $this->input->post('confirm_doc');
            if($this->input->post('passport')){
                $doc_arr['passport']='yes';
            }
            if($this->input->post('address')){
                $doc_arr['address']='yes';
            }
            $res = false;
           
            if ($doc_arr) {
                $res = $this->profile_model->updateUserVerification($verify_id, $doc_arr);

                if ($res) {
                    $this->redirect(lang('Proof_verified_succesfully'), 'profile/bankdata', TRUE);
                } else {
                    $this->redirect(lang('Proof_verification_failed'), 'profile/bankdata', FALSE);
                }
            }
            else{
                 $this->redirect(lang('you_are_not_selected_any_document_to_confirm'), 'profile/bankdata', FALSE);
            }
        } elseif ($this->input->post('reject_doc')) {
            
            
//            $doc_arr['passport']='no';
//            $doc_arr['address']='no';
            
            $doc_arr=array();
            
            $verify_id = $this->input->post('reject_doc');
            if($this->input->post('passport')){
                $doc_arr['passport']='yes';
            }
            if($this->input->post('address')){
                $doc_arr['address']='yes';
            }
            $res = false;
           
            if ($doc_arr) {
                $res = $this->profile_model->rejectUserVerification($verify_id, $doc_arr);

                if ($res) {
                    $this->redirect(lang('Proof_Rejected_succesfully'), 'profile/bankdata', TRUE);
                } else {
                    $this->redirect(lang('failed_to_reject_profile'), 'profile/bankdata', FALSE);
                }
            }
            else{
                 $this->redirect(lang('you_are_not_selected_any_document_to_reject'), 'profile/bankdata', FALSE);
            }
        }

        $res = $this->profile_model->getUserVerificationDetails();
        $this->set("res", $res);
        $this->setView();
    }

}
