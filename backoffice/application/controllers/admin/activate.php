<?php

require_once 'Inf_Controller.php';

class activate extends Inf_Controller {

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

        $this->form_validation->set_rules('user_name', 'User name', 'required|trim|strip_tags');

        $flag = "";

        if ($this->input->post('select')) {
            if ($this->form_validation->run()) {
                $user_name = $this->input->post('user_name');
                $user_id = $this->validation_model->userNameToID($user_name);
                if ($user_id == 0) {
                    $msg = lang('invalid_username');
                    $this->redirect($msg, "activate/activate_deactivate", false);
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
                $this->redirect($msg, "activate/activate_deactivate", false);
            }
        }
        $this->set("flag", $flag);

        $this->setView();
    }

    public function deactivate_user() {

        $post_arr = $this->input->post();
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
        $is_valid_user = $this->validation_model->isUserAvailable($post_arr['user_id']);
        if (!$is_valid_user) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'activate/activate_deactivate', FALSE);
        }
        $result = $this->activate_model->inactivateAccount($post_arr['user_id'], 'admin');

        if ($result) {
            $data = serialize($post_arr);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'user deactivated', $post_arr['user_id'], $data);
            $msg = lang('user_deactivated');
            $this->redirect($msg, "activate/activate_deactivate", true);
        } else {
            $msg = lang('user_not_deactivated');
            $this->redirect($msg, "activate/activate_deactivate", false);
        }
    }

    public function activate_user() {
        $post_arr = $this->input->post();
        $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
        $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
        $is_valid_user = $this->validation_model->isUserAvailable($post_arr['user_id']);
        if (!$is_valid_user) {
            $msg = lang('invalid_user_name');
            $this->redirect($msg, 'activate/activate_deactivate', FALSE);
        }

        $result = $this->activate_model->activateAccount($post_arr['user_id'], 'admin');
        if ($result) {
            $data = serialize($post_arr);
            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'user activated', $post_arr['user_id'], $data);
            $msg = lang('user_activated');
            $this->redirect($msg, "activate/activate_deactivate", true);
        } else {
            $msg = lang('user_not_activated');
            $this->redirect($msg, "activate/activate_deactivate", false);
        }
    }

    function change_sponsorname() {
        $title = lang('change_sponsor_name');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-sponsor';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_sponsor_name');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_sponsor_name');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($this->input->post('change_sponsor') && $this->validate_change_sponsor()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $user_name = $post_arr['user_name'];
            $sponsor_name = $post_arr['sponsor_user_name'];
            $sponsor_id = $this->validation_model->userNameToID($sponsor_name);
            $user_id = $this->validation_model->userNameToID($user_name);
            $current_sponsor_id = $this->validation_model->getSponsorId($user_id);

            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            $is_valid_sponsor = $this->validation_model->isUserAvailable($sponsor_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'activate/change_sponsorname', FALSE);
            }
            if (!$is_valid_sponsor) {
                $msg = lang('invalid_sponsor_name');
                $this->redirect($msg, 'activate/change_sponsorname', FALSE);
            }

            if ($user_id && $sponsor_id) {
                $result = $this->activate_model->updateSponsorId($user_id, $sponsor_id);
                if ($result) {
                    $this->activate_model->insertSponsorNameChangeHistory($user_id, $current_sponsor_id, $sponsor_id);
                    $msg = lang('sponsor_name_updated_sucessfully');
                    $this->redirect($msg, 'activate/change_sponsorname', TRUE);
                } else {
                    $msg = lang('error_on_sponsor_name_updation');
                    $this->redirect($msg, 'activate/change_sponsorname', FALSE);
                }
            } else {
                $msg = lang('error_on_sponsor_name_updation');
                $this->redirect($msg, 'activate/change_sponsorname', FALSE);
            }
        }
        $this->setView();
    }

    function validate_change_sponsor() {

        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
        $this->form_validation->set_rules('sponsor_user_name', 'Sponsor Name', 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function getCurrentSponsor($user_name = '') {
        $text = '';
        if ($user_name != '' && strcmp($user_name, "/") > 0) {
            $user_id = $this->validation_model->userNameToID($user_name);

            if ($user_id) {
                $sponsor_id = $this->validation_model->getSponsorId($user_id);
                $sponsor_name = $this->validation_model->IdToUserName($sponsor_id);

                $current_sponsor = lang('current_sponsor');
                $text = '<label class="col-sm-3 control-label" for="blnc">' .
                        $current_sponsor . '<b> ' . $sponsor_name . '</b>' .
                        '</label>';
            }
        }
        echo $text;
    }

    function getCurrentPlacementDetails($user_name = '') {
        $text = '';
        if ($user_name != '' && strcmp($user_name, "/") > 0) {
            $user_id = $this->validation_model->userNameToID($user_name);

            if ($user_id) {
                $position = $this->activate_model->getUserPosition($user_id);
                $father_id = $this->validation_model->getFatherId($user_id);
                $father_name = $this->validation_model->IdToUserName($father_id);

                $current_father = lang('current_placement');
                $current_position = lang('current_position');
                $text = '<div class="form-group"><div  class="col-sm-3" style="margin-left:200px;"> '.
                        $current_father . '<b> ' . $father_name . '</b></br></div> <div  class="col-sm-3" style="margin-left:-303px;"></br></br>'.
                        
                        $current_position . '<b> ' . $position . '</b>' .
                        '</div></div>';
            }
        }
        echo $text;
    }

    function change_placement() {
        $title = lang('change_plcement');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'change-placement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('change_plcement');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('change_plcement');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

       if ($this->input->post('change_sponsor') && $this->validate_change_placement()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $user_name = $post_arr['user_name'];
            $user_id = $this->validation_model->userNameToID($user_name);
            $new_user_name = $post_arr['new_user_name'];
            $new_user_placement = $post_arr['placement'];
            $new_user_id = $this->validation_model->userNameToID($new_user_name);

            $is_valid_username = $this->validation_model->isUserAvailable($user_id);
            $is_valid_new_user = $this->validation_model->isUserAvailable($new_user_id);
            if (!$is_valid_username) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'activate/change_placement', FALSE);
            }
            if (!$is_valid_new_user) {
                $msg = lang('invalid_sponsor_name');
                $this->redirect($msg, 'activate/change_placement', FALSE);
            }

            if ($user_id && $new_user_id) {
                $father_id = $this->validation_model->getFatherId($user_id);
                $result = $this->activate_model->ChangeUserPosition($new_user_id, $user_id, $new_user_placement, $father_id);
                if ($result) {
                    $this->activate_model->insertPlacementHistory($user_id, $new_user_id, $new_user_placement);
                    $msg = lang('user_placement_updated_sucessfully');
                    $this->redirect($msg, 'activate/change_placement', TRUE);
                } else {
                    $msg = lang('error_on_user_placement_updation');
                    $this->redirect($msg, 'activate/change_placement', FALSE);
                }
            }
        }
        $this->setView();
    }

     function validate_change_placement() {

        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required');
        $this->form_validation->set_rules('new_user_name', 'New Placement', 'trim|required');
        $this->form_validation->set_rules('placement', 'Placement', 'trim|required');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
    
    
    function checkUserNameAvailability() {
        $user_name = $this->input->post("user_name");
        if ($user_name) {
            $username_exist = $this->activate_model->checkUsernameExist($user_name);
            if ($username_exist) {

                echo "yes";
            } else {

                echo "no";
            }
        } else {
            echo "no";
        }
    }

}
