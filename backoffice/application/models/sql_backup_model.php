<?php

/**
 *  This is a developer class for easy backup making/schedule of their mysql database.
 *  
 * @category   ToolsAndUtilities
 * @package    EasyPHPBackup
 * @author     Melillo Gabriel <ilpcportal@altervista.org>
 * @license    https://www.opensource.org/licenses/lgpl-license.php LGPL
 */
/**
 * Define variable needed for schedule recurrence
 */
define("_Monthly_", 12);
define("_Weekly_", 48);
define("_Daily_", 365);
define("_Annual_", 1);

/**
 * Define variable needed for making backup array
 */
define("SCHEDULE", "bck_schedule");
define("TYPE", "bck_type");
define("DIR", "bck_dir");
define("NAME", "bck_name");

/**
 * Define variable needed for schedule type
 */
define("_Table_", "t");
define("_Data_", "d");
define("_ALL_", "td");

/**
 * Version of this Class
 */
define("_Version_", "1.0.7");

/**
 * Include library for message error language
 */


//include ( "language.php" );

class sql_backup_model extends inf_model {

    // Global variables
    var $db_name;
    var $dir;
    var $filename;
    var $error;

    /**
     * Main function used for making backup schedule. for run this function you need to create a nominal vector following a example code in example_schedule.php downloaded with this class and used database name.
     */
    function schedule($backup, $db) {
        global $BckErrorMessage;

        // Check if $backup is array, if it isn't set error message and return false
        if (!is_array($backup)) {
            $this->error .= $BckErrorMessage['Schedule'];
            return false;
        }

        // Check if $db is null, if it is set error and return false
        if ($db == "") {
            $this->error .= $BckErrorMessage['DBNameNull'];
            return false;
        }

        // Retruve from $backup all data needed for make and shedule a backup
        $schedule = $backup[SCHEDULE];
        $type = $backup[TYPE];
        $dir = $backup[DIR];
        $name = $backup[NAME];

        // check if $schedule, $type, $dir or $name is null or empty,
        // if one is null or empty set error message and return false.
        if ($schedule == "" || $type == "" || $dir == "" || $name == "") {
            $this->error .= $BckErrorMessage['WrongParameters'];
            return false;
        }

        // if $dir isn't a directory set error message and return false
        if (!is_dir($dir)) {
            $this->error .= $BckErrorMessage['NoDir'];
            return false;
        }

        // Check if $type is correctly setted and if it isn't set error message and return false
        if ($type != _Table_ && $type != _Data_ && $type != _ALL_) {
            $this->error .= $BckErrorMessage['BckType'];
            return false;
        }

        // Check if $schedule is correctly setted and if it isn't set error message and return false
        if ($schedule != _Monthly_ && $schedule != _Weekly_ && $schedule != _Daily_ && $schedule != _Annual_) {
            $this->error .= $BckErrorMessage['ScheduleType'];
            return false;
        }

        // if $name is null or empty set default name
        if ($name == "")
            $name = "default";

        // Making a backup file path
        $backup_file = $dir . $name . ".sql";
        $start = false;

        // if backup name exists make a new name for previous backup and rename it
        if (!file_exists($backup_file))
            $start = true;
        else {
            // Get in $last_time_modified array the date of file creation
            $last_time_modified = explode("/", date("j/m/y", filemtime($backup_file)));
            // Set in $today array the current date.
            $today = explode("/", date("j/m/y"));

            // Check if is time to make backup using $schedule and time variables ( $last_time_modified and $today ).
            if ($schedule == _Monthly_ && $last_time_modified[1] < $today[1])
                $start = true;
            else if ($schedule == _Weekly_ && $today[0] > ( $last_time_modified[0] + 6 ))
                $start = true;
            else if ($schedule == _Daily_ && $today[0] > $last_time_modified[0])
                $start = true;
            else if ($schedule == _Annual_ && $today[2] > $last_time_modified[2])
                $start = true;
        }

        // if start is true is time to make backup
        if ($start == true) {
            // if backup file exists rename it
            if (file_exists($backup_file))
                rename($backup_file, $this->createFilename($name, $dir, 0));

            $this->db_name = $db;

            // Exec backup and return all data in $bck.
            $bck = $this->getSqlBck($type);

            // Open file in write mode and store backup,
            $file = gzopen($backup_file, "w9");
            gzwrite($file, $bck);
            gzclose($file);
        }

        return true;
    }

