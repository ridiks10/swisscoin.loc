<?php defined("BASEPATH") or exit("No direct script access allowed");

/**
 * @property  CI_Migration $migration
 * @property  CI_Input $input
 */
class Migrate extends CI_Controller
{

    public function __construct()
    {
        error_reporting(0);

        parent::__construct();

        $this->input->is_cli_request() or exit("Execute via command line: <br/>php index.php up <br/>php index.php to < version >");

        $this->load->library('migration');
    }


    public function up()
    {
        $result = $this->migration->latest();
        $this->_discribe_result($result);
    }

    public function to($version)
    {
        if (is_null($version)) {
            echo 'Need to define version' . PHP_EOL;
        } else {
            $result = $this->migration->version($version);
            $this->_discribe_result($result, true);
        }
    }

    protected function _discribe_result($result, $orRollbacked = false)
    {
        if ($result === true) {
            echo 'All migration already applied' . PHP_EOL;
        } elseif ($result === false) {
            echo $this->migration->error_string() . PHP_EOL;
        } else {
            $rollbacked = $orRollbacked ? '/rollbacked' : '';
            echo "Migrations applied$rollbacked. Current version is $result" . PHP_EOL;
        }
    }

    public function help(){
        echo 'Usage: ' . PHP_EOL;
        echo 'php index.php migrate up '. "\t\t" .'Apply all migration' . PHP_EOL;
        echo 'php index.php migrate to <version> '. "\t" .'Apply or rollback to specified migration' . PHP_EOL;
        echo 'php index.php migrate help '. "\t\t" .'Show what you see now :)' . PHP_EOL;
    }
}