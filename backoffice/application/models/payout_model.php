<?php

class payout_model extends inf_model {

    function __construct() {

        parent::__construct();

        $this->load->model('payout_class_model');
        $this->load->model('page_model');
        $this->load->model('validation_model');
        $this->load->model('register_model');
        $this->load->model('settings_model');
    }

    public function paging($page, $limit, $url) {
        $numrows = $this->payout_class_model->payoutWeeklyPage($this->session->userdata('inf_from'), $this->session->userdata('inf_to'));
        $page_arr['first'] = $this->page_model->paging($page, $limit, $numrows);
        $page_arr['page_footer'] = $this->page_model->paging($page, $limit, $url);
        return $page_arr;
    }

    /**
     * @todo Optimization requied
     * @since 1.21 remove fields for deleted DB columns
     */
    public function payoutWeeklyTotal($limit, $page, $from, $to, $user_id = '') {
        $row1 = array();
        if ($user_id == '') {
            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select('user_id');
            $this->db->from('leg_amount');
            $this->db->join('ft_individual AS ft', 'ft.id = leg_amount.user_id', 'INNER');
            $where = "date_of_submission BETWEEN {$this->db->escape($from)} AND {$this->db->escape($to)}";
            $this->db->where($where);
            $this->db->where('ft.active', 'yes');
            $this->db->group_by('user_id');
            $this->db->limit($limit, $page);

            $query = $this->db->get();
        } else {
            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select('user_id');
            $this->db->from('leg_amount');
            $this->db->join('ft_individual AS ft', 'ft.id = leg_amount.user_id', 'INNER');
            $where = "date_of_submission BETWEEN {$this->db->escape($from)} AND {$this->db->escape($to)}";
            $this->db->where('user_id', $user_id);
            $this->db->where($where);
            $this->db->where('ft.active', 'yes');
            $this->db->group_by('user_id');
            $this->db->limit($limit, $page);
            $query = $this->db->get();
        }
        $i = 0;
        $row1 = array();
        foreach ($query->result_array() as $row) {
            $row1[$i]['user_id'] = $row['user_id'];
            $row1[$i]['total_leg'] = 0;
            $row1[$i]['total_amount'] = round($row['total_amount'], 2);
            $row1[$i]['leg_amount_carry'] = 0;
            $row1[$i]['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
            $row1[$i]['full_name'] = $this->validation_model->getUserFullName($row['user_id']);
            $row1[$i]['amount_payable'] = round($row['amount_payable'], 2);
            $row1[$i]['tds'] = 0;
            $row1[$i]['service_charge'] = 0;
            $i++;
        }
        return $row1;
    }

    public function getIncome($username) {
        $income_arr = array();
        $user_id = $this->validation_model->userNameToID($username);
        $this->db->select('paid_user_id,paid_date,paid_type');
        $this->db->select_sum('paid_amount');
        $this->db->where('paid_date !=', '0000-00-00');
        $this->db->where('paid_user_id', $user_id);
        $this->db->group_by('paid_date');
        $this->db->from("amount_paid");
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $income_arr["detail$i"]["paid_date"] = $row['paid_date'];
            $income_arr["detail$i"]["paid_type"] = ucfirst($row['paid_type']);
            $income_arr["detail$i"]["paid_amount"] = $row['paid_amount'];
            $i++;
        }
        return $income_arr;
    }

    public function getAllBinaryPayoutDates($order = 'DESC') {

        $obj_arr = $this->settings_model->getSettings();

        if (strcmp($obj_arr['payout_release'], 'month') == 0) {
            $payout_releasedate = '365 day';
        } elseif (strcmp($obj_arr['payout_release'], 'week') == 0) {
            $payout_releasedate = '7 day';
        } else {
            $payout_releasedate = '1 day';
        }

        $current_date = date('Y-m-d H:i:s');
        $newdate = strtotime($payout_releasedate, strtotime($current_date));
        $newdate_1 = date('Y-m-j', $newdate);

        $this->db->distinct('release_date');
        $this->db->from('payout_release_date');
        $this->db->where('release_date <=', $newdate_1);
        $this->db->order_by('release_date', $order);
        $dat_arr = Array();
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {

            $timestamp = strtotime($row->release_date);
            $dat_arr[] = date('Y-m-d', $timestamp);
        }
        $dat_arr1 = array_unique($dat_arr);

        return $dat_arr1;
    }

