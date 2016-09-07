<?php


Class settings_model extends CI_Model {

    public function __construct() {

        parent::__construct();
    }

    public function isSetConfiguration() {

        $flag = false;
        $obj_arr = array();
        $configuration = 'configuration';
        $this->db->select('setting_staus');
        $this->db->from($configuration);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $obj_arr['setting_staus'] = $row->setting_status;
        }

        if ($obj_arr['setting_staus'] == 'no') {
            $flag = false;
        } else {
            $flag = true;
        }
        return $flag;
    }

    public function getSettings($tprefix) {
        $obj_arr=array();
        $this->db->select('*');
        $this->db->from($tprefix.'_configuration');
        $res = $this->db->get();

        foreach ($res->result_array() as $row) {
            $obj_arr['id'] = $row['id'];
            $obj_arr['tds'] = $row['tds'];
            $obj_arr['pair_price'] = $row['pair_price'];
            $obj_arr['pair_ceiling'] = $row['pair_ceiling'];
            $obj_arr['service_charge'] = $row['service_charge'];
            $obj_arr['product_point_value'] = $row['product_point_value'];
            $obj_arr['pair_value'] = $row['pair_value'];
            $obj_arr['startDate'] = $row['start_date'];
            $obj_arr['endDate'] = $row['end_date'];
            $obj_arr['sms_status'] = $row['sms_status'];
            $obj_arr['payout_release'] = $row['payout_release'];
            $obj_arr['referal_amount'] = $row['referal_amount'];
            $obj_arr['pair_commission_type'] = $row['pair_commission_type'];
        }
        return $obj_arr;
    }

    public function updatSettings($tds, $pair, $ceiling, $service, $pair_value, $product_point_value = '', $referal_amount = '') {

        $configuration = 'configuration';
        $data = array(
            'tds' => $tds,
            'pair_price' => $pair,
            'pair_ceiling' => $ceiling,
            'service_charge' => $service,
            'pair_value' => $pair_value,
            'product_point_value' => $product_point_value,
            'setting_staus' => 'yes',
            'referal_amount' => $referal_amount
        );
        $res = $this->db->update($configuration, $data);
        return $res;
    }

    public function updateConfigurationYes() {

        $configuration = 'configuration';
        $data = array('setting_staus' => 'yes');
        $res = $this->db->update($configuration, $data);
        return $res;
    }

    public function getTermsConditionsSettings() {

        $terms_con = '';
        $terms = 'terms_conditions';
        $this->db->select('terms_conditions');
        $this->db->from($terms);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $terms_con = $row->terms_conditions;
        }
        return $terms_con;
    }

    public function updateTermsConditionsSettings($newone) {
        $terms = 'terms_conditions';
        $data = array('terms_conditions' => $newone);
        $res = $this->db->update($terms, $data);
        return $res;
    }

}