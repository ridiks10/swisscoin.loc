<?php

/*
 * You can modify this class
 */

/**
 * Description of Settings Class
  Contain the fuctions for seeting the configurations of Infinite MLM Software
 *
 * @author Abdul Majeed.P
  CSA Of IOSS
  www.ioss.in
 */
Class settings_model extends inf_model {

    public function __construct() {

        /*  if ($this->table_prefix == "") {
          $this->session->userdata('inf_table_prefix');
          } */
    }

    public function isSetConfiguration() {
        //code edited by jiji

        $flag = false;
        $obj_arr = array();
        $configuration = "configuration";
        //$qr = "SELECT setting_staus FROM $configuration";
        $this->db->select('setting_staus');
        $this->db->from($configuration);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $obj_arr["setting_staus"] = $row->setting_status;
        }


        if ($obj_arr["setting_staus"] == "no") {
            $flag = false;
        } else {
            $flag = true;
        }
        return $flag;
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
            $obj_arr["percentorvalue"] = $row['percentorvalue'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
        }

        return $obj_arr;
    }

    public function updatSettings($tds, $pair, $ceiling, $service, $pair_value, $product_point_value = "", $referal_amount = "") {
        //code edited by jiji

        $configuration = "configuration";
        // $qr = "UPDATE $configuration SET  tds=' $tds' ,pair_price ='$pair', pair_ceiling ='$ceiling' ,
        // service_charge ='$service',pair_value='$pair_value', product_point_value='$product_point_value',
        // setting_staus='yes', referal_amount='$referal_amount' ";

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
        //code edited by jiji

        $configuration = "configuration";
        // $qr = "UPDATE $configuration SET  setting_staus='yes'";

        $data = array('setting_staus' => 'yes');
        $res = $this->db->update($configuration, $data);

        return $res;
    }

    public function getTermsConditionsSettings() {
        //code  edited by jiji

        $terms_con = "";
        $terms = "terms_conditions";
        // $qr = "SELECT terms_conditions FROM $terms";

        $this->db->select('terms_conditions');
        $this->db->from($terms);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $terms_con = $row->terms_conditions;
        }

        return $terms_con;
    }

    public function updateTermsConditionsSettings($newone) {
        //code edited by jiji
        $terms = "terms_conditions";
        //$qr = "UPDATE $terms SET `terms_conditions` = '$newone'";

        $data = array('terms_conditions' => $newone);
        $res = $this->db->update($terms, $data);

        return $res;
    }

    public function getRegAmount() {
        $reg_amount = "";

        $this->db->select('reg_amount');
        $this->db->from('configuration');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $reg_amount = $row->reg_amount;
        }

        return $reg_amount;
    }

    public function getLevelOnePercetage($level_no) {
        $level_per = "";
        $this->db->select('level_percentage');
        $this->db->from('level_commision');
        $this->db->where('level_no', $level_no);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $level_per = $row->level_percentage;
        }
        return $level_per;
    }

    public function getPVamount($product_id) {
        $pair_value = 0;
        $this->db->select('pair_value');
        $this->db->from('package');
        $this->db->where('product_id', $product_id);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $pair_value = $row->pair_value;
        }
        return $pair_value;
    }

    public function getDepthCieling() {
        $obj_arr = $this->getMatrixSettings();
        $depth_cieling = $obj_arr["depth_ceiling"];
        return $depth_cieling;
    }

    public function getMatrixSettings() {
        $obj_arr = array();
        $this->db->select("*");
        $this->db->from("configuration");
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $obj_arr["id"] = $row['id'];
            $obj_arr["tds"] = $row['tds'];
            $obj_arr["percentorvalue"] = $row['percentorvalue'];
            $obj_arr["service_charge"] = $row['service_charge'];
            $obj_arr["width_ceiling"] = $row['width_ceiling'];
            $obj_arr["depth_ceiling"] = $row['depth_ceiling'];
            $obj_arr["startDate"] = $row['start_date'];
            $obj_arr["endDate"] = $row['end_date'];
            $obj_arr["sms_status"] = $row['sms_status'];
            $obj_arr["payout_release"] = $row['payout_release'];
            $obj_arr["reg_amount"] = $row['reg_amount'];
            $obj_arr["referal_amount"] = $row['referal_amount'];
        }
        return $obj_arr;
    }

}
