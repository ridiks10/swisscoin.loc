<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Balanceindexes extends CI_Migration {

    public function up()
    {
        # example up (create table)

        try {
            $this->db->trans_start();
            $this->db->query("ALTER TABLE {$this->db->dbprefix('leg_amount')} ADD INDEX (`user_id`), ADD INDEX (`from_id`), ADD INDEX (`amount_type`), ADD INDEX (`date_of_submission`);");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} ADD INDEX (`from_user_id`), ADD INDEX (`to_user_id`);");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('pin_purchases')} ADD INDEX (`pin_alloc_date`), ADD INDEX (`generated_user_id`), ADD INDEX (`allocated_user_id`), ADD INDEX (`purchase_status`);");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('amount_paid')} ADD INDEX (`paid_user_id`), ADD INDEX (`paid_date`), ADD INDEX (`paid_type`);");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('ewallet_payment_details')} ADD INDEX (`user_id`), ADD INDEX (`used_user_id`), ADD INDEX (`used_for`), ADD INDEX (`payed_account`), ADD INDEX (`date`);");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('amount_type')} ADD INDEX (`db_amt_type`);");
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            echo "Migration error" . PHP_EOL;
        }

    }

    public function down()
    {
        # example down (drop table)
        try {
            $this->db->trans_start();
            $this->db->query("ALTER TABLE {$this->db->dbprefix('leg_amount')} DROP INDEX `user_id`, DROP INDEX `from_id`, DROP INDEX `amount_type`, DROP INDEX `date_of_submission`;");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} DROP INDEX `from_user_id`, DROP INDEX `to_user_id`;");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('pin_purchases')} DROP INDEX `pin_alloc_date`, DROP INDEX `generated_user_id`, DROP INDEX `allocated_user_id`, DROP INDEX `purchase_status`;");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('amount_paid')} DROP INDEX `paid_user_id`, DROP INDEX `paid_date`, DROP INDEX `paid_type`;");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('ewallet_payment_details')} DROP INDEX `user_id`, DROP INDEX `used_user_id`, DROP INDEX `used_for`, DROP INDEX `payed_account`, DROP INDEX `date`;");
            $this->db->query("ALTER TABLE {$this->db->dbprefix('amount_type')} DROP INDEX `db_amt_type`;");
            $this->db->trans_complete();
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', $e->getMessage());
            echo "Migration error" . PHP_EOL;
        }
    }
}