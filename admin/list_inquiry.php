<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Customer Inquiries");

include '../includes/constant/nav.inc.php';

?>

<h1>Inquiries</h1>

<?php

$query_for_table = mysql_query("SELECT * FROM ".TABLE_INQUIRIES." ORDER BY id;") or die(mysql_error());		

//constant/config.inc.php line 393
generate_html_table();
	
include('../includes/constant/footer.inc.php');

?>