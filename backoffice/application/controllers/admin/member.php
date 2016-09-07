<?php

require_once 'Inf_Controller.php';

/**
 * @property-read member_model $member_model Member model
 */
class member extends Inf_Controller {

    function search_member($id = "") {
        $title = lang('search_member');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('search_member');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('search_member');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "search-member";
        $this->set("help_link", $help_link);

        $this->set("mem_arr", "");
        $this->set("count", "");

        $mem_arr = array();
        $msg = '';
        $flag = false;
        $config['uri_segment'] = 5;
        $base_url = base_url() . "admin/member/search_member/tab";

        if ($this->uri->segment(4) != "") {
            $page = $this->uri->segment(5);
            $flag = true;
        } else
            $page = 0;

        if ($this->input->post('search_member') && $this->validate_search_member() && $this->validate_member()) {
            $flag = true;
        } else {
            $error_array = $this->form_validation->error_array();
            $this->session->set_userdata('inf_search_member_error', $error_array);
        }
        $error_array = array();
        if ($this->session->userdata('inf_search_member_error')) {
            $error_array = $this->session->userdata('inf_search_member_error');
            $this->session->unset_userdata('inf_search_member_error');
        }
        $this->set('error_array', $error_array);
        $this->set('error_count', count($error_array));

        $config['base_url'] = $base_url;
        $config['num_links'] = 5;
        $numrows = $this->member_model->getCountMembers($this->session->userdata('inf_ser_keyword'));
        $config['per_page'] = $flag ? 50 : 1;
        $config['total_rows'] = $numrows;

        $mem_details_arr = $this->member_model->searchMembers($this->session->userdata('inf_ser_keyword'), $page, $config['per_page']);
        $this->set("mem_arr", $mem_details_arr);
        $count = count($mem_details_arr);
        $this->set("count", $count);
        $this->set('flag', $flag);

        $this->pagination->initialize($config);
        $this->set("mem_arr", $mem_details_arr);
        $result_per_page = $this->pagination->create_links();
        $this->set("result_per_page", $result_per_page);
        $this->set("action_page", $this->CURRENT_URL);

        $this->setView();
    }

