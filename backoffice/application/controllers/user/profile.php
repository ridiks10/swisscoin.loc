<?php

require_once 'Inf_Controller.php';

/**
 * @property-read profile_model $profile_model 
 */
class Profile extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function profile_view() {

        $this->HEADER_LANG['page_top_header'] = lang('profile_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('profile_management');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

        $product_status = $this->MODULE_STATUS['product_status'];
        $pin_status = $this->MODULE_STATUS['pin_status'];
        $user_type = $this->LOG_USER_TYPE;
        $this->set('user_type', $user_type);
        $mlm_plan = $this->MLM_PLAN;
        $this->set('mlm_plan', $mlm_plan);

        $edit_profile = '';
        $lang_id = $this->LANG_ID;
        $this->set('lang_id', $lang_id);
        $tab1 = ' active';
        $tab2 = $tab3 = '';

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
        if ($this->input->post('profile_edit')) {
            $edit_post_array = $this->input->post();
            $edit_post_array = $this->validation_model->stripTagsPostArray($edit_post_array);
            $edit_post_array = $this->validation_model->escapeStringPostArray($edit_post_array);
            $edit_profile = $edit_post_array['profile_edit'];
            $country_code = $edit_post_array['country_code'];
            $user_state = $edit_post_array['user_state'];

            $countries = $this->country_state_model->viewCountry($country_code);
            $this->set('countries', $countries);

            $state = $this->country_state_model->viewState($user_state);
            $this->set('state', $state);
        }
        $this->set('edit_profile', $edit_profile);
        $u_name = $this->LOG_USER_NAME;

        if ($this->input->post('update_profile') && $this->validate_profile_view()) {

            $regr = array();
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            if (array_key_exists('username', $post_arr)) {
                $regr['username'] = $post_arr['username'];
            }
            if (array_key_exists('name', $post_arr)) {
                $regr['full_name'] = $post_arr['name'];
            }
            if (array_key_exists('second_name', $post_arr)) {
                $regr['second_name'] = $post_arr['second_name'];
            }
            if (array_key_exists('address', $post_arr)) {
                $regr['address'] = $post_arr['address'];
            }
            if (array_key_exists('address_line2', $post_arr)) {
                $regr['address_line2'] = $post_arr['address_line2'];
            }
            if (array_key_exists('post_office', $post_arr)) {
                $regr['post_office'] = $post_arr['post_office'];
            }
            if (array_key_exists('country', $post_arr)) {
                $regr['country'] = $post_arr['country'];
            }
            if (array_key_exists('town', $post_arr)) {
                $regr['town'] = $post_arr['town'];
            } else {
                $regr['town'] = 'NA';
            }
            if (array_key_exists('state', $post_arr) && $post_arr['state'] != '0') {
                $regr['state'] = $post_arr['state'];
            } else {
                $regr['state'] = 'NA';
            }

            if (array_key_exists('city', $post_arr)) {
                $regr['city'] = $post_arr['city'];
            }
            if (array_key_exists('mobile', $post_arr)) {
                $regr['mobile'] = $post_arr['mobile'];
            }
            if (array_key_exists('land_line', $post_arr)) {
                $regr['land_line'] = $post_arr['land_line'];
            }
            if (array_key_exists('email', $post_arr)) {
                $regr['email'] = $post_arr['email'];
            }
           
            $year = $post_arr['year'];
            $month = $post_arr['month'];
            $day = $post_arr['day'];
            $regr['date_of_birth'] = $year . '-' . $month . '-' . $day;

            if (($year == '0000') || ($month == '00') || ($day == '00')) {
                $msg = lang('you_must_select_date_of_birth');
                $this->redirect($msg, 'profile/profile_view', FALSE);
            }

            if (array_key_exists('gender', $post_arr)) {
                $regr['gender'] = $post_arr['gender'];
            }
            if (array_key_exists('pin', $post_arr)) {
                $regr['pin'] = $post_arr['pin'];
            }
            if (array_key_exists('nominee', $post_arr)) {
                $regr['nominee'] = $post_arr['nominee'];
            }
            if (array_key_exists('relation', $post_arr)) {
                $regr['relation'] = $post_arr['relation'];
            }
            if (array_key_exists('bank_country', $post_arr)) {
                $regr['bank_country'] = $post_arr['bank_country'];
            }
            if (array_key_exists('bank_acc_no', $post_arr)) {
                $regr['bank_acc_no'] = $post_arr['bank_acc_no'];
            }
            if (array_key_exists('ifsc', $post_arr)) {
                $regr['ifsc'] = $post_arr['ifsc'];
            }
            if (array_key_exists('bank_name', $post_arr)) {
                $regr['bank_name'] = $post_arr['bank_name'];
            }
            if (array_key_exists('bank_branch', $post_arr)) {
                $regr['bank_branch'] = $post_arr['bank_branch'];
            }
            if (array_key_exists('facebook', $post_arr)) {
                $regr['facebook'] = $post_arr['facebook'];
            }
            if (array_key_exists('twitter', $post_arr)) {
                $regr['twitter'] = $post_arr['twitter'];
            }
            if (array_key_exists('passport_id', $post_arr)) {
                $regr['passport_id'] = $post_arr['passport_id'];
            }
            if (array_key_exists('id_expire', $post_arr)) {
                $regr['id_expire'] = $post_arr['id_expire'];
            }
            if (array_key_exists('tax-id', $post_arr)) {
                $regr['tax_id'] = $post_arr['tax-id'];
            }
            if (array_key_exists('tax-number', $post_arr)) {
                $regr['tax_number'] = $post_arr['tax-number'];
            }

            if ($_FILES['userfile']['error'] != 4) {

                $user_id = $this->profile_model->userNameToId($regr['username']);
                $config['upload_path'] = './public_html/images/profile_picture/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000000';
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
                $loggin_id = $this->LOG_USER_ID;
                $data_array = array();
                $data_array['edit_profile'] = $regr;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($loggin_id, 'profile updated', $loggin_id, $data);
                $msg = lang('user_profile_updated_successfully');
                $this->redirect($msg, 'profile/profile_view', TRUE);
            } else {
                $msg = lang('error_on_profile_updation');
                $this->redirect($msg, 'profile/profile_view', FALSE);
            }
        }

        if ($this->input->post('update_network2')) {
            $tab1 = '';
            $tab2 = '';
            $tab3 = ' active';
            $this->session->set_userdata('inf_prof_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
            $network = array();
            $network['position'] = strip_tags($this->input->post('network'));
            $network['user'] = $this->LOG_USER_NAME;
            $network['id'] = $this->profile_model->userNameToId($network['user']);

            $res = $this->profile_model->updateUserNetwork($network);

            $msg = '';
            if ($res) {
                $loggin_id = $this->LOG_USER_ID;
                $data_array = array();
                $data_array['edit_profile'] = $edit_post_array;
                $data = serialize($data_array);
                $this->validation_model->insertUserActivity($loggin_id, 'profile updated', $loggin_id, $data);
                $msg = lang('user_profile_updated_successfully');
                $this->redirect($msg, 'profile/profile_view', TRUE);
            } else {
                $msg = lang('error_on_profile_updation');
                $this->redirect($msg, 'profile/profile_view', FALSE);
            }
        }

        $user_id = $this->profile_model->userNameToId($u_name);
        if ($user_id == '') {
            $user_id = $this->LOG_USER_ID;
            $u_name = $this->LOG_USER_NAME;
        }
        $profile_arr = $this->profile_model->getProfileDetails($user_id, $u_name, $product_status, $lang_id);
        
     
        if ($profile_arr["details"]["detail1"]["dob"] !='0000-00-00') {
            $profile_arr['details']['detail1']['year'] = date("Y", strtotime($profile_arr["details"]["detail1"]["dob"]));
            $profile_arr['details']['detail1']['month'] = date("m", strtotime($profile_arr["details"]["detail1"]["dob"]));
            $profile_arr['details']['detail1']['day'] = date("d", strtotime($profile_arr["details"]["detail1"]["dob"]));
        } else {
            $profile_arr['details']['detail1']['year'] = 'YYYY';
            $profile_arr['details']['detail1']['month'] = 'MM';
            $profile_arr['details']['detail1']['day'] = 'DD';
        }
        $details = $profile_arr['details'];
        $this->set('cur_country', $details['detail1']['country']);
        $this->set('cur_state', $details['detail1']['state']);
        $country_id = $details['detail1']['country_code'];
        $countries = $this->country_state_model->viewCountry($country_id);
        $this->set('countries', $countries);
        $state = $this->country_state_model->viewState($details['detail1']['country_code'], $details['detail1']['state']);
        if ($details['detail1']['state'] == 'NA') {
            $state = "<option value='0' selected>" . lang('no_state_selected') . "</option>" . $state;
        }
        $this->set('state', $state);
        $this->set('position', $details['detail1']['network']);

        $sponser = $profile_arr['sponser'];
        if ($product_status == 'yes') {
            $product_name = $profile_arr['product_name'];
            $this->set('product_name', $product_name);
        }
        $title = lang('s_profile');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $u_name . $title);

        $this->set('u_name', $u_name);
        $this->set('product_status', $product_status);
        $this->set('pin_status', $pin_status);
        $this->set('sponser', $sponser);
        $this->set('details', $details);
        $this->set('years', $aray);
        $this->set('month', $aray1);
        $replica_url=base_url();
        $replica_url=dirname($replica_url);
        $this->set('replica_url',$replica_url);
        $file_name = $this->profile_model->getUserPhoto($user_id);
        if (!file_exists('public_html/images/profile_picture/' . $file_name)) {
            $file_name = 'nophoto.jpg';
        }
        $this->set('file_name', $file_name);
        if ($this->session->userdata('inf_prof_tab_active_arr')) {
            $tab1 = $this->session->userdata['inf_prof_tab_active_arr']['tab1'];
            $tab2 = $this->session->userdata['inf_prof_tab_active_arr']['tab2'];
            $tab3 = $this->session->userdata['inf_prof_tab_active_arr']['tab3'];
            $this->session->unset_userdata('inf_prof_tab_active_arr');
        }
        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->setView();
    }

