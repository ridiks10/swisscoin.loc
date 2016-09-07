<?php

class backup_model extends inf_model
{

    public $BACKUP_PATH;
    public $DATABSE_NAME;

    public function __construct()
    {
        parent::__construct();
        $this->BACKUP_PATH = "db_backup/";
        $this->DATABSE_NAME = DB_NAME;
    }

    public function generateBackup()
    {
        ini_set("memory_limit", "10000M");
        ini_set("max_execution_time", "20000");

        include_once("sql_backup_model.php");
        $backup = new sql_backup_model();
        $datetime = date("Y-m-d") . "-" . date("H") . "-" . date("i") . "-" . date("s");


        $database_name = $this->db->database;

        if (!$backup->setDB($database_name))
            die("Errore : " . $backup->getError());
        if (!$backup->setDir("db_backup/dump/"))
            die("Errore : " . $backup->getError());
        if (!$backup->setFile($datetime . ".gz"))
            die("Errore : " . $backup->getError());
        if (!$backup->make())
            die("Errore : " . $backup->getError());
        $file_name = $datetime . ".gz";
        print "Backup done---------------------------------------->";


        $path = "db_backup/dump/";


// Define the folder to clean
// (keep trailing slashes)
        $captchaFolder = $path;

// Filetypes to check (you can also use *.*)
        $fileTypes = '*.gz';

// Here you can define after how many
// minutes the files should get deleted
        $expire_time = 10080;

// Find all files of the given file type
        foreach (glob($captchaFolder . $fileTypes) as $Filename) {

            // Read file creation time
            $FileCreationTime = filectime($Filename);

            // Calculate file age in seconds
            $FileAge = time() - $FileCreationTime;

            // Is the file older than the given time span?
            if ($FileAge > ($expire_time * 60)) {

                // Now do something with the olders files...

                print "The file $Filename is older than $expire_time minutes\n";

                // For example deleting files:
                unlink($Filename);
            }
        }

        print "Deletion done---------------------------------------->";

        $this->sendMail($file_name);
    }

    public function generateBackup_old()
    {
        //$this->backup();


        $datetime = date("Y-m-d H:i:s");
// number of backups to keep
        $backups = 5;

// hours between backups
        $interval = 12;

// 1 only with ZLib support, else change value to 0
        $compression = 0;

// full path to phpMyBackup
//$path="/home/pages/htdocs/phpmybackup/";
        echo "backuop=" . $path = $this->BACKUP_PATH;


// DO NOT CHANGE THE LINES BELOW

        $version = "0.4 beta";
        flush();

        $dbname = $this->DATABSE_NAME;

        $path = $path . "dump/";

        if (!is_dir($path))
            mkdir($path, 0777);


        if ($compression == 1)
            $filetype = "sql.gz";
        else
            $filetype = "sql";
//echo '?????'.$filetype."<br>";

        $oldname = $i - 1 . ".$filetype";
        $newname = $i . $datetime . ".$filetype";


        $cur_time = $datetime;
        $newfile = "# Dump created with 'phpMyBackup v.$version' on $cur_time\r\n";
        $tables1 = mysql_list_tables($dbname);
        $num_tables = mysql_num_rows($tables1);
        echo '######<br>';
        $i = 0;
        while ($row = mysql_fetch_array($tables1)) {
            $tables[$i] = $row;
            $num_tables = count($tables);

            $i = 0;
            while ($i < $num_tables) {
                $table = mysql_tablename($tables, $i);
                echo "<br/>table=" . $table = $tables[$i]["Tables_in_$dbname"];
                $newfile .= "\n# ----------------------------------------------------------\n#\n";
                $newfile .= "# structur for table '$table'\n#\n";
                $newfile .= $this->getDef($dbname, $table);
                $newfile .= "\n\n";
                $newfile .= "#\n# data for table '$table'\n#\n";
                $newfile .= $this->getContent($dbname, $table);
                $newfile .= "\n\n";
                $i++;
            }
        }
        $file_name_sql = "back" . date("Y-m-d") . ".$filetype";
        if ($compression == 1) {

            $fp = gzopen($path . $file_name_sql, "w9");
            gzwrite($fp, $newfile);
            gzclose($fp);
        } else {
            $fp = fopen("db_backup/dump/" . $file_name_sql, "w+");
            fwrite($fp, $newfile);
            fclose($fp);
        }

        $this->deleteOldBackupFiles();

        $attachment = $file_name_sql;
        $this->sendMail($attachment);
    }

//Mail Sending
    function sendMail($file_name_sql)
    {
        require_once 'Phpmailer.php';
        $mailObj = new Phpmailer();

        $datetime = date("Y-m-d H:i:s");
        $firstname = "IOSS-VETO";
        $email = "info@ioss.in";
        $FILE_NAME = $file_name_sql;
        $mailBodyDetails = "Please find the attachment containing Infinite MLM Software database backup.
<br/><br/> File name : $file_name_sql <br/>
<br/>To Download File click here http://swisscoin.eu/backoffice/db_backup/dump/$file_name_sql <br/><br/>
                           Keep this file safe in order to restore the database if required.
                           Regards,<br /><b>Team IOSS - VETO</b><br />https://www.ioss.in";


        $mailObj->From = $email;
        $mailObj->FromName = $firstname;
        $mailObj->Subject = "CRM Backup - " . $datetime;
        $mailObj->IsHTML(true);
        $mailObj->Body = $mailBodyDetails;
        $mailObj->ClearAddresses();
        $mailObj->AddAddress('ioss.spartans@gmail.com'); //PASSWORD:Login@IOSS.Spartans

        //if($FILE_NAME !="")
        //$mailObj->AddAttachment($FILE_NAME);


        if (!$mailObj->send()) {
            echo "Mailer Error: " . $mailObj->ErrorInfo;
        } else {
            echo "Message sent!";
            $cmd = "rm $FILE_NAME";
            exec($cmd);
        }
        //echo $FILE_NAME;
    }

