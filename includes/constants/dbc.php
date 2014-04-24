<?php
//JDM

//SQL credentials
define ("DB_HOST", "localhost");
define ("DB_USER", "hci573");
define ("DB_PASS", "hci573");
define ("DB_NAME", "hci573");

//tables
define ("TABLE_PRODUCTS", "products_jdm_chie");
define ("TABLE_INQUIRIES", "inquiries_jdm_chie");
define ("TABLE_USERS", "users_jdm_chie");

//connect to the SQL database
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

?>