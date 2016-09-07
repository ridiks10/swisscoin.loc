<?php

class fix_issues_model extends Core_inf_model {

    function __construct() {
        parent::__construct();
    }

    public function fixTableFields($table, $field_name) {
        $database_name = $this->db->database;

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '%$table'");
        foreach ($table_query->result_array() AS $rows) {
            $table_name = $rows['TABLE_NAME'];
            if (!$this->checkFieldExists($field_name, $table_name)) {
                $split_table = explode("_", $table_name);
                $table_prefix = $split_table[0];
                $this->alterTable($table, $table_name, $table_prefix);
            }
        }
        return true;
    }

    public function checkFieldExists($field_name, $table_name) {
        $table_query = $this->db->query("Show columns from $table_name like '$field_name'");
        $count = $table_query->num_rows;
        return $count;
    }

    public function alterTable($table, $table_name, $table_prefix, $field_name = "") {
        if ($table == "infinite_languages") {
            $this->db->query("ALTER TABLE `$table_name` ADD `default_id` INT NOT NULL DEFAULT '0'");
            $this->db->query("UPDATE  `$table_name` SET `default_id`= 1  WHERE lang_id =1");
            if ($table_prefix != 'infinite') {
                $this->db->query("ALTER TABLE " . $table_prefix . "_login_user ALTER COLUMN default_lang SET DEFAULT 1");
            }
            if ($this->checkCompanyName($table_prefix)) {
                $this->db->query("UPDATE `" . $table_prefix . "_site_information` SET `company_name` = 'Infinite MLM Software 7.0' WHERE `id` =1;");
            }
        } elseif ($table == "common_mail_settings") {
            $this->db->query("ALTER TABLE `` ADD `mail_status` VARCHAR( 10 ) NOT NULL DEFAULT 'yes'");
        } else if ($table == "leg_amount") {
            if ($field_name == "oc_order_id") {
                $this->db->query("ALTER TABLE `$table_name` ADD `oc_order_id` DOUBLE NOT NULL DEFAULT '0'");
            } else if ($field_name == "board_no") {
                $this->db->query("ALTER TABLE `$table_name` ADD `board_no` DOUBLE NOT NULL DEFAULT '0' ");
            } else if ($field_name == "board_serial_no") {
                $this->db->query("ALTER TABLE `$table_name` ADD `board_serial_no` DOUBLE NOT NULL DEFAULT '0' AFTER `board_no` ");
            }
        }
    }

    public function checkCompanyName($table_prefix) {
        $query = $this->db->query("SELECT id FROM `" . $table_prefix . "_site_information` WHERE `company_name` = 'Infinite MLM Software 6.0' ");
        $count = $query->num_rows;
        return $count;
    }

    public function fixTableEngineType() {
        $database_name = $this->db->database;
        $type = 'InnoDB';
        $innodb_tables = array("ft_individual", "login_user", "user_details", "auto_board_1", "auto_board_2", "board_view", "board_user_detail", "leg_details", "leg_amount", "user_balance_amount", "tran_password", "infinite_user_registration_details", "pin_numbers", "payment_registration_details", "epdq_payment_order", "credit_card_purchase_details", "pin_used", "ewallet_payment_details", "sales_order");

        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `account_status` != 'deleted'");

        foreach ($query->result_array()AS $row) {
            $table_prefix = $row['id'] . "_";

            foreach ($innodb_tables AS $innodb_table) {
                $inno_table_name = $table_prefix . $innodb_table;
                $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$inno_table_name'");

                foreach ($table_query->result_array() AS $rows) {
                    $table_name = $rows['TABLE_NAME'];
                    $this->db->query("ALTER TABLE `$table_name` ENGINE = $type");
                }
            }
        }
        return true;
    }