    public function deleteOldBackupFiles()
    {
        $path = $this->BACKUP_PATH . "dump/";;

// Define the folder to clean
// (keep trailing slashes)
        $captchaFolder = $path;

// Filetypes to check (you can also use *.*)
        $fileTypes = '*.gz';

// Here you can define after how many
// minutes the files should get deleted
        $expire_time = 10080;

// Find all files of the given file type
        foreach (glob($captchaFolder . $fileTypes) as $Filename) {

            // Read file creation time
            $FileCreationTime = filectime($Filename);

            // Calculate file age in seconds
            $FileAge = time() - $FileCreationTime;

            // Is the file older than the given time span?
            if ($FileAge > ($expire_time * 60)) {

                // Now do something with the olders files...

                print "The file $Filename is older than $expire_time minutes\n";

                // For example deleting files:
                unlink($Filename);
            }
        }
    }

    public function getDef($dbname, $table)
    {
        // global $conn;
        $def = "";
        $def .= "DROP TABLE IF EXISTS $table;#%%\n";
        $def .= "CREATE TABLE $table (\n";
        $result = mysql_db_query($dbname, "SHOW FIELDS FROM $table");
        while ($row = mysql_fetch_array($result)) {
            $def .= "    $row[Field] $row[Type]";
            if ($row["Default"] != "")
                $def .= " DEFAULT '$row[Default]'";
            if ($row["Null"] != "YES")
                $def .= " NOT NULL";
            if ($row[Extra] != "")
                $def .= " $row[Extra]";
            $def .= ",\n";
        }
        $def = ereg_replace(",\n$", "", $def);
        $result = mysql_db_query($dbname, "SHOW KEYS FROM $table");
        while ($row = mysql_fetch_array($result)) {
            $kname = $row[Key_name];
            if (($kname != "PRIMARY") && ($row[Non_unique] == 0))
                $kname = "UNIQUE|$kname";
            if (!isset($index[$kname]))
                $index[$kname] = array();
            $index[$kname][] = $row[Column_name];
        }
        while (list($x, $columns) = @each($index)) {
            $def .= ",\n";
            if ($x == "PRIMARY")
                $def .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
            else if (substr($x, 0, 6) == "UNIQUE")
                $def .= "   UNIQUE " . substr($x, 7) . " (" . implode($columns, ", ") . ")";
            else
                $def .= "   KEY $x (" . implode($columns, ", ") . ")";
        }

        $def .= "\n);#%%";
        return (stripslashes($def));
    }

    public function getContent($dbname, $table)
    {
        //global $conn;
        $content = "";
        $result = mysql_db_query($dbname, "SELECT * FROM $table");
        while ($row = mysql_fetch_row($result)) {
            $insert = "INSERT INTO $table VALUES (";
            for ($j = 0; $j < mysql_num_fields($result); $j++) {
                if (!isset($row[$j]))
                    $insert .= "NULL,";
                else if ($row[$j] != "")
                    $insert .= "'" . addslashes($row[$j]) . "',";
                else
                    $insert .= "'',";
            }
            $insert = ereg_replace(",$", "", $insert);
            $insert .= ");#%%\n";
            $content .= $insert;
        }
        return $content;
    }

}
