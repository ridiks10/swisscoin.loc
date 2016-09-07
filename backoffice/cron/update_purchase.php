<?php

$url = 'http://swisscoin.eu/backoffice/admin/cron/update_purchase';


get_data($url);
function get_data($url)
{
    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);

    curl_close($ch);
    return $data;
}
?>
