<?php

/**
 * Model that handles system configuration requests
 * 
 * @since 1.21 change this file to request configuration only once on start
 * and use it aftermath for other requests
 */
Class settings_model extends inf_model {

    private $_table = 'configuration';
    
    private $_config;

    public function __construct() {
        $this->_config = $this->db->get($this->_table)->row_array();
    }

    public function isSetConfiguration()
    {
        return isset($this->_config['setting_staus']) ? $this->_config['setting_staus'] != 'no' : false;
    }

    public function getSettings()
    {
        return $this->_config;
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

    public function getTermsConditionsSettings()
    {
        return @$this->_config['terms_conditions'] ?: '';
    }

    public function updateTermsConditionsSettings($newone) {
        //code edited by jiji
        $terms = "terms_conditions";
        //$qr = "UPDATE $terms SET `terms_conditions` = '$newone'";

        $data = array('terms_conditions' => $newone);
        $res = $this->db->update($terms, $data);

        return $res;
    }

    public function getRegAmount()
    {
        return @$this->_config['reg_amount'] ?: '';
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

    public function getMatrixSettings()
    {
        return array_merge(array_intersect_key($this->_config, array_flip(['id', 'tds', 'percentorvalue', 'service_charge', 'width_ceiling', 'depth_ceiling', 'sms_status', 'payout_release', 'reg_amount', 'referal_amount'])), ['startDate' => $this->_config['start_date'], 'endDate' => $this->_config['end_date']]);
    }

    public function getFSBSettings()
    {    
        $arr = [
            'percentage' => intval($this->_config['fsb_percentage']) / 100,
            'turnover_1' => intval($this->_config['fsb_accumulated_turn_over_1']),
            'turnover_2' => intval($this->_config['fsb_accumulated_turn_over_2']),
            'first_liners' => intval($this->_config['fsb_required_firstliners']),
            'package' => intval($this->_config['fsb_firstliners_pack'])
        ];
        
        return $arr;
    }

    public function getDPCommission()
    {
        return @$this->_config['dp_percentage'] ?: '';
    }
    
}
