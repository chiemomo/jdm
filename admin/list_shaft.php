<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Shaft Entries");

include '../includes/constant/nav.inc.php';

?>

<h1>Shafts</h1>

<?php

$query_for_table = mysql_query("SELECT * FROM ".TABLE_SHAFTS." ORDER BY shaft ASC;") or die(mysql_error());		

//constant/config.inc.php line 393
generate_html_table();

include('../includes/constant/footer.inc.php');

?>