    public function validate_member() {
        $this->form_validation->set_rules('keyword', 'Keyword', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function validate_search_member() {

        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
        $keyword = $post_arr['keyword'];

        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {

            $check_user_id = $this->validation_model->userNameToID($keyword);
            $check_user_type = $this->validation_model->getUserType($check_user_id);
            if ($check_user_type == 'admin') {
                $msg = lang('you_cant_access_admin');
                $this->redirect($msg, "member/search_member", FALSE);
            }
        }

        if ($keyword != "" && $keyword != "'") {

            $this->session->set_userdata('inf_ser_keyword', $keyword);
        }

        return true;
    }

    public function validate_search_leads() {
//   $this->form_validation->set_rules('keyword', 'keyword', 'trim|required');
//    $validation_status = $this->form_validation->run();
//        return $validation_status;
//        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
//        $keyword = $post_arr['keyword'];
//
//        if ($keyword != "" && $keyword != "'") {
//
//            $this->session->set_userdata('inf_ser_keyword', $keyword);
//        }

        return true;
    }

    function upgrade_account() {
        $title = lang('upgrade_account');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('upgrade_account');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('upgrade_account');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "search-member";
        $this->set("help_link", $help_link);

        $result = '';

        if ($this->input->post('activate') && $this->validate_upgrade_account()) {
            $activate_post_array = $this->input->post();
            $activate_post_array = $this->validation_model->stripTagsPostArray($activate_post_array);
            $activate_post_array = $this->validation_model->escapeStringPostArray($activate_post_array);
            $activate_post_array['remarks'] = $this->validation_model->stripTagTextArea($this->input->post('remarks'));
            $user_name = $activate_post_array['user_name'];
            $remarks = $activate_post_array['remarks'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $active = $this->member_model->isUserActive($user_id, 'no');
            if ($active > 0) {
                $result = $this->member_model->activateAccount($user_id);
                if ($result) {
                    $this->member_model->insertUpgradeHistory($user_id, 'by admin', 'yes', $remarks);
                    $msg = lang('success_update');
                    $this->redirect($msg, "member/upgrade_account", true);
                } else {
                    $msg = lang('error_updation');
                    $this->redirect($msg, "member/upgrade_account", false);
                }
            } else {
                $msg = "user is already active";
                $this->redirect($msg, "member/upgrade_account", false);
            }
        }

        if ($this->input->post('inactivate') && $this->validate_upgrade_account()) {
            $inactivate_post_array = $this->input->post();
            $inactivate_post_array = $this->validation_model->stripTagsPostArray($inactivate_post_array);
            $inactivate_post_array = $this->validation_model->escapeStringPostArray($inactivate_post_array);
            $inactivate_post_array['remarks'] = $this->validation_model->stripTagTextArea($this->input->post('remarks'));
            $user_name = $inactivate_post_array['user_name'];
            $remarks = $inactivate_post_array['remarks'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $active = $this->member_model->isUserActive($user_id, 'yes');
            if ($active > 0) {
                $result = $this->member_model->inactivateAccount($user_id);
                if ($result) {
                    $this->member_model->insertUpgradeHistory($user_id, 'by admin', 'no', $remarks);
                    $msg = lang('success_degrade');
                    $this->redirect($msg, "member/upgrade_account", true);
                } else {
                    $msg = lang('error_upgrade');
                    $this->redirect($msg, "member/upgrade_account", false);
                }
            } else {
                $msg = "user is already inactive";
                $this->redirect($msg, "member/upgrade_account", false);
            }
        }

        $this->setView();
    }

    public function validate_upgrade_account() {
        $this->form_validation->set_rules('user_name', lang('user_name'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('remarks', lang('remarks'), 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function leads() {

        $title = lang('lead');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('lead');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('lead');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $lcp_url = base_url() . "../";

        $help_link = "Leads";
        $this->set("help_link", $help_link);
        $this->set("lcp_url", $lcp_url);

        $user_id = $this->LOG_USER_ID;
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $prefix = str_replace('_', '', $table_prefix);
        $key_word = '';
        $username = $this->member_model->IdToUserName($user_id);
        $this->set("tran_user_name", $username);
        $details = $this->member_model->getLeadDetails($user_id, $key_word);
        if ($this->input->post('search_lead')) {
            $key_word = $this->input->post('keyword');
            if ($key_word != '') {
                $details = $this->member_model->getLeadDetails($user_id, $key_word);
            }
        }
        $this->set("details", $details);
        $lead_url = $this->member_model->getLeadUrl();
        $this->set("lead_url", $lead_url);
        $this->set("id", $user_id);
        $this->set("prefix", $prefix);

        $this->setView();
    }

    public function getleads($id = '') {
        $details = $this->member_model->getLeadDetailsById($id);
        $pending_status = '';
        $following_status = '';
        $reg_status = '';
        $dec_status = '';
        if ($details['status'] == 'pending') {
            $pending_status = 'selected';
        } elseif ($details['status'] == 'following') {
            $following_status = 'selected';
        } elseif ($details['status'] == 'registered') {
            $reg_status = 'selected';
        } elseif ($details['status'] == 'declined') {
            $dec_status = 'selected';
        }
        echo "<form action='edit_Lead_Capture' method='post' >
            <table  border='0'  align=''>
                <tr>
                    <td align='left'>Name : </td>
                    <td align='left'>$details[name]</td>
                </tr>
                <tr>
                    <td align='left'>Sponser Name : </td>
                    <td align='left'>$details[sponser_name]</td>
                </tr>
                <tr>
                    <td align='left'>Email : </td>
                    <td align='left'>$details[email]</td>
                </tr>
                <tr>
                    <td align='left'>Phone : </td>
                    <td align='left'>$details[phone]</td>
                </tr>
                <tr>
                    <td align='left'>Date : </td>
                    <td align='left'>$details[date]</td>
                </tr>
                <tr>
                    <td align='left'>Comment : </td>
                    <td align='left' >$details[comment]</td>
                </tr>
                <tr>
                    <td align='left'>Add comment  : </td>
                    <td align='left'><textarea id='admin_comment' name='admin_comment' class='form-control'>$details[admin_comment]</textarea></td>
                </tr>
                <tr>
                <td align='left'>status  :</td>
                <td align='left'>
                
                <select name='status' id='status' class='form-control' >
                
                                        <option value='pending' $pending_status>Pending</option>
                                        <option value='following' $following_status>Following</option>
                                        <option value='registered' $reg_status>Registered</option>
                                        <option value='declined' $dec_status>Declined</option>
                                        
                                    </select>  
                    
                    </td>
                </tr>
                
            </table><br />
            <input type='hidden' name='lead_id' id='lead_id' value='$details[id]'>
            
            <input value='Update' id='edit_lead' name='edit_lead' class='btn btn-bricky' type='submit'>
        </form>";
    }

    public function edit_Lead_Capture() {
        if ($this->input->post('edit_lead')) {
            $det = $this->input->post();
            $det = $this->validation_model->stripTagsPostArray($det);
            $det = $this->validation_model->escapeStringPostArray($det);
            $res = $this->member_model->updateLeadCapture($det);
            if ($res) {
                $msg = lang('lead_capture_updated');
                $this->redirect($msg, "member/leads", TRUE);
            } else {
                $msg = lang('unable_to_update_lead_capture');
                $this->redirect($msg, "member/leads", FALSE);
            }
        }
    }

    public function text_invite_configuration() {
        $title = lang('text_invite');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('text_invite');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('text_invite');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'text invite';
        $this->set("help_link", $help_link);

        $mail_data = $this->member_model->getTextInvitesData();
        $this->set("mail_data", $mail_data);

        if ($this->input->post('update') && $this->validate_invite_text()) {

            $update_post_array = $this->input->post();
            $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
            $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);
            $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
            $update_post_array['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));

            $mail_content['mail_content'] = $update_post_array['mail_content'];
            $mail_content['subject'] = $update_post_array['subject'];
            $res = $this->member_model->insertTextInvites($mail_content);
            if ($res) {
                $data = serialize($update_post_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite added', $this->LOG_USER_ID, $data);
                $msg = lang('invite_text_added');
                $this->redirect($msg, "member/text_invite_configuration", true);
            } else {
                $msg = lang('invite_text_not_added');
                $this->redirect($msg, "member/text_invite_configuration", false);
            }
        }

        $this->setView();
    }

    public function edit_invite_text() {

        if ($this->input->post('invite_text_id')) {
            $title = 'text invite';
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $this->HEADER_LANG['page_top_header'] = 'text invite';
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = 'text invite';
            $this->HEADER_LANG['page_small_header'] = '';

            $this->load_langauge_scripts();

            $help_link = 'text invite';
            $this->set("help_link", $help_link);

            $edit_id = $this->input->post('invite_text_id');
            $mail_details = $this->member_model->getTextInvitesDataById($edit_id);
            $this->set('mail_details', $mail_details);
            if ($this->input->post('update')) {
                $update_post_array = $this->input->post();
                $update_post_array = $this->validation_model->stripTagsPostArray($update_post_array);
                $update_post_array = $this->validation_model->escapeStringPostArray($update_post_array);
                $update_post_array['mail_content'] = $this->validation_model->stripTagTextArea($this->input->post('mail_content'));
                if ($this->validate_invite_text()) {
                    $mail_content['mail_content'] = $update_post_array['mail_content'];
                    $mail_content['subject'] = $update_post_array['subject'];
                    $mail_content['id'] = $update_post_array['invite_text_id'];
                    $res = $this->member_model->editTextInvites($mail_content);
                    if ($res) {
                        $data = serialize($update_post_array);
                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite edited', $this->LOG_USER_ID, $data);
                        $msg = lang('updated_invite_text');
                        $this->redirect($msg, "member/text_invite_configuration", true);
                    } else {
                        $msg = lang('invite_text_not_updated');
                        $this->redirect($msg, "member/text_invite_configuration", false);
                    }
                }
            }

            $this->setView();
        } else {
            $this->redirect('', "member/text_invite_configuration", true);
        }
    }

    public function validate_invite_text() {
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('mail_content', 'Content', 'required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function delete_invite_text() {
        $invite_text_id = strip_tags($this->input->post('invite_text_id'));
        $res = $this->member_model->deleteInviteText($invite_text_id);
        if ($res) {
            $data_array['text_invite_id'] = $invite_text_id;
            $data = serialize($data_array);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'text invite deleted', $this->LOG_USER_ID, $data);
            $msg = lang('invite_text_deleted');
            $this->redirect($msg, "member/text_invite_configuration", true);
        } else {
            $msg = lang('invite_text_not_deleted');
            $this->redirect($msg, "member/text_invite_configuration", false);
        }
    }

    public function invite_wallpost_config() {
        $title = lang('social_invites');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('social_invites');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('social_invites');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'wallpost';
        $this->set("help_link", $help_link);

        $social_invite_email = $this->member_model->getSocialInviteData('social_email');
        $social_invite_email['subject'] = html_entity_decode($social_invite_email['subject']);
        $social_invite_email['content'] = html_entity_decode($social_invite_email['content']);
        $social_invite_fb = $this->member_model->getSocialInviteData('social_fb');
        $social_invite_fb['subject'] = html_entity_decode($social_invite_fb['subject']);
        $social_invite_fb['content'] = html_entity_decode($social_invite_fb['content']);
        $this->set("social_invite_email", $social_invite_email);
        $this->set("social_invite_fb", $social_invite_fb);
        if ($this->input->post('submit_email') && $this->validate_invite_social_email()) {
            $details = $this->input->post();
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('subject'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $res = $this->member_model->insertsocialInvites($details, 'social_email');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'email invite updated', $this->LOG_USER_ID, $data);
                $msg = lang('email_invite_updated');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_update_email_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        if ($this->input->post('submit_fb') && $this->validate_invite_social_fb()) {
            $details['subject'] = $this->validation_model->stripTagTextArea($this->input->post('caption'));
            $details['message'] = $this->validation_model->stripTagTextArea($this->input->post('description'));
            $res = $this->member_model->insertsocialInvites($details, 'social_fb');
            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'facebook invite updated', $this->LOG_USER_ID, $data);
                $msg = lang('fb_invite_updated');
                $this->redirect($msg, "member/invite_wallpost_config", true);
            } else {
                $msg = lang('unable_to_update_fb_invite');
                $this->redirect($msg, "member/invite_wallpost_config", false);
            }
        }
        $this->setView();
    }

    public function validate_invite_social_email() {
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function validate_invite_social_fb() {
        $this->form_validation->set_rules('caption', 'Caption', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function invite_banner_config() {
        $title = lang('banner');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('banner');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('banner');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'banner';
        $this->set("help_link", $help_link);
        $banners = $this->member_model->getBanners();
        $this->set("banners", $banners);

        if ($this->input->post('banner')) {

            $details = array();

            $config['upload_path'] = './public_html/images/banners/';
            $config['allowed_types'] = 'png';
            $config['max_size'] = '20000000';
            $config['remove_spaces'] = true;
            $config['overwrite'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('banner_image')) {
                $error = array('error' => $this->upload->display_errors());
                $error = $this->validation_model->stripTagsPostArray($error);
                $error = $this->validation_model->escapeStringPostArray($error);
                if ($error['error'] == 'You did not select a file to upload.') {
                    $msg = lang('please_select_file');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                }
                if ($error['error'] == 'The file you are attempting to upload is larger than the permitted size.') {
                    $msg = lang('max_size_20MB');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                }
                if ($error['error'] == 'The filetype you are attempting to upload is not allowed.') {
                    $msg = lang('please_choose_a_png_file.');
                    $this->redirect($msg, "member/invite_banner_config/", false);
                } else {
                    $msg = 'Error uploading file';
                    $this->redirect($msg, 'member/invite_banner_config', false);
                }
            } else {
                $banner_arr = array('upload_data' => $this->upload->data());
            }
            $details['product_url'] = $banner_arr['upload_data']['file_name'];
            $res = $this->member_model->insertBanner($banner_arr['upload_data']['file_name']);

            if ($res) {
                $data = serialize($details);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite added', $this->LOG_USER_ID, $data);
                $msg = lang('banner_added');
                $this->redirect($msg, "member/invite_banner_config/", TRUE);
            } else {
                $msg = lang('banner_not_added');
                $this->redirect($msg, "member/invite_banner_config/", FALSE);
            }
        }
        $this->setView();
    }

    public function delete_banner() {
        $banner_id = $this->input->post('banner_id');

        $res = $this->member_model->deleteBanner($banner_id);
        if ($res) {
            $data_array['banner_id'] = $banner_id;
            $data = serialize($data_array);
                $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'banner invite deleted', $this->LOG_USER_ID, $data);
            $msg = lang('banner_deleted');
            $this->redirect($msg, "member/invite_banner_config", true);
        } else {
            $msg = lang('banner_not_deleted');
            $this->redirect($msg, "member/invite_banner_config", false);
        }
    }

    public function activate_deactivate() {
        $title = lang('activate_deactivate');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('activate_deactivate');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('activate_deactivate');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = 'activate_deactivate';
        $this->set("help_link", $help_link);

        $this->form_validation->set_rules('user_name', 'User name', 'required');

        $flag = "";

        if ($this->input->post('select')) {
            if ($this->form_validation->run()) {
                $user_name = strip_tags($this->input->post('user_name'));
                $user_id = $this->validation_model->userNameToID($user_name);
                if ($user_id == 0) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, "member/activate_deactivate", false);
                }
                $active = $this->validation_model->isUserActive($user_id);
                $user_details = array();
                $user_details['user_name'] = $user_name;
                $user_details['name'] = $this->validation_model->getUserFullName($user_id);
                $sponser_id_name = $this->validation_model->getSponserIdName($user_id);
                $user_details['sponser_name'] = $sponser_id_name['name'];
                $user_details['mobile_no'] = $this->validation_model->getUserPhoneNumber($user_id);
                $user_details['address'] = $this->validation_model->getUserAddress($user_id);
                $this->set("user_details", $user_details);
                $this->set("user_id", $user_id);
                $this->set("active", $active);
                $flag = "true";
            } else {
                $msg = lang('you_must_enter_username');
                $this->redirect($msg, "member/activate_deactivate", false);
            }
        }
        $this->set("flag", $flag);

        $this->setView();
    }

    public function deactivate_user() {
        $this->load_langauge_scripts();

        $user_id = strip_tags($this->input->post('user_id'));
        $res = $this->member_model->inactivateAccount($user_id, 'admin');

        if ($res) {
            $msg = lang('user_deactivated');
            $this->redirect($msg, "member/activate_deactivate", true);
        } else {
            $msg = lang('user_not_deactivated');
            $this->redirect($msg, "member/activate_deactivate", false);
        }
    }

    public function activate_user() {
        $this->load_langauge_scripts();

        $user_id = strip_tags($this->input->post('user_id'));
        $res = $this->member_model->activateAccount($user_id, 'admin');

        if ($res) {
            $msg = lang('user_activated');
            $this->redirect($msg, "member/activate_deactivate", true);
        } else {
            $msg = lang('user_not_activated');
            $this->redirect($msg, "member/activate_deactivate", false);
        }
    }
    
    
    
     


}
