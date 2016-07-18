<?php

// class.oracle.connection.php


  abstract class Oracle_Connection {

    var $db;
    var $mailid = 'jstrain@gpc.edu';
    var $login;


    function oracle_connection($server) {


       switch ($server) {


           case 'DEVL':
                        $db= "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = donkey.gpc.edu) (PORT = 8866))
                              (CONNECT_DATA = (SID = DEVL) (GLOBAL_NAME = DEVL.dekalb.usg.ga.us)))";
                        $this->login = 'DEVL';
                        break;

           case 'TRNG':
                        $db= "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = pluto.gpc.edu) (PORT = 8866))
                              (CONNECT_DATA = (SID = TRNG) (GLOBAL_NAME = TRNG.dekalb.usg.ga.us)))";
                        $this->login = 'TRNG';
                        break;

           case 'PROD':
                        $db= "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = banner-db.gpc.edu) (PORT = 8866))
                              (CONNECT_DATA = (SID = PROD) (GLOBAL_NAME = PROD.dekalb.usg.ga.us)))";
                        $this->login = 'PROD';

           default:
                        $db= "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = banner-db.gpc.edu) (PORT = 8866))
                              (CONNECT_DATA = (SID = PROD) (GLOBAL_NAME = PROD.dekalb.usg.ga.us)))";
                        $this->login = 'PROD';

       }


       require "/usr/local/secure/globals/oracle/oracle_user_pass.inc.php";

       $this->db = OCILogon($oracle_username, $oracle_password, $db);



    }//endof


    public function getLoginDb() {
       return($this->login);
    }


    public function logoff() {

        OCILogoff($this->db);

   }


    public function escape_single_quote($str) {

        $str = str_replace("'", "''", $str);
        return($str);

    }


    private function nothing() {


         $SQL="select w_hold.f_Release_NS('900336667') from dual";

         $st = OCIParse($this->db, $SQL);
         OCIExecute($st, OCI_DEFAULT);

         OCIFetchInto ($st, $r,  OCI_NUM | OCI_RETURN_NULLS);

         return($r[0]);

    }

}//class








