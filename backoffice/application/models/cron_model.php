<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require_once 'Inf_Model.php';

/**
 * @property  leg_amount_model $leg_amount_model
 */
class cron_model extends Inf_Model {

    private $mailObj;

    public function __construct() {
        $this->load->model('profile_class_model');
        $this->load->model('validation_model');
        $this->load->model('page_model');
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function sentMailAutomatic() {
        $base_url = base_url();
        $visitor_details = $this->validation_model->getVisitordetails();

        foreach ($visitor_details as $row) {
            $id = $row['id'];
            $today = date('d-m-Y');
            $date1 = date_create($today);
            $date2 = date_create($row['date']);
            $diff = date_diff($date1, $date2);
            $date_diff = $diff->format("%a ");

            if ($date_diff > 0) {

                $mail_details = $this->getAutoMailSettings($date_diff);

                if ($mail_details) {
                    $sponser_phone_num = $this->validation_model->getUserPhoneNumber($row['user_id']);
                    $username = $this->validation_model->IdToUserName($row['user_id']);
                    $sponser_name = $this->validation_model->getFullName($row['user_id']);
                    $sponser_email = $this->validation_model->getUserEmailId($row['user_id']);




                    $subject = $mail_details['subject'];
                    $mail_content = $mail_details['mail_content'];
                    $mail_content = str_replace("{visitor_name}", $row['name'], $mail_content);
                    $mail_content = str_replace("{member_name}", $sponser_name, $mail_content);
                    $mail_content = str_replace("{Telephone_No}", $sponser_phone_num, $mail_content);
                    $mail_content = str_replace("{member_email}", $sponser_email, $mail_content);
                    $result = $this->sendAutoMail($mail_content, $row['email'], $subject, $sponser_name, $sponser_email);

                    if (!$result) {
                        return FALSE;
                    }
                }
            }
        }
        return true;
    }

    public function sendAutoMail($mailBodyDetails, $email, $subject, $sponser_name, $sponser_email) {

        $email_details = array();
        $email_details = $this->validation_model->getCompanyEmail();

        $this->mailObj->From = $email_details["from_email"];
        $this->mailObj->FromName = $email_details["from_name"];
        $this->mailObj->Subject = $subject;
        $this->mailObj->IsHTML(true);

        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);

        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;
        return $res;
    }

    public function getAutoMailSettings($mail_date) {
        $mail_arr = array();
        $this->db->select('*')
                ->from('autoresponder_setting')
                ->where('date_to_send', $mail_date);
        $qry = $this->db->get();

        foreach ($qry->result() as $row) {
            $mail_arr['subject'] = $row->subject;
            $mail_arr['mail_content'] = $row->content;
        }
        return $mail_arr;
    }

    public function insertCronHistory($cron_type) {
        $data_arr = array('cron' => $cron_type,
            'date' => date('Y-m-d H:i:s'),
            'status' => 'started');
        $this->db->insert('cron_history', $data_arr);
        return $this->db->insert_id();
    }

    public function haveCron($name) {
        $this->db->select('COUNT(id) as num');
        $this->db->where('cron', $name);
        $this->db->where('status', 'started');
        return $this->db->get('cron_history')->row()->num;
    }

    public function haveCronHour($name) {
        return (bool) $this->db
            ->where('cron', $name)
            ->where('HOUR( `date` ) = ', 'HOUR( NOW( ) )', false)
            ->where('cast(`date` as DATE) = ', 'cast(NOW() as DATE)', false)
            ->count_all_results('cron_history');
    }

    public function haveCronInDay($name) {
        return (bool) $this->db
            ->where('cron', $name)
            ->where('cast(`date` as DATE) = ', 'cast(NOW() as DATE)', false)
            ->count_all_results('cron_history');
    }

    public function haveStartedCronInDay($name) {
        return (bool) $this->db
            ->where('cron', $name)
            ->where('end_date')
            ->where('cast(`date` as DATE) = ', 'cast(NOW() as DATE)', false)
            ->count_all_results('cron_history');
    }
    
    public function prepareTables() {
        $this->db->set('product_id', 1);
        $this->db->update('ft_individual');
        $this->db->empty_table('commission_history');
        $this->db->empty_table('leg_amount');
    }
    
