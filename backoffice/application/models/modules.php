<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modulesclass
 *
 * @author Administrator
 */
class Modules extends InfModel {

    public function trackModule() {
        $table_prefix = $this->table_prefix;
        $qry = "SELECT * FROM {$table_prefix}module_status";
        $res = $this->selectData($qry, "123");
        if ($row = mysql_fetch_array($res)) {
            $this->MODULE_STATUS['id'] = $row['id'];
            $this->MODULE_STATUS['mlm_plan'] = $row['mlm_plan'];
            $this->MODULE_STATUS['first_pair'] = $row['first_pair'];
            $this->MODULE_STATUS['pin_status'] = $row['pin_status'];
            $this->MODULE_STATUS['no_of_pin_types'] = $row['no_of_pin_types'];
            $this->MODULE_STATUS['product_status'] = $row['product_status'];
            $this->MODULE_STATUS['sms_status'] = $row['sms_status'];
            $this->MODULE_STATUS['mailbox_status'] = $row['mailbox_status'];
            $this->MODULE_STATUS['referal_status'] = $row['referal_status'];
            $this->MODULE_STATUS['sec_pswd_status'] = $row['sec_pswd_status'];
            $this->MODULE_STATUS['emp_login_status'] = $row['emp_login_status'];
            $this->MODULE_STATUS['news_status'] = $row['news_status'];
            $this->MODULE_STATUS['galery_status'] = $row['galery_status'];
            $this->MODULE_STATUS['feedback_status'] = $row['feedback_status'];
            $this->MODULE_STATUS['upload_status'] = $row['upload_status'];
        }
    }

    public function getSiteInformation() {
        $table_prefix = $_SESSION['table_prefix'];
        $qry = "SELECT * FROM {$table_prefix}site_information";

        $res = $this->selectData($qry, "Error : get company name title on Module st");
        if ($row = mysql_fetch_array($res)) {
            $information['company_name'] = $row['company_name'];
            $information['logo'] = $row['logo'];
            $information['email'] = $row['email'];
            $information['phone'] = $row['phone'];
            $information['favicon'] = $row['favicon'];
        }
        return $information;
    }

    public function getDefaultInformation() {
        $qry = "SELECT * FROM site_information";

        $res = $this->selectData($qry, "Error : get company name title on Module st");
        if ($row = mysql_fetch_array($res)) {
            $information['company_name'] = $row['company_name'];
            $information['logo'] = $row['logo'];
            $information['email'] = $row['email'];
            $information['phone'] = $row['phone'];
            $information['favicon'] = $row['favicon'];
        }
        return $information;
    }

    function getModuleID($module_link, $table_prefix) {

        $menu = $table_prefix . "infinite_mlm_menu";
        $qr = "SELECT id FROM $menu WHERE link='$module_link'";
        //echo $qr;
        $res = $this->selectData($qr, "Error on slect module_names-31224M");

        $row = mysql_fetch_array($res);
        if ($row["id"] != "") {
            $str = "m#" . $row["id"];



            //echo "eeeeeee".$str."<br>";
            return $str;
        } else {
            $menu = $table_prefix . "infinite_mlm_sub_menu";
            $qr = "SELECT  sub_id,sub_refid FROM $menu WHERE sub_link='$module_link'";
            $res = $this->selectData($qr, "Error on slect module_names-31224S");
            $row = mysql_fetch_array($res);
            if ($row["sub_id"] != "") {


                return $row["sub_refid"] . "#" . $row["sub_id"];
            } else {
                $menu = $table_prefix . "module_names";
                $qr = "SELECT id FROM $menu WHERE module_name='$module_link'";
                $res = $this->selectData($qr, "Err on slect module_names-31224S");
                if ($res) {

                    $row = mysql_fetch_array($res);
                    $str = "o" . "#" . $row["id"];

                    return $str;
                }
            }
        }
    }

}
