<?php

require_once 'Inf_Controller.php';

class party_setup extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function create_party() {
        $title = lang('setup_party');
        $this->set("title", $this->COMPANY_NAME . " | $title");
        $this->set('action_page', $this->CURRENT_URL);

        $help_link = "create_party";
        $this->set("help_link", $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('setup_party');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('setup_party');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $countries = $this->country_state_model->getCountries('');
        $this->set('countries', $countries);

        $user_id = $this->LOG_USER_ID;

        $host_arr = $this->party_setup_model->getAllHosts($user_id);
        $this->set("host_arr", $host_arr);
        $lang_id = $this->LANG_ID;
        $current_date = strtotime(date('Y-m-d H:i A'));

        $party = array();
        if ($this->input->post('submit') && $this->validate_setup_party()) {
            $party = $this->input->post();
            $party = $this->validation_model->stripTagsPostArray($party);
            $party = $this->validation_model->escapeStringPostArray($party);

            $party_name = $party['party_name'];
            $host = $party['host'];
            $party['user_id'] = $user_id;
            if ($host == 'old') {////select host from list
                $party['host_id'] = $party['host_id'];
            }
            if ($host == 'new') {////create new host
                $party['host_state'] = $party['state'];
                $this->party_setup_model->addNewHost($party, $user_id);

                $party['host_id'] = $this->party_setup_model->getNewHostId($user_id);
            }
            if ($host == 'iam') {//////logged user as host
                $party['host_id'] = $this->party_setup_model->getUserAsHostId($party['user_id']);
            }

            $add_address = $party['address'];
            $party['address_type'] = $add_address;
            if ($add_address != "") {
                if ($add_address == "host_address") {

                    $party['address'] = $this->party_setup_model->getHostAddress($party['host_id']);
                }
                if ($add_address == "user_address") {

                    $party['address'] = $this->party_setup_model->getUserAddress($party['user_id']);
                }
                if ($add_address == "new_address") {
                    $party['address'] = $party['address_new'];
                    $party['state'] = $party['new_state'];
                }
            }

            $party_start_time = strtotime($party['from_date'] . " " . $party['from_time']);
            $party_end_time = strtotime($party['to_date'] . " " . $party['to_time']);

            if (($current_date > $party_start_time) || ($current_date > $party_end_time)) {

                $msg = lang('party_date_should_be_greater_than_current_date');
                $this->redirect($msg, 'party_setup/create_party', false);
            }
            if (($party_start_time < $party_end_time)) {

                $res = $this->party_setup_model->insertNewParty($party, $party_name, $add_address);
                if ($res) {
                    $party_id = $this->party_setup_model->getCreatedPartyId();
                    $msg = lang('your_party_has_been_created');
                    $this->redirect($msg, "party_setup/promote_party/$party_id", true);
                } else {
                    $msg = lang('party_not_created');
                    $this->redirect($msg, 'party_setup/create_party', FALSE);
                }
            } else {

                $msg = lang('invalid_from_date_and_to_date');
                $this->redirect($msg, 'party_setup/create_party', false);
            }
        }
        $this->set("lang_id", $lang_id);
        $this->setView();
    }

    function validate_setup_party() {
        $party_setup_arr = $this->input->post();

        $party_name = "NA";
        if ($party_setup_arr['host_id'] != "") {
            $party_name = $this->party_setup_model->getHostName($party_setup_arr['host_id']);
        }

        $party_setup_arr['host_party_name'] = $party_name;
        $this->session->set_userdata('inf_party_setup_arr', $party_setup_arr);
        if ($this->session->userdata("inf_party_setup_arr")) {
            $party_setup_arr = $this->session->userdata("inf_party_setup_arr");
        }

        $this->set('party_setup_arr', $party_setup_arr);

        $this->form_validation->set_rules('party_name', 'Party Name', 'trim|required|strip_tags|alpha_numeric');
        $this->form_validation->set_rules('from_date', 'From Date', 'trim|required|strip_tags');
        $this->form_validation->set_rules('to_date', 'To Date', 'trim|required|strip_tags');
        //$this->form_validation->set_rules('to_date', 'Invalid To Date', 'callback_check_date');
//        $this->form_validation->set_rules('timepicker1', 'Start Time', 'required');
//        $this->form_validation->set_rules('timepicker2', 'End Time', 'required');
        if ($party_setup_arr['host'] == "old") {
            $this->form_validation->set_rules('host_id', 'Host Name', 'trim|required');
        }
        if ($party_setup_arr['host'] == "new") {
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('host_address', 'Host Address', 'trim|required|callback_alpha_city_address');
            $this->form_validation->set_rules('host_phone', 'Host Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('host_city', 'Host City', 'trim|required');
            $this->form_validation->set_rules('host_zip', 'Host Zip', 'trim|required|numeric');
            $this->form_validation->set_rules('host_email', 'Host Email', 'trim|required||valid_email');
        }
        if ($party_setup_arr['address'] == "new_address") {
            $this->form_validation->set_rules('address_new', 'Address New', 'trim|required|callback_alpha_city_address');
            $this->form_validation->set_rules('city', 'City', 'trim|required|alpha_numeric');
            $this->form_validation->set_rules('zip', 'Zip', 'trim|required|numeric');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|required||valid_email');
        }
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
    
    
    public function check_date() {
        $flag = TRUE;
        $party_setup_arr = $this->input->post();
        if ($party_setup_arr['from_date'] < $party_setup_arr['to_date']) {
            $flag = FALSE;
        }

        return $flag;
    }

    public function get_states($country_code) {
        $tran_state = "state";
        $state_select = "";
        $state_select .= '<select name="state" id="state" tabindex="15" ';
        $option = "select state";
        $state_select .= '</select>';

        echo $state_select;
    }

    function promote_party($party_id) {
        /////////////to promote a party by sharing party url at social media site//////////////
        $title = lang('promote_your_party');
        $this->set("title", $this->COMPANY_NAME . " | $title");

        $this->HEADER_LANG['page_top_header'] = lang('promote_your_party');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('promote_your_party');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $help_link = "promote_your_party";
        $this->set("help_link", $help_link);

        $party_url = "http://party_url/party_details.php?pid=$party_id"; ///this is an example..give your exact party site url
        $details = $this->party_setup_model->getPartyDetails($party_id);

        $this->set("party_id", $party_id);
        $this->set("party_url", $party_url);
        $this->set("details", $details);

        $this->setView();
    }

}
