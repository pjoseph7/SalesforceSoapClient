<?php

require "class.salesforceWebService.php";

$db = new salesforceWebService();

$idStr = "('003o000000BIri1AAD', '003o000000BIri2AAD', '003o000000BIri4AAD', '003o000000BIrhxAAD', '003o000000BIriCAAT', '003o000000BIri3AAD')";


$s = $db->getUserBySfId($idStr);


echo $s;
