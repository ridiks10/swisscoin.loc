<?php

require_once 'Inf_Controller.php';

/**
 * @property-read ewallet_model $ewallet_model 
 */
class Ewallet extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function fund_transfer() {

        $this->set('action_page', $this->CURRENT_URL);
        $title = lang('fund_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'fund-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $userid = $this->LOG_USER_ID;
        $balamount = $this->ewallet_model->getBalanceAmount($userid);
        $trans_fee = $this->ewallet_model->getTransactionFee();

        $this->set('trans_fee', $trans_fee);
        $pass = $this->ewallet_model->getUserPassword($userid);

        $msg = '';
        $this->set("step1", '');
        $this->set("step2", ' none');
        if ($this->input->post('fund_trans') && $this->validate_fund_transfer()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            if (array_key_exists('to_user_name', $post_arr)) {
                $touser = $post_arr['to_user_name'];
            }
            if (array_key_exists('amount', $post_arr)) {
                $trans_amt = round(($post_arr['amount'] / $this->DEFAULT_CURRENCY_VALUE), 2);
                $total_req_amount = $trans_amt + $trans_fee;
            }
            $to_userid = $this->ewallet_model->userNameToID($touser);
            $user_exists = $this->ewallet_model->isUserNameAvailable($touser);


            $this->set('bal_amount', $balamount);
            $this->set('to_user', $touser);
            $this->set('amount', $trans_amt);
            $this->set('total_req_amount', $total_req_amount);

            if ($user_exists && $userid != $to_userid) {

                if (is_numeric($trans_amt) && ($trans_amt > 0)) {
                    if ($total_req_amount <= $balamount) {

                        $this->set("step1", ' none');
                        $this->set("step2", '');
                    } else {
                        $msg = lang('you_dont_have_enough_balance');
                        $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
                    }
                } else {
                    $msg = lang('invalid_amount_please_try_again');
                    $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
                }
            } else {
                $msg = lang('invalid_user_selection');
                $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
            }
        }

        if ($this->input->post('transfer') && $this->validate_transfer()) {
            $transfer_post_array = $this->input->post();
            $transfer_post_array = $this->validation_model->stripTagsPostArray($transfer_post_array);
            $transfer_post_array = $this->validation_model->escapeStringPostArray($transfer_post_array);
            $tran_pass = $transfer_post_array['pswd'];
            $to_user_name = $transfer_post_array['to_username'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user_name);
            $trans_amt = $transfer_post_array['amount'];
            $total_req_amount = $transfer_post_array['tot_req_amount'];
            if ($total_req_amount < $trans_amt || $trans_amt + $trans_fee != $total_req_amount) {
                $msg = lang('invalid_amount_please_try_again');
                $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
            }
            if ($total_req_amount > $balamount) {
                $msg = lang('you_dont_have_enough_balance');
                $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
            }
            if ($pass == $tran_pass) {

                $this->ewallet_model->begin();
                $this->ewallet_model->insertBalAmountDetails($userid, $to_user_id, round($trans_amt, 2), $amount_type = '', $transaction_concept = '', $trans_fee);
                $up_date1 = $this->ewallet_model->updateBalanceAmountDetailsFrom($userid, round($total_req_amount, 2));
                $up_date2 = $this->ewallet_model->updateBalanceAmountDetailsTo($to_user_id, round($trans_amt, 2));
                if ($up_date1 && $up_date2) {
                    $this->ewallet_model->commit();
                    $login_id = $this->LOG_USER_ID;
                    $data_array = array();
                    $data_array['transfer_post_array'] = $transfer_post_array;
                    $data = serialize($data_array);
                    $this->validation_model->insertUserActivity($login_id, 'fund transferred', $to_user_id , $data);
                    $msg = lang('fund_transfered_successfully');
                    $this->redirect($msg, 'ewallet/fund_transfer', TRUE);
                } else {
                    $this->ewallet_model->rollback();
                    $msg = lang('error_on_fund_transfer');
                    $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
                }
            } else {
                $msg = lang('invalid_transaction_password');
                $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
            }
        }

        $this->set('balamount', round($balamount, 2));
        $this->set('pass', $pass);
        $this->setView();
    }

    public function validate_fund_transfer() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
        if (!$post_arr['to_user_name']) {
            $this->redirect("Enter to user user", 'ewallet/fund_transfer', FALSE);
        }
        if (!$post_arr['amount']) {
            $this->redirect("Enter amount ", 'ewallet/fund_transfer', FALSE);
        }

