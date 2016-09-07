<?php

require_once ("get_tree_model.php");
require_once ("tree_view_model.php");
require_once 'tooltip_view_model.php';
require_once 'tabular_tree_class_model.php';
require_once ("validation_model.php");

class tree_model extends inf_model {

    public $OBJ_TREE_VIEW;
    public $OBJ_GET_TREE;
    public $OBJ_VAL;
    public $OBJ_AUTH;
    public $obj_tooltip;
    public $board_view;
    public $auto_filling;
    public $obj_tabular_tree;
    public $board_array = array();
    public $board_tooltip_array = array();
    public $tree_array = array();
    public $tree_tooltip_array = array();
    public $display_tree = "";

    function __construct() {
        parent::__construct();

        $this->OBJ_TREE_VIEW = new tree_view_model();
        $this->OBJ_GET_TREE = new get_tree_model();
        $this->OBJ_VAL = new validation_model();
        $this->obj_tooltip = new tooltip_view_model();
        $this->obj_tabular_tree = new tabular_tree_class_model();

        if ($this->MLM_PLAN == "Board") {
            require_once 'boardview_model.php';
            $this->board_view = new boardview_model();
            $this->load->model("auto_board_filling_model");
        }
    }

    public function viewTree($id_decrypt) {
        $this->OBJ_TREE_VIEW->addtomatrix($id_decrypt, 1, 0);
        $matrix = $this->OBJ_TREE_VIEW->balancematrix();
        return $matrix;
    }

    public function getAllUserToolTipArray() {
        return $this->OBJ_TREE_VIEW->Tooltip_Array;
    }

    public function viewSponsorTree($id_decrypt) {
        $this->OBJ_TREE_VIEW->addtomatrixUnilevel($id_decrypt, 1, 0);
        $matrix = $this->OBJ_TREE_VIEW->balancematrixsponser();
        return $matrix;
    }

    public function viewTreeBoard($user_id, $id_decrypt, $board_id) {
        $this->OBJ_TREE_VIEW->addtoBoardMatrix($id_decrypt, 1, 0, $board_id);
        $this->OBJ_TREE_VIEW->checkBoardMatrix($board_id);
        $matrix = $this->OBJ_TREE_VIEW->balancematrix($board_id);
        return $matrix;
    }

    public function userDownlineUserUnilevel($child_id, $user_id) {
        $this->intitailze();

        $user_id = $this->OBJ_GET_TREE->userDownlineUserUnilevel($child_id, $user_id);
        return $user_id;
    }

    public function userDownlineUser($child_id, $user_id) {

        $this->intitailze();
        $user_id = $this->OBJ_GET_TREE->userDownlineUser($child_id, $user_id);
        return $user_id;
    }

    public function getUserDetails($id, $table_name = '') {

        $user_details = $this->obj_tooltip->getUserDetails($id, $table_name);
        return $user_details;
    }

    public function getSponserDetails($id) {

        $user_details = $this->obj_tooltip->getUserDetail($id);
        return $user_details;
    }

    public function getToolTip($user_detail, $plan, $board_no = 1) {

        $tootip = '';
        if ($plan == 'Board') {
            $tootip = $this->obj_tooltip->getBoardToolTip($user_detail, $board_no);
        } else {
            $tootip = $this->obj_tooltip->getToolTip($user_detail);
        }
        return $tootip;
    }

    public function getSponserToolTip($user_detail) {

        $tootip = '';
        $tootip = $this->obj_tooltip->getSponserToolTip($user_detail);
        return $tootip;
    }

    public function getUserDetailss($id) {
        $user_details = $this->obj_tooltip->getUserDetail($id);
        return $user_details;
    }

    function createChildren($id, $recursive = false) {
        return $this->obj_tabular_tree->createChildren($id);
    }

    function getUserFullName($user_id) {
        return $this->obj_tabular_tree->getUserFullName($user_id);
    }

    function getChildren($data) {
        return $this->obj_tabular_tree->getChildren($data);
    }

    public function getUserId($user_name) {
        return $this->obj_tabular_tree->getUserId($user_name);
    }

