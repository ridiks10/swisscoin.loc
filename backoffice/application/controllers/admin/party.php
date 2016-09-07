<?php

require_once 'Inf_Controller.php';

/**
 * @property-read party_model $party_model 
 */
class Party extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function host_manager() {
        $title = lang('host_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('host_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('host_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $id = $this->LOG_USER_ID;
        $data = $this->party_model->getHostAllDetails($id);
        $this->set('data', $data);

        $help_link = "host_management";
        $this->set("help_link", $help_link);

        if ($this->input->post("change")) {
            $change_post_array = $this->input->post();
            $change_post_array = $this->validation_model->stripTagsPostArray($change_post_array);
            $change_post_array = $this->validation_model->escapeStringPostArray($change_post_array);
            $crt['country'] = $change_post_array['country'];
            $crt['firstname'] = $change_post_array['firstname'];
            $crt['lastname'] = $change_post_array['lastname'];
            $crt['address'] = $change_post_array['address'];
            $crt['city'] = $change_post_array['city'];
            $crt['state'] = $change_post_array['state'];
            $crt['zip'] = $change_post_array['zip'];
            $crt['phone'] = $change_post_array['phone'];
            $crt['email'] = $change_post_array['email'];
            $res = $this->party_model->editHostDetails($crt, $edit_id);
            if ($res) {
                $msg = lang('host_details_edited');
                $this->redirect($msg, "party/host_manager", TRUE);
            } else {
                $msg = lang('error_on_edit');
                $this->redirect($msg, "party/create_host/edit/$edit_id", FALSE);
            }
        }

        $this->setView();
    }

    function create_host($action = '', $edit_id = '') {
        $title = lang('host_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('host_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('host_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "host_management";
        $this->set("help_link", $help_link);

        if ($action == "edit") {
            $row = $this->party_model->getEditHostDetails($edit_id);
            $this->set('first_name', $row->first_name);
            $this->set('last_name', $row->last_name);
            $this->set('address', $row->address);
            $this->set('city', $row->city);
            $this->set('state', $row->state);
            $state_name = $this->country_state_model->getStateNameFromId($row->state);
            $this->set('zip', $row->zip);
            $this->set('email', $row->email);
            $this->set('phone', $row->phone);
            $this->set('country', $row->country);
            $this->set('state_name', $state_name);

            $this->set('action', $action);
            $this->set('action_page', "../../create_host");
        } else {

            $this->set('first_name', "");
            $this->set('last_name', "");
            $this->set('address', "");
            $this->set('city', "");
            $this->set('state', "");
            $this->set('zip', "");
            $this->set('email', "");
            $this->set('phone', "");
            $this->set('country', "");
            $this->set('action', "");
            $this->set('action_page', "create_host");
        }
        $countries = $this->country_state_model->getCountries('');
        $this->set('countries', $countries);
        $states = $this->country_state_model->viewState(223);
        $this->set('states', $states);
        if ($this->input->post("submit") && $this->validate_create_host()) {
            $host_array = $this->input->post();
            $host_array = $this->validation_model->stripTagsPostArray($host_array);
            $host_array = $this->validation_model->escapeStringPostArray($host_array);

            $id = $this->LOG_USER_ID;

            $res = $this->party_model->saveNewHostDetails($host_array, $id);
            if ($res) {
                $msg = lang('new_host_created');
                $this->redirect($msg, "party/host_manager", TRUE);
            } else {
                $msg = lang('new_host_creation_failed');
                $this->redirect($msg, "party/create_host", FALSE);
            }
        }
        if ($this->input->post("change") && $this->validate_create_host()) {
            $change_post_array = $this->input->post();
            $change_post_array = $this->validation_model->stripTagsPostArray($change_post_array);
            $change_post_array = $this->validation_model->escapeStringPostArray($change_post_array);

            $res = $this->party_model->editHostDetails($change_post_array, $edit_id);
            if ($res) {
                $msg = lang('host_details_edited');
                $this->redirect($msg, "party/host_manager", TRUE);
            } else {
                $msg = lang('error_on_edit');
                $this->redirect($msg, "party/create_host/edit/$edit_id", FALSE);
            }
        }

        $this->setView();
    }

    public function validate_create_host() {

        $create_host_arr = $this->input->post();
        $country_name = "NA";
        if ($create_host_arr['country'] != "") {
            $country_name = $this->country_state_model->getCountryNameFromId($create_host_arr['country']);
        }
        $create_host_arr['country_name'] = $country_name;
        $this->session->set_userdata('inf_create_host_arr', $create_host_arr);
        if ($this->session->userdata("inf_create_host_arr")) {
            $create_host_arr = $this->session->userdata("inf_create_host_arr");
        }
        $this->set('create_host_arr', $create_host_arr);
        $this->form_validation->set_rules('country', lang('country'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('firstname', lang('firstname'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('lastname', lang('lastname'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|strip_tags|callback_alpha_city_address');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('zip', lang('zip'), 'trim|required|numeric|strip_tags');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|numeric|strip_tags');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }
  function _alpha_city_address($str_in = '') {
        if (!preg_match("/^([a-zA-Z0-9\s\.\, ])+$/i", $str_in)) {
            $this->form_validation->set_message('_alpha_city_address', 'The %s field may only contain alphabets, numerals, white spaces, commas and periods');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    function delete_host($action = '', $delete_id = '') {

        if ($action == "delete") {
            $redirect_msg = "";
            $result = $this->party_model->deleteHost($delete_id);

            if ($result) {

                $redirect_msg = lang('host_deleted_successfully');
                $this->redirect($redirect_msg, "party/host_manager", TRUE);
            } else {
                $redirect_msg = lang('error_on_host_deletion');
                $this->redirect($redirect_msg, "party/host_managerparty/host_manager", FALSE);
            }
        }
    }

    function guest_manager() {
        $title = lang('guest_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('guest_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('guest_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "guest_management";
        $this->set("help_link", $help_link);

        $id = $this->LOG_USER_ID;
        $data = $this->party_model->getGuestDetails($id);
        $this->set('data', $data);

        $this->setView();
    }

    function create_guest($action = '', $edit_id = '') {

        $title = lang('guest_management');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('guest_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('guest_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "guest_management";
        $this->set("help_link", $help_link);

        if ($action == "edit") {

            $row = $this->party_model->getEditGuestDetails($edit_id);

            $this->set('first_name', $row->first_name);
            $this->set('last_name', $row->last_name);
            $this->set('address', $row->address);
            $this->set('city', $row->city);
            $this->set('state', $row->state);
            $state_name = $this->country_state_model->getStateNameFromId($row->state);
            $this->set('zip', $row->zip);
            $this->set('email', $row->email);
            $this->set('phone', $row->phone);
            $this->set('state_name', $state_name);
            $this->set('country', $row->country);
            $this->set('action', $action);
            $this->set('action_page', "../../create_guest");
        } else {
            $this->set('first_name', "");
            $this->set('last_name', "");
            $this->set('address', "");
            $this->set('city', "");
            $this->set('state', "");
            $this->set('zip', "");
            $this->set('email', "");
            $this->set('phone', "");
            $this->set('country', "");
            $this->set('action', "");
            $this->set('action_page', "create_guest");
        }

        $countries = $this->country_state_model->getCountries('');
        $states = $this->country_state_model->viewState(223);
        $this->set('countries', $countries);
        $this->set('states', $states);

        if ($this->input->post("submit") && $this->validate_create_guest()) {

            $guest_array = $this->input->post();
            $guest_array = $this->validation_model->stripTagsPostArray($guest_array);
            $guest_array = $this->validation_model->escapeStringPostArray($guest_array);

            $id = $this->LOG_USER_ID;
            $res = $this->party_model->saveNewGuestDetails($guest_array, $id);
            if ($res) {
                $msg = lang('new_guest_created');
                if ($action == "add_more") {
                    $this->redirect($msg, "party/invite_guest", TRUE);
                } else if ($action == "enter_order") {
                    $party_id = $this->session->userdata('inf_party_id');
                    $selected_id[0] = $this->party_model->getMaxGuestId();
                    $result = $this->party_model->addGuestInvitedDetails($selected_id, $id, $party_id);
                    if ($result) {
                        $msg = lang('new_guest_created_invite_to_party');
                        $this->redirect($msg, "party_guest_order/guest_orders", TRUE);
                    } else {
                        $msg = lang('guest_invite_failed');
                        $this->redirect($msg, "party/invite_guest", FALSE);
                    }
                } else {
                    $this->redirect($msg, "party/guest_manager", TRUE);
                }
            } else {
                $msg = lang('new_guest_created_failed');
                $this->redirect($msg, "party/create_guest", FALSE);
            }
        }

        if ($this->input->post("change") && $this->validate_create_guest()) {

            $change_post_array = $this->input->post();
            $change_post_array = $this->validation_model->stripTagsPostArray($change_post_array);
            $change_post_array = $this->validation_model->escapeStringPostArray($change_post_array);
            $res = $this->party_model->editGuestDetails($change_post_array, $edit_id);
            if ($res) {
                $msg = lang('guest_details_edit"');
                $this->redirect($msg, "party/guest_manager", TRUE);
            } else {
                $msg = lang('error_on_edit');
                $this->redirect($msg, "party/create_guest/edit/$edit_id", FALSE);
            }
        }

        $this->setView();
    }

    public function validate_create_guest() {

        $create_guest_arr = $this->input->post();
        $country_name = "NA";
        if ($create_guest_arr['country'] != "") {
            $country_name = $this->country_state_model->getCountryNameFromId($create_guest_arr['country']);
        }
        $create_guest_arr['country_name'] = $country_name;
        $this->session->set_userdata('inf_create_guest_arr', $create_guest_arr);
        if ($this->session->userdata("inf_create_guest_arr")) {
            $create_guest_arr = $this->session->userdata("inf_create_guest_arr");
        }
        $this->set('create_guest_arr', $create_guest_arr);
        $this->form_validation->set_rules('country', lang('country'), 'trim|required|strip_tags');
        $this->form_validation->set_rules('firstname', lang('firstname'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('lastname', lang('lastname'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('address', lang('address'), 'trim|required|strip_tags|callback_alpha_city_address');
        $this->form_validation->set_rules('city', lang('city'), 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('zip', lang('zip'), 'trim|required|numeric|strip_tags');
        $this->form_validation->set_rules('phone', lang('phone'), 'trim|required|numeric|strip_tags');
        $this->form_validation->set_rules('email', lang('email'), 'trim|required|valid_email|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

    function view_order($id = '') {
        $title = lang('view_order');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('view_order');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('view_order');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "view_order";
        $this->set("help_link", $help_link);

        $order = $this->party_model->getProductOrder($id);
        $this->set('order', $order);
        $det = $this->party_model->guestDetails($id);
        $this->set('det', $det);

        $this->setView();
    }

    function delete_guest($action = '', $delete_id = '') {

        if ($action == "delete") {
            $redirect_msg = "";
            $result = $this->party_model->deleteGuest($delete_id);

            if ($result) {
                $redirect_msg = lang('guest_deleted_successfully');
                $this->redirect($redirect_msg, "party/guest_manager", TRUE);
            } else {
                $redirect_msg = lang('error_on_guest_deletion');
                $this->redirect($redirect_msg, "party/guest_manager", FALSE);
            }
        }
    }

    function invite_guest() {
        $title = lang('invite_guest');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('invite_guest');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('invite_guest');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $this->set("action_page", $this->CURRENT_URL);

        $id = $this->LOG_USER_ID;
        $party_id = $this->session->userdata('inf_party_id');
        $data = $this->party_model->getSelectedGuestDetails($id, $party_id);
        $this->set('data', $data);

        if ($this->input->post("sent_evite")) {
            $count = $this->input->post("count");
            if (is_numeric($count) && $count > 0) {
                $j = 0;
                for ($i = 0; $i < $count; $i++) {

                    if ($this->input->post("select" . $i) == "yes") {

                        $selected_id[$j] = strip_tags($this->input->post("selected_id" . $i));
                        $j++;
                    }
                }

                if ($j == 0) {
                    $redirect_msg = lang('please_select_a_guest');
                    $this->redirect($redirect_msg, "party/invite_guest", FALSE);
                }

                $result = $this->party_model->addGuestInvitedDetails($selected_id, $id, $party_id);

                if ($result) {
                    $redirect_msg = lang('guest_invited_sucessfully');
                    $this->redirect($redirect_msg, "party/invite_guest", TRUE);
                } else {
                    $redirect_msg = lang('error_on_guest_invitation');
                    $this->redirect($redirect_msg, "party/invite_guest", FALSE);
                }
            } else {
                $redirect_msg = lang('error_on_guest_invitation');
                $this->redirect($redirect_msg, "party/invite_guest", FALSE);
            }
        }

        $help_link = "invite_guest";
        $this->set("help_link", $help_link);

        $this->setView();
    }

    public function get_states($country_code) {
        $tran_state = "state";
        $state_select .= '<select name="state" id="state" tabindex="15" ';

        $option = "select state";
        $state_select .= $this->country_state_model->viewState($country_code, $option);
        $state_select .= '</select>';

        echo $state_select;
    }

    function get_statesAdd($country_id) {
        $state_select = '';

        $state_string = $this->country_state_model->viewState($country_id);
        if ($state_string != '') {
            $state_select.="<option value =''>" . $this->lang->line('select_state') . "</option>";
            $state_select.=$state_string;
        } else {
            $state_select.="<option value='0'>--No data Available--</option>";
        }
        $state_select .= '</select></div>';
        echo $state_select;
        exit();
    }

}