    public function updateRecalcCronHistory() {
        $this->db->set("status", 'finish');
        $this->db->set('end_date', date("Y-m-d H:i:s"));
        $this->db->where('cron', 'recalculate');
        $this->db->update('cron_history');
    }
    
    public function updateCronHistory($cron_id, $status) {
        $this->db->set("status", $status);
        $this->db->set('end_date', date("Y-m-d H:i:s"));
        $this->db->where('id', $cron_id);
        $this->db->update('cron_history');
        return true;
    }
    
    public function getUnfinishedCron($tag) {
        $this->db->select('id');
        $this->db->where('cron', $tag);
        $this->db->where('status', 'started');
        $this->db->where('DATE_ADD( DATE, INTERVAL 10 MINUTE) <', date("Y-m-d H:i:s"));
        return $this->db->get('cron_history')->result_array();
    }

//    public function getPurchaseHistory($type = '') {
//        $data = array();
//        $first_date = date('Y-m-d 00:00:00');
//        $second_date = date('Y-m-d 23:59:59');
//        if ($type != '') {
//            $this->db->where($type, 'no');
//        }
//
//        $this->db->where('date >=', $first_date);
//        $this->db->where('date <=', $second_date);
//        $qry = $this->db->get('order_history');
//
//        foreach ($qry->result_array() as $row) {
//            $data[] = $row;
//        }
//        return $data;
//    }


    public function getDirectBonusPercentage() {
        $direct_bonus = 0;
        $this->db->select('db_percentage');
        $this->db->limit(1);
        $qry = $this->db->get('configuration');
        $direct_bonus = $qry->row()->db_percentage;
        return $direct_bonus;
    }

    public function getTeamBonusPercentage($bv = 0) {
        $team_bonus = '';
        $tb_percentage = 0;
        if ($bv >= 10000000) {
            $team_bonus = 'tb_10000000';
        } elseif ($bv >= 5000000) {
            $team_bonus = 'tb_5000000';
        } elseif ($bv >= 1000000) {
            $team_bonus = 'tb_1000000';
        } elseif ($bv >= 500000) {
            $team_bonus = 'tb_500000';
        } elseif ($bv >= 250000) {
            $team_bonus = 'tb_250000';
        } elseif ($bv >= 100000) {
            $team_bonus = 'tb_100000';
        } elseif ($bv >= 50000) {
            $team_bonus = 'tb_50000';
        } elseif ($bv >= 25000) {
            $team_bonus = 'tb_25000';
        } elseif ($bv >= 10000) {
            $team_bonus = 'tb_10000';
        } elseif ($bv >= 5000) {
            $team_bonus = 'tb_5000';
        } elseif ($bv >= 1000) {
            $team_bonus = 'tb_1000';
        }

        if ($team_bonus) {
            $this->db->select("$team_bonus");
            $this->db->limit(1);
            $qry = $this->db->get('configuration');
            $tb_percentage = $qry->row()->$team_bonus;
        }

        return $tb_percentage;
    }

    public function distributeDirectBonus($user_id, $amount, $amount_type, $stage, $from = '', $date = null) {
        $res = "";

        $this->load->model('calculation_model');
        $res = $this->calculation_model->insertBonusInToLegAmount($user_id, $amount, $amount_type, $from, 0, 0, $stage, $date);

        return $res;
    }

//    public function distributeMatchingBonus($father_id, $amount, $from_user, $bonus_type,$stage) {
//        $res = "";
//        $this->load->model('calculation_model');
//        $res = $this->calculation_model->calculateLegCount($from_user, $father_id, $amount, $bonus_type,$stage);
//
//        return $res;
//    }

    public function distributeTeamBonus($user_id, $amount, $amount_type, $stage, $date = null) {
        $res = "";

        $this->load->model('calculation_model');
        $res = $this->calculation_model->insertTeamBonusInToLegAmount($user_id, $amount, $amount_type, '', 0, 0, $stage, $date);

        return $res;
    }

    public function distributeFastStartBonus($user_id, $amount, $amount_type, $stage) {
        $res = "";

        $this->load->model('calculation_model');
        $res = $this->calculation_model->insertFastStartBonusInToLegAmount($user_id, $amount, $amount_type, '', 0, 0, $stage);

        return $res;
    }

