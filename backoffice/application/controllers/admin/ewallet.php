<?php

require_once 'Inf_Controller.php';

class Ewallet extends Inf_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('profile_model');
    }

    function fund_transfer() {

        $title = lang('fund_transfer');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $this->set('action_page', $this->CURRENT_URL);

        $help_link = 'fund-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('fund_transfer');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_name_arr = $this->ewallet_model->getUserName_details();
        $this->set('user_name_arr', $user_name_arr);
        $msg = '';
        $this->set("step1", '');
        $this->set("step2", ' none');
        $trans_fee = $this->ewallet_model->getTransactionFee();
        $this->set('trans_fee', $trans_fee);

        if ($this->input->post('fund_trans') && $this->validate_fund_transfer()) {

            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $from_user = $post_arr['user_name'];
            $from_user_id = $this->ewallet_model->userNameToID($from_user);
            $bal_amount = $this->ewallet_model->getBalanceAmount($from_user_id) * $this->DEFAULT_CURRENCY_VALUE;

            $to_user = $post_arr['to_user_name'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user);
            $trans_amount = $post_arr['amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);

            $total_req_amount = $trans_amount + $trans_fee;
            $user_exists = $this->ewallet_model->isUserNameAvailable($to_user);

            $this->set('bal_amount', $bal_amount);
            $this->set('to_user', $to_user);
            $this->set('amount', $trans_amount);
            $this->set('from_user', $from_user);
            $this->set('total_req_amount', $total_req_amount);

            $bal_amount = $this->ewallet_model->getBalanceAmount($from_user_id);

            if ($user_exists && strcmp($from_user, $to_user) != 0) {

                if (is_numeric($trans_amount) && ($trans_amount > 0)) {
                    if ($bal_amount >= $total_req_amount) {
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
            $tran_pswd = $transfer_post_array['pswd'];
            $from_user = $transfer_post_array['from_user'];
            $from_user_id = $this->ewallet_model->userNameToID($from_user);
            $to_user_name = $transfer_post_array['to_username'];
            $to_user_id = $this->ewallet_model->userNameToID($to_user_name);
            $trans_amount = $transfer_post_array['amount'];
            $trans_amount = $trans_amount * (1 / $this->DEFAULT_CURRENCY_VALUE);
            $total_req_amount = $trans_amount + $trans_fee;
            $pass = $this->ewallet_model->getUserPassword($from_user_id);
            if ($pass == $tran_pswd) {
                $this->ewallet_model->begin();
                $this->ewallet_model->insertBalAmountDetails($from_user_id, $to_user_id, round($trans_amount, 2), $amount_type = '', $transaction_concept = '', $trans_fee);
                $up_date1 = $this->ewallet_model->updateBalanceAmountDetailsFrom($from_user_id, round($total_req_amount, 2));
                $up_date2 = $this->ewallet_model->updateBalanceAmountDetailsTo($to_user_id, round($trans_amount, 2));
                if ($up_date1 && $up_date2) {
                    $this->ewallet_model->commit();
                    $login_user_type = $this->LOG_USER_TYPE;
                    $data = serialize($transfer_post_array);
                    $this->validation_model->insertUserActivity($from_user_id, 'fund transferred', $to_user_id, $data);
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

        $this->setView();
    }

    public function validate_fund_transfer() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['user_name']) {
            $msg = lang('you_must_select_user');
            $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
        }
        if (!$post_arr['to_user_name']) {
            $msg = lang('Please_type_To_User_name');
            $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
        }
        if (!$post_arr['amount']) {
            $msg = lang('Please_type_Amount');
            $this->redirect($msg, 'ewallet/fund_transfer', FALSE);
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

    function getLegAmount($user_name = '') {
        $text = '';
        if ($user_name != '' && strcmp($user_name, "/") > 0) {
            $user = $this->ewallet_model->userNameToID($user_name);
            if ($user) {
                $bal_amount = $this->ewallet_model->getBalanceAmount($user);
                $balance_amount = lang('balance_amount');
                $text = '<label class="col-sm-2 control-label" for="blnc">' .
                        $balance_amount .
                        '</label>
                <div class="col-sm-6">
                    '.$this->DEFAULT_SYMBOL_LEFT.'<input type="text" id="blnc" name="blnc" value=' . number_format($bal_amount * $this->DEFAULT_CURRENCY_VALUE, 2) . ' readonly /> '.$this->DEFAULT_SYMBOL_RIGHT.'                           
                </div>';
            }
        }
        echo $text;
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

        $amount_details = $this->ewallet_model->getAllEwalletAmounts();
        $msg = '';
        if ($this->input->post('transfer') && $this->validate_ewallet_pin_purchase()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $user_name = $post_arr['user_name'];
            $pin_count = $post_arr['pin_count'];
            $amount_id = $post_arr['amount'];
            $user_id = $this->validation_model->userNameToId($user_name);

            if ($user_id != $this->ADMIN_USER_ID) {
                $balamount = $this->ewallet_model->getBalanceAmount($user_id);

                if ($pin_count > 0 && $amount_id != '' && is_numeric($pin_count)) {

                    $amount = $this->ewallet_model->getEpinAmount($amount_id);
                    $tot_avb_amt = $amount * $pin_count;

                    if ($tot_avb_amt <= $balamount) {

                        $uploded_date = date('Y-m-d H:i:s');
                        $expiry_date = date('Y-m-d', strtotime('+6 months', strtotime($uploded_date)));
                        $purchase_status = 'yes';
                        $status = 'yes';
                        $res = false;

                        $max_active_pincount = $this->ewallet_model->getMaxPinCount();
                        $current_active_pin_count = $this->ewallet_model->getAllActivePinspage($purchase_status);
                        if ($current_active_pin_count < $max_active_pincount) {
                            $balance_count = $max_active_pincount - $current_active_pin_count;
                            if ($pin_count <= $balance_count) {

                                $this->ewallet_model->begin();

                                $res = $this->ewallet_model->generatePasscode($pin_count, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id, $this->ADMIN_USER_ID);

                                if ($res) {
                                    $bal = round($balamount - $tot_avb_amt, 2);
                                    $update = $this->ewallet_model->updateBalanceAmount($user_id, $bal);
                                    if ($update) {
                                        $this->ewallet_model->commit();
                                        $data = serialize($post_arr);
                                        $this->validation_model->insertUserActivity($this->LOG_USER_ID, 'epin purchased using ewallet', $user_id, $data);
                                        $msg = lang('epin_purchased_successfully');
                                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', TRUE);
                                    } else {
                                        $this->ewallet_model->rollback();
                                        $msg = lang('error_on_epin_purchase');
                                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                                    }
                                } else {
                                    $this->ewallet_model->rollback();
                                    $msg = lang('error_on_epin_purchase');
                                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                                }
                            } else {
                                $msg = sprintf(lang('only_few_epins_can_be_generated'), $balance_count);
                                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                            }
                        } else {
                            $msg1 = lang('already');
                            $msg2 = lang('epin_present');
                            $this->redirect($msg1 . $current_active_pin_count . $msg2, 'ewallet/ewallet_pin_purchase', FALSE);
                        }
                    } else {
                        $msg = lang('no_sufficient_balance_amount');
                        $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                    }
                } else {
                    $msg = lang('error_on_purchasing_epin_please_try_again');
                    $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
                }
            } else {
                
            }
        }

        $this->set('amount_details', $amount_details);
        $this->setView();
    }

    public function validate_ewallet_pin_purchase() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());

        if (!$post_arr['user_name']) {
            $msg = lang('You_must_enter_user_name');
            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        } else {
            $user_id = $this->validation_model->userNameToId($post_arr['user_name']);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
            } elseif ($user_id == $this->ADMIN_USER_ID) {
                $msg = lang('you_cant_use_admin_account');
                $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
            }
        }
        if (!$post_arr['amount']) {
            $msg = lang('Please_type_Amount');
            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        }
        if (!$post_arr['pin_count']) {
            $msg = lang('You_must_enter_pin_count');
            $this->redirect($msg, 'ewallet/ewallet_pin_purchase', FALSE);
        }

        return true;
    }

    function fund_management() {
        $this->set('action_page', $this->CURRENT_URL);
        $title = lang('ewallet_fund_management');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'add-deduct-fund';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('ewallet_fund_management');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_fund_management');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $user_name_arr = $this->ewallet_model->getUserName_details();
        $this->set('user_name_arr', $user_name_arr);
        $msg = '';
        if ($this->input->post('add_amount') && $this->validate_fund_management_add_amount()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);

            $userid = $this->LOG_USER_ID;
            $to_user = $post_arr['user_name'];
            $user_type = $this->LOG_USER_TYPE;
            $transaction_concept = $post_arr['tran_concept'];
            $user = $this->validation_model->userNameToID($to_user);
            $to_userid = $this->ewallet_model->userNameToID($to_user);
            $amount = $post_arr['amount'] * (1 / $this->DEFAULT_CURRENCY_VALUE);
            $user_exists = $this->ewallet_model->isUserNameAvailable($to_user);
            if ($user_exists) {
                if (is_numeric($amount) && $amount > 0) {
                    $this->ewallet_model->begin();
                    $this->ewallet_model->insertBalAmountDetails($userid, $to_userid, round($amount, 2), 'admin_credit', $transaction_concept);
                    $up_date = $this->ewallet_model->addUserBalanceAmount($to_userid, round($amount, 2));
                    if ($up_date) {
                        $this->ewallet_model->commit();
                        $data = serialize($post_arr);
                        $this->validation_model->insertUserActivity($userid, 'amount added to ewallet', $user, $data);
                        $msg = lang('fund_credited_successfully');
                        $this->redirect($msg, 'ewallet/fund_management', TRUE);
                    } else {
                        $this->ewallet_model->rollback();
                        $msg = lang('error_on_crediting_fund');
                        $this->redirect($msg, 'ewallet/fund_management', FALSE);
                    }
                } else {
                    $msg = lang('error_on_crediting_fund_please_check_the_amount');
                    $this->redirect($msg, 'ewallet/fund_management', FALSE);
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/fund_management', FALSE);
            }
        }
        if ($this->input->post('deduct_amount') && $this->validate_fund_management_deduct_amount()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $userid = $this->LOG_USER_ID;
            $to_user = $post_arr['user_name'];
            $user_type = $this->LOG_USER_TYPE;
            $transaction_concept = $post_arr['tran_concept'];
            $user = $this->validation_model->userNameToID($to_user);
            $to_userid = $this->ewallet_model->userNameToID($to_user);
            $amount = $post_arr['amount'];
            $user_exists = $this->ewallet_model->isUserNameAvailable($to_user);
            if ($user_exists) {
                $bal_amount = $this->ewallet_model->getBalanceAmount($to_userid);
                if (is_numeric($amount) && $amount > 0 && $bal_amount >= $amount) {
                    $this->ewallet_model->begin();
                    $this->ewallet_model->insertBalAmountDetails($userid, $to_userid, round($amount, 2), 'admin_debit', $transaction_concept);
                    $up_date = $this->ewallet_model->deductUserBalanceAmount($to_userid, round($amount, 2));
                    $user_level = $this->ewallet_model->getUserLevel($to_userid);
                    $this->ewallet_model->insertReleasedDetails($to_userid, $amount, $user_level);

                    if ($up_date) {
                        $this->ewallet_model->commit();
                        $data = serialize($post_arr);
                        $this->validation_model->insertUserActivity($userid, 'amount deducted from ewallet', $user, $data);
                        $msg = lang('fund_deducted_successfully');
                        $this->redirect($msg, 'ewallet/fund_management', TRUE);
                    } else {
                        $this->ewallet_model->rollback();
                        $msg = lang('error_on_deducting_fund');
                        $this->redirect($msg, 'ewallet/fund_management', FALSE);
                    }
                } else {
                    $msg = lang('error_on_deducting_fund_please_check_the_amount');
                    $this->redirect($msg, 'ewallet/fund_management', FALSE);
                }
            } else {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/fund_management', FALSE);
            }
        }
        $this->setView();
    }

    public function validate_fund_management_add_amount() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
        if (!$post_arr['user_name']) {
            $msg = lang('you_must_select_user');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        if (!$post_arr['amount']) {
            $msg = lang('Please_type_Amount');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        if (!$post_arr['tran_concept']) {
            $msg = lang('Please_type_transaction_password');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        return true;
    }

    public function validate_fund_management_deduct_amount() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
        if (!$post_arr['user_name']) {
            $msg = lang('you_must_select_user');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        if (!$post_arr['amount']) {
            $msg = lang('Please_type_Amount');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        if (!$post_arr['tran_concept']) {
            $msg = lang('Please_type_transaction_password');
            $this->redirect($msg, 'ewallet/fund_management', FALSE);
        }
        return true;
    }

    function my_transfer_details() {
        $title = lang('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' | ' . $title);
        $help_link = 'my-transfer';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('transfer_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();

        $weekdate = $this->input->post('weekdate');
        $daily = $this->input->post('daily');
        $this->set('weekdate', $weekdate);
        $this->set('daily', $daily);
        if ($this->input->post('weekdate') && $this->validate_my_transfer_details_weekdate()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $user_name = $post_arr['user_name'];
            $user_id = $this->ewallet_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
            } else {
                $userid = $user_id;
            }
            $from_date = $post_arr['week_date1'] . ' 00:00:00';
            $to_date = $post_arr['week_date2'] . ' 23:59:59';
            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date);
            $this->set('details', $details);
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set('details_count', $details_count);
        }
        if ($this->input->post('daily') && $this->validate_my_transfer_details_daily()) {
            $post_arr = $this->input->post();
            $post_arr = $this->validation_model->stripTagsPostArray($post_arr);
            $post_arr = $this->validation_model->escapeStringPostArray($post_arr);
            $user_name = $post_arr['user_name1'];
            $user_id = $this->ewallet_model->userNameToID($user_name);
            if (!$user_id) {
                $msg = lang('invalid_user_name');
                $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
            } else {
                $userid = $user_id;
            }
            $from_date = $post_arr['week_date3'] . ' 00:00:00';
            $to_date = $post_arr['week_date3'] . ' 23:59:59';
            $details = $this->ewallet_model->getUserEwalletDetails($user_id, $from_date, $to_date);
            $this->set('details', $details);
            $this->set('user_name', $user_name);
            $details_count = count($details);
            $this->set(
                    'details_count', $details_count);
        }
        $this->setView();
    }

    public function validate_my_transfer_details_weekdate() {
        $post_arr = $this->validation_model->stripTagsPostArray($this->input->post());
        if (!$post_arr['user_name']) {
            $msg = lang('you_must_select_user');
            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        }
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
        if (!$post_arr['user_name1']) {
            $msg = lang('you_must_select_user');
            $this->redirect($msg, 'ewallet/my_transfer_details', FALSE);
        }
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

        $title = lang('transfer_details');
        $this->set('title', $this->COMPANY_NAME . ' |' . $title);
        $help_link = 'my-e-wallet';
        $this->set('help_link', $help_link);

        $this->HEADER_LANG['page_top_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_top_small_header'] = '';
        $this->HEADER_LANG['page_header'] = lang('ewallet_details');
        $this->HEADER_LANG['page_small_header'] = '';

        $this->load_langauge_scripts();
        $mlm_plan = $this->MLM_PLAN;
        $this->set('mlm_plan', $mlm_plan);
        $user_type = $this->LOG_USER_TYPE;
        if ($user_type == 'employee') {
            $employee_view_permission = 'no';
        } else {
            $employee_view_permission = 'yes';
        }
		if( $this->session->userdata('ewallet_account_chosen_uid') ) {
			$user_id   = intval( $this->session->userdata('ewallet_account_chosen_uid') );
			$user_name = $this->validation_model->IdToUserName( $user_id );
		} else {
			$user_id   = $this->LOG_USER_ID;
			$user_name = $this->LOG_USER_NAME;
		}
        $product_status = $this->MODULE_STATUS['product_status'];
        $msg = '';
        $is_valid_username = false;

        if ($this->input->post('user_name') && $this->validate_my_ewallet()) {
            $user_name = $this->input->post('user_name');
            $is_valid_username = $this->validation_model->isUserNameAvailable($user_name);
            if (!$is_valid_username) {
                $msg = lang('Username_not_Exists');
                $this->redirect($msg, "ewallet/my_ewallet", false);
            }
            $this->set('ewallet_view_permission', 'yes');
            $user_id = $this->validation_model->userNameToID($user_name);
			$this->session->set_userdata('ewallet_account_chosen_uid', $user_id );
        }
        $from_date = Date('Y-m-d', strtotime($this->ewallet_model->getJoiningDate($user_id)));
        $to_date = Date('Y-m-d');


        $details_data    = $this->ewallet_model->getCommission2( $user_id, $from_date, $to_date, $pagination, true );
        $ewallet_details = $this->ewallet_model->getCommissionDetails2( $user_id, $from_date, $to_date, $pagination, $details_data['initial_balance'] );
        
        $this->set('ewallet_view_permission', $employee_view_permission);
        $this->set('details_count', $details_data['total_amount']);
        $this->set('ewallet_details', $ewallet_details);
        $this->set('offset', ++$pagination['offset'] );
        $this->set('user_name', $user_name);
        $this->set('total', $details_data['total_amount'] );
        $links = $this->inf_pagination->create_links( [
            'base_url'   => base_url() . "admin/ewallet/my_ewallet/",
            'total_rows' => $details_data['num_rows']
        ] );
        $this->set('links', $links );
        $this->setView();
    }

    function validate_my_ewallet() {
        $this->form_validation->set_rules('user_name', 'User Name', 'trim|required|strip_tags');
        $validate_form = $this->form_validation->run();
        return $validate_form;
    }

}