    public function getBeforePayoutDate($date_sub) {
        if ($this->table_prefix == '') {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }

        $this->db->select('release_date');
        $this->db->where('release_date < ', $date_sub);
        $this->db->order_by('release_date', 'desc');
        $this->db->limit(1);
        $this->db->from('payout_release_date');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            return $row->release_date;
        }
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function updatePaidStatus($post) {
        log_message('error', 'payout_model->updatePaidStatus :: Depracated call');
        return true;
    }

    public function getBeforePayoutDateBinary($date_sub) {
        $check_dates = $date_sub;
        $previous_date = '';
        $arr_dates = $this->getAllBinaryPayoutDates('ASC');
        $arr_len = count($arr_dates);
        for ($i = 1; $i < $arr_len; $i++) {
            $k = $i - 1;
            $date_from_arr = $arr_dates[$i];
            if ($check_dates >= $date_from_arr) {
                $previous_date = $arr_dates[$k];

                break;
            }
        }
        return $previous_date;
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function getNonPaidAmounts($previous_pyout_date, $date_sub) {
        log_message('error', 'payout_model->getNonPaidAmounts :: Depracated call');
        $previous_pyout_date = $previous_pyout_date . ' 23:59:59';
        $date_sub_tmp = $date_sub;
        $date_sub = $date_sub . ' 23:59:59';

        $before_payout_date = $this->getBeforePayoutDateBinary($date_sub_tmp);

        $this->db->select_sum('total_amount');
        $this->db->select_sum('amount_payable');
        $this->db->select('user_id');
        $this->db->select('amount_type');
        $this->db->from('leg_amount');
        $this->db->group_by('user_id');
        $query = $this->db->get();
        $i = 0;
        $row1 = array();
        foreach ($query->result_array() as $row) {

            $user_id = $row['user_id'];
            if ($user_id) {
                $row1[$i]['user_id'] = $row['user_id'];
                $row1[$i]['amount_type'] = $row['amount_type'];
                $row1[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $row1[$i]['fullname'] = $this->validation_model->getFullName($row['user_id']);
                $row1[$i]['total_leg'] = 0;
                $row1[$i]['total_amount'] = round($row['total_amount'], 2);
                $row1[$i]['leg_amount_carry'] = 0;
                $row1[$i]['amount_payable'] = round($row['amount_payable'], 2);
                $row1[$i]['tds'] = 0;
                $row1[$i]['service_charge'] = 0;
                $i++;
            }
        }
        $weekly_payout_details = $row1;
        return $weekly_payout_details;
    }

    public function insertPayoutDate($date) {

        $payout = 'payout_release_date';

        $data = array(
            'release_date' => $date
        );

        $res = $this->db->insert("$payout", $data);

        return $res;
    }

    public function getJoiningDate($user_id) {
        $this->db->select('join_date');
        $this->db->where('user_detail_refid', "$user_id");
        $this->db->from('user_details');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            return $row->join_date;
        }
    }

    public function getWeekNo($release_date, $join_date) {

        $date1 = strtotime($release_date);
        $date2 = strtotime($join_date);
        $dateDiff = $date1 - $date2;
        $fullDays = floor($dateDiff / (60 * 60 * 24));
        $week = round($fullDays / 7);
        return $week;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function getPayoutUserDetails($previous_pyout_date, $date_sub) {

        $payout_type = $this->getPayoutType();
        if ($payout_type == 'daily') {
            $this->db->select('a.user_name');
            $this->db->select('b.user_id ');
            $this->db->select_sum('total_amount');
            $this->db->select_sum('amount_payable');
            $this->db->select('b.amount_type ');
            $this->db->select('c.user_detail_name');
            $this->db->select('c.user_detail_address');
            $this->db->select('c.user_detail_mobile');
            $this->db->select('c.user_detail_nbank');
            $this->db->select('c.user_detail_nbranch');
            $this->db->select('c.user_detail_acnumber');
            $this->db->select(' c.user_detail_ifsc');
            $this->db->from('ft_individual AS a');
            $this->db->join('leg_amount AS b', 'a.id = b.user_id', 'inner');
            $this->db->join('user_details AS c', 'a.id = c.user_detail_refid', 'inner');
            $this->db->like('date_of_submission', $date_sub, 'after');
            $this->db->where('active', 'yes');
            $this->db->group_by('a . id');
            $query = $this->db->get();
        } else {
            $this->db->select('a.user_name');
            $this->db->select('b.user_id ');
            $this->db->select_sum('total_amount');
            $this->db->select_sum('amount_payable');
            $this->db->select('b.amount_type ');
            $this->db->select('c.user_detail_name');
            $this->db->select('c.user_detail_address');
            $this->db->select('c.user_detail_mobile');
            $this->db->select('c.user_detail_nbank');
            $this->db->select('c.user_detail_nbranch');
            $this->db->select('c.user_detail_acnumber');
            $this->db->select(' c.user_detail_ifsc');
            $this->db->from('ft_individual AS a');
            $this->db->join('leg_amount AS b', 'a.id = b.user_id', 'inner');
            $this->db->join('user_details AS c', 'a.id = c.user_detail_refid', 'inner');
            $this->db->where('active', 'yes');
            $this->db->group_by('a . id');
            $query = $this->db->get();
        }

        $release = array();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $release[$i]['name'] = $row['user_name'];
            $release[$i]['uid'] = $row['user_id'];
            $release[$i]['total_amount'] = $row['total_amount'];
            $release[$i]['amount_payable'] = $row['amount_payable'];
            $release[$i]['status'] = 'no'; // ??
            $release[$i]['type'] = $row['amount_type'];
            $release[$i]['user_name'] = $row['user_detail_name'];
            $release[$i]['address'] = $row['user_detail_address'];
            $release[$i]['mobile'] = $row['user_detail_mobile'];
            $release[$i]['bank'] = $row['user_detail_nbank'];
            $release[$i]['branch'] = $row['user_detail_nbranch'];
            $release[$i]['acc'] = $row['user_detail_acnumber'];
            $release[$i]['ifsc'] = $row['user_detail_ifsc'];
            $i++;
        }

        return $release;
    }

    public function getPayoutType() {
        $this->db->select('payout_release');
        $this->db->from('configuration');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            return $row->payout_release;
        }
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function getUnPaidAmount($date) {

        $this->db->select_sum('total_leg');
        $this->db->select_sum('total_amount');
        $this->db->select_sum('amount_payable');
        $this->db->select('user_id');
        $this->db->select('amount_type');
        $this->db->from('leg_amount');
        $this->db->join('ft_individual AS ft', 'ft.id = leg_amount.user_id', 'INNER');
        $this->db->where('ft.active', 'yes');
        $this->db->like('date_of_submission', $date, 'after');
        $this->db->group_by('user_id');
        $query = $this->db->get();
        $i = 0;
        $row1 = array();
        foreach ($query->result_array() as $row) {

            $user_id = $row['user_id'];
            if ($user_id) {
                $row1[$i]['user_id'] = $row['user_id'];
                $row1[$i]['amount_type'] = $row['amount_type'];
                $row1[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $row1[$i]['fullname'] = $this->validation_model->getFullName($row['user_id']);
                $row1[$i]['total_leg'] = $row['total_leg'];
                $row1[$i]['total_amount'] = round($row['total_amount'], 2);
                $row1[$i]['leg_amount_carry'] = 0;
                $row1[$i]['amount_payable'] = round($row['amount_payable'], 2);
                $row1[$i]['tds'] = 0;
                $row1[$i]['service_charge'] = 0;
                $i++;
            }
        }
        $payout_details = $row1;
        return $payout_details;
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function payDailyAmount($post) {
        log_message('error', 'payout_model->payDailyAmount :: Depracated call');
        return true;
    }

    public function getPayoutReleasePercentages($user_id = '') {

        $payout_details = array();


        $released_payouts = $this->getReleasedPayoutCount($user_id);
        $pending_payouts = $this->getPendingPayoutCount($user_id);
        $total_payouts = $pending_payouts + $released_payouts;
        if ($total_payouts > 0) {
            $released_payouts_percentage = ($released_payouts / $total_payouts) * 100;
            $pending_payouts_percentage = ($pending_payouts / $total_payouts) * 100;
        } else {
            $released_payouts_percentage = 100;
            $pending_payouts_percentage = 0;
        }

        $payout_details['released'] = $released_payouts_percentage;
        $payout_details['pending'] = $pending_payouts_percentage;

        return $payout_details;
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function getReleasedPayoutCount($user_id = '') {
        log_message('error', 'payout_model->getReleasedPayoutCount :: Depracated call');
        return 0;
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function getPendingPayoutCount($user_id = '') {
        log_message('error', 'payout_model->getPendingPayoutCount :: Depracated call');
        return 0;
    }

    public function getPayoutDetails($payout_release_type, $amount = '') {
        $this->load->model('ewallet_model');
        $payout_details = array();
        if ($amount == '') {
            $amount = $this->getMinimumPayoutAmount();
        }
        $current_date = date('Y-m-d H:i:s');
        if ($payout_release_type == 'ewallet_request') {
            $req_validity = $this->getPayoutRequestValidity();
            $this->db->select('pr.req_id,pr.requested_user_id,pr.requested_date,pr.requested_amount_balance,ft.user_name,ud.user_detail_name' ); //, ba.cash_account');
            $this->db->from('payout_release_requests AS pr');
            $this->db->join('ft_individual AS ft', 'ft.id = pr.requested_user_id', 'INNER');
            $this->db->join('user_details AS ud', 'ud.user_detail_refid = ft.id', 'INNER');
            //$this->db->join('user_balance_amount AS ba', 'ud.user_detail_refid = ba.user_id', 'INNER');
            $this->db->where('ft.active', 'yes');
            $this->db->where('pr.requested_amount >=', $amount);
            $this->db->where('pr.status', "pending");
            $this->db->order_by('pr.requested_date', 'DESC');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $row) {
				$requested_date   = $row['requested_date'];
				$req_id           = $row['req_id'];
				$diff             = abs( strtotime( $requested_date ) - strtotime( $current_date ) );
				$days             = floor( ( $diff ) / ( 60 * 60 * 24 ) );
				$balance_amount   = $this->getUserBalanceAmount( $row['requested_user_id'] );
				//$cash_account     = (double) $this->ewallet_model->getCommission( $row['requested_user_id'], Date( 'Y-m-d', strtotime( $this->ewallet_model->getJoiningDate( $row['requested_user_id'] ) ) ), Date( 'Y-m-d' ) );
				$cash_account   = $balance_amount;
				$requested_amount = $row['requested_amount_balance'];
                if ($days > $req_validity) {
                    $this->db->set('status', 'inactive');
                    $this->db->where('req_id', $req_id);
                    $this->db->update('payout_release_requests');
                } else {
					$payout_details[ $i ]['req_id']           = $row['req_id'];
					$payout_details[ $i ]['user_id']          = $row['requested_user_id'];
					$payout_details[ $i ]['user_name']        = $row['user_name'];
					$payout_details[ $i ]['user_detail_name'] = $row['user_detail_name'];
					$payout_details[ $i ]['balance_amount']   = $balance_amount;
					$payout_details[ $i ]['payout_amount']    = $requested_amount;
					$payout_details[ $i ]['requested_date']   = $row['requested_date'];
					//$payout_details[$i]['cash_account']     = $row['cash_account'];
					$payout_details[ $i ]['cash_account']     = $cash_account;
					$i++;
                }
            }
        } else {
            $this->db->select('usr.user_id,usr.balance_amount,usr.cash_account,ft.user_name,ud.user_detail_name');
            $this->db->from('user_balance_amount AS usr');
            $this->db->join('ft_individual AS ft', 'ft.id = usr.user_id', 'INNER');
            $this->db->join('user_details AS ud', 'ud.user_detail_refid = usr.user_id', 'INNER');
            $this->db->where('ft.active', 'yes');
            $this->db->where('usr.cash_account >=', $amount);
            $this->db->order_by('usr.cash_account', 'DESC');
            $query = $this->db->get();
            $i = 0;
            foreach ($query->result_array() as $row) {
                $payout_details[$i]['req_id'] = $row['user_id'];
                $payout_details[$i]['user_id'] = $row['user_id'];
                $payout_details[$i]['user_name'] = $row['user_name'];
                $payout_details[$i]['user_detail_name'] = $row['user_detail_name'];
                $payout_details[$i]['balance_amount'] = $row['cash_account'];
                $payout_details[$i]['payout_amount'] = $amount;
                $payout_details[$i]['requested_date'] = $current_date;
                $i++;
            }
        }
        return $payout_details;
    }

    public function getMinimumPayoutAmount() {
        $amount = 0;
        $this->db->select('min_payout');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $amount = $row->min_payout;
        }
        return $amount;
    }
    public function getMaximumPayoutAmount() {
        $amount = 0;
        $this->db->select('max_payout');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $amount = $row->max_payout;
        }
        return $amount;
    }

    public function checkTransactionPassword($user_id, $transation_password) {
        $this->db->select('*');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $this->db->where('tran_password', $transation_password);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getPayoutRequestValidity() {
        $request_validity = 0;
        $this->db->select('payout_request_validity');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $request_validity = $row->payout_request_validity;
        }
        return $request_validity;
    }

    public function getUserBalanceAmount($user_id) {
//        $user_balance = 0;
//        $this->db->select('cash_account');
//        $this->db->from('user_balance_amount');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get();
//
//        foreach ($query->result() as $row) {
//            $user_balance = round($row->cash_account, 2);
//        }
//        return $user_balance;
		$this->load->model('ewallet_model');
		return (double) $this->ewallet_model->getCommission2( $user_id, Date( 'Y-m-d', strtotime( $this->ewallet_model->getJoiningDate( $user_id ) ) ), Date( 'Y-m-d' ) );
    }

    public function updateUserBalanceAmount($user_id, $payout_release_amount) {
        $res = 0;
        $balance_amount = $this->getUserBalanceAmount($user_id);
        if ($balance_amount >= $payout_release_amount && $payout_release_amount > 0) {
            $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $payout_release_amount . ',2)', FALSE);
            $this->db->set('cash_account', 'ROUND(cash_account - ' . $payout_release_amount . ',2)', FALSE);
            $this->db->where('user_id', $user_id);
            $res = $this->db->update('user_balance_amount');
        }

        return $res;
    }

    public function insertPayoutReleaseRequest($user_id, $payout_amount, $request_date, $status = 'pending') {

        $data = array(
            'requested_user_id' => $user_id,
            'requested_amount' => $payout_amount,
            'requested_amount_balance' => $payout_amount,
            'requested_date' => $request_date,
            'status' => $status
        );
        $res = $this->db->insert('payout_release_requests', $data);
        return $res;
    }

    public function getReleasedPayoutTotal($user_id) {
        $total_amount = '';
        $this->db->select_sum('requested_amount');
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('status', 'released');
        $this->db->from('payout_release_requests');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $total_amount = $row->requested_amount;
        }
        return $total_amount;
    }