    public function fixTableStructConfig($table,$field) {
           $database_name = $this->db->database;
           $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `account_status` != 'deleted'");
           foreach ($query->result_array()AS $row) {
                $table_prefix =$row['id'].$table;
           $query1="ALTER TABLE  `$table_prefix` CHANGE  `$field`  `$field` DOUBLE NOT NULL";
           $result1=$this->db->query($query1);
           
           }
           $query2="ALTER TABLE  `inf$table` CHANGE  `$field`  `$field` DOUBLE NOT NULL";
           $result2=$this->db->query($query2);
          if($result1 && $result2) {
              return true;
          }
    }
      public function InsertActivityHistoryMenu() {   
          
     $database_name = $this->db->database;
           $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `account_status` != 'deleted'");
           foreach ($query->result_array()AS $row) {
                $table_prefix =$row['id'].'_infinite_mlm_menu';
                $table_prefix_inf_urls =$row['id'].'_infinite_urls';
                $insert="Delete from $table_prefix where link_ref_id='129'";
                //$result2=$this->db->query($insert);
                $insert="Delete from $table_prefix_inf_urls where id='128'";
              // $result2=$this->db->query($insert);
    
        }
        $insert="Delete from inf_infinite_mlm_menu where link_ref_id='129'";
        //$result2=$this->db->query($insert);
        $insert="Delete from inf_infinite_urls where id='128'";
        // $result2=$this->db->query($insert);
        
         //$result4=$this->db->query($insert_infinit_urls);
         if($result1 && $result2 && $result3 && $result4)
         return true;
    } 
     public function InsertActivityHistoryMenu1() {
           $database_name = $this->db->database;
           $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `account_status` != 'deleted'");
           foreach ($query->result_array()AS $row) {
                $table_prefix =$row['id'].'_infinite_mlm_menu';
                $table_prefix_inf_urls =$row['id'].'_infinite_urls';
                $insert="INSERT INTO $table_prefix (
                `id` ,
                `link_ref_id` ,
                `icon` ,
                `status` ,
                `perm_admin` ,
                `perm_dist` ,
                `perm_emp` ,
                `main_order_id`
                )
                VALUES (
                NULL , '129','clip-stack-empty', 'yes', '1', '0', '0', '28'
                )";
               // $result1=$this->db->query($insert);
               $insert_inf_urls ="INSERT INTO $table_prefix_inf_urls (
                `id` ,
                `link` ,
                `status` ,
                `target`
                )
                VALUES (
                NULL , 'activity_history/activity_history_view', 'yes', 'none'
                )";
                //$result2=$this->db->query($insert_inf_urls);
        }
        $insert_infinite="INSERT INTO inf_infinite_mlm_menu (
         `id` ,
         `link_ref_id` ,
         `icon` ,
         `status` ,
         `perm_admin` ,
         `perm_dist` ,
         `perm_emp` ,
         `main_order_id`
         )
         VALUES (
         NULL , '129','clip-stack-empty', 'yes', '1', '0', '0', '28'
         )";
        //$result3=$this->db->query($insert_infinite);
         $insert_infinit_urls ="INSERT INTO inf_infinite_urls (
         `id` ,
         `link` ,
         `status` ,
         `target`
         )
         VALUES (
         NULL , 'activity_history/activity_history_view', 'yes', 'none'
         )";
         //$result4=$this->db->query($insert_infinit_urls);
         if($result1 && $result2 && $result3 && $result4)
         return true;
    }
    public function fixConfigurationStartEndDates() {
        $database_name = $this->db->database;

        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `account_status` != 'deleted'");

        foreach ($query->result_array()AS $row) {
            $table_prefix = $row['id'] . "_";
            $inno_table_name = $table_prefix . "configuration";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$inno_table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $table_name = $rows['TABLE_NAME'];
                $this->db->query("UPDATE  `$table_name` SET  `start_date` =  'Sunday' WHERE  `id` =1");
                $this->db->query("UPDATE  `$table_name` SET  `end_date` =  'Saturday' WHERE  `id` =1;");
            }
        }

        $table_name = "inf_configuration";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("UPDATE  `$table_name` SET  `start_date` =  'Sunday' WHERE  `id` =1");
            $this->db->query("UPDATE  `$table_name` SET  `end_date` =  'Saturday' WHERE  `id` =1;");
        }

        return true;
    }

    public function fixAmountTypeTable() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE `mlm_plan` = 'Board' AND `account_status` != 'deleted'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "amount_type";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $insert_query = $this->db->query("INSERT INTO `$table_name` (`db_amt_type`, `view_amt_type`, `status`) VALUES ('board_commission', 'Board Commission', 'yes')");
            }
        }

        $inf_table = 'inf_amount_type';
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$inf_table'");
        foreach ($table_query->result_array() AS $rows) {
            $insert_query = $this->db->query("INSERT INTO `$inf_table` (`db_amt_type`, `view_amt_type`, `status`) VALUES ('board_commission', 'Board Commission', 'yes')");
        }

        return true;
    }

    public function fixCountryNameToId() {
        $this->load->model("country_state_model");
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "user_details";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $user_query = $this->db->query("SELECT `user_detail_country` FROM (`$table_name`) WHERE  `user_detail_id` =1");
                foreach ($user_query->result_array() AS $rows) {
                    $country_name = $rows['user_detail_country'];
                    $country_id = $this->country_state_model->getCountryIDFromName($country_name);
                    $country_id = ($country_id > 0) ? $country_id : 99;
                    $this->db->query("UPDATE  `$table_name` SET  `user_detail_country` =  '$country_id' WHERE  `user_detail_id` =1");
                }
            }
        }
        return true;
    }

    public function fixMailStatusField() {
        $database_name = $this->db->database;
        $field_name = "mail_status";
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        $table = "common_mail_settings";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "common_mail_settings";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                if (!$this->checkFieldExists($field_name, $table_name)) {
                    $split_table = explode("_", $table_name);
                    $table_prefix = $split_table[0];
                    $this->alterTable($table, $table_name, $table_prefix);
                }
            }
        }
        $table_name = "inf_common_mail_settings";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            if (!$this->checkFieldExists($field_name, $table_name)) {
                $split_table = explode("_", $table_name);
                $table_prefix = $split_table[0];
                $this->alterTable($table, $table_name, $table_prefix);
            }
        }
        return true;
    }

    public function fixDefaultMailContent() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "common_mail_settings";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $truncate_query = $this->db->query("TRUNCATE TABLE `$table_name`");

                if ($truncate_query) {
                    $insert_query = $this->db->query("INSERT INTO `$table_name` (`id`, `mail_type`, `subject`, `mail_content`, `date`, `mail_status`) VALUES
(1, 'registration', 'Welcome!', '<div style=\"width: 80%; padding: 40px; border: solid 10px #D0D0D0; margin: 50px auto;\">\n<div style=\"width: 100%; margin: 15px 0 0 0;\">\n<p>&lt;p&gt;Your MLM software is now Activated.&lt;/p&gt;</p>\n<p>&lt;p&gt;Please save this message, so you will have permanent record of your Infinite MLM Software.I trusted that this mail finds you mutually excited about your new opportunity with Infinite Open Source Solutions LLP.&lt;br /&gt;Each of us will play a role to ensure your successful integration into the company.&lt;/p&gt;</p>\n<p>&lt;p&gt;Thank you for using Infinite MLM service&lt;/p&gt;</p>\n<p>&lt;p&gt;&amp;nbsp;&lt;/p&gt;</p>\n</div>\n</div>', '2015-06-24 09:12:51', 'yes'),
(2, 'payout_release', 'Payout Released', '<p>&nbsp; Your Payout Released Successfully........</p>', '2015-11-21 11:32:35', 'yes'),
(3, 'Forgot_pswd', 'Reset Password', '<p>&nbsp;Dear {user_name}</p>\n<table id=\"Table_01\" border=\"0\" width=\"600\" cellspacing=\"0\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td colspan=\"3\">&nbsp;</td>\n</tr>\n</tbody>\n</table>\n<table border=\"0\" width=\"60%\" cellpadding=\"0\">\n<tbody>\n<tr>\n<td colspan=\"2\" align=\"center\"><strong>Your current password is :{password}</strong></td>\n</tr>\n<tr>\n<td colspan=\"2\">Thanking you,</td>\n</tr>\n<tr>\n<td colspan=\"2\">\n<p align=\"left\">{company_name}<br />Date:{date}<br />Place :{place}</p>\n</td>\n</tr>\n</tbody>\n</table>', '2015-01-16 10:19:26', 'yes')");
                }
            }
        }
        return true;
    }

    public function fixDefaultMailSettings() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "mail_settings";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("UPDATE `" . $table_prefix . "mail_settings` SET `smtp_host` = 'mail.ioss.in', `smtp_username` = 'iossmlm@ioss.in',`smtp_password` = 'ceadecs001', `reg_mail_type` = 'normal',smtp_port = 25, smtp_protocol='tls'  WHERE `id` =1;");
            }
        }
        $this->db->query("UPDATE `inf_mail_settings` SET `smtp_host` = 'mail.ioss.in', `smtp_username` = 'iossmlm@ioss.in',`smtp_password` = 'ceadecs001', `reg_mail_type` = 'normal',smtp_port = 25, smtp_protocol='tls'  WHERE `id` =1;");
        return true;
    }

    public function fixDefaultMailID() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "site_information";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("UPDATE `" . $table_name . "` SET `email` = 'iossmlm@gmail.com' WHERE `id` =1;");
            }
        }
        $table_name = "site_information";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("UPDATE `" . $table_name . "` SET `email` = 'iossmlm@gmail.com' WHERE `id` =1;");
        }
        return true;
    }

    public function fixFacebookShareContent() {
        $database_name = $this->db->database;

        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
//        print_r($query->result_array()); die();
        $table = "invites_configuration";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "invites_configuration";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $count_query = $this->db->query("SELECT *  FROM (`" . $table_name . "`) WHERE `type` = 'social_fb'");
                $count = $count_query->num_rows;
                if ($count > 0) {
                    $this->db->query("UPDATE `" . $table_name . "` SET `subject` = 'Infinite Open Source Solutions LLP', `content` = 'The Infinite MLM software is an entire solution for all types of business plans like Binary, Matrix, Unilevel, Board, Monoline, Generation and many other MLM Compensation Plans. This software is developed by leading Software development company Infinite Open Source Solutions LLP.  We provide an experience which is way more than just basic MLM Software. Our MLM Website Design integrates SMS, E-Wallet, Replicated Website, E-Pin and many more features.\n' WHERE `type` = 'social_fb'");
                } else {
                    $this->db->query("INSERT INTO `" . $table_name . "` (`subject`, `content`, `type`) VALUES ('Infinite Open Source Solutions LLP', 'The Infinite MLM software is an entire solution for all types of business plans like Binary, Matrix, Unilevel, Board, Monoline, Generation and many other MLM Compensation Plans. This software is developed by leading Software development company Infinite Open Source Solutions LLP.  We provide an experience which is way more than just basic MLM Software. Our MLM Website Design integrates SMS, E-Wallet, Replicated Website, E-Pin and many more features.\n', 'social_fb')");
                }
            }
        }

        $table_name = "inf_invites_configuration";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("INSERT INTO `" . $table_name . "` (`subject`, `content`, `type`) VALUES ('Infinite Open Source Solutions LLP', 'The Infinite MLM software is an entire solution for all types of business plans like Binary, Matrix, Unilevel, Board, Monoline, Generation and many other MLM Compensation Plans. This software is developed by leading Software development company Infinite Open Source Solutions LLP.  We provide an experience which is way more than just basic MLM Software. Our MLM Website Design integrates SMS, E-Wallet, Replicated Website, E-Pin and many more features.\n', 'social_fb')");
        }

        return true;
    }

