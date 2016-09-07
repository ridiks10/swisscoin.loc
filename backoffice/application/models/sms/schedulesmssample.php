<?php

/* 
You need the nusoap library bundled here, please extract it to lib/ 

Set $username, $senderid, $password, $message, $numbers, $starttime etc. to the 
correct values.
*/

require_once('lib/nusoap.php');

$username = "<username>";
$password = "<password>";
$senderid = "IOSS";//this will be for gsm numbers, you can set the cdma sender id in the website. GSM sender id should be max 11 chars
$message = "Scheduling message test";
$numbers = "9846722822";//commma seperated 10 digit mobile numbers
/* TIME 
FORMAT YYYY-MM-DD hh:mm:ss and time GMT ie IST - 05:30 hours 
for example if you want to schedule sms for Jan 1 2009 08:00:00PM you should enter start time as 2009-01-01 14:30:00
*/
$starttime = "2009-01-01 14:30:00"; 
$endtime = ""; //Leave blank
//API URL
$api_path = "https://api.fastalerts.in/webservice/falertservicerevised.php?wsdl";
$client = new soapclient1($api_path, true);
$param = array('username'=>$username, 'senderid'=>$senderid, 'password'=>$password, 'message'=>$message, 'number'=>$numbers);
$parameters = array('username' => $username, 'senderid' => $senderid, 'password' => $password, 'message' => $message, 'numbers' => $numbers,'starttime' => $starttime, 'endtime' => $endtime);$client->call('ScheduleSms', $parameters, '', '', false, true);



?>

		