    /**
     * Make backup filename.
     */
    function createFilename($filename, $dir, $i = 0) {
        $name = $dir . $filename . "($i)" . "_old.sql";
        if (file_exists($name))
            return $this->createFilename($filename, $dir, ($i + 1));
        else
            return $name;
    }

    /**
     * Make database backup and return total sql command for remake database. before run this function you need to exec setDB function. On error occurred return false.
     */
    function getSqlBck($type = _ALL_) {
        global $BckErrorMessage;

        // Check if $type is correctly setted
        if ($type != _Table_ && $type != _Data_ && $type != _ALL_) {
            $this->error .= $BckErrorMessage['BckType'];
            return false;
        }

        // Make backup header
        $file_dump = "# SQL Dump\n# version " . _Version_ . "\n# " . $this->getPageUrl() . "\n#\n# Host: `localhost`\n# Generato il: " . date("d-M-Y") . "\n#\n# Database: `" . $this->db_name . "`\n\n\n";

        // find all table name in database with name $this->db_name
        //$risultato = mysql_list_tables($this->db_name);//unc


        $qr = "SHOW TABLES FROM $this->db_name";//added 
        $risultato = $this->db->query($qr);//added 

        // If database server occured return false and save error on $this->error
        if (!$risultato) {
            $this->error .= mysql_error();
            return false;
        }

        // With while cycle, $this->datadump and $this->tabledump function make a backup of database
        // and put in $file_dump SQL code needed for backup
        /*while ($riga = mysql_fetch_row($risultato)) {
            if ($type == _ALL_ || $type == _Table_)
                $file_dump .= $this->tabledump($riga[0]);
            if ($type == _ALL_ || $type == _Data_)
                $file_dump .= $this->datadump($riga[0]);
        }/unc*/
        
        foreach ($risultato->result_array() as $riga) {
            $riga = array_values($riga);
            if ($type == _ALL_ || $type == _Table_)
                $file_dump .= $this->tabledump($riga[0]);
            if ($type == _ALL_ || $type == _Data_)
                $file_dump .= $this->datadump($riga[0]);
        }//added fn

        // Free $risultato variable
        //mysql_free_result($risultato);//unc
        $risultato->free_result();//added 

        // Return generated SQL code
        return $file_dump;
    }

    /**
     * Return error message if exist or false if the class have not generate error.
     */
    function getError() {
        // if $this->error isn't empty return it else return false
        if ($this->error != "")
            return $this->error;
        else
            return false;
    }

    /**
     * Set $this->dbname wit Database name set in $db.
     */
    function setDB($db) {
        global $BckErrorMessage;

        // Check if $db isn't null, if $d isn't null 
        // set $this->db_name with $db value else
        // set error message and return false
        if ($db != "") {
            $this->db_name = $db;
            return true;
        } else {
            $this->error .= $BckErrorMessage['WrongDBName'];
            return false;
        }
    }

    /**
     * set directory name in $this->dir.
     */
    function setDir($d) {
        global $BckErrorMessage;

        // Check if $d isn't null, if $d isn't null go next
        // else set error message and return false
        if ($d != "") {
            // Check if $d if existing folder,
            //if it is set $this->dir with $d else
            // making error and return false.
            if (is_dir($d)) {
                $this->dir = $d;
                return true;
            } else {
                $this->error .= $BckErrorMessage['NoDirSet'];
                return false;
            }
        } else {
            $this->error .= $BckErrorMessage['NotNullValue'];
            return false;
        }
    }

    /**
     * set name of file where you want make backup ($file) in $this->filename
     */
    function setFile($file) {
        global $BckErrorMessage;

        // Check if file name isn't null, if $file isn't null go next
        // else set error message and return false
        if (isset($file)) {
            // Check if filename isn't already in selected folder,
            // if file exists set error and return false else
            // set in $this->filename $file value
            if (!file_exists($this->dir . $file)) {
                $this->filename = $file;
                return true;
            } else {
                $this->error .= $BckErrorMessage['FileExists'];
                return false;
            }
        } else {
            $this->error .= $BckErrorMessage['FileNotNull'];
            return false;
        }
    }

