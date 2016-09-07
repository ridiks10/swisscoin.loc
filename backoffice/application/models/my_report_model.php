<?php

class my_report_model extends inf_model {

    public $referals;
    public $obj_cal;

    public function __construct() {
        parent::__construct();
        $this->load->model('select_report_class_model');
        $this->load->model('page_model');
        $this->referals = array();
        $this->load->model('validation_model');        
    }

    public function getCommissionsDates($user_id) {
        $date_arr = array(0 => 'all');
        $this->db->select("DATE(`date_of_submission`) as date_of_submission")->where('user_id', $user_id)->group_by("DATE(`date_of_submission`)")->from('leg_amount');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            array_push($date_arr, $row->date_of_submission);
        }
        return $date_arr;
    }

    public function getMycommissions($user_id, $date) {
        $date_arr = array();
        $return_arr = array();
        if ($date == 'all') {
            $this->db->select("DATE(`date_of_submission`) as date_of_submission")->where('user_id', $user_id)->group_by("DATE(`date_of_submission`)")->from('leg_amount');
            $res = $this->db->get();
            foreach ($res->result() as $row) {
                array_push($date_arr, $row->date_of_submission);
            }
        } else {
            array_push($date_arr, $date);
        }

        if (count($date_arr) > 0) {
            $i = 0;
            foreach ($date_arr as $date) {
                $return_arr[$i]['date'] = $date;
                $this->db->select('amount_type');
                $this->db->select_sum('amount_payable')->where('user_id', $user_id);
                $this->db->where("DATE(`date_of_submission`)", $date);
                $this->db->group_by('amount_type');
                $res = $this->db->get("leg_amount");
                foreach ($res->result() as $row) {
                    $return_arr[$i][$row->amount_type] = $row->amount_payable;
                }
                $i++;
            }
        }
        return $return_arr;
    }

    public function getAllUnilevel($id) {
        $arr = $this->getDownlineUsers($id, 'left_sponsor', 'right_sponsor', 'unilevel');
        return $arr;
    }

    public function getDownlineDetailsBinary($id) {
        $arr = $this->getDownlineUsers($id, 'left_father', 'right_father');
        return $arr;
    }

    public function findUserlevel($id, $logged_user, $level = 1, $plan) {

        $table = "ft_individual";
        if ($plan == 'unilevel') {

            $this->db->select('sponsor_id');
            $this->db->where('id', $id);
            $this->db->limit(1);
            $res = $this->db->get($table);
            foreach ($res->result() as $row) {

                if ($logged_user == $row->sponsor_id) {

                    return $level;
                } else {
                    $ret_level = $this->findUserlevel($row->sponsor_id, $logged_user, $level + 1, $plan);

                    return $ret_level;
                }
            }
        } else {
            $this->db->select('father_id');
            $this->db->where('id', $id);
            $this->db->limit(1);
            $res = $this->db->get($table);
            foreach ($res->result() as $row) {

                if ($logged_user == $row->father_id) {

                    return $level;
                } else {
                    $ret_level = $this->findUserlevel($row->father_id, $logged_user, $level + 1, $plan);

                    return $ret_level;
                }
            }
        }
    }

    public function getDownlineUsers($user_id, $left_field, $right_field, $plan = 'binary') {

        $this->load->model('country_state_model');
        $this->db->select("$left_field, $right_field");
        $this->db->where('id', $user_id);
        $root = $this->db->get('ft_individual');
        $root = $root->result_array();
        $left = $root[0]["$left_field"];
        $right = $root[0]["$right_field"];

        $this->db->select('ft.id,ft.user_name,ft.date_of_joining,ud.user_detail_name,ud.user_detail_second_name,ud.user_detail_email,ud.user_detail_town,ud.user_detail_country,ud.user_detail_state');
        $this->db->from('ft_individual AS ft');
        $this->db->join('user_details AS ud', 'ft.id = ud.user_detail_refid');
        $this->db->where("ft.$left_field >", $left);
        $this->db->where("ft.$right_field <", $right);
        $this->db->where('active !=', 'server');
        $res = $this->db->get();
       // die($this->db->last_query());
        $i = 0;
        $referrals = array();
        foreach ($res->result_array() as $row) {
            $referrals[$i]['id'] = $row['id'];
            $referrals[$i]['date_of_joining'] = $row['date_of_joining'];
            $referrals[$i]['name'] = $row['user_detail_name'];
            $referrals[$i]['second_name'] = $row['user_detail_second_name'];
            $referrals[$i]['username'] = $row['user_name'];
            $referrals[$i]['email'] = $row['user_detail_email'];
            if ($row['user_detail_state'] == "") {
                $referrals[$i]['state'] = "NA";
            } else {
                $referrals[$i]['state'] = $this->country_state_model->getStateNameFromId($row['user_detail_state']);
            }
            if ($row['user_detail_town'] == "0") {
                $referrals[$i]['city'] = "NA";
            } else {
                $referrals[$i]['city'] = $row['user_detail_town'];
            }
            $referrals[$i]['country'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $referrals[$i]['level'] = $level = $this->findUserlevel($row['id'], $user_id, 1, $plan);
            $i++;
        }
        if (count($referrals) > 0) {
            foreach ($referrals as $key => $row) {
                $arr[$key] = $row['level'];
            }
            array_multisort($arr, SORT_ASC, $referrals);
        }
        return $referrals;
    }

    public function createQuery($user_id_arr, $plan) {
        $table = $this->table_prefix . "ft_individual";
        if ($plan == 'unilevel') {
            $arr_len = count($user_id_arr);
            for ($i = 0; $i < $arr_len; $i++) {
                $user_id = $user_id_arr[$i];
                if ($i == 0) {
                    $where_qr = "sponsor_id = '$user_id'";
                } else {
                    $where_qr .= " OR sponsor_id = '$user_id'";
                }
            }
        } else {
            $arr_len = count($user_id_arr);
            for ($i = 0; $i < $arr_len; $i++) {
                $user_id = $user_id_arr[$i];
                if ($i == 0) {
                    $where_qr = "father_id = '$user_id'";
                } else {
                    $where_qr .= " OR father_id = '$user_id'";
                }
            }
        }
        $user_details = $this->table_prefix . "user_details";
        $qr = "Select ft.id,ft.user_name,ft.date_of_joining,user.user_detail_name,user.user_detail_city,user.user_detail_country from  $table as ft INNER JOIN  `$user_details` AS user ON user.user_detail_refid=ft.id  where ($where_qr) and active NOT LIKE 'server'";


        return $qr;
    }

    public function getUserProductPurchase($user_id, $start_date, $end_date) {
        $orders = array();
        $this->db->select('*');
        $this->db->where("purchase_date BETWEEN '$start_date' AND '$end_date'");
        if ($user_id)
            $this->db->where('user_id', $user_id);
        $this->db->from('user_product_purchase');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $row['user_name'] = $this->validation_model->IdToUserName($row['user_id']);
            if ($row['payment_method'] == "ewallet") {
                $row['ewallet_user'] = $this->getEwalletUser($row['user_id'], $row['purchase_date'], $row['total_amount']);
                $row['ewallet_user_name'] = $this->validation_model->IdToUserName($row['ewallet_user']);
            } else
                $row['ewallet_user_name'] = 'NA';
            $orders[$i] = $row;
            $i++;
        }
        return $orders;
    }

    public function getEwalletUser($used_user, $purchase_date, $amount) {
        
        
        $current_date = strtotime($purchase_date);
        $future_date = $current_date + (60 * 0.05);
        $past_date = $current_date - (60 * 0.05);
        $date_high = date("Y-m-d H:i:s", $future_date);
        $date_low = date("Y-m-d H:i:s", $past_date);
        
        $this->load->model('settings_model');
        $obj_arr = $this->settings_model->getSettings();
        $amount = $amount + $obj_arr['enrollment_notes_payment'];

        $user_id = "";
        $this->db->select('user_id');
        $this->db->where('used_user_id', $used_user);
        $this->db->where('used_amount', $amount);
        $this->db->where("date BETWEEN '$date_low' AND '$date_high'");
        $this->db->where('used_for', 'ewallet_purchase');
        $query = $this->db->get('ewallet_payment_details');
        foreach ($query->result() as $row) {
            $user_id = $row->user_id;
        }
        return $user_id;
    }

    public function getCustomerProductPurchase($email_id, $start_date, $end_date) {

        $orders = array();
        $this->db->select('*');
        $this->db->where("purchase_date BETWEEN '$start_date' AND '$end_date'");
        $this->db->where('final_customer_email', $email_id);
        $this->db->where('user_type', 'finalcustomer');
        $this->db->from('user_product_purchase');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $orders[$i] = $row;
            $i++;
        }

        return $orders;
    }

    public function getCustomerEmail($user_id) {
        $orders = '';
        $this->db->select('finalcustomer_email');

        $this->db->where('id', $user_id);
        $this->db->from('finalcustomer_details');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $orders = $row->finalcustomer_email;
        }
        return $orders;
    }

    public function finalCustomersDetails($user_id, $number = '') {
        $details = array();
        $this->db->select('*');
        $this->db->from('finalcustomer_details');
        $this->db->where('sponsor_id', $user_id);
        if ($number)
            $this->db->where('id', $number);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details["detail$i"]["customer_number"] = $row['id'];
            $details["detail$i"]["customer_name"] = $row['finalcustomer_name'];
            $details["detail$i"]["customer_email"] = $row['finalcustomer_email'];
            $details["detail$i"]["customer_country"] = $row['country'];
            $details["detail$i"]["customer_city"] = $row['city'];
            $details["detail$i"]["customer_date"] = date("Y-m-d", strtotime($row['date']));
            $i++;
        }
        return $details;
    }

    public function finalCustomersNumber($user_id) {
        $orders = array();
        $this->db->select('id');
        $this->db->from('finalcustomer_details');
        $this->db->where('sponsor_id', $user_id);
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $orders[$i] = $row;
            $i++;
        }
        $products = "<option value='all' selected='selected'>All</option>";
        for ($i = 0; $i < count($orders); $i++) {
            $id = $orders["$i"]["id"];
            $product_name = $orders["$i"]["id"];
            $products.="<option value='$id' >$product_name</option>";
        }
        return $products;
    }

    public function my_bonus() {
        $details = array();
        $i = 0;
        $table = $this->table_prefix . "leg_amount";
        $table1 = $this->table_prefix . "user_details";
        $table3 = $this->table_prefix . "ewallet_payment_details";
        $table4 = $this->table_prefix . "fund_transfer_details";
        $qr = "SELECT user_id,sum(amount_payable) FROM  $table WHERE amount_type LIKE '%unilevel%' group by user_id";
        $res = $this->selectData($qr, "Error On Selecting 157894512345");
        while ($row = mysql_fetch_array($res)) {
            $details["detail$i"]["user"] = $this->validation_model->IdToUserName($row['user_id']);

            $user_id = $row['user_id'];
            $details["detail$i"]["user_balance"] = $this->user_balance($user_id);
            $qr1 = "SELECT * FROM  $table1 WHERE user_detail_refid = $user_id";
            $res1 = $this->selectData($qr1, "Error On Selecting 157894512345");
            while ($row1 = mysql_fetch_array($res1)) {
                $details["detail$i"]["full_name"] = $row1['user_detail_name'];
                $details["detail$i"]["email"] = $row1['user_detail_email'];
            }
            $qr2 = "SELECT used_user_id,used_amount,used_for FROM $table3 WHERE date LIKE '2014-10-01%' AND user_id=$user_id";
            $res2 = $this->selectData($qr2, "Error On Selecting 157894512345");
            $used_user = '';
            $used_for = '';
            $used_amount = '';
            while ($row2 = mysql_fetch_array($res2)) {
                $used_for = $used_for . "<br/>" . $row2['used_for'];
                $details["detail$i"]["used_for"] = $used_for;
                $used_user = $used_user . "<br/>" . $this->validation_model->IdToUserName($row2['used_user_id']);

                $details["detail$i"]["used_user"] = $used_user;
                $used_amount = $used_amount . "<br/>" . $row2['used_amount'];
                $details["detail$i"]["used_amounts"] = $used_amount;
            }

            $qr3 = "SELECT from_user_id,amount,transfer_fee FROM $table4 WHERE date LIKE '2014-10-01%' AND to_user_id=$user_id and  amount_type='user_debit'";
            $res3 = $this->selectData($qr3, "Error On Selecting 157894512345");
            $fund_user = '';
            $amount = '';
            while ($row3 = mysql_fetch_array($res3)) {
                $amount = $amount . "<br/>" . ($row3['amount'] + $row3['transfer_fee']);
                $details["detail$i"]["fund_amount"] = $amount;
                $fund_user = $fund_user . "<br/>" . $this->validation_model->IdToUserName($row3['from_user_id']);
                $details["detail$i"]["fund_user"] = $fund_user;
            }


            $details["detail$i"]['sum'] = $row['sum(amount_payable)'];
            $i++;
        }
        return $details;
    }

    public function user_balance($user_id) {
        $balance = '';
        $this->db->select('balance_amount');

        $this->db->where('user_id', $user_id);
        $this->db->from('user_balance_amount');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result() as $row) {
            $balance = $row->balance_amount;
        }
        return $balance;
    }
   
}

?>