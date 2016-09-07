<?php
/**
 * Try avoid to use this model as much as you can,
 * because there is to much DB requests
 */
Class validation_model extends inf_model {

    private $mailObj;

    public function __construct() {
        parent::__construct();
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function stripTagsPostArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = strip_tags($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function escapeStringPostArray($post_arr = array()) {
        $temp_arr = array();
        if (is_array($post_arr) && count($post_arr)) {
            foreach ($post_arr AS $key => $value) {
                if (is_string($value)) {
                    $temp_arr["$key"] = addslashes($value);
                } else {
                    $temp_arr["$key"] = $value;
                }
            }
        }
        return $temp_arr;
    }

    public function stripTagTextArea($text = '') {
        $allowable_tags = '<b></b><i></i><u></u><strong></strong><em></em><p></p><s></s><sub></sub><sup></sup><ol></ol><ul></ul><li></li><blockquote></blockquote><a><img><table></table><tbody></tbody><tr></tr><td></td><h1></h1><h2></h2><h3></h3><h4></h4><h5></h5><h6></h6><pre></pre><address></address><div></div>';
        return strip_tags($text, $allowable_tags);
    }

    /**
     * 
     * @param string $username This value will be escaped!
     * @return int
     */
    public function userNameToID($username) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('user_name', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    public function IdToUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        $query->free_result();
        return $user_name;
    }

    public function getFatherId($user_id) {
        $father_id = NULL;
        $this->db->select('father_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $father_id = $row->father_id;
        }
        return $father_id;
    }

    public function getSponsorData($user_id) {
        $data = array();
        $this->db->select('ud.*');
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details as ud', 'ft.father_id = ud.user_detail_refid');
        $this->db->where('ft.id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $row['country_name'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $row['state_name'] = $this->country_state_model->getStateNameFromId($row['user_detail_state']);
            $data = $row;
        }
        return $data;
    }

    public function getFirstLine($user_id, $page = 0, $limit = 10) {
        $this->load->model('career_model');
        $no = 1;
        $data = array();
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details as ud', 'ft.id = ud.user_detail_refid', 'LEFT');
        $this->db->where('ft.father_id', $user_id);
        $this->db->where('ft.active !=', 'server');
        if($limit != 0){
            $this->db->limit($limit, $page * $limit);
        }
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $row['country_name'] = $this->country_state_model->getCountryNameFromId($row['user_detail_country']);
            $row['state_name'] = $this->country_state_model->getStateNameFromId($row['user_detail_state']);

            $stat = $this->career_model->getCarrerStat($row['id']);
            $row["user_bv"] = $stat['aq_team_bv'];
            $cr = 'NA';
            $det = $this->career_model->getAllCareers();
            foreach ($det as $career) {
                if ($career['id'] == $stat['career']) {
                    $cr = $career['leadership_rank'];
                    break;
                }
            }
            $row["user_rank"] = $cr;
            $first_line = $this->validation_model->getFirstLineCount($row['id']);
            $row["firstline"] = $first_line;
            $data[] = $row;
            $data[$i]['number'] = $no;
            $i++;
            $no++;
        }
        return $data;
    }

    public function getCountFirstLine($user_id) {
        $this->db->from('ft_individual as ft');
        $this->db->join('user_details as ud', 'ft.id = ud.user_detail_refid');
        $this->db->where('ft.father_id', $user_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getFirstLineCount($user_id) {

        $this->db->where('active !=', 'server');
        $this->db->where('father_id', $user_id);
        $query = $this->db->get('ft_individual');
        return $query->num_rows();
    }

	public function getFirstAndSecondLineIds( $user_ID ) {
		$this->db->select( 'id' );
		$this->db->where( 'active !=', 'server' );
		$this->db->where( 'father_id', $user_ID );
		$query = $this->db->get( 'ft_individual' );
		$first_line_ids = $query->result_array();
		if ( empty( $first_line_ids ) )
			return [];
		$first_line_ids  = array_column( $first_line_ids, 'id' );
		$second_line_ids = $this->db->select( 'id' )
			->where( 'active !=', 'server' )
			->where_in( 'father_id', $first_line_ids )
			->get( 'ft_individual' )
			->result_array();
		if ( is_array( $second_line_ids ) && ! empty( $second_line_ids ) ) {
			$second_line_ids = array_column( $second_line_ids, 'id' );

			return array_merge( $first_line_ids, $second_line_ids );
		}

		return $first_line_ids;
	}

    public function getSecondLineCount($user_ids, $level = 1) {
        if(!is_array($user_ids)){
            $user_ids = array($user_ids);
        }
        $count = 0;
        $this->db->select('id');
        $this->db->where('active !=', 'server');
        $this->db->where_in('father_id', $user_ids);
        $query = $this->db->get('ft_individual');
        $children = $query->result_array();
        $query->free_result();
        $children_ids = [];
        foreach ($children as $child) {
            $children_ids[] = $child['id'];
            if($level != 1){
                $count++;
            }
        }

        return count($children_ids) ? $count + $this->getSecondLineCount($children_ids, ++$level) : 0;
    }

 /*   public function getSecondLineCount($user_ids, $level = 1) {
        if(!is_array($user_ids)){
            $user_ids = array($user_ids);
        }
        $count = 0;
        $query = $this->db->where('active !=', 'server')->where_in('father_id', $user_ids);
        $query_count = clone $query;
        $row_num = $query_count->get('ft_individual')->num_rows();
        $offset = 0;
        while($offset < $row_num){
            $children = $query->get('ft_individual', 5000, $offset)->result_array();
            $offset += 5000;
            $children_ids = [];
            foreach ($children as $child) {
                $children_ids[] = $child['id'];
                if($level != 1){
                    $count++;
                }
            }
            $count = count($children_ids) ? $count + $this->getSecondLineCount($children_ids, ++$level) : 0;
        }
        return $count;
//        $children = $query->result_array();
    }*/

    public function getSponsorId($user_id) {
        $sponsor_id = NULL;
        $this->db->select('sponsor_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $sponsor_id = $row->sponsor_id;
        }
        return $sponsor_id;
    }

    public function IdToUserNameBoard($board_user_id, $board_no) {
        if ($board_user_id > 0) {
            $user_name = NULL;
            $query = $this->db->select("user_name")->where("id", $board_user_id)->get("auto_board_$board_no");
            foreach ($query->result() as $row) {
                $user_name = $row->user_name;
            }
            return $user_name;
        } else {
            return "NA";
        }
    }

    public function getProfilePicture($user_id) {
        $img = 'nophoto.jpg';
        $this->db->select('user_photo');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $img = $row['user_photo'];
            if (!file_exists('public_html/images/profile_picture/' . $row['user_photo'])) {
                $img = 'nophoto.jpg';
            }
        }

        return $img;
    }

    public function getLeftNodeId($father_id) {
        $user_id_left = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id =$father_id AND position ='L' AND active ='yes'");
        $rs = $this->db->get();
        foreach ($rs->result() as $id_left) {

            $user_id_left = $id_left->id;
        }
        return $user_id_left;
    }

    public function isUserAvailableinBoard($user_id, $board_no) {
        $flag = false;
        $board_table = "auto_board_" . $board_no;

        $this->db->select("*")->where("id", $user_id)->from("$board_table");
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $flag = true;
        }
        return $flag;
    }

    /**
     * 
     * @param int $user_id This value will be scaped
     * @return string
     */
    public function getUserFullName($user_id) {
        $this->db->select('user_detail_name,user_detail_second_name');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get()->row_array();
        try {
            return $query['user_detail_name'] . " " . $query['user_detail_second_name'];
        } catch (Exception $ex) {
            return 'NA';
        }
    }


    public function getMaxAcademyLevel( $email ) {
        $config = [];
        $config['token'] = 'e124fb01ab1c83d0f516cc16ca1fcf0e';
        $config['server'] = 'https://wordpress.swisscoin.eu/testacademy/moodle';
        $config['dir'] = '/';
        $config['xmlrpc_url'] = 'webservice/xmlrpc/server.php?wstoken=';
        $config['login_url'] = 'login/index.php';

        $this->load->library('moodle_api', $config );
		$fields = [
			'key'   => 'email',
			'value' => $email,
		];
		$user = $this->moodle_api->getUser($fields);
		if( empty( $user ) )
			return 0;

		$courses = $this->moodle_api->getCourse( $user['id'] );

		if( ! empty( $courses ) && isset( $courses['fullname'] ) ) {
			return $courses['fullname'];
		} else return 0;
    }

    public function getUserEmail($user_id) {
        $user_name = NULL;
        $this->db->select('user_detail_email');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_detail_email;
        }
        return $user_name;
    }

    public function getUserPin($user_id) {
        $user_name = NULL;
        $this->db->select('user_detail_pin');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_detail_pin;
        }
        return $user_name;
    }

    public function getUserCity($user_id) {
        $user_name = NULL;
        $this->db->select('user_detail_city');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_detail_city;
        }
        return $user_name;
    }

    public function getUserMobileNumber($user_id) {
        $user_name = NULL;
        $this->db->select('user_detail_mobile');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_detail_mobile;
        }
        return $user_name;
    }

    public function getUserEmailId($user_id) {
        $email_id = NULL;
        $this->db->select("user_detail_email");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_id = $row->user_detail_email;
        }
        return $email_id;
    }

    public function geRighttNodeId($father_id) {
        $user_id_right = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where("father_id =$father_id AND position ='R' AND active ='yes'");
        $rs = $this->db->get();
        foreach ($rs->result() as $id_right) {
            $user_id_right = $id_right->id;
        }
        return $user_id_right;
    }

    public function getChildNodeId($father_id, $postion, $active = 'server') {
        $id_child = NULL;
        $this->db->select("id");
        $this->db->from("ft_individual");
        $this->db->where('father_id', $father_id);
        if ($postion && $postion != "") {
            $this->db->where('position', $postion);
        }
        $this->db->where('active', $active);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $id_child = $row->id;
        }
        return $id_child;
    }

    public function getSponserIdName($user_id, $table_prefix = '') {
        $row_data = array();
        $row = array();
        $id = "";
        $this->db->select("father_id");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qr = $this->db->get();
        foreach ($qr->result_array()as $row) {

            $id = $row['father_id'];

            if ($id == 0) {
                $row_data['id'] = $row['father_id'];
                $row_data['name'] = "Infinite MLM Software";
            } else {

                $this->db->select("user_detail_name,user_detail_second_name");
                $this->db->from($table_prefix . "user_details");
                $this->db->where("user_detail_refid", $id);
                $sql = $this->db->get();
                foreach ($sql->result()as $spncr) {
                    $row_data['id'] = $id;
                    $row_data['name'] = $spncr->user_detail_name . ' ' . $spncr->user_detail_second_name;
                }
            }
        }

        return $row_data;
    }

    public function checkUserPin($passcode) {
        $flag = false;
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where('pin_numbers', $passcode);
        $this->db->where('status', 'yes');
        $qr = $this->db->get();
        $pin_avail = $qr->num_rows();

        if ($pin_avail > 0) {
            $flag = true;
        }

        return $flag;
    }

    /**
     * 
     * @param int $sponserid This value will be scaped!
     * @param string $sponserleg This value will be scaped!
     * @param bool $check_position ???
     * @return boolean
     */
    public function isLegAvailable($sponserid, $sponserleg, $check_position = false) {
        $flag = false;

        $sponsor_available = $this->isUserAvailable($sponserid);
        if ($sponsor_available) {
            $count = 0;
            $this->db->select("COUNT(*) AS cnt");
            $this->db->from("ft_individual");
            $this->db->where('father_id', $sponserid);
            $this->db->where('position', $sponserleg);
            $this->db->where('active !=', 'server');
            $qr = $this->db->get();

            foreach ($qr->result() as $row) {
                $count = $row->cnt;
            }

            if ($check_position) {
                if ($count) {
                    $flag = false;
                } else {
                    $flag = true;
                }
            } else {
                $flag = true;
            }
        }
        return $flag;
    }

    /**
     * 
     * @param string $user_name This value will be escaped!
     * @return boolean
     */
    public function isUserNameAvailable($user_name) {
        $flag = false;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("ft_individual");
        $this->db->where('user_name', $user_name);
        $this->db->where('active !=', 'server');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        if ($count > 0) {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    /**
     * 
     * @param int $user_id This value will be escaped!
     * @return boolean
     */
    public function isUserAvailable($user_id) {
        $flag = false;
        $this->db->select("*");
        $this->db->from("login_user");
        $this->db->where('user_id', $user_id);
        $this->db->where('addedby !=', 'server');
        $qr = $this->db->get();
        $user_avail = $qr->num_rows();
        if ($user_avail > 0) {
            $flag = true;
        }
        return $flag;
    }

    public function getStatus($user_id) {
        $status = NULL;
        $this->db->select("status");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $status = $row->status;
        }
        return $status;
    }

    public function getProductNameFromUserID($user_id, $table_prefix = '') {
        $product_name = NULL;
        $this->db->select("product_name");
        $this->db->from("package as pr");
        $this->db->join("ft_individual as ft", "pr.product_id = ft.product_id", "INNER");
        $this->db->where("ft.id", $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $product_name = $row->product_name;
        }
        return $product_name;
    }

    public function getProductId($user_id) {
        $product_id = 0;
        $this->db->select("product_id");
        $this->db->where('id', $user_id);
        $query = $this->db->get("ft_individual");
        foreach ($query->result() as $row) {
            $product_id = $row->product_id;
        }
        return $product_id;
    }

    public function getFullName($user_id) {
        $det_name = NULL;
        $this->db->select("user_detail_name");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $det_name = $row->user_detail_name;
        }
        return $det_name;
    }

    public function getAdminId() {
        $user_id = NULL;
        $this->db->select('user_id');
        $this->db->from('login_user');
        $this->db->where('user_type', 'admin');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->user_id;
        }
        return $user_id;
    }

    public function getAdminUsername() {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_type', "admin");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getAdminPassword() {
        $password = NULL;
        $this->db->select("password");
        $this->db->from("login_user");
        $this->db->where("user_type", 'admin');
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $password = $row->password;
        }
        return $password;
    }

    public function getJoiningData($user_id) {
        $date_of_joining = NULL;
        $this->db->select("date_of_joining");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $date_of_joining = $row->date_of_joining;
        }
        return $date_of_joining;
    }

    public function getSiteInformation() {
        $details = array();
        $this->db->select("*");
        $this->db->from("site_information");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $details = $row;
            if (!file_exists('public_html/images/logos/' . $row['logo'])) {
                $details['logo'] = 'logo_login_page.png';
            }
            if (!file_exists('public_html/images/logos/' . $row['logo'])) {
                $details['favicon'] = 'favicon.ico';
            }
        }
        return $details;
    }

    public function getUserRank($id) {
        $rank = NULL;
        $this->db->select('user_rank_id');
        $this->db->from('ft_individual');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $rank = $row->user_rank_id;
        }
        return $rank;
    }

    public function getReferalCount($id) {
        $count = 0;
        $this->db->select("COUNT(*) AS cnt");
        $this->db->from("ft_individual");
        $this->db->where('sponsor_id', $id);
        $this->db->where('active !=', 'server');
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $count = $row->cnt;
        }
        return $count;
    }

    public function getCurrentRankFromRankConfig($num) {
        $rank_id = 0;
        $count = $this->getRefferalCount($num);
        $this->db->select('rank_id');
        $this->db->where('referal_count', $count);
        $this->db->where('rank_status', 'active');
        $this->db->limit(1);
        $res = $this->db->get('rank_details');
        foreach ($res->result() as $row) {
            $rank_id = $row->rank_id;
        }
        return $rank_id;
    }

    public function isUserActive($id) {
        $flag = false;

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where('id', $id);
        $qr = $this->db->get();
        foreach ($qr->result() as $row) {
            $active = $row->active;
        }


        if ($active == 'yes') {
            $flag = true;
        } else {
            $flag = false;
        }
        return $flag;
    }

    public function getRefferalCount($num) {
        $count = 0;
        $this->db->select_max('referal_count');
        $this->db->where('referal_count <=', $num);
        $this->db->where('rank_status', 'active');
        $this->db->limit(1);
        $res = $this->db->get('rank_details');

        foreach ($res->result() as $row) {
            $count = $row->referal_count;
        }
        return $count;
    }

    public function getPrdocutName($product_id) {
        $prod_name = NULL;
        $this->db->select("product_name");
        $this->db->from('package');
        $this->db->where("product_id", $product_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $prod_name = $row->product_name;
        }
        return $prod_name;
    }

    public function getTokenFromProduct($product_id) {
        $num_of_tokens = 0;
        $this->db->select("num_of_tokens");
        $this->db->from('package');
        $this->db->where("product_id", $product_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $num_of_tokens = $row->num_of_tokens;
        }
        return $num_of_tokens;
    }

    public function getBvFromProduct($product_id) {
        $num_of_tokens = 0;
        $this->db->select("bv_value");
        $this->db->from('package');
        $this->db->where("product_id", $product_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $num_of_tokens = $row->bv_value;
        }
        return $num_of_tokens;
    }

    public function insertUserActivity($login_id, $activity, $user_id = '', $data = '') {
        $date = date("Y-m-d H:i:s");
        $ip_adress = $_SERVER['REMOTE_ADDR'];
        $this->db->set('done_by', $login_id);
        $this->db->set('done_by_type', $this->LOG_USER_TYPE);
        $this->db->set('ip', $ip_adress);
        $this->db->set('user_id', $user_id);
        $this->db->set('activity', $activity);
        $this->db->set('date', $date);
        $this->db->set('data', $data);
        $result = $this->db->insert('activity_history');

        return $result;
    }

    public function getUsernameCount($username) {
        $count = 0;
        $this->db->like("user_name", "$username", "after");
        $res = $this->db->get("ft_individual");
        $count = $res->num_rows();
        return $count;
    }

    public function sendEmail($mailBodyDetails, $user_id, $subject) {
        $email_details = array();
        $email_details = $this->getCompanyEmail();
        $email = $this->getUserEmailId($user_id);

        $this->mailObj->From = $email_details["from_email"];
        $this->mailObj->FromName = $email_details["from_name"];
        $this->mailObj->Subject = $subject;
        $this->mailObj->IsHTML(true);


        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);
        //if($FILE_NAME !="")
        //$this->mailObj->AddAttachment($FILE_NAME);

        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;

        return $res;
    }

    public function getCompanyEmail() {
        $email_details = array();
        $this->db->select('from_name');
        $this->db->select('from_email');
        $this->db->from('mail_settings');
        $this->db->where('id', 1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $email_details["from_name"] = $row->from_name;
            $email_details["from_email"] = $row->from_email;
        }
        return $email_details;
    }

    public function getMailBody() {
        $reg_mail_content = NULL;
        $this->db->select('reg_mail_content');
        $this->db->from('mail_settings');
        $res = $this->db->get();
        foreach ($res->result() as $row) {

            $reg_mail_content = $row->reg_mail_content;
        }
        return $reg_mail_content;
    }

    public function getUserName($user_id) {
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from('login_user');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $row = $res->result_array();
        $user_name = $row[0]['user_name'];
        return $user_name;
    }

    public function getViewAmountType($amount_type) {
        $view_type = NULL;
        $this->db->select('view_amt_type');
        $this->db->from('amount_type');
        $this->db->where("db_amt_type", $amount_type);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $view_type = $row->view_amt_type;
        }
        return $view_type;
    }

    public function sentPassword($user_id, $password, $user_name) {
        $this->load->model('mail_model');
        $letter_arr = $this->getLetterSetting();
        $subject = "Password Change";
        $message = "Dear $user_name,<br /> Your current password is : <br /><b> Password : " . $password . "</b>";
        $dt = date('Y-m-d h:m:s');

        $mailBodyDetails = "<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
</head>
<body >
<table id='Table_01' width='600'   border='0' cellpadding='0' cellspacing='0'>
	<tr><td COLSPAN='3'></td></tr>

		<td width='50px'></td>
<td   width='520px'  >
		Dear $user_name<br>  
                <p>
			<table border='0' cellpadding='0' width='60%' >
			<tr>
				<td colspan='2' align='center'><b>Your current password is : " . $password . "</b></td>
			</tr>
			<tr>
				<td colspan='2'>Thanking you,</td>
			</tr>
			
            <tr>
				<td colspan='2'><p align='left'>" . $letter_arr['company_name'] . "<br />Date:" . $dt . "<br />Place : " . $letter_arr['place'] . "</p></td>				
            </tr>
		</table>
	<tr>
			<td COLSPAN='3'>
			</td>
	</tr>
	</table>
	</body>
	</html>";

        $email = $this->mail_model->getEmailId($user_id);

        if ($email)
            $this->mail_model->sendEmail($mailBodyDetails, $email, $subject);

        return true;
    }

    public function getLatestBoardIDFromFTUsername($username) {
        $board_user_arr = array();
        $res = $this->db->select("id")->where("user_name", $username)->get("ft_individual");
        foreach ($res->result_array() as $row) {
            $ft_id = $row['id'];
        }
        if ($ft_id != '') {
            $board_id1 = $this->getBoardIDByUserRefId($ft_id, 1);

            if ($board_id1) {

                $board_no = 1;
                $board_user_id = $board_id1;
            }
            $board_username = $this->IdToUserNameBoard($board_user_id, 1);
            $board_user_arr = array("board_id" => $board_user_id, "board_username" => $board_username, "board_table_no" => $board_no);
        }

        return $board_user_arr;
    }

    public function getBoardIDByUserRefId($id, $board_table_no) {
        $user_id = 0;
        $goc_table_name = "auto_board_" . $board_table_no;
        $res = $this->db->select("id")->where("user_ref_id", $id)->order_by("date_of_joining", "DESC")->limit(1)->get("$goc_table_name");

        foreach ($res->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    public function getUserIDByBoardID($id, $board_table_no) {
        $user_id = 0;
        $goc_table_name = "auto_board_" . $board_table_no;
        $res = $this->db->select("user_ref_id")->where("id", $id)->limit(1)->get("$goc_table_name");

        foreach ($res->result() as $row) {
            $user_id = $row->user_ref_id;
        }
        return $user_id;
    }

    public function getRankName($rank) {
        $rank_name = NULL;
        $this->db->select('rank_name');
        $this->db->from('rank_details');
        $this->db->where('rank_id', $rank);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $rank_name = $row->rank_name;
        }
        return $rank_name;
    }

    public function getUserType($user_id) {
        $user_type = "";
        $this->db->select('user_type');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get('login_user');
        foreach ($res->result_array() as $row) {
            $user_type = $row['user_type'];
        }
        return $user_type;
    }

    public function getUserIdFromOrder($order_id) {
        $user_id = "";
        $this->db->select('user_id');
        $this->db->where('order_id', $order_id);
        $this->db->limit(1);
        $res = $this->db->get('orders');
        foreach ($res->result_array() as $row) {
            $user_id = $row['user_id'];
        }
        return $user_id;
    }

    public function getUserDetails($user_id, $type = 'user') {
        $user_details = array();
        if ($type == "employee") {
            $this->db->select('*');
            $this->db->from("employee_details");
            $this->db->where("user_detail_refid", $user_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                $user_details = $row;
            }
            $user_details["affiliates_count"] = 0;
            $user_details["status"] = "active";
            $user_details["rank"] = 0;
            $user_details["rank_status"] = "no";
            $user_details["rank_name"] = "NA";
        } else if ($type == "super_admin") {//for super admin
            $user_details["affiliates_count"] = 0;
            $user_details["status"] = "active";
            $user_details["rank"] = 0;
            $user_details["rank_status"] = "no";
            $user_details["rank_name"] = "NA";
            $user_details['user_detail_email'] = "sasaa@sss.lkj";
            $user_details['user_photo'] = "nonphoto.png";
        } else {

            $this->db->select('*');
            $this->db->from("user_details");
            $this->db->where("user_detail_refid", $user_id);
            $query = $this->db->get();
            foreach ($query->result_array() as $row) {
                if (!file_exists('public_html/images/profile_picture/' . $row['user_photo'])) {
                    $row['user_photo'] = 'nophoto.jpg';
                }
                $user_details = $row;
            }
            $user_details["affiliates_count"] = $this->getAffiliatesCount($user_id);
            $user_details["status"] = $this->getUserStatus($user_id);
            $user_details["rank"] = $this->getUserRank($user_id);
            $rank_status = 'yes';
            $rank_name = 'NA';
            if ($user_details["rank"] == 0) {
                $rank_status = "no";
            } else {
                $rank_name = $this->validation_model->getRankName($user_details["rank"]);
            }
            $user_details["rank_status"] = $rank_status;
            $user_details["rank_name"] = $rank_name;
        }
        return $user_details;
    }

    public function getAffiliatesCount($user_id) {
        $this->db->select('*');
        $this->db->from("ft_individual");
        $this->db->where("sponsor_id", $user_id);
        $count = $this->db->count_all_results();

        return $count;
    }

    public function getUserStatus($user_id) {
        $status = "0";

        $this->db->select('active');
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            if ($row->active == "yes")
                $status = "active";
            else
                $status = "inactive";
        }

        return $status;
    }

    public function getUserRankStatus() {
        $rank_status = "";
        $this->db->select('rank_status');
        $this->db->from("module_status");
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            $rank_status = $row->rank_status;
        }
        return $rank_status;
    }

    public function getCommonMailSettings($mail_type) {

        $mail_arr['subject'] = "hi sample subject";
        $mail_arr['mail_content'] = "<p>Your MLM software is now Activated.</p>

<p>Please save this message, so you will have permanent record of your Infinite MLM Software.I trusted that this mail finds you mutually excited about your new opportunity with Infinite Open Source Solutions LLP.<br />
Each of us will play a role to ensure your successful integration into the company.</p>

<p>Thank you for using Infinite MLM service</p>

<p>&nbsp;</p>
";
        return $mail_arr;
    }

    public function getVisitordetails() {
        $result = NULL;
        $this->db->select("*");
        $this->db->from("capture_details");
//        $this->db->where("visitor_status", "yes");
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $result[$i]['name'] = $row['name'];
            $result[$i]['id'] = $row['id'];
            $result[$i]['email'] = $row['email'];
            $result[$i]['user_id'] = $row['user_id'];
            $date = strtotime($row['date']);
            $newformat = date('d-m-Y', $date);
            $result[$i]['date'] = $newformat;

            $i++;
        }

        return $result;
    }

    public function getUserPhoneNumber($user_id) {
        $email_id = NULL;
        $this->db->select("user_detail_mobile");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $phone_num = $row->user_detail_mobile;
        }
        return $phone_num;
    }

    public function getUserAddress($user_id) {
        $this->db->select("user_detail_address");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $address = $row->user_detail_address;
        }
        return $address;
    }

    public function getUserAddress2($user_id) {
        $this->db->select("user_detail_address2");
        $this->db->from("user_details");
        $this->db->where("user_detail_refid", $user_id);
        $this->db->limit(1);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $address = $row->user_detail_address2;
        }
        return $address;
    }

    public function IdToUserNameWitoutLogin($user_id, $prefix) {
        $table = $prefix . '_ft_individual';
        $user_name = NULL;
        $this->db->select('user_name');
        $this->db->from($table);
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    public function getDefaulturrecy($user_id) {

        $currency = NULL;
        $this->db->select('default_currency');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $currency = $row->default_currency;
        }

        $currency_value = NULL;
        $this->db->select('value');
        $this->db->from('currency_details');
        $this->db->where('id', $currency);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $currency_value = $row->value;
        }

        return $currency_value;
    }

    public function convertToDefaultCurrency($user_id, $amount) {
        $status = $this->getMultyCurrencyStatus();

        if ($status == 'yes') {
            $currency = NULL;
            $this->db->select('default_currency');
            $this->db->from('ft_individual');
            $this->db->where('id', $user_id);
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $currency = $row->default_currency;
            }

            $currency_value = NULL;
            $this->db->select('value');
            $this->db->from('currency_details');
            $this->db->where('id', $currency);
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $currency_value = $row->value;
            }

            return $amount * $currency_value;
        } else {
            return $amount;
        }
    }

    public function convertToDollar($user_id, $amount) {
        $status = $this->getMultyCurrencyStatus();
        if ($status == 'yes') {
            $currency = NULL;
            $this->db->select('default_currency');
            $this->db->from('ft_individual');
            $this->db->where('id', $user_id);
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $currency = $row->default_currency;
            }

            $currency_value = NULL;
            $this->db->select('value');
            $this->db->from('currency_details');
            $this->db->where('id', $currency);
            $this->db->limit(1);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $currency_value = $row->value;
            }
            return $amount * (1 / $currency_value);
        } else {
            return $amount;
        }
    }

    public function getMultyCurrencyStatus() {
        $currency_status = "";
        $this->db->select('multy_currency_status');
        $this->db->from("module_status");
        $qry = $this->db->get();
        foreach ($qry->result() as $row) {
            $currency_status = $row->multy_currency_status;
        }
        return $currency_status;
    }

    public function sendInviteMail($mail_id, $subject, $message) {

        $email_details = array();
        $email_details = $this->getCompanyEmail();

        $this->mailObj->From = $email_details["from_email"];
        $this->mailObj->FromName = $email_details["from_name"];
        $this->mailObj->Subject = $subject;
        $this->mailObj->IsHTML(true);


        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($mail_id);

        $this->mailObj->Body = $message;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;

        return $res;
    }

    public function getUserBalanceAmount($user_id) {
//        $balance_amount = 0;
//        $this->db->select('balance_amount');
//        $this->db->from('user_balance_amount');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get();
//        foreach ($query->result() as $row) {
//            $balance_amount = $row->balance_amount;
//        }
//        return $balance_amount;
		return self::getUserCashBalanceAmount($user_id);
    }

    public function getUserCashBalanceAmount($user_id) {
        $this->load->model('ewallet_model');
        return (double) $this->ewallet_model->getCommission2( $user_id, Date( 'Y-m-d', strtotime( $this->ewallet_model->getJoiningDate( $user_id ) ) ), Date( 'Y-m-d' ) );
//        $balance_amount = 0;
//        $this->db->select('cash_account');
//        $this->db->from('user_balance_amount');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get();
//        foreach ($query->result() as $row) {
//            $balance_amount = $row->cash_account;
//        }
//        return $balance_amount;
    }

    public function getUserTradingBalanceAmount($user_id) {
//        $balance_amount = 0;
//        $this->db->select('trading_account');
//        $this->db->from('user_balance_amount');
//        $this->db->where('user_id', $user_id);
//        $query = $this->db->get();
//        foreach ($query->result() as $row) {
//            $balance_amount = $row->trading_account;
//        }
		//$balance_amount = 0;
		$this->load->model('trading_model');
		return (double) $this->trading_model->getCommission2( $user_id, Date( 'Y-m-d', strtotime( $this->trading_model->getJoiningDate( $user_id ) ) ), Date( 'Y-m-d' ) );
        //return $balance_amount;
    }

    public function getUserTotalTokens($user_id) {
        $this->load->model('package_model');
        return (int) $this->package_model->getTotalTokens($user_id);
        /*$tokens = 0;
        $this->db->select('tokens');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $tokens = $row->tokens;
        }
        return $tokens;*/
    }

	public function getUserDeductedTokens( $user_ID ) {
		$mining = $this->db->select_sum('amount', 'sum')
			->where('user_id', $user_ID)
			->get('minings')
			->first_row('array')['sum'];
		return (int) $mining;
	}
	public function getUserResultTokens( $user_ID ) {
		return self::getUserTotalTokens( $user_ID );// - self::getUserDeductedTokens( $user_ID );
	}
	public function addDeductedTokenAmount( $user_ID, $amount ) {
		$this->db->set('amount', $amount );
		$this->db->set('user_id', $user_ID );
		return $this->db->insert('minings');
	}
