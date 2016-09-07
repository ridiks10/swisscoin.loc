<?php

class myparty_model extends inf_model {

    private $mailObj;

    public function __construct() {
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
        require_once 'calculation_model.php';
        $this->obj_calc = new calculation_model();

        $this->load->model('register_model');
    }

    public function getAvailableParties($id) {
        $i = 0;
        $party_detail = array();
        $this->db->select('*');
        $this->db->from('party');
        $this->db->where('added_by', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $party_detail["$i"]["id"] = $row['id'];
            $party_detail["$i"]["host_id"] = $row['host_id'];
            $party_detail["$i"]["host_name"] = $this->getHostName($party_detail["$i"]["host_id"]);
            $party_detail["$i"]["from_date"] = $row['from_date'];
            $party_detail["$i"]["status"] = $row['status'];
            $party_detail["$i"]["party_name"] = $row['party_name'];
            $party_detail["$i"]["from_date"] = $row['from_date'];
            $party_detail["$i"]["from_time"] = $row['from_time'];
            $party_detail["$i"]["to_date"] = $row['to_date'];
            $party_detail["$i"]["to_time"] = $row['to_time'];
            $i++;
        }
        return $party_detail;
    }

    public function getHostName($id) {
        $this->db->select('first_name,last_name');
        $this->db->from('party_host');
        $this->db->where('id', $id);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            foreach ($res->result() as $row) {
                $first_name = $row->first_name;
                $last_name = $row->last_name;
            }
            return $first_name . " " . $last_name;
        }
    }

    public function getInvitedGuestDetails($id, $party_id) {
        $i = 0;
        $guest_detail = array();
        $this->db->select('*');
        $this->db->from('party_guest_invited');
        $this->db->where('status', 'yes');
        $this->db->where('added_by', $id);
        $this->db->where('party_id', $party_id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $guest_detail["$i"]["invited_id"] = $row['invited_id'];
            $guest_detail["$i"]["guest_id"] = $row['guest_id'];
            $details = $this->getGuestDetails($guest_detail["$i"]["guest_id"]);
            $guest_detail["$i"]["name"] = $details['first_name'] . " " . $details['last_name'];
            $guest_detail["$i"]["email"] = $details['email'];
            $guest_detail["$i"]["phone"] = $details['phone'];
            $i++;
        }
        return $guest_detail;
    }

    public function getGuestDetails($id) {
        $guest_detail = array();
        $this->db->select('*');
        $this->db->from('party_guest');
        $this->db->where('guest_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $guest_detail['first_name'] = $row->first_name;
            $guest_detail['last_name'] = $row->last_name;
            $guest_detail['email'] = $row->email;
            $guest_detail['phone'] = $row->phone;
        }
        return $guest_detail;
    }

    public function selectedPartyDetails($id) {
        $party = array();
        if ($id) {
            $this->db->select('host_id,from_date,status,party_name,from_time,to_date,to_time');
            $this->db->from('party');
            $this->db->where('id', $id);
            $res = $this->db->get();

            foreach ($res->result() as $row) {
                $party['host_id'] = $row->host_id;
                $party['status'] = $row->status;
                $party['party_name'] = $row->party_name;
                $party['from_date'] = $row->from_date;
                $party['from_time'] = $row->from_time;
                $party['to_date'] = $row->to_date;
                $party['to_time'] = $row->to_time;
                $party['host_name'] = $this->getHostName($party['host_id']);
                $party['id'] = $id;
            }
        }
        return $party;
    }

    public function getProcessedOrders($id) {
        $details = array();
        $this->db->select('guest_id,product_id');
        $this->db->select_sum('product_count');
        $this->db->select_sum('total_amount');
        $this->db->from('party_guest_orders');
        $this->db->group_by('guest_id');
        $this->db->where('party_id', $id);
        $this->db->where('processed', 'yes');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details["$i"]['guest_id'] = $row['guest_id'];
            $details["$i"]['guest_name'] = $this->getGuestName($details["$i"]['guest_id']);
            $details["$i"]['product_id'] = $row['product_id'];
            $details["$i"]['count'] = $row['product_count'];
            $details["$i"]['total_amount'] = $row['total_amount'];
            $i = $i + 1;
        }

        return $details;
    }

    public function getGuestName($id) {

        $this->db->select('first_name,last_name');
        $this->db->from('party_guest');
        $this->db->where('guest_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $name = $row->first_name . " " . $row->last_name;
        }
        return $name;
    }

    public function getUnprocessedOrders($id) {
        $details = array();
        $this->db->select('guest_id,party_id,product_id');
        $this->db->select_sum('product_count');
        $this->db->select_sum('total_amount');
        $this->db->from('party_guest_orders');
        $this->db->where('party_id', $id);
        $this->db->where('processed', 'no');
        $this->db->group_by('guest_id');
        $res = $this->db->get();
        $i = 0;
        foreach ($res->result_array() as $row) {
            $details["$i"]['guest_id'] = $row['guest_id'];
            $details["$i"]['party_id'] = $row['party_id'];
            $details["$i"]['guest_name'] = $this->getGuestName($details["$i"]['guest_id']);
            $details["$i"]['product_id'] = $row['product_id'];
            $details["$i"]['count'] = $row['product_count'];
            $details["$i"]['total_amount'] = $row['total_amount'];
            $i = $i + 1;
        }

        return $details;
    }

    public function processOrder($party_id, $guest_id) {
        $this->db->where('guest_id', $guest_id);
        $this->db->where('party_id', $party_id);
        $this->db->set('processed', 'yes');
        $res = $this->db->update('party_guest_orders');
        return $res;
    }

    public function checkAllOrdersProcesed($id) {

        $status = "no";
        $this->db->select('*');
        $this->db->from('party_guest_orders');
        $this->db->where('party_id', $id);
        $this->db->where('processed', 'no');
        $res = $this->db->get();

        $cnt = $res->num_rows();
        if ($cnt > 0) {
            $status = "yes";
        }
        return $status;
    }

    public function closeParty($id, $closed_by = '') {
        $this->db->set('status', 'closed');
        $this->db->set('closed_by', $closed_by);
        $this->db->where('id', $id);
        $res = $this->db->update('party');
        return $res;
    }

    public function evaluatePartyCommission($user_id, $tot_process_amount, $party_id) {

        $admin_id = $this->validation_model->getAdminId();
        $father_id = $this->validation_model->getFatherId($user_id);

        if ($user_id != $admin_id) {
            $this->obj_calc->calculateLegCount($father_id, '', $tot_process_amount, $user_id, 'sponsor_level_bonus');
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function getCommissionDetails($rank_id) {

        $this->db->select('*');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->get('rank_details');

        foreach ($query->result() as $row) {

            return $row;
        }
    }

    public function getPartyCommission($rank_id) {
        $party_comm = 0;
        $this->db->select('party_comm');
        $this->db->where('rank_id', $rank_id);
        $query = $this->db->get('rank_details');

        foreach ($query->result() as $row) {

            $party_comm = $row->party_comm;
        }
        return $party_comm;
    }

    public function evaluateUserRank($user_name) {

        $this->register_model->evaluateUserRank($user_name);
    }

    public function checkRankStatus($user_id) {

        $this->load->model('register_model');

        $prod_join_details = $this->register_model->getProdAndJoiningDetails($user_id);

        $date_after_six_month = date('Y-m-d', strtotime('+6 month', strtotime($prod_join_details['date_of_joining'])));
        $curr_date = date('Y-m-d');
        $amount = 0;
        $order_amount = 0;

        $rank_id = $this->validation_model->getRankId($user_id);

        if ($prod_join_details['product_id'] > 1 && $date_after_six_month < $curr_date && $rank_id < 5) {

            $total_income = $this->register_model->getTotalIncome($rank_id);
            $user_name = $this->validation_model->idToUserName($user_id);

            $from_date = $prod_join_details['date_of_joining'];
            $to_date = $date_after_six_month;

            $amount = $this->register_model->getTotalPurchase($user_name, $from_date, $to_date);

            $this->register_model->getDownlineDetailsAll($user_id);

            foreach ($this->register_model->referals as $id) {

                $ref_user_name = $this->validation_model->IdToUserName($id);
                $amount+=$this->register_model->getTotalPurchase($ref_user_name, $from_date, $to_date);
            }
            $all_party_id = $this->register_model->getClosedPartyId($user_id, $from_date, $to_date);

            foreach ($all_party_id as $party_id) {

                $order_amount+=$this->register_model->totalProductAmountGetFromParty($party_id, $from_date, $to_date);
            }
            $amount+=$order_amount;

            if ($amount >= $total_income['tot_income']) {

                return $rank_id;
            } else {
                $rank_id = $this->register_model->findBelowRank($rank_id);

                return $rank_id;
            }
        } else {
            return $rank_id;
        }
    }

    public function closeTimeOutParties($current_date) {
        $this->db->select('id,to_date,to_time');
        $this->db->from('party');
        $this->db->where('status', 'open');
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $party_end_time = strtotime($row->to_date . " " . $row->to_time);
            if ($current_date > $party_end_time) {

                $this->closeParty($row->id, 'out_date');
            }
        }
        return TRUE;
    }

}

?>