    /**
     * Make backup of database and save him in $this->dir with name $this->filename. if before you don't exec function setDir, setFile and setDB the function return false and save error.
     */
    function make($type = _ALL_) {
        global $BckErrorMessage;

        // Check if $type is correctly setted
        if ($type != _Table_ && $type != _Data_ && $type != _ALL_) {
            $this->error .= $BckErrorMessage['BckType'];
            return false;
        }

        // Check variables $this->db_name, $this->dir and $this->filename
        // if there isn't set return error
        if ($this->db_name != "" && $this->dir != "" && $this->filename != "") {
            // Exec getSqlBck() function for making backup
            // end insert return value in $file_dump
            $file_dump = $this->getSqlBck($type);

            // Open backup file in write mode
            $file = gzopen($this->dir . $this->filename, "w9");
            // Write sql backup
            gzwrite($file, $file_dump);
            // Close file
            gzclose($file);

            return true;
        } else {
            $this->error .= $BckErrorMessage['StartMakeErr'];
            return false;
        }
    }

    /**
     * Return SQL istruction for making $table
     */
    function tabledump($table) {
        // make $result variable with header
        $result = "# Dump of `$table`\n# Dump DATE : " . date("d-M-Y") . "\n\n";

        // Exec query to make table detail
        $sql = "SHOW CREATE TABLE `$table`";
        $ris = mysql_query($sql);

        // If database server occured return false and save error on $this->error
        if (!$ris) {
            $this->error .= mysql_error();
            return false;
        }

        // Get table structure
        $row = mysql_fetch_assoc($ris);
        // Fill $result variable
        $result .= $row['Create Table'] . ";\n\n\n";

        // Return completed SQL
        return $result;
    }

    /**
     * Return needed SQL for fill $table
     */
    function datadump($table) {
        // make $result variable with header
        $result = "# Dump data of `$table` \n\n";

        // Select total row in database table
        $sql = "SELECT * FROM `$table`";
        $query = mysql_query($sql);

        // If database server occured return false and save error on $this->error
        if (!$query) {
            $this->error .= mysql_error();
            return false;
        }

        // Select total collum in database table
        $num_fields = @mysql_num_fields($query);

        // Select total row in database table
        $numrow = mysql_num_rows($query);

        // Cycle all row of table
        for ($i = 0; $i < $numrow; $i++) {
            // Return all collum of row in $row
            $row = mysql_fetch_row($query);

            // Fill $result wit default query used for insert data in mysql table
            $result .= "INSERT INTO `$table` VALUES(";

            // Fill $result with data for all collum
            for ($j = 0; $j < $num_fields; $j++) {
                $row[$j] = addslashes($row[$j]);
                //$row[$j] = ereg_replace("\n", "\\n", $row[$j]);//unc
                $row[$j] = preg_replace("#\n#", "\\n", $row[$j]);//added

                if (isset($row[$j]))
                    $result .= "\"$row[$j]\"";
                else
                    $result .= "\"\"";

                if ($j < ( $num_fields - 1 ))
                    $result .= ",";
            }

            // Close INSERT istruction
            $result .= ");\n";
        }

        return $result . "\n";
    }

    /**
     * 	Returns the address of the server
     */
    function getPageUrl() {
        // Start to make variable $url with http
        $url = 'http';

        // Check if the page is in https secure connection and if true insert on $url 's' character.
        if (isset($_SERVER ['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $url .= 's';

        // Inserto on $url '://'
        $url .= '://';

        // Check if the webserver use a standard port (80)
        // if webserver don't use default port i add correct port on URL string  
        if ($_SERVER['SERVER_PORT'] != '80')
            $url .= $_SERVER['HTTP_HOST'] . ':' . $_SERVER['SERVER_PORT'];
        else
            $url .= $_SERVER['HTTP_HOST'];

        // return Correct URL of page
        return $url;
    }

}