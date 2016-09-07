<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Packstats extends CI_Migration {

	public function up()
	{
		try {
			$this->db->query("INSERT INTO  {$this->db->dbprefix('infinite_urls')} (`id` ,`link` ,`status` ,`target`) VALUES (NULL ,  'select_report/pack_stats',  'yes',  'none');");
			$this->db->query("INSERT INTO  {$this->db->dbprefix('infinite_mlm_sub_menu')} (`sub_id` ,`sub_link_ref_id` ,`icon` ,`sub_status` ,`sub_refid` ,`perm_admin` ,`perm_dist` ,`perm_emp`, `sub_order_id`)  VALUES ('108',  '183',  'clip-file',  'yes',  '16',  '1',  '0',  '0',  '5')");

		} catch (Exception $e) {
			log_message('error', $e->getMessage());
			echo "Migration error" . PHP_EOL;
		}

	}

	public function down()
	{
		try {
			$this->db->query("DELETE FROM {$this->db->dbprefix('infinite_mlm_sub_menu')} WHERE `55_infinite_mlm_sub_menu`.`sub_id` = 108;");
			$this->db->query("DELETE FROM  {$this->db->dbprefix('infinite_urls')}  WHERE `55_infinite_urls`.`id` = 183;");

		} catch (Exception $e) {
			log_message('error', $e->getMessage());
			echo "Migration error" . PHP_EOL;
		}
	}
}