<?php

		$customer = "";
		$email = "";
		$club = "";
		$shaft = "";
		$subscribe = "";
		$comment = "";
		$quantity = "";

//INSERT SUBMITTED INFORMATION TO INQUIRY TABLE
if($_POST and $_GET) //Check for post data
{
	if ($_GET['cmd'] == 'add'){
	
		//Assign variables and sanitize POST data
		$customer = mysql_real_escape_string($_POST['customer']);
		$email = mysql_real_escape_string($_POST['email']);
		$club = mysql_real_escape_string($_POST['club']);
		$shaft = mysql_real_escape_string($_POST['shaft']);
		$subscribe = $_POST['subscribe']; //The value is 'yes' or 'no' only and no need to sanitize
		$comment = mysql_real_escape_string($_POST['comment']);
		$quantity = preg_replace('#[^0-9]#', '', $_POST['quantity']); //get rid of letters except numbers
	 
		//Build a query statement for insertion
		$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, quantity, subscribe, comment, time) VALUES ('".$customer."', '".$email."', '".$club."', '".$shaft."', '".$quantity."', '".$subscribe."', '".$comment."', now());";
		mysql_query($query) or die(mysql_error());
		
		//After the $_POST data is processed, we use the exit() function because we don't need to actually show the page as the request is made in the background
		exit();
	}
}

echo $customer;

?>

<html>
<body>

Welcome <?php echo $_POST["club"]; ?><br>
Your email address is: <?php echo $_POST["shaft"]; ?>

</body>
</html> 