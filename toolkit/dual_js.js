<script type='text/javascript'>



function getHTTPObjectOracle() {

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
var httpSF = getHTTPObjectOracle(); // We create the HTTP Object





function loadBannerData() {

   var parameters="";

   //document.getElementById('bannerData').innerHTML = "<img src=\"images/indicator_medium.gif\" width=\"32\" height=\"32\">";

   httpSF.open("POST", "getBannerData.php", true)
   httpSF.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   httpSF.onreadystatechange = handle_loadBannerData;
   httpSF.send(parameters)

}


function handle_loadBannerData() {

  var results;

  if (httpSF.readyState == 4) {
      results = httpSF.responseText;
      document.getElementById('bannerData').innerHTML = results;

  }

}


function editBanner(sfid) {

   var parameters="sfId="+sfid;

   //document.getElementById('editt').innerHTML = "<img src=\"images/indicator_medium.gif\" width=\"32\" height=\"32\">";

   httpSF.open("POST", "editBannerData.php", true)
   httpSF.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   httpSF.onreadystatechange = handle_editBannerData;
   httpSF.send(parameters)


}


function handle_editBannerData() {

  var results;

  if (httpSF.readyState == 4) {
      results = httpSF.responseText;
      document.getElementById('editt').innerHTML = results;

  }

}



function saveBannerData(sfId) {

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

   //httpSF.open("POST", "saveBannerData.php", true)
   httpSF.open("POST", "saveBoth.php", true)
   httpSF.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
   httpSF.onreadystatechange = handle_saveBannerData;
   httpSF.send(parameters)

}


function handle_saveBannerData() {

  var results;

  if (httpSF.readyState == 4) {
      results = httpSF.responseText;
      document.getElementById('editt').innerHTML = results;

      loadSalesforceData();

      loadBannerData();

  }

}




</script>

