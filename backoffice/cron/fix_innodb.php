<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/WC/Revamp_Responsive/backoffice/admin/fix_issues/fix_MLM_table_engine_type');
$store = curl_exec($ch);
curl_close($ch);
?>