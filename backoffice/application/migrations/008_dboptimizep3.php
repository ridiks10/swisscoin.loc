<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dboptimizep3 extends CI_Migration {

    protected function name() {
        return "DB optimize step 3";
    }
    
    protected function doQuery($query, $num, $total)
    {
        $this->db->query($query);
        $q = implode(' ', array_slice(explode(' ', $query, 4), 0 ,3));
        echo "STEP {$num}/{$total} Complete : {$q}" . PHP_EOL;
    }
    
    public function up()
    {
        try {
            $this->db->trans_start();
            echo "Migration {$this->name()} started to apply" . PHP_EOL;
            $queries = [
                "ALTER TABLE {$this->db->dbprefix('leg_amount')} DROP `total_leg`, DROP `left_leg`, DROP `right_leg`, DROP `leg_amount_carry`, DROP `flush_out_pair`, DROP `tds`, DROP `service_charge`, DROP `paid_status`, DROP `payout_date`, DROP `paid_current_date`, DROP `released_date`, DROP `paid_date`, DROP `product_id`, DROP `board_no`, DROP `board_serial_no`",
                "ALTER TABLE {$this->db->dbprefix('leg_amount')} 
                    CHANGE `total_amount` `total_amount` DOUBLE(12, 2) NOT NULL DEFAULT '0',
                    CHANGE `amount_payable` `amount_payable` DOUBLE(12, 2) NOT NULL DEFAULT '0',
                    CHANGE `cash_account` `cash_account` DOUBLE(12, 2) NOT NULL DEFAULT '0',
                    CHANGE `trading_account` `trading_account` DOUBLE(12, 2) NOT NULL DEFAULT '0';",
                "ALTER TABLE {$this->db->dbprefix('payout_release_requests')} 
                    CHANGE `requested_amount` `requested_amount` DOUBLE(12, 2) NOT NULL DEFAULT '0',
                    CHANGE `requested_amount_balance` `requested_amount_balance` DOUBLE(12, 2) NOT NULL DEFAULT '0';",
                "ALTER TABLE {$this->db->dbprefix('ft_individual')} CHANGE `default_currency` `default_currency` INT(5) NOT NULL DEFAULT '1';",
                "ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} CHANGE `amount` `amount` DOUBLE(12, 2) NOT NULL;",
                "ALTER TABLE {$this->db->dbprefix('amount_paid')} CHANGE `paid_amount` `paid_amount` DOUBLE(12, 2) NOT NULL;",
                "ALTER TABLE {$this->db->dbprefix('ewallet_payment_details')} CHANGE `used_amount` `used_amount` DOUBLE(12, 2) NOT NULL;",
                "ALTER TABLE {$this->db->dbprefix('user_balance_amount')} ADD INDEX (`aq_team_bv`), ADD INDEX (`week_team_bv`), ADD INDEX (`first_line_aq_bv`), ADD INDEX (`first_line_weekly_bv`), ADD INDEX (`status`);",
            ];
            $total = count($queries);
            foreach ($queries as $num => $query) {
                $this->doQuery($query, $num + 1, $total);
            }
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            echo "Migration {$this->name()} error" . PHP_EOL;
        }
    }

    public function down()
    {
        try {
            $this->db->trans_start();
            echo "Migration {$this->name()} started to rollback" . PHP_EOL;
            $queries = [
                "ALTER TABLE {$this->db->dbprefix('leg_amount')} 
                    ADD `total_leg` INT NOT NULL DEFAULT '0' AFTER `from_id`,
                    ADD `left_leg` INT NOT NULL DEFAULT '0' AFTER `total_leg`,
                    ADD `right_leg` INT NOT NULL DEFAULT '0' AFTER `left_leg`,
                    ADD `leg_amount_carry` INT(20) NULL DEFAULT '0' AFTER `total_amount`,
                    ADD `flush_out_pair` INT(20) NULL DEFAULT '0' AFTER `leg_amount_carry`,
                    ADD `tds` FLOAT(9, 2) NOT NULL DEFAULT '0' AFTER `amount_type`,
                    ADD `service_charge` FLOAT(9, 2) NOT NULL DEFAULT '0' AFTER `date_of_submission`,
                    ADD `paid_status` VARCHAR(50) NOT NULL DEFAULT 'no' AFTER `service_charge`,
                    ADD `payout_date` DATETIME NULL DEFAULT NULL AFTER `paid_status`,
                    ADD `paid_current_date` DATETIME NULL DEFAULT NULL AFTER `payout_date`,
                    ADD `released_date` DATE NULL DEFAULT NULL AFTER `user_level`,
                    ADD `paid_date` DATETIME NULL DEFAULT NULL AFTER `released_date`,
                    ADD `product_id` INT NOT NULL DEFAULT '0' AFTER `paid_date`,
                    ADD `board_no` DOUBLE NOT NULL DEFAULT '0' AFTER `oc_order_id`,
                    ADD `board_serial_no` DOUBLE NOT NULL DEFAULT '0' AFTER `board_no`,
                    CHANGE `total_amount` `total_amount` DOUBLE NOT NULL DEFAULT '0',
                    CHANGE `amount_payable` `amount_payable` DOUBLE NOT NULL DEFAULT '0',
                    CHANGE `cash_account` `cash_account` DOUBLE NOT NULL DEFAULT '0',
                    CHANGE `trading_account` `trading_account` DOUBLE NOT NULL DEFAULT '0';",
                "ALTER TABLE {$this->db->dbprefix('payout_release_requests')} 
                    CHANGE `requested_amount` `requested_amount` DOUBLE NOT NULL DEFAULT '0',
                    CHANGE `requested_amount_balance` `requested_amount_balance` DOUBLE NOT NULL DEFAULT '0';",
                "ALTER TABLE {$this->db->dbprefix('ft_individual')} CHANGE `default_currency` `default_currency` INT(100) NOT NULL DEFAULT '1';",
                "ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} CHANGE `amount` `amount` DOUBLE NOT NULL",
                "ALTER TABLE {$this->db->dbprefix('amount_paid')} CHANGE `paid_amount` `paid_amount` DOUBLE NOT NULL;",
                "ALTER TABLE {$this->db->dbprefix('ewallet_payment_details')} CHANGE `used_amount` `used_amount` INT NOT NULL;",
                "ALTER TABLE {$this->db->dbprefix('user_balance_amount')} DROP INDEX `aq_team_bv`, DROP INDEX `week_team_bv`, DROP INDEX `first_line_aq_bv`, DROP INDEX `first_line_weekly_bv`, DROP INDEX `status`;",
            ];
            $total = count($queries);
            foreach ($queries as $num => $query) {
                $this->doQuery($query, $num + 1, $total);
            }
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            echo "Migration error" . PHP_EOL;
        }
    }
}