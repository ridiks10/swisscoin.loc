<?php
require_once 'Inf_Controller.php';
class Backup extends Inf_Controller 
{
	function generate_backup()
	{   
		$this->load->model('backup_model', '', TRUE);
	    $this->backup_model->generateBackup();
	}
}
?>