    function validate_profile_view() {

        $tab1 = '';
        $tab2 = ' active';
        $tab3 = '';
        $this->session->set_userdata('inf_prof_tab_active_arr', array('tab1' => $tab1, 'tab2' => $tab2, 'tab3' => $tab3));
        $this->form_validation->set_rules('name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('username', 'User Name', 'trim|required|');
        $this->form_validation->set_rules('second_name', 'Second Name', 'trim|required|');
        // $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');

        $this->form_validation->set_rules('year', 'Year', 'trim|required');
        $this->form_validation->set_rules('month', 'Month', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');

        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('address', 'Address Line1', 'trim|required');
        $this->form_validation->set_rules('pin', 'Post Code', 'trim|required|alpha_numeric');
//        $this->form_validation->set_rules('address_line2', 'Address Line2', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('passport_id', 'Passport Id', 'trim|required');
        $this->form_validation->set_rules('id_expire', 'Expiry Date', 'trim|required');

        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_message('max_length', 'The %s field can not exceed 20 digits.');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", "</div>");
        $res_val = $this->form_validation->run();
        return $res_val;
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

    function banking() {
        $title = lang('banking');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = "banking";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('banking');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('banking');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();


        $session_data = $this->session->userdata('inf_logged_in');
        $user_id = $session_data['user_id'];
        $banking_details = $this->profile_model->getBankingDetails($user_id);
        $this->set("banking_details", $banking_details);

        if ($this->input->post('save')) {
            $this->form_validation->set_rules('bank', 'Bank name', 'required');
            $this->form_validation->set_rules('branch', 'Branch name', 'required');
            $this->form_validation->set_rules('ifsc', 'ifsc code', 'required');
            $this->form_validation->set_rules('acc_no', 'Account Number', 'required');
            $res_val = $this->form_validation->run();
            if ($res_val) {
                $post_arr = $this->input->post();
                $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
                $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
                $res = $this->profile_model->updateBankingDetails($user_id, $post_arr);
                if ($res) {
                    $msg = lang('details_have_been_saved_successfully');
                    $this->redirect($msg, "profile/banking", TRUE);
                } else {
                    $msg = lang('error_on_updation');
                    $this->redirect($msg, "profile/banking", FALSE);
                }
            } else {
                $error = validation_errors();
                $this->redirect("$error", "profile/banking", FALSE);
            }
        }
        $this->setView();
    }

    function bankdata() {
        $title = lang('verify_bankdata');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);


        $this->HEADER_LANG['page_top_header'] = lang('verify_bankdata');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('verify_bankdata');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();
        
        $user_id=$this->LOG_USER_ID;

        $passport ='';
        $address ='';
        
//        $this->profile_model->uploadDocumentStatus($user_id);
        
        if ($this->input->post('upload')) {
          
            if ($_FILES['passport']['error'] != 4) {
                $config['upload_path'] = './public_html/images/kyc/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload('passport')) {
                    $error = array('error' => $this->upload->display_errors());
//                    print_r($error);die();
                    
//                    $msg = "Image not selected";
//                    $error = array('error' => $this->upload->display_errors());
//                    $this->redirect($msg, 'news/add_news', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $passport = $image_arr['upload_data']['file_name'];
//                    $image = $image_arr['upload_data'];
                  

//                    if ($image['file_name']=="") {
////                        $msg = lang('image_cannot_be_uploaded');
////                        $this->redirect($msg, 'news/add_news', FALSE);
//                    }
                }
            }
            if ($_FILES['address']['error'] != 4) {
                $config['upload_path'] = './public_html/images/kyc/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;

                $this->load->library('upload', $config);
                $msg = '';
                if (!$this->upload->do_upload('address')) {
                      $error = array('error' => $this->upload->display_errors());
//                    print_r($error);die();
//                    $msg = "Image not selected";
//                    $error = array('error' => $this->upload->display_errors());
//                    $this->redirect($msg, 'news/add_news', FALSE);
                } else {
                    $image_arr = array('upload_data' => $this->upload->data());
                    $address = $image_arr['upload_data']['file_name'];
//                    $image = $image_arr['upload_data'];


//                    if ($image['file_name']=="") {
////                        $msg = lang('image_cannot_be_uploaded');
////                        $this->redirect($msg, 'news/add_news', FALSE);
//                    }
                }
            }
            
            
            if($address !='' || $passport !=''){               
                $this->profile_model->uploadDocuments($address,$passport,$user_id);
                
                $msg = lang('document_uploaded');
                $this->redirect($msg, 'profile/bankdata', TRUE);
            }else{
                
                 $msg = lang('document_cannot_be_uploaded');
                 $this->redirect($msg, 'profile/bankdata', FALSE);
            }
            
        }


        $this->setView();
    }

}

?>