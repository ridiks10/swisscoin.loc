<?php
/**
 * @deprecated Most likely do not used
 */
class auto_board_filling_model extends Inf_Model {

    public $BOARD_WIDTH;
    public $BOARD_DEPTH;
    public $FOLLOW_SPONSOR_STATUS;
    public $ACTIVE_SPONSER;
    public $BOARD_FILL_COMMISSION;
    public $upline_id_arr;

    function __construct() {
        parent::__construct();

        $this->load->model('validation_model');
        $this->load->model('settings_model');

        $this->FOLLOW_SPONSOR_STATUS = TRUE;
        $this->RE_ENTRY_STATUS = TRUE;
        $this->RE_ENTRY_NEXT_STATUS = FALSE;
        $this->BOARD_WIDTH = 2;
        $this->BOARD_DEPTH = 2;
        $this->ACTIVE_SPONSER = 0;
        $this->BOARD_FILL_COMMISSION = 0;
        $this->upline_id_arr = array();
    }

    public function addUserBoard($user_ft_id, $board_user_name, $referrer_id, $board_no, $active = 'yes', $type = 'normal', $oc_order_id = 0) {

        $this->setBoardWidthAndDepth($board_no);

        $board_placement = $this->getNewBoardPlacement($referrer_id, $board_no);

        $father_id = $board_placement["father_id"];
        $position = $board_placement["position"];
        $user_detail_arr["user_name"] = $board_user_name;
        $user_detail_arr["user_ref_id"] = $user_ft_id;
        $user_detail_arr["position"] = $position;
        $user_detail_arr["father_id"] = $father_id;
        $user_detail_arr["active"] = $active;
        $user_detail_arr["type"] = $type;

        $user_level = 0;
        if ($father_id != 0) {
            $user_level = $this->getUserLevel($father_id, $board_no) + 1;
        }
        $user_detail_arr["user_level"] = $user_level;

        $insert_id = $this->insertIntoAutoBoard($user_detail_arr, $board_no);

        //$board_slno = $this->getBoardNumberFromBoardUserDetails($father_id, $board_no);
        //$board_user_id = $this->getBoardUserID($referrer_id, $board_no);
        //$referal_slno = $this->getBoardNumberFromBoardUserDetails($board_user_id, $board_no);

        $new_board_slno = $this->getMaxBoardNumber($board_no) + 1;

        $this->addToBoardView($insert_id, $board_no, $new_board_slno, 'no', 'no');

        $last_slno = $this->addToBoardUserDetailRecursively($insert_id, $board_no, $new_board_slno);
        $board_top_id = $this->getBoardTopID($last_slno, $board_no);

        $total_user_count = $this->boardTotalUserCount($last_slno, $board_no);

        $board_total_count = (pow($this->BOARD_WIDTH, $this->BOARD_DEPTH + 1) - 1) / ($this->BOARD_WIDTH - 1);

        if ($total_user_count == $board_total_count) {
            $this->splitUserBoard($board_top_id, $last_slno, $board_no);

            $from_id = $this->getUserFtID($insert_id, $board_no);
            $split_board_slno = $this->getBoardNumberFromBoardUserDetails($board_top_id, $board_no);
            $board_top_ref_id = $this->getUserFtID($board_top_id, $board_no);

            //Commission
            $this->payBoardFillCommission($board_top_ref_id, $board_no, $split_board_slno, $from_id, $oc_order_id);

            $board_top_username = $this->validation_model->IdToUserNameBoard($board_top_id, $board_no);

            $split_username = explode("_", $board_top_username);

            $search_username = $split_username[0];

            if ($this->RE_ENTRY_STATUS == "yes") {
                $next_board_username = $search_username;
                if ($board_no > 1) {
                    for ($count = 1; $count < $board_no; $count++) {
                        if (isset($split_username[$count])) {
                            $next_board_username .= '_' . $split_username[$count];
                        }
                    }
                }

                $total_entry_count = $this->getUsernameCount($board_top_ref_id, $search_username, $board_no);
                $re_entry_suffix = ($total_entry_count > 0) ? "_" . $total_entry_count : '';

                $board_user_name = $search_username . $re_entry_suffix;
                $type = "re_entry_$total_entry_count";
                $this->addUserBoard($board_top_ref_id, $board_user_name, $board_top_ref_id, $board_no, 'yes', $type);
            }

            if ($this->RE_ENTRY_NEXT_STATUS == "yes") {
                $board_no++;
                $next_board_username = $search_username;

                if ($board_no > 1) {
                    for ($count = 1; $count < $board_no; $count++) {
                        if (isset($split_username[$count])) {
                            $next_board_username .= '_' . $split_username[$count];
                        }
                    }
                }

                $total_entry_count = $this->getUsernameCount($board_top_ref_id, $search_username, $board_no);
                $re_entry_suffix = ($total_entry_count > 0) ? "_" . $total_entry_count : '';

                $board_user_name = $search_username . $re_entry_suffix;
                $type = "entry_$total_entry_count";
                $this->addUserBoard($board_top_ref_id, $board_user_name, $board_top_ref_id, $board_no, 'yes', $type);
            }
        }
    }