    public function getDecryptID($id) {
        return $this->OBJ_TREE_VIEW->getDecrypt($id);
    }

    public function getUserRefIdByAutoID($id, $goc_table_name) {
        $user_ref_id = 0;
        $res = $this->db->select("user_ref_id")->where("id", $id)->get("$goc_table_name");
        foreach ($res->result() as $row) {

            $user_ref_id = $row->user_ref_id;
        }
        return $user_ref_id;
    }

    public function getMyBoardIDs($ft_userid, $board_no) {
        return $this->board_view->getMyBoardIDs($ft_userid, $board_no);
    }

    public function getBoardNumberFromBoardUserDetails($user_id, $board_number) {

        $board_seriel_no = 0;
        if ($user_id != 0) {
            $query = $this->db->select_max("board_serial_no")->where("user_id", "$user_id")->where("board_table_name", "$board_number")->get("board_user_detail");

            foreach ($query->result() as $row) {
                if ($row->board_serial_no != "") {
                    $board_seriel_no = $row->board_serial_no;
                }
            }
        } else {
            $board_seriel_no = 1;
        }
        return $board_seriel_no;
    }

    public function getBoardFullName($id, $board_no) {
        $auto_goc_table_name = $this->table_prefix . "auto_board_" . $board_no;
        $this->db->select('user_ref_id');
        $this->db->from($auto_goc_table_name);
        $this->db->where('id', $id);
        $res_set = $this->db->get();

        foreach ($res_set->result() as $row) {
            $user_name = $row->user_ref_id;
            $full_name = $this->OBJ_VAL->getUserFullName($user_name);
        }
        return $full_name;
    }

    public function getRefCountAndCheck($user_ref_id, $board_no, $user_board_serial_number = '') {

        $refer_count = 0;
        $qry = $this->db->select("referral_count")->where("user_ref_id", $user_ref_id)->where("board_no", $board_no)->limit(1)->get("board_referral_count");
        foreach ($qry->result_array() AS $row) {
            $refer_count = $row['referral_count'];
        }

        return $refer_count;
    }

    public function getUplineBoardID($board_id, $board_no) {
        $res = $this->db->select("father_id")->where("id", $board_id)->get("auto_board_" . $board_no);
        foreach ($res->result() AS $row) {
            return $row->father_id;
        }
    }

    public function getRefferenceID($id, $auto_goc_table_name, $user_board_serial_number) {

        $board_split_query = '';
        if ($auto_goc_table_name == "auto_board_1_backup" || $auto_goc_table_name == "auto_board_2_backup") {
            $board_split_query = " AND board_serial_no=$user_board_serial_number";
        }

        $this->db->select("user_ref_id");
        $this->db->where("id =$id $board_split_query");
        $res = $this->db->get("$auto_goc_table_name");
        foreach ($res->result() as $row) {
            $user_ref_id = $row->user_ref_id;
        }

        return $user_ref_id;
    }

    public function getDirectRefID($user_id) {

        $user_details = "user_details";
        $this->db->select('user_details_ref_user_id');
        $this->db->from($user_details);
        $this->db->where('user_detail_refid', $user_id);
        $res = $this->db->get();
        foreach ($res->result() AS $row) {
            return $row->user_details_ref_user_id;
        }
    }

    public function getFirstSecondThirdUserId($user_id, $board_table_name = "auto_board_1") {
        $arr = array();

        $this->db->select("id,user_ref_id,position")->where("father_id", $user_id);
        $this->db->order_by("position", "asc");
        $res = $this->db->get("$board_table_name");
        foreach ($res->result_array() AS $row) {
            $position = $row['position'];
            $id = $row['id'];

            if ($position == 1) {
                $arr['first_id'] = $id;
            } else
            if ($position == 2) {
                $arr['second_id'] = $id;
            }
        }
        return $arr;
    }

    public function callToSetConfig($id) {
        return $this->OBJ_TREE_VIEW->set_config($id);
    }

    public function getGraphWidth($tree_array) {
        $max_col = $tree_array[1][1]["max_col"];
        $max_graphwidth = ($max_col) * TREE_BOX_WIDTH;

        $graphwidth = ($max_graphwidth > MIN_TREE_WIDTH) ? $max_graphwidth : MIN_TREE_WIDTH;

        return $graphwidth;
    }

