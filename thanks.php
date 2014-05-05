<?php
require 'includes/constant/config.inc.php';
require_once('includes/swift/lib/swift_required.php');
return_meta("Thank You!");

//Process a submission on quote_form.php
if($_POST) //Check for post data
{

	//validate if required fields are filled
	//http://www.w3schools.com/php/php_form_required.asp

	//if a required field is empty, return an error message
	if (empty($_POST["club"]) || empty($_POST["shaft"]) || empty($_POST["quantity"]) || empty($_POST["customer"]) || empty($_POST["email"])) {

		$err = "Please fill all of the required field.<br><br>";
		$err .= "Use browser's back button to go back to the form and type in again.";

	} elseif (!check_email($_POST['email'])) {

		//validate the email address
		$err = "Entered email address does not seem to be an valid email address.<br><br>";
		$err .= "Use browser's back button to go back to the form and type it again.";

	} else {
	
		//if all of required fields are NOT empty, sanitize the post data
		$club = filter($_POST["club"]);
		$shaft = filter($_POST["shaft"]);
		$quantity = preg_replace('#[^0-9]#', '', $_POST['quantity']); //get rid of letters except numbers
		$customer_email = filter($_POST['email']);
		$customer_name = filter($_POST['customer']);
		$comment = filter($_POST['comment']);

		//Check if subscribe check box is left checked or unchecked
		//http://www.webdeveloper.com/forum/showthread.php?209721-Posting-an-UNCHECKED-check-box
		if (!empty($_POST['subscribe'])) {
			$subscribe = 'yes';
		} else {
			$subscribe = 'no';
		}//The value is 'yes' or 'no' only

		//Build a query statement for insertion
		$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, quantity, subscribe, comment, time) VALUES ('".$customer_name."', '".$customer_email."', '".$club."', '".$shaft."', '".$quantity."', '".$subscribe."', '".$comment."', now());";
		
		//run the query to insert posted data into the inquiry table
		mysql_query($query) or die(mysql_error());

/*
$club = "Epon AF 103 Drivers";
$shaft = "KBS C Taper Iron Shafts";
$quantity = "8";
$customer_name = "momotaro";
$customer_email = "chiemomo@gmail.com";
$comment = "hello";
$subscribe = "yes";
*/

//Swift
$username = "umikoariko";
$email_password = "";
$email_from = "umikoariko@gmail.com";
$from_name = "Fairway Golf, Inc.";


		//Compute prices for quote

		//Fetch price for the single club from the product table
		//Limit 1 saves time by making the the query to return price for the club only
		$query_club_pcice = "SELECT `price` FROM `" . TABLE_PRODUCTS . "` WHERE `club` = '" . $club . "' limit 1";
		$result_club_price = mysql_query($query_club_pcice) or die("Failed to retrieve rows: " . mysql_error());

		//Fetch price for the single shaft from the shaft table
		$query_shaft_pcice = "SELECT `price` FROM `" . TABLE_SHAFTS . "` WHERE `shaft` = '" . $shaft . "' limit 1";
		$result_shaft_price = mysql_query($query_shaft_pcice) or die("Failed to retrieve rows: " . mysql_error());

		//Assign variable to the results
		$club_price = mysql_result($result_club_price, 0); //refer row 0
		$shaft_price = mysql_result($result_shaft_price, 0); //refer row 0
		$total_price = ($club_price + $shaft_price) * $quantity; //calculate total price

		if (!empty($comment)) {
			$content_comment = "Our staff will send you another email to reply to your comment.\n
	Your comment: " . $comment; //if the customer left a comment, return this message
		} else {
			$content_comment = "Your comment: No comment is posted."; //return this if there is no comment
		}

//generate email content to send to customers
$email_content = "Dear " . $customer_name .",\n\n

Thank you for your interest on " . $club . ".\n
Here is the custom quote with your selected specifications.\n\n

Your Club: " . $club . "\n
Your Shaft: " . $shaft . "\n\n

Price per Club: $" . $club_price . "\n
Price per Shaft: $" . $shaft_price . "\n
Quantity : " . $quantity . "pc\n
--------------------------------\n
Total Price: $" . $total_price . "\n\n

" . $content_comment . "\n\n

* Free shipping is available for JDM orders.\n
* CA sales tax is applied for a shipment within California.\n\n

To place this order or for further questions, simply reply to this email or call our customer service at " . $company_phone . ".\n
Thank you again and we are looking forward to hearing from you soon!\n\n

" . $company_name . "\n
" . $company_address . "\n
" . $company_email . "\n
" . $company_phone . "\n
" . $company_url;

		$email_subject = "Custom quote for " . $club;

		//send it to the customer
		send_email($customer_email,$email_content,$email_subject);

	}

} //close if($_POST) 

?>
	
<?php include 'includes/constant/nav.inc.php'; ?>

<?php
//Show error message if the customer left any of required field.
if(!empty($err)) {
	
	echo "<div class='err'>" . $err . "</div>";

	} else {

	//else, return below HTML on the page
?>

<h1>Thank you for your interest!</h1>
<p>A custom quote for your JDM golf clubs will be sent to your email address "<?php echo $customer_email; ?>" soon!<br>
If you do not receive the quote within 15 minutes, please submit the form again or contact us directly at <?php echo $company_email; ?> or <?php echo $company_phone; ?>.</p>

<table class="thanks">
	<tr>
		<td colspan="2" class="thanks_label">Information Sent:</td>
	</tr>
	<tr>
		<td class="thanks_label">Your Name: </td>
		<td><?php echo $customer_name; ?></td>
	</tr>
	<tr>
		<td class="thanks_label">Your Email: </td>
		<td><?php echo $customer_email; ?></td>
	</tr>
	<tr>	
		<td class="thanks_label">Your Club: </td>
		<td><?php echo $club; ?></td>
	</tr>
	<tr>
		<td class="thanks_label">Your Shaft: </td>
		<td><?php echo $shaft; ?></td>
	</tr>
	<tr>
		<td class="thanks_label">Quantity: </td>
		<td><?php echo $quantity; ?></td>
	</tr>
	<tr>
		<td class="thanks_label">Comment: </td>
		<td><?php echo $comment; ?></td>
	</tr>
	<tr>
		<td class="thanks_label">Newsletter Subscription: </td>
		<td><?php echo $subscribe; ?></td>
	</tr>
</table>

<?php

} //close success HTML

include('includes/constant/footer.inc.php');

?>