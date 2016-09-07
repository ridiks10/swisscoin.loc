<?php
header("Content-type: text/css");

 for($i=1;$i<=count($user_detail);$i++)

	 {

echo '#user'.$user_detail["detail$i"]["id"].'{display:none;}';

 echo "\n";

     }

?>