<?php

require "class.oracleBanner.php";

$db = new oracleBanner();

$s = $db->getBannerData();

echo $s;

$db->logoff();