    public function getFather($user_id) {
        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        $row = $query_parent->row_array();
        $root = $row["sponsor_id"];
        return $root;
    }

    public function getFtFather($user_id) {
        $this->db->select('father_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        $row = $query_parent->row_array();
        $root = $row["father_id"];
        return $root;
    }

    public function getUserBoard($user_board_id, $board_no) {
        $this->auto_board_filling_model->setBoardWidthAndDepth($board_no);
        $board_width = $this->auto_board_filling_model->BOARD_WIDTH;
        $board_depth = $this->auto_board_filling_model->BOARD_DEPTH;
        $board_slno = $this->auto_board_filling_model->getBoardNumberFromBoardUserDetails($user_board_id, $board_no);
        $board_top_id = $this->auto_board_filling_model->getBoardTopID($board_slno, $board_no);


        $this->getAllBoardUsers($board_top_id, $board_slno, $board_no, $board_width, $board_depth);
        $board_arr['board_users'] = $this->board_array;
        $board_arr['board_depth'] = $board_depth;
        $board_arr['board_width'] = $board_width;
        return $board_arr;
    }

    public function getAllBoardUsers($board_id, $board_slno, $board_no, $board_width, $board_depth, $level = 0, $order = 0) {

        if ($level == 0) {
            $level = $board_depth;
            $this->board_array[$level][$order]['id'] = $board_id;
            $this->board_array[$level][$order]['user_name'] = $this->OBJ_VAL->IdToUserNameBoard($board_id, $board_no);

            $user_id = $this->validation_model->getUserIDByBoardID($board_id, $board_no);
            $ft_user_details = $this->validation_model->getUserFTDetails($user_id);
            $user_details = $this->validation_model->getAllUserDetails($user_id);
            $referral_count = $this->validation_model->getUserReferralCount($user_id);
            $tooltip_array = array(
                "user_id" => $this->board_array[$level][$order]['id'],
                "user_name" => $this->board_array[$level][$order]['user_name'],
                "date_of_joining" => $ft_user_details["date_of_joining"],
                "user_photo" => $user_details["user_photo"],
                "full_name" => $user_details ['user_detail_name'] . " " . $user_details["user_detail_second_name"],
                "referral_count" => $referral_count
            );
            $MODULE_STATUS = $this->trackModule();
            if ($MODULE_STATUS['rank_status'] == "yes" && $ft_user_details['user_rank_id']) {
                $tooltip_array["user_rank"] = $this->validation_model->getRankName($ft_user_details['user_rank_id']);
            } else {
                $tooltip_array["user_rank"] = "NA";
            }
            $this->board_tooltip_array[] = $tooltip_array;
        }
        if ($level) {
            $level--;
            $child_nodes = $this->auto_board_filling_model->getUserChildNodes($board_id, $board_no);

            for ($k = 0; $k < $board_width; $k++) {
                $child_id = 0;
                $user_name = "NA";
                if (array_key_exists($k, $child_nodes)) {
                    $child_id = $child_nodes[$k];
                    $user_name = $this->OBJ_VAL->IdToUserNameBoard($child_id, $board_no);

                    $user_id = $this->validation_model->getUserIDByBoardID($child_id, $board_no);
                    $ft_user_details = $this->validation_model->getUserFTDetails($user_id);
                    $user_details = $this->validation_model->getAllUserDetails($user_id);
                    $referral_count = $this->validation_model->getUserReferralCount($user_id);
                    $tooltip_array = array(
                        "user_id" => $child_id,
                        "user_name" => $user_name,
                        "date_of_joining" => $ft_user_details["date_of_joining"],
                        "user_photo" => $user_details["user_photo"],
                        "full_name" => $user_details ['user_detail_name'] . " " . $user_details["user_detail_second_name"],
                        "referral_count" => $referral_count
                    );
                    $MODULE_STATUS = $this->trackModule();
                    if ($MODULE_STATUS['rank_status'] == "yes" && $ft_user_details['user_rank_id']) {
                        $tooltip_array["user_rank"] = $this->validation_model->getRankName($ft_user_details['user_rank_id']);
                    } else {
                        $tooltip_array["user_rank"] = "NA";
                    }
                    $this->board_tooltip_array[] = $tooltip_array;
                }
                $order++;
                $this->board_array[$level][$order]['id'] = $child_id;
                $this->board_array[$level][$order]['user_name'] = $user_name;


                if ($level) {
                    $order = $this->getAllBoardUsers($child_id, $board_slno, $board_no, $board_width, $board_depth, $level, $order);
                }
            }
        }
        return $order;
    }

    public function userDownlineUserBoard($child_id, $user_id, $board_id) {
        $user_id = $this->OBJ_GET_TREE->userDownlineUserBoard($child_id, $user_id, $board_id);
        return $user_id;
    }

    public function getUserDetailsBoard($id, $board_id) {
        $user_details = $this->obj_tooltip->getUserDetailBoard($id, $board_id);
        return $user_details;
    }

    public function getToolTipBoard($user_detail, $board_id) {
        $tootip = $this->obj_tooltip->getToolTipBoard($user_detail, $board_id);
        return $tootip;
    }

    public function getUserLeftAndRight($user_id, $type) {
        $this->db->select("left_$type, right_$type");
        $this->db->where('id', $user_id);
        $result = $this->db->get('ft_individual');
        $result = $result->result_array();
        return $result[0];
    }

    public function getAllTreeUsers($user_id, $type = "tree") {
        $this->display_tree = '<ul id="tree_view" style="display:none">';
        if ($type == "tree") {
            $this->getDisplayTree($user_id);
        } else if ($type == "sponsor_tree") {
            $this->getDisplaySponsorTree($user_id);
        }
        $this->display_tree .= '</ul>';
    }

    public function getDisplayTree($user_id, $level = 0) {

        if ($level < 5) {

            $tree_user_detail = $this->getTreeUserDeatils($user_id);

            $user_name = $tree_user_detail["user_name"];
            $user_active = $tree_user_detail["active"];
            $father_id = $tree_user_detail["father_id"];
            $father_id_encrypt = $tree_user_detail["father_id_encrypt"];
            $user_position = $tree_user_detail["position"];
            $product_id = $tree_user_detail["product_id"];

            $user_icon_link = $this->getUserIconAndLink($user_id, $user_name, $user_active, $father_id, $father_id_encrypt, $user_position, $level,$product_id);

            $user_icon = $user_icon_link["icon"];
            $user_link = $user_icon_link["link"];
            $user_up_link = $user_icon_link["up_link"];
            $user_text = $user_icon_link["text"];

            $user_up_link_image = ($user_up_link != '') ? '<a href="javascript:void(0)"><img width="16px" height="16px" border="0" src="' . base_url() . '/public_html/images/up.png" ' . $user_up_link . '></a><br>' : '';

            $user_onclick_link = ($user_active != "server") ? 'onclick=\'getGenologyTree("' . $user_id . '",event);\'' : '';

            $this->display_tree .= '<li>'
                    . $user_up_link_image
                    . '<a href="' . $user_link . '" id="level-' . $level . '">'
                    . '<img src="' . $user_icon . '" alt="' . $user_text . '" id= "userlink' . $user_id . '" ' . $user_onclick_link . '/>'
                    . '<br>' . $user_text . ''
                    . '</a>';

            $child_nodes = $this->getUserChildNodes($user_id);

            $child_count = count($child_nodes);

            if ($child_count) {
                $new_level = $level + 1;
                if ($new_level < 5) {
                    $this->display_tree .= '<ul>';
                    for ($k = 0; $k < $child_count; $k++) {
                        $child_id = $child_nodes[$k];
                        $this->getDisplayTree($child_id, $new_level);
                    }
                    $this->display_tree .= '</ul>';
                }
            }
            $this->display_tree .= '</li>';
        }
        return $this->tree_array;
    }

    public function getTreeUserDeatils($user_id) {

        $ft_user_details = $this->validation_model->getUserFTDetails($user_id);
        $user_details = $this->validation_model->getAllUserDetails($user_id);

        $tree_user_detail["user_id"] = $user_id;

        $tree_user_detail["user_name"] = $ft_user_details["user_name"];

        $tree_user_detail["active"] = $ft_user_details["active"];

        $tree_user_detail["position"] = $ft_user_details["position"];

        $tree_user_detail["father_id"] = $ft_user_details["father_id"];

        $tree_user_detail["product_id"] = $ft_user_details["product_id"];

        $tree_user_detail["father_id_encrypt"] = $this->OBJ_TREE_VIEW->getEncrypt($ft_user_details["father_id"]);

        $tree_user_detail["sponsor_id"] = $ft_user_details["sponsor_id"];

        $tree_user_detail["sponsor_id_encrypt"] = $this->OBJ_TREE_VIEW->getEncrypt($ft_user_details["sponsor_id"]);

        if ($ft_user_details["active"] != "server") {
            $tooltip_array = array(
                "user_id" => $user_id,  
                "user_name" => $ft_user_details["user_name"],
                "date_of_joining" => $ft_user_details["date_of_joining"]
            );
            if ($user_details) {
                $tooltip_array["user_photo"] = $user_details["user_photo"];
                $tooltip_array["full_name"] = $user_details ['user_detail_name'] . " " . $user_details["user_detail_second_name"];
                if(!$user_details ['user_detail_name']){
                    $tooltip_array["full_name"]='NA';
                }
                
                $MODULE_STATUS = $this->trackModule();
                if ($MODULE_STATUS['mlm_plan'] == "Binary") {
                    $leg_arr = $this->OBJ_TREE_VIEW->getLegLeftRightCount($user_id);
                    $tooltip_array["left"] = $leg_arr['total_left_count'];
                    $tooltip_array["left_carry"] = $leg_arr['total_left_carry'];
                    $tooltip_array["right"] = $leg_arr['total_right_count'];
                    $tooltip_array["right_carry"] = $leg_arr['total_right_carry'];
                }
                if ($MODULE_STATUS['rank_status'] == "yes" && $ft_user_details['user_rank_id']) {
                    $tooltip_array["user_rank"] = $this->validation_model->getRankName($ft_user_details['user_rank_id']);
                } else {
                    $tooltip_array["user_rank"] = "NA";
                }
            } else {
                $tooltip_array["user_photo"] = "NA";
                $tooltip_array["full_name"] = "NA";
                $tooltip_array["user_rank"] = "NA";
            }
            $this->tree_tooltip_array[] = $tooltip_array;
        }
        return $tree_user_detail;
    }

    public function getUserChildNodes($user_id, $type = "tree") {
        $child_nodes = array();
        if ($user_id) {
            $this->db->select('id');
            if ($type == "sponsor_tree") {
                $this->db->where("sponsor_id", $user_id);
                $this->db->where("active !=", "server");
            } else {
                $this->db->where("father_id", $user_id);
            }
            $query = $this->db->get("ft_individual");
            foreach ($query->result_array() AS $rows) {
                $child_nodes[] = $rows['id'];
            }
        }
        return $child_nodes;
    }

    /**
     * That's cool ... hardcode
     */
    public function getUserIconAndLink($user_id, $user_name, $user_active, $father_id, $father_id_encrypt, $user_position, $level, $product_id) {
        $image_path = base_url() . "public_html/images/";
        $user_icon = "outline1.png";
        $user_link = "javascript:void(0)";
        $user_up_link = "";
        $user_text = ($user_active != "server") ? $user_name : '';
        if($user_name=='admin'){
            $user_text='SWISSCOIN';
        }
        switch ($user_active) {
            case "yes":
                $user_icon = "active.png";
                if (!$level && $user_id == $this->LOG_USER_ID) {
                    $user_icon = "active-admin.png";
                }
                if ($product_id) {
                    switch ($product_id) {
                        case 1:
                            $user_icon = "rookie.png";
                            break;
                        case 2:
                            $user_icon = "trainee.png";
                            break;
                        case 3:
                            $user_icon = "tester-50.png";
                            break;
                        case 4:
                            $user_icon = "tester-100.png";
                            break;
                        case 5:
                            $user_icon = "tester-250.png";
                            break;
                        case 6:
                            $user_icon = "trader-500.png";
                            break;
                        case 7:
                            $user_icon = "trader-1000.png";
                            break;
                        case 8:
                            $user_icon = "crypto-trader.png";
                            break;
                        case 9:
                            $user_icon = "crypto-maker.png";
                            break;
                        case 10:
                            $user_icon = "crypto-broker.png";
                            break;
                        case 11:
                            $user_icon = "crypto-manager.png";
                            break;
                        case 12:
                            $user_icon = "crypto-director.png";
                            break;
                    }
                }
                break;
            case "no":
                $user_icon = "outline1.png";
                break;
            case "terminated":
                $user_icon = "terminate.png";
                break;
            case "server":
//                $user_icon = "add.png";
                $user_icon = "add_disabled.png";
                
                if (!$this->FROM_MOBILE) {
                    $MODULE_STATUS = $this->trackModule();
                    if ($MODULE_STATUS['mlm_plan'] == "Unilevel") {
                        if ($father_id == $this->LOG_USER_ID) {
//                            $user_link = base_url() . "register/user_register/$father_id_encrypt/$user_position";
                            $user_link = 'javascript:void(0)';
                        } else {
                            $user_icon = "add_disabled.png";
                            $user_link = "javascript:void(0)";
                            $user_text = '';
                        }
                    } else {
//                        $user_link = base_url() . "register/user_register/$father_id_encrypt/$user_position";
                        $user_link = 'javascript:void(0)';
                    }
                } else {
                    $user_text = '';
                }
                break;
            default :
                $user_icon = "outline1.png";
        }

        if ($user_id != $this->LOG_USER_ID) {
            $user_up_link = 'onclick=\'getGenologyTree("' . $father_id . '",event);\'';
        }

        $user_icon_link = array("icon" => $image_path . $user_icon, "link" => $user_link, "up_link" => $user_up_link, "text" => $user_text);
        return $user_icon_link;
    }

    public function getDisplaySponsorTree($user_id, $level = 0) {

        if ($level < 5) {

            $tree_user_detail = $this->getTreeUserDeatils($user_id);

            $user_name = $tree_user_detail["user_name"];
            $user_active = $tree_user_detail["active"];
            $father_id = $tree_user_detail["sponsor_id"];
            $father_id_encrypt = $tree_user_detail["sponsor_id_encrypt"];
            $user_position = $tree_user_detail["position"];
            $product_id = $tree_user_detail["product_id"];

            $user_icon_link = $this->getUserIconAndLink($user_id, $user_name, $user_active, $father_id, $father_id_encrypt, $user_position, $level, $product_id);

            $user_icon = $user_icon_link["icon"];
            $user_link = $user_icon_link["link"];
            $user_up_link = $user_icon_link["up_link"];
            $user_text = $user_icon_link["text"];

            $user_up_link_image = ($user_up_link != '') ? '<a href="javascript:void(0)"><img width="16px" height="16px" border="0" src="' . base_url() . '/public_html/images/up.png" ' . $user_up_link . '></a><br>' : '';

            $user_onclick_link = ($user_active != "server") ? 'onclick=\'getGenologyTree("' . $user_id . '",event);\'' : '';

            $this->display_tree .= '<li>'
                    . $user_up_link_image
                    . '<a href="' . $user_link . '" id="level-' . $level . '">'
                    . '<img src="' . $user_icon . '" alt="' . $user_text . '" id= "userlink' . $user_id . '" ' . $user_onclick_link . '/>'
                    . '<br>' . $user_text . ''
                    . '</a>';

            $child_nodes = $this->getUserChildNodes($user_id, "sponsor_tree");

            $child_count = count($child_nodes);

            if ($child_count) {
                $new_level = $level + 1;
                if ($new_level < 5) {
                    $this->display_tree .= '<ul>';
                    for ($k = 0; $k < $child_count; $k++) {
                        $child_id = $child_nodes[$k];
                        $this->getDisplaySponsorTree($child_id, $new_level);
                    }
                    $this->display_tree .= '</ul>';
                }
            }
            $this->display_tree .= '</li>';
        }
        return $this->tree_array;
    }

}