    public function distributeDiamondPoolBonus($user_id, $amount, $amount_type, $stage, $date = null) {
        $res = "";

        $this->load->model('calculation_model');
        $res = $this->calculation_model->insertDiamontPoolBonusInToLegAmount($user_id, $amount, $amount_type, '', 0, 0, $stage, $date);

        return $res;
    }

    public function tranBegin() {
        $this->begin();
    }

    public function tranCommit() {
        $this->commit();
    }

    public function tranRollback() {
        $this->rollBack();
    }

    public function downLinePosition($user_id) {
        $details = array();
        $this->db->select("left_sponsor, right_sponsor");
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $root = $this->db->get('ft_individual');
        $details = $root->result_array();
        return $details;
    }

//    public function userTeamBvUpdation() {
//      
//        $this->db->set('week_team_bv', "week_team_bv - aq_team_bv", false);
//        $this->db->set('first_line_weekly_bv', "first_line_weekly_bv - first_line_aq_bv", false);   
//        $res = $this->db->update('user_balance_amount');                
//        return true;
//    }


    function getDownlinesBv($left_sponsor, $right_sponsor) {

        $bv = 0;
        $this->db->select_sum('bv');
        $this->db->from('ft_individual AS ft');
        $this->db->join('user_balance_amount AS ub', 'ft.id = ub.user_id');
        $this->db->where("ub.bv >", 0);
        $this->db->where("ft.left_sponsor >", $left_sponsor);
        $this->db->where("ft.right_sponsor <", $right_sponsor);
        $this->db->where('ft.active !=', 'server');
        $query = $this->db->get();
        $bv = $query->row()->bv;
        return $bv;
    }

//    function getDownlines($user_id, $left_sponsor, $right_sponsor) {
//        $down_lines = array();
//
//        $this->db->select('ft.id');
//        $this->db->from('ft_individual AS ft');
//        $this->db->join('user_balance_amount AS ub', 'ft.id = ub.user_id');
//        $this->db->where("ub.bv >", 0);
//        $this->db->where("ft.left_sponsor >", $left_sponsor);
//        $this->db->where("ft.right_sponsor <", $right_sponsor);
//        $this->db->where('ft.active !=', 'server');
//        $res = $this->db->get();
//
//        foreach ($res->result_array() as $row) {
//            $down_lines[] = $row['id'];
//        }
//        return $down_lines;
//    }
//    function getDownlines($next_lines, $down_lines) {
//        $this->db->select('id');
//        $this->db->from('ft_individual');
//        $this->db->where('active', 'yes');
//        $this->db->where_in('father_id', $next_lines);
//        $query = $this->db->get();
//        $next_lines = array();
//        foreach ($query->result_array() as $row) {
//            array_push($next_lines, $row['id']);
//            array_push($down_lines, $row['id']);
//        }
//        if (empty($next_lines)) {
//            return $down_lines;
//        } else {
//            return $this->getDownlines($next_lines, $down_lines);
//        }
//    }

    function getUserList() {
        $data = array();
        $this->db->select('user_id,aq_team_bv,week_team_bv,first_line_aq_bv,first_line_weekly_bv');
        $this->db->from('user_balance_amount');
        //$this->db->limit(5000,0);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    function changeStatus($user_id, $stat) {
        $this->db->set('status', $stat);
        $this->db->where('user_id', $user_id);
        $data = $this->db->update('user_balance_amount');
        return $data;
    }

    function getAchiversList() {
        $data = array();
        $this->db->select('ub.user_id,ub.bv,ub.aq_team_bv,ub.week_team_bv,ub.first_line_weekly_bv,ft.career,ub.first_line_aq_bv');
        $this->db->from('user_balance_amount as ub');
        $this->db->join('ft_individual as ft', 'ft.id = ub.user_id');
        $this->db->where('ub.first_line_weekly_bv >', 0);
        $this->db->or_where('ub.week_team_bv >', 0);
        $this->db->order_by("ub.user_id", "desc");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }


    public function getLegAmountStage() {
        $status = 1;
        $this->db->select_max('stage');
        $query = $this->db->get('leg_amount');
        $rowcount = $query->num_rows();
        if ($rowcount) {
            $status = $query->row()->stage;
        }
        return $status;
    }

