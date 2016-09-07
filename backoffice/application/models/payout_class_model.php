<?php

class payout_class_model extends inf_model {

    public $all_payout_details;
    public $member_payout_details;

    public function __construct() {

        $this->load->model('settings_model');
        $this->load->model('validation_model');
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     * @todo Requires optimization
     * @param string $from_date Start date. This value wil be escaped!
     * @param string $to_date End date. This value wil be escaped!
     * @return array 
     */
    public function getTotalPayout($from_date = '', $to_date = '') {
        $this->load->model('leg_class_model');
        if ($from_date == '' AND $to_date == '') {
            $this->db->select_sum('leg_amount.total_amount', 'total_amount');
            $this->db->select_sum('leg_amount.amount_payable', 'amount_payable');
            $this->db->select('leg_amount.user_id');
            $this->db->from('leg_amount ');
            $this->db->join('ft_individual', 'leg_amount.user_id=ft_individual.id', 'INNER');
            $this->db->where('ft_individual.active', 'yes');
            $this->db->group_by('leg_amount.user_id');
        } else {
            $this->db->select_sum('leg_amount.total_amount', 'total_amount');
            $this->db->select_sum('leg_amount.amount_payable', 'amount_payable');
            $this->db->select('leg_amount.user_id');
            $this->db->from('leg_amount ');
            $this->db->join('ft_individual', 'leg_amount.user_id=ft_individual.id', 'INNER');
            $this->db->where('ft_individual.active', 'yes');
            $where = "leg_amount.date_of_submission BETWEEN {$this->db->escape($from_date)} AND {$this->db->escape($to_date)}";
            $this->db->where($where);
            $this->db->group_by('leg_amount.user_id');
        }

        $this->db->select('user.user_detail_acnumber,user.user_detail_nbank,user.user_detail_nbranch,user.user_detail_address');
        $this->db->join('user_details as user', 'user.user_detail_refid=leg_amount.user_id', 'INNER');

        $all_payout_details = array();
        $i = 0;
        $query = $this->db->get();
        $row = $query->result_array();
        foreach ($query->result_array() as $row) {
            $all_payout_details['detail' . $i]['user_id'] = $row['user_id'];
            $all_payout_details['detail' . $i]['full_name'] = $this->validation_model->getFullName($row['user_id']);
            $all_payout_details['detail' . $i]['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
            $all_payout_details['detail' . $i]['left_leg'] = $this->leg_class_model->getLeftLegCount($row['user_id']);
            $all_payout_details['detail' . $i]['right_leg'] = $this->leg_class_model->getRightLegCount($row['user_id']);
            $all_payout_details['detail' . $i]['total_leg'] = 0;
            $all_payout_details['detail' . $i]['total_amount'] = $row['total_amount'];
            $all_payout_details['detail' . $i]['amount_payable'] = round($row['amount_payable'], 2);
            $all_payout_details['detail' . $i]['tds'] = 0;
            $all_payout_details['detail' . $i]['service_charge'] = 0;
            //$all_payout_details['detail' . $i]['user_pan'] = $row['user_detail_pan'];
            if ($row['user_detail_acnumber'])
                $all_payout_details['detail' . $i]['acc_number'] = $row['user_detail_acnumber'];
            else
                $all_payout_details['detail' . $i]['acc_number'] = 'NA';
            if ($row['user_detail_nbank'])
                $all_payout_details['detail' . $i]['user_bank'] = $row['user_detail_nbank'];
            else
                $all_payout_details['detail' . $i]['user_bank'] = 'NA';

            if ($row['user_detail_address'])
                $all_payout_details['detail' . $i]['user_address'] = $row['user_detail_address'];
            else
                $all_payout_details['detail' . $i]['user_address'] = 'NA';
            $i++;
        }

        return $all_payout_details;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function getMemberPayout($user_mob_name) {
        $this->load->model('leg_class_model');
        if ($this->table_prefix == '') {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $user_id = $this->validation_model->userNameToID($user_mob_name);
        $leg_amount = $this->table_prefix . 'leg_amount';

        $this->db->select_sum('total_amount', 'total_amount');
        $this->db->select_sum('amount_payable', 'amount_payable');
        $this->db->select('user_id');
        $this->db->from($leg_amount);
        $where = "date_of_submission BETWEEN '$from_date' AND '$to_date'";
        $this->db->where($where);
        $this->db->group_by(user_id);
        $query = $this->db->get();
        $row = $query->result_array();
        $member_payout_details['user_id'] = $row['user_id'];
        $member_payout_details['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
        $member_payout_details['user_id'] = $row['user_id'];
        $member_payout_details['full_name'] = $this->validation_model->getFullName($row['user_id']);
        $member_payout_details['left_leg'] = $this->leg_class_model->getLeftLegCount($row['user_id']);
        $member_payout_details['right_leg'] = $this->leg_class_model->getRightLegCount($row['user_id']);
        $member_payout_details['total_leg'] = 0;
        $member_payout_details['total_amount'] = $row['total_amount'];
        $member_payout_details['amount_payable'] = round($row['amount_payable'], 2);
        $member_payout_details['tds'] = 0;
        $member_payout_details['service_charge'] = 0;

        return $member_payout_details;
    }

    public function payoutAllPage() {
        
    }

    public function payoutWeeklyDetails() {
        
    }

    /**
     * SUM(total_leg) in count result query?..
     */
    public function payoutWeeklyPage($from_date, $to_date) {
        if ($this->table_prefix == '') {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $leg_amount = $this->table_prefix . 'leg_amount';
        $this->db->select_sum('total_amount', 'total_amount');
        $this->db->select_sum('amount_payable', 'amount_payable');
        $this->db->select('user_id');
        $this->db->from($leg_amount);
        $where = "date_of_submission BETWEEN '$from_date' AND '$to_date'";
        $this->db->where($where);
        $this->db->group_by(user_id);
        $query = $this->db->get();
        $count = $this->db->count_all_results();


        return $count;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function payoutWeeklyTotal($limit, $page, $from_date, $to_date, $user = '') {

        $this->load->model('leg_class_model');

        if ($user != '') {
            if ($this->table_prefix == '') {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $leg_amount = $this->table_prefix . 'leg_amount';

            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select('user_id');
            $this->db->from($leg_amount);
            $where = "date_of_submission BETWEEN '$from_date' AND '$to_date' AND user_id ='$user'";
            $this->db->where($where);
            $this->db->group_by(user_id);
            $this->db->limit($limit, $page);

            $query = $this->db->get();
        } else {

            if ($this->table_prefix == '') {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $leg_amount = $this->table_prefix . 'leg_amount';

            $this->db->select_sum('total_amount', 'total_amount');
            $this->db->select_sum('amount_payable', 'amount_payable');
            $this->db->select('user_id');
            $this->db->from($leg_amount);
            $where = "date_of_submission BETWEEN '$from_date' AND '$to_date'";
            $this->db->where($where);
            $this->db->limit($limit, $page);

            $query = $this->db->get();
        }
        $i = 0;
        foreach ($query->result_array() as $row) {
            $row1 = array();
            $user_id = $row['user_id'];
            if ($user_id) {
                $row1[$i]['user_id'] = $row['user_id'];
                $row1[$i]['total_leg'] = 0;
                $row1[$i]['total_amount'] = $row['total_amount'];
                $row1[$i]['leg_amount_carry'] = 0;
                $row1[$i]['user_name'] = $this->validation_model->IdToUserName($user_id);
                $row1[$i]['amount_payable'] = round($row['amount_payable'], 2);
                $row1[$i]['tds'] = 0;
                $row1[$i]['service_charge'] = 0;
                $i++;
            }
        }

        $weekly_payout_details = $row1;
        return $weekly_payout_details;
    }

    public function getActivation($from_date = '', $to_date = '', $status = '') {

        if ($from_date == '' AND $to_date == '') {
            if ($this->table_prefix == '') {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $ft_individual = $this->table_prefix . 'ft_individual';

            $this->db->select('user_name');
            $this->db->where('active!=', $status);
            $this->db->from($ft_individual);
            $this->db->group_by(order_id);
        } else {
            if ($this->table_prefix == '') {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $ft_individual = $this->table_prefix . 'ft_individual';

            $this->db->select('user_name');
            $this->db->where('active!=', $status);
            $where = "date_of_submission BETWEEN '$from_date' AND '$to_date'";
            $this->db->where($where);
            $this->db->from($ft_individual);
            $this->db->group_by('order_id');
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $actiavtion_details['detail' . $i]['user_name'] = $row['user_name'];
            $i++;
        }
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function updatePaidStatus($POST) {
        log_message('error', 'payout_class_model->updatePaidStatus :: Depracated call');
        return true;
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
        log_message('error', 'payout_class_model->getNonPaidAmounts :: Depracated call');
        $this->load->model('leg_class_model');
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

    /* public function getOldPayoutDateBinary($date_sub)
      {


      if($this->table_prefix=="")
      {
      $this->table_prefix= $this->session->userdata('inf_table_prefix');
      }
      $payout_release_date=$this->table_prefix."payout_release_date";
      $qj= "SELECT release_date FROM $payout_release_date WHERE  release_date >'$date_sub' limit 1";
      $res=$this->selectData($qj,"Error on select date 45456");
      $row =mysql_fetch_array($res);
      $previous_date=$row['release_date'];



      return $previous_date;

      //SELECT `release_date` FROM `76_payout_release_date` WHERE `release_date`>2012-02-29 limit 1
      } */
}

?>
