<?php

class pin_model extends inf_model {

    function __construct() {
        parent::__construct();
        $this->load->model('validation_model');
    }

    var $active_pin = Array();
    var $all_pin = Array();
    var $used_pin = Array();
    var $active_search = Array();

    public function getNoOfRows($user_id) {

        $product = $this->table_prefix . "package";
        $top = "select pr.*,pi.* from $product as pr inner join pin_numbers as pi on pr.product_id = pi.pin_prod_refid where pin_alloc_user_ref_id = '$user_id' AND status ='active' ";
        $numresults = $this->selectData($top); // the query.
        $numrows = mysql_num_rows($numresults); // Number of rows returned from above query.
        return $numrows;
    }

    public function getActivePins($page, $limit) {
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->order_by("pin_id", "DESC");
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get();

        $i = 0;

        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->active_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->active_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->active_pin["detail$i"]["used_user"] = $search_active['used_user'];
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->active_pin["detail$i"]["status"] = $search_active['status'];
                $this->active_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->active_pin["detail$i"]["pin_bal_amount"] = $search_active["pin_balance_amount"];
                $this->active_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($search_active['allocated_user_id'] != "NA") {
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->active_pin["detail$i"]["allocated_user"] = "NULL";

                $i++;
            }
        }

        return $this->active_pin;
    }

    public function deleteActivePins($page, $limit) {
        $date = date("Y-m-d");
        $this->db->select("pin_id,pin_numbers");
        $this->db->from("pin_numbers");
        $this->db->where("status", "yes");
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        $this->db->order_by("pin_id", "DESC");
        $this->db->limit($limit, $page);
        $search_my_active = $this->db->get();
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->db->set('status', 'delete');
                $this->db->where('pin_id', $search_active['pin_id']);
                $this->db->update('pin_numbers');

                $this->db->set('status', 'delete');
                $this->db->where('pin_numbers', $search_active['pin_numbers']);
                $this->db->update('pin_purchases');
            }
        }
        return TRUE;
    }

    public function deleteInactivePins($page, $limit) {
        $date = date("Y-m-d");
        $search_my_active = $this->db->query("SELECT pin_id,pin_numbers FROM (`" . $this->db->dbprefix . "pin_numbers`) WHERE`status` != 'delete' AND  (`status` = 'no' OR `pin_expiry_date` < '$date' OR `pin_balance_amount` = 0) ORDER BY `pin_alloc_date` DESC LIMIT $page,$limit ");
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->db->set('status', 'delete');
                $this->db->where('pin_id', $search_active['pin_id']);
                $this->db->update('pin_numbers');

                $this->db->set('status', 'delete');
                $this->db->where('pin_numbers', $search_active['pin_numbers']);
                $this->db->update('pin_purchases');
            }
        }
        return TRUE;
    }

    public function insertPinRequest($req_user, $cnt, $request_date, $expiry_date, $pin_amount) {

        $array = array('req_user_id' => $req_user, 'req_pin_count' => $cnt, 'req_rec_pin_count' => $cnt, 'req_date' => $request_date, 'status' => 'yes', 'pin_amount' => $pin_amount, 'pin_expiry_date' => $expiry_date);
        $this->db->set($array);
        $res = $this->db->insert('pin_request');
        return $res;
    }

    public function getInactivePins($page, $limit) {
        $date = date("Y-m-d");
        $this->inactive_pin = array();

        $search_my_active = $this->db->query("SELECT * FROM (`" . $this->db->dbprefix . "pin_numbers`) WHERE`status` != 'delete' AND  (`status` = 'no' OR `pin_expiry_date` < '$date' OR `pin_balance_amount` = 0) ORDER BY `pin_id` DESC LIMIT $page,$limit ");

        $i = 0;
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->inactive_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->inactive_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->inactive_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->inactive_pin["detail$i"]["used_user"] = $search_active['used_user'];
                $this->inactive_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->inactive_pin["detail$i"]["status"] = $search_active['status'];
                $this->inactive_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->inactive_pin["detail$i"]["pin_bal_amount"] = $search_active["pin_balance_amount"];
                $this->inactive_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($search_active['allocated_user_id'] != "NA") {
                    $this->inactive_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->inactive_pin["detail$i"]["allocated_user"] = "NULL";


                $i++;
            }
        }

        return $this->inactive_pin;
    }

    public function getAllPins($page, $limit) {
        $session_data = $this->session->userdata('inf_logged_in');
        $user_id = $session_data['user_id'];
        $user_type = $session_data['user_type'];

        if ($user_type == "admin" || $user_type == "employee") {
            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("status", "yes");
            $this->db->where("pin_balance_amount >", 0);
            $this->db->order_by("status", "DESC");
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        } else {
            $user_id = $this->session->userdata('inf_user_id');
            $this->db->select("pr.*,pi.*");
            $this->db->from("package as pr");
            $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
            $this->db->where("allocated_user_id", $user_id);
            $this->db->where("status", "yes");
            $this->db->where("pin_balance_amount >", 0);
            $this->db->order_by("status", "DESC");
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        }

        $i = 0;

        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {
                $this->all_pin["detail$i"]["pin_id"] = $search_active['pin_id'];
                $this->all_pin["detail$i"]["pin_amount"] = $search_active['pin_amount'];
                $this->all_pin["detail$i"]["pin_bal_amount"] = $search_active['pin_balance_amount'];
                $this->all_pin["detail$i"]["pin"] = $search_active['pin_numbers'];
                $this->all_pin["detail$i"]["pin_alloc_date"] = $search_active['pin_alloc_date'];
                $this->all_pin["detail$i"]["used_user"] = $search_active['used_user'];
                if ($search_active['allocated_user_id'] != "NA") {

                    $this->all_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                } else
                    $this->all_pin["detail$i"]["allocated_user"] = "NULL";
                $this->all_pin["detail$i"]["pin_uploded_date"] = $search_active['pin_uploded_date'];
                $this->all_pin["detail$i"]["pin_expiry_date"] = $search_active['pin_expiry_date'];
                $this->all_pin["detail$i"]["status"] = $search_active['status'];

                $date1 = $search_active['pin_uploded_date'];
                $middle = strtotime($date1);
                $pin_expired1 = strtotime(date('Y-m-d', $middle)) . "       ";
                $date2 = $search_active['pin_expiry_date'];
                $pin_expired2 = strtotime($date2);
                $pin_expired = $pin_expired2 - $pin_expired1;
                if ($pin_expired <= 0)
                    $this->all_pin["detail$i"]["pin_expired"] = 'yes';
                else {
                    $this->all_pin["detail$i"]["pin_expired"] = 'no';
                }
                $i++;
            }
        }

        return $this->all_pin;
    }

    public function getAllPinspage() {

        $session_data = $this->session->userdata('inf_logged_in');
        $user_type = $session_data['user_type'];

        if ($user_type == "admin" || $user_type == "employee") {
            $this->db->from("pin_numbers");
            $this->db->where("status", "yes");
            $this->db->where("pin_balance_amount >", 0);
            $cnt = $this->db->count_all_results();
        } else {
            $user_id = $this->session->userdata('inf_user_id');
            $this->db->from("package as pr");
            $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
            $this->db->where("allocated_user_id", $user_id);
            $cnt = $this->db->count_all_results();
        }
        return $cnt;
    }

    public function getAllActivePinspage($purchase_status = '') {
        $date = date("Y-m-d");
        $this->db->select("*");
        $this->db->from("pin_numbers");
        $this->db->where('status', 'yes');
        $this->db->where('pin_expiry_date >=', $date);
        $this->db->where('pin_balance_amount >', 0);
        if ($purchase_status != '') {
            $this->db->where('purchase_status', 'yes');
        }
        $numrows = $this->db->count_all_results();
        return $numrows;
    }

    public function getAllInactivePinspage() {
        $date = date("Y-m-d");
        $search_all = $this->db->query("SELECT * FROM (`" . $this->db->dbprefix . "pin_numbers`) WHERE`status` != 'delete' AND  (`status` = 'no' OR `pin_expiry_date` < '$date' OR `pin_balance_amount` = 0)");
        $cnt = $search_all->num_rows();
        return $cnt;
    }

    public function getUserName($pin) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";
        $pin_user = "select user_pin_name FROM $pin_numbers WHERE pin_numbers='$pin' and status='yes'";

        //echo $serchpin;
        $res = $this->selectData($pin_user, "Error on Selecting user from pin");
        $row = mysql_fetch_array($res);
        $user_name = $row['user_pin_name'];
        return $user_name;
    }

    public function getUsedPins() {
        
    }

    public function insertPasscode($passcode, $status, $pin_uploded_date, $generated_user, $allocate_id, $pin_amount, $expiry_date, $purchase_status = "") {

        $pin_alloc_date = "";
        $used_user = "";
        if ($purchase_status == "") {
            $array = array('pin_numbers' => $passcode, 'pin_alloc_date' => $pin_alloc_date, 'status' => $status, 'used_user' => $used_user, 'pin_uploded_date' => $pin_uploded_date, 'generated_user_id' => $generated_user, 'allocated_user_id' => $allocate_id, 'pin_expiry_date' => $expiry_date, 'pin_amount' => $pin_amount, 'pin_balance_amount' => $pin_amount);
            $this->db->set($array);
            $res = $this->db->insert('pin_numbers');
        } else {

            $array = array('pin_numbers' => $passcode, 'pin_alloc_date' => $pin_alloc_date, 'status' => $status, 'used_user' => $used_user, 'pin_uploded_date' => $pin_uploded_date, 'generated_user_id' => $generated_user, 'allocated_user_id' => $allocate_id, 'purchase_status' => 'yes', 'pin_expiry_date' => $expiry_date, 'pin_amount' => $pin_amount, 'pin_balance_amount' => $pin_amount);

            $this->db->set($array);
            $res = $this->db->insert('pin_numbers');
        }
        return $res;
    }

    public function getAllPinsearchProd($keyword, $page, $limit) {

        $this->db->select("pr.*,pi.*");
        $this->db->from("package as pr");
        $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
        $this->db->where("pin_prod_refid = '$keyword%' and status!='delete'");
        $this->db->order_by("status", "asc");
        $this->db->limit($limit, $page);
        $search_my_res_active = $this->db->get();
        $cnt = $search_my_res_active->num_rows();

        $i = 0;

        if ($cnt > 0) {
            foreach ($search_my_res_active->result_array() as $row_search) {
                $this->active_search["detail$i"]["pin_id"] = $row_search['pin_id'];
                $this->active_search["detail$i"]["product"] = $row_search['product_name'];
                $this->active_search["detail$i"]["pin"] = $row_search['pin_numbers'];
                $this->active_search["detail$i"]["pin_alloc_date"] = $row_search['pin_alloc_date'];
                $this->active_search["detail$i"]["used_user"] = $row_search['used_user'];

                $this->active_search["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($row_search['allocated_user_id']);
                $this->active_search["detail$i"]["pin_uploded_date"] = $row_search['pin_uploded_date'];
                $this->active_search["detail$i"]["prod_id"] = $row_search['prod_id'];
                $this->active_search["detail$i"]["status"] = $row_search['status'];
                $i++;
            }
        }
        return $this->active_search;
    }

    public function getAllPinsearchProdpage($keyword) {

        $this->db->select("pr.*,pi.*");
        $this->db->from("package as pr");
        $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
        $this->db->where("pin_prod_refid LIKE '$keyword%' AND status!='delete'");
        $this->db->order_by("status", "asc");
        $search_my_res_active = $this->db->get();
        $cnt = $search_my_res_active->num_rows();
        return $cnt;
    }

    public function getAllPinsearch($keyword, $page, $limit) {

        $this->db->select("pr.*,pi.*");
        $this->db->from("package as pr");
        $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
        $where = "pin_numbers LIKE '$keyword%' AND status!='delete' OR pin_id = '$keyword'  OR  user_pin_name LIKE '$keyword%' ";
        $this->db->where($where);
        $this->db->order_by("status", "asc");
        $this->db->limit($limit, $page);

        $search_my_active = $this->db->get();
        $cnt = $search_my_active->num_rows();

        $i = 0;

        if ($cnt > 0) {
            foreach ($search_my_active->result_array() as $search_active) {

                $this->active_pin["detail$i"]["pin_id"] = $search_active["pin_id"];
                $this->active_pin["detail$i"]["product"] = $search_active["product_name"];
                $this->active_pin["detail$i"]["pin"] = $search_active["pin_numbers"];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active["pin_alloc_date"];
                $this->active_pin["detail$i"]["used_user"] = $search_active["used_user"];
                $id = $search_active['allocated_user_id'];

                if ($id != "NA" && $id != "") {
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($id);
                } else {
                    $this->active_pin["detail$i"]["allocated_user"] = "NA";
                }
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active["pin_uploded_date"];
                $this->active_pin["detail$i"]["prod_id"] = $search_active["prod_id"];
                $this->active_pin["detail$i"]["status"] = $search_active["status"];
                $i++;
            }
        }
        return $this->active_pin;
    }

    public function getAllPinsearchpage($keyword) {

        $this->db->select("pr.*,pi.*");
        $this->db->from("package as pr");
        $this->db->join("pin_numbers as pi", "pr.product_id = pi.pin_prod_refid", "INNER");
        $where = ("pin_numbers LIKE '$keyword%' AND status!='delete'  OR pin_id='$keyword' OR user_pin_name LIKE '$keyword%'");
        $this->db->where($where);
        $this->db->order_by("status", "asc");

        $search_my = $this->db->get();
        $cnt = $search_my->num_rows();
        return $cnt;
    }

    public function deletePasscode($pin_id) {
        $this->db->set('status', 'delete');
        $this->db->where('pin_id', $pin_id);

        $res = $this->db->update('pin_numbers');

        return $res;
    }

    public function updatePasscode($pin_id, $status) {
        $this->db->set("status", $status);
        $this->db->where("pin_id", $pin_id);

        $res = $this->db->update("pin_numbers");

        return $res;
    }

    public function getPinDetails($pin_no) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $purchase_pin = $this->table_prefix . "pin";

        $search_my = "select * from $purchase_pin WHERE pin_numbers='$pin_no'";
        //echo $serchpin;
        $search_my_res_active = $this->selectData($search_my, "Error on selecting pin detail124546787");
        $cnt = mysql_num_rows($search_my_res_active);
        if ($cnt > 0) {
            $i = 0;
            $row_search = mysql_fetch_array($search_my_res_active);
            $pin_detail_arr["pin_id"] = $row_search['pin_id'];
            $pin_detail_arr["pin_status"] = $row_search['status'];
        }
        return $pin_detail_arr;
    }

    public function getAllPinRequest($limit = '', $page = '') {
        $pin_detail_arr = array();
        $this->db->select("*");
        $this->db->from("pin_request");
        $this->db->where("status", "yes");
        $this->db->limit($limit, $page);
        $qr_pin_req = $this->db->get();

        $cnt = $qr_pin_req->num_rows();
        if ($cnt > 0) {
            $i = 0;
            foreach ($qr_pin_req->result_array() as $row_search) {
                $pin_detail_arr["detail$i"]["req_id"] = $row_search['req_id'];
                $pin_detail_arr["detail$i"]["user_id"] = $row_search['req_user_id'];
                $pin_detail_arr["detail$i"]["product_id"] = $row_search['product_id'];
                $pin_detail_arr["detail$i"]["pin_count"] = $row_search['req_pin_count'];
                $pin_detail_arr["detail$i"]["rem_count"] = $row_search['req_rec_pin_count'];
                $pin_detail_arr["detail$i"]["req_date"] = $row_search['req_date'];
                $pin_detail_arr["detail$i"]["expiry_date"] = $row_search['pin_expiry_date'];
                $pin_detail_arr["detail$i"]["amount"] = $row_search['pin_amount'];
                $i++;
            }
        }
        return $pin_detail_arr;
    }

    public function updatePinRequest($id, $rem_count, $pin_count) {
        $date = date('Y-m-d');

        if ($pin_count == $rem_count) {
            $this->db->where('req_id', $id);
            $this->db->set('status', 'no');
            $res = $this->db->update('pin_request');
        } else {
            $pin_count = $rem_count - $pin_count;

            $data = array('req_pin_count' => $pin_count, 'req_rec_pin_count' => $pin_count);
            $this->db->where('req_id', $id);
            $res = $this->db->update('pin_request', $data);
        }

        return $res;
    }

    public function getPinAmount() {

        $this->db->select("pin_amount");
        $this->db->from("pin_config");
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $pin_amount = $row->pin_amount;
        }
        return $pin_amount;
    }

    public function getMaxPinCount() {
        $this->db->select('pin_maxcount');
        $query = $this->db->get('pin_config');
        foreach ($query->result_array() as $row) {
            $maxpincount = $row['pin_maxcount'];
        }
        return $maxpincount;
    }

    public function getFreePins($page, $limit) {
        $date = date('Y-m-d');
        $user_type = $this->LOG_USER_TYPE;
        $user_id = $this->LOG_USER_ID;
        if ($user_type == "admin") {
            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("allocated_user_id", "NA");
            $this->db->where("status", "yes");
            $this->db->order_by("status", "DESC");
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        } else {
            $this->db->select("*");
            $this->db->from("pin_numbers");
            $this->db->where("allocated_user_id", $user_id);
            $this->db->where("status", "yes");
            $this->db->order_by("status", "DESC");
            $this->db->limit($limit, $page);
            $search_my_active = $this->db->get();
        }

        $i = 0;
        $cnt = $search_my_active->num_rows();
        if ($cnt > 0) {
            $date = date('Y-m-d');
            foreach ($search_my_active->result_array() as $search_active) {
                $this->active_pin["detail$i"]["pin_id"] = $search_active["pin_id"];
                $this->active_pin["detail$i"]["pin_amount"] = $search_active["pin_amount"];
                $this->active_pin["detail$i"]["pin"] = $search_active["pin_numbers"];
                $this->active_pin["detail$i"]["pin_balance_amount"] = $search_active["pin_balance_amount"];
                $this->active_pin["detail$i"]["pin_alloc_date"] = $search_active["pin_alloc_date"];
                if ($search_active["used_user"] == "")
                    $this->active_pin["detail$i"]["used_user"] = "NULL";
                else
                    $this->active_pin["detail$i"]["used_user"] = $this->validation_model->IdToUserName($search_active["used_user"]);
                if ($search_active["allocated_user_id"] == "" || $search_active["allocated_user_id"] == "NA")
                    $this->active_pin["detail$i"]["allocated_user"] = "NULL";
                else
                    $this->active_pin["detail$i"]["allocated_user"] = $this->validation_model->IdToUserName($search_active['allocated_user_id']);
                $this->active_pin["detail$i"]["pin_uploded_date"] = $search_active["pin_uploded_date"];
                $this->active_pin["detail$i"]["pin_expiry_date"] = $search_active["pin_expiry_date"];
                if ($date > $search_active["pin_expiry_date"] && $search_active["status"] == 'yes')
                    $this->active_pin["detail$i"]["status"] = 'expired';
                else
                    $this->active_pin["detail$i"]["status"] = $search_active["status"];
                $i++;
            }
        }

        return $this->active_pin;
    }

    public function getAllFreePinspage() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";

        $search_all = "select * from $pin_numbers WHERE status='yes' and used_user=''";

        $search_my_res_all = $this->selectData($search_all, "Error on selecting pin page 1234544");
        $cnt = mysql_num_rows($search_my_res_all);
        return $cnt;
    }

}
