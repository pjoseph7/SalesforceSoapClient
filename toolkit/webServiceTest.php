<?php



define("USERNAME", "strainje@gmail.com");
define("PASSWORD", "");
define("SECURITY_TOKEN", "F3QXQMNUWIHnukF5PDcEyJea");
 
require_once ('forcePHP/soapclient/SforceEnterpriseClient.php');
 
$mySforceConnection = new SforceEnterpriseClient();
$mySforceConnection->createConnection("forcePHP/soapclient/enterprise.wsdl.xml");
$res = $mySforceConnection->login(USERNAME, PASSWORD.SECURITY_TOKEN);

ini_set('display_errors','off');




$dataArray = objectToArray($res);
echo "<pre>".print_r($dataArray)."</pre>";

echo "ORG: ".$dataArray['userInfo']['organizationName']."<br>";


$query = "SELECT Id, FirstName, LastName, Phone from Contact where firstName = 'Rowdy'";
$response = $mySforceConnection->query($query);

echo "Results of query '$query'<br/><br/>\n";
foreach ($response->records as $record) {
    echo $record->Id . ": " . $record->FirstName . " "
        . $record->LastName . " " . $record->Phone . "<br/>\n";
}


if (0) { //create

   $records = array();

   $records[0] = new stdclass();
   $records[0]->FirstName = 'John';
   $records[0]->LastName = 'Smith';
   $reords[0]->Phone = '(678) 555-5555';
   $records[0]->BirthDate = '1957-01-25';

   $records[1] = new stdclass();
   $records[1]->FirstName = 'Mary';
   $records[1]->LastName = 'Jones';
   $records[1]->Phone = '(510) 486-9969';
   $records[1]->BirthDate = '1977-01-25';

   $response = $mySforceConnection->create($records, 'Contact');

   $ids = array();
   foreach ($response as $i => $result) {
       echo $records[$i]->FirstName . " " . $records[$i]->LastName . " "
          . $records[$i]->Phone . " created with id " . $result->id
          . "<br/>\n";
       array_push($ids, $result->id);
   }
 

}


if (0) {  //update Mary Jones

   $records[0] = new stdclass(); 
   $records[0]->Id = '003o000000BaJOJAA3';
   $records[0]->Phone = '(812) 332-5212';

   $response = $mySforceConnection->update($records, 'Contact');

   foreach ($response as $result) {
      echo $result->id . " updated<br/>\n";
   }



}









function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }
  
        if (is_array($d)) {
            /*
            * Return array converted to object
            * Using __FUNCTION__ (Magic constant)
            * for recursive call
            */
            return array_map(__FUNCTION__, $d);
        }
        else {
            // Return array
            return $d;
        }
    }
