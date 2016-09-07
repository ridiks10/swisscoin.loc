<?php

require_once 'Inf_Controller.php';

class member extends Inf_Controller {

    function search_member($action = "", $id = "") {

        $title = lang('member_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('search_member');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('search_member');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "search-member";
        $this->set("help_link", $help_link);
        $flag = FALSE;
        if ($action == "block") {

            $result = $this->member_model->blockMember($id, 'no');
            if ($result) {
                $msg = lang('User_blocked_Successfully');
                $this->redirect($msg, "member/search_member", TRUE);
            } else {
                $msg = lang('Error_on_blocking_User');
                $this->redirect($msg, "member/search_member", FALSE);
            }
        }
        if ($action == "activate") {
            $result = $this->member_model->blockMember($id, 'yes');
            if ($result) {
                $msg = lang('User_Activated_Successfully');
                $this->redirect($msg, "member/search_member", TRUE);
            } else {
                $msg = lang('Error_on_Activating_User');
                $this->redirect($msg, "member/search_member", FALSE);
            }
        }
        if ($this->uri->segment(3) != "")
            $page = $this->uri->segment(3);
        else
            $page = 0;

        if ($this->input->post('search_member') && $this->validate_search_member()) {

            $flag = TRUE;
            $this->set("search_member", $this->input->post('search_member'));
            if ($this->input->post('keyword') != "") {
                $keyword = $this->input->post('keyword');
                $this->session->set_userdata('inf_ser_keyword', $keyword);
            }
            $base_url = base_url() . "member/search_member";
            $config['base_url'] = $base_url;

            $config['per_page'] = 25;

            $mem_arr = $this->member_model->searchMembers($this->session->userdata('inf_ser_keyword'), $page, $config['per_page']);
            $this->set("mem_arr", $mem_arr);

            $numrows = $this->member_model->getCountMembers($this->session->userdata('inf_ser_keyword'));
            $config['total_rows'] = $numrows;
            $this->pagination->initialize($config);

            $this->set("mem_arr", $mem_arr);
            $result_per_page = $this->pagination->create_links();
            $this->set("result_per_page", $result_per_page);
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
        $this->set("flag", $flag);
        $this->set("action_page", $this->CURRENT_URL);
        $this->setView();
    }

    public function validate_search_member() {
        $this->form_validation->set_rules('keyword', "keyword", 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function upgrade_account() {

        $user_id = $this->LOG_USER_ID;
        $active = $this->member_model->isUserActive($user_id, 'no');
        if ($active > 0) {
            $title = lang('activate_account');
            $this->set("title", $this->COMPANY_NAME . " | $title");

            $this->HEADER_LANG['page_top_header'] = lang('activate_account');
            $this->HEADER_LANG['page_top_small_header'] = '';
            $this->HEADER_LANG['page_header'] = lang('activate_account');
            $this->HEADER_LANG['page_small_header'] = '';

            $this->load_langauge_scripts();

            $help_link = "search-member";
            $this->set("help_link", $help_link);

            $upgradeAmount = $this->member_model->getUpgradationAmount();
            $result = '';


            if ($this->input->post('pay') && $this->validate_upgrade_account()) {
                $transaction_password = $this->input->post('transaction_password');

                $this->member_model->begin();
                $tranPass = $this->member_model->isTranPass($user_id, $transaction_password);
                if ($tranPass > 0) {
                    $userBalanceAmount = $this->member_model->getUserBalanceAmount($user_id);
                    if ($upgradeAmount < $userBalanceAmount) {
                        $result = $this->member_model->activateAccountUser($user_id);
                        if ($result) {
                            $balance = $this->member_model->updateUserBalanceAmount($user_id, $upgradeAmount);
                            if ($balance) {
                                $this->member_model->commit();
                                $this->member_model->insertUpgradeHistory($user_id, 'by user', 'yes', 'upgraded by user');
                                $msg = lang('success_update');
                                $this->redirect($msg, "member/upgrade_account", true);
                            } else {
                                $this->member_model->rollback();
                                $msg = 'Error in balance Update';
                                $this->redirect($msg, "member/upgrade_account", false);
                            }
                        } else {
                            $this->member_model->rollback();
                            $msg = lang('error_updation');
                            $this->redirect($msg, "member/upgrade_account", false);
                        }
                    } else {
                        $this->member_model->rollback();
                        $msg = 'Insufficient balance';
                        $this->redirect($msg, "member/upgrade_account", false);
                    }
                } else {
                    $this->member_model->rollback();
                    $msg = 'Invalid transaction password';
                    $this->redirect($msg, "member/upgrade_account", false);
                }
            }
        } else {
            $msg = 'User Already Active';
            $this->redirect($msg, "home", false);
        }

        $this->set('upgradeAmount', $upgradeAmount);
        $this->setView();
    }

    public function validate_upgrade_account() {
        $this->form_validation->set_rules('transaction_password', lang('transaction_password'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('pay', lang('pay'), 'trim|required|strip_tags');
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

        $help_link = "Leads";
        $this->set("help_link", $help_link);

        $user_id = $this->LOG_USER_ID;
	$session_data = $this->session->userdata('inf_logged_in');
	$table_prefix = $session_data['table_prefix'];
	$prefix = str_replace('_', '', $table_prefix);
        $username = $this->member_model->IdToUserName($user_id);
        $this->set("tran_user_name", $username);
        $details = $this->member_model->getLeadDetails($user_id);
        $this->set("details", $details);
        $admin_name = $this->member_model->getadmin_name();
        $this->set("admin_name", $admin_name);
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
                $this->redirect('Lead Capture Updated Successfully', "member/leads", TRUE);
            } else {
                $this->redirect('Unable To Update Lead Capture', "member/leads", TRUE);
            }
        }
    }

    public function invites() {
        $tab1 = ' active';
        $tab2 = '';
        $tab3 = '';
        $tab4 = '';
        $tab5 = '';

        $title = lang('invites');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('invites');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('invites');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "Leads";
        $this->set("help_link", $help_link);


        $user_id = $this->LOG_USER_ID;

        $invite_history_details = $this->member_model->getInviteHistory($user_id);
        //$invite_text=$this->member_model->getInviteTextOptions();
        $invite_text = $this->member_model->getTextInvitesData();
        $invite_text[0]['subject'] = html_entity_decode($invite_text[0]['subject']);
        $invite_text[0]['content'] = html_entity_decode($invite_text[0]['content']);
        
        $social_invite_email = $this->member_model->getSocialInviteData('social_email');
        $social_invite_email['subject'] = html_entity_decode($social_invite_email['subject']);
        $social_invite_email['content'] = html_entity_decode($social_invite_email['content']);
        
        $social_invite_fb = $this->member_model->getSocialInviteData('social_fb');
        $social_invite_fb['subject'] = html_entity_decode($social_invite_fb['subject']);
        $social_invite_fb['content'] = html_entity_decode($social_invite_fb['content']);
        
        $banners = $this->member_model->getBanners();
        $this->set("banners", $banners);
        $this->set("base_url", $this->BASE_URL);

        $this->set("social_invite_email", $social_invite_email);
        $this->set("social_invite_fb", $social_invite_fb);
        $this->set("invite_text", $invite_text);
        $this->set("invite_history_details", $invite_history_details);

        if ($this->input->post('invite') && $this->validate_invite()) {
            //$invite_details = array();
            $invite_details = $this->input->post();
            $invite_details = $this->validation_model->stripTagsPostArray($invite_details);
            $invite_details = $this->validation_model->escapeStringPostArray($invite_details);
            $invite_details['message'] = $this->validation_model->stripTagTextArea($this->input->post('message'));
            $result = $this->member_model->sendInvites($invite_details, $user_id);
            $to_id=$invite_details['to_mail_id'];
            if ($result == 1) {
                        $data_array = array();
                        $data_array['invite_details'] = $invite_details;
                        $data = serialize($data_array);
                $this->validation_model->insertUserActivity($user_id, 'invitation sent', $user_id, $data);
                $msg = lang('invitation_send');
                $this->redirect($msg, "member/invites", TRUE);
            } else {
                $msg = lang('unable_to_send_invitation');
                $this->redirect($msg, "member/invites", FALSE);
            }
        }

        $this->set('tab1', $tab1);
        $this->set('tab2', $tab2);
        $this->set('tab3', $tab3);
        $this->set('tab4', $tab4);
        $this->set('tab5', $tab5);
        $this->setView();
    }

    public function validate_invite() {
        $this->form_validation->set_rules('to_mail_id', 'mail id', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    public function get_message($text_id) {

        $result = $this->member_model->getTextInvitesDataById($text_id);
        echo $result['content'];
    }

    public function get_subject($text_id) {

        $result = $this->member_model->getTextInvitesDataById($text_id);
        echo $result['subject'];
    }

}
