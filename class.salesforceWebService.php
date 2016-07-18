<?php

class SalesforceWebService {

   private  $webSr;
   private  $connectString;


   function salesforceWebService() {

      require "/usr/local/secure/globals/salesforce/webServiceVars.php";    

      require "/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/SforceEnterpriseClient.php";

mail('jstrain@gpc.edu, aredfoot@gpc.edu', 'XXXX',  $userName." __ ".$password.$securityToken);

exit;

      try {

      $this->webSr = new SforceEnterpriseClient();
      //$this->webSr->createConnection("/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/enterpriseID.wsdl.xml");
      $this->webSr->createConnection("/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/enterpriseERX.wsdl.xml");
      $res = $this->webSr->login($userName, $password.$securityToken);

      } catch ( SoapFault $e ) {
          echo "<p>Cannot connect to service</p>";
          print_r($e);
          exit;
      }


      $dataArray = $this->objectToArray($res);

      $this->connectString = $dataArray['userInfo']['organizationName'];



   }


   public function getConnectString() {

          return($this->connectString);
   }


   private function objectToArray($d) {

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
            return array_map(array($this, 'objectToArray'), $d);
        }
        else {
            // Return array
            return $d;
        }
    }

   
    public function getUserByName($fn, $ln) {

      $query = "SELECT Id, 
                       FirstName, 
                       LastName, 
                       Title,
                       Department,
                       BirthDate,
                       Phone,
                       Email 
                from   Contact 
                where  (lastName like 'B%' OR lastName like 'P%' OR lastName like 'F%')
                order by lastName";


//          where  firstName = '".$fn."'
//                and    lastName = '".$ln."'";

      $response = $this->webSr->query($query);
      foreach ($response as $record) {
        echo $record->Id ."|". $record->FirstName ."|". $record->LastName . "|".$record->Title . "|". $record->Department . "|". $record->Birthdate. "|". $record->Phone . "|". $record-Email."<br />";
      }
      return($response);
   
    }


    public function getUserBySfId($ids) {

      $lcnt=0;
      $s = "";

      $s = "<table width='100%' cellspacing='0' cellpadding='0' style='font-family:arial;font-size:.8em'>";
      $s .= "<tr bgcolor='D0D0D0' align='center'>";
      $s .= "<td ><strong> &nbsp;</strong>";
      $s .= "<td ><strong>First</strong>";
      $s .= "<td ><strong>Last</strong>";
      $s .= "<td><strong>Title</strong>";
      $s .= "<td><strong>Phone</strong>";
      $s .= "<td><strong>Email</strong>";
      $s .= "</tr>";

      $query = "SELECT Id, 
                       FirstName, 
                       LastName, 
                       Title,
                       Phone,
                       Email,
                       Birthdate,
                       ssn4__c,
                       ID__c 
                from   Contact 
                WHERE  lastname = 'Barr'
                and    Birthdate = 1948-05-18
                and    ssn4__c = '1234' ";

                //where  Id in ".$ids." order by LastName";
      $response = $this->webSr->query($query);


      foreach ($response as $r) {

        if (($lcnt % 2) != 0) {
            $s .= "<tr bgcolor='#E0E0E0'>";
        } else  {
            $s .= "<tr bgcolor='white'>";
        }

        $s .= "<td><a href='javascript:void(0)' onclick='editSalesforce(\"".$r->Id."\")'>Edit</a></td>";
        $s .= "<td>".$r->FirstName."</td>";
        $s .= "<td>".$r->LastName."</td>";
        $s .= "<td>".$r->Title."</td>";
        $s .= "<td>".$r->Phone."</td>";
        $s .= "<td>".$r->Email." ssn4: ".$r->ssn4__c." ID: ".$r->ID__c."</td>";
        $s .= "</tr>";

        $lcnt++;

     }

     $s .= "<table>";

    $sobj = new SObject($response);
    return($s);
   
   }

    
    public function createUserInContact($data) {

      $records = array();
      $ids = array();


      $records[0] = new stdclass();
      $records[0]->FirstName = $data['firstName'];
      $records[0]->LastName = $data['lastName'];
      $records[0]->Phone = $data['phone'];
      $records[0]->BirthDate = $data['dob'];



      $response = $this->webSr->create($records, 'Contact');

      foreach ($response as $i => $result) {
         echo $records[$i]->FirstName . " " . $records[$i]->LastName . " "
         . $records[$i]->Phone . " created with id " . $result->id
         . "<br/>\n";

         array_push($ids, $result->id);
      }


      return($ids);
     

    }


    public function updateUserContact($data) {


      $records[0] = new stdclass();
      $records[0]->Id = $data['Id'];
      $records[0]->Phone = $data['Phone'];
      $records[0]->Title = $data['Title'];

      $response = $this->webSr->update($records, 'Contact');

      return($response);

    }


    public function deleteUserById($id) {

      $response = $this->webSr->delete($ids);
      foreach ($response as $result) {
         echo $result->id . " deleted<br/>\n";
      }

   }



public function editById($sfId) {

     $s = "";
     $lcnt=0;

     $s = "<table width='100%' cellspacing='0' cellpadding='0' style='font-family:arial;font-size:.8em'>";
     $s .= "<tr bgcolor='D0D0D0' align='center'>";
     $s .= "<td ><strong> &nbsp;</strong>";
     $s .= "<td ><strong>First</strong>";
     $s .= "<td ><strong>Last</strong>";
     $s .= "<td><strong>Title</strong>";
     $s .= "<td><strong>Phone</strong>";
     $s .= "<td><strong>Email</strong>";
     $s .= "</tr>";

     $query = "SELECT  Id,
                       FirstName,
                       LastName,
                       Title,
                       Phone,
                       Email
                from   Contact
                where  Id ='".$sfId."' ";


      $response = $this->webSr->query($query);

      foreach ($response as $r) {

        if (($lcnt % 2) != 0) {
            $s .= "<tr bgcolor='#E0E0E0'>";
        } else  {
            $s .= "<tr bgcolor='white'>";
        }

        $s .= "<td><a href='javascript:void(0)' onclick='saveSalesforce(\"".$r->Id."\")'>Update</a></td>";
        $s .= "<td><input type='text' name='fn' id='fn' value='".$r->FirstName."'></td>";
        $s .= "<td><input type='text' name='ln' id='ln' value='".$r->LastName."'></td>";
        $s .= "<td><input type='text' name='title' id='title' value='".$r->Title."'></td>";
        $s .= "<td><input type='text' name='phone' id='phone' value='".$r->Phone."'></td>";
        $s .= "<td><input type='text' name='email' id='email' value='".$r->Email."'></td>";
        $s .= "</tr>";

        $lcnt++;

     }

     $s .= "</table>";

     return($s);


}



public function saveById($data) {

   
   $records[0] = new stdclass();
   $records[0]->Id = $data['Id'];
   $records[0]->FirstName = $data['FirstName']; 
   $records[0]->LastName = $data['LastName']; 
   $records[0]->Title = $data['Title']; 
   $records[0]->Phone = $data['Phone'];
   $records[0]->Email = $data['Email']; 
   $records[0]->ID__c = $data['GPCID']; 


   $response = (array) $this->webSr->update($records, 'Contact');

   //print_r($response);

   return('<p>Salesforce Data Successfully Saved</p>');

}




}//class
