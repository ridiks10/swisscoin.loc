<?php
$ch = curl_init('http://swisscoin.eu/backoffice/admin/cron/rank_bonus');
$store = curl_exec($ch);
curl_close($ch);
