<?php

require "dual_js.js";
require "dualSf_js.js";

echo "<table width='1200' cellspacing='0' cellpadding='0' style='font-family:arial'>";

echo "<tr>";
echo "<td width='600' align='center'><strong>Salesforce</strong></td>";
echo "<td width='10' align='center'>&nbsp;</td>";
echo "<td width='600' align='center'><strong>Banner</strong></td>";
echo "</tr>";



echo "<tr>";
echo "<td><div id='salesforceData'></div></td>";
echo "<td width='10' align='center'>&nbsp;</td>";
echo "<td><div id='bannerData'></div></td>";
echo "</tr>";


echo "</table>";

echo "<br />";

echo "<div id='editt'></div>";


?>


<script type='text/javascript'>

  loadSalesforceData();

  loadBannerData();

</script>