        return true;
    }

    public function validate_transfer() {
        if (!$this->input->post('pswd')) {
            $msg = lang('Please_type_transaction_password');
            $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
        }
        return TRUE;
    }

    function getLegAmount($user_name) {
        $this->AJAX_STATUS = true;
        $user = $this->ewallet_model->userNameToID($user_name);
        $bal_amount = $this->ewallet_model->getBalanceAmount($user);
        echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Balance Amount:</b></td><td><input type="text" name="bal"  id="bal" readonly="true" value=' . $bal_amount . ' ></td>';
    }

    function getBalance_EPin() {
        $this->AJAX_STATUS = true;
        $user = $this->URL['user'];
        $bal_epin = $this->Ewallet->getBalancePin($user);
        $pwd1 = $this->Ewallet->getUserPassword($user);
        echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Balance E-pin Count</b></td><td><input type='text' name='balance'  readonly='true' id='balance' value=" . $bal_epin . " ></td><input type='hidden' id='u_pwd' name='u_pwd' value=" . $pwd1 . "  /></td>";
    }

    function getPassWordInmd($pswdm) {
        $this->AJAX_STATUS = true;
        $mdpsw = md5($pswdm);
        echo'<td><input type="hidden" id="md_psd" name="md_psd" value=' . $mdpsw . '  /></td>';
    }

    function ewallet_pin_purchase() {

        $title = lang('e_pin_purchase');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'pin-purchase';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('e_pin_purchase');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('e_pin_purchase');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_id = $this->LOG_USER_ID;
        $balamount = $this->ewallet_model->getBalanceAmount($user_id);
        $amount_details = $this->ewallet_model->getAllEwalletAmounts();
        $msg = '';
        if ($this->input->post('transfer') && $this->validate_ewallet_pin_purchase()) {

            $pin_post_array = $this->input->post();
            $pin_post_array = $this->validation_model->stripTagsPostArray($pin_post_array);
            $pin_post_array = $this->validation_model->escapeStringPostArray($pin_post_array);

            $pin_count = $pin_post_array['pin_count'];
            $amount_id = $pin_post_array['amount'];

            if ($pin_count > 0 && $amount_id != '' && is_numeric($pin_count)) {
                $tran_pass = $pin_post_array['passcode'];
                $dbpass = $this->ewallet_model->getTransactionPasscode($user_id);
                if ($tran_pass == $dbpass) {
                    $amount = $this->ewallet_model->getEpinAmount($amount_id);
                    $tot_avb_amt = $amount * $pin_count;
                    if ($tot_avb_amt <= $balamount) {
                        $uploded_date = date('Y-m-d H:i:s');
                        $expiry_date = date('Y-m-d', strtotime('+6 months', strtotime($uploded_date)));
                        $purchase_status = 'yes';
                        $status = 'yes';
                        $this->ewallet_model->begin();

                        $max_pincount = $this->ewallet_model->getMaxPinCount();
                        $rec = $this->ewallet_model->getAllActivePinspage($purchase_status);
                        if ($rec < $max_pincount) {
                            $errorcount = $max_pincount - $rec;
                            if ($pin_count <= $errorcount) {

                                $res = $this->ewallet_model->generatePasscode($pin_count, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id, $user_id);
                            }
                        } else {
                            $msg1 = lang('already');
                            $msg2 = lang('epin_present');
                            $this->redirect($msg1 . $rec . $msg2, 'epin/generate_epin', FALSE);
                        }

                        if ($res) {

                            $bal = round($balamount - $tot_avb_amt, 2);
                            $update = $this->ewallet_model->updateBalanceAmount($user_id, $bal);
                            if ($res && $update) {
                                $this->ewallet_model->commit();
                                $loggin_id = $this->LOG_USER_ID;
                                $data_array = array();
                                $data_array['pin_post_array'] = $pin_post_array;
                                $data = serialize($data_array);
                                $this->validation_model->insertUserActivity($loggin_id, 'epin purchased', $loggin_id, $data);

                                $msg = lang('epin_purchased_successfully');
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', TRUE);
                            } else {
                                $this->ewallet_model->rollback();
                                $msg = lang('error_on_epin_purchase');
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                            }
                        } else {
                            $this->ewallet_model->rollback();
                            $mail = $this->ewallet_model->getAdminEmailId();
                            $mailBodyDetails = '<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
							</head>
							<body >
							<table id="Table_01" width="600"   border="0" cellpadding="0" cellspacing="0">
							<tr><td><br />Dear Admin,<br /></td></tr>
							<tr><td>There is no active E-pin for the product in your company. Please generate new E-pin.</td></tr>
							<tr><td>Thanks,<br />World Class Reward</td></tr> 
							</table>
							</body></html>';
                            $res = $this->validation_model->sendEmail($mailBodyDetails, $user_id, '');
                            $msg = lang('no_epin_found_please_contact_administrator');
                            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                        }
                    } else {
                        $msg = lang('no_sufficient_balance_amount');
                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                    }
                } else {
                    $msg = lang('invalid_transaction_password');
                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', false);
                }
            } else {
                $msg = lang('error_on_purchasing_epin_please_try_again');
                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
            }
        }

        $this->set('balamount', $balamount);
        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    public function validate_ewallet_pin_purchase() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['amount']) {
            $msg = lang('Please_type_Amount');
            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        }
        if (!$post_arr['pin_count']) {
            $msg = lang('You_must_enter_pin_count');
            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        }
        if (!$post_arr['passcode']) {
            $msg = lang('Please_type_transaction_password');

            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        }
        return true;
    }

    function my_transfer_details() {

        $title = $this->lang->line('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);

        $help_link = 'my-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $weekdate = strip_tags($this->input->post('weekdate'));
        $daily = strip_tags($this->input->post('daily'));
        $this->set('weekdate', $weekdate);
        $this->set('daily', $daily);

        if ($this->input->post('weekdate') && $this->validate_my_transfer_details_weekdate()) {

            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->ewallet_model->userNameToID($user_name);

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $from_date = $post_arr['week_date1'];
            $to_date = $post_arr['week_date2'];

            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date);
            $this->set('details', $details);
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
        }
        if ($this->input->post('daily') && $this->validate_my_transfer_details_daily()) {
            $user_name = $this->LOG_USER_NAME;
            $user_id = $this->ewallet_model->userNameToID($user_name);

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $from_date = $post_arr['week_date3']. ' 00:00:00';
            $to_date = $post_arr['week_date3']. ' 23:59:59';
            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date);
            $this->set('details', $details);
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
        }
        $this->setView();
    }

    public function validate_my_transfer_details_weekdate() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['week_date1']) {
            $msg = lang('please_select_from_date');
            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        }
        if (!$post_arr['week_date2']) {
            $msg = lang('please_select_to_date');
            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        }
        return TRUE;
    }

    public function validate_my_transfer_details_daily() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['week_date3']) {
            $msg = lang('please_select_date');
            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        }

        return TRUE;
    }

    function my_ewallet() {

		$this->load->library( 'inf_pagination' );
		$pagination           = [ ];
		$pagination['limit']  = inf_pagination::PER_PAGE;
		$pagination['offset'] = 0;
		if ( $this->uri->segment( 4 ) && is_numeric( $this->uri->segment( 4 ) ) ) {
			$pagination['offset'] = intval( $this->uri->segment( 4 ) - 1 ) * inf_pagination::PER_PAGE;
		}
        $input = $this->input;
        $title = $this->lang->line('ewallet_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);
        $this->HEADER_LANG['page_top_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_small_header'] = '';
        $this->load_langauge_scripts();

		$details   = [ ];
		$user_id   = $this->LOG_USER_ID;
		$user_name = $this->LOG_USER_NAME;
		if($input->server('REQUEST_METHOD') == 'POST'){
            $from_date = $input->post('week_date1');
            $to_date = $input->post('week_date2');
        }else{
            $from_date = Date('Y-m-d', strtotime($this->ewallet_model->getJoiningDate($user_id)));
            $to_date = Date('Y-m-d');
        }

		$details_data    = $this->ewallet_model->getCommission2( $user_id, $from_date, $to_date, $pagination, true );
		$ewallet_details = $this->ewallet_model->getCommissionDetails2( $user_id, $from_date, $to_date, $pagination, $details_data['initial_balance'] );

        $this->set('details_count', $details_data['total_amount']);
        $this->set('details', $ewallet_details);
        $this->set('offset', ++$pagination['offset'] );
        $this->set('user_name', $user_name);
        $this->set('total', $details_data['total_amount'] );
		$links = $this->inf_pagination->create_links( [
			'base_url'   => base_url() . "user/ewallet/my_ewallet/",
			'total_rows' => $details_data['num_rows']
		] );
		$this->set('links', $links );
        $this->setView();
    }

    public function user_availability() {
        if ($this->ewallet_model->checkUser(strip_tags($this->input->post('user_name')))) {
            echo "yes";
            exit();
        } else {
            echo "no";
            exit();
        }
    }

}
