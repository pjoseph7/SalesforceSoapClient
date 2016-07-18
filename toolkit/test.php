<?php

require "class.salesforceWebService.php";


$webS = new salesforceWebService();

$testConnection = $webS->getConnectString();

if ($testConnection != 'Georgia Perimeter College') {

    echo "<p>Invalid Web Service Connection</p>";
    exit;
}
/***

$idArray = array(
                  '003o000000BIri1AAD',
                  '003o000000BIri2AAD',
                  '003o000000BIri4AAD',
                  '003o000000BIrhxAAD',
                  '003o000000BIriCAAT',
                  '004o000000BIri3AAD'
                };



$res = $webS->getUserById($idArray);

**/






















$id = '';
$fn='Tim';
$ln='Barr';

$res = json_decode(json_encode($webS->getUserByName($fn, $ln)), true);

echo "size: ".$res['size']."<br>";

//print_r($res);

for($i=0; $i < $res['size']; $i++) {

    echo "<br>ID: ".$res['records'][$i]['Id']."<br>";
    echo "First: ".$res['records'][$i]['FirstName']."<br>";
    echo "Last: ".$res['records'][$i]['LastName']."<br>";
    echo "DOB: ".$res['records'][$i]['Birthdate']."<br>";
    echo "Phone: ".$res['records'][$i]['Phone']."<br>";
    echo "Title: ".$res['records'][$i]['Title']."<br>";
    echo "Email: ".$res['records'][$i]['Email']."<br>";
    echo "Dept:: ".$res['records'][$i]['Department']."<br>";
     
}


exit;

$userData = array(
                  'firstName' => 'Jon',
                  'lastName' => 'Testing',
                  'phone' => '(812) 332-5000',
                  'dob' => '1953-08-13'
                 );


//echo "createUserInContact <br/>\n";
//$res = $webS->createUserInContact($userData);

$userData = array(
                  'Id' => '003o000000BIri1AAD',
                  'Phone' => '(812) 332-5000',
                  'Title' => 'King'
                 );

echo "updateUserContact <br/>\n";
$webS->updateUserContact($userData);

echo "deleteUserById <br/>\n";
//$webS->deleteUserById($id);













