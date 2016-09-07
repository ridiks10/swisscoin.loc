<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dboptimizep2 extends CI_Migration {

    protected function name() {
        return "DB optimize step 2";
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
                "ALTER TABLE {$this->db->dbprefix('mining_request')} ADD INDEX (`req_user_id`), ADD INDEX (`status`);",
                "ALTER TABLE {$this->db->dbprefix('news_viewed')} ADD INDEX (`user_id`, `news_id`);",
                "ALTER TABLE {$this->db->dbprefix('orders')} ADD INDEX (`user_id`);",
                "ALTER TABLE {$this->db->dbprefix('order_history')} ADD INDEX (`order_id`), ADD INDEX (`user_id`), ADD INDEX (`package`), ADD INDEX (`date`), ADD INDEX (`status`), ADD INDEX (`assigned_split`), ADD INDEX (`tax_id`);",
                "ALTER TABLE {$this->db->dbprefix('package')} CHANGE `num_of_tokens` `num_of_tokens` varchar(30) NOT NULL, CHANGE `mining_status` `mining_status` varchar(10) NOT NULL DEFAULT 'NO', ADD INDEX (`product_name`), ADD INDEX (`active`), ADD INDEX (`splits`), ADD INDEX (`mining_status`);",
                "ALTER TABLE {$this->db->dbprefix('payout_release_requests')} ADD INDEX (`requested_amount`), ADD INDEX (`requested_date`), ADD INDEX (`status`);",
                "ALTER TABLE {$this->db->dbprefix('product')} ADD INDEX (`active`);",
                "ALTER TABLE {$this->db->dbprefix('team_bonuses')} ADD INDEX (`user_id_source`), ADD INDEX (`user_id_recipient`), ADD INDEX (`order_id`);",
                "ALTER TABLE {$this->db->dbprefix('tickets')} ADD INDEX (`user_id`), ADD INDEX (`assignee_id`), ADD INDEX (`priority`), ADD INDEX (`dt`);",
                "ALTER TABLE {$this->db->dbprefix('ticket_activity')} ADD INDEX (`ticket_id`);",
                "ALTER TABLE {$this->db->dbprefix('ticket_replies')} ADD INDEX (`user_id`);",
                "ALTER TABLE {$this->db->dbprefix('video')} ADD INDEX (`on_dashboard`);"
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
                "ALTER TABLE {$this->db->dbprefix('mining_request')} DROP INDEX `req_user_id`, DROP INDEX `status`;",
                "ALTER TABLE {$this->db->dbprefix('news_viewed')} DROP INDEX `user_id`;",
                "ALTER TABLE {$this->db->dbprefix('orders')} DROP INDEX `user_id`;",
                "ALTER TABLE {$this->db->dbprefix('order_history')} DROP INDEX `order_id`, DROP INDEX `user_id`, DROP INDEX `package`, DROP INDEX `date`, DROP INDEX `status`, DROP INDEX `assigned_split`, DROP INDEX `tax_id`;",
                "ALTER TABLE {$this->db->dbprefix('package')} CHANGE `num_of_tokens` `num_of_tokens` varchar(100) NOT NULL, CHANGE `mining_status` `mining_status` varchar(100) NOT NULL DEFAULT 'NO', DROP INDEX `product_name`, DROP INDEX `active`, DROP INDEX `splits`, DROP INDEX `mining_status`;",
                "ALTER TABLE {$this->db->dbprefix('payout_release_requests')} DROP INDEX `requested_amount`, DROP INDEX `requested_date`, DROP INDEX `status`;",
                "ALTER TABLE {$this->db->dbprefix('product')} DROP INDEX `active`;",
                "ALTER TABLE {$this->db->dbprefix('team_bonuses')} DROP INDEX `user_id_source`, DROP INDEX `user_id_recipient`, DROP INDEX `order_id`;",
                "ALTER TABLE {$this->db->dbprefix('tickets')} DROP INDEX `user_id`, DROP INDEX `assignee_id`, DROP INDEX `priority`, DROP INDEX `dt`;",
                "ALTER TABLE {$this->db->dbprefix('ticket_activity')} DROP INDEX `ticket_id`;",
                "ALTER TABLE {$this->db->dbprefix('ticket_replies')} DROP INDEX `user_id`;",
                "ALTER TABLE {$this->db->dbprefix('video')} DROP INDEX `on_dashboard`;",
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