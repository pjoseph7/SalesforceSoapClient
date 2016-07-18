<?php


require_once "class.oracle.connection.php";

class oracleBanner extends Oracle_Connection {


  function oracleBanner() {

      parent::__construct('DEVL');

  }



  public function getBannerData() {


     $lcnt = 0;
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



     $SQL="select    wgbsfts_sfid, 
                     WGBSFTS_firstName, 
		     WGBSFTS_lastName, 
		     WGBSFTS_title, 
		     WGBSFTS_department, 
		     WGBSFTS_dob, 
		     WGBSFTS_phone, 
		     WGBSFTS_email
           from      SMARTS.WGBSFTS
	   order by  WGBSFTS_lastName ";


     //echo "<pre>".$SQL."</pre>";
     $st = OCIParse($this->db, $SQL);
     OCIExecute($st, OCI_DEFAULT);
     while (OCIFetchInto ($st, $r, OCI_ASSOC | OCI_RETURN_NULLS)) {

        if (($lcnt % 2) != 0) {
            $s .= "<tr bgcolor='#E0E0E0'>";
        } else  {
            $s .= "<tr bgcolor='white'>";
        }

        $s .= "<td><a href='javascript:void(0)' onclick='editBanner(\"".$r['WGBSFTS_SFID']."\")'>Edit</a></td>";
        $s .= "<td>".$r['WGBSFTS_FIRSTNAME']."</td>";
        $s .= "<td>".$r['WGBSFTS_LASTNAME']."</td>";
        $s .= "<td>".$r['WGBSFTS_TITLE']."</td>";
        $s .= "<td>".$r['WGBSFTS_PHONE']."</td>";
        $s .= "<td>".$r['WGBSFTS_EMAIL']."</td>";
        $s .= "</tr>";

        $lcnt++;

     }//while


     $s .= "</table>";

     return($s);

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



     $SQL="select    wgbsfts_sfid,
                     WGBSFTS_firstName,
                     WGBSFTS_lastName,
                     WGBSFTS_title,
                     WGBSFTS_department,
                     WGBSFTS_dob,
                     WGBSFTS_phone,
                     WGBSFTS_email
           from      SMARTS.WGBSFTS
           where     wgbsfts_sfid = '".$sfId."' ";


     //echo "<pre>".$SQL."</pre>";
     $st = OCIParse($this->db, $SQL);
     OCIExecute($st, OCI_DEFAULT);
     while (OCIFetchInto ($st, $r, OCI_ASSOC | OCI_RETURN_NULLS)) {

        if (($lcnt % 2) != 0) {
            $s .= "<tr bgcolor='#E0E0E0'>";
        } else  {
            $s .= "<tr bgcolor='white'>";
        }

        $s .= "<td><a href='javascript:void(0)' onclick='saveBannerData(\"".$r['WGBSFTS_SFID']."\")'>Update</a></td>";
        $s .= "<td><input type='text' name='fn' id='fn' value='".$r['WGBSFTS_FIRSTNAME']."'></td>";
        $s .= "<td><input type='text' name='ln' id='ln' value='".$r['WGBSFTS_LASTNAME']."'></td>";
        $s .= "<td><input type='text' name='title' id='title' value='".$r['WGBSFTS_TITLE']."'></td>";
        $s .= "<td><input type='text' name='phone' id='phone' value='".$r['WGBSFTS_PHONE']."'></td>";
        $s .= "<td><input type='text' name='email' id='email' value='".$r['WGBSFTS_EMAIL']."'></td>";
        $s .= "</tr>";

        $lcnt++;

     }//while


     $s .= "</table>";

     return($s);


}


public function saveById($data) {


   $SQL="update  wgbsfts
            set  WGBSFTS_firstName = '".$data['FirstName']."',
                 WGBSFTS_lastName = '".$data['LastName']."',
                 WGBSFTS_title = '".$data['Title']."',
                 WGBSFTS_phone = '".$data['Phone']."',
                 WGBSFTS_email = '".$data['Email']."'
         where   wgbsfts_sfid = '".$data['Id']."' "; 


   //echo "<pre>".$SQL."</pre>";
   $st = OCIParse($this->db, $SQL);
   OCIExecute($st, OCI_DEFAULT);

   $SQL = 'commit';

   $st = OCIParse($this->db, $SQL);
   OCIExecute($st, OCI_DEFAULT);

   return('<p>Banner Data Successfully Saved</p>');

}
















}//class