    public function payBoardFillCommission($board_top_ref_id, $board_no, $board_slno, $from_id, $oc_order_id) {

        $board_commission = $this->BOARD_FILL_COMMISSION;
        $amount_type = 'board_commission';
        $this->insertInToLegAmount($board_top_ref_id, $from_id, $board_commission, $board_no, $board_slno, $amount_type, $oc_order_id);
    }

    public function getBoardConfiguration($board_no) {

        $this->db->select('*');
        $this->db->from("board_configuration");
        $this->db->where('board_id', $board_no);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            return $row;
        }
    }

    public function setBoardWidthAndDepth($board_no) {
        $this->db->select('*');
        $this->db->where("board_id", $board_no);
        $query = $this->db->get("board_configuration");
        $result = $query->result_array();
        $this->BOARD_WIDTH = $result[0]['board_width'];
        $this->BOARD_DEPTH = $result[0]['board_depth'];
        $this->BOARD_FILL_COMMISSION = $result[0]['board_commission'];

        if ($result[0]['sponser_follow_status'] == 'no') {
            $this->FOLLOW_SPONSOR_STATUS = FALSE;
        } else {
            $this->FOLLOW_SPONSOR_STATUS = TRUE;
        }

        if ($result[0]['re_entry_status'] == 'no') {
            $this->RE_ENTRY_STATUS = FALSE;
        } else {
            $this->RE_ENTRY_STATUS = TRUE;
        }

        if ($result[0]['re_entry_to_next_status'] == 'no') {
            $this->RE_ENTRY_NEXT_STATUS = FALSE;
        } else {
            $this->RE_ENTRY_NEXT_STATUS = TRUE;
        }
    }

    public function getBoardPlacement($referrer_id, $board_no) {
        $board_placement = array();
        if (!$this->isBoardEmpty($board_no)) {
            if ($this->FOLLOW_SPONSOR_STATUS) {

                if ($this->isEntryExistInBoard($referrer_id, $board_no)) {

                    $user_board_id = $this->getUserBoardId($board_no, $referrer_id);
                    $latest_non_splitted_slno = $this->getUserLatestBoardSerialNumber($user_board_id, $board_no);

                    if ($latest_non_splitted_slno) {//SPONSER BOARD EXISTS
                        $board_placement = $this->getBoardPlacementPositionSponsor($board_no, $latest_non_splitted_slno);
                    } else {//AUTO FILL
                        $board_placement = $this->getBoardPlacementPosition($board_no);
                        //$board_placement= $this->getActiveSponser($board_no, $referrer_id);
                    }
                } else {
                    $active_sponser_ref_id = $this->getReferalId($referrer_id);

                    if ($active_sponser_ref_id != '' && $active_sponser_ref_id != 0) {
                        $board_placement = $this->getBoardPlacement($active_sponser_ref_id, $board_no);
                    } else {//AUTO FILL
                        $board_placement = $this->getBoardPlacementPosition($board_no);
                    }
                }
            } else {//AUTO FILL
                $board_placement = $this->getBoardPlacementPosition($board_no);
            }
        } else {
            $board_placement["id"] = '0';
            $board_placement["position"] = '';
        }
        return $board_placement;
    }

    public function getReferalId($user_id) {
        $referal_id = "";
        $this->db->select('user_details_ref_user_id');
        $this->db->from("user_details");
        $this->db->where('user_detail_refid ', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $referal_id = $row->user_details_ref_user_id;
        }
        return $referal_id;
    }

    public function getBoardPlacementPosition($board_no) {
        $placement_array = array();
        $this->db->select_min("id");
        $this->db->select("child_count");
        $this->db->where("child_count <", $this->BOARD_WIDTH);
        $query = $this->db->get("auto_board_$board_no");

        foreach ($query->result_array() AS $rows) {
            $placement_array['father_id'] = $rows['id'];
            $placement_array['position'] = $rows['child_count'] + 1;
        }
        return $placement_array;
    }

    public function getBoardPlacementPositionSponsor($board_no, $board_slno) {
        $placement_array = array();
        $this->db->select('ab.id AS id');
        $this->db->select('ab.child_count');
        $this->db->from("auto_board_$board_no AS ab");
        $this->db->join("board_user_detail AS bu", "bu.user_id = ab.id", "INNER");
        $this->db->where("bu.board_table_name", $board_no);
        $this->db->where("bu.board_serial_no", $board_slno);
        $this->db->where("ab.child_count <", $this->BOARD_WIDTH);
        $this->db->order_by("ab.child_count", "DESC");
        $this->db->order_by("ab.user_level", "ASC");
        $this->db->order_by("bu.board_position", "ASC");
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() AS $rows) {
            $placement_array['father_id'] = $rows['id'];
            $placement_array['position'] = $rows['child_count'] + 1;
        }
        return $placement_array;
    }

    public function getMinimumNonSplittedBoardNumber($board_no) {
        $board_slno = 0;
        $this->db->select("board_no");
        $this->db->where("board_table_name", $board_no);
        $this->db->where("board_split_status", "no");
        $this->db->order_by("board_no", "ASC");
        $this->db->limit(1);
        $query = $this->db->get("board_view");
        foreach ($query->result_array() AS $row) {
            $board_slno = $row['board_no'];
        }
        return $board_slno;
    }

    public function isBoardEmpty($board_no) {
        $flag = false;
        $count = $this->db->from("auto_board_$board_no")->count_all_results();
        if ($count == 0) {
            $flag = true;
        }
        return $flag;
    }

    public function isEntryExistInBoard($user_id, $board_no) {
        $board_name = "auto_board_" . $board_no;
        $count = $this->db->select("*")->where("user_ref_id", $user_id)->from("$board_name")->count_all_results();

        $flag = false;
        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getUserBoardId($board_no, $user_ref_id) {
        $board_id = 0;
        $res = $this->db->select_max("id")->where("user_ref_id", $user_ref_id)->get("auto_board_$board_no");
        foreach ($res->result() AS $row) {
            $board_id = $row->id;
        }
        return $board_id;
    }

    public function getUserMinimumNonSplittedBoardId($board_no, $user_ref_id) {
        $board_id = 0;
        $res = $this->db->select("MIN(ab.id) AS id")->from("auto_board_$board_no AS ab")->join("board_view AS bv", "bv.board_top_id = ab.id", "INNER")->where("bv.board_table_name", $board_no)->where("bv.board_split_status", 'no')->where("ab.user_ref_id", $user_ref_id)->get();

        foreach ($res->result() AS $row) {
            $board_id = $row->id;
        }
        return $board_id;
    }

    public function getUserLatestBoardSerialNumber($user_board_id, $board_no) {
        $board_serial_no = 0;
        $this->db->select("bu.board_serial_no");
        $this->db->from("board_user_detail AS bu");
        $this->db->join("board_view AS bv", "bv.board_no = bu.board_serial_no", "INNER");
        $this->db->order_by("bu.date_of_join", "DESC");
        $this->db->order_by("bu.board_serial_no", "DESC");
        $this->db->where("bu.user_id", $user_board_id);
        $this->db->where("bu.board_table_name", $board_no);
        $this->db->where("bv.board_table_name", $board_no);
        $this->db->where("bv.board_split_status", "no");
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() AS $row) {
            $board_serial_no = $row['board_serial_no'];
        }
        return $board_serial_no;
    }

    public function getBoardTopID($board_seriel_no, $board_no) {
        $board_top_id = 0;
        if ($board_seriel_no == 1) {
            $board_top_id = $this->getAdminId(); //take admin id directly
        } else {
            $res_b = $this->db->select("board_top_id")->where("board_no", $board_seriel_no)->where("board_table_name = ", $board_no)->get("board_view");
            foreach ($res_b->result() as $row_b) {
                $board_top_id = $row_b->board_top_id;
            }
        }
        return $board_top_id;
    }

    public function getAdminId() {
        $admin_id = '';
        $this->db->select("user_id");
        $this->db->from("login_user");
        $this->db->where("user_type", 'admin');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $admin_id = $row->user_id;
        }
        return $admin_id;
    }

    public function getUserLevel($id, $board_no) {
        $user_level = 0;
        $query = $this->db->select("user_level")->where("id", $id)->get("auto_board_$board_no");
        foreach ($query->result() as $row) {
            $user_level = $row->user_level;
        }
        return $user_level;
    }

    public function getBoardLevel($id, $board_slno, $board_no) {
        $user_level = 0;
        $this->db->select("board_level");
        $this->db->where("user_id", $id);
        $this->db->where("board_table_name", $board_no);
        $this->db->where("board_serial_no", $board_slno);
        $qr = $this->db->get("board_user_detail");
        foreach ($qr->result() as $row) {
            $user_level = $row->board_level;
        }
        return $user_level;
    }

    public function insertIntoAutoBoard($user_detail_arr, $board_no) {
        $data = array(
            "user_name" => $user_detail_arr["user_name"],
            "user_ref_id" => $user_detail_arr["user_ref_id"],
            "position" => $user_detail_arr["position"],
            "father_id" => $user_detail_arr["father_id"],
            "active" => $user_detail_arr["active"],
            "date_of_joining" => date("Y-m-d H:i:s"),
            "user_level" => $user_detail_arr["user_level"],
            "type" => $user_detail_arr["type"],
        );
        $result = $this->db->insert("auto_board_$board_no", $data);
        $insert_id = $this->db->insert_id();
        if ($result) {
            $this->updatePositionCount($user_detail_arr["father_id"], $board_no);
        }
        return $insert_id;
    }

    public function updatePositionCount($user_board_id, $board_no) {
        $this->db->set("child_count", "child_count+1", FALSE);
        $this->db->where("id", $user_board_id);
        $this->db->update("auto_board_$board_no");
    }

    public function getBoardNumberFromBoardUserDetails($user_id, $board_number) {
        $board_serial_no = 0;
        if ($user_id != 0) {
            $query = $this->db->select_max("board_serial_no")->where("user_id", "$user_id")->where("board_table_name", "$board_number")->get("board_user_detail");

            foreach ($query->result() as $row) {
                if ($row->board_serial_no != "") {
                    $board_serial_no = $row->board_serial_no;
                }
            }
        } else {
            $board_serial_no = 1;
        }

        return $board_serial_no;
    }

    public function addToBoardUserDetailRecursively($board_id, $board_no, $board_slno, $board_level = 0, $board_depth = '', $next_board_id = '') {
        $last_slno = $board_slno;
        if ($board_depth == '') {
            $board_depth = $this->BOARD_DEPTH + 1;
        }

        if ($board_depth) {
            $board_position = $this->getBoardMaxPosition($board_no, $board_slno) + 1;
            $this->addToBoardUserDetail($board_id, $board_no, $board_slno, $board_level, $board_position);
            $board_depth--;
            if ($board_depth) {
                if ($next_board_id != '') {
                    $next_board_id = $this->getBoardFatherID($next_board_id, $board_no);
                } else {
                    $next_board_id = $this->getBoardFatherID($board_id, $board_no);
                }
                if ($next_board_id) {
                    $next_board_slno = $this->getBoardNumberFromBoardUserDetails($next_board_id, $board_no);
                    $next_board_level = $board_level + 1;
                    $last_slno = $this->addToBoardUserDetailRecursively($board_id, $board_no, $next_board_slno, $next_board_level, $board_depth, $next_board_id);
                }
            }
        }
        return $last_slno;
    }

    public function getBoardMaxPosition($board_no, $board_slno) {
        $board_position = 0;
        $this->db->select_max('board_position')->where('board_table_name', $board_no)->where("board_serial_no", $board_slno);
        $query = $this->db->get('board_user_detail');

        foreach ($query->result_array() AS $row) {
            $board_position = $row['board_position'];
        }
        return $board_position;
    }

    public function addToBoardUserDetail($board_id, $board_no, $board_slno, $board_level, $board_position) {
        $curent_date = date("Y-m-d H:i:s");
        $data = array("user_id" => $board_id,
            "board_serial_no" => $board_slno,
            "date_of_join" => $curent_date,
            "board_level" => $board_level,
            "board_position" => $board_position,
            "board_table_name" => $board_no);
        $query = $this->db->insert("board_user_detail", $data);
    }

    public function getBoardFatherID($board_id, $board_no) {
        $board_father_id = 0;
        $res_set = $this->db->select("father_id")->where("id", $board_id)->get("auto_board_$board_no");
        foreach ($res_set->result() as $row) {
            $board_father_id = $row->father_id;
        }
        return $board_father_id;
    }

    public function boardTotalUserCount($board_slno, $board_no) {
        $this->db->where("board_table_name", $board_no);
        $this->db->where("board_serial_no", $board_slno);
        $this->db->from("board_user_detail");
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUserFtID($id, $board_no) {
        $user_ref_id = 0;
        $res_set = $this->db->select("user_ref_id")->where("id", $id)->get("auto_board_$board_no");
        foreach ($res_set->result() as $row) {
            $user_ref_id = $row->user_ref_id;
        }
        return $user_ref_id;
    }

    public function getUserCount($user_ref_id, $board_no) {
        $this->db->select("*")->where("user_ref_id", $user_ref_id)->from("auto_board_$board_no");
        $count = $this->db->count_all_results();
        return $count;
    }

    public function getUsernameCount($user_ref_id, $user_name, $board_no) {
        $this->db->select("*")->where('user_ref_id', $user_ref_id)->like("user_name", $user_name, 'after')->from("auto_board_$board_no");
        $count = $this->db->count_all_results();
        return $count;
    }

    public function splitUserBoard($board_top_id, $board_slno, $board_no) {
        $status = $this->updateBoardSplitStatus($board_top_id, $board_slno, $board_no);
        if ($status) {
            $max_board_slno = $this->getMaxBoardNumber($board_no);

            $child_nodes = $this->getUserChildNodes($board_top_id, $board_no);
            for ($i = 0, $new_board_slno = $max_board_slno + 1; $i < $this->BOARD_WIDTH; $i++, $new_board_slno++) {
                $child_id = $child_nodes[$i];
                $child_board_no = $this->getBoardNumberFromBoardUserDetails($child_id, $board_no);
                $this->updateBoardViewStatus($child_id, $board_no, $child_board_no);
                //$board_level = 0;
                //$this->addToBoardView($child_id, $board_no, $new_board_slno);
                //$this->addToBoardUserDetail($child_id, $board_no, $new_board_slno, $board_level);
                //$this->addUsersToBoardUserDetail($child_id, $board_no, $new_board_slno, $board_level);
            }
        }
    }

    public function updateBoardViewStatus($board_top_id, $board_no, $board_slno) {
        $this->db->set("board_view_status", 'yes');
        $this->db->where("board_top_id", $board_top_id);
        $this->db->where("board_table_name", $board_no);
        $this->db->where("board_no", $board_slno);
        $result = $this->db->update("board_view");
        return $result;
    }

    public function addToBoardView($board_top_id, $board_no, $board_slno, $split_status = "no", $view_status = "no") {
        $this->db->set("board_split_status", $split_status);
        $this->db->set("board_view_status", $view_status);
        $this->db->set("board_top_id", $board_top_id);
        $this->db->set("board_table_name", $board_no);
        $this->db->set("board_no", $board_slno);
        $this->db->set("date_of_join", date("Y-m-d H:i:s"));
        $result = $this->db->insert("board_view");
        return $result;
    }

    public function updateBoardSplitStatus($board_top_id, $board_slno, $board_no, $status = "yes") {
        $this->db->set("board_split_status", $status);
        $this->db->where("board_top_id", $board_top_id);
        $this->db->where("board_table_name", $board_no);
        $this->db->where("board_no", $board_slno);
        $result = $this->db->update("board_view");
        return $result;
    }

    public function getMaxBoardNumber($board_no) {
        $max_num = 1;
        $this->db->select_max("board_no");
        $this->db->where("board_table_name", "$board_no");
        $query = $this->db->get("board_view");
        foreach ($query->result() as $row) {
            $max_num = $row->board_no;
        }

        return $max_num;
    }

    public function getUserChildNodes($board_top_id, $board_no) {
        $child_nodes = array();
        if ($board_top_id) {
            $this->db->select('id');
            $this->db->where("father_id", $board_top_id);
            $query = $this->db->get("auto_board_$board_no");
            foreach ($query->result_array() AS $rows) {
                $child_nodes[] = $rows['id'];
            }
        }
        return $child_nodes;
    }

    public function addUsersToBoardUserDetail($board_id, $board_no, $board_slno, $board_level, $level = '') {
        if ($level == '') {
            $level = $this->BOARD_DEPTH - 1;
        }
        if ($level) {
            $level--;
            $board_level++;
            $child_nodes = $this->getUserChildNodes($board_id, $board_no);
            for ($k = 0; $k < $this->BOARD_WIDTH; $k++) {
                $child_id = $child_nodes[$k];
                $this->addToBoardUserDetail($child_id, $board_no, $board_slno, $board_level);
                if ($level) {
                    $this->addUsersToBoardUserDetail($child_id, $board_no, $board_slno, $board_level, $level);
                }
            }
        }
        return TRUE;
    }

    public function getBoardId($board_table, $user_ref_id) {
        $res = $this->db->select_max("id")->where("user_ref_id", $user_ref_id)->get("$board_table");
        foreach ($res->result() AS $row)
            return $row->id;
    }

    public function getMaximumLevelReached($level, $board_slno, $board_no) {
        $this->db->where("board_level", $level);
        $this->db->where("board_serial_no", $board_slno);
        $this->db->where("board_table_name", $board_no);
        $this->db->from("board_user_detail");
        $count = $this->db->count_all_results();
        return $count;
    }

    /**
     * @since 1.21 remove fields for deleted DB columns
     */
    public function insertInToLegAmount($user_id, $from_id, $total_amount, $board_no, $board_sl_no, $amount_type, $oc_order_id) {

        $config_arr = $this->settings_model->getSettings();
        $tds_db = $config_arr['tds'];
        $service_charge_db = $config_arr['service_charge'];
        $tds_amount = ($total_amount * $tds_db ) / 100;
        $service_charge = ($total_amount * $service_charge_db ) / 100;
        $amount_payable = $total_amount - ($tds_amount + $service_charge);

        $date_of_joining = date("Y-m-d H:i:s");
        $data = array("user_id" => $user_id,
            "from_id" => $from_id,
            "total_amount" => $total_amount,
            "amount_payable" => $amount_payable,
            "amount_type" => $amount_type,
            "date_of_submission" => $date_of_joining);

        $MODULE_STATUS = $this->trackModule();
        if ($MODULE_STATUS['opencart_status_demo'] == "yes") {
            $data["oc_order_id"] = $oc_order_id;
        }
        $result = $this->db->insert("leg_amount", $data);
        if ($result) {
            $this->updateBalanceAmount($user_id, $total_amount);
        }
    }

    public function checkAlreadyInBoard($user_name, $board_no) {
        $count = "";
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("auto_board_$board_no");
        $this->db->where('user_name', $user_name);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getUserRefIdByAutoID($id, $board_no) {
        $user_ref_id = 0;
        $res = $this->db->select("user_ref_id")->where("id", $id)->get("auto_board_$board_no");
        foreach ($res->result() as $row) {
            $user_ref_id = $row->user_ref_id;
        }
        return $user_ref_id;
    }

    public function getBoardUserID($user_id, $board_no) {
        $id = '';
        $this->db->select("id");
        $this->db->from("auto_board_$board_no");
        $this->db->where("user_ref_id", $user_id);
        $res = $this->db->get();

        foreach ($res->result() as $row) {
            $id = $row->id;
        }
        return $id;
    }

    public function getBoardCommissionType($board_no) {
        $commission_type = '';
        $this->db->select("commission_type");
        $this->db->from("board_configuration");
        $this->db->where("board_id", $board_no);
        $res = $this->db->get();

        foreach ($res->result() as $row) {
            $commission_type = $row->commission_type;
        }
        return $commission_type;
    }

    public function checkUserActive($userid) {
        $flag = FALSE;

        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("ft_individual_unilevel");
        $this->db->where("father_id", $userid);
        $qr = $this->db->get();

        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }

        if ($count >= 2)
            $flag = TRUE;

        return $flag;
    }

    public function deductUserPoints($userid, $amount) {


        $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $amount . ',2)', FALSE);
        $this->db->where('user_id', $userid);
        $up_date2 = $this->db->update('user_balance_amount');
        return $up_date2;
    }

    public function checkUserActiveInMatrix($userid) {
        $active_status = '';
        $this->db->select('user_active');
        $this->db->from('ft_individual_unilevel');
        $this->db->where('id', $userid);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $active_status = $row->user_active;
        }
        return $active_status;
    }

    public function getNewBoardPlacement($referrer_id, $board_no) {
        $board_placement = array();
        if (!$this->isBoardEmpty($board_no)) {
            if ($referrer_id) {
                if ($this->FOLLOW_SPONSOR_STATUS) {
                    if ($this->isEntryExistInBoard($referrer_id, $board_no)) {
                        $min_board_id = $this->getUserMinimumNonSplittedBoardId($board_no, $referrer_id);
                        if ($min_board_id) {
                            $board_id = $min_board_id;
                        } else {
                            $board_id = $this->getUserBoardId($board_no, $referrer_id);
                        }

                        $board_sl_no = $this->getBoardSerialNumber($board_id, $board_no);
                        $total_user_count = $this->boardTotalUserCount($board_sl_no, $board_no);
                        $board_total_count = (pow($this->BOARD_WIDTH, $this->BOARD_DEPTH + 1) - 1) / ($this->BOARD_WIDTH - 1);

                        if ($total_user_count < $board_total_count) {
                            $user["0"] = $board_id;
                            $board_placement = $this->getPosition($board_no, $user);
                        } else {
                            $flag = false;
                            $user_id_arr = array("0" => $board_id);
                            do {
                                $qr = $this->createQuery($user_id_arr, $board_no);
                                $res = $this->db->query("$qr");
                                foreach ($res->result_array() AS $row) {
                                    $referral_id = $row['id'];
                                    $temp_user_id_arr[] = $referral_id;

                                    $board_sl_no = $this->getBoardSerialNumber($referral_id, $board_no);
                                    $total_user_count = $this->boardTotalUserCount($board_sl_no, $board_no);
                                    $board_total_count = (pow($this->BOARD_WIDTH, $this->BOARD_DEPTH + 1) - 1) / ($this->BOARD_WIDTH - 1);

                                    if ($total_user_count < $board_total_count) {
                                        $user["0"] = $referral_id;
                                        $board_placement = $this->getPosition($board_no, $user);
                                        $flag = true;
                                        break;
                                    }
                                }
                                $user_id_arr = $temp_user_id_arr;
                                $temp_count = count($temp_user_id_arr);
                            } while (!$flag && $temp_count);

                            if (!$flag) {
                                $board_placement = $this->getBoardPlacementPosition($board_no);
                            }
                        }
                    } else {
                        $sponsor_id = $this->getSponsorID($referrer_id);
                        if ($sponsor_id) {
                            $board_placement = $this->getNewBoardPlacement($sponsor_id, $board_no);
                        } else {
                            $board_placement = $this->getBoardPlacementPosition($board_no);
                        }
                    }
                } else {//AUTO FILL
                    $board_placement = $this->getBoardPlacementPosition($board_no);
                }
            } else {//AUTO FILL
                $board_placement = $this->getBoardPlacementPosition($board_no);
            }
        } else {
            $board_placement["id"] = '0';
            $board_placement["position"] = '';
        }
        return $board_placement;
    }

    public function getPosition($board_no, $downlineuser) {
        $p = 0;
        $child_arr = "";
        for ($i = 0; $i < count($downlineuser); $i++) {
            $sponsor_id = $downlineuser["$i"];
            $this->db->select("*");
            $this->db->from("auto_board_$board_no");
            $this->db->where('father_id', $sponsor_id);
            $res = $this->db->get();
            $row_count = $res->num_rows();
            if ($row_count > 0) {
                foreach ($res->result_array() as $row) {
                    $width_ceiling = $this->BOARD_WIDTH;
                    if ($row_count < $width_ceiling) {
                        $sponsor['father_id'] = $sponsor_id;
                        $sponsor['position'] = $row_count + 1;
                        return $sponsor;
                    } else {
                        $child_arr[$p] = $row["id"];
                        $p++;
                    }
                }
            } else {
                $sponsor['father_id'] = $sponsor_id;
                $sponsor['position'] = 1;
                return $sponsor;
            }
        }

        if (count($child_arr) > 0) {
            $position = $this->getPosition($board_no, $child_arr);
            return $position;
        }
    }

    public function createQuery($user_id_arr, $board_no) {
        $ft_individual = $this->db->dbprefix . "auto_board_$board_no";
        $arr_len = count($user_id_arr);
        for ($i = 0; $i < $arr_len; $i++) {
            $user_id = $user_id_arr[$i];
            if ($i == 0) {
                $where_qr = "father_id = '$user_id'";
            } else {
                $where_qr .= " OR father_id = '$user_id'";
            }
        }
        $qr = "Select * from $ft_individual where ($where_qr) and active NOT LIKE 'server'  ";

        return $qr;
    }

    public function getBoardSerialNumber($board_id, $board_no) {
        $board_serial_number = 0;
        $this->db->select('board_no');
        $this->db->where('board_table_name', $board_no);
        $this->db->where('board_top_id', $board_id);
        $query = $this->db->get('board_view');
        foreach ($query->result_array() AS $row) {
            $board_serial_number = $row['board_no'];
        }
        return $board_serial_number;
    }

    public function getSponsorID($user_id) {
        $sponsor_id = '';
        $this->db->select('user_details_ref_user_id');
        $this->db->from("user_details");
        $this->db->where('user_detail_refid ', $user_id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sponsor_id = $row->user_details_ref_user_id;
        }
        return $sponsor_id;
    }

    public function updateBalanceAmount($user_id, $total_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount +' . $total_amount . ',2)', FALSE);
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $res = $this->db->update('user_balance_amount');

        return $res;
    }

    public function IdToUserNameBoard($board_user_ref_id, $board_no) {
        if ($board_user_ref_id > 0) {
            $user_name = NULL;
            $query = $this->db->select("user_name")->where("user_ref_id", $board_user_ref_id)->order_by('id', 'ASC')->limit(1)->get("auto_board_$board_no");
            foreach ($query->result() as $row) {
                $user_name = $row->user_name;
            }
            return $user_name;
        } else {
            return "NA";
        }
    }

}