    public function getDPCommission() {

        $dep_per = 0;
        $this->db->select('dp_percentage');
        $this->db->limit(1);
        $query = $this->db->get('configuration');
        $dep_per = $query->row()->dp_percentage;
        return $dep_per;
    }

    public function getTeamBV($user_id) {

        $team_bv = 0;
        $this->db->select('aq_team_bv');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_balance_amount');
        $team_bv = $query->row()->aq_team_bv;
        return $team_bv;
    }

    public function getDiamondCommissionStatus($user_id, $team_bv, $first_line_career, $first_line_number) {

        $status = false;
        $user_team_bv = $this->getTeamBV($user_id);
        if ($user_team_bv >= $team_bv) {
            $this->db->select();
            $this->db->where('sponsor_id', $user_id);
            $this->db->where('career', $first_line_career);
            $query = $this->db->get('ft_individual');
            $rowcount = $query->num_rows();
            if ($rowcount >= $first_line_number) {
                $status = true;
            }
        }

        return $status;
    }

    public function addAllDownlineUsers() {
        $next_lines = array();
        $user_id = '55';
        $users = array();

        $this->db->select('id,father_id');
        $this->db->where('add_status', 0);
        $this->db->where('date_of_joining >=', '2016-04-30 15:21:38');
        $this->db->order_by("date_of_joining", "ASC");
        $query = $this->db->get('ft_individual');
        $h = 0;
        foreach ($query->result_array() as $ro) {
            $users[$h]['user_id'] = $ro['id'];
            $users[$h]['father_id'] = $ro['father_id'];
            $h++;
        }

        $cnt = count($users);
        for ($j = 0; $j < $cnt; $j++) {
            $user_id = $users[$j]['user_id'];
            $father_id = $users[$j]['father_id'];

            $this->db->select('left_father1,right_father1');
            $this->db->where('id', $father_id);
            $this->db->limit(1);
            $query2 = $this->db->get('ft_downline');
            $diff = 0;
            if ($query2->num_rows() > 0) {
                foreach ($query2->result_array() as $row1) {
                    $diff = $row1['right_father1'] - $row1['left_father1'];
                }
            }

            if ($diff > 1) {
                $position_user = $this->getRightMostChild($father_id);
                $this->usersInLevel($user_id, $position_user, $father_id);
            } else {
                $position_user = $father_id;
                $this->noUsersInLevel($user_id, $position_user, $father_id);
            }

            $this->db->set('add_status', 1);
            $this->db->where('id', $user_id);
            $result11 = $this->db->update('ft_individual');
        }
        return 1;
    }

    public function getRightMostChild($father_id) {

        $this->db->select('id');
        $this->db->where('father_id', $father_id);
        $this->db->order_by("right_father1", "DESC");
        $query2 = $this->db->get('ft_downline');
        return $query2->row()->id;
    }

    public function noUsersInLevel($user_id, $position_user, $father_id) {
        mysql_query("SELECT @myLeft := left_father1 FROM 55_ft_downline WHERE user_id = '$position_user'");
        mysql_query("UPDATE 55_ft_downline SET right_father1 = right_father1 + 2 WHERE right_father1 > @myLeft");
        mysql_query("UPDATE 55_ft_downline SET left_father1 = left_father1 + 2 WHERE left_father1 > @myLeft");
        mysql_query("INSERT INTO 55_ft_downline(user_id,father_id, left_father1, right_father1) VALUES('$user_id','$father_id', @myLeft + 1, @myLeft + 2)");
    }

    public function usersInLevel($user_id, $position_user, $father_id) {
        mysql_query("SELECT @myRight := right_father1 FROM 55_ft_downline WHERE user_id = '$position_user'");
        mysql_query("UPDATE 55_ft_downline SET right_father1 = right_father1 + 2 WHERE right_father1 > @myRight");
        mysql_query("UPDATE 55_ft_downline SET left_father1 = left_father1 + 2 WHERE left_father1 > @myRight");
        mysql_query("INSERT INTO 55_ft_downline(user_id,father_id, left_father1, right_father1) VALUES('$user_id','$father_id', @myRight + 1, @myRight + 2)");
    }

