<?php

Class Validation_Android extends CI_Model {

        
	public function __construct() {
		parent::__construct();
	}

	public function stripTagsPostArray($post_arr = array()) {
		$temp_arr = array();
		if (count($post_arr) > 1) {
			foreach ($post_arr AS $key => $value) {
				$temp_arr["$key"] = strip_tags($post_arr["$key"]);
			}
		}
		return $temp_arr;
	}

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

	public function getSponsorId($user_id) {
		$sponsor_id = NULL;
		$this->db->select('father_id');
		$this->db->from('ft_individual_unilevel');
		$this->db->where('id', $user_id);
		$this->db->limit(1);
		$query = $this->db->get();

		foreach ($query->result() as $row) {
			$sponsor_id = $row->father_id;
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
		$img = array();
		$this->db->select('user_photo');
		$this->db->from('user_details');
		$this->db->where('user_detail_refid', $user_id);
		$this->db->limit(1);
		$res = $this->db->get();
		foreach ($res->result_array() as $row) {
			$img = $row['user_photo'];
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

	public function isUserAvailableinBoard($user_id) {
		$flag = false;
		$count = 0;
		$this->db->select("*")->where("id", $user_id)->get("auto_board_1");
		$count = $this->db->count_all_results();
		if ($count > 0) {
			$flag = true;
		}
		return $flag;
	}

	public function getUserFullName($user_id) {
		$user_name = NULL;
		$this->db->select('user_detail_name');
		$this->db->from('user_details');
		$this->db->where('user_detail_refid', $user_id);
		$this->db->limit(1);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$user_name = $row->user_detail_name;
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

	public function mailUsed($mail) {
		//is it used in an invitation
		$this->db->select("COUNT(*) AS cnt");
		$this->db->from("user_invitations");
		$this->db->where("email", $mail);
		$qr = $this->db->get();
		foreach ($qr->result() as $row) {
			$count = $row->cnt;
		}
		$in_invitation = ($count > 0) ? true : false;
		//is it used by an account ( activated or not)
		if (!$in_invitation) {
			$this->db->select("COUNT(*) AS cnt");
			$this->db->from("user_details");
			$this->db->where("user_detail_email", $mail);
			$qr = $this->db->get();
			foreach ($qr->result() as $row) {
				$count = $row->cnt;
			}
			return ($count > 0) ? true : false;
		}
		return true;
	}

	public function isMailInAccount($mail) {
		$this->db->select("COUNT(*) AS cnt");
		$this->db->from("user_details");
		$this->db->where("user_detail_email", $mail);
		$qr = $this->db->get();
		foreach ($qr->result() as $row) {
			$count = $row->cnt;
		}
		return ($count > 0) ? true : false;
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
		$this->db->where('position', $postion);
		$this->db->where_in('active', array($active, 'yes'));
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
		foreach ($qr->result_array() as $row) {

			$id = $row['father_id'];

			if ($id == 0) {

				$row_data['id'] = $row['father_id'];
				$row_data['name'] = "admin";
			} else {

				$this->db->select("user_name");
				$this->db->from($table_prefix . "ft_individual");
				$this->db->where("id", $id);
				$sql = $this->db->get();
				foreach ($sql->result() as $spncr) {
					$row_data['id'] = $id;
					$row_data['name'] = $spncr->user_name;
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

	public function isLegAvailable($sponserid, $sponserleg) {
		$flag = false;
		$count = 0;
		$this->db->select("COUNT(*) AS cnt");
		$this->db->from("ft_individual");
		$this->db->where('father_id', $sponserid);
		$this->db->where('position', $sponserleg);
		$this->db->where_not_in('active', array('server', 'no'));
		$qr = $this->db->get();
		foreach ($qr->result() as $row) {
			$count = $row->cnt;
		}

		if ($sponserid == "") {
			$flag = false;
		} else if ($sponserleg == "") {
			$flag = false;
		} else if ($count < 1) {
			$user = $this->isUserAvailable($sponserid);
			if (!$user) {
				$flag = false;
			} else {
				$flag = true;
			}
		}

		return $flag;
	}

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
		$this->db->from("product as pr");
		$this->db->join("ft_individual as ft", "pr.product_id = ft.product_id", "INNER");
		$this->db->where("ft.id", $user_id);
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$product_name = $row->product_name;
		}
		return $product_name;
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
		$this->db->select("user_id");
		$this->db->from("login_user");
		$this->db->where("user_type", 'admin');
		$this->db->limit(1);
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			$user_id = $row->user_id;
		}
		return $user_id;
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
		foreach ($res->result() as $row) {
			$details["company_name"] = $row->company_name;
			$details["logo"] = $row->logo;
			$details["email"] = $row->email;
			$details["phone"] = $row->phone;
			$details["favicon"] = $row->favicon;
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
		$count = NULL;
		$this->db->select("COUNT(*) AS cnt");
		$this->db->from("ft_individual_unilevel");
		$this->db->where('father_id', $id);

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
		$this->db->where('referal_count <', $num);
		$this->db->limit(1);
		$res = $this->db->get('rank_details');

		foreach ($res->result() as $row) {
			$count = $row->referal_count;
		}
		return $num;
	}

	public function getPrdocutName($prodcut_id) {
		$prod_name = NULL;
		$this->db->select("product_name");
		$this->db->from('product');
		$this->db->where("product_id", $prodcut_id);
		$res = $this->db->get();
		foreach ($res->result() as $row) {
			$prod_name = $row->product_name;
		}
		return $prod_name;
	}

	public function insertUserActivity($login_id, $activity, $done_by = "admin", $done_by_type = '') {
		$date = date("Y-m-d H:i:s");
		$ip_adress = $_SERVER['REMOTE_ADDR'];
		$this->db->set('user_id', $login_id);
		$this->db->set('activity', $activity);
		$this->db->set('done_by', $done_by);
		$this->db->set('done_by_type', $done_by_type);
		$this->db->set('ip', $ip_adress);
		$this->db->set('date', $date);
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
		if (!$res) {
			$arr['error_info'] = $this->mailObj->ErrorInfo;
		}

		return $res;
	}

	public function sendEmailToMail($mailBodyDetails, $email, $subject) {

		$email_details = array();
		$email_details = $this->getCompanyEmail();

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
		if (!$res) {
			$arr['error_info'] = $this->mailObj->ErrorInfo;
		}

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
		require_once "mail_model.php";
		$this->mail = new mail_model();
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

		$email = $this->mail->getEmailId($user_id);

		if ($email) {
			$this->mail->sendEmail($mailBodyDetails, $email, $subject);
		}

		return true;
	}

	///////////////////////////////  EDITED BY YASIR   ////////////////////////////////////

	public function getLatestBoardIDFromFTUsername($username) {
		$board_user_arr = array();
		$res = $this->db->select("id")->where("user_name", $username)->get("ft_individual");
		foreach ($res->result_array() as $row) {
			$ft_id = $row['id'];
		}
		if ($ft_id != '') {
			$board_id1 = $this->getAutoIDByUserRefId($ft_id, 1);

			if ($board_id1) {

				$board_no = 1;
				$board_user_id = $board_id1;
			}
			$board_username = $this->IdToUserNameBoard($board_user_id, 1);
			$board_user_arr = array("board_id" => $board_user_id, "board_username" => $board_username, "board_table_no" => $board_no);
		}

		return $board_user_arr;
	}

	public function getAutoIDByUserRefId($id, $board_table_no) {
		$user_id = '';
		$goc_table_name = "auto_board_1";
		$res = $this->db->select("id")->where("user_ref_id", $id)->order_by("date_of_joining", "DESC")->get("$goc_table_name");

		foreach ($res->result() as $row) {
			$user_id = $row->id;
		}
		return $user_id;
	}

	public function getRankName($rank) {
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
	///////////////////////////////  EDITED BY YASIR   ////////////////////////////////////
}
