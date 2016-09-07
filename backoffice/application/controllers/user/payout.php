<?php

require_once 'Inf_Controller.php';

/**
 * @property-read payout_model $payout_model 
 */
class Payout extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function payout_release_request() {

        $title = lang('Request_Payout_Release');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'payout-release-request';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('Request_Payout_Release');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $minimum_payout_amount = $this->payout_model->getMinimumPayoutAmount();
        $maximum_payout_amount = $this->payout_model->getMaximumPayoutAmount();

        $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
        $req_amount = $this->payout_model->getRequestPendingAmount($user_id);
        $result_amount = $this->payout_model->getResultAmount( $balance_amount, $req_amount );
        $total_amount = $this->payout_model->getReleasedPayoutTotal($user_id);
        $this->load->model('profile_model');
        $KYC_status = true;//$this->profile_model->getKYCStatus($user_id) == 'approved';

        if ($this->input->post('payout_request_submit') && $this->validate_transation_password()) {
            if($KYC_status) {
                $transation_password = $this->input->post('transation_password');
                $password_flag = $this->payout_model->checkTransactionPassword($user_id, $transation_password);
                if ($password_flag) {
                    $payout_amount = round($this->input->post('payout_amount') / $this->DEFAULT_CURRENCY_VALUE, 2);
                    $request_date = date('Y-m-d H:i:s');
                    $balance_amount = $this->payout_model->getUserBalanceAmount($user_id);
                    if ($result_amount >= $payout_amount && $payout_amount >= $minimum_payout_amount && $payout_amount <= $maximum_payout_amount) {
                        $res = $this->payout_model->insertPayoutReleaseRequest($user_id, $payout_amount, $request_date, 'pending');
                        if ($res) {
                            $this->payout_model->updateUserBalanceAmount($user_id, $payout_amount);
                            $data_array = array();
                            $data_array['tran_pass'] = $transation_password;
                            $data_array['req_amount'] = $req_amount;
                            $data_array['balance_amount'] = $balance_amount;
                            $data = serialize($data_array);
                            $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'payout request sent ', $this->LOG_USER_ID, $data);
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
                    $msg = $this->lang->line('invalid_transaction_password');
                    $this->redirect($msg, 'payout/payout_release_request', FALSE);
                }
            }else{
                $msg = lang('invalid_transaction_password');
                $this->redirect($msg, 'payout/payout_release_request', FALSE);
            }
        }

        $this->set('minimum_payout_amount', $minimum_payout_amount);
        $this->set('balance_amount', $balance_amount);
        $this->set('req_amount', $req_amount);
		$this->set('result_amount', $result_amount );
        $this->set('total_amount', $total_amount);
        $this->set('KYC_status', $KYC_status);

        $this->setView();
    }

    function validate_transation_password() {
        $this->form_validation->set_rules('payout_amount', 'payout amount ', 'trim|required|numeric|greater_than[25]');
        $this->form_validation->set_rules('transation_password', 'Transaction Password', 'required|strip_tags');
        $this->form_validation->set_message('required', '%s is Required');
        $this->form_validation->set_error_delimiters("<div style='color:rgba(249, 6, 6, 1)'>", '</div>');
        $res_val = $this->form_validation->run();
        return $res_val;
    }

    function my_income() {

        $title = $this->lang->line('income');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'income-statement';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('income');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('income');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_name = $this->LOG_USER_NAME;
        $this->set('user_name', $user_name);
        $binary = $this->payout_model->getIncome($user_name);
        $this->set('binary', $binary);

        $this->setView();
    }

    function weekly_payout($page = '', $limit = '') {

        $title = $this->lang->line('weekly_payout');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $user_name = $this->validation_model->IdToUserName($user_id);

        $this->set('user_name', $user_name);
        $weekdate = $this->session->userdata('inf_weekdate');
        $this->set('weekdate', $weekdate);

        $from1 = $this->session->userdata('inf_from1');
        $this->set('from1', $from1);
        $to1 = $this->session->userdata('inf_to1');
        $this->set('to1', $to1);

        $length = '';
        $weekly_payout = array();
        $form_submit = FALSE;
        $session = FALSE;

        if ($this->session->userdata('inf_weekdate')) {
            $session = TRUE;
        }
        if ($this->input->post('weekdate')) {

            $form_submit = TRUE;
            $this->session->set_userdata('inf_weekdate', strip_tags($this->input->post('weekdate')));
            $from_date = strip_tags($this->input->post('week_date1')) . ' 00:00:00';
            $to_date = strip_tags($this->input->post('week_date2')) . ' 23:59:59';

            /// Pagination BEGINS
            if (!($limit)) {
                $limit = 25;
            } // Default results per-page.
            if (!($page)) {
                $page = 0;
            }

            $weekly_payout = $this->payout_model->payoutWeeklyTotal($limit, $page, $from_date, $to_date, $this->LOG_USER_ID);

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

}

?>