//	public function getUserDataWithTokens( $user_ID ) {
//		$total_tokens    = self::getUserTotalTokens( $user_ID );
//		$deducted_tokens = self::getUserDeductedTokens( $user_ID );
//
//
//		$mining = $this->db->select('amount')->from('user_id', $user_ID)->get('mining')->result_array();
//		if( ! empty( $mining ) ) {
//			//return
//		}
//
//	}


	public function getUserFTDetails($user_id) {
        $user_detail = array();
        $this->db->select("*");
        $this->db->from("ft_individual");
        $this->db->where("id", $user_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $user_detail = $row;
        }
        return $user_detail;
    }

    public function getWidthCieling() {
        $obj_arr = $this->getSettings();
        $width_cieling = $obj_arr["width_ceiling"];
        return $width_cieling;
    }

    public function getSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["pair_price"] = $row['pair_price'];
            $obj_arr["pair_ceiling"] = $row['pair_ceiling'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["product_point_value"] = $row['product_point_value'];
            $obj_arr["pair_value"] = $row['pair_value'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
            $obj_arr["level_commission_type"] = $row['level_commission_type'];
            $obj_arr["pair_commission_type"] = $row['pair_commission_type'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
            $obj_arr["percentorvalue"] = $row['percentorvalue'];
        }

        return $obj_arr;
    }

    public function userNameToIDBoard($username, $board_id) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from("auto_board_$board_id");
        $this->db->where('user_name', $username);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }

        return $user_id;
    }

    public function getRankId($user_id) {
        $rank_id = 0;
        $this->db->select('user_rank_id');
        $this->db->where('id', $user_id);
        $query = $this->db->get('ft_individual');

        foreach ($query->result() as $row) {
            $rank_id = $row->user_rank_id;
        }

        return $rank_id;
    }

    public function checkNewRank($referal_count) {
        $rank_id = 0;
        $this->db->select('rank_id');
        $this->db->where('referal_count <=', $referal_count);
        $this->db->where('rank_status', 'active');
        $this->db->limit(1);
        $this->db->order_by('rank_id', 'DESC');
        $res = $this->db->get('rank_details');
        foreach ($res->result() as $row) {
            $rank_id = $row->rank_id;
        }
        return $rank_id;
    }

    public function getUserLevel($user_id) {
        $level = "NA";
        $this->db->select('user_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level = $row->user_level;
        }

        return $level;
    }

    public function getUserData($user_id, $field_name = "") {
        $data = null;
        if ($field_name != "") {
            $this->db->select($field_name);
            $this->db->from('user_details');
            $this->db->where('user_detail_refid', $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $data = $row->$field_name;
            }
        }
        return $data;
    }

    public function getMLMPlan() {
        $mlm_plan = "NA";
        $this->db->select('mlm_plan');
        $this->db->from('module_status');
        $this->db->where('id', 1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $mlm_plan = $row->mlm_plan;
        }
        return $mlm_plan;
    }

    public function getUserIDFromCustomerID($customer_id) {
        $user_id = 0;
        $this->db->select('id');
        $this->db->from('ft_individual');
        $this->db->where('oc_customer_ref_id', $customer_id);
        $this->db->limit(1);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $user_id = $row->id;
        }
        return $user_id;
    }

    function getOcCustomerId($user_id) {
        $oc_customer_ref_id = 0;
        $this->db->select('oc_customer_ref_id');
        $this->db->where('id', $user_id);
        $res = $this->db->get('ft_individual');
        foreach ($res->result() as $row) {
            $oc_customer_ref_id = $row->oc_customer_ref_id;
        }
        return $oc_customer_ref_id;
    }

    public function getAllUserDetails($user_id) {
        $user_details = array();
        $this->db->select('*');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $user_details = $row;
            if (!file_exists('public_html/images/profile_picture/' . $row['user_photo'])) {
                $user_details['user_photo'] = 'nophoto.jpg';
            }
        }

        return $user_details;
    }

    public function getUserReferralCount($user_id) {
        $this->db->where('sponsor_id', $user_id);
        $count = $this->db->count_all_results('ft_individual');
        return $count;
    }

    public function getInfoDetails($type, $lang_id) {
        $message = '';
        $this->db->select('message');
        $this->db->where('lang_ref_id', $lang_id);
        $this->db->where('info_type', $type);
        $this->db->limit(1);
        $query = $this->db->get('info_box');
        foreach ($query->result_array() as $row) {
            $message = $row['message'];
        }
        return $message;
    }

    public function EmployeeIdToUserName($user_id) {
        $user_name = 0;
        $this->db->select("user_name");
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get('login_employee');
        foreach ($query->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }
    
  public function employeeNameToID($user_name) {
        $user_id = 0;
        $this->db->select("user_id");
        $this->db->where('user_name', $user_name);
        $this->db->limit(1);
        $query = $this->db->get('login_employee');
        foreach ($query->result() as $row) {
            $user_id = $row->user_id;
        }
        return $user_id;
    }


    public function getColumnFromConfig( $column ) {
		$val = 0;
		$this->db->select($column);
		$this->db->from('configuration');
		$this->db->where('id', 1);
		$query = $this->db->get();
        foreach( $query->result() as $row ) {
            $val = $row->$column;
        }
        return $val;
    }
	public function updateColumnFromConfig( array $column ) {
		$this->db->where('id', 1);
		return $this->db->update('configuration', $column);
	}
    public function getCountOfRegisteredUsers() {

        return $this->db->select('COUNT(`id`) as ctr', false )->get('login_user')->first_row('array')['ctr'];
    }

    public function get_option( $name, array $params = null ) {
		if( ! is_null( $params ) ) {
			$this->db->select( implode(',', $params ) );
			$this->db->from('options');
			$this->db->where('option_name', $name );
			return $this->db->get()->first_row('array');
		}
        $this->db->select('option_value');
		$this->db->from('options');
		$this->db->where('option_name', $name );
		$query  = $this->db->get()->first_row('array');
		return isset( $query['option_value'] ) ? $query['option_value'] : null;

    }

	public function update_option( $name, $value ) {
		if( is_array( $value ) ) {
			$this->db->where('option_name', $name );
			return $this->db->update('options', $value);
		}
        $this->db->set('option_value', $value );
		$this->db->where('option_name', $name );
		return $this->db->update('options');

    }


}
