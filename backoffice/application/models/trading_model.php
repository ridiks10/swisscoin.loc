<?php

class trading_model extends inf_model {

    private $mailObj;

    public function __construct() {
        $this->load->model('validation_model');
        $this->load->model('misc_model');

        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
    }

    public function userNameToID($user_name) {
        $user_id = $this->validation_model->userNameToID($user_name);
        return $user_id;
    }

    public function IdToUserName($user_name) {
        $user_id = $this->validation_model->IdToUserName($user_name);
        return $user_id;
    }

    public function getAllProducts($status) {
        $i = 0;
        $this->db->select('product_id');
        $this->db->select('product_name');
        $this->db->select('active');
        $this->db->select('date_of_insertion');
        $this->db->select('prod_id');
        $this->db->select('product_value');
        $this->db->from('package');
        $this->db->where('active', $status);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $product_detail['details' . $i]['id'] = $row['product_id'];
            $product_detail['details' . $i]['name'] = $row['product_name'];
            $product_detail['details' . $i]['active'] = $row['active'];
            $product_detail['details' . $i]['date'] = $row['date_of_insertion'];
            $product_detail['details' . $i]['prod_id'] = $row['prod_id'];
            $product_detail['details' . $i]['product_value'] = $row['product_value'];
            $i++;
        }
        return $product_detail;
    }

    public function getAllEwalletAmounts() {
        $i = 0;
        $amount_detail = array();
        $this->db->select('id,amount');
        $this->db->from('pin_amount_details');
        $this->db->order_by("amount", "asc");
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $amount_detail["details$i"]["id"] = $row['id'];
            $amount_detail["details$i"]["amount"] = $row['amount'];
            $i++;
        }
        return $amount_detail;
    }

    public function getBalanceAmount($user_id) {
        $this->db->select('balance_amount');
        $this->db->from('user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->balance_amount;
    }

    public function getTransactionFee() {
        $this->db->select('trans_fee');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->trans_fee;
    }

    public function getBalanceAmountforMobile($user_id, $table_perfix) {
        $this->db->select('balance_amount');
        $this->db->from($table_perfix . '_user_balance_amount');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->balance_amount;
    }

    public function getUserPassword($user_id) {
        $this->db->select('tran_password');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row)
            return $row->tran_password;
    }

    public function insertBalAmountDetails($from_user_id, $to_user_id, $trans_amount, $amount_type = '', $transaction_concept = '', $trans_fee = '') {
        $date = date('Y-m-d H:i:s');

        if ($amount_type != '') {
            $data = array(
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => $amount_type,
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee
            );
            $query = $this->db->insert('fund_transfer_details', $data);
        } else {
            $data = array(
                'from_user_id' => $from_user_id,
                'to_user_id' => $to_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => 'user_credit',
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee
            );
            $query = $this->db->insert('fund_transfer_details', $data);
            $data = array(
                'from_user_id' => $to_user_id,
                'to_user_id' => $from_user_id,
                'amount' => $trans_amount,
                'date' => $date,
                'amount_type' => 'user_debit',
                'transaction_concept' => $transaction_concept,
                'trans_fee' => $trans_fee
            );
            $query = $this->db->insert('fund_transfer_details', $data);
        }
    }

    public function updateBalanceAmountDetailsFrom($from_user_id, $trans_amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $trans_amount . ',2)', FALSE);
        $this->db->where('user_id', $from_user_id);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function updateBalanceAmountDetailsTo($to_user_id, $trans_amount) {

        $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $trans_amount . ',2)', FALSE);
        $this->db->where('user_id', $to_user_id);
        $query = $this->db->update('user_balance_amount');

        return $query;
    }

    public function getProductAmount($product_id) {
        $prod_arr = array();
        $this->db->select('product_value');
        $this->db->select('product_name');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row10) {
            $prod_arr['product_value'] = $row10['product_value'];
            $prod_arr['product_name'] = $row10['product_name'];
        }
        return $prod_arr;
    }

    public function getEpinAmount($amount_id) {
        $amount = 0;
        $this->db->select('amount');
        $this->db->from('pin_amount_details');
        $this->db->where('id', $amount_id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $amount = $row['amount'];
        }
        return $amount;
    }

    public function updateBalanceAmount($user_id, $bal) {
        $bal = round($bal, 2);
        $data = array(
            'balance_amount' => $bal
        );
        $this->db->where('user_id', $user_id);
        $result = $this->db->update('user_balance_amount', $data);
        return $result;
    }

    public function getUserName_details() {
        $this->db->select('id,user_name');
        $this->db->from('ft_individual');
        $this->db->where('active !=', 'server');
        $this->db->group_by('id');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {
            $name_arr[$i]['id'] = $row->id;
            $name_arr[$i]['user_name'] = $row->user_name;
            $i++;
        }
        return $name_arr;
    }

    public function getEwalletDetails($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $fund_transfer_details = $this->table_prefix . "fund_transfer_details";

        $qr = "SELECT to_user_id,amount,date FROM $fund_transfer_details WHERE from_user_id='$id' ";
        $result = $this->selectData($qr, "ERROR-HFGJKHGKHKGHKJGJK");
        $i = 0;
        while ($row = mysql_fetch_array($result)) {
            $arr[$i]["amount"] = $row['amount'];
            $arr[$i]["date"] = $row['date'];
            $arr[$i]["to_user_name"] = $this->getName($row['to_user_id']);
            $i++;
        }
        return $arr;
    }

    public function getName($id, $table_prefix = "") {
        $this->db->select('user_name');
        $this->db->from($table_prefix . 'ft_individual');
        $this->db->where('id', $id);
        $result = $this->db->get();
        foreach ($result->result() as $row)
            return $row->user_name;
    }

    public function getBalancePin($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";

        $select = "SELECT COUNT(*) AS balance FROM $pin_numbers WHERE allocated_user_id='$user_id' AND status='yes'";
        $res = $this->selectData($select, "Error on select balance pin");
        $row = mysql_fetch_array($res);
        $balance = intval($row['balance']);
        return $balance;
    }

    public function balanceEpinUSer($user_id) {
        if ($this->table_prefix == '') {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . 'pin_numbers';
        $select = "SELECT COUNT(*) AS balance FROM $pin_numbers WHERE allocated_user_id='$user_id' AND status='yes'";
        $res = $this->selectData($select, 'Error on select balance pinuser');
        $row = mysql_fetch_array($res);
        $balance = intval($row['balance']);
        return $balance;
    }

    public function generateEpin($user_id, $how_much_pin, $to_user_name_id, $pass) {

        if ($_SESSION['user_type'] == "admin") {
            $pass_table = $this->getPass($user_id);
        } else {
            $pass_table = $this->getPass($user_id);
        }
        $pass_c = md5($pass);
        if ($pass_table == $pass_c) {
            if ($this->table_prefix == '') {
                $this->table_prefix = $_SESSION['table_prefix'];
            }
            $pin_numbers = $this->table_prefix . "pin_numbers";

            $delete = "DELETE FROM $pin_numbers WHERE allocated_user_id = '$user_id' AND status='yes' LIMIT $how_much_pin";
            $res = $this->deleteData($delete, "Error on delete E-Pin");
            $OBJ_PIN = new pin_model();

            $status = 'yes';
            $uploded_date = date('Y-m-d');


            for ($m = 0; $m < $how_much_pin; $m++) {
                $passcode = $this->misc_model->getRandStr(9, 9);
                $res = $OBJ_PIN->insertPasscode($passcode, $status, $uploded_date, $to_user_name_id, $to_user_name_id, $product);
            }
            $flag = true;
        } else {
            $flag = false;
            echo "<script>alert('you enter invalid password');</script>";
        }
        return $flag;
    }

    public function getPass($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_user = $this->table_prefix . "login_user";

        $qr = "SELECT password FROM $login_user WHERE user_id=$id";
        $result = $this->selectData($qr, "ERROJGKJJKKJHKKJGHK");
        $row = mysql_fetch_array($result);
        return $row['password'];
    }

    public function allocatePasscodes($pro_status, $pin_count, $passcode, $status, $uploded_date, $admin_id, $allocate_id, $product) {
        require_once 'pin_model.php';

        $OBJ_PIN = new pin_model();

        for ($m = 0; $m < $pin_count; $m++) {
            $passcode = $this->misc_model->getRandStr(9, 9);
            $res = $OBJ_PIN->insertPasscode($passcode, $status, $uploded_date, $admin_id, $allocate_id, $product, 'yes');
        }
        return $res;
    }

    public function addUserBalanceAmount($to_userid, $amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount + ' . $amount . ',2)', FALSE);
        $this->db->where('user_id', $to_userid);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function deductUserBalanceAmount($to_userid, $amount) {
        $this->db->set('balance_amount', 'ROUND(balance_amount - ' . $amount . ',2)', FALSE);
        $this->db->where('user_id', $to_userid);
        $query = $this->db->update('user_balance_amount');
        return $query;
    }

    public function getUserEwalletDetails($user_id, $from_date, $to_date) {
        $details = array();
        $this->db->select_sum('amount');
        $this->db->select_sum('trans_fee');
        $this->db->select('date');
        $this->db->select('amount_type');
        $this->db->from('fund_transfer_details');
        $this->db->where('to_user_id', $user_id);
        $this->db->where("date BETWEEN '$from_date' AND '$to_date'");
        $this->db->group_by('amount_type');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result_array() as $row) {
            $details[$i]['total_amount'] = $row['amount'];
            $details[$i]['date'] = $row['date'];
            $details[$i]['amount_type'] = $row['amount_type'];
            $details[$i]['trans_fee'] = $row['trans_fee'];
            $i++;
        }
        return $details;
    }

    public function isUserNameAvailable($user_name) {
        $res = $this->validation_model->isUserNameAvailable($user_name);
        return $res;
    }

    public function getPinAmount() {
        $this->db->select('pin_amount');
        $this->db->from('pin_config');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $value = $row['pin_amount'];
        }
        return $value;
    }

    public function getPinAmountForMoblie($table_prefix) {
        $this->db->select('pin_amount');
        $this->db->from($table_prefix . '_pin_config');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $value = $row['pin_amount'];
        }
        return $value;
    }

    public function allocatePin($pin_num, $product = "") {
        $count = $this->getAvailablePinCount($product);
        $pins = $this->getPinsToAllocate($pin_num, $product);
        if ($count >= $pin_num) {
            $user_id = $this->session->userdata['inf_logged_in']['user_id'];
            for ($i = 0; $i < $pin_num; $i++) {
                $pin = $pins["pin$i"];
                $id = $pins["id$i"];
                $this->allocatePinToUser($user_id, $pin, $id);
            }
            $flag = 1;
        } else {
            $flag = 0;
        }
        return $flag;
    }

    public function getPinsToAllocate($pin_num, $product = "") {
        $pin = array();
        if ($product != "") {
            $this->db->select('pin_numbers');
            $this->db->select('pin_id');
            $this->db->from('pin_numbers');
            $this->db->where('pin_prod_refid', $product);
            $this->db->where('allocated_user_id', 'NA');
            $this->db->where('status', 'yes');
            $this->db->limit($pin_num);
            $res = $this->db->get();
        } else {
            $this->db->select('pin_numbers');
            $this->db->select('pin_id');
            $this->db->from('pin_numbers');
            $this->db->where('allocated_user_id', 'NA');
            $this->db->where('status', 'yes');
            $this->db->limit($pin_num);
            $res = $this->db->get();
        }
        $i = 0;
        foreach ($res->result_array() as $row) {
            $pin["pin$i"] = $row['pin_numbers'];
            $pin["id$i"] = $row['pin_id'];
            $i++;
        }

        return $pin;
    }

    public function allocatePinToUser($user_id, $pin, $id) {
        $date = date("Y-m-d H:i:s");
        $data = array(
            'allocated_user_id' => $user_id,
            'pin_alloc_date' => $date,
            'purchase_status' => 'yes',
        );
        $this->db->where('pin_id', $id);
        $this->db->where('pin_numbers', $pin);
        $this->db->update('pin_numbers', $data);
    }

    public function getAvailablePinCount($product = "") {
        if ($product != "") {
            $this->db->select('COUNT(allocated_user_id) AS cnt');
            $this->db->from('pin_numbers');
            $this->db->where('pin_prod_refid', $product);
            $this->db->where('allocated_user_id', 'NA');
            $this->db->where('status', 'yes');
            $res = $this->db->get();
        } else {
            $this->db->select('COUNT(allocated_user_id) AS cnt');
            $this->db->from('pin_numbers');
            $this->db->where('allocated_user_id', 'NA');
            $this->db->where('status', 'yes');
            $res = $this->db->get();
        }
        foreach ($res->result_array() as $row) {
            $cnt = $row['cnt'];
        }
        return $cnt;
    }

    public function getJoiningDate($user_id, $table_perfix = "") {

        if ($table_perfix == '')
            $table_name = 'ft_individual';
        else {
            $table_name = $table_perfix . '_ft_individual';
        }
        $table_name = $table_perfix . 'ft_individual';
        $this->db->select('date_of_joining');
        $this->db->from($table_name);
        $this->db->where('id', $user_id);
        $res = $this->db->get();
        foreach ($res->result() as $row)
            return $row->date_of_joining;
    }

    function getCommissionDetails2( $user_id, $from_date = null, $to_date = null, array $pagination = [], $initial_balance = 0 ) {

		$isTimeQuery = false;
		if( ! is_null( $from_date ) && ! is_null( $to_date ) ) {
			$_start  = DateTime::createFromFormat( 'Y-m-d', $from_date )->setTime( 0, 0 )->format('Y-m-d H:i:s');
			$_finish = DateTime::createFromFormat( 'Y-m-d', $to_date )->setTime( 23, 59 )->format('Y-m-d H:i:s');
			$isTimeQuery = ! $isTimeQuery;
		}
		$this->db->select('la.id as id');
		$this->db->select( "la.trading_account as total_amount" );
		$this->db->select( "at.view_amt_type as amount_type" );
		$this->db->select( "UNIX_TIMESTAMP( la.date_of_submission ) as full_date" );
		$this->db->select( "STR_TO_DATE( la.date_of_submission, ('%Y-%m-%d') ) as date" );
		$this->db->select( "NULLIF(fi.user_name, ('')) as from_user_name" );
		$this->db->from( "leg_amount as la" );
		$this->db->join( 'amount_type as at', 'at.db_amt_type = la.amount_type', 'inner' );
		$this->db->join( 'ft_individual as fi', 'fi.id = la.from_id', 'left' );
		$this->db->where( 'la.user_id', $user_id );
		if( $isTimeQuery ) {
			$this->db->where("la.date_of_submission BETWEEN '$_start' AND '$_finish'");
		}
		$leg_details = $this->db->select_string();

		$this->db->select('epd.id as id');
		$this->db->select( "epd.used_amount as total_amount" );
		$this->db->select( "epd.used_for as amount_type" );
		$this->db->select( "UNIX_TIMESTAMP( epd.date ) as full_date" );
		$this->db->select( "STR_TO_DATE( epd.date, ('%Y-%m-%d') ) as date" );
		$this->db->select( "fi.user_name as from_user_name" );
		$this->db->from( "ewallet_payment_details as epd" );
		$this->db->join( 'ft_individual as fi', 'fi.id = epd.user_id', 'left' );
		$this->db->where( "epd.used_user_id", $user_id );
		$this->db->where_in( 'epd.payed_account', 'trading' );
		if ( $isTimeQuery ) {
			$this->db->where( "epd.date BETWEEN '$_start' AND '$_finish'" );
		}
		$ewallet_details = $this->db->select_string();

		$sql = sprintf( " %s UNION ALL %s ORDER BY full_date DESC, id DESC" , $leg_details, $ewallet_details );

		if ( ! empty( $pagination ) ) {
			$sql .= sprintf(" LIMIT %d OFFSET %d", intval( $pagination['limit'] ), intval( $pagination['offset'] ) );
		}
		$query   = $this->db->query( $sql );
		$details = $query->result_array();
		if ( empty( $details ) )
			return [];
		$balance = $initial_balance;
		$details = array_reverse( $details );
		foreach ( $details as &$detail ) {
			$balance += ( round( $detail['total_amount'], 2 ) * ( in_array( $detail['amount_type'], [
					'user_debit', 'admin_debit', 'payout_released', 'pin_purchased', 'annual_fee', 'registration', 'repurchase'
				] ) ? -1 : 1 ) );
			$detail['balance'] = $balance;
		}
		return array_reverse($details);
    }

    public function getCommissionDetails($user_id, $from_date, $to_date, array $arr ) {

        $i = 0;
        $details = array();
        $from_user_name = '';
        if ($from_date != null && $to_date != null) {
            $start = $from_date . ' 00:00:00';
            $end = $to_date . ' 23:59:59';
        }

        $this->db->select('amount_payable,total_amount,amount_type,trading_account,date_of_submission,from_id');
        $this->db->from('leg_amount');
        $this->db->where('user_id', $user_id);
        if ($from_date != '' && $to_date != '') {
            $this->db->where("date_of_submission BETWEEN '$start' AND '$end'");
        }
        $this->db->order_by('date_of_submission');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details[ $i ]['total_amount']   = $row['trading_account'];
            $details[ $i ]['from_user_name'] = $this->validation_model->IdToUserName( $row['from_id'] );
            $details[ $i ]['amount_type']    = $this->validation_model->getViewAmountType( $row['amount_type'] );
            $details[ $i ]['date']           = date( 'Y-m-d', strtotime( $row['date_of_submission'] ) );
            $details[ $i ]['full_date']      = strtotime( $row['date_of_submission'] );
            $i++;
        }

        $this->db->select('user_id,used_amount,used_for,date');
        $this->db->from('ewallet_payment_details');
        $this->db->where_in('payed_account', 'trading');
        $this->db->where('used_user_id', $user_id);
		$this->db->limit(30);
        if ($from_date != '' && $to_date != '') {
            $this->db->where("date BETWEEN '$start' AND '$end'");
        }
        $query4 = $this->db->get();
        foreach ($query4->result_array() as $row) {
            $details[ $i ]['total_amount']   = $row['used_amount'];
            $details[ $i ]['amount_type']    = $row['used_for'];
            $details[ $i ]['date']           = date( 'Y-m-d', strtotime( $row['date'] ) );
            $details[ $i ]['full_date']      = strtotime( $row['date'] );
            $details[ $i ]['from_user_name'] = $this->validation_model->IdToUserName( $row['user_id'] );
            $i++;
        }

        if (count($details) > 0) {
            foreach ($details as $key => $row) {
                $volume[$key] = $row['full_date'];
            }
            array_multisort($volume, SORT_ASC, $details);
        }
        $balance = 0;
        foreach ($details as &$detail) {
            $balance += (round($detail['total_amount'], 2) * (in_array($detail['amount_type'], [
                'user_debit', 'admin_debit', 'payout_released', 'pin_purchased', 'annual_fee', 'registration', 'repurchase'
            ]) ? -1 : 1));
            $detail['balance'] = $balance;
        }

        return array_reverse($details);
    }

	public function getCommission2( $user_id, $from_date = null, $to_date = null, $output = false, array $pagination = null ) {
		$isTimeQuery = false;
		if( ! empty( $from_date ) && ! empty( $to_date ) ) {
			$_start  = DateTime::createFromFormat( 'Y-m-d', $from_date )->setTime( 0, 0 )->format('Y-m-d H:i:s');
			$_finish = DateTime::createFromFormat( 'Y-m-d', $to_date )->setTime( 23, 59 )->format('Y-m-d H:i:s');
			$isTimeQuery = ! $isTimeQuery;
		}
		$this->db->select('la.id as id');
		$this->db->select( "la.trading_account as total_amount" );
		$this->db->select( "at.view_amt_type as amount_type" );
		$this->db->select( "UNIX_TIMESTAMP( la.date_of_submission ) as full_date" );
		$this->db->from( "leg_amount as la" );
		$this->db->join( 'amount_type as at', 'at.db_amt_type = la.amount_type', 'inner' );
		$this->db->where( 'la.user_id', $user_id );
		if( $isTimeQuery ) {
			$this->db->where("la.date_of_submission BETWEEN '$_start' AND '$_finish'");
		}
		$leg_details = $this->db->select_string();

		$this->db->select('epd.id as id');
		$this->db->select( "epd.used_amount as total_amount" );
		$this->db->select( "epd.used_for as amount_type" );
		$this->db->select( "UNIX_TIMESTAMP( epd.date ) as full_date" );
		$this->db->from( "ewallet_payment_details as epd" );
		$this->db->where( "epd.used_user_id", $user_id );
		$this->db->where_in( 'epd.payed_account', 'trading' );
		if ( $isTimeQuery ) {
			$this->db->where( "epd.date BETWEEN '$_start' AND '$_finish'" );
		}
		$ewallet_details = $this->db->select_string();

		$sql     = sprintf( " %s UNION ALL %s ORDER BY full_date DESC, id DESC" , $leg_details, $ewallet_details );
		$query   = $this->db->query( $sql );
		$details = $query->result_array();

		if ( empty( $details ) )
			return 0;

		$balance = 0;
		$count   = 0;
		$details = array_reverse( $details );
		foreach ( $details as &$detail ) {
			$balance += ( round( $detail['total_amount'], 2 ) * ( in_array( $detail['amount_type'], [
					'user_debit', 'admin_debit', 'payout_released', 'pin_purchased', 'annual_fee', 'registration', 'repurchase'
				] ) ? -1 : 1 ) );
			unset( $detail['amount_type'] );
			unset( $detail['full_date'] );
			$detail['balance'] = $balance;
			$count++;
		}
		$details = array_reverse( $details );
		$initial_balance = 0;
		if ( is_array( $pagination ) and  $count > ( $pagination['limit'] + $pagination['offset'] ) ) {
			$right = array_slice( $details, $pagination['limit'] + $pagination['offset'], $count );
			if ( ! empty( $right ) ) {
				$initial_balance = current( $right )['balance'];
			}
		}
		if ( $output ) {
			return [
				'initial_balance' => $initial_balance,
				'total_amount'    => $balance,
				'num_rows'        => $count
			];
		}
		else return $balance;
	}

    public function getCommission($user_id, $from_date, $to_date, $output = false ) {


    $balance = 0;
    if ($from_date != '' && $to_date != '') {
        $start = $from_date . ' 00:00:00';
        $end = $to_date . ' 23:59:59';
    }

    $this->db->select('amount_payable,total_amount,amount_type,trading_account,date_of_submission,from_id');
    $this->db->from('leg_amount');
    $this->db->where('user_id', $user_id);
    if ($from_date != '' && $to_date != '') {
        $this->db->where("date_of_submission BETWEEN '$start' AND '$end'");
    }
    $this->db->order_by('date_of_submission');
    $query = $this->db->get();
	$count = 0;
    foreach ($query->result_array() as $row) {
        $balance += (round($row['trading_account'], 2) * (in_array($this->validation_model->getViewAmountType($row['amount_type']), [
                'user_debit', 'admin_debit', 'payout_released', 'pin_purchased', 'annual_fee', 'registration', 'repurchase'
            ]) ? -1 : 1));
		$count++;
    }

    $this->db->select('user_id,used_amount,used_for,date');
    $this->db->from('ewallet_payment_details');
    $this->db->where_in('payed_account', 'trading');
    $this->db->where('used_user_id', $user_id);
    if ($from_date != '' && $to_date != '') {
        $this->db->where("date BETWEEN '$start' AND '$end'");
    }
    $query4 = $this->db->get();
    foreach ($query4->result_array() as $row) {
        $balance += (round($row['used_amount'], 2) * (in_array($row['used_for'], [
                'user_debit', 'admin_debit', 'payout_released', 'pin_purchased', 'annual_fee', 'registration', 'repurchase'
            ]) ? -1 : 1));
		$count++;
    }

    return $output ? ['total_amount' => $balance, 'num_rows' => $count ] : $balance;
}

    public function getCommissionDetailsForMobile($user_id, $table_prefix, $from_date, $to_date, $product_status) {
        $i = 0;
        $details = array();
        $from_user_name = "";
        while ($from_date <= $to_date) {
            $start = $from_date . " 00:00:00";
            $end = $from_date . " 23:59:59";
            $this->db->select('amount_payable');
            $this->db->select('total_amount');
            $this->db->select('amount_type');
            $this->db->select('date_of_submission');
            $this->db->from($table_prefix . '_leg_amount');
            $this->db->where('user_id', $user_id);
            $this->db->where("date_of_submission BETWEEN '$start' AND '$end'");
            $this->db->order_by('date_of_submission');
            $res2 = $this->db->get();
            foreach ($res2->result_array() as $row2) {
                $details[$i]['total_amount'] = $row2['amount_payable'];
                $details[$i]['amount_type'] = $row2['amount_type'];
                $details[$i]['date'] = $from_date;
                $i++;
            }

            $this->db->select('amount as total_amount');
            $this->db->select('date');
            $this->db->select('amount_type');
            $this->db->select('from_user_id');
            $this->db->select('to_user_id');
            $this->db->from($table_prefix . '_fund_transfer_details');
            $this->db->where("to_user_id", $user_id);
            $this->db->where("date BETWEEN '$start' AND '$end'");
            $this->db->order_by('date');
            $res1 = $this->db->get();
            if ($res1->num_rows() != 0) {
                foreach ($res1->result_array() as $row1) {

                    $details[$i]['total_amount'] = $row1['total_amount'];
                    $details[$i]['amount_type'] = $row1['amount_type'];
                    $from_user_id = $row1['from_user_id'];
                    $from_user_name = $this->getName($from_user_id, $table_prefix . "_");
                    $details[$i]['from_user_name'] = $from_user_name;
                    $details[$i]['date'] = $from_date;
                    $i++;
                }
            }
            $pin_status = $this->getPinStatus($table_prefix . "_");
            $pro_status = $this->getProductStatus($table_prefix . "_");


            if ($pin_status) {
                $this->db->select('pin_prod_refid');
                $this->db->select('pin_uploded_date');
                $this->db->from($table_prefix . '_pin_numbers');
                $this->db->where('allocated_user_id', $user_id);
                $this->db->where('purchase_status', 'yes');
                $this->db->where("pin_alloc_date BETWEEN '$start' AND '$end'");
                $res3 = $this->db->get();
                foreach ($res3->result_array() as $row3) {
                    if ($pro_status) {
                        $product = $this->getProductAmount($row3['pin_prod_refid']);
                        $details[$i]['total_amount'] = $product["product_value"];
                    } else {
                        $pin_amount = $this->getPinAmountForMoblie($table_prefix);
                        $details[$i]['total_amount'] = $pin_amount;
                    }
                    $details[$i]['amount_type'] = "pin_purchased";
                    $details[$i]['date'] = $from_date;
                    $i++;
                }
            }

            $this->db->select('paid_amount');
            $this->db->from($table_prefix . '_amount_paid');
            $this->db->where('paid_user_id', $user_id);
            $this->db->where('paid_type', "released");
            $this->db->where("paid_date BETWEEN '$start' AND '$end'");
            $res4 = $this->db->get();
            foreach ($res4->result_array() as $row4) {
                $details[$i]['total_amount'] = $row4['paid_amount'];
                $details[$i]['amount_type'] = "payout_released";
                $details[$i]['date'] = $from_date;
                $i++;
            }


            $from_date = date('Y-m-d', strtotime('+1 days', strtotime($from_date)));
        }
        return $details;
    }

    public function getPinStatus($table_prefix = "") {
        $this->db->select('pin_status');
        $this->db->from($table_prefix . 'module_status');
        $res = $this->db->get();
        foreach ($res->result() as $row)
            $status = $row->pin_status;
        if ($status == 'yes')
            return true;
        else
            return false;
    }

    public function getProductStatus($table_prefix = "") {
        $this->db->select('product_status');
        $this->db->from($table_prefix . 'module_status');
        $res = $this->db->get();
        foreach ($res->result() as $row)
            $status = $row->product_status;
        if ($status == 'yes')
            return true;
        else
            return false;
    }

    public function getAdminEmailId() {
        $this->db->select('user_id');
        $this->db->from('login_user');
        $this->db->where('user_type', 'admin');
        $res1 = $this->db->get();
        foreach ($res1->result() as $row1) {
            $user_id = $row1->user_id;
        }
        $this->db->select('user_detail_email');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $user_id);
        $res2 = $this->db->get();
        foreach ($res2->result() as $row2) {
            return $row2->user_detail_email;
        }
    }

    public function sendEmail($mailBodyDetails, $email) {
        $this->mailObj->From = 'info@infinitemlmsoftware.com';
        $this->mailObj->FromName = 'Infinitemlmsoftware.com';
        $this->mailObj->Subject = 'Infinitemlmsoftware Notification';
        $this->mailObj->IsHTML(true);

        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);

        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr['send_mail'] = $res;
        if (!$res)
            $arr['error_info'] = $mail->ErrorInfo;
        return $arr;
    }

    public function getTransactionPasscode($user_id) {
        //$tran_passcodes = $this->table_prefix . 'tran_password';
        $this->db->select('tran_password');
        $this->db->from('tran_password');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $passcode = $row->tran_password;
        }
        return $passcode;
    }

    public function getGrandTotalEwallet($user_id = '') {

        $grand_total = 0;
        if ($user_id == "") {
            $this->db->select_sum('balance_amount');
            $this->db->from('user_balance_amount');
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $grand_total = $row->balance_amount;
            }
        } else {
            $this->db->select('balance_amount');
            $this->db->from('user_balance_amount');
            $this->db->where("user_id", $user_id);
            $query = $this->db->get();
            foreach ($query->result() as $row) {
                $grand_total = $row->balance_amount;
            }
        }
        return $grand_total;
    }

    public function generatePasscode($cnt, $status, $uploded_date, $amount, $expiry_date, $purchase_status, $amount_id, $user_id = '', $gen_user_id = '') {
        $res = false;
        for ($i = 0; $i < $cnt; $i++) {
            $passcode = $this->misc_model->getRandStr(9, 9);
            if ($user_id == '') {
                $allocated_user = 'NA';
            } else {
                $allocated_user = $user_id;
            }
            $res = $this->insertPurchases($passcode, $status, $uploded_date, $gen_user_id, $allocated_user, $amount, $expiry_date, $purchase_status, $amount_id);
        }
        return $res;
    }

    public function getMaxPinCount() {

        $OBJ_PIN = new pin_model();
        $maxpincount = $OBJ_PIN->getMaxPinCount();
        return $maxpincount;
    }

    public function getAllActivePinspage($purchase_status = '') {

        $OBJ_PIN = new pin_model();
        $num = $OBJ_PIN->getAllActivePinspage($purchase_status);
        return $num;
    }

    public function checkUser($user_name) {
        $flag = false;
        $user_id = $this->validation_model->userNameToID($user_name);
        if ($user_id) {
            $flag = 1;
        }
        return $flag;
    }

    public function getTotalRequestAmount($user_id = "") {
        $req_amount = 0;
        $this->db->select_sum('requested_amount');
        $this->db->where('status', 'pending');
        if ($user_id != "")
            $this->db->where('requested_user_id', $user_id);
        $query = $this->db->get('payout_release_requests');
        foreach ($query->result() as $row) {
            $req_amount = $row->requested_amount;
        }
        return $req_amount;
    }

    public function getTotalReleasedAmount($user_id = "") {
        $released_amount = 0;
        $this->db->select_sum('paid_amount');
        $this->db->where('paid_type', 'released');
        if ($user_id != "")
            $this->db->where('paid_user_id', $user_id);
        $query = $this->db->get('amount_paid');
        foreach ($query->result() as $row) {
            $released_amount = $row->paid_amount;
        }
        return $released_amount;
    }

    public function insertPurchases($passcode, $status, $pin_uploded_date, $generated_user, $allocate_id, $pin_amount, $expiry_date, $purchase_status, $amount_id) {

        $pin_alloc_date = $pin_uploded_date;
        $used_user = "";

        $array = array(
            'pin_numbers' => $passcode,
            'pin_alloc_date' => $pin_alloc_date,
            'status' => $status,
            'used_user' => $used_user,
            'pin_uploded_date' => $pin_uploded_date,
            'generated_user_id' => $generated_user,
            'allocated_user_id' => $allocate_id,
            'pin_expiry_date' => $expiry_date,
            'pin_amount' => $pin_amount,
            'pin_balance_amount' => $pin_amount,
            'purchase_status' => $purchase_status,
            'pin_prod_refid' => $amount_id
        );

        $this->db->set($array);
        $res = $this->db->insert('pin_purchases');

        $this->db->set($array);
        $res = $this->db->insert('pin_numbers');
        return $res;
    }

    public function insertReleasedDetails($to_userid, $amount, $user_level) {
        $date =  date("Y-m-d H:i:s");
        $paid_type = "admin_debit";
        $data = array(
            'paid_user_id' => $to_userid,
            'paid_amount' => $amount,
            'paid_date' => $date,
            'paid_level' => $user_level,
            'paid_type' => $paid_type
        );
        $query = $this->db->insert('amount_paid', $data);
    }

    public function getUserLevel($to_userid) {
        $this->db->select('user_level');
        $this->db->from('ft_individual');
        $this->db->where('id', $to_userid);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level = $row->user_level;
        }
        return $level;
    }
    
    
     public function getTradingCommissionDetails($user_id, $from_date, $to_date) {

        $i = 0;
        $details = array();

        if ($from_date != '' && $to_date != '') {
            $start = $from_date . ' 00:00:00';
            $end = $to_date . ' 23:59:59';
        }

        $this->db->select('*');
        $this->db->from('leg_amount');
        $this->db->where('trading_account !=', 0);
        $this->db->where('user_id', $user_id);
        if ($from_date != '' && $to_date != '') {
            $this->db->where("date_of_submission BETWEEN '$start' AND '$end'");
        }
        $this->db->order_by('date_of_submission');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $details[$i]['total_amount'] = $row['trading_account'];
            $details[$i]['from_user_name'] = $this->validation_model->IdToUserName($row['from_id']);
            $details[$i]['amount_type'] = $this->validation_model->getViewAmountType($row['amount_type']);
            $details[$i]['package'] = $this->validation_model->getPrdocutName(0);
            $details[$i]['date'] = date('Y-m-d', strtotime($row['date_of_submission']));
            $details[$i]['full_date'] = strtotime($row['date_of_submission']);
            $i++;
        }
        return $details;
    }
    

}
