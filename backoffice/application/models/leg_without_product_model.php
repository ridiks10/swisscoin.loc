<?php

Class leg_model extends inf_model {

    var $user_leg_det = Array();
    var $total_user_leg_det = Array();
    public $user_arr = null;
    public $table_prefix = "";

    public function setTablePrefix($table_prefix) {
        $this->table_prefix = $table_prefix;
    }

    public function __construct() {
        $this->load->model('validation_model');

        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
    }

    public function getTotalLegCount($id) {

        $this->user_arr = null;
        $left_leg_count = 0;

        $arr[] = $id;
        $arr = $this->getUserArray($arr);

        $left_leg_count = count($this->user_arr);

        return $left_leg_count;
    }

    public function getLeftLegCount($id) {
        $this->user_arr = null;
        $left_leg_count = 0;
        $id_left = $this->validation_model->getLeftNodeId($id);
        if ($id_left > 0) {
            $this->user_arr[] = $id_left;
            $arr[] = $id_left;
            $arr = $this->getUserArray($arr);
            $left_leg_count = count($this->user_arr);
        }

        return $left_leg_count;
    }

    public function getRightLegCount($id) {
        $this->user_arr = null;
        $right_leg_count = 0;
        $id_right = $this->validation_model->geRighttNodeId($id);
        if ($id_right > 0) {
            $this->user_arr[] = $id_right;
            $arr[] = $id_right;
            $arr = $this->getUserArray($arr);

            $right_leg_count = count($this->user_arr);
        }
        return $right_leg_count;
    }

    public function getUserArray($arr) {

        $user_id_temp = null;
        $user_id = $arr;
        $select_users = "";
        $count_id = count($user_id);
        $flag = 0;
        $where = "";

        if ($count_id > 0) {

            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $flag = 1;
                    $where .= " OR  father_id='$user_id[$i]'";
                } else {
                    $where = "active LIKE 'yes%' AND (father_id='$user_id[$i]'";
                }
            }
            $where .=")";
            $this->db->select("id");
            $this->db->from("ft_individual");
            $this->db->where($where);
            $query = $this->db->get();

            foreach ($query->result() as $row1) {
                $this->user_arr[] = $row1->id;
                $user_id[] = $row1->id;
                $user_id_temp[] = $row1->id;
            }
        }

        $count = count($user_id_temp);
        if ($count > 0) {
            if ($count >= 5000) {
                $input_array = $user_id_temp;

                $split_arr = array_chunk($input_array, intval($count / 4));

                for ($i = 0; $i < count($split_arr); $i++) {

                    $this->getUserArray($split_arr[$i]);
                }
            } else {

                $this->getUserArray($user_id_temp);
            }
        }
        return $user_id_temp;
    }

    public function getCountUserLegDetails($user_id, $user_type) {

        $count_leg_details = 0;
        if ($user_type == 'admin') {

            $this->db->select("id,user_name");
            $this->db->from("ft_individual");
            $this->db->where("active", "yes");
            $count_leg_details = $this->db->count_all_results();
        } else {

            $this->db->select("id,user_name");
            $this->db->from("ft_individual");
            $this->db->where("active", "yes");
            $this->db->where("id", "$user_id");

            $count_leg_details = $this->db->count_all_results();
        }
        return $count_leg_details;
    }

    public function getUserLegDetails($user_id, $page, $limit, $user_type) {

        $this->db->select('*');
        if ($user_type != 'admin')
            $this->db->where('id', $user_id);
        $this->db->limit($limit, $page);
        $query = $this->db->get('leg_details');
        $j = 0;
        foreach ($query->result_array() as $row) {
            $user_status = $this->getUserStatus($row['id']);
            if ($user_status != 'server') {
                $user_leg_det["detail$j"]["user"] = $this->validation_model->IdToUserName($row['id']);
                $user_leg_det["detail$j"]["detail"] = $this->validation_model->getUserFullName($row['id']);
                $user_leg_det["detail$j"]["left"] = $row['total_left_count'];
                $user_leg_det["detail$j"]["right"] = $row['total_right_count'];
                $user_leg_det["detail$j"]["left_carry"] = $row['total_left_carry'];
                $user_leg_det["detail$j"]["right_carry"] = $row['total_right_carry'];
                $total_leg_arr = $this->getTotalLegTotalAmount($row['id']);
                $tot_leg = $total_leg_arr['total_leg'];
                $tot_amount = $total_leg_arr['total_amount'];
                $user_leg_det["detail$j"]["total_leg"] = $tot_leg;
                $user_leg_det["detail$j"]["total_amount"] = round($tot_amount, 2);
                $j = $j + 1;
            }
        }
        return $user_leg_det;
    }

//////////by vaisakh on 28-02-13
    public function getUserDetailName($user_id) {
        $this->db->select('user_detail_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $user_detail_name = $row->user_detail_name;
        }
        return $user_detail_name;
    }