    public function moveAllDownlineUsers() {

        $this->db->select('user_id,left_father1,right_father1');
        $query = $this->db->get('ft_downline');
        foreach ($query->result_array() as $ro) {
            $this->db->set('left_sponsor', $ro['left_father1']);
            $this->db->set('right_sponsor', $ro['right_father1']);
            //$this->db->set('add_status',2);
            $this->db->where('id', $ro['user_id']);
            $this->db->update('ft_individual');
        }
        return 1;
    }

    public function pendingBVUpdate($stat = '', $with_old = false) {

        $this->db->select('id,user_id,bv');
        if ($stat != 'critical') {
            $this->db->limit(10);
        }
        if ($with_old) {
            $this->db->where('status !=', 1);
        } else {
            $this->db->where('status', 0);
        }
        $query = $this->db->get('order_history');
        /* create new status */
        $this->db->set('status', 2);
        if ($with_old) {
            $this->db->where('status !=', 1);
        } else {
            $this->db->where('status', 0);
        }
        if ($stat != 'critical') {
            $this->db->limit(10);
        }
        $this->db->update('order_history');
        
        if ($query->num_rows() > 0) {

            foreach ($query->result_array() as $row) {

                $father = $this->validation_model->getFatherId($row['user_id']);
                if ($father) {

                    $bv = $row['bv'];

                    $this->db->trans_start();

                    $this->db->set('first_line_aq_bv', "$bv + first_line_aq_bv", false);
                    $this->db->set('first_line_weekly_bv', "$bv + first_line_weekly_bv", false);
                    $this->db->where('user_id', $father);
                    $res = $this->db->update('user_balance_amount');

                    while ($father) {
                        $this->db->set('aq_team_bv', "$bv + aq_team_bv", false);
                        $this->db->set('week_team_bv', "$bv + week_team_bv", false);
                        $this->db->where('user_id', $father);
                        $res2 = $this->db->update('user_balance_amount');

                        $father = $this->validation_model->getFatherId($father);
                    }

                    $this->db->set('status', 1);
                    $this->db->where('id', $row['id']);
                    $res3 = $this->db->update('order_history');
                    
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_complete();
                    }
                }
            }
        }
        return 1;
    }

    public function updatDownlineSpend($user_id, $amount) {

        $father = $this->validation_model->getFatherId($user_id);
        if ($father) {
            while ($father) {
                $this->db->set('downline_spend', "$amount + downline_spend", false);
                $this->db->where('user_id', $father);
                $res2 = $this->db->update('user_balance_amount');
                $father = $this->validation_model->getFatherId($father);
            }
        }
        return 1;
    }

    function resetWeekBv($user_id) {
        $this->db->set('week_team_bv', 0);
        $this->db->set('first_line_weekly_bv', 0);
        $this->db->set('downline_spend', 0);
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('user_balance_amount');
//        echo $this->db->last_query();die();
        return $res;
    }

    function resetWeekFirstLineBv($user_id) {

        return $this->db
            ->set('first_line_weekly_bv', 0)
            ->where('user_id', $user_id)
            ->update('user_balance_amount');
    }

    function resetWeekTeamBv($user_id) {

        return $this->db
            ->set('week_team_bv', 0)
            ->where('user_id', $user_id)
            ->update('user_balance_amount');
    }

    function getDownlineSpendAmount($user_id) {
        $downline_spend = 0;
        $this->db->select('downline_spend');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('user_balance_amount');
        if ($query->num_rows() > 0) {
            $downline_spend = round($query->row()->downline_spend, 2);
        }
        return $downline_spend;
    }

    function pendingDistributStatus() {
        $status = false;
        $this->db->where('status', 0);
        $query = $this->db->get('order_history');
        if ($query->num_rows() > 0) {
            $status = true;
        }
        return $status;
    }

    function insertCommissionHistory($user_id, $first_line_weekly_bv, $week_team_bv, $aq_team_bv, $downline_spend = 0, $date = null) {
        $this->db->set('user_id', $user_id);
        $this->db->set('aq_team_bv', $aq_team_bv);
        $this->db->set('week_team_bv', $week_team_bv);
        $this->db->set('first_line_weekly_bv', $first_line_weekly_bv);
        $this->db->set('downline_spend', $downline_spend);
        $this->db->set('date', empty($date) ? date("Y-m-d H:i:s") : $date);
        $status = $this->db->insert('commission_history');
        return $status;
    }

    function bonusDaycalculationStatus() {
        $status = false;
        $date = date('Y-m-d');
        $this->db->where('cron', 'bonus_calculation');
        $this->db->like('date', $date);
        $query = $this->db->get('cron_history');
        return (bool)$query->num_rows();
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

    public function getTeamBonusStatus($user_id, $date = null) {

        $status = false;
        $tb_settings = $this->getTeamBonusSettings();

        $this->db->select();
        $this->db->where('father_id', $user_id);
        $this->db->where('active !=', 'server');
//        $this->db->where('sponsor_id', $user_id);
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

    public function getDownlineAmount($user_id) {//new_code
        $amount1 = 0;
        $this->db->select('ft.id,ub.aq_team_bv,ub.bv,ub.week_team_bv');
        $this->db->from('ft_individual AS ft');
        $this->db->join('user_balance_amount AS ub', 'ft.id = ub.user_id');
        $this->db->where("ft.father_id", $user_id);
        $this->db->where('ft.active !=', 'server');
        $this->db->where('ub.week_team_bv >', 0);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {


            foreach ($query->result_array() as $row) {
                $status = false;
                $status = $this->getTeamBonusStatus($row['id']);
                if ($status) {
                    $team_bonus = $this->getTeamBonusPercentage($row['aq_team_bv'] + $row['bv']);
                    $amount1 += ($row['week_team_bv'] * $team_bonus) / 100;
//                  echo $row['id'].'-----'.$team_bonus.'-----'.$row['week_team_bv'].'------'.(($row['week_team_bv'] * $team_bonus) / 100).'<br>';
                }
            }
        }
        return $amount1;
    }

    public function userbalence_absent() {
        $status = array();
        $this->db->select('id');
        $this->db->where('active !=', 'server');
//        $this->db->limit(10);
        $query = $this->db->get('ft_individual');
        foreach ($query->result_array() as $row) {
            $rowcount = 0;
            $this->db->select('user_id');
            $this->db->where('user_id', $row['id']);
            $this->db->limit(1);
            $query2 = $this->db->get('user_balance_amount');
            $rowcount = $query2->num_rows();

//            echo '------'.$this->db->last_query();
            if ($rowcount > 0) {
//                array_push($status, $row['user_id']);
            } else {
                array_push($status, $row['id']);
            }
        }
        print_r($status);
        die();
        return $status;
    }

    function bonus_distrb() {
        $data = array();
        $this->db->select('ub.user_id,ub.aq_team_bv');
        $this->db->from('user_balance_amount as ub');
        $this->db->join('ft_individual as ft', 'ft.id = ub.user_id');
        $this->db->where("ub.aq_team_bv >=", 1000);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $this->db->where('father_id', $row['user_id']);
            $this->db->where('active !=', 'server');
            $query2 = $this->db->get();
            $rowcount = $query2->num_rows();
            if ($rowcount >= 2) {
                $this->db->set('career',8);
                $this->db->where('user_id', $row['user_id']);
                $this->db->limit(1);
                $this->db->update('ft_individual');
            }
        }
        return $data;
    }
    
    public function DiamondPoolStarted($day = null)
    {
        $date = new DateTime(is_null($day) ? 'now' : $day);
        if (intval($date->format('m')) > 6) {
            $end = $date->format('Y-12-01 23:59:59');
            $start = $date->format('Y-07-01 00:00:01');
        } else {
            $end = $date->format('Y-06-01 23:59:59');
            $start = $date->format('Y-01-01 00:00:01');
        }
        
        $this->db->select('id');
        $this->db->where('cron', 'diamond_pool');
        $this->db->where('date BETWEEN', "{$this->db->escape($start)} AND {$this->db->escape($end)}", false);
        try {
            $row = $this->db->get('cron_history')->row();
            return $row ? intval($row->id) : false;
        } catch (Exception $e) {
            //this can simply mean we have no cron return false
            return false;
        }
    }
    
}
