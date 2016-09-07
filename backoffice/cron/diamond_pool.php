<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://server1.swisscoin.eu/~swisscoin/backoffice/admin/cron/diamond_pool');
$store = curl_exec($ch);
curl_close($ch);
?>
