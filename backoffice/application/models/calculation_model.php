<?php

Class calculation_model extends Inf_Model {

    public $fromDateCal;
    public $toDateCal;
    public $user_arr;
    public $user_detail_arr;
    public $user_detail_id_arr;
    public $obj_module;
    public $obj_mng;
    public $upline_id_arr;
    public $upline_user_arr;

    public function __construct() {
        $this->fromDateCal = null;
        $this->toDateCal = null;
        $this->user_arr = array();
        $this->user_detail_arr = array();
        $this->user_detail_id_arr = array();

        $this->upline_id_arr = array();
        $this->load->model('settings_model');
    }

    public function calculateLegCount($from_user, $father_id, $product_amount, $amount_type = 'matching_bonus', $stage, $date = null) {

        $depth_cieling = $this->settings_model->getDepthCieling();

        $config_details = $this->settings_model->getSettings();

        $tds_db = $config_details["tds"];

        $service_charge_db = $config_details["service_charge"];

        $type_levelcomission = $config_details["level_commission_type"];


        $this->getAllUplineId($father_id, 0, $depth_cieling);
        $total_len = count($this->upline_id_arr);
        $date_of_sub = empty($date) ? date("Y-m-d H:i:s") : $date;

        for ($i = 0; $i < $total_len; $i++) {
            $user_id = $this->upline_id_arr["detail$i"]["id"];
            $level = $this->upline_id_arr["detail$i"]["user_level"];

            $level_amount = 0;
            $level_percent = $this->settings_model->getLevelOnePercetage($level);
//            if ($type_levelcomission == "") {
            $level_amount = $product_amount * ( $level_percent / 100);
//            } else {
//                $level_amount = $level_percent;
//            }

            $mb_status = $this->getMatchingBonusStatus($user_id, $date);


            if ($level_amount && $mb_status) {
                $tds_amount = ($level_amount * $tds_db) / 100;

                $service_charge = ($level_amount * $service_charge_db) / 100;

                $amount_payable = $level_amount - ($tds_amount + $service_charge);

                $cash_amount = $amount_payable * 0.6;
                $trade_amount = $amount_payable * 0.4;

                $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user, $product_id = 0, $product_pair_value = 0, $product_amount, $oc_order_id = 0, $cash_amount, $trade_amount, $stage);
            }
        }
        return TRUE;
    }

    public function updateBalanceAmount($user_id, $total_amount, $cash_amount, $trade_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount +' . $total_amount . ',2)', FALSE);
        $this->db->set('cash_account', 'ROUND(cash_account +' . $cash_amount . ',2)', FALSE);
        $this->db->set('trading_account', 'ROUND(trading_account +' . $trade_amount . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');

        return $res;
    }

    public function getAllUplineId($id, $i, $limit) {
        $this->db->select('father_id,product_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $cnt = $query->num_rows();

        if ($cnt > 0) {
            foreach ($query->result() as $row) {
                $father_id = $row->father_id;
                $this->upline_id_arr["detail$i"]["id"] = $id;
                $this->upline_id_arr["detail$i"]["user_level"] = $i + 1;
                $this->upline_id_arr["detail$i"]["product_id"] = $row->product_id;
                $i = $i + 1;
            }
            if ($i < $limit && $father_id) {
                $this->getAllUplineId($father_id, $i, $limit);
            }
        }
    }

    public function insertTeamBonusInToLegAmount($user_id, $amount, $amount_type, $from_user = '', $product_id = 0, $from_level = 0, $stage, $date = null) {

        $bonus_status = $this->getTeamBonusStatus($user_id, $date);
        if ($amount && $bonus_status) {

            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $tds_db = $config_details["tds"];

            $service_charge_db = $config_details["service_charge"];

            $tds_amount = ($amount * $tds_db ) / 100;

            $service_charge = ($tds_amount * $service_charge_db ) / 100;

            $amount_payable = $amount - ($tds_amount + $service_charge);

            $cash_amount = $amount_payable * 0.6;
            $trade_amount = $amount_payable * 0.4;

            $date_of_sub = empty($date) ? date("Y-m-d H:i:s") : $date;

            $this->insertInToLegAmount($user_id, $amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = '', $amount, $oc_order_id = '', $cash_amount, $trade_amount, $stage);
//            $sponsor_id = $this->validation_model->getSponsorId($user_id);
//            if ($sponsor_id) {
//                $this->calculateLegCount($user_id, $sponsor_id, $amount, $amount_type = 'matching_bonus', $stage, $date);
//            }
        }

        return TRUE;
    }

    public function insertBonusInToLegAmount($user_id, $amount, $amount_type, $from_user = '', $product_id = 0, $from_level = 0, $stage, $date = null) {

        if ($amount) {

            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $tds_db = $config_details["tds"];

            $service_charge_db = $config_details["service_charge"];

            $tds_amount = ($amount * $tds_db ) / 100;

            $service_charge = ($tds_amount * $service_charge_db ) / 100;

            $amount_payable = $amount - ($tds_amount + $service_charge);

            $cash_amount = $amount_payable * 0.6;
            $trade_amount = $amount_payable * 0.4;

            $date_of_sub = empty($date) ? date("Y-m-d H:i:s") : $date;

            $this->insertInToLegAmount($user_id, $amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = '', $amount, $oc_order_id = '', $cash_amount, $trade_amount, $stage);


            $sponsor_id = $this->validation_model->getSponsorId($user_id);
            if ($sponsor_id) {
                $this->calculateLegCount($user_id, $sponsor_id, $amount, $amount_type = 'matching_bonus', $stage, $date);
            }
        }

        return TRUE;
    }

    public function insertFastStartBonusInToLegAmount($user_id, $amount, $amount_type, $from_user = '', $product_id = 0, $from_level = 0, $stage) {

        if ($amount) {

            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $tds_db = $config_details["tds"];

            $service_charge_db = $config_details["service_charge"];

            $tds_amount = ($amount * $tds_db ) / 100;

            $service_charge = ($tds_amount * $service_charge_db ) / 100;

            $amount_payable = $amount - ($tds_amount + $service_charge);

            $cash_amount = $amount_payable * 0;
            $trade_amount = $amount_payable * 1;

            $date_of_sub = date("Y-m-d H:i:s");


            $this->insertInToLegAmount($user_id, $amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = '', $amount, $oc_order_id = '', $cash_amount, $trade_amount, $stage);
        }

        return TRUE;
    }

    public function insertDiamontPoolBonusInToLegAmount($user_id, $amount, $amount_type, $from_user = '', $product_id = 0, $from_level = 0, $stage, $date = null) {

        if ($amount) {

            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $tds_db = $config_details["tds"];

            $service_charge_db = $config_details["service_charge"];

            $tds_amount = ($amount * $tds_db ) / 100;

            $service_charge = ($tds_amount * $service_charge_db ) / 100;

            $amount_payable = $amount - ($tds_amount + $service_charge);

            $cash_amount = $amount_payable * 0;
            $trade_amount = $amount_payable * 1;

            $date_of_sub = empty($date) ? date("Y-m-d H:i:s") : $date;

            $this->insertInToLegAmount($user_id, $amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = '', $amount, $oc_order_id = '', $cash_amount, $trade_amount, $stage);
        }
        return TRUE;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user = '', $product_id = 0, $product_pair_value = 0, $product_amount = 0, $oc_order_id = 0, $cash_amount, $trade_amount, $stage) {
        $result = false;
        $active_status = $this->validation_model->isUserActive($user_id);
        if ($total_amount && $active_status) {
            $date_of_sub = strtotime($date_of_sub);
            $date_of_sub += 1;
            $date_of_sub = date("Y-m-d H:i:s", $date_of_sub);

            $this->db->set('user_id', $user_id);
            $this->db->set('from_id', $from_user);
            $this->db->set('total_amount', round($total_amount, 2));
            $this->db->set('amount_payable', round($amount_payable, 2));
            $this->db->set('date_of_submission', $date_of_sub);
            $this->db->set('user_level', $level);
            $this->db->set('amount_type', $amount_type);
            $this->db->set('pair_value', $product_pair_value);
            $this->db->set('product_value', round($product_amount));
            $this->db->set('cash_account', round($cash_amount, 2));
            $this->db->set('trading_account', round($trade_amount, 2));
            $this->db->set('stage', $stage);

            $MODULE_STATUS = $this->trackModule();
            if ($MODULE_STATUS['opencart_status_demo'] == "yes") {
                $this->db->set('oc_order_id', $oc_order_id);
            }

            $result = $this->db->insert('leg_amount');
            if ($result) {
                $this->updateBalanceAmount($user_id, $amount_payable, $cash_amount, $trade_amount);
            }
        }
        return $result;
    }

    public function getWeekStartEndDates($startDate, $endDate) {
        if (date("l") == $startDate)
            $this_sat = date("Y-m-d 23:59:59");
        else {
            $a = strtotime("next $startDate");
            $this_sat = date("Y-m-d 23:59:59", $a);
        }

        if (date("l") == $endDate)
            $last_sat = date("Y-m-d 00:00:00");
        else {
            $a = strtotime("last $endDate");
            $last_sat = date("Y-m-d 00:00:00", $a);
        }

        $arr['startDate'] = $last_sat;
        $arr['endDate'] = $this_sat;

        return $arr;
    }

    public function getPrevMonthStartEndDates($current_date) {

        $start_date = '';
        $end_date = '';
        $date = $current_date;

        list($yr, $mo, $da) = explode('-', $date);

        $start_date = date('Y-m-d', mktime(0, 0, 0, $mo - 1, 1, $yr));

        $i = 2;

        list($yr, $mo, $da) = explode('-', $start_date);

        while (date('d', mktime(0, 0, 0, $mo, $i, $yr)) > 1) {
            $end_date = date('Y-m-d', mktime(0, 0, 0, $mo, $i, $yr));
            $i++;
        }
        $ret_arr["month_first_date"] = $start_date;
        $ret_arr["month_end_date"] = $end_date;
        return $ret_arr;
    }

    public function getCurrentMonthStartEndDates($current_date) {

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
        $ret_arr["month_first_date"] = $start_date;
        $ret_arr["month_end_date"] = $end_date;
        return $ret_arr;
    }

    public function createQuery($all_id) {

        $len = count($all_id);
        for ($i = 0; $i < $len; $i++) {
            if ($i == 0)
                $qry = " id=$all_id[$i]";
            else
                $qry .= " OR id=$all_id[$i]";
        }

        return $qry;
    }

    public function selectpayoutrelease($date_of_sub) {
        $nextpayoutreleasedate = "";

        $this->db->select_min('release_date');

        $this->db->from("payout_release_date");

        $this->db->where('release_date >=', $date_of_sub);

        $this->db->limit(1);

        $query = $this->db->get();

        foreach ($query->result() as $row) {

            $nextpayoutreleasedate = $row->release_date;
        }

        return $nextpayoutreleasedate;
    }

    public function insertReferalAmount($referal_id, $referal_amount, $from_user, $from_level = 0) {

        $res = "";
        if ($referal_id != "") {

            $this->load->model('settings_model');
            $config_details = $this->settings_model->getSettings();

            $tds_db = $config_details["tds"];

            $service_charge_db = $config_details["service_charge"];

            $total_amount = $referal_amount;

            $amount_type = "referral";

            $tds_amount = ($total_amount * $tds_db ) / 100;

            $service_charge = ($total_amount * $service_charge_db ) / 100;

            $amount_payable = $total_amount - ($tds_amount + $service_charge);

            $date_of_sub = date("Y-m-d H:i:s");

            $res = $this->insertInToLegAmount($referal_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_user);
        }


        return $res;
    }

    public function getReferalId($user_id) {

        $referal_id = "";
        $this->db->select('sponsor_id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');
        foreach ($query->result() as $row) {
            $referal_id = $row->sponsor_id;
        }
        return $referal_id;
    }

    function calculateLevelCommission($from_user, $father_id, $product_id, $product_pair_value, $product_amount, $amount_type = 'level_commission', $oc_order_id = 0) {

        $this->load->model('settings_model');
        $this->load->model('product_model');

        $config_details = $this->settings_model->getSettings();

        $this->getAllUniLevelUplineId($father_id, 0, $config_details['depth_ceiling']);

        $level_commission_type = $config_details['level_commission_type'];
        $tds_db = $config_details['tds'];
        $service_charge_db = $config_details ['service_charge'];

        if ($level_commission_type == 'percentage' && !$product_pair_value) {
            return TRUE;
        } else {
            $total_len = count($this->upline_user_arr);

            for ($i = 0; $i < $total_len; $i++) {
                $user_id = $this->upline_user_arr["detail$i"]["id"];

                $level = $this->upline_user_arr["detail$i"]["user_level"];

                $date_of_sub = date('Y-m-d H:i:s');

                $level_amount = 0;
                $level_percent = $this->settings_model->getLevelOnePercetage($level);
                if ($level_commission_type == 'percentage') {
                    $level_amount = $product_pair_value * ($level_percent / 100);
                } else {
                    $level_amount = $level_percent;
                }
                if ($level_amount) {
                    $tds_amount = ($level_amount * $tds_db) / 100;

                    $service_charge = ($level_amount * $service_charge_db) / 100;

                    $amount_payable = $level_amount - ($tds_amount + $service_charge);
                    $this->insertInToLegAmount($user_id, $level_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $level, $amount_type, $from_user, $product_id, $product_pair_value, $product_amount, $oc_order_id);
                }
            }
        }
        return TRUE;
    }

    public function getAllUniLevelUplineId($id, $i, $limit) {

        $this->db->select('sponsor_id,product_id');
        $this->db->where('id', $id);
        $query = $this->db->get('ft_individual');
        $cnt = $query->num_rows();

        if ($cnt > 0) {
            foreach ($query->result() as $row) {
                $father_id = $row->sponsor_id;
                $this->upline_user_arr["detail$i"]["id"] = $id;
                $this->upline_user_arr["detail$i"]["user_level"] = $i + 1;
                $this->upline_user_arr["detail$i"] ["product_id"] = $row->product_id;
                $i = $i + 1;
            }
            if ($i < $limit && $father_id) {
                $this->getAllUniLevelUplineId(
                        $father_id, $i, $limit);
            }
        }
    }

    public function insertRankBonus($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $amount_type = "leg", $from_id = '', $from_level = 0) {
        $result = FALSE;
        if ($total_amount) {
            $result = $this->insertInToLegAmount($user_id, $total_amount, $amount_payable, $tds_amount, $service_charge, $date_of_sub, $from_level, $amount_type, $from_id);
        }
        return $result;
    }

    public function getMatchingBonusSettings() {

        $data = array();
        $this->db->select('mb_minimum_pack,mb_first_line_minimum_pack,mb_required_firstliners');
        $this->db->limit(1);
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

    public function getTeamBonusSettings() {

        $data = array();
        $this->db->select('tb_required_firstliners,tb_first_line_minimum_pack');
        $this->db->limit(1);
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data;
    }

    public function getMatchingBonusStatus($user_id, $date = null) {

        $status = false;
        $mb_settings = $this->getMatchingBonusSettings();
        $user_pack = $this->validation_model->getProductId($user_id);
        if ($user_pack >= $mb_settings['mb_minimum_pack']) {

            $this->db->select();
//          $this->db->where('sponsor_id', $user_id);
            $this->db->where('father_id', $user_id);
            $this->db->where('active !=', 'server');
            $this->db->where('product_id >=', $mb_settings['mb_first_line_minimum_pack']);
            if (!empty($date)) {
                $this->db->where('date_of_joining <=', $date);
            }
            $query = $this->db->get('ft_individual');
            $rowcount = $query->num_rows();
            if ($rowcount >= $mb_settings['mb_required_firstliners']) {
                $status = true;
            }
        }
        return $status;
    }

    public function getTeamBonusStatus($user_id, $date = null) {

        $status = false;
        $tb_settings = $this->getTeamBonusSettings();

        $this->db->select();
//      $this->db->where('sponsor_id', $user_id);
        $this->db->where('father_id', $user_id);
        $this->db->where('active !=', 'server');
        $this->db->where('product_id >=', $tb_settings['tb_first_line_minimum_pack']);
        if (!empty($date)) {
            $this->db->where('date_of_joining <=', $date);
        }
        $query = $this->db->get('ft_individual');
        $rowcount = $query->num_rows();
        if ($rowcount >= $tb_settings['tb_required_firstliners']) {
            $status = true;
        }

        return $status;
    }

}
