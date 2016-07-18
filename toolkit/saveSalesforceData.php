<?php

$sfId = $_POST['sfId'];
$fn = $_POST['fn'];
$ln = $_POST['ln'];
$title = $_POST['title'];
$phone = $_POST['phone'];
$email = $_POST['email'];

$data = array(
              'Id' => $sfId,
              'FirstName' => $fn,
              'LastName' => $ln,
              'Title' => $title,
              'Phone' => $phone,
              'Email' => $email
        );


require "class.salesforceWebService.php";

$db = new salesforceWebService();

$s = $db->saveById($data);

echo $s;

