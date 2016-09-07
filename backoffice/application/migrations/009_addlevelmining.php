<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Addlevelmining extends CI_Migration {

	public function up()
	{
		try {
			$this->db->query("ALTER TABLE  {$this->db->dbprefix('mining_request')} ADD  `level` INT( 11 ) UNSIGNED NOT NULL DEFAULT '1';");
		} catch (Exception $e) {
			log_message('error', $e->getMessage());
			echo "Migration error" . PHP_EOL;
		}

	}

	public function down()
	{
		try {
			$this->db->query("ALTER TABLE {$this->db->dbprefix('mining_request')} DROP `level`;");
		} catch (Exception $e) {
			log_message('error', $e->getMessage());
			echo "Migration error" . PHP_EOL;
		}
	}
}

