<?php

class SalesforceStudentCheck {

   private  $webSr;
   private  $connectString;


   function salesforceStudentCheck() {

      require "/usr/local/secure/globals/salesforce/webServiceVars.php";    

      require "/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/SforceEnterpriseClient.php";

      try {

      $this->webSr = new SforceEnterpriseClient();
      //$this->webSr->createConnection("/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/enterpriseERX.wsdl.xml");

      $this->webSr->createConnection("/usr/local/web/jstatDev/toolkit/forcePHP/soapclient/enterpriseERX_PROD.wsdl.xml");


      $res = $this->webSr->login($userName, $password.$securityToken);

      } catch ( SoapFault $e ) {

          
          echo "<p>Cannot connect to service</p>";
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



   /*  SF Contact fields     WHICH?

       Country_of_Birth__c
       Country_of_Citizenship__c
       County_of_Residence__c

  USE:  EnrollmentrxRx__Contact_Status__c
        "Inquiry", "AppStarted", "AppSubmitted", "App Complete","Admit","Deposit",  and "Closed (File Closed)

     App Submitted = The Contact has completed the application and paid the application fee.
     App Complete = The Contact has completed the application but has not paid the application fee.


   */




   public function salesforceQuickCheck($lastName, $emailAddr) {


      if (strpos($lastName, "'")) {
          $tmp = explode("'", $lastName);
          $lnSearch = $tmp[0]."\'".ucfirst($tmp[1]);

      } else {
         $charArray = array(' ', '-');
         $lastName = ucfirst(trim(strtolower($lastName))); // SF format
         $lnSearch = str_replace($charArray, '%', $lastName);

      }

      $email = strtolower($emailAddr); // SF format

    $query = "SELECT Id,
                       EnrollmentrxRx__Contact_Status__c,
                       Country_of_Birth__c,
                       LastName,
                       Email,
                       SSN__c,
                       ID__c,
                       BirthDate
                from   Contact  ";

      if ($stPos) {
          $query .= " WHERE  lastname like '".$lnSearch."' ";
      } else {
          $query .= " WHERE  lastname =  '".$lnSearch."' ";
      }

      $query .= " and    Email = '".$emailAddr."' ";

     try {

          $response = $this->webSr->query($query);

      } catch (Exception $e) {

          //echo "Database Error";
          //echo "EXP: ".$e->faultstring."<br>";
          mail('webteam@gpc.edu', 'Salesforce appgateway web service error 1', $e->faultstring);
          return('FATALERROR');
          exit;

      }

      foreach ($response as $r) {


         $s = "YES";

         if ($r->Id) {

             $s = "YES|SID";



// 05042015

             $queryAp="select EnrollmentrxRx__Admissions_Status__c
                       from   EnrollmentrxRx__Enrollment_Opportunity__c
                       where  EnrollmentrxRx__Applicant__c = '".$r->Id."' ";

             try {

                   $responseAp = $this->webSr->query($queryAp);

             } catch (Exception $e) {

                   mail('webteam@gpc.edu', 'Salesforce appgateway web service error quick Check', $e->faultstring);
                   return('FATALERROR');
                   exit;
             }

             $lcnt =0;
             foreach ($responseAp as $rAp) {

               $rAs .= "|".$rAp->EnrollmentrxRx__Admissions_Status__c."|".$r->Id;
               $lcnt++;

             }

             if (! $lcnt) {
                $s .= "|NOAPPLICATION|".$r->Id;
             }  else {
                $s .= $rAs;
             }

         }

         return($s);

     }//for

     return('NO');

    }





















   
    public function checkSalesforceCredentials($lastName, $dob, $ssn4, $country, $emailAddr) {

        
      if (strpos($lastName, "'")) {
          $tmp = explode("'", $lastName);
          $lnSearch = $tmp[0]."\'".ucfirst($tmp[1]);

      //mail('jstrain@gpc.edu', 'POS*A', $lnSearch);
      } else {
         $charArray = array(' ', '-');
         $lastName = ucfirst(trim(strtolower($lastName))); // SF format 
         $lnSearch = str_replace($charArray, '%', $lastName);

      }

      $stPos = strpos($lnSearch, '%');


      $email = strtolower($emailAddr); // SF format 

      //EnrollmentrxRx__Contact_Status__c = Application Status


      $query = "SELECT Id,
                       EnrollmentrxRx__Contact_Status__c,
                       Country_of_Birth__c,
                       LastName,
                       Email,
                       SSN__c,
                       ID__c
                from   Contact  ";

      if ($stPos) {
          $query .= " WHERE  lastname like '".$lnSearch."' ";
      } else {
          $query .= " WHERE  lastname =  '".$lnSearch."' ";
      }
 
      $query .= " and    Birthdate = ".$dob." ";

     // mail('jstrain@gpc.edu', '****A', $query." pos: ".$stPos);
      $response = $this->webSr->query($query);


      foreach ($response as $r) {

        if ($r->LastName) {
            $iDMatchCount = 2; //number of items that have matched  (lastname and birthdate)
            if (substr($r->SSN__c, -4) == $ssn4) {
                $iDMatchCount++;
            }

            if ($r->Country_of_Birth__c == $country) {
                $iDMatchCount++;
            }

            if (strtolower($r->Email) == $email) {
                $iDMatchCount++;
            }


            if ($iDMatchCount > 2) {

                $s = "YES";    

                if ($r->Id) {

                    $s .= "|GPCID";    // GPCID exists 
                 
                    // now check application status 
                    $queryAp="select EnrollmentrxRx__Admissions_Status__c
                              from   EnrollmentrxRx__Enrollment_Opportunity__c
                              where  EnrollmentrxRx__Applicant__c = '".$r->Id."' 
                              and    EnrollmentrxRx__Admissions_Status__c != 'Inquiry'";

//04302015
                    $queryAp="select EnrollmentrxRx__Admissions_Status__c
                              from   EnrollmentrxRx__Enrollment_Opportunity__c
                              where  EnrollmentrxRx__Applicant__c = '".$r->Id."' ";




                    $responseAp = $this->webSr->query($queryAp);

                    $lcnt =0;
                    foreach ($responseAp as $rAp) {

                       $rAs .= "|".$rAp->EnrollmentrxRx__Admissions_Status__c."|".$r->Id;
                       $lcnt++;
                    }
             
                    if (! $lcnt) {
                       $s .= "|NOAPPLICATION|".$r->Id;
                    }  else {
                       $s .= $rAs;
                    }
                     
                } 

                return($s);
            }
         }
      }


      return('NO');
   
   }









}//class
