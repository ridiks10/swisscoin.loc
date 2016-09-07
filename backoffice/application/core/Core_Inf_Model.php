<?php

/**
 * @property-read validation_model $validation_model Validation model :D
 * Try avoid to use this model as much as you can, because there is to much DB requests
 */
class Core_Inf_Model extends CI_Model {

    public $ARR_SCRIPT;

    public function setDBPrefix($table_prefix) {
        if ($table_prefix != '') {
            $this->db->set_dbprefix($table_prefix);
            $this->db->set_ocprefix($table_prefix . "oc_");
        }
    }

    public function isValidDemoID($demo_id) {
        $flag = FALSE;
        $count = 0;

        $query = $this->db->query("SELECT COUNT(*) AS `numrows` FROM (`infinite_mlm_user_detail`) WHERE `id` = '$demo_id' AND `account_status` != 'deleted'");
        foreach ($query->result() AS $row) {
            $count = $row->numrows;
        }
        if ($count) {
            $flag = TRUE;
        }
        return $flag;
    }

    public function begin() {
        $this->db->trans_start();
    }

    public function commit() {
        $this->db->trans_commit();
    }

    public function rollBack() {
        $this->db->trans_rollback();
    }

    /**
     * @deprecated 1.21
     */
    public function getWritelock($tables_arr) {
        log_message('error', 'Core_Inf_Model->getWritelock() :: Deprecated call');
    }

    /**
     * @deprecated 1.21
     */
    public function getReadlock($tables_arr) {
        log_message('error', 'Core_Inf_Model->getReadlock() :: Deprecated call');
    }

}