//OPENCART NEW THEME TABLES - START

    public function createDefaultOpencartTables() {
        $create_table_query = $this->db->query("CREATE TABLE inf_opencart_table_names LIKE 1177_opencart_table_name");

        $database_name = $this->db->database;

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '1177_oc_%'");
        foreach ($table_query->result_array() AS $rows) {
            $table_name = str_replace("1177_oc_", "", $rows['TABLE_NAME']);
            $insert_query = $this->db->query("INSERT INTO inf_opencart_table_names SET table_name = '$table_name'");
        }
    }

    public function generateNewOpencartTables() {
        $query = $this->db->query("SELECT `id`,`user_name` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted' AND `id` != '53'");

        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'];
            $user_name = $rows['user_name'];
            if ($this->checkOpencartEnabled($table_prefix)) {
                echo "<br>$table_prefix $user_name : oc enabled<br>";
                $this->createOpencartTables($table_prefix);
            }
        }
        $this->createOpencartTables('inf');

        return true;
    }

    public function checkOpencartEnabled($table_prefix) {

        $opencart_status_demo = false;
        $database_name = $this->db->database;

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '" . $table_prefix . "_module_status'");
        foreach ($table_query->result_array() AS $rows) {
            $query = $this->db->query("SELECT opencart_status_demo FROM " . $table_prefix . "_module_status");
            $result = $query->result_array();

            if ($query->num_rows) {
                if ($result[0]['opencart_status_demo'] == "yes") {
                    $opencart_status_demo = true;
                }
            }
        }
        return $opencart_status_demo;
    }

    public function createOpencartTables($id) {

        $table_name = $this->getOpencartTableNames();
        $cnt = count($table_name);
        for ($i = 0; $i < $cnt; $i++) {
            $oc_table = "53_oc_" . $table_name [$i];
            $table = $id . "_oc_" . $table_name [$i];
            $table_old = $id . "_" . $table_name [$i];

            $this->db->query("DROP TABLE IF EXISTS $table");
            $this->db->query("DROP TABLE IF EXISTS $table_old");
            $this->db->query("CREATE TABLE $table LIKE $oc_table");
            $this->db->query("INSERT INTO $table SELECT * FROM $oc_table");
        }
    }

    public function dropOpencartTables($id) {
        $table_name = $this->getOpencartTableNames();
        $cnt = count($table_name);
        for ($i = 0; $i < $cnt; $i++) {
            $table = $id . "_" . $table_name [$i];
            $this->db->query("DROP TABLE IF EXISTS $table ");
        }
    }

    public function getOpencartTableNames() {
        $data = array();
        $res = $this->db->query("SELECT table_name FROM inf_opencart_table_names");
        foreach ($res->result() as $row) {
            $data[] = $row->table_name;
        }

        return $data;
    }

