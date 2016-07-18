<?php

$sfId = $_POST['sfId'];

require "class.salesforceWebService.php";

$db = new salesforceWebService();

$s = $db->editById($sfId);

echo $s;

