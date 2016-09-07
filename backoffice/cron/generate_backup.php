<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://swisscoin.eu/backoffice/admin/cron/generate_backup');
$store = curl_exec($ch);
curl_close($ch);
?>