<?php

Class calculation_model extends CI_Model {

    public $fromDateCal;
    public $toDateCal;
    public $user_arr;
    public $user_detail_arr;
    public $user_detail_id_arr;
    public $obj_mng;
    public $upline_id_arr;

    public function __construct() {

        parent::__construct();
        $this->fromDateCal = null;
        $this->toDateCal = null;
        $this->user_arr = array();
        $this->user_detail_arr = array();
        $this->user_detail_id_arr = array();

        $this->upline_id_arr = array();
    }

    public function getConfigurationEntries($tprefix) {

        require_once 'settings_model.php';
        $obj_sett = new settings_model();
        $arr_config = $obj_sett->getSettings($tprefix);

        return $arr_config;
    }

    public function calculateLegCount($tprefix, $id, $father_id, $product_id, $child_position, $from_id = '') {



        $obj_arr = $this->getConfigurationEntries($tprefix);

        $pair_price = $obj_arr['pair_price'];

        $ceiling_user = $obj_arr['pair_ceiling'];

        $tds_db = $obj_arr['tds'];

        $service_charge_db = $obj_arr['service_charge'];

        $product_point_value = $obj_arr['product_point_value'];

        $pair_commission_type = $obj_arr['pair_commission_type'];

        $amount = $this->getProductValue($tprefix, $product_id);
        $product_amount = $amount['pair_value'];
        $pdct_amnt = $amount['product_value'];

        $week_start_date_db = $obj_arr['startDate'];

        $week_end_date_db = $obj_arr['endDate'];

        $payout_release = $obj_arr['payout_release'];

        if ($payout_release == 'month') {

            $current_date = date('Y-m-d');

            $month_arr = $this->getCurrentMonthStartEndDates($tprefix, $current_date);

            $from_date = $month_arr['month_first_date'];

            $to_date = $month_arr['month_end_date'];
        } else if ($payout_release == 'week') {

            $week_arr = $this->getWeekStartEndDates($tprefix, $week_end_date_db, $week_start_date_db);

            $from_date = $week_arr['startDate'];

            $to_date = $week_arr['endDate'];
        } else if ($payout_release == 'daily') {

            $from_date = date('Y-m-d') . ' 00:00:00';

            $to_date = date('Y-m-d') . ' 23:59:59';
        } else {
            $from_date = date('Y-m-d') . ' 00:00:00';

            $to_date = date('Y-m-d') . ' 23:59:59';
        }

        $this->getAllUplineId($tprefix, $father_id, 0, $child_position);

        $total_len = count($this->upline_id_arr);

        if ($product_amount > 0) {

            $this->updateAllUpline($tprefix, $product_amount);
        }

        $this->upline_id_arr[] = array();

        for ($i = 0; $i < $total_len; $i++) {

            $user_id = $this->upline_id_arr['detail' . $i]['id'];

            $left_leg = $this->upline_id_arr['detail' . $i]['left_carry'];

            $right_leg = $this->upline_id_arr['detail' . $i]['right_carry'];

            $product_id = $this->upline_id_arr['detail' . $i]['product_id'];

            $is_First_Pair = $this->isFirstPair($tprefix, $user_id, $from_date, $to_date);
            $user_pair_arr = $this->getUserPair($tprefix, $user_id, $left_leg, $right_leg, $is_First_Pair, $ceiling_user, $product_point_value, $from_date, $to_date);

            $user_pair = $user_pair_arr['pair'];

            $left_leg = $user_pair_arr['left_leg'];

            $right_leg = $user_pair_arr['right_leg'];

            if ($user_pair > 0) {

                $total_amount = $user_pair * $pair_price;

                $tds_amount = ($total_amount * $tds_db ) / 100;

                $service_charge = ($total_amount * $service_charge_db ) / 100;

                $amount_payable = $total_amount - ($tds_amount + $service_charge);

                $date_of_sub = date('Y-m-d H:i:s');

                $this->insertInToLegAmount($tprefix, $user_id, $left_leg, $right_leg, $user_pair, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, 'leg', $from_id);

                $user_pair = $user_pair * $product_point_value;

                $left_leg = $left_leg - $user_pair;
                $right_leg = $right_leg - $user_pair;

                $this->updateFTIndividualForPair($tprefix, $user_id, $left_leg, $right_leg, $user_pair);
            } else {

                $balance = min($left_leg, $right_leg);

                if (($is_First_Pair === false) and ($balance > 0 AND ($left_leg > $product_point_value AND $right_leg > $product_point_value))) {

                    $left_leg = $left_leg - $balance;

                    $right_leg = $right_leg - $balance;

                    $this->updateFTIndividualForPair($tprefix, $user_id, $left_leg, $right_leg, 0);
                }
            }
        }
        return TRUE;
    }

    public function getUserPair($tprefix, $user_id, $left_leg, $right_leg, $is_First_Pair, $ceiling_user, $product_point_value, $from_date, $to_date) {



        $pair = 0;
        if (($left_leg >= $product_point_value) && ($right_leg >= $product_point_value)) {

            if ($is_First_Pair) {

                if (($left_leg >= (2 * $product_point_value)) or ($right_leg >= (2 * $product_point_value)) && (($left_leg > 0) && ($right_leg > 0))) {

                    if ($left_leg < $right_leg) {

                        $right_leg = $right_leg - $product_point_value;

                        $first_pair = 'right';

                        $data = array('first_pair' => $first_pair);

                        $this->db->where('id', $user_id);
                    } else {

                        $left_leg = $left_leg - $product_point_value;

                        $first_pair = 'left';

                        $data = array('first_pair' => $first_pair);
                        $this->db->where('id', $user_id);
                    }

                    $result = $this->db->update($tprefix . '_ft_individual', $data);
                } else {

                    $left_leg = 0;

                    $right_leg = 0;

                    $pair = 0;
                }
            }

            $pair = min(intval($left_leg / $product_point_value), intval($right_leg / $product_point_value));


            $week_total = $this->getWeekTotal($tprefix, $user_id, $from_date, $to_date);

            $week_added_total = $week_total + $pair;

            if ($week_added_total > $ceiling_user) {

                if ($week_total >= $ceiling_user) {

                    $pair = 0;
                } else {

                    $pair = $ceiling_user - $week_total;
                }
            }
        }
        $ret_arr['pair'] = $pair;

        $ret_arr['left_leg'] = $left_leg;

        $ret_arr['right_leg'] = $right_leg;

        return $ret_arr;
    }

    public function isFirstPair($tprefix, $user_id, $from_date, $to_date) {

        $flag = 0;

        $flag_betweeen_week = 0;

        $today = date('Y-m-d H:i:s');


        if ($from_date <= $today and $today <= $to_date) {

            $flag_betweeen_week = 1;
        }

        $this->db->select('COUNT(*) AS count');

        $this->db->from($tprefix . '_leg_amount');

        $this->db->where('user_id', $user_id);

        $this->db->where('amount_type', 'leg');

        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $cnt = $row->count;
        }

        if ($cnt <= 0) {

            $flag = 1;
        }
        return $flag;
    }

    public function updateAllUpline($tprefix, $product_amount) {

        $user_left_id = array();
        $user_right_id = array();

        $total_len = count($this->upline_id_arr);

        for ($i = 0; $i < $total_len; $i++) {

            $user_id = $this->upline_id_arr['detail' . $i]['id'];

            $position = $this->upline_id_arr['detail' . $i]['child_position'];

            if ($position == 'L') {

                $user_left_id[] = $user_id;

                $this->upline_id_arr['detail' . $i]['left_carry'] += $product_amount;
            } else if ($position == 'R') {

                $user_right_id[] = $user_id;

                $this->upline_id_arr['detail' . $i]['right_carry'] += $product_amount;
            }
        }

        $letf_id_count = count($user_left_id);

        if ($letf_id_count > 0) {

            if ($letf_id_count >= 5000) {

                $input_array = $user_left_id;

                $split_arr_left = array_chunk($input_array, intval($letf_id_count / 4));

                for ($i = 0; $i < count($split_arr_left); $i++) {

                    $left_id_qry = $this->createQuery($split_arr_left[$i]);

                    $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);

                    $this->db->where($left_id_qry);

                    $result = $this->db->update($tprefix . '_ft_individual');

                    $active = 'yes';

                    if ($active == 'yes') {

                        $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_left_count', 'ROUND(total_left_count +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_active', 'ROUND(total_active +' . $product_amount.',2)', FALSE);
                        $this->db->where($left_id_qry);
                    } else {

                        $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_left_count', 'ROUND(total_left_count +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_inactive', 'ROUND(total_inactive +' . $product_amount.',2)', FALSE);
                        $this->db->where($left_id_qry);
                    }
                    $result = $this->db->update($tprefix . '_leg_details');
                }
            } else {

                $left_id_qry = $this->createQuery($user_left_id);

                $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);

                $this->db->where($left_id_qry);

                $result = $this->db->update($tprefix . '_ft_individual');

                $active = 'yes';

                if ($active == 'yes') {


                    $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_left_count', 'ROUND(total_left_count +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_active', 'ROUND(total_active +' . $product_amount.',2)', FALSE);

                    $this->db->where($left_id_qry);
                } else {

                    $this->db->set('total_left_carry', 'ROUND(total_left_carry +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_left_count', 'ROUND(total_left_count +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_inactive', 'ROUND(total_inactive +' . $product_amount.',2)', FALSE);

                    $this->db->where($left_id_qry);
                }
                $result = $this->db->update($tprefix . '_leg_details');
            }
        }



        $right_id_count = count($user_right_id);

        if ($right_id_count > 0) {

            if ($right_id_count >= 5000) {

                $input_array = $user_right_id;

                $split_arr_right = array_chunk($input_array, intval($right_id_count / 4));

                for ($i = 0; $i < count($split_arr_right); $i++) {

                    $right_id_qry = $this->createQuery($split_arr_right[$i]);

                    $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);

                    $this->db->where($right_id_qry);

                    $result = $this->db->update($tprefix . '_ft_individual');

                    $active = 'yes';

                    if ($active == 'yes') {

                        $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_right_count', 'ROUND(total_right_count +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_active', 'ROUND(total_active +' . $product_amount.',2)', FALSE);
                        $this->db->where($right_id_qry);
                    } else {


                        $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_right_count', 'ROUND(total_right_count +' . $product_amount.',2)', FALSE);
                        $this->db->set('total_inactive', 'ROUND(total_inactive +' . $product_amount.',2)', FALSE);
                        $this->db->where($right_id_qry);
                    }

                    $result = $this->db->update($tprefix . '_leg_details');
                }
            } else {


                $right_id_qry = $this->createQuery($user_right_id);


                $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);


                $this->db->where($right_id_qry);

                $result = $this->db->update($tprefix . '_ft_individual');

                $active = 'yes';

                if ($active == 'yes') {

                    $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_right_count', 'ROUND(total_right_count +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_active', 'ROUND(total_active +' . $product_amount.',2)', FALSE);
                    $this->db->where($right_id_qry);
                } else {

                    $this->db->set('total_right_carry', 'ROUND(total_right_carry +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_right_count', 'ROUND(total_right_count +' . $product_amount.',2)', FALSE);
                    $this->db->set('total_inactive', 'ROUND(total_inactive +' . $product_amount.',2)', FALSE);
                    $this->db->where($right_id_qry);
                }
                $result = $this->db->update($tprefix . '_leg_details');
            }
        }
    }

    public function createQuery($all_id) {


        $len = count($all_id);


        for ($i = 0; $i < $len; $i++) {

            if ($i == 0)
                $qry = "id = $all_id[$i]";
            else
                $qry .= " OR id = $all_id[$i]";
        }

        return $qry;
    }

    public function getAllUplineId($tprefix, $id, $i, $child_position = '') {

        $this->db->select('father_id,total_leg,total_left_carry,total_right_carry,product_id,position');
        $this->db->from($tprefix . '_ft_individual');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $cnt = $query->num_rows();


        if ($cnt > 0) {
            foreach ($query->result() as $row) {

                $father_id = $row->father_id;
                $this->upline_id_arr['detail' . $i]['id'] = $id;
                $this->upline_id_arr['detail' . $i]['position'] = $row->position;


                if ($i == 0) {
                    $this->upline_id_arr['detail' . $i]['child_position'] = $child_position;
                } else {
                    $k = $i - 1;
                    $this->upline_id_arr['detail' . $i]['child_position'] = $this->upline_id_arr['detail' . $k]['position'];
                }

                $this->upline_id_arr['detail' . $i]['left_carry'] = $row->total_left_carry;
                $this->upline_id_arr['detail' . $i]['right_carry'] = $row->total_right_carry;
                $this->upline_id_arr['detail' . $i]['product_id'] = $row->product_id;
                $i = $i + 1;
            }
            $this->getAllUplineId($tprefix, $father_id, $i);
        }
        return TRUE;
    }

    public function getProductValue($tprefix, $product_id) {

        $amount = array();

        $this->db->select('pair_value');
        $this->db->select('product_value');

        $this->db->from($tprefix . '_product');

        $this->db->where('product_id', $product_id);

        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $amount['pair_value'] = $row->pair_value;
            $amount['product_value'] = $row->product_value;
        }

        return $amount;
    }
    
    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function insertInToLegAmount($tprefix, $user_id, $totalLeft, $totalRight, $totalLeg, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type = 'leg', $from_id = '') {

        $date_of_sub = strtotime($date_of_sub);

        $date_of_sub += 1;
        $date_of_sub = date('Y-m-d H:i:s', $date_of_sub);

        $obj_arr = $this->getConfigurationEntries($tprefix);

        $payout_release = $obj_arr['payout_release'];
        if ($payout_release == 'daily')
            $nextpayoutreleasedate = date('Y-m-d');
        else
            $nextpayoutreleasedate = $this->selectpayoutrelease($tprefix, $date_of_sub);

        $this->db->set('user_id', $user_id);
        $this->db->set('from_id', $from_id);
        $this->db->set('total_amount', round($total_amount, 2));
        $this->db->set('amount_payable', round($amount_payable, 2));
        $this->db->set('date_of_submission', $date_of_sub);
        $this->db->set('amount_type', $amount_type);
        $result = $this->db->insert($tprefix . '_leg_amount');
        $result1 = $this->updateBalanceAmount($tprefix, $user_id, $amount_payable);

        return $result;
    }

    public function updateBalanceAmount($tprefix, $user_id, $total_amount) {

        $this->db->set('balance_amount', 'ROUND(balance_amount +' . $total_amount.',2)', FALSE);

        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update($tprefix . '_user_balance_amount');

        return $res;
    }

    public function getWeekStartEndDates($tprefix, $startDate, $endDate) {

        if (date('l') == $startDate)
            $this_sat = date('Y-m-d 23:59:59');

        else {

            $a = strtotime("next $startDate");


            $this_sat = date('Y-m-d 23:59:59', $a);
        }

        if (date('l') == $endDate)
            $last_sat = date('Y-m-d 00:00:00');

        else {

            $a = strtotime("last $endDate");

            $last_sat = date('Y-m-d 00:00:00', $a);
        }

        $arr['startDate'] = $last_sat;

        $arr['endDate'] = $this_sat;

        return $arr;
    }

    public function getCurrentMonthStartEndDates($tprefix, $current_date) {

        $start_date = '';

        $end_date = '';

        $date = $current_date;

        list($yr, $mo, $da) = explode('-', $date);

        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo, 1, $yr));

        $i = 2;

        list($yr, $mo, $da) = explode('-', $start_date);

        while (date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {

            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));

            $i++;
        }
        $ret_arr['month_first_date'] = $start_date;

        $ret_arr['month_end_date'] = $end_date;

        return $ret_arr;
    }
    
    /**
     * @deprecated 1.21 DB columns erased
     */
    function getWeekTotal($tprefix, $user_id, $from_date, $to_date) {
        return 0;
        $this->db->select_sum('total_leg', 'tot_amt');
        $this->db->where('user_id', $user_id);
        $where = "date_of_submission between '$from_date' and '$to_date'";
        $this->db->where($where);
        $this->db->from($tprefix . '_leg_amount');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $total_ceiling = $row->tot_amt;
        }

        return $total_ceiling;
    }

    public function updateFTIndividual($tprefix, $first_pair, $user_id) {

        $data = array(
            'first_pair' => $first_pair
        );
        $this->db->where('id', $user_id);
        $res = $this->db->update($tprefix . '_ft_individual', $data);
        return $res;
    }

    public function updateFTIndividualForPair($tprefix, $user_id, $left_leg, $right_leg, $user_pair) {

        $this->db->set('total_left_carry', $left_leg);

        $this->db->set('total_right_carry', $right_leg);

        $this->db->set('total_leg', "total_leg +  $user_pair", FALSE);

        $this->db->where('id', $user_id);

        $this->db->limit(1);

        $result = $this->db->update($tprefix . '_ft_individual');

        $data = array(
            'total_left_carry' => $left_leg,
            'total_right_carry' => $right_leg
        );
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $result1 = $this->db->update($tprefix . '_leg_details', $data);

        return $result;
    }

    public function getReferalId($tprefix, $user_id) {
        $referal_id = '';
        $this->db->select('user_details_ref_user_id');
        $this->db->from($tprefix . '_user_details');
        $this->db->where('user_detail_refid ', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_id = $row->user_details_ref_user_id;
        }
        return $referal_id;
    }

    public function selectpayoutrelease($tprefix, $date_of_sub) {

        $nextpayoutreleasedate = '';

        $this->db->select_min('release_date');

        $this->db->from($tprefix . '_payout_release_date');

        $this->db->where('release_date >=', $date_of_sub);

        $this->db->limit(1);

        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $nextpayoutreleasedate = $row->release_date;
        }

        return $nextpayoutreleasedate;
    }

    public function insertReferalAmount($tprefix, $referal_id, $referal_amount, $from_id = '') {
        $res = '';
        if ($referal_id != '') {

            $obj_arr = $this->getConfigurationEntries($tprefix);

            $tds_db = $obj_arr['tds'];

            $service_charge_db = $obj_arr['service_charge'];

            $total_amount = $referal_amount;

            $amount_type = 'referal';

            $tds_amount = ($total_amount * $tds_db ) / 100;

            $service_charge = ($total_amount * $service_charge_db ) / 100;

            $amount_payable = $total_amount - ($tds_amount + $service_charge);

            $date_of_sub = date('Y-m-d H:i:s');

            $res = $this->insertInToLegAmount($tprefix, $referal_id, 0, 0, 0, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type, $from_id);
        }
        return $res;
    }

}
