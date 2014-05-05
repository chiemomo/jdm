<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Customer Inquiries");

include '../includes/constant/nav.inc.php';

?>

<h1>Inquiries</h1>

<?php

//get all fields from the inquiry table and sort by date, newer comes to the top 
$query_for_table = mysql_query("SELECT * FROM ".TABLE_INQUIRIES." ORDER BY time DESC;") or die(mysql_error());		

//constant/config.inc.php line 393
generate_html_table();
	
include('../includes/constant/footer.inc.php');

?>