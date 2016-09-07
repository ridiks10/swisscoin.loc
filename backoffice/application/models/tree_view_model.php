<?php

require_once ('get_tree_model.php');

class tree_view_model extends inf_model {

    public $GRAPH_WIDTH;
    public $MATRIX;
    public $MAX_LEVEL;
    public $MAX_COL;
    public $POINT;
    public $Tooltip_Array;

    function __construct() {
        parent::__construct();
        $this->obj_tree = new get_tree_model();
        $this->Tooltip_Array = array();
    }

    function addtomatrix($id, $level, $parent) {

        # GET POSITION IN MATRIX
        if (!isset($this->MATRIX[$level][0])) {
            $this->MATRIX[$level][0] = 0;
        }
        $this->MATRIX[$level][0] ++;

        $column = $this->MATRIX[$level][0];

        # SET MAXCOL AND MAXLEVEL

        if ($column > $this->MAX_COL) {
            $this->MAX_COL = $column;
        }
        if ($level > $this->MAX_LEVEL) {
            $this->MAX_LEVEL = $level;
        }
        # RECURSIVITY AIRBAG

        if ($level > TREE_LEVEL) {
            return;
        }
        $this->db->select('*');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $member) {

            # ADD TO MATRIX

            $this->MATRIX[$level][$column]["id"] = $id;

            $this->MATRIX[$level][$column]["name"] = $member->user_name;

            $this->MATRIX[$level][$column]["parent"] = $parent;

            $this->MATRIX[$level][$column]["active"] = $member->active;

            $this->MATRIX[$level][$column]["position"] = $member->position;

            $this->MATRIX[$level][$column]["father_id"] = $member->father_id;

            $this->MATRIX[$level][$column]["father_id_encrypt"] = $this->getEncrypt($member->father_id);

            $this->MATRIX[$level][$column]["sponsor_id"] = $member->sponsor_id;

            $this->MATRIX[$level][$column]["sponsor_id_encrypt"] = $this->getEncrypt($member->sponsor_id);

            if ($member->active != 'server') {
                $Tooltip_Array = array('user_id' => $member->id,
                    'user_name' => $member->user_name,
                    'date_of_joining' => $member->date_of_joining);

                $user_details = $this->validation_model->getAllUserDetails($member->id);
                $Tooltip_Array['full_name'] = $user_details ['user_detail_name'] . " " . $user_details["user_detail_second_name"];
                $Tooltip_Array['user_photo'] = $user_details['user_photo'];

                $MODULE_STATUS = $this->trackModule();
                if ($MODULE_STATUS['mlm_plan'] == "Binary") {
                    $leg_arr = $this->getLegLeftRightCount($member->id);
                    $Tooltip_Array["left"] = $leg_arr['total_left_count'];
                    $Tooltip_Array["left_carry"] = $leg_arr['total_left_carry'];
                    $Tooltip_Array["right"] = $leg_arr['total_right_count'];
                    $Tooltip_Array["right_carry"] = $leg_arr['total_right_carry'];
                }

                if ($MODULE_STATUS['rank_status'] == "yes" && $member->user_rank_id) {
                    $Tooltip_Array["user_rank"] = $this->validation_model->getRankName($member->user_rank_id);
                } else {
                    $Tooltip_Array["user_rank"] = "NA";
                }
                $this->Tooltip_Array[] = $Tooltip_Array;
            }


            # GET CHILDREN
            $this->db->select('id');
            $this->db->from('ft_individual');
            $this->db->where('father_id', $id);
            if ($this->MLM_PLAN == "Binary") {
                $this->db->order_by("position", "asc");
            } else {
                $this->db->order_by("order_id", "asc");
            }
            $query_ch = $this->db->get();
            foreach ($query_ch->result() as $member_ch) {
                $this->addtomatrix($member_ch->id, $level + 1, $id);
            }
        }
    }

    function balancematrix() {

        # ASSIGN WEIGHT TO EACH PARENT
        for ($level = $this->MAX_LEVEL; $level >= 1; $level--) {
            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                $weight = 0;
                if ($level == $this->MAX_LEVEL) {
                    $this->MATRIX[$level][$column]["weight"] = 1;
                } else {

                    for ($col = 1; $col <= $this->MAX_COL; $col++) {

                        if (isset($this->MATRIX[$level] [$column]) || isset($this->MATRIX[$level + 1][$column])) {

                            if (isset($this->MATRIX[$level + 1][$col]["parent"]) && isset($this->MATRIX[$level] [$column]["id"]) && ($this->MATRIX[$level + 1][$col]["parent"] == $this->MATRIX[$level][$column]["id"])) {

                                $weight = $weight + $this->MATRIX[$level + 1][$col]["weight"];
                            } /* else if (isset($this->MATRIX[$level][$column]["active"]) && $this->MATRIX[$level][$column]["active"] == 'server') {
                              $weight = $weight + $this->MATRIX[$level + 1][$col]["weight"];
                              } */
                        }
                    }
                }

                $this->MATRIX[$level][$column]["children"] = $weight;
                if ($weight == 0) {
                    $weight = 1;
                }
                $this->MATRIX[$level][$column]["weight"] = $weight;
            }
        }
        # DEFINE X COORDINATES

        $this->MATRIX[1][1]["x"] = .5;
        $this->MATRIX[1][1]["max_level"] = $this->MAX_LEVEL;
        $this->MATRIX[1][1]["max_col"] = $this->MAX_COL;

        $this->MATRIX[1][1] ["width"] = 1;

        for ($level = 2; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                if (isset($this->MATRIX[$level][$column]["id"])) {

                    $parentweight = 1;
                    $parentwidth = 1;
                    $parentx = 1;

                    for ($col = 1; $col <= $this->MAX_COL; $col++) {

                        if (isset($this->MATRIX[$level - 1][$col]["id"]) && isset($this->MATRIX[$level][$column] ["parent"]) && ($this->MATRIX[$level - 1][$col]["id"] == $this->MATRIX[$level][$column]["parent"])) {

                            $parentweight = $this->MATRIX[$level - 1][$col]["weight"];

                            $parentwidth = $this->MATRIX[$level - 1][$col]["width"];

                            $parentx = $this->MATRIX[$level - 1][$col]["x"];
                        }
                    }

                    $mywidth = ( $this->MATRIX[$level] [$column]["weight"] / $parentweight) * $parentwidth;

                    # IF I AM NOT THE FIRST CHILD, CALCULATE LEFT EDGE

                    if ($this->MATRIX[$level][$column - 1]["parent"] != $this->MATRIX[$level][$column]["parent"]) {

                        $myleftedge = $parentx - ($parentwidth / 2);
                    } else {

                        $myleftedge = $this->MATRIX[$level][$column - 1]["x"] + ( $this->MATRIX[$level][$column - 1]["width"] / 2);
                    }

                    $myx = $myleftedge + ($mywidth / 2);

                    $this->MATRIX[$level][$column]["width"] = $mywidth;

                    $this->MATRIX[$level][$column]["x"] = $myx;
                } else {

                    $column = 9999;
                }
            }
        }

        return $this->MATRIX;
    }

    function addtomatrixUnilevel($id, $level, $parent) {

# GET POSITION IN MATRIX

        if (!isset($this->MATRIX[$level][0])) {
            $this->MATRIX[$level][0] = 0;
        }
        $this->MATRIX[$level][0] ++;

        $column = $this->MATRIX[$level][0];


# SET MAXCOL AND MAXLEVEL

        if ($column > $this->MAX_COL) {
            $this->MAX_COL = $column;
        }

        if ($level > $this->MAX_LEVEL) {
            $this->MAX_LEVEL = $level;
        }

# RECURSIVITY AIRBAG

        if ($level > TREE_LEVEL) {
            return;
        }
        $this->db->select('*');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $member) {

# ADD TO MATRIX

            $this->MATRIX[$level][$column]["id"] = $id;

            $this->MATRIX[$level][$column]["name"] = $member->user_name;

            $this->MATRIX[$level][$column]["parent"] = $parent;

            $this->MATRIX[$level][$column]["active"] = $member->active;

            $this->MATRIX[$level][$column]["position"] = $member->position;

            $this->MATRIX[$level][$column]["father_id"] = $member->father_id;

            $this->MATRIX[$level][$column]["father_id_encrypt"] = $this->getEncrypt($member->father_id);

            $this->MATRIX[$level][$column]["sponsor_id"] = $member->sponsor_id;

            $this->MATRIX[$level][$column]["sponsor_id_encrypt"] = $this->getEncrypt($member->sponsor_id);

            if ($member->active != 'server') {
                $Tooltip_Array = array('user_id' => $member->id,
                    'user_name' => $member->user_name,
                    'date_of_joining' => $member->date_of_joining);

                $user_details = $this->validation_model->getAllUserDetails($member->id);
                $Tooltip_Array['full_name'] = $user_details ['user_detail_name'] . " " . $user_details["user_detail_second_name"];
                $Tooltip_Array['user_photo'] = $user_details['user_photo'];

                $this->Tooltip_Array[] = $Tooltip_Array;
            }

# GET CHILDREN

            $this->db->select('id');
            $this->db->from('ft_individual');
            $this->db->where('sponsor_id', $id);
            $this->db->order_by("order_id", "asc");
            $query_ch = $this->db->get();

            foreach ($query_ch->result() as $member_ch) {
                $this->addtomatrixUnilevel($member_ch->id, $level + 1, $id);
            }
        }
    }

    function balancematrixsponser() {

        # ASSIGN WEIGHT TO EACH PARENT
        for ($level = $this->MAX_LEVEL; $level >= 1; $level--) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                $weight = 0;
                if ($level == $this->MAX_LEVEL) {

                    $this->MATRIX[$level][$column]["weight"] = 1;
                } else {


                    for ($col = 1; $col <= $this->MAX_COL; $col++) {
                        if (isset($this->MATRIX[$level] [$column]) || isset($this->MATRIX[$level + 1][$column])) {
                            if (isset($this->MATRIX[$level][$column] ["id"]) && isset($this->MATRIX[$level + 1][$col] ["parent"]) && ($this->MATRIX[$level + 1][$col]["parent"] == $this->MATRIX[$level][$column]["id"])) {

                                $weight = $weight + $this->MATRIX[$level + 1][$col]["weight"];
                            }
                        }
                    }
                }

                $this->MATRIX[$level][$column]["children"] = $weight;

                if ($weight == 0) {
                    $weight = 1;
                }

                $this->MATRIX[$level][$column]["weight"] = $weight;
            }
        }
        # DEFINE X COORDINATES

        $this->MATRIX[1][1]["x"] = .5;
        $this->MATRIX[1][1]["max_level"] = $this->MAX_LEVEL;
        $this->MATRIX[1][1]["max_col"] = $this->MAX_COL;

        $this->MATRIX[1][1] ["width"] = 1;
        if ($this->MAX_COL > 8) {
            $this->MATRIX[1][1]["x"] = $this->MAX_COL * 0.055;
            $this->MATRIX[1][1]["width"] = $this->MAX_COL * 0.11; //changes according to max no of users
        }

        for ($level = 2; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                if (isset($this->MATRIX[$level][$column]["id"])) {

                    $parentweight = 1;
                    $parentwidth = 1;
                    $parentx = 1;

                    for ($col = 1; $col <= $this->MAX_COL; $col++) {

                        if (isset($this->MATRIX[$level][$column] ["parent"]) && isset($this->MATRIX[$level - 1] [$col]["id"]) && ($this->MATRIX[$level - 1][$col]["id"] == $this->MATRIX[$level][$column]["parent"])) {

                            $parentweight = $this->MATRIX[$level - 1][$col]["weight"];

                            $parentwidth = $this->MATRIX[$level - 1][$col]["width"];

                            $parentx = $this->MATRIX[$level - 1][$col]["x"];
                        }
                    }

                    $mywidth = ( $this->MATRIX[$level] [$column]["weight"] / $parentweight) * $parentwidth;

                    # IF I AM NOT THE FIRST CHILD, CALCULATE LEFT EDGE

                    if ($this->MATRIX[$level][$column - 1]["parent"] != $this->MATRIX[$level][$column]["parent"]) {

                        $myleftedge = $parentx - ($parentwidth / 2);
                    } else {

                        $myleftedge = $this->MATRIX[$level][$column - 1]["x"] + ( $this->MATRIX[$level][$column - 1]["width"]);
                    }

                    $myx = $myleftedge + ($mywidth / 2);

                    $this->MATRIX[$level][$column]["width"] = $mywidth;

                    $this->MATRIX[$level][$column]["x"] = $myx;
                } else {

                    $column = 9999;
                }
            }
        }

        return $this->MATRIX;
    }

    function get_parent($child) {

        $this->db->select('father_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $child);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        foreach ($query_parent->result() as $row) {
            $father = $row->father_id;
        }

        return $father;
    }

    function get_parent_unilevel($child) {

        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $child);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        foreach ($query_parent->result() as $row) {
            $father = $row->sponsor_id;
        }

        return $father;
    }

    function get_active_status($id) {

        $this->db->select('*');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $cnt = $this->db->count_all_results();

        if ($cnt > 0) {
            $status = "yes";
        } else {
            $status = "no";
        }

        return $status;
    }

    function getEncrypt($string) {
        $id_encode = $this->encrypt->encode($string);
        $id_encode = str_replace("/", "_", $id_encode);
        return $encrypt_id = urlencode($id_encode);
    }

    function getDecrypt($string) {
        $id = urldecode($string);
        $id_decode = str_replace("_", "/", $id);
        return $id_decrypt = $this->encrypt->decode($id_decode);
    }

    function set_config($id) {
        $user_arr = $this->obj_tree->getDownlineUsers($id, 4);
        $max_level_count = $this->obj_tree->getMaxLevelCount($user_arr);
        $this->GRAPH_WIDTH = ($max_level_count ) * 100;

        if ($this->GRAPH_WIDTH < 850) {
            $this->GRAPH_WIDTH = 900;
        }

        return $this->GRAPH_WIDTH;
    }

    function set_config_board($id) {
        $max_level_count = 8;
        $this->GRAPH_WIDTH = ($max_level_count ) * 125;

        if ($this->GRAPH_WIDTH < 850) {
            $this
                    ->GRAPH_WIDTH = 900;
        }
    }

    function addtoBoardMatrix($id, $level, $parent, $board_id) {
        # GET POSITION IN MATRIX

        $this->MATRIX[$level][0] ++;

        $column = $this->MATRIX[$level][0];


        # SET MAXCOL AND MAXLEVEL

        if ($column > $this->MAX_COL) {
            $this->MAX_COL = $column;
        }

        if ($level > $this->MAX_LEVEL) {
            $this->MAX_LEVEL = $level;
        }



        # RECURSIVITY AIRBAG

        if ($level > TREE_LEVEL) {
            return;
        }
        $this->db->select('*');
        $this->db->from("auto_board_ $board_id");
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();

        $board_position = 1;
        foreach ($query->result() as $member) {

            # ADD TO MATRIX
            $this->MATRIX[$level][$column]["id"] = $id;

            $this->MATRIX[$level][$column]["user_ref_id"] = $member->user_ref_id;

            $this->MATRIX[$level][$column]["name"] = $member->user_name;

            $this->MATRIX[$level][$column]["parent"] = $parent;

            $this->MATRIX[$level][$column]["active"] = $member->active;

            $this->MATRIX[$level][$column]["position"] = $member->position;

            $this->MATRIX[$level][$column]["father_id"] = $member->father_id;

            $this->MATRIX[$level][$column]["board_position"] = $board_position;

            $board_position++;

# GET CHILDREN

            $this->db->select('id');
            $this->db->from("auto_board_$board_id");
            $this->db->where('father_id', $id);
            $this->db->order_by("position", "asc");
            $query_ch = $this->db->get();
            foreach ($query_ch->result() as $member_ch) {
                $this->addtoBoardMatrix($member_ch->id, $level + 1, $id, $board_id);
            }
        }
    }

    public function checkBoardMatrix($board_id) {
        $this->load->model('configuration_model');
        $board_config = $this->configuration_model->getBoardSettings($board_id);
        $board_width = $board_config[0]['board_width'];
        $board_depth = $board_config[0]['board_depth'];


# ASSIGN Empty nodes
        $node = 0;
        for ($level = $board_depth; $level >= 1; $level--) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                if (!isset($this->MATRIX[$level][$column])) {

                    if ($this->MATRIX [$level][$column - 1]["board_position"] < $board_width) {

                        $this->MATRIX[$level][$column]["id"] = $node;

                        $this->MATRIX[$level][$column]["user_ref_id"] = 0;

                        $this->MATRIX[$level][$column]["name"] = "NA";

                        $this->MATRIX[$level][$column]["parent"] = $this->MATRIX[$level][$column - 1]["parent"];

                        $this->MATRIX[$level][$column]["active"] = 'server';

                        $this->MATRIX[$level][$column]["position"] = $this->MATRIX [$level][$column - 1]["position"] + 1;

                        $this->MATRIX[$level][$column]["father_id"] = $this->MATRIX[$level][$column - 1]["parent"];

                        $this->MATRIX[$level][$column]["board_position"] = $this->MATRIX [$level][$column - 1]["board_position"] + 1;

                        $node++;
                    } else if ($this->MATRIX [$level][$column - 1]["board_position"] == $board_width) {

                        $this->MATRIX[$level][$column]["id"] = $node;

                        $this->MATRIX[$level][$column]["user_ref_id"] = 0;

                        $this->MATRIX[$level][$column]["name"] = "NA";

                        $this->MATRIX[$level][$column] ["parent"] = $this->MATRIX[$level - 1][$column]["id"];

                        $this->MATRIX[$level][$column]["active"] = 'server';

                        $this->MATRIX[$level][$column]["position"] = $this->MATRIX [$level][$column - 1]["position"] + 1;

                        $this->MATRIX[$level][$column]["father_id"] = $this->MATRIX[$level][$column - 1]["parent"];

                        $this->MATRIX[$level][$column]["board_position"] = 1;

                        $node++;
                    } else {

                        $this->MATRIX[$level][$column]["id"] = $node;

                        $this->MATRIX[$level][$column]["user_ref_id"] = 0;

                        $this->MATRIX[$level][$column]["name"] = "NA";

                        $this->MATRIX[$level][$column] ["parent"] = $this->MATRIX[$level - 1][$column]["id"];

                        $this->MATRIX[$level][$column]["active"] = 'server';

                        $this->MATRIX[$level][$column]["position"] = $this->MATRIX [$level][$column - 1]["position"] + 1;

                        $this->MATRIX[$level][$column] ["father_id"] = $this->MATRIX[$level - 1][$column]["id"];

                        $this->MATRIX[$level][$column]["board_position"] = $this->MATRIX [$level][$column - 1]["board_position"] + 1;

                        $node++;
                    }
                }
            }
        }

        $this->MAX_LEVEL = $board_depth;
    }

    public function checkRefIdExistInAutoBoard($user_refid, $board_no) {
        $count = 0;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("auto_board_$board_no");
        $this->db->where('user_ref_id', $user_refid);

        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function checkUserExistInAutoBoard($user, $board_no) {
        $count = 0;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("auto_board_ $board_no");
        $this->db->where('user_name', $user);

        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    function get_parent_board($child, $board_id) {

        $this->db->select('father_id');
        $this->db->from("auto_board_ $board_id");
        $this->db->where('id', $child);
        $this->db->limit(1);
        $query_parent = $this->db->get();
        foreach ($query_parent->result() as $row) {
            $father = $row->father_id;
        }

        return $father;
    }

    public function getUserRefIdByAutoID($id, $board_no) {
        $user_ref_id = 0;
        $res = $this->db->select("user_ref_id")->where("id", $id)->get("auto_board_$board_ no");
        foreach ($res->result() as $row) {
            $user_ref_id = $row->user_ref_id;
        }

        return $user_ref_id;
    }

    public function getBoardId($board_id, $user_ref_id) {
        $res = $this->db->select_max("id")->where("user_ref_id", $user_ref_id)->get("auto_board_$board_ id");
        foreach ($res->result() AS $row)
            return $row->id;
    }

    function displaymatrix($user_id, $id) {


        $this->set_config($id);
        $graphwidth = $this->GRAPH_WIDTH;
        $boxwidth = TREE_BOX_WIDTH;
        $boxheight = TREE_BOX_HIGHT;
        $topmargin = TREE_TOP_MARGIN;
        $leftmargin = TREE_LEFT_MARGIN;
        $maxweight = $this->MATRIX[1][1]["weight"];
        $display_tree = "";
        $unit = $graphwidth / $maxweight;


        for ($level = 1; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

                # DRAW BOXES

                if (isset($this->MATRIX[$level][$column]["id"])) {

                    $id_encrypt = $this->getEncrypt($this->MATRIX[$level][$column]["id"]);
                    $id_t = $this->MATRIX[$level][$column]["id"];

                    $x = ($this->MATRIX [$level][$column] ["x"] * $graphwidth) - ($boxwidth / 2) + $leftmargin;

                    $y = ($level * $boxheight) - $boxheight + $topmargin + 20;


                    $display_tree.= "<div align='center' style='position:absolute; top:$y; left:$x;

				padding:0px;

				height:" . ($boxheight - 20) . "px;width:$boxwidth;'><div id=\"member\">";

                    if ($this->MATRIX[$level][$column]["active"] == "no") {

                        $active = $this->get_active_status($this->MATRIX[$level][$column]["id"]);

                        if ($active == "yes") {

                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getGenologyTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/inactive.png' height='48px' width='48px' border='0' title='Account Freezed'/><br>";
                        } else {

                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getGenologyTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/inactive.png' height='48px' width='48px' border='0' title='Not Activated'/><br>";
                        }
                    } elseif ($this->MATRIX[$level][$column]["active"] == "terminated")
                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getSponsorTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/terminate.gif' height='48px' width='48px' border='0'  /><br>";
                    elseif ($this->MATRIX[$level][$column][
                            "active"] == "server")
                        $display_tree .= "<a href=\"" . base_url() . "register/user_register/{$id_encrypt}/" . $this->MATRIX [$level][$column]["position"] . "/" . $this->MATRIX[$level][$column]["father_id"] . "\" target=_parent><img src='" . $this->PUBLIC_URL . "images/add.png' height='48px' width='48px' border='0' title='Add new member here...'/><br>";
                    else
                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getGenologyTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/active.gif' height='48px' width='48px' border='0'  /><br>";

                    if ($this->MATRIX[$level][$column]["active"] != "server") {
                        $display_tree .= $this->MATRIX[$level][$column]["name"] . "</a><br>";
                    } else {
                        $display_tree.="ADD HERE" . "</a><br>";
                    }
                    if ($this->MATRIX[$level][$column][
                            "active"] != "server")
                        $display_tree .= "[" . "<font color='#009900'>" . /* $this->MATRIX[$level][$column]["track_id"] . */"</font>]";

                    $display_tree.= "</div>";

                    $display_tree.= "</div>";



# DRAW CONNECTING LINES

                    if ($this->MATRIX[$level][$column]["parent"] == $this->MATRIX[$level][$column - 1]["parent"]) {

                        if ($level > 1) {

# HORIZONTAL LINE

                            $prevx = ( $this->MATRIX[$level][$column - 1]["x"] *
                                    $graphwidth) + $leftmargin;

                            $y2 = $y - 10;

                            $width = $x - $prevx + ($boxwidth / 2);

                            $display_tree.= "<div style='position:absolute; top:$y2; 							left:$prevx; border-top:1px solid #000; width:$width ; 						height:0px'>&nbsp;</div>";
                        }
                    }



# VERTICAL LINE (TOP)

                    if ($level > 1) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y - 10;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }

# VERTICAL LINE (BOTTOM)

                    if ($level < $this->MAX_LEVEL && $this->MATRIX[$level][$column]["children"]) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y + $boxheight - 20 + 1;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }



# "REDRAW" ICON

                    if ($level == 1) {

                        $this->db->select('father_id');
                        $this->db->from('ft_individual');
                        $this->db->where('id', $this->MATRIX[$level][$column]["id"]);
                        $this->db->limit(1);
                        $query_parent = $this->db->get();
                        $row = $query_parent->row_array();
                        $root = $row["father_id"];

                        if ($user_id > $root) {
                            $root = $this->MATRIX[$level][$column]["id"];
                        }
                    } else {

                        $root = $this->MATRIX[$level][$column]["id"];
                    }

                    if ($root) {

                        $x = ($this->MATRIX [$level] [$column]["x"] * $graphwidth) - 8 + $leftmargin;

                        $url_encrypted_id = $this->getEncrypt($root);

                        $loged_user_id = $this->LOG_USER_ID;
                        $user_type = $this->session->userdata['inf_logged_in']['user_type'];
                        if ($user_type == 'employee') {
                            $this->load->model('validation_model');
                            $loged_user_id = $this->validation_model->getAdminId();
                        }
                        if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $loged_user_id) {
                            $up_link = $this->get_parent($this->MATRIX[$level][$column]["id"]);
                            if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $loged_user_id) {

                                $display_tree.= "<div title='UP' onclick=\"getGenologyTree('$up_link');\"

					style='position:absolute; top:" . ($y - 9) . "; left:$x;

					border:0px solid #000; cursor:pointer; '><img src='" . $this->PUBLIC_URL . "images/up.png' height='16px' width='16px' border='0' /></div>\n";
                            }
                        }
                    }
                }
            }
        }

        return $display_tree;
    }

    function displaymatrixUnilevel($user_id, $id) {

        $this->set_config($id);
        $graphwidth = $this->GRAPH_WIDTH;
        $boxwidth = TREE_BOX_WIDTH;
        $boxheight = TREE_BOX_HIGHT;
        $topmargin = TREE_TOP_MARGIN;
        $leftmargin = TREE_LEFT_MARGIN;
        $maxweight = $this->MATRIX[1][1] ["weight"];

        $unit = $graphwidth / $maxweight;
        $display_tree = "";

        for ($level = 1; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

# DRAW BOXES
                if (isset($this->MATRIX[$level][$column]["id"])) {
                    $this->MATRIX[$level][$column]["id"] = $this->getSponsor($this->MATRIX[$level][$column]["id"]);

                    $id_encrypt = $this->getEncrypt($this->MATRIX[$level][$column]["id"]);
                    $id_t = $this->MATRIX[$level][$column]["id"];

                    $x = ($this->MATRIX [$level][$column] ["x"] * $graphwidth) - ($boxwidth / 2) + $leftmargin;


                    $y = ($level * $boxheight) - $boxheight + $topmargin + 20;


                    $display_tree.= "<div align='center' style='position:absolute; top:$y; left:$x;

				padding:0px;

				height:" . ($boxheight - 20) . "px;width:$boxwidth;'><div id=\"member\">";

                    if ($this->MATRIX[$level][$column]["active"] == "no") {

                        $active = $this->get_active_status($this->MATRIX[$level][$column]["id"]);

                        if ($get_active_status == "yes") {

                            $display_tree .= "<a href=\"\"><img src='" . $this->PUBLIC_URL . "images/freezed.gif' height='48px' width='48px' border='0' title='Account Freezed'/><br>";
                        } else {



                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getSponsorTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/inactive.png' height='48px' width='48px' border='0'  /><br>";
                        }
                    } elseif ($this->MATRIX[$level][$column]["active"] == "terminated")
                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getSponsorTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/terminate.gif' height='48px' width='48px' border='0'  /><br>";

                    elseif ($this->MATRIX[$level][$column][
                            "active"] == "server")
                        $display_tree .= "<a href=\"" . base_url() . "register/user_register/{$id_encrypt}/" . $this->MATRIX [$level][$column]["position"] . "/" . $this->MATRIX[$level][$column]["father_id"] . "\" target=_parent><img src='" . $this->PUBLIC_URL . "images/add.png' height='48px' width='48px' border='0' title='Add new member here...'/><br>";
                    else {
                        if ($this->MATRIX[$level][$column]["package"] ==
                                'brand_partner')
                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getSponsorTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/bp.png' height='48px' width='48px' border='0'  /><br>";
                        else
                            $display_tree.= "<a class=\"ttip\" href=\"javascript:void(0);\" onclick=\"getSponsorTree('{$id_t}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/active.gif' height='48px' width='48px' border='0'  /><br>";
                    }
                    if ($this->MATRIX[$level][$column]["active"] != "server") {
                        $display_tree .= $this->MATRIX[$level][$column]["name"] . "</a><br>";
                    } else {
                        $display_tree.="ADD HERE" . "</a><br>";
                    }
                    if ($this->MATRIX[$level][$column][
                            "active"] != "server")
                        $display_tree .= "[" . "<font color='#009900'>" . /* $this->MATRIX[$level][$column]["track_id"] . */"</font>]";

                    $display_tree.= "</div>";

                    $display_tree.= "</div>";



# DRAW CONNECTING LINES

                    if ($this->MATRIX[$level][$column]["parent"] == $this->MATRIX[$level][$column - 1]["parent"]) {

                        if ($level > 1) {

# HORIZONTAL LINE

                            $prevx = ( $this->MATRIX[$level][$column - 1]["x"] *
                                    $graphwidth) + $leftmargin;

                            $y2 = $y - 10;

                            $width = $x - $prevx + ($boxwidth / 2);

                            $display_tree.= "<div style='position:absolute; top:$y2; 							left:$prevx; border-top:1px solid #000; width:$width ; 						height:0px'>&nbsp;</div>";
                        }
                    }



# VERTICAL LINE (TOP)

                    if ($level > 1) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y - 10;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }

# VERTICAL LINE (BOTTOM)

                    if ($level < $this->MAX_LEVEL && $this->MATRIX[$level][$column]["children"]) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y + $boxheight - 20 + 1;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }



# "REDRAW" ICON

                    if ($level == 1) {

                        $this->db->select('sponsor_id');
                        $this->db->from('ft_individual');
                        $this->db->where('id', $this->MATRIX[$level][$column]["id"]);
                        $this->db->limit(1);
                        $query_parent = $this->db->get();
                        $row = $query_parent->row_array();
                        $root = $row["sponsor_id"];

                        if ($user_id > $root) {
                            $root = $this->MATRIX[$level][$column]["id"];
                        }
                    } else {

                        $root = $this->MATRIX[$level][$column]["id"];
                    }

                    if ($root) {

                        $x = ($this->MATRIX [$level] [$column]["x"] * $graphwidth) - 8 + $leftmargin;

                        $url_encrypted_id = $this->getEncrypt($root);

                        $loged_user_id = $this->LOG_USER_ID;
                        $user_type = $this->session->userdata['inf_logged_in']['user_type'];
                        if ($user_type == 'employee') {
                            $this->load->model('validation_model');
                            $loged_user_id = $this->validation_model->getAdminId();
                        }
                        if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $loged_user_id) {
                            $up_link = $this->get_parent_unilevel($this->MATRIX[$level][$column]["id"]);
                            if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $loged_user_id) {

                                $display_tree.= "<div title='UP' onclick=\"getSponsorTree('$up_link');\"

					style='position:absolute; top:" . ($y - 9) . "; left:$x;

					border:0px solid #000; cursor:pointer; '><img src='" . $this->PUBLIC_URL . "images/up.png' height='16px' width='16px' border='0' /></div>\n";
                            }
                        }
                    }
                }
            }
        }

        return $display_tree;
    }

    function displayBoard($user_id, $id, $board_id) {

        $this->set_config($id);
        $graphwidth = $this->GRAPH_WIDTH;
        $boxwidth = TREE_BOX_WIDTH;
        $boxheight = TREE_BOX_HIGHT;
        $topmargin = TREE_TOP_MARGIN;
        $leftmargin = TREE_LEFT_MARGIN;
        $maxweight = $this->MATRIX[1][1] ["weight"];

        $unit = $graphwidth / $maxweight;
        $board_icon = 'active.gif';

        for ($level = 1; $level <= $this->MAX_LEVEL; $level++) {

            for ($column = 1; $column <= $this->MAX_COL; $column++) {

# DRAW BOXES

                if ($this->MATRIX[$level][$column]["id"]) {

                    $id_encrypt = $this->getEncrypt($this->MATRIX[$level][$column]["id"]);
                    $id_t = $this->MATRIX[$level][$column]["id"];

                    $x = ($this->MATRIX [$level][$column] ["x"] * $graphwidth) - ($boxwidth / 2) + $leftmargin;

                    $y = ($level * $boxheight) - $boxheight + $topmargin + 20;


                    $display_tree.= "<div align='center' style='position:absolute; top:$y; left:$x;

				padding:0px;

				height:" . ($boxheight - 20) . "px;width:$boxwidth;'><div id=\"member\">";
                    $user_ref_id = $this->getUserRefIdByAutoID($this->MATRIX[$level][$column]["id"], $board_id);
                    $this->load->model('validation_model');
                    $uname = $this->validation_model->IdToUserName($user_ref_id);
                    if ($this->MATRIX[$level][$column]["active"] == "no") {

                        $active = $this->get_active_status($this->MATRIX[$level][$column]["id"]);


                        if ($get_active_status == "yes") {

                            $display_tree.= "<a href=\"ft_chart.php?id={$id_encrypt}\"><img src='" . $this->PUBLIC_URL . "images/freezed.gif' height='48px' width='48px' border='0' title='Account Freezed'/><br>";
                        } else {

                            $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/inactive.png' height='48px' width='48px' border='0' title='Not Activated'/><br>";
                        }
                    } elseif ($this->MATRIX[$level][$column]["active"] == "terminated")
                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/terminate.gif' height='48px' width='48px' border='0'  /><br>";
                    elseif ($this->MATRIX[$level][$column][
                            "active"] == "server")
                        $display_tree .= "<a href=\"" . base_url() . "register/user_register/{$id_encrypt}/" . $this->MATRIX [$level][$column]["position"] . "/" . $this->MATRIX[$level][$column]["father_id"] . "\" target=_parent><img src='" . $this->PUBLIC_URL . "images/add.png' height='48px' width='48px' border='0' title='Add new member here...'/><br>";
                    else {
                        $user_ref_id = $this->getUserRefIdByAutoID($this->MATRIX[$level][$column]["id"], 1);
                        $count1 = $this->checkUserExistInAutoBoard($uname, 1);
                        $count2 = $this->checkUserExistInAutoBoard($uname, 2);


                        $display_tree.= "<a href=\"javascript:void(0);\" onclick=\"getBoardTree('{$id_t}','{$board_id}')\" id='userlink" . $this->MATRIX [$level][$column]['id'] . "'><img src='" . $this->PUBLIC_URL . "images/$board_icon' height='48px' width='48px' border='0'  /><br>";
                    }

                    if ($this->MATRIX[$level][$column]["active"] != "server") {
                        $display_tree .= $this->MATRIX[$level][$column]["name"] . "</a><br>";
                    } else {
                        $display_tree.="ADD HERE" . "</a><br>";
                    }
                    if ($this->MATRIX[$level][$column][
                            "active"] != "server")
                        $display_tree .= "[" . "<font color='#009900'>" . $this->MATRIX[$level][$column]["track_id"] . "</font>]";

                    $display_tree.= "</div>";

                    $display_tree.= "</div>";



# DRAW CONNECTING LINES

                    if ($this->MATRIX[$level][$column]["parent"] == $this->MATRIX[$level][$column - 1]["parent"]) {

                        if ($level > 1) {

# HORIZONTAL LINE

                            $prevx = ( $this->MATRIX[$level][$column - 1]["x"] *
                                    $graphwidth) + $leftmargin;

                            $y2 = $y - 10;

                            $width = $x - $prevx + ($boxwidth / 2);

                            $display_tree.= "<div style='position:absolute; top:$y2; 							left:$prevx; border-top:1px solid #000; width:$width ; 						height:0px'>&nbsp;</div>";
                        }
                    }



# VERTICAL LINE (TOP)

                    if ($level > 1) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y - 10;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }

# VERTICAL LINE (BOTTOM)

                    if ($level < $this->MAX_LEVEL && $this->MATRIX[$level][$column]["children"]) {

                        $x = ($this->MATRIX [$level][$column]["x"] * $graphwidth) + $leftmargin;

                        $y2 = $y + $boxheight - 20 + 1;

                        $display_tree.= "<div style='position:absolute; top:$y2; left:$x;

					border-left:1px solid #000; width:0px;height:10px'>&nbsp;</div>";
                    }



# "REDRAW" ICON

                    if ($level == 1) {

                        $this->db->select('father_id');
                        $this->db->from("auto_board_$board_id");
                        $this->db->where('id', $this->MATRIX[$level][$column]["id"]);
                        $this->db->limit(1);
                        $query_parent = $this->db->get();
                        $row = $query_parent->row_array();
                        $root = $row["father_id"];

                        if ($user_id > $root) {
                            $root = $this->MATRIX[$level][$column]["id"];
                        }
                    } else {
                        $root = $this->MATRIX[$level][$column]["id"];
                    }

                    if ($root) {

                        $x = ($this->MATRIX [$level] [$column]["x"] * $graphwidth) - 8 + $leftmargin;

                        $url_encrypted_id = $this->getEncrypt($root);

                        $loged_user_id = $this->LOG_USER_ID;
                        $user_type = $this->session->userdata['inf_logged_in']['user_type'];
                        if ($user_type == 'employee') {
                            $this->load->model('validation_model');
                            $loged_user_id = $this->validation_model->getAdminId();
                        }

                        $auto_board_id = $this->getBoardId($board_id, $loged_user_id);

                        if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $auto_board_id) {
                            $up_link = $this->get_parent_board($this->MATRIX[$level][$column]["id"], $board_id);
                            if (( $this->MATRIX [$level][$column]["active"] != "server") and $this->MATRIX[$level][$column]["id"] != $auto_board_id) {

                                $display_tree.= "<div title='UP' onclick=\"getBoardTree('$up_link','$board_id');\"

					style='position:absolute; top:" . ($y - 9) . "; left:$x;

					border:0px solid #000; cursor:pointer; '><img src='" . $this->PUBLIC_URL . "images/up.png' height='16px' width='16px' border='0' /></div>\n";
                            }
                        }
                    }
                }
            }
        }

        return $display_tree;
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

}
