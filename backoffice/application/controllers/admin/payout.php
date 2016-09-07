<?php

require_once 'Inf_Controller.php';

/**
 * @property-read payout_model $payout_model 
 */
class Payout extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile_model');
        $this->load->model('mail_model');
        $this->load->model('validation_model');
    }

    function payout_release($action = '', $del_id = '', $user_id = '') {

        $title = $this->lang->line('payout_release');
        $this->set("title", $this->COMPANY_NAME . " | " . $title);

        $help_link = 'release-payout';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('payout_release');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('payout_release');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        if ($action == 'delete') {
            $res = $this->payout_model->deletePayoutRequest($del_id, $user_id);
            if ($res) {
                $msg = lang('Payout_Request_Deleted_Successfully');
                $this->redirect($msg, 'payout/payout_release', TRUE);
            } else {
                $msg = lang('Error_on_deleting_Payout_Request');
                $this->redirect($msg, 'payout/payout_release', FALSE);
            }
        }

        $payout_release_type = $this->MODULE_STATUS['payout_release_status'];
        $payout_amount = 0;
        $payout_details = $this->payout_model->getPayoutDetails($payout_release_type);
        $min_max_payout_amount = $this->payout_model->getMinimumMaximunPayoutAmount();

        if ($this->input->post('release_payout')) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $count = $post_arr['table_rows'];
            $result = false;
            for ($i = 0; $i < $count; $i++) {
                if (array_key_exists('release' . $i, $post_arr)) {
                    $request_id = $post_arr['request_id' . $i];
                    $user_id = $post_arr['user_id' . $i];
                    $user_name = $this->validation_model->IdToUserName($user_id);
                    $payout_release_amount = round((floatval(str_replace(',', '',$post_arr['payout' . $i])) / $this->DEFAULT_CURRENCY_VALUE), 2);
                    if ($payout_release_amount > $min_max_payout_amount['max_payout'] || $payout_release_amount < $min_max_payout_amount['min_payout']) {

                        $msg = lang('You_cant_release_this_amount_for') . ' ' . $user_name;
                        $this->redirect($msg, 'payout/payout_release', FALSE);
                    }

                    if ($payout_release_type != "ewallet_request") {
                        $user_id = $request_id;
                        $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
                        if ($payout_release_amount > $balance_amount) {
                            $msg = lang('Payout_Release_Failed');
                            $msg1 = lang('Low_balance');
                            $this->redirect($msg . " \n" . $msg1, 'payout/payout_release', FALSE);
                        } else {
                            $res = $this->payout_model->updateUserBalanceAmount($user_id, $payout_release_amount);
                        }
                    } else {
                        $payout_release_amount = $this->payout_model->getPayoutRequestAmount($request_id, $user_id);
                    }
                    $result = $this->payout_model->updatePayoutReleaseRequest($request_id, $user_id, $payout_release_amount, $payout_release_type);
                    $type = 'payout_release';
                    $check_status = $this->mail_model->checkMailStatus($type);
                    if ($check_status == 'yes') {
                        $send_details = array();
                        $email = $this->validation_model->getUserEmailId($user_id);
                        $send_details['full_name'] = $this->validation_model->getUserFullName($user_id);
                        $send_details['email'] = $email;
                        $send_details['first_name'] = $this->validation_model->getUserData($user_id, "user_detail_name");
                        $send_details['last_name'] = $this->validation_model->getUserData($user_id, "user_detail_second_name");
                        $this->mail_model->sendAllEmails($type, $send_details);
                    }
                }
            }

            if ($result) {
                $login_id = $this->LOG_USER_ID;
                $this->validation_model->insertUserActivity($user_id, 'release payout', $login_id);
                $msg = lang('Payout_Released_Successfully');
                $this->redirect($msg, 'payout/payout_release', TRUE);
            } else {
                $msg = lang('Payout_Release_Failed');
                $this->redirect($msg, 'payout/payout_release', FALSE);
            }
			exit();
        }

        $count_details = count($payout_details);
        $this->set('payout_details', $payout_details);
        $this->set('payout_amount', $payout_amount);
        $this->set('count', $count_details);

        $this->setView();
    }

    function my_income() {

        $title = lang('incentive');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'income-statement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('released_income');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('released_income');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $week_date = FALSE;
        $binary = array();
        $user_name = '';
        $mlm_plan = $this->MLM_PLAN;
        $is_valid_username = false;
        if ($this->input->post('user_name') && $this->validate_my_income()) {
            $week_date = TRUE;
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if ($is_valid_username) {
                $binary = $this->payout_model->getIncome($user_name);
            } else {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, 'payout/my_income', false);
            }
        }

        $this->set('user_name', $user_name);
        $this->set('mlm_plan', $mlm_plan);
        $this->set('is_valid_username', $is_valid_username);
        $this->set('binary', $binary);
        $this->set('week_date', $week_date);

        $this->setView();
    }

    function validate_my_income() {

        if (!$this->input->post('user_name')) {
            $msg = lang('you_must_enter_user_name');
            $this->redirect($msg, 'payout/my_income', false);
        } else {
            $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
            $validate_form = $this->form_validation->run();
            return $validate_form;
        }
    }

    function payout_release_request() {

        $title = lang('Request_Payout_Release');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);

        $help_link = 'payout-release-request';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $minimum_payout_amount = $this->payout_model->getMinimumPayoutAmount();
        $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
        $req_amount = $this->payout_model->getRequestPendingAmount($user_id);
        $total_amount = $this->payout_model->getReleasedPayoutTotal($user_id);

        if ($this->input->post('payout_request_submit') && $this->validate_transation_password()) {
            $submit_post_array = $this->input->post();
            $submit_post_array = $this->validation_model->stripTagsPostArray($submit_post_array);
            $submit_post_array = $this->validation_model->escapeStringPostArray($submit_post_array);
            $transation_password = $submit_post_array['transation_password'];
            $password_flag = $this->payout_model->checkTransactionPassword($user_id, $transation_password);
            if ($password_flag) {
                $payout_amount = round($submit_post_array['payout_amount'] * $this->DEFAULT_CURRENCY_VALUE, 2);
                $request_date = date('Y-m-d H:i:s');
                $minimum_payout_amount = $this->payout_model->getMinimumPayoutAmount();
                $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
                if ($balance_amount >= $payout_amount && $payout_amount >= $minimum_payout_amount) {
                    $res = $this->payout_model->insertPayoutReleaseRequest($user_id, $payout_amount, $request_date, 'pending');
                    if ($res) {
                        $this->payout_model->updateUserBalanceAmount($user_id, $payout_amount);
                        $this->payout_model->sendMailToAdmin($user_id);
                        $this->redirect('Payout Request Sent Successfully.', 'payout/payout_release_request', TRUE);
                    } else {
                        $this->redirect('Payout Request Sending Failed.', 'payout/payout_release_request', FALSE);
                    }
                } else {
                    $msg = $this->lang->line('You_cant_request_this_amount');
                    $this->redirect($msg, 'payout/payout_release_request', FALSE);
                }
            } else {
                $msg = $this->lang->line('You_cant_request_this_amount');
                $this->redirect($msg, 'payout/payout_release_request', FALSE);
            }
        }

        $this->set('minimum_payout_amount', $minimum_payout_amount);
        $this->set('balance_amount', $balance_amount);
        $this->set('req_amount', $req_amount);
        $this->set('total_amount', $total_amount);

        $this->setView();
    }

    function validate_transation_password() {
        $this->form_validation->set_rules('payout_amount', 'payout amount ', 'trim|required|numeric');
        $this->form_validation->set_rules('transation_password', 'Transaction Password', 'required');
        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function monthly_income() {

        $title = 'Monthly revenue details';
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'release-payout';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = 'Monthly revenue details';
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = 'Monthly revenue details';
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $this->set('status', 0);

        if ($this->input->post('submit')) {
            $date = strip_tags($this->input->post('date'));
            $monthly_income_details = $this->payout_model->getMonthlyDetails($date);
            $monthly_commission_details = $this->payout_model->getMonthlyCommisionDetails($date);
            $percentage = round($monthly_income_details / $monthly_commission_details['total'], 2) * 100;

            $this->set('status', 1);
            $this->set('monthly_income_details', $monthly_income_details);
            $this->set('monthly_commission_details', $monthly_commission_details);
            $this->set('percentage', $percentage);
            $this->set('date', date('F Y', strtotime($date)));
        }

        $this->setView();
    }

    function weekly_payout($page = '', $limit = '') {

        $title = $this->lang->line('weekly_payout');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->HEADER_LANG['page_top_header'] = lang('weekly_payout');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('weekly_payout');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $weekdate = $this->session->userdata('inf_weekdate');
        $this->set('weekdate', $weekdate);

        $from1 = $this->session->userdata('inf_from1');
        $this->set('from1', $from1);
        $to1 = $this->session->userdata('inf_to1');
        $this->set('to1', $to1);

        $weekly_payout = array();
        $form_submit = FALSE;
        $session = FALSE;
        if ($this->session->userdata('inf_weekdate')) {
            $session = TRUE;
        }
        if ($this->input->post('weekdate')) {

            $date_post_array = $this->input->post();
            $date_post_array = $this->validation_model->stripTagsPostArray($date_post_array);
            $date_post_array = $this->validation_model->escapeStringPostArray($date_post_array);

            $form_submit = TRUE;
            $this->session->set_userdata('inf_weekdate', $date_post_array['weekdate']);
            $from_date = $date_post_array['week_date1'] . ' 00:00:00';
            $to_date = $date_post_array['week_date2'] . ' 23:59:59';
            $this->session->set_userdata('inf_from', $from_date);
            $this->session->set_userdata('inf_to', $to_date);
            $this->session->set_userdata('inf_from1', $date_post_array['week_date1']);
            $this->session->set_userdata('inf_to1', $date_post_array['week_date2']);

            /// Pagination BEGINS
            if (!($limit)) {
                $limit = 25;
            } // Default results per-page.
            if (!($page)) {
                $page = 0;
            }

            if ($this->session->userdata('inf_weekdate')) {
                $session = TRUE;
                $from = $this->session->userdata('inf_from');
                $to = $this->session->userdata('inf_to');
                $weekly_payout = $this->payout_model->payoutWeeklyTotal($limit, $page, $from, $to);
            }
        }
        $this->set('weekly_payout', $weekly_payout);
        $length = count($weekly_payout);
        $this->set('length', $length);
        $this->set('total_leg_tot', '0');
        $this->set('total_amount_tot', '0');
        $this->set('tds_tot', '0');
        $this->set('service_charge_tot', '0');
        $this->set('amount_payable_tot', '0');
        $this->set('leg_amount_carry_tot', '0');
        $this->set('form_submit', $form_submit);
        $this->set('session', $session);

        $this->setView();
    }

    public function user_details($user_id = '') {

        $user_details = $this->payout_model->getUserDetails($user_id);

        $user_name = $this->lang->line('User_Name');
        $fullname = $this->lang->line('full_name');
        $email = $this->lang->line('email');
        $mobile_no = $this->lang->line('mobile_no');
        $address = $this->lang->line('address');
        $country = $this->lang->line('country');
        $pan_no = $this->lang->line('pan_no');
        $d_o_b = $this->lang->line('date_of_birth');
        $gender = $this->lang->line('gender');
        $pincode = $this->lang->line('pincode');
        $bank_account_number = $this->lang->line('bank_account_number');
        $bank_name = $this->lang->line('bank_name');
        $branch_name = $this->lang->line('branch_name');
        $user_detail = $this->lang->line('user_details');



        echo '<div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>
                                    <h4 class="modal-title">' . $user_detail . '</h4>
                                </div><table cellpadding="0" cellspacing="0" align="center" width="60%">
                                        <tr>
                                            <td>
                                                <b>Username</b> </td>  <td>:' . $user_details[0]['user_name'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Name</b> </td>  <td>:' . $user_details[0]['name'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>BOB</b> </td>  <td>:' . $user_details[0]['dob'] . '
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>
                                                <b>Gender</b> </td>  <td>:' . $user_details[0]['gender'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Address</b> </td>  <td>:' . $user_details[0]['address'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Zip code</b></td>  <td> :' . $user_details[0]['pin'] . '
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>
                                                <b>E-mail</b> </td>  <td>:' . $user_details[0]['email'] . '
                                            </td>
                                        </tr>
                                         <tr>
                                            <td>
                                                <b>Mobile</b> </td>  <td>:' . $user_details[0]['mobile'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Country</b> </td>  <td>:' . $user_details[0]['country'] . '
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td>
                                                <b>A/c Number</b> </td>  <td>:' . $user_details[0]['acc'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Bank</b> </td>  <td>:' . $user_details[0]['bank'] . '
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Branch</b> </td>  <td>:' . $user_details[0]['branch'] . '</td>
                                        </tr>
                                    </table>';
    }

}

?>
