<script type='text/javascript'>



function getHTTPObject() {

  var xmlhttp;

  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}
var http = getHTTPObject(); // We create the HTTP Object



function loadSalesforceData() {

   var parameters="";

   document.getElementById('salesforceData').innerHTML = "<img src=\"images/indicator_medium.gif\" width=\"32\" height=\"32\">";

   http.open("POST", "getSalesforceData.php", true)
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   http.onreadystatechange = handle_loadSalesforceData;
   http.send(parameters)

}


function handle_loadSalesforceData() {
 
  var results;

  if (http.readyState == 4) {
      results = http.responseText;
      document.getElementById('salesforceData').innerHTML = results;

  }


}



function editSalesforce(sfid) {

   var parameters="sfId="+sfid;

   document.getElementById('editt').innerHTML = "<img src=\"images/indicator_medium.gif\" width=\"32\" height=\"32\">";

   http.open("POST", "editSalesforce.php", true)
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   http.onreadystatechange = handle_editSalesforce;
   http.send(parameters)


}


function handle_editSalesforce() {

  var results;

  if (httpSF.readyState == 4) {
      results = http.responseText;
      document.getElementById('editt').innerHTML = results;

  }

}



function saveSalesforce(sfId) {

  var fn = document.getElementById('fn');
  var ln = document.getElementById('ln');
  var title = document.getElementById('title');
  var phone = document.getElementById('phone');
  var email = document.getElementById('email');


  if (fn.value == '') {
      alert('First Name is a required field');
      return(false);
  }

  if (ln.value == '') {
      alert('Last Name is a required field');
      return(false);
  }

  if (title.value == '') {
      alert('Title is a required field');
      return(false);
  }

  if (phone.value == '') {
      alert('Phone is a required field');
      return(false);
  }

  if (email.value == '') {
      alert('Email is a required field');
      return(false);
  }

   var parameters ="sfId="+sfId;
       parameters += "&fn="+fn.value;
       parameters += "&ln="+ln.value;
       parameters += "&title="+title.value;
       parameters += "&phone="+phone.value;
       parameters += "&email="+email.value;

   //alert(parameters);
   
   //document.getElementById('editt').innerHTML = "<img src=\"images/indicator_medium.gif\" width=\"32\" height=\"32\">";
  
   //http.open("POST", "saveSalesforceData.php", true)
   http.open("POST", "saveBoth.php", true)

   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   http.onreadystatechange = handle_saveSalesforceData;
   http.send(parameters)
   
} 


function handle_saveSalesforceData() {

  var results;

  if (http.readyState == 4) {
      results = http.responseText;
      document.getElementById('editt').innerHTML = results;

      loadSalesforceData();

      loadBannerData();

  }

}




















</script>

