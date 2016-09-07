<?php

class backup_restore_model extends inf_model {

    function __construct() {
	parent::__construct();
    }

    public function restore($plan) {
	$this->load->model('cleanup_model');
	$res = $this->cleanup_model->clean($plan);
	return $res;
    }

    public function backup() {
	$this->load->model('backup_model');
	$this->backup_model->generateBackup();
	return true;
    }

    public function backup_tables() {

	$output = '';

	$table_prefix = $this->db->dbprefix;
	$database_name = $this->db->database;

	$query = $this->db->query("SHOW TABLES LIKE '$table_prefix%'");

	foreach ($query->result_array() AS $row) {

	    $table = $row['Tables_in_'.$database_name.' (' . $table_prefix . '%)'];

	    if ($table_prefix) {
		if (strpos($table, $table_prefix) === false) {
		    $status = false;
		} else {
		    $status = true;
		}
	    } else {
		$status = true;
	    }

	    if ($status) {
		$output .= 'TRUNCATE TABLE `' . $table . '`;' . "\n\n";

		$query = $this->db->query("SELECT * FROM `" . $table . "`");

		foreach ($query->result_array() as $result) {
		    $fields = '';

		    foreach (array_keys($result) as $value) {
			$fields .= '`' . $value . '`, ';
		    }

		    $values = '';

		    foreach (array_values($result) as $value) {
			$value = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $value);
			$value = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $value);
			$value = str_replace('\\', '\\\\', $value);
			$value = str_replace('\'', '\\\'', $value);
			$value = str_replace('\\\n', '\n', $value);
			$value = str_replace('\\\r', '\r', $value);
			$value = str_replace('\\\t', '\t', $value);

			$values .= '\'' . $value . '\', ';
		    }

		    $output .= 'INSERT INTO `' . $table . '` (' . preg_replace('/, $/', '', $fields) . ') VALUES (' . preg_replace('/, $/', '', $values) . ');' . "\n";
		}

		$output .= "\n\n";
	    }
	}

	header("Pragma: public", true);
	header("Expires: 0", true);
	header("Content-Description: File Transfer", true);
	header("Content-Type: application/octet-stream", true);
	header("Content-Disposition: attachment; filename=" . date('Y-m-d_H-i-s', time()) . "_backup.sql", true);
	header("Content-Transfer-Encoding: binary", true);

	echo $output;
    }

    public function restore_from_file($sql) {
	ini_set('max_execution_time', 50000);
	foreach (explode(";\n", $sql) as $sql) {
	    $sql = trim($sql);
	    if ($sql) {
		$this->db->query("$sql");
	    }
	}
	return TRUE;
    }

}
