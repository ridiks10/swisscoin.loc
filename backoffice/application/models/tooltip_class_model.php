<?php

Class tooltip_class_model extends inf_model {

    public $user_arr = null;

    public function getSponserDetails($qr) {
        $this->load->model('country_state_model');
        $this->load->model('leg_class_model');
        $user_detail = array();

        $res1 = $this->db->query($qr);
        $num = $res1->num_rows;

        $i = 1;
        foreach ($res1->result_array() as $row) {
            $user_detail["detail$i"]["id"] = $row["user_detail_refid"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["address"] = $row["user_detail_address"];
            $user_detail["detail$i"]["father"] = $row["user_detail_father"];
            $user_detail["detail$i"]["product"] = $row["user_details_prod"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["position"] = $row["position"];
            $user_detail["detail$i"]["country"] = $this->country_state_model->getCountryNameFromId($row["user_detail_country"]);
            $user_detail["detail$i"]["state"] = $row["user_detail_state"];
            $user_detail["detail$i"]["po"] = $row["user_detail_po"];
            $user_detail["detail$i"]["pincode"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["college"] = $row["user_detail_college"];
            $user_detail["detail$i"]["course"] = $row["user_detail_course"];
            $user_detail["detail$i"]["year_study"] = $row["user_detail_year_study"];
            $user_detail["detail$i"]["blood"] = $row["user_detail_blood_group"];
            $user_detail["detail$i"]["donate_blood"] = $row["user_detail_donate_blood"];
            $user_detail["detail$i"]["area_interest"] = $row["user_detail_area_interest"];
            $user_detail["detail$i"]["qualification"] = $row["user_detail_qualification"];
            $user_detail["detail$i"]["designation"] = $row["user_detail_designation"];
            $user_detail["detail$i"]["dept"] = $row["user_detail_dept"];
            $user_detail["detail$i"]["office"] = $row["user_detail_office"];
            $user_detail["detail$i"]["place_work"] = $row["user_detail_place_work"];
            $user_detail["detail$i"]["passcode"] = $row["user_detail_passcode"];
            $user_detail["detail$i"]["mobile"] = $row["user_detail_mobile"];
            $user_detail["detail$i"]["land"] = $row["user_detail_land"];
            $user_detail["detail$i"]["email"] = $row["user_detail_email"];
            $user_detail["detail$i"]["dob"] = $row["user_detail_dob"];
            $user_detail["detail$i"]["gender"] = $row["user_detail_gender"];
            $user_detail["detail$i"]["nominee"] = $row["user_detail_nominee"];
            $user_detail["detail$i"]["seek_job"] = $row["user_detail_seek_job"];
            $user_detail["detail$i"]["relation"] = $row["user_detail_relation"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["level"] = $row["user_level"];
            $user_detail["detail$i"]["date"] = $row["join_date"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["referral"] = $row["user_details_ref_user_id"];
            $user_detail["detail$i"]["user_photo"] = $row["user_photo"];
            $user_detail["detail1"]["nominee"] = $row["user_detail_nominee"];
            $user_detail["detail1"]["relation"] = $row["user_detail_relation"];
            $user_detail["detail1"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail1"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail1"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail1"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail1"]["pan"] = $row["user_detail_pan"];
            $leg_arr = $this->getLegLeftRightCount($row["user_detail_refid"]);
            $user_detail["detail$i"]["left"] = $leg_arr['total_left_count'];
            $user_detail["detail$i"]["right"] = $leg_arr['total_right_count'];
            $i++;
        }

        return $this->replaceNullFromArray($user_detail, "NA");
    }

    /**
     * @deprecated 1.21 Is this even used?
     */
    public function getUserDetails($qr) {
        log_message('error', 'tooltip_class_model->getUserDetails :: Deprecated call');
        $this->load->model('country_state_model');
        $user_detail = array();

        $res1 = $this->db->query($qr);
        $num = $res1->num_rows;

        $i = 1;
        foreach ($res1->result_array() as $row) {
            $user_detail["detail$i"]["id"] = $row["user_detail_refid"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["last_name"] = $row["user_detail_second_name"];
            $user_detail["detail$i"]["address"] = $row["user_detail_address"];
            $user_detail["detail$i"]["father"] = $row["user_details_ref_user_id"];
            $user_detail["detail$i"]["product"] = $row["product_id"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["position"] = $row["position"];
            $user_detail["detail$i"]["country"] = $this->country_state_model->getCountryNameFromId($row["user_detail_country"]);
            $user_detail["detail$i"]["state"] = $row["user_detail_state"];
            $user_detail["detail$i"]["po"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["pincode"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["passcode"] = $row["user_detail_passcode"];
            $user_detail["detail$i"]["mobile"] = $row["user_detail_mobile"];
            $user_detail["detail$i"]["land"] = $row["user_detail_land"];
            $user_detail["detail$i"]["email"] = $row["user_detail_email"];
            $user_detail["detail$i"]["dob"] = $row["user_detail_dob"];
            $user_detail["detail$i"]["gender"] = $row["user_detail_gender"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["level"] = $row["user_level"];
            $user_detail["detail$i"]["date"] = $row["join_date"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["referral"] = $row["user_details_ref_user_id"];
            $user_detail["detail$i"]["user_photo"] = $row["user_photo"];
            if ($this->session->userdata['inf_logged_in']['mlm_plan'] == "Binary") {
                $leg_arr = $this->getLegLeftRightCount($row["user_detail_refid"]);
                $user_detail["detail$i"]["left"] = $leg_arr['total_left_count'];
                $user_detail["detail$i"]["left_carry"] = $leg_arr['total_left_carry'];
                $user_detail["detail$i"]["right"] = $leg_arr['total_right_count'];
                $user_detail["detail$i"]["right_carry"] = $leg_arr['total_right_carry'];
            }

            $user_detail["detail$i"]["rank"] = $this->validation_model->getRankName($row["user_rank_id"]);
            $i++;
        }

        return $this->replaceNullFromArray($user_detail, "NA");
    }

    /**
     * @deprecated 1.21 Is this even used?
     */
    public function getBoardUserDetails($qr) {
        log_message('error', 'tooltip_class_model->getBoardUserDetails :: Deprecated call');
        $user_detail = array();

        $res1 = $this->db->query($qr);
        $num = $res1->num_rows;

        $i = 1;
        foreach ($res1->result_array() as $row) {
            $user_detail["detail$i"]["id"] = $row["id"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["user_photo"] = $row["user_photo"];
            $i++;
        }

        return $this->replaceNullFromArray($user_detail, "NA");
    }

    public function getLegLeftRightCount($user_id) {
        $total_left_count = $total_right_count = $total_left_carry = $total_right_carry = 0;
        $this->db->select('total_left_count,total_right_count');
        $this->db->select('total_left_carry,total_right_carry');
        $this->db->from('leg_details');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $total_left_count = $row->total_left_count;
            $total_right_count = $row->total_right_count;
            $total_left_carry = $row->total_left_carry;
            $total_right_carry = $row->total_right_carry;
        }
        $arr = array();
        $arr['total_left_count'] = $total_left_count;
        $arr['total_left_carry'] = $total_left_carry;
        $arr['total_right_count'] = $total_right_count;
        $arr['total_right_carry'] = $total_right_carry;
        return $arr;
    }

    /**
     * @deprecated 1.21 Is this even used?
     */
    public function getUserData($qr) {
        log_message('error', 'tooltip_class_model->getUserData :: Deprecated call');
        $user_detail = $this->getUserDetails($qr);
        return $user_detail;
    }

    public function replaceNullFromArray($user_detail = array(), $replace = '') {
        if ($replace == '') {
            $replace = "NA";
        }

        $len = count($user_detail);
        $key_up_arr = array_keys($user_detail);
        for ($i = 1; $i <= $len; $i++) {
            $k = $i - 1;
            $fild = $key_up_arr[$k];
            $arr_key = array_keys($user_detail["$fild"]);
            $key_len = count($arr_key);
            for ($j = 0; $j < $key_len; $j++) {
                $key_field = $arr_key[$j];
                if ($user_detail["$fild"]["$key_field"] == "") {
                    $user_detail["$fild"]["$key_field"] = $replace;
                }
            }
        }
        return $user_detail;
    }

    public function createQuery($user_id, $ft_individual = '') {

        $where = "";

        $count_id = count($user_id);

        $user_details = $this->table_prefix . "user_details";

        if ($ft_individual == '') {


            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $where .= " OR user_detail_refid='$user_id[$i]' ";
                } else {
                    $where .= " user_detail_refid='$user_id[$i]' ";
                }
            }
            $ft_individual = $this->table_prefix . "ft_individual";
            $select_users = "SELECT * FROM $user_details INNER JOIN $ft_individual on id=user_detail_refid  WHERE " . $where;
        } else {

            for ($i = 0; $i < $count_id; $i++) {
                if ($i !== 0) {
                    $where .= " OR ft.id='$user_id[$i]' ";
                } else {
                    $where .= " ft.id='$user_id[$i]' ";
                }
            }
            $ft_individual = $this->table_prefix . $ft_individual;
            $select_users = "SELECT * FROM $user_details AS ud INNER JOIN $ft_individual AS ft on ft.user_ref_id=ud.user_detail_refid  WHERE " . $where;
        }
        return $select_users;
    }

    public function getSponsor($arr, $ft_individual = "") {
        $user_id = $arr;
        $this->user_arr = $arr;
        if (count($user_id) > 0) {
            for ($k = 1; $k <= TREE_LEVEL; $k++) {
                $user_id = $this->getSponsorUser($user_id, $ft_individual);
            }
        }
        return $this->user_arr;
    }

    public function getUsers($arr, $ft_individual = "") {
        $user_id1 = $arr;
        $this->user_arr = $arr;
        if (count($user_id1) > 0) {
            for ($k = 1; $k <= TREE_LEVEL; $k++) {
                $user_id1 = $this->getUserArray($user_id1, $ft_individual);
            }
        }
        return $this->user_arr;
    }

    public function getUserArray($arr, $ft_individual) {
        $user_id1 = null;
        $user_id = $arr;
        $select_users = "";
        $sql = "";
        if ($ft_individual == "") {
            $ft_individual = 'ft_individual';
        }
        $count_id = count($user_id);

        $flag = 0;

        if (count($user_id) > 0) {
            for ($i = 0; $i < $count_id; $i++) {
                $j = 0;
                $user_ft_details = $this->validation_model->getUserFTDetails($user_id[$j]);
                $user_level = $user_ft_details['user_level'];
                if ($i != 0) {
                    $flag = 1;
                    $sql .= "OR father_id = '$user_id[$i]' AND (user_level-$user_level < " . TREE_LEVEL . ")";
                } else {
                    $sql .="active !='server' AND (father_id = '$user_id[$i]') AND (user_level-$user_level <  " . TREE_LEVEL . ")";
                }
            }

            $this->db->select('id');
            $this->db->from("$ft_individual");
            $this->db->where($sql);
            $res1 = $this->db->get();

            foreach ($res1->result_array() as $row1) {
                $user_id1[] = $row1['id'];
                $user_id[] = $row1['id'];
                $this->user_arr[] = $row1['id'];
            }
        }


        return $user_id1;
    }

    public function getSponsorUser($arr, $ft_individual) {
        $user_id1 = null;
        $user_id = $arr;
        $select_users = "";
        $sql = "";

        $count_id = count($user_id);

        $flag = 0;
        if (count($user_id) > 0) {
            for ($i = 0; $i < $count_id; $i++) {

                if ($i != 0) {
                    $flag = 1;
                    $sql .= " OR  father_id='$user_id[$i]'";
                } else {
                    if ($ft_individual == '') {
                        $ft_individual = $this->table_prefix . "ft_individual";

                        $sql .= "SELECT id FROM $ft_individual WHERE   (active!='server') AND ( sponsor_id='$user_id[$i]'";
                    } else {
                        $ft_individual = $this->table_prefix . $ft_individual;

                        $sql .= "SELECT id FROM $ft_individual WHERE   (active!='server') AND ( father_id='$user_id[$i]'";
                    }
                }
            }


            $as = "";
            if ($i > 0) {
                $as = " )";
                $select_users.=$sql . " )";
            } else {
                $select_users.=$sql;
            }
            $query = $this->db->query($select_users);
            foreach ($query->result_array() as $row) {
                $this->user_arr[] = $row['id'];
                $user_id[] = $row['id'];
                $user_id1[] = $row['id'];
            }
        }
        return $user_id1;
    }

    public function getStatus($id) {
        $status = 'no';
        $ft_individual = $this->table_prefix . "ft_individual";
        $query = $this->db->query("SELECT status FROM $ft_individual WHERE id='$id'");
        foreach ($query->result_array() AS $row) {
            $status = $row['status'];
        }
        return $status;
    }

    public function getUsersBoard($arr, $board_id) {
        $user_id1 = $arr;
        $this->user_arr = $arr;
        if (count($user_id1) > 0)
            for ($k = 1; $k <= TREE_LEVEL; $k++) {
                $user_id1 = $this->getUserArrayBoard($user_id1, $board_id);
            }

        return $this->user_arr;
    }

    public function getUserArrayBoard($arr, $board_id) {
        $user_id1 = null;
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
                    $auto_board = $this->table_prefix . "auto_board_$board_id";

                    $sql .= "SELECT user_ref_id FROM $auto_board WHERE   (active!='server') AND ( father_id='$user_id[$i]'";
                }
            }

            $as = "";
            if ($i > 0) {
                $as = " )";
                $select_users.=$sql . " )";
            } else {
                $select_users.=$sql;
            }

            $res1 = $this->db->query($select_users);
            foreach ($res1->result_array() AS $row1) {
                $this->user_arr[] = $row1['user_ref_id'];
                $user_id[] = $row1['user_ref_id'];
                $user_id1[] = $row1['user_ref_id'];
            }
        }

        return $user_id1;
    }

    public function createQueryBoard($user_id, $board_id) {

        $sql = "";
        $user_details = $this->table_prefix . "user_details";
        $auto_board = $this->table_prefix . "auto_board_$board_id";
        $select_users = "SELECT * FROM $user_details INNER JOIN $auto_board on user_ref_id=user_detail_refid  WHERE ";

        $count_id = count($user_id);
        for ($i = 0; $i < $count_id; $i++) {
            if ($i !== 0) {
                $sql .= " OR user_ref_id='$user_id[$i]'";
            } else {
                $sql .= "user_ref_id='$user_id[$i]'";
            }
        }
        $select_users.=$sql;
        return $select_users;
    }

    public function getUserDetailsBoard($qr, $board_id) {
        $this->load->model('country_state_model');
        $user_detail = array();
        $res1 = $this->db->query($qr, "Error sel query -24535");

        $i = 1;
        foreach ($res1->result_array() AS $row) {
            $user_detail["detail$i"]["id"] = $row["id"];
            $user_detail["detail$i"]["user_name"] = $row["user_name"];
            $user_detail["detail$i"]["name"] = $row["user_detail_name"];
            $user_detail["detail$i"]["address"] = $row["user_detail_address"];
            $user_detail["detail$i"]["father"] = $row["user_detail_father"];
            $user_detail["detail$i"]["product"] = $row["user_details_prod"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["position"] = $row["position"];
            $user_detail["detail$i"]["country"] = $this->country_state_model->getCountryNameFromId($row["user_detail_country"]);
            $user_detail["detail$i"]["state"] = $row["user_detail_state"];
            $user_detail["detail$i"]["po"] = $row["user_detail_po"];
            $user_detail["detail$i"]["pincode"] = $row["user_detail_pin"];
            $user_detail["detail$i"]["college"] = $row["user_detail_college"];
            $user_detail["detail$i"]["course"] = $row["user_detail_course"];
            $user_detail["detail$i"]["year_study"] = $row["user_detail_year_study"];
            $user_detail["detail$i"]["blood"] = $row["user_detail_blood_group"];
            $user_detail["detail$i"]["donate_blood"] = $row["user_detail_donate_blood"];
            $user_detail["detail$i"]["area_interest"] = $row["user_detail_area_interest"];
            $user_detail["detail$i"]["qualification"] = $row["user_detail_qualification"];
            $user_detail["detail$i"]["designation"] = $row["user_detail_designation"];
            $user_detail["detail$i"]["dept"] = $row["user_detail_dept"];
            $user_detail["detail$i"]["office"] = $row["user_detail_office"];
            $user_detail["detail$i"]["place_work"] = $row["user_detail_place_work"];
            $user_detail["detail$i"]["passcode"] = $row["user_detail_passcode"];
            $user_detail["detail$i"]["mobile"] = $row["user_detail_mobile"];
            $user_detail["detail$i"]["land"] = $row["user_detail_land"];
            $user_detail["detail$i"]["email"] = $row["user_detail_email"];
            $user_detail["detail$i"]["dob"] = $row["user_detail_dob"];
            $user_detail["detail$i"]["gender"] = $row["user_detail_gender"];
            $user_detail["detail$i"]["nominee"] = $row["user_detail_nominee"];
            $user_detail["detail$i"]["seek_job"] = $row["user_detail_seek_job"];
            $user_detail["detail$i"]["relation"] = $row["user_detail_relation"];
            $user_detail["detail$i"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail$i"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail$i"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail$i"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail$i"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["level"] = $row["user_level"];
            $user_detail["detail$i"]["date"] = $row["join_date"];
            $user_detail["detail$i"]["town"] = $row["user_detail_town"];
            $user_detail["detail$i"]["referral"] = $row["user_details_ref_user_id"];
            $user_detail["detail$i"]["user_photo"] = $row["user_photo"];
            $user_detail["detail1"]["acnumber"] = $row["user_detail_acnumber"];
            $user_detail["detail1"]["ifsc"] = $row["user_detail_ifsc"];
            $user_detail["detail1"]["nbank"] = $row["user_detail_nbank"];
            $user_detail["detail1"]["nbranch"] = $row["user_detail_nbranch"];
            $user_detail["detail1"]["pan"] = $row["user_detail_pan"];
            $user_detail["detail$i"]["left"] = 0;
            $user_detail["detail$i"]["right"] = 0;
            $i++;
        }
        $user_detail = $this->replaceNullFromArray($user_detail, "NA");
        return $user_detail;
    }

    public function getAutoBoardId($ref_id, $board_id) {
        $id = '';
        $this->db->select("id");
        $this->db->from("auto_board_$board_id");
        $this->db->where("user_ref_id", $ref_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {

            $id = $row->id;
        }
        return $id;
    }

}
