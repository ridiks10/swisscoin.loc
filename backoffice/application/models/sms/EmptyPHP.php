<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileUpload
 *
 * @author IOSS Abdul Majeed.P
 */
class FileUpload
{

//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
// You may change maxsize, and allowable upload file types.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
//Mmaximum file size. You may increase or decrease.
var $MAX_SIZE = 200000000000;

//Allowable file Mime Types. Add more mime types if you want
var $FILE_MIMES = array('application/msword','application/pdf');

//Allowable file ext. names. you may add more extension names.
var $FILE_EXTS = array('.doc','.docx','.pdf');

//Allow file delete? no, if only allow upload only
var $DELETABLE = false;

//vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
// Do not touch the below if you are not confident.
//^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
/************************************************************
* Setup variables
************************************************************/
var $site_name = $_SERVER['HTTP_HOST'];
var $url_dir = "https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['php_SELF']);
var $url_this = "https://".$_SERVER['HTTP_HOST'].$_SERVER['php_SELF'];

$upload_dir = "UploadDocuments/";
$upload_url = $url_dir."/UploadDocuments/";
$message ="";




public function addFilter($filtr_arr="")
{
 $this->FILE_EXTS = array('.doc','.docx','.pdf');
}
/************************************************************
* Create Upload Directory
************************************************************/
if (!is_dir("files"))
    {
if (!mkdir($upload_dir))
die ("upload_files directory doesn't exist and creation failed");
if (!chmod($upload_dir,0755))
die ("change permission to 755 failed.");
}

/************************************************************
* Process User's Request
************************************************************/
if ($_REQUEST[del] && $DELETABLE)
    {
$resource = fopen("log.txt","a");
fwrite($resource,date("Ymd h:i:s")."DELETE - $_SERVER[REMOTE_ADDR]"."$_REQUEST[del]\n");
fclose($resource);

if (strpos($_REQUEST[del],"/.")>0); //possible hacking
else if (strpos($_REQUEST[del],$upload_dir) === false); //possible hacking
else if (substr($_REQUEST[del],0,6)==$upload_dir) {
unlink($_REQUEST[del]);
print "<script>window.location.href='$url_this?message=deleted successfully'</script>";
}
}
else if ($_FILES['document']) {
$resource = fopen("log.txt","a");
fwrite($resource,date("Ymd h:i:s")."UPLOAD - $_SERVER[REMOTE_ADDR]"
.$_FILES['document']['name']." "
.$_FILES['document']['type']."\n");
fclose($resource);

$file_type = $_FILES['document']['type'];
$file_name = $_FILES['document']['name'];
$file_ext = strtolower(substr($file_name,strrpos($file_name,".")));

$_SESSION['file']=$file_name;

//File Size Check
if ( $_FILES['document']['size'] > $MAX_SIZE)
$message = "The file size is over 2MB.";
//File Type/Extension Check
else if (!in_array($file_type, $FILE_MIMES)
&&!in_array($file_ext, $FILE_EXTS) )
$message = "Sorry, $file_name($file_type) is not allowed to be uploaded.";
else
$message = do_upload($upload_dir, $upload_url);
}
else if (!$_FILES['document']);
else
$message = "Invalid File Specified.";

/************************************************************
* List Files
************************************************************/
$handle=opendir($upload_dir);
$filelist = "";
while ($file = readdir($handle)) {
if(!is_dir($file) &&!is_link($file)) {
$filelist .= "<a href='$upload_dir$file'>".$file."</a>";
if ($DELETABLE) {
$delfile = $file;
$delfile = str_replace("%","%25",$delfile);
$delfile = str_replace("&","%26",$delfile);
$delfile = str_replace("+","%2b",$delfile);
$delfile = str_replace("?","%3f",$delfile);
$filelist .= " <a href='?del=$upload_dir".$delfile."' title='delete'>x</a>";
}
$filelist .= "<sub><small><small><font color=grey> ".date("d-m H:i", filemtime($upload_dir.$file))
."</font></small></small></sub>";
$filelist .="<br>";
}
}

function doUpload($upload_dir, $upload_url)
{
$temp_name = $_FILES['document']['tmp_name'];
$file_name = $_FILES['document']['name'];
$file_name = str_replace("\\","",$file_name);
$file_name = str_replace("'","",$file_name);
$file_path = "UploadDocuments/"."majeed.doc";
//echo "############$upload_dir#############".$file_path ;
//File Name Check
if ( $file_name =="") {
$message = "Invalid File Name Specified";
return $message;
}

$result = move_uploaded_file($temp_name, $file_path);
if (!chmod($file_path,0777))
$message = "change permission to 777 failed.";
else
$message = ($result)?"$file_name uploaded successfully." :
"Somthing is wrong with uploading a file.";
//echo $_FILES['document']['name'];
return $message;
}

}
?>