    public function getRequestPendingAmount($user_id) {
        $req_amount = '';
        $this->db->select_sum('requested_amount_balance');
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('status', 'pending');
        $this->db->from('payout_release_requests');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $req_amount = $row->requested_amount_balance;
        }
        return $req_amount;
    }

    function getResultAmount ( $balance, $requested_amount ) {
        if( empty( $balance ) || $balance < 5 )
            return 0;
        if( empty( $requested_amount ) && $balance > 5 )
            return $balance - 5;
        if( $balance > ( $requested_amount + 5 )  )
            return $balance - $requested_amount - 5;
        if( $balance < $requested_amount )
            return 0;
    }

    public function deletePayoutRequest($del_id, $user_id) {
        $this->db->set('status', 'deleted');
        $this->db->where('req_id', $del_id);
        $this->db->where('requested_user_id', $user_id);
        $res = $this->db->update('payout_release_requests');
        if ($res) {
            $requested_amount = $this->getPayoutRequestAmount($del_id, $user_id);
            if ($requested_amount) {
                $this->addUserBalanceAmount($user_id, $requested_amount);
            }
        }
        return $res;
    }

    public function getPayoutRequestAmount($del_id, $user_id) {
        $requested_amount = 0;
        $this->db->select('requested_amount_balance');
        $this->db->where('req_id', $del_id);
        $this->db->where('requested_user_id', $user_id);
        $query = $this->db->get('payout_release_requests');
        foreach ($query->result_array()AS $row) {
            $requested_amount = $row["requested_amount_balance"];
        }
        return $requested_amount;
    }

    public function addUserBalanceAmount($user_id, $amount) {
        $res = 0;
        $balance_amount = $this->getUserBalanceAmount($user_id);
        if ($balance_amount >= $amount && $amount > 0) {
            $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $amount . ',2)', FALSE);
            $this->db->set('cash_account', 'ROUND(cash_account + ' . $amount . ',2)', FALSE);
            $this->db->where('user_id', $user_id);
            $res = $this->db->update('user_balance_amount');
        }
        return $res;
    }

    public function getMonthlyDetails($date) {
        $date = strtotime($date);
        $month = date('m', $date);
        $year = date('Y', $date);
        $this->db->select('product_id');
        $this->db->where('active', 'yes');
        $this->db->where('month(date_of_joining)', $month);
        $this->db->where('year(date_of_joining)', $year);

        $this->db->from('ft_individual');
        $res = $this->db->get();
        $toatal_amount = 0;
        foreach ($res->result_array() as $row) {
            $toatal_amount +=$this->gteProductValue($row['product_id']);
        }
        return $toatal_amount;
    }

    public function gteProductValue($pd_id) {
        $this->db->select('product_value');
        $this->db->where('product_id', $pd_id);
        $this->db->from('package');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            return $row['product_value'];
        }
    }

    public function getMonthlyCommisionDetails($date) {
        $date = strtotime($date);
        $month = date('m', $date);
        $year = date('Y', $date);
        $this->db->select_sum('total_amount');
        $this->db->select('amount_type');
        $this->db->where('month(date_of_submission)', $month);
        $this->db->where('year(date_of_submission)', $year);
        $this->db->group_by('amount_type');
        $this->db->from('leg_amount');
        $res = $this->db->get();
        $i = 0;
        $result['total'] = 0;
        foreach ($res->result_array() as $row) {
            $result[$i]['total_amount'] = $row['total_amount'];
            $result[$i]['amount_type'] = $row['amount_type'];
            $result['total']+=$row['total_amount'];
            $i++;
        }
        return $result;
    }

    public function getUserDetails($user_id) {
        $this->load->model('country_state_model');
        $this->db->select('*');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->from('user_details');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $result[$i]['name'] = $row['user_detail_name'];
            $result[$i]['address'] = $row['user_detail_address'];
            $result[$i]['pin'] = $row['user_detail_pin'];
            $result[$i]['email'] = $row['user_detail_email'];
            $result[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
            $result[$i]['mobile'] = $row['user_detail_mobile'];
            $result[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $result[$i]['dob'] = $row['user_detail_dob'];
            if ($row['user_detail_gender'] == 'M')
                $result[$i]['gender'] = 'Male';
            else
                $result[$i]['gender'] = 'Female';
//            $result[$i]['pan'] = $row['user_detail_pan'];
            $result[$i]['acc'] = $row['user_detail_acnumber'];
            $result[$i]['bank'] = $row['user_detail_nbank'];
            $result[$i]['branch'] = $row['user_detail_nbranch'];
            $i++;
        }
        return $result;
    }

    public function sendPayoutMail($user_id) {

        $full_name = $this->validation_model->getUserFullName($user_id);
        $mail_details = $this->validation_model->getCommonMailSettings('payout_release');
        $mail_details['mail_content'] = str_replace('{full_name}', $full_name, $mail_details['mail_content']);
        $res = $this->validation_model->sendEmail($mail_details['mail_content'], $user_id, $mail_details['subject']);
        return $res;
    }

    public function sendMailToAdmin($user_id) {
        $this->load->model('mail_model');
        $site_info = $this->validation_model->getSiteInformation();
        $mail_header = $this->mail_model->getHeaderDetails($site_info);
        $mail_footer = $this->mail_model->getFooterDetails($site_info);
        $full_name = $this->validation_model->getUserFullName($user_id);
        $user_name = $this->validation_model->IdToUserName($user_id);
        $admin_id = $this->validation_model->getAdminId();
        $mail_details = $this->validation_model->getCommonMailSettings('payout_release');
        $mail_details['mail_content'] = $mail_header . '<div class="banner" style="background: url(http://infinitemlm.com/mlm-demo/beta/backoffice/public_html/images/banners/banner.jpg);
                      height: 58px;
                      color: #fff;
                      font-size: 21px;
                      padding: 43px 20px 20px 40px;">
                User requested payout
            </div>
            <div class="body_text" style="padding:25px 65px 25px 45px; color:#333333;">
                <h1 style="font-size:18px; color:#333333; font-weight: normal; font-weight: 300;">Dear <span style="font-weight:bold;">'.$this->ADMIN_USER_NAME.',</span></h1>
                <p style="font-size: 14px; line-height: 27px;">&emsp; &emsp;'.$user_name.' requested payout </p>
            </div>'. $mail_footer;
        $mail_details['subject'] = "User Requested Payout";
        $res = $this->validation_model->sendEmail($mail_details['mail_content'], $admin_id, $mail_details['subject']);
//        $res = $this->sendMailSmtp( $mail_details['subject'] ,$mail_details['mail_content'], "mundekat.niyasali@gmail.com");
        return $res;
    }

    public function sendMailSmtp($mail_subject = '', $mail_message = '', $email = '') {
        $mail_details = $this->getSmtpEmailDetails();
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        // $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_host'] = $mail_details['host'];
        $config['smtp_port'] = $mail_details['port'];
        $config['smtp_timeout'] = $mail_details['time_out'];
        $config['smtp_user'] = $mail_details['username'];
        $config['smtp_pass'] = $mail_details['password'];
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from($config['smtp_user'], 'admin');
        $this->email->to($email);

        $this->email->subject($mail_subject);
        $this->email->message($mail_message);

        $this->email->send();
//        $this->email->print_debugger();
    }

    public function getSmtpEmailDetails() {
        $mail_details = array();
        $this->db->select('*');
        $this->db->from('mail_settings');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mail_details['host'] = $row->smtp_host;
            $mail_details['port'] = $row->smtp_port;
            $mail_details['time_out'] = $row->smtp_timeout;
            $mail_details['username'] = $row->smtp_username;
            $mail_details['password'] = $row->smtp_password;
        }
        return $mail_details;
    }

    public function getTransactionFee() {
        $transactio_fee = 0;
        $this->db->select('trans_fee');
        $this->db->from('configuration');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $transactio_fee = $row['trans_fee'];
        }
        return $transactio_fee;
    }

    public function updatePayoutReleaseRequest($request_id, $user_id, $payout_release_amount, $payout_release_type) {
        $result = false;
		$result2 = false;
        if ($payout_release_amount > 0) {
            $update_request = false;
            if ($payout_release_type == 'ewallet_request') {
                if ($this->isPayoutRequestPending($request_id, $user_id)) {
                    $this->db->set('status', 'released');
                    $this->db->set('requested_amount_balance', 'ROUND(requested_amount_balance + ' . - $payout_release_amount . ',2)', FALSE);
                    $this->db->where('requested_user_id', $user_id);
                    $this->db->where('req_id', $request_id);
                    $this->db->where('status', 'pending');
                    $update_request = $this->db->update('payout_release_requests');
                }
            } else {
                $update_request = true;
            }
            if ($update_request) {
                $date = date( "Y-m-d H:i:s" );
                $data = [
                    'paid_user_id' => $user_id,
                    'paid_amount'  => $payout_release_amount,
                    'paid_date'    => $date,
                    'paid_type'    => 'released'
                ];

				$result    = $this->db->insert( 'amount_paid', $data );
				$comission = array_merge( $data, [
					'paid_type'   => 'release_comission',
					'paid_amount' => 5
				] );
				$result2 = $this->db->insert( 'amount_paid', $comission );

            }
        }
        return ( $result === $result2 ) === true;
    }

    public function isPayoutRequestPending($request_id, $user_id) {
        $this->db->where('requested_user_id', $user_id);
        $this->db->where('req_id', $request_id);
        $this->db->where('status', 'pending');
        $count = $this->db->count_all_results('payout_release_requests');
        return $count;
    }

    public function getMinimumMaximunPayoutAmount() {
        $details = array();
        $this->db->select('min_payout,max_payout');
        $this->db->from('configuration');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $details['min_payout'] = $row->min_payout;
            $details['max_payout'] = $row->max_payout;
        }
        return $details;
    }

}
