<?php

Class misc_model extends inf_model {

    function __construct() {
        parent::__construct();
    }

    public function getNow($format) {
        $now = date($format);
        return $now;
    }

    public function alert($msg) {
        echo "<script>alert('$msg');</script>";
    }

    public function redirect($msg, $page) {
        echo "<script>alert('$msg');</script>";
        echo "<script>document.location.href='" . $page . "';</script>";
    }

    public function createAlert($var, $success, $fail, $redirect) {
        if ($var)
            echo "<script>alert('" . $success . "');</script>";
        else
            echo "<script>alert('" . $fail . "');</script>";
        if ($redirect != "")
            echo "<script>document.location.href='" . $redirect . "';</script>";
    }

    public function getRandStr($minlength, $maxlength, $useupper = true, $usespecial = false, $usenumbers = true) {
        $charset = "";
        $key = "";

        $pin_config = $this->getPinConfig();
        $pin_length = $pin_config["pin_length"];
        $character_set = $pin_config["pin_character_set"];
        if ($character_set == "alphabet") {
            if ($useupper)
                $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        }
        else if ($character_set == "numeral") {
            $charset = "0123456789";
        } else {
            if ($useupper)
                $charset .= "ABCDEFGHIJKLMNPQRSTUVWXYZ";
            $charset .= "23456789";
        }
        if ($usespecial)
            $charset .= "~@#$%^*()_+-={}|]["; // Note: using all special characters this reads: "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";

        $length = $pin_length;

        for ($i = 0; $i < $length; $i++)
            $key .= $charset[(mt_rand(0, (strlen($charset) - 1)))];

        $randum_number = $key;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $pin_numbers = $this->table_prefix . "pin_numbers";
        $query = "SELECT * FROM $pin_numbers WHERE pin_numbers = '$randum_number'";

        $result = mysql_query($query) or die(mysql_error());

        if (!mysql_num_rows($result))
            return $key;
        else
            $this->getRandStr($minlength, $maxlength);
    }

    public function createSelect($field, $db_field, $db_id, $table, $condition, $post, $class) {

        echo "<select name=\"" . $field . "\" id=\"" . $field . "\" class=\"$class\">";

        $memsql = "SELECT $db_field,$db_id FROM $table";
        if ($condition != "")
            $memsql.=$condition;
        $memres = mysql_query($memsql) or die("Error on selecting");
        echo "<option value=''>Select</option>";
        while ($member = mysql_fetch_array($memres)) {
            if ($post == $member[$db_id])
                echo "<option value='" . $member[$db_id] . "' selected='selected'>" . $member[$db_field] . "</option>";
            else
                echo "<option value='" . $member[$db_id] . "'>" . $member[$db_field] . "</option>";
        }

        echo "</select>";
    }

    public function getEncrypt($string) {
        $key = "EASY1055MLM!@#$";
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result.=$char;
        }

        return base64_encode($result);
    }

    public function getDecrypt($string) {
        $key = "EASY1055MLM!@#$";
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result.=$char;
        }

        return $result;
    }

    public function getPinConfig() {
        $config = array();
        $this->db->select('*');
        $query = $this->db->get('pin_config');
        foreach ($query->result_array() as $row) {
            $config["pin_amount"] = $row["pin_amount"];
            $config["pin_length"] = $row["pin_length"];
            $config["pin_type"] = $row["pin_type"];
            $config["pin_maxcount"] = $row["pin_maxcount"];
            $config["pin_character_set"] = $row["pin_character_set"];
        }
        return $config;
    }

}
