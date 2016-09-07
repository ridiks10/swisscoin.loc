<?php

class select_report_class_model extends inf_model {

    public $all_payout_details;
    public $member_payout_details;

    public function __construct() {
        $this->load->model('settings_model');
        $this->load->model('validation_model');
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function getTotalPayout($from_date = '', $to_date = '') {
        $this->load->model('leg_class_model');
        if ($from_date == '' AND $to_date == '') {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $leg_amount = $this->table_prefix . "leg_amount";
            $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    GROUP BY user_id";
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $leg_amount = $this->table_prefix . "leg_amount";
            $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    WHERE date_of_submission BETWEEN '$from_date' AND '$to_date'
                    GROUP BY user_id";
        }
        //echo $select;
        $result = $this->selectData($select, "Error on selecting leg amount ..");

        $i = 0;
        while ($row = mysql_fetch_array($result)) {


            $this->all_payout_details["detail$i"]["user_id"] = $row['user_id'];
            $this->all_payout_details["detail$i"]["full_name"] = $this->validation_model->getFullName($row['user_id']);
            $this->all_payout_details["detail$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $this->all_payout_details["detail$i"]["left_leg"] = $this->leg_class_model->getLeftLegCount($row['user_id']);
            $this->all_payout_details["detail$i"]["right_leg"] = $this->leg_class_model->getRightLegCount($row['user_id']);
            $this->all_payout_details["detail$i"]["total_leg"] = 0;
            $this->all_payout_details["detail$i"]["total_amount"] = $row['total_amount'];
            $this->all_payout_details["detail$i"]["amount_payable"] = round($row['amount_payable'], 2);
            $this->all_payout_details["detail$i"]["tds"] = 0;
            $this->all_payout_details["detail$i"]["service_charge"] = 0;
            $i++;
        }
        return $this->all_payout_details;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function getMemberPayout($user_mob_name) {
        $this->load->model('leg_class_model');
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $user_id = $this->validation_model->userNameToID($user_mob_name);
        $leg_amount = $this->table_prefix . "leg_amount";
        $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    WHERE user_id='$user_id'
                    GROUP BY user_id
                    ";
        // echo $select;
        $result = $this->selectData($select, "Error on selecting leg amount ..");

        $row = mysql_fetch_array($result);

        $this->member_payout_details["user_id"] = $row['user_id'];
        $this->member_payout_details["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
        $this->member_payout_details["full_name"] = $this->validation_model->getFullName($row['user_id']);
        $this->member_payout_details["left_leg"] = $this->leg_class_model->getLeftLegCount($row['user_id']);
        $this->member_payout_details["right_leg"] = $this->leg_class_model->getRightLegCount($row['user_id']);
        $this->member_payout_details["total_leg"] = 0;
        $this->member_payout_details["total_amount"] = $row['total_amount'];
        $this->member_payout_details["amount_payable"] = round($row['amount_payable'], 2);
        $this->member_payout_details["tds"] = 0;
        $this->member_payout_details["service_charge"] = 0;

        return $this->member_payout_details;
    }

    public function payoutAllPage() {
        
    }

    public function payoutWeeklyDetails() {
        
    }

    /**
     * Can this even work?
     */
    public function payoutWeeklyPage($from_date, $to_date) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $leg_amount = $this->table_prefix . "leg_amount";
        $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    WHERE date_of_submission BETWEEN '$from_date' AND '$to_date'
                    GROUP BY user_id";
        $result = $this->selectData($select, "Error on selecting leg amount ..");
        $count = mysql_numrows($result);

        return $count;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function payoutWeeklyTotal($limit, $page, $from_date, $to_date, $user = '') {
        $this->load->model('leg_class_model');

        if ($user != '') {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $leg_amount = $this->table_prefix . "leg_amount";
            $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    WHERE date_of_submission BETWEEN '$from_date' AND '$to_date' and user_id ='$user'
                    GROUP BY user_id limit $page, $limit";
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $leg_amount = $this->table_prefix . "leg_amount";
            $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id
                    FROM $leg_amount
                    WHERE date_of_submission BETWEEN '$from_date' AND '$to_date'
                    GROUP BY user_id limit $page, $limit";
        }

        //echo $select;
        $result = $this->selectData($select, "Error on selecting leg amount ..");
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $this->weekly_payout_details["detail$i"]["user_id"] = $row['user_id'];
            $this->weekly_payout_details["detail$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $this->weekly_payout_details["detail$i"]["total_leg"] = 0;
            $this->weekly_payout_details["detail$i"]["total_amount"] = $row['total_amount'];
            $this->weekly_payout_details["detail$i"]["leg_amount_carry"] = 0;
            $this->weekly_payout_details["detail$i"]["amount_payable"] = round($row['amount_payable'], 2);
            $this->weekly_payout_details["detail$i"]["tds"] = 0;
            $this->weekly_payout_details["detail$i"]["service_charge"] = 0;
            $i++;
        }
        return $this->weekly_payout_details;
    }

    public function getActivation($from_date = '', $to_date = '', $status = '') {

        if ($from_date == '' AND $to_date == '') {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $ft_individual = $this->table_prefix . "ft_individual";
            $select = "SELECT user_name FROM $ft_individual where active!='$status'
                    GROUP BY order_id";
        } else {
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $ft_individual = $this->table_prefix . "ft_individual";
            $select = "SELECT user_name FROM $ft_individual where active!='$status' AND date_of_joining BETWEEN '$from_date' AND '$to_date' GROUP BY order_id ";
        }
        //echo $select;
        $result = $this->selectData($select, "Error on selecting Activated User ..");

        $i = 0;
        while ($row = mysql_fetch_array($result)) {

            $this->actiavtion_details["detail$i"]["user_name"] = $row['user_name'];
            $i++;
        }
    }

    /**
     * @deprecated 1.21 this utilized deleted columns.
     */
    public function updatePaidStatus($POST) {
        log_message('error', 'select_report_class_model->updatePaidStatus :: Depracated call');
        return true;
    }

    public function getAllBinaryPayoutDates($order = "DESC") {

        $payout_releasedate = "";
        $obj_arr = $this->settings_model->getSettings();
        if (strcmp($obj_arr["payout_release"], "month") == 0) {
            $payout_releasedate = '365 day';
        } elseif (strcmp($obj_arr["payout_release"], "week") == 0) {
            $payout_releasedate = '7 day';
        }
        $current_date = date("Y-m-d H:i:s");
        $newdate = strtotime($payout_releasedate, strtotime($current_date));
        $newdate_1 = date('Y-m-j', $newdate);
        $this->db->distinct();
        $this->db->select("release_date");
        $this->db->from("payout_release_date");
        $this->db->where("release_date <= '$newdate_1'");
        $this->db->order_by("release_date", $order);
        $res = $this->db->get();

        $dat_arr = Array();
        foreach ($res->result() as $row) {

            $timestamp = strtotime($row->release_date);

            $dat_arr[] = date("Y-m-d", $timestamp);
        }

        $dat_arr1 = array_unique($dat_arr);
        return $dat_arr1;
    }

    public function getBeforePayoutDateBinary($date_sub) {

        $check_dates = $date_sub;
        $arr_dates = $this->getAllBinaryPayoutDates("ASC");
        $arr_len = count($arr_dates);
        for ($i = 0; $i < $arr_len; $i++) {
            $k = $i - 1;
            $date_from_arr = $arr_dates[$i];
            //  echo "CHECK DATE:$check_dates Arr Date:$date_from_arr ";
            if ($check_dates == $date_from_arr) {
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
        log_message('error', 'select_report_class_model->getNonPaidAmounts :: Depracated call');
        $previous_pyout_date = $previous_pyout_date . " 23:59:59";
        $date_sub_tmp = $date_sub;
        $date_sub = $date_sub . " 23:59:59";

        //$amount_type_len= count($amount_type_arr);
        $qr_amount_type = "";
        /* for($j=0;$j<$amount_type_len;$j++)
          {
          $amount_type = $amount_type_arr[$j];
          if($j == 0)
          {

          $qr_amount_type = " amount_type = '$amount_type' ";
          }
          else
          {
          $qr_amount_type .= " OR amount_type = '$amount_type' ";
          }
          } */

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }

        $before_payout_date = $this->getBeforePayoutDateBinary($date_sub_tmp);
        $leg_amount = $this->table_prefix . "leg_amount";
        $select = "SELECT SUM(total_amount) AS total_amount,
                            SUM(amount_payable) AS amount_payable,
                            user_id,amount_type
                            FROM $leg_amount
                            AND  date_of_submission  <= '$date_sub' GROUP BY user_id";

        //echo   $select;

        $result = $this->selectData($select, "Error on selecting leg amount 4546 ..");
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $this->weekly_payout_details["detail$i"]["user_id"] = $row['user_id'];
            $this->weekly_payout_details["detail$i"]["amount_type"] = $row['amount_type'];
            $this->weekly_payout_details["detail$i"]["user_name"] = $this->validation_model->IdToUserName($row['user_id']);
            $this->weekly_payout_details["detail$i"]["fullname"] = $this->validation_model->getFullName($row['user_id']);
            $this->weekly_payout_details["detail$i"]["total_leg"] = 0;
            $this->weekly_payout_details["detail$i"]["total_amount"] = $row['total_amount'];
            $this->weekly_payout_details["detail$i"]["leg_amount_carry"] = 0;
            $this->weekly_payout_details["detail$i"]["amount_payable"] = round($row['amount_payable'], 2);
            $this->weekly_payout_details["detail$i"]["tds"] = 0;
            $this->weekly_payout_details["detail$i"]["service_charge"] = 0;
            $i++;
        }
        return $this->weekly_payout_details;
    }

}