/////////code ends       

    /**
     * @since 1.21 There is no total_leg
     */
    public function getTotalLegTotalAmount($user_id) {
        $this->db->select_sum("total_amount");
        $this->db->from("leg_amount");
        $this->db->where("user_id", "$user_id");
        $this->db->where("amount_type", "leg");

        $query = $this->db->get();

        // echo "<br/>getTotalLegTotalAmount" . $this->db->last_query();

        foreach ($query->result() as $row) {
            $tot_arr['total_leg'] = '0';
            if ($row->total_amount == "") {
                $tot_arr['total_amount'] = '0';
            } else
                $tot_arr['total_amount'] = $row->total_amount;
        }

        return $tot_arr;
    }

    public function getUserStatus($user_id) {
        $status = "0";

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            return $row->active;
        }
    }

    public function getTotalLegUserDetail($user_det) {
        $left_leg_tot = 0;
        $right_leg_tot = 0;
        $total_leg_tot = 0;
        $total_amount_tot = 0;

        for ($i = 0; $i < count($user_det); $i++) {
            $user_det["detail$i"]["user"];
            $left = $user_det["detail$i"]["left"];
            $right = $user_det["detail$i"]["right"];
            $left_carry = $user_det["detail$i"]["left_carry"];
            $right_carry = $user_det["detail$i"]["right_carry"];
            $tot_leg = $user_det["detail$i"]["total_leg"];
            $flush_out_pair = $user_det["detail$i"]["flush_out_pair"];
            $tot_amt = $user_det["detail$i"]["total_amount"];
            $left_leg_tot+=$left;
            $right_leg_tot+=$right;
            $left_carry_tot += $left_carry;
            $right_carry_tot += $right_carry;
            $total_leg_tot+=$tot_leg;
            $total_amount_tot+=$tot_amt;
            $flush_out_pair_tot += $flush_out_pair;
        }

        $this->total_user_leg_det["right"] = $right_leg_tot;
        $this->total_user_leg_det["left"] = $left_leg_tot;
        $this->total_user_leg_det["left_carry"] = $left_carry_tot;
        $this->total_user_leg_det["right_carry"] = $right_carry_tot;
        $this->total_user_leg_det["total_leg"] = $total_leg_tot;
        $this->total_user_leg_det["total_amount"] = $total_amount_tot;
        $this->total_user_leg_det["right_carry"] = $right_carry_tot;
        $this->total_user_leg_det["total_leg"] = $flush_out_pair_tot;

        return $this->total_leg_detail;
    }

    public function getLegCountCarry($id) {

        /////////////////////  CODE EDITED BY JIJI  //////////////////////////
        //$select = "SELECT * FROM $ft_individual WHERE id='$id'";

        $query = $this->db->get_where("ft_individual", array('id' => $id));

        // echo "<br/>getLegCountCarry" . $this->db->last_query();

        foreach ($query->result() as $row) {

            $left_carry = $row->total_left_carry;
            $right_carry = $row->total_right_carry;

            if ($left_carry == "")
                $left_carry = 0;
            if ($right_carry == "")
                $right_carry = 0;


            $arr["left_carry"] = $left_carry;
            $arr["right_carry"] = $right_carry;
        }
        return $arr;
    }

    public function getRightLegCountOld($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $selectleft1 = "select * from  $ft_individual where father_id = " . $id . " and active = 'yes' and position='R'";
//echo $selectleft1;
        $selectleftres1 = $this->selectData($selectleft1);

        $row1 = mysql_fetch_array($selectleftres1);
        $cnt2 = mysql_num_rows($selectleftres1);
        if ($cnt2 > 0) {


            $lid = $row1['id'];


            $total_left_temp = $this->calculateEach($lid, 0);
            //$total_right = $total_left_temp - $total_right_previos + 1;
            //$total_right_previos = $total_left_temp;
            $total_right = $total_left_temp;
            if ($this->table_prefix == "") {
                $this->table_prefix = $this->session->userdata('inf_table_prefix');
            }
            $ft_individual = $this->table_prefix . "ft_individual";
            $selectleft1 = "select * from $ft_individual where father_id = " . $id . " and active = 'yes' and position='R'";


            $selectleftres1 = $this->selectData($selectleft1);
            $row1 = mysql_fetch_array($selectleftres1);
            $cnt3 = mysql_num_rows($selectleftres1);
            if ($cnt3 > 0)
                $total_right = $total_right + 1;


            return $total_right;
        }
    }

    public function getUserLegPage($user_id) {

        if ($_SESSION['user_type'] == 'admin')
            $sql = "";
        else
            $sql = " where am.user_id=" . $_SESSION['user_id'];
        $ft_individual = $this->table_prefix . "ft_individual";
        $login_user = $this->table_prefix . "login_user";
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $select = "SELECT id
					FROM $ft_individual 
					WHERE active='yes'";

        $result = $this->selectData($select);
        $cnt2 = mysql_num_rows($result);
        return $cnt2;
    }

    public function getUserPointCount($id) {

        /////////////////  CODE EDITED BY JIJI  ////////////////

        $product_value_child1 = 0;
        $product_value_child2 = 0;

        // $select = "SELECT * FROM  $ft_individual WHERE father_id=$id and active='yes' ORDER BY position";
        $user_id = null;
        $this->db->select("*");
        $this->db->from("ft_individual");
        $this->db->where("father_id", $id);
        $this->db->where("active", "yes");
        $this->db->order_by("position");
        $query = $this->db->get();
//echo $this->db->last_query();
        foreach ($query->result() as $row) {

            if ($row->position == "L")
                $user_id['0'] = $row->id;
            else if ($row->position == "R")
                $user_id['1'] = $row->id;
            /* else {
              $user_id['0'] = 0;
              $user_id['1'] = 0;
              } */
        }

        if (count($user_id) > 1) {
            if ($user_id['0'] > 0) {
                $product_value_child1 = $this->getTotalLegCount($user_id["0"]) + 1;
                //echo "<br> 1111 ". " && $user_id[0] ".$product_value_child1."<br>";
            }
            if ($user_id['1'] > 0) {
                $product_value_child2 = $this->getTotalLegCount($user_id["1"]) + 1;
            }
        }
        $total_arr["left"] = $product_value_child1;
        $total_arr["right"] = $product_value_child2;

        return $total_arr;
    }

    public function calculate_each_leg_count($id, $cnt) {
        global $count;
        $count = $cnt;
        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $selectleft1 = "select * from $ft_individual where father_id = $id";
        $selectleftres1 = mysql_query($selectleft1) or die("Error on selecting blocked member 11");

        while ($row1 = mysql_fetch_array($selectleftres1)) {
            $active = $row1['active'];
            if ($active == 'yes') {
                $count+=1;
            }

            $this->calculate_each_leg_count($row1['id'], $count);
        }

        return $count;
    }

    public function getLevelUsers($user_id, $level) {
        $arr[] = $user_id;
        $this->each_level_leg_count = null;
        $this->last_level_user = null;
        //  echo $no_of_level;
        $liimit_incriment = 0;
        $next = 1;


        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $table_prefix = $this->table_prefix;
        $this->last_level_user = $this->getOneLevelUsers($arr, $liimit_incriment, $level, $next, $table_prefix);

        return $this->last_level_user;
    }

    public function getOneLevelUsers($arr, $liimit_incriment, $no_of_level, $next, $table_prefix) {
        $liimit_incriment = $liimit_incriment + 1;
        $user_id_temp = null;
        $user_id = $arr;
        $select_users = "";
        $count_id = count($user_id);
        $flag = 0;

        if (count($user_id) > 0) {

            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $flag = 1;
                    $sql .= " OR  father_id='$user_id[$i]'";
                } else {

                    $ft_individual = $table_prefix . "ft_individual";
                    $sql .= "SELECT id FROM $ft_individual WHERE  (active='yes') AND ( father_id='$user_id[$i]'";
                }
            }
            $as = "";
            if ($i > 0) {
                $as = " )";
                $select_users.=$sql . " )";
            } else {
                $select_users.=$sql;
            }
            // echo "<br>$flag ".$select_users;
            $res1 = $this->selectData($select_users);
            $current_level_leg_count = mysql_num_rows($res1);
            $old_count = $this->each_level_leg_count["level$next"];
            // echo  "######".$old_count;
            $this->each_level_leg_count["level$next"] = $current_level_leg_count + $old_count;
            $reach = false;

            //echo "Level User Count:".$next;

            if ($next >= $no_of_level) {
                //echo "Reach....";
                $reach = true;
            }

            while ($row1 = mysql_fetch_array($res1)) {

                $user_id[] = $row1['id'];
                $user_id_temp[] = $row1['id'];
                if ($reach) {
                    //echo "##".$row1['id'];
                    $this->last_level_user[] = $row1['id'];
                }
            }
        }

        if ($liimit_incriment < $no_of_level) {
            $count = count($user_id_temp);
            if ($count > 0) {

                if ($count >= 5000) {

                    $next = $next + 1;
                    $input_array = $user_id_temp;

                    $split_arr = array_chunk($input_array, intval($count / 4));

                    for ($i = 0; $i < count($split_arr); $i++) {

                        $this->getOneLevelUsers($split_arr[$i], $liimit_incriment, $no_of_level, $next, $table_prefix);
                    }
                } else {

                    $next = $next + 1;

                    $this->getOneLevelUsers($user_id_temp, $liimit_incriment, $no_of_level, $next, $table_prefix);
                }
            }
        }
        return $this->last_level_user;
    }

    public function getAllUplineId($id, $i, $limit) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $this->session->userdata('inf_table_prefix');
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $select = "SELECT father_id,total_leg,product_id
               FROM $ft_individual
               WHERE id=$id";
        //echo "<br>".$select."<br>";
        $result = $this->selectData($select, "Error on selction 001");
        $cnt = mysql_num_rows($result);
        if ($cnt > 0) {
            $row = mysql_fetch_array($result);
            $father_id = $row['father_id'];
            if ($i > 0) {
                $this->upline_id_arr[] = $id;
                //$this->upline_id_arr["detail$i"]["product_id"]=$row['product_id'];
            }
            $i = $i + 1;
            if ($i < $limit) {
                $this->getAllUplineId($father_id, $i, $limit);
            }
        }

        return $this->upline_id_arr;
    }

}
