<?php

Class get_tree_model extends inf_model {

    public $fromDateCal;
    public $toDateCal;
    public $user_arr;
    public $user_detail_id_arr;
    public $obj_mng;
    public $upline_id_arr;
    public $obj_set;
    public $obj_leg;
    public $downline_user;
    public $each_level_leg_count;

    public function __construct() {
        parent::__construct();
        $this->fromDateCal = null;
        $this->toDateCal = null;
        $this->user_arr = array();
        $this->user_detail_id_arr = array();
        $this->downline_user = array();
        $this->upline_id_arr = array();
        $this->each_level_leg_count = array();
    }

    public function closeDB() {
        $this->closeDB();
    }

    public function getAllUplineId($id, $i, $session_userid) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }

        $ft_individual = $this->table_prefix . "ft_individual";
        $select = "SELECT father_id,total_leg,product_id
                FROM $ft_individual
                WHERE id=$id";
        $result = $this->db->query($select);
        $cnt = $result->num_rows();
        if ($cnt > 0) {
            $row = $result->row_array();
            $father_id = $row['father_id'];
            $this->upline_id_arr["detail$i"]["id"] = $id;
            $this->upline_id_arr["detail$i"]["up_level"] = $i + 1;

            $i = $i + 1;
            if ($father_id >= $session_userid) {
                $this->getAllUplineId($father_id, $i, $session_userid);
            }
        }
    }

    public function getAllUplineIdUnilevel($id, $i, $session_userid) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $ft_individual = $this->table_prefix . "ft_individual";
        $select = "SELECT sponsor_id,product_id
                FROM $ft_individual
                WHERE id=$id";

        $result = $this->selectData($select, "Error on selction 001");
        $cnt = mysql_num_rows($result);
        if ($cnt > 0) {
            $row = mysql_fetch_array($result);
            $father_id = $row['sponsor_id'];
            $this->upline_id_arr["detail$i"]["id"] = $id;
            $this->upline_id_arr["detail$i"]["up_level"] = $i + 1;
            $i = $i + 1;
            if ($father_id >= $session_userid) {
                $this->getAllUplineId($father_id, $i, $session_userid);
            }
        }
    }

    Public function userDownlineUser($id, $session_userid) {
        $flag = "no";
        $userdetail = $this->getAllUplineId($id, 0, $session_userid);

        $user_count = count($this->upline_id_arr);
        for ($i = 0; $i < $user_count; $i++) {
            $userid = $this->upline_id_arr["detail$i"]["id"];
            if ($userid == $session_userid) {
                $flag = "yes";
                break;
            } else {
                $flag = "no";
            }
        }
        return $flag;
    }

    Public function userDownlineUserUnilevel($id, $session_userid) {
        $flag = "no";
        $userdetail = $this->getAllUplineIdUnilevel($id, 0, $session_userid);

        $user_count = count($this->upline_id_arr);
        for ($i = 0; $i < $user_count; $i++) {
            $userid = $this->upline_id_arr["detail$i"]["id"];
            if ($userid == $session_userid) {
                $flag = "yes";
                break;
            } else {
                $flag = "no";
            }
        }
        return $flag;
    }

    public function getDownlineUsers($user_id, $no_level = 0) {
        $arr[] = $user_id;

        $this->downline_user_leg_det = null;

        $liimit_incriment = 0;
        $next = 1;
        $arr = $this->insertLevelLevelUsers($arr, $liimit_incriment, $no_level, $next);

        return $this->downline_user;
    }

    public function insertLevelLevelUsers($arr, $liimit_incriment, $no_of_level, $next) {
        $liimit_incriment = $liimit_incriment + 1;
        $user_id_temp = null;
        $user_id = $arr;
        $select_users = "";
        $count_id = count($user_id);
        $flag = 0;
        $sql = "";

        if (count($user_id) > 0) {
            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $flag = 1;
                    $sql .= " OR  father_id=$user_id[$i]";
                } else {
                    $sql .= "(active='yes' OR active='server' ) AND  ( father_id=$user_id[$i]";
                }
            }
            $sql.= " )";
            $res1 = $this->db->select("*")->where("active !=", "server")->where("$sql")->get("ft_individual");
            $current_level_leg_count = $res1->num_rows();
            if (array_key_exists("level$next", $this->each_level_leg_count))
                $old_count = $this->each_level_leg_count["level$next"];
            else
                $old_count = 0;
        }
        foreach ($res1->result_array() AS $row1) {
            $user_id[] = $row1['id'];
            $user_id_temp[] = $row1['id'];
            $this->downline_user["details$next"][] = $row1['id'];
        }
        if (($liimit_incriment < $no_of_level) OR ( $no_of_level == 0)) {
            $count = count($user_id_temp);
            if ($count > 0) {

                if ($count >= 5000) {
                    $next = $next + 1;
                    $input_array = $user_id_temp;
                    $split_arr = array_chunk($input_array, intval($count / 4));
                    for ($i = 0; $i < count($split_arr); $i++) {
                        $this->insertLevelLevelUsers($split_arr[$i], $liimit_incriment, $no_of_level, $next);
                    }
                } else {
                    $next = $next + 1;
                    $this->insertLevelLevelUsers($user_id_temp, $liimit_incriment, $no_of_level, $next);
                }
            }
        }

        return $user_id_temp;
    }

    public function getMaxLevelCount($user_arr) {
        $arr_len = count($user_arr);
        $max_count = 0;
        for ($i = 0; $i < $arr_len; $i++) {
            if (isset($user_arr["details$i"]))
                $inner_len = count($user_arr["details$i"]);
            else
                $inner_len = 0;
            if ($inner_len > $max_count) {
                $max_count = $inner_len;
            }
        }
        return $max_count;
    }

    public function getDownLevelUsersAndPosition($father_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }


        $ft_individual = $this->table_prefix . "ft_individual";

        $qrCat = "SELECT id,position FROM $ft_individual WHERE father_id='$father_id' ORDER BY position";

        $res = $this->selectData($qrCat, "Error on get father 57467867");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {

            $down_user_id_arr["detail$i"]["id"] = $row["id"];
            $down_user_id_arr["detail$i"]["position"] = $row["position"];
            $i++;
        }
        return $down_user_id_arr;
    }

    Public function userDownlineUserBoard($id, $session_userid, $board_id) {
        $flag = "no";
        $userdetail = $this->getAllUplineIdBoard($id, 0, $session_userid, $board_id);

        $user_count = count($this->upline_id_arr);
        for ($i = 0; $i < $user_count; $i++) {
            $userid = $this->upline_id_arr["detail$i"]["id"];
//echo $userid."userid".$session_userid."<br>";
            if ($userid == $session_userid) {
                $flag = "yes";
                break;
            } else {
                $flag = "no";
            }
        }
        return $flag;
    }

    public function getAllUplineIdBoard($id, $i, $session_userid, $board_id) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $auto_board = $this->table_prefix . "auto_board_$board_id";
        $select = "SELECT father_id
                FROM $auto_board
                WHERE id=$id";
        //echo "<br>".$select."<br>";
        $result = $this->selectData($select, "Error on selction 001");
        $cnt = mysql_num_rows($result);
        if ($cnt > 0) {
            $row = mysql_fetch_array($result);
            $father_id = $row['father_id'];
            $this->upline_id_arr["detail$i"]["id"] = $id;
            $this->upline_id_arr["detail$i"]["up_level"] = $i + 1;

            $i = $i + 1;
            if ($father_id >= $session_userid) {
                $this->getAllUplineId($father_id, $i, $session_userid, $board_id);
            }
        }
    }

}
