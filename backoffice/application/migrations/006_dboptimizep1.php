<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dboptimizep1 extends CI_Migration {

    protected function name() {
        return "DB optimize step 1";
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
                "ALTER TABLE {$this->db->dbprefix('cron_history')} ADD INDEX (`cron`), ADD INDEX (`date`), ADD INDEX (`end_date`);",
                "ALTER TABLE {$this->db->dbprefix('employee_details')} ADD INDEX (`user_detail_refid`), ADD INDEX (`user_detail_name`), ADD INDEX (`user_detail_second_name`), ADD INDEX (`user_detail_email`), ADD INDEX (`user_detail_mobile`);",
                "ALTER TABLE {$this->db->dbprefix('ft_individual')} ADD INDEX (`career`);",
                "ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} ADD INDEX (`date`), ADD INDEX (`amount_type`);",
                "ALTER TABLE {$this->db->dbprefix('kyc_details')} ADD INDEX (`user_id`), ADD INDEX (`address_status`), ADD INDEX (`passport_status`);",
                "ALTER TABLE {$this->db->dbprefix('mailtoadmin')} ADD INDEX (`mailaduser`), ADD INDEX (`status`), ADD INDEX (`read_msg`);",
                "ALTER TABLE {$this->db->dbprefix('mailtouser')} ADD INDEX (`mailtoususer`), ADD INDEX (`status`), ADD INDEX (`read_msg`);",
                "ALTER TABLE {$this->db->dbprefix('mail_from_lead')} ADD INDEX (`mail_from`), ADD INDEX (`mail_to`), ADD INDEX (`mail_date`), ADD INDEX (`status`), ADD INDEX (`read_msg`);",
                "ALTER TABLE {$this->db->dbprefix('mail_from_lead_cumulative')} ADD INDEX (`mail_from`), ADD INDEX (`mail_to`), ADD INDEX (`mail_date`), ADD INDEX (`status`), ADD INDEX (`read_msg`);",
                "ALTER TABLE {$this->db->dbprefix('minings')} ADD INDEX (`user_id`), ADD INDEX (`date`);",
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

    public function down()
    {
        try {
            $this->db->trans_start();
            echo "Migration {$this->name()} started to rollback" . PHP_EOL;
            $queries = [
                "ALTER TABLE {$this->db->dbprefix('cron_history')} DROP INDEX `cron`, DROP INDEX `date`, DROP INDEX `end_date`;",
                "ALTER TABLE {$this->db->dbprefix('employee_details')} DROP INDEX `user_detail_refid`, DROP INDEX `user_detail_name`, DROP INDEX `user_detail_second_name`, DROP INDEX `user_detail_email`, DROP INDEX `user_detail_mobile`;",
                "ALTER TABLE {$this->db->dbprefix('ft_individual')} DROP INDEX `career`;",
                "ALTER TABLE {$this->db->dbprefix('fund_transfer_details')} DROP INDEX `date`, DROP INDEX `amount_type`;",
                "ALTER TABLE {$this->db->dbprefix('kyc_details')} DROP INDEX `user_id`, DROP INDEX `address_status`, DROP INDEX `passport_status`;",
                "ALTER TABLE {$this->db->dbprefix('mailtoadmin')} DROP INDEX `mailaduser`, DROP INDEX `status`, DROP INDEX `read_msg`;",
                "ALTER TABLE {$this->db->dbprefix('mailtouser')} DROP INDEX `mailtoususer`, DROP INDEX `status`, DROP INDEX `read_msg`;",
                "ALTER TABLE {$this->db->dbprefix('mail_from_lead')} DROP INDEX `mail_from`, DROP INDEX `mail_to`, DROP INDEX `mail_date`, DROP INDEX `status`, DROP INDEX `read_msg`;",
                "ALTER TABLE {$this->db->dbprefix('mail_from_lead_cumulative')} DROP INDEX `mail_from`, DROP INDEX `mail_to`, DROP INDEX `mail_date`, DROP INDEX `status`, DROP INDEX `read_msg`;",
                "ALTER TABLE {$this->db->dbprefix('minings')} DROP INDEX `user_id`, DROP INDEX `date`;",
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