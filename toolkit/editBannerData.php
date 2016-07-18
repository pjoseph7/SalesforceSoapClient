<?php

$sfId = $_POST['sfId'];

require "class.oracleBanner.php";

$db = new oracleBanner();

$s = $db->editById($sfId);

echo $s;

$db->logoff();