//OPENCART NEW THEME TABLES - END
    public function fixSMTPSettings() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        $table = "mail_settings";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "mail_settings";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("ALTER TABLE  `" . $table_name . "` ADD  `smtp_authentication` VARCHAR( 5 ) NOT NULL DEFAULT  '1',
ADD  `smtp_protocol` VARCHAR( 5 ) NOT NULL DEFAULT  'none'");
            }
        }
        $table_name = "inf_mail_settings";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("ALTER TABLE  `" . $table_name . "` ADD  `smtp_authentication` VARCHAR( 5 ) NOT NULL DEFAULT  '1',
ADD  `smtp_protocol` VARCHAR( 5 ) NOT NULL DEFAULT  'none'");
        }
        return true;
    }

    public function fixLegAmountFields() {
        $database_name = $this->db->database;
        $table = "leg_amount";
        $new_fields = array("oc_order_id", "board_no", "board_serial_no");

        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '%$table'");
        foreach ($table_query->result_array() AS $rows) {
            $table_name = $rows['TABLE_NAME'];
            foreach ($new_fields AS $field_name) {
                if (!$this->checkFieldExists($field_name, $table_name)) {
                    $split_table = explode("_", $table_name);
                    $table_prefix = $split_table[0];
                    $this->alterTable($table, $table_name, $table_prefix, $field_name);
                }
            }
        }
        return true;
    }

    public function fixBvFieldName() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        $table = "package";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "package";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("ALTER TABLE  `" . $table_name . "` CHANGE  `prod_bv`  `bv_value` DOUBLE NOT NULL");
            }
        }
        $table_name = "inf_package";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("ALTER TABLE  `" . $table_name . "` CHANGE  `prod_bv`  `bv_value` DOUBLE NOT NULL");
        }
        return true;
    }

    public function createKbAttachmentsTable() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM `infinite_mlm_user_detail` WHERE  `account_status` != 'deleted'");
        foreach ($query->result_array() AS $rows) {
            $table = $rows['id'] . "_kb_attachments";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '" . $rows['id'] . "_module_status'");
            foreach ($table_query->result_array() as $row) {
                $qur = $this->db->query("SELECT `ticket_system_status_demo` from `" . $rows['id'] . "_module_status`");
                $qur = $qur->result_array();
                $ticket_system_status = $qur[0]['ticket_system_status_demo'];
                if ($ticket_system_status == 'yes') {
                    $this->db->query("DROP TABLE IF EXISTS $table");
                    $this->db->query("CREATE TABLE $table LIKE inf_kb_attachments");
                }
            }
        }
        return true;
    }
    
    public function renameTicketSystem() {
        $query = $this->db->query("SELECT `id`,`user_name` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted' ");
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'];
            $user_name = $rows['user_name'];
            if ($this->checkTicketSystemEnabled($table_prefix)) {
                echo "<br>$table_prefix $user_name : ticket enabled<br>";
                $this->renameTicketSystemTables($table_prefix);
            }
        }
        $this->renameTicketSystemTables('inf');

        return true;
    }
        public function renameTicketSystemTables($id) {
            $table_name = $this->getTicketSystemTableNames();
            $cnt = count($table_name);
            for ($i = 0; $i < $cnt; $i++) {
                  $table = $id . "_ticket_" . $table_name [$i];
                  $table_old = $id . "_" . $table_name [$i];
                  $this->db->query("RENAME TABLE $table_old TO $table") ;
            }
        }
        public function checkTicketSystemEnabled($table_prefix) {

            $ticketsystem_status_demo = false;
            $database_name = $this->db->database;

            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME LIKE '" . $table_prefix . "_module_status'");
            foreach ($table_query->result_array() AS $rows) {
                $query = $this->db->query("SELECT ticket_system_status_demo FROM " . $table_prefix . "_module_status");
                $result = $query->result_array();

                if ($query->num_rows) {
                    if ($result[0]['ticket_system_status_demo'] == "yes") {
                        $ticketsystem_status_demo = true;
                    }
                }
            }
            return $ticketsystem_status_demo;
       }
       
       public function getTicketSystemTableNames() {
            $data = array();
            $res = $this->db->query("SELECT table_name FROM inf_get_ticket_system");
            foreach ($res->result() as $row) {
                $data[] = $row->table_name;
            }

            return $data;
      }
      
    public function fixActivityHistoryTable() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        $table = "activity_history";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "activity_history";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("ALTER TABLE $table_name ADD  `data` TEXT NOT NULL ;");
                $this->db->query("ALTER TABLE  $table_name ADD  `notification_status` BOOLEAN NOT NULL DEFAULT FALSE ;");
                echo $table_name . '<br>';
            }
        }
        $table_name = "inf_activity_history";
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("ALTER TABLE $table_name ADD  `data` TEXT NOT NULL ;");
            $this->db->query("ALTER TABLE  $table_name ADD  `notification_status` BOOLEAN NOT NULL DEFAULT FALSE ;");
        }
        return true;
    }
    
    public function fixModuleStatusTableField() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted' AND mlm_plan != 'Board'");
        $table = "module_status";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name = $table_prefix . "module_status";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("ALTER TABLE  `$table_name` ADD  `table_status` VARCHAR( 5 ) NOT NULL DEFAULT  'no';");
                $this->db->query("UPDATE  `$table_name` SET  `table_status` =  'no';");
            }
        }
        return true;
    }

    public function fixPlanSettingsMenu() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        $table1 = "infinite_mlm_sub_menu";
        $table2 = "infinite_urls";
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name1 = $table_prefix . "infinite_mlm_sub_menu";
            $table_name2 = $table_prefix . "infinite_urls";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name1'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("INSERT INTO `$table_name2` (`id`, `link`, `status`, `target`) VALUES (126, 'configuration/plan_settings', 'yes', 'none');");
                $this->db->query("INSERT INTO `$table_name1` (`sub_id`, `sub_link_ref_id`, `icon`, `sub_status`, `sub_refid`, `perm_admin`, `perm_dist`, `perm_emp`, `sub_order_id`) VALUES (76, '126', 'clip-world', 'yes', 10, 1, 0, 1, 1);");
                echo $table_name1 . '   ' . $table_name2 . '<br>';
            }
        }
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name1'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("INSERT INTO `inf_infinite_urls` (`id`, `link`, `status`, `target`) VALUES (126, 'configuration/plan_settings', 'yes', 'none');");
            $this->db->query("INSERT INTO `inf_infinite_mlm_sub_menu` (`sub_id`, `sub_link_ref_id`, `icon`, `sub_status`, `sub_refid`, `perm_admin`, `perm_dist`, `perm_emp`, `sub_order_id`) VALUES (76, '126', 'clip-world', 'yes', 10, 1, 0, 1, 1);");
        }
        return true;
    }
    
    public function fixUnilevelListMenu() {
        $database_name = $this->db->database;
        $query = $this->db->query("SELECT `id` FROM (`infinite_mlm_user_detail`) WHERE  `account_status` != 'deleted'");
        foreach ($query->result_array() AS $rows) {
            $table_prefix = $rows['id'] . "_";
            $table_name1 = $table_prefix . "infinite_mlm_menu";
            $table_name2 = $table_prefix . "infinite_mlm_sub_menu";
            $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name1'");
            foreach ($table_query->result_array() AS $rows) {
                $this->db->query("UPDATE  `$table_name1` SET  `perm_dist` =  '1' WHERE  `id` =25;");
                $this->db->query("UPDATE  `$table_name2` SET  `perm_dist` =  '1' WHERE  `sub_id` =54 OR `sub_id` =55;");
                echo $table_name1 . ' == ' . $table_name2 . '<br>';
            }
        }
        $table_query = $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='$database_name' AND TABLE_NAME = '$table_name1'");
        foreach ($table_query->result_array() AS $rows) {
            $this->db->query("UPDATE  `inf_infinite_mlm_menu` SET  `perm_dist` =  '1' WHERE  `id` =25;");
            $this->db->query("UPDATE  `inf_infinite_mlm_sub_menu` SET  `perm_dist` =  '1' WHERE  `sub_id` =54 OR `sub_id` =55;");
        }
        return true;
    }
}
