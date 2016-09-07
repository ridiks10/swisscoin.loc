<?php

Class leg_class_model extends inf_model {

    var $user_leg_det = Array();
    var $total_user_leg_det = Array();
    public $user_arr = null;
    public $table_prefix = "";
    public $total_user_det = Array();

    public function __construct() {
        $this->load->model('validation_model');
    }

    public function setTablePrefix($table_prefix) {
        $this->table_prefix = $table_prefix;
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
        $sql = "";
        $count_id = count($user_id);
        $flag = 0;
        if (count($user_id) > 0) {
            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $flag = 1;
                    $sql .= " OR  father_id='$user_id[$i]'";
                } else {



                    $this->db->select('id');
                    $this->db->from('ft_individual');
                    $this->db->where('active', 'yes');
                    $this->db->where('father_id', $user_id[$i]);
                    $query = $this->db->get();

                    //$sql .= "SELECT id FROM $ft_individual WHERE (active='yes') AND ( father_id='$user_id[$i]'";
                }
            }
            $as = "";
            if ($i > 0) {
                $as = " )";
                $select_users.=$sql . " )";
            } else {
                $select_users.=$sql;
            }
            //echo "<br>$flag ".$select_users;
            //$res1 = $this->selectData($select_users);
            foreach ($query->result_array() as $row) {

                $this->user_arr[] = $row['id'];
                $user_id[] = $row['id'];
                $user_id_temp[] = $row['id'];
            }
        }

        $count = count($user_id_temp);
        if ($count > 0) {
            if ($count >= 8) {
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

    public function getUserLegDetails($user_id, $page, $limit) {
        $this->db->select('id as userid');
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('active', 'yes');
        $this->db->group_by('id');
        $this->db->limit($limit, $page);
        $result = $this->db->get();

        $j = 0;
        foreach ($result->result_array() as $row) {
            extract($row);

            $this->user_leg_det["detail$j"]["user_id"] = $userid;
            $user_detail_name = $this->getUserDetailName($userid);
            $this->user_leg_det["detail$j"]["user_name_id"] = "$user_name - $user_detail_name";

            $j = $j + 1;
        }

        return $this->user_leg_det;
    }

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

    /**
     * @since 1.21 There is no total_leg
     */
    public function getTotalLegTotalAmount($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $leg_amount = $this->table_prefix . "leg_amount";
        $select = "SELECT SUM(total_amount) AS total_amount
                   FROM $leg_amount WHERE user_id='$user_id'";

        $result = $this->selectData($select, "Error on selecting leg 100");
        $row = mysql_fetch_array($result);
        $tot_arr['total_leg'] = '0';
        if ($row['total_amount'] == "") {
            $tot_arr['total_amount'] = '0';
        } else
            $tot_arr['total_amount'] = $row['total_amount'];

        return $tot_arr;
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
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $leg_carry_forward = $this->table_prefix . "leg_carry_forward";
        $select = "SELECT * FROM $leg_carry_forward WHERE user_id='$id'";
        $result = $this->selectData($select);
        $row = mysql_fetch_array($result);

        $left_carry = $row['carry_left'];
        $right_carry = $row['carry_right'];

        if ($left_carry == "")
            $left_carry = 0;
        if ($right_carry == "")
            $right_carry = 0;


        $arr["left_carry"] = $left_carry;
        $arr["right_carry"] = $right_carry;

        return $arr;
    }

    public function getRightLegCountOld($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $selectleft1 = "select * from  $ft_individual where father_id = " . $id . " and active = 'yes' and position='R'";
        $selectleftres1 = $this->selectData($selectleft1);

        $row1 = mysql_fetch_array($selectleftres1);
        $cnt2 = mysql_num_rows($selectleftres1);
        if ($cnt2 > 0) {


            $lid = $row1['id'];
            $total_left_temp = $this->calculateEach($lid, 0);
            $total_right = $total_left_temp;
            if ($this->table_prefix == "") {
                $this->table_prefix = $_SESSION['table_prefix'];
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
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $select = "SELECT id
					FROM $ft_individual 
					WHERE active='yes'";

        $result = $this->selectData($select);
        $cnt2 = mysql_num_rows($result);
        return $cnt2;
    }

    public function getUserPointCount($id) {
        $product_value_child1 = 0;
        $product_value_child2 = 0;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $product_value_id = $this->get_product_point($id);
        $select = "SELECT * FROM  $ft_individual WHERE father_id=$id and active='yes' ORDER BY position";
        $result = $this->selectData($select, "Error on selecting 302");
        while ($row = mysql_fetch_array($result)) {
            if ($row["position"] == "L")
                $user_id['0'] = $row["id"];
            else if ($row["position"] == "R")
                $user_id['1'] = $row["id"];
        }


        if ($user_id["0"] > 0) {
            $product_value_child1 = $this->get_product_point($user_id["0"]) + $this->getTotalLegCount($user_id["0"]);
        }
        if ($user_id["1"] > 0) {
            $product_value_child2 = $this->get_product_point($user_id["1"]) + $this->getTotalLegCount($user_id["1"]);
        }


        $total_arr["left"] = $product_value_child1;
        $total_arr["right"] = $product_value_child2;
        return $total_arr;
    }

    public function calculate_each_leg_count($id, $cnt) {
        global $count;
        $count = $cnt;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $selectleft1 = "select * from $ft_individual where father_id = $id";
        $selectleftres1 = mysql_query($selectleft1) or die("Error on selecting blocked member 11");

        while ($row1 = mysql_fetch_array($selectleftres1)) {
            $active = $row1['active'];
            if ($active == 'yes') {
                $count+=$this->get_product_point($row1['id']);
            }

            $this->calculate_each_leg_count($row1['id'], $count);
        }

        return $count;
    }

    public function get_product_point($id) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $point = 0;
        $ft_individual = $this->table_prefix . "ft_individual";
        $product = $this->table_prefix . "product";
        $tmpinsert = "select p.pair_value from $ft_individual as f INNER JOIN $product as p on f.product_id=p.product_id where id=$id";

        $tmpres = mysql_query($tmpinsert) or die("Error on selecting product point");
        $cnt = mysql_num_rows($tmpres);

        if ($cnt > 0) {
            $row = mysql_fetch_array($tmpres);
            $point = $row['pair_value'];
        }

        return $point;
    }

    public function getLevelUsers($user_id, $level) {
        $arr[] = $user_id;
        $this->each_level_leg_count = null;
        $this->last_level_user = null;

        $liimit_incriment = 0;
        $next = 1;

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
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
            $res1 = $this->selectData($select_users);
            $current_level_leg_count = mysql_num_rows($res1);
            $old_count = $this->each_level_leg_count["level$next"];

            $this->each_level_leg_count["level$next"] = $current_level_leg_count + $old_count;
            $reach = false;


            if ($next >= $no_of_level) {

                $reach = true;
            }

            while ($row1 = mysql_fetch_array($res1)) {

                $user_id[] = $row1['id'];
                $user_id_temp[] = $row1['id'];
                if ($reach) {

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
            $this->table_prefix = $_SESSION['table_prefix'];
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

    public function getEachLeveLegCountAndTotalLeveAmount($user_id, $no_levels) {
        $user_arr[] = $user_id;
        $level = 1;

        for ($i = 0; $i < $no_levels; $i++) {
            $res = $this->insertUserDetailToArray($user_arr, $level, $user_id);

            $user_arr = $this->getUserArray($user_arr);

            $level = $level + 1;

            if (count($user_arr) < 1) {
                break;
            }
        }
        return $this->total_user_det;
    }

    public function insertUserDetailToArray($user_id_arr, $level, $user_id) {
        $i = $level;

        $persons = count($user_id_arr);
        $amount = $this->getAmount($user_id, $level - 1);
        $this->total_user_det["detail$i"]["level"] = $level;
        $this->total_user_det["detail$i"]["persons"] = $persons;
        $this->total_user_det["detail$i"]["amount"] = $amount;
    }

    public function getAmount($user_id, $level) {
        //$totaluser=count($user_id_arr);
        $amount = 0;
        $this->db->select_sum('total_amount', 'amt');
        $this->db->from('leg_amount');
        $this->db->where('user_id', $user_id);
        $this->db->where('user_level', $level);
        $qr1 = $this->db->get();
        foreach ($qr1->result() as $row) {
            $amount = $row->amt;
        }
        return $amount;
    }

}
