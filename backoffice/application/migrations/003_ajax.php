<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Ajax extends CI_Migration {

    public function up()
    {
        try {
            $this->db->query("ALTER TABLE {$this->db->dbprefix('activity_history')} ADD INDEX (`done_by`), ADD INDEX (`done_by_type`), ADD INDEX (`date`), ADD INDEX (`notification_status`);");
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            echo "Migration error" . PHP_EOL;
        }

    }

    public function down()
    {
        try {
            $this->db->query("ALTER TABLE {$this->db->dbprefix('activity_history')} DROP INDEX `done_by`, DROP INDEX `done_by_type`, DROP INDEX `date`, DROP INDEX `notification_status`;");
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            echo "Migration error" . PHP_EOL;
        }
    }
}