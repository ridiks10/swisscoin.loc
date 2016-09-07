<?php



class sms_model extends inf_model {

    public $sms_acct_username;
    public $sms_acct_password;
    public $sms_sender_id;
    public $sms_api_path;
    public $phone_no_arr;
    public $sms_msg;
    public $client_obj;
    public $sms_param;

    function __construct() {
        parent::__construct();

        require_once 'sms_config.php';
        require_once  'sms/lib/nusoap.php';
        $this->load->model('misc_model');
        $this->phone_no_arr = null;
        $this->sms_msg = null;
        $this->client_obj = null;
        $this->sms_param = Array();
        $this->sms_acct_username = $sms_username;
        $this->sms_acct_password = $sms_password;
        $this->sms_sender_id = $sms_senderid;
        $this->sms_api_path = $sms_api_path;
        //$this->client_obj = new soapclient1($this->sms_api_path, true);
        $this->client_obj = new nusoap_client($this->sms_api_path, true);
    }

    public function echoAllUserSms($value, $text) {
        $echo = "";

        $this->db->select('*');
        $this->db->from('login_user');
        $this->db->where('addedby !=', 'server');
        $this->db->order_by('user_id', 'asc');
        $query = $this->db->get();

        $echo.= "<option value='$value' selected='selected'>$text</option>";

        foreach ($query->result() as $row) {

            $echo.= "<option value='$row->user_id' >$row->user_name</option>";
        }
        return $echo;
    }

    public function echoSingleNumber($id) {
        $echo = "";
        $this->db->select('user_detail_mobile');
        $this->db->from('user_details');
        $this->db->where('user_detail_refid', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {

            if ($row->user_detail_mobile == "") {
                $echo.= "No no available...";
                //exit();
            } else {
                $echo.= $row->user_detail_mobile;
                //exit();
            }
            return $echo;
        }
    }

    public function echoAllNumber($from, $to) {
        $echo = "";

        $this->db->select('user_detail_mobile');
        $this->db->from('user_details');
        $where = "user_detail_refid BETWEEN {$this->db->escape($from)} and {$this->db->escape($to)}";
        $this->db->where($where);
        $query = $this->db->get();
        $cnt = $query->num_rows();
        $numbers = "";
        foreach ($query->result_array() as $row) {
            $len = strlen($row['user_detail_mobile']);
            if ($row['user_detail_mobile'] != '' && $len == 10)
                $numbers.=$row['user_detail_mobile'] . ",";
        }
        $numbers = substr($numbers, 0, (strlen($numbers) - 1));
        return $echo.= $numbers;
    }

    public function getAllNumbers() {
        $numbers = "";
        $this->db->select('user_detail_mobile');
        $this->db->from('user_details');
        $this->db->order_by('user_detail_id');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $len = strlen($row["user_detail_mobile"]);
            if ($row["user_detail_mobile"] != '' && $len == 10)
                $numbers.=$row["user_detail_mobile"] . ",";
        }
        return $numbers;
    }

    public function checkSMSStatus() {
        $flag = false;

        $obj_arr = $this->getSettings();
        $status = $obj_arr["sms_status"];
        if ($status == "enabled") {
            $flag = true;
        } else {
            $this->alert('You are unable to Send SMS ,Please Contact Administrator');
        }
        return $flag;
    }

    public function getSettings() {
        $query = $this->db->get('configuration');

        foreach ($query->result() as $row) {
            $obj_arr["id"] = $row->id;
            $obj_arr["tds"] = $row->tds;
            $obj_arr["pair_price"] = $row->pair_price;
            $obj_arr["pair_ceiling"] = $row->pair_ceiling;
            $obj_arr["service_charge"] = $row->service_charge;
            $obj_arr["product_point_value"] = $row->product_point_value;
            $obj_arr["pair_value"] = $row->pair_value;
            $obj_arr["startDate"] = $row->start_date;
            $obj_arr["endDate"] = $row->end_date;
            $obj_arr["sms_status"] = $row->sms_status;
            $obj_arr["payout_release"] = $row->payout_release;
            $obj_arr["referal_amount"] = $row->referal_amount;
        }
        return $obj_arr;
    }

    public function setSMSAPI() {
        $message = str_replace("\n", "\r\n", $this->sms_msg);
        $this->sms_param = array('username' => $this->sms_acct_username, 'senderid' => $this->sms_sender_id, 'password' => $this->sms_acct_password, 'message' => $message, 'number' => $this->phone_no_arr);
    }

    public function sendSMS() {
        $sms = $this->client_obj->call('SendSMS', $this->sms_param, '', '', false, true);
        return $sms;
    }

    public function insertsmsDeatails($numbers, $message, $sms_count, $sms) {
        $now = date('Y-m-d H:i:s');

        $this->db->set('numbers', $numbers);
        $this->db->set('message', $message);
        $this->db->set('message_count', $sms_count);
        $this->db->set('status', $sms);
        $this->db->set('datetime', $now);
        $this->db->insert('sms_history');
        return $res;
    }

    public function getBalance() {
        $result = $this->client_obj->call('getBalance', $this->sms_param, '', '', false, true);
        return $result = 0;
    }

}
