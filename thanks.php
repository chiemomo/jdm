<?php
require 'includes/constant/config.inc.php';
require_once('includes/swift/lib/swift_required.php');

//Process a submission on quote_form.php and insert the data into the inquiry table.
if($_POST) //Check for post data
{
	//Assign variables and sanitize POST data
	$club = mysql_real_escape_string($_POST['club']);
	$shaft = mysql_real_escape_string($_POST['shaft']);
	$quantity = preg_replace('#[^0-9]#', '', $_POST['quantity']); //get rid of letters except numbers
	$customer_name = mysql_real_escape_string($_POST['customer']);
	$customer_email = mysql_real_escape_string($_POST['email']);
	$subscribe = $_POST['subscribe']; //The value is 'yes' or 'no' only
	$comment = mysql_real_escape_string($_POST['comment']);
 
	//Build a query statement for insertion
	$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, quantity, subscribe, comment, time) VALUES ('".$customer_name."', '".$customer_email."', '".$club."', '".$shaft."', '".$quantity."', '".$subscribe."', '".$comment."', now());";
	mysql_query($query) or die(mysql_error());
}


//Swift
$username = "umikoariko";
$email_password = "umineko1234";
$email_from = "umikoariko@gmail.com";
$from_name = "Umi Neko";

$club = "Miura Special Edition K.J. Choi CB-501 Forged Irons";

	$query_club_pcice = "SELECT price FROM " . TABLE_PRODUCTS . " WHERE club = '" . $club ."';";
	$result_club_price = mysql_query($query_club_pcice) or die("Failed to retrieve rows: " . mysql_error());

	echo $result_club_price;
/*
function email_content_customer ($customer_name, $club, $shaft, $quantity, $comment){
	$content = "Dear " . $customer_name .",
	Thank you for your interest on " . $club . ".
	
	You have been assigned as a reviewer for the following two final project proposals: " . $club . " and " . $shaft . "

	* Do you have any suggestions for related work that should be cited?";

	return $content;
}
		

		echo "Sending email to $email_to<br><br><br>";
		echo $email_content . "<br><br><br><br>";
*/		
		//send_email($customer_email,$email_content_customer,"HCI 573 Proposal Review Assignments");

		//send_email("chiemomo@gmail.com","test","another test");
		echo "sent";
?>
<html>
<body>
<!--
Welcome <?php //echo $customer; ?><br>
Your email address is: <?php //echo $quantity; ?>
-->
</body>
</html> 