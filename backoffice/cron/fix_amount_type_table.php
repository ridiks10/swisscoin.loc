<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://infinitemlm.com/mlm-demo/beta/backoffice/admin/fix_issues/fix_amount_type_table');
$store = curl_exec($ch);
curl_close($ch);
?>