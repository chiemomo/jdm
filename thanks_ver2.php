<?php
require 'includes/constant/config.inc.php';
require_once('includes/swift/lib/swift_required.php');
return_meta("Thank You!");

//Process a submission on quote_form.php and insert the data into the inquiry table.
if($_POST) //Check for post data
{

//validate if required fields are filled
//http://www.w3schools.com/php/php_form_required.asp

	//define variables and set to empty values
	$clubErr = $shaftErr = $qtyErr = $nameErr = $emailErr = "";
	$club = $shaft = $quantity = $customer_name = $customer_email = "";

	//if a required field is empty, return an error message
	//if a required field is not empty, sanitize the post data
	if (empty($_POST["club"])) {
		$clubErr = "Club is required";
	} else {
		$club = mysql_real_escape_string($_POST["club"]);
	}

	if (empty($_POST["shaft"])) {
		$shaftErr = "Shaft is required";
	} else {
		$shaft = mysql_real_escape_string($_POST["shaft"]);
	}

	if (empty($_POST["quantity"])) {
		$qtyErr = "Quantity is required";
	} else {
		//get rid of letters except numbers
		$quantity = preg_replace('#[^0-9]#', '', $_POST['quantity']); 
	}

	if (empty($_POST["customer"])) {
		$nameErr = "Name is required";
	} else {
		$customer_name = mysql_real_escape_string($_POST['customer']);
	}

	if (empty($_POST["email"])) {
		$emailErr = "Email is required";
	} else {
		$customer_email = mysql_real_escape_string($_POST['email']);
	}
	
	//sanitize fields that are not required
	$comment = mysql_real_escape_string($_POST['comment']);
	$subscribe = $_POST['subscribe']; //The value is 'yes' or 'no' only

	//Build a query statement for insertion
	$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, quantity, subscribe, comment, time) VALUES ('".$customer_name."', '".$customer_email."', '".$club."', '".$shaft."', '".$quantity."', '".$subscribe."', '".$comment."', now());";
	
	//run the query to insert posted data into the inquiry table
	mysql_query($query) or die(mysql_error());
}

/*
$club = "club a";
$shaft = "shaft a";
$quantity = "8";
$customer_name = "momotaro";
$customer_email = "chiemomo@gmail.com";
$comment = "hello";
$subscribe = "yes";
*/

//Swift
$username = "umikoariko";
$email_password = "umichancute";
$email_from = "umikoariko@gmail.com";
$from_name = "Fairway Golf, Inc.";


//Compute prices for quote

$club_price = $shaft_price = "";

//Fetch price for single club from the product table 
if (!empty($club)) {
$query_club_pcice = "SELECT `price` FROM `" . TABLE_PRODUCTS . "` WHERE `club` = '" . $club . "' limit 1";
$result_club_price = mysql_query($query_club_pcice) or die("Failed to retrieve rows: " . mysql_error());
$club_price = mysql_result($result_club_price, 0);
}

//Fetch price for single shaft from the shaft table
if (!empty($shaft)) {
$query_shaft_pcice = "SELECT `price` FROM `" . TABLE_SHAFTS . "` WHERE `shaft` = '" . $shaft . "' limit 1";
$result_shaft_price = mysql_query($query_shaft_pcice) or die("Failed to retrieve rows: " . mysql_error());
$shaft_price = mysql_result($result_shaft_price, 0);
}
//Assign variable to the results

$total_price = ($club_price + $shaft_price) * $quantity;


if (!empty($comment)) {
	$content_comment = "Our staff will send you another email to reply to your comment.\n
Your comment: " . $comment;
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
//send_email($customer_email,$email_content,$email_subject);

?>
	
<?php include 'includes/constant/nav.inc.php'; ?>

<?php
//Show error message if isset
if(!empty($clubErr) || !empty($shaftErr))
{
	echo ' ass="err">';
	foreach($err as $e)
	{
	echo $e.'<br />';
	}
	echo '</div>';
}
?>

<h1>Thank you for your interest!</h1>
<p>A custom quote for your JDM golf clubs will be sent to your email address "<?php echo $customer_email; ?>" soon!<br>
If you do not receive the quote within 15 minutes, please submit the form again or contact us at <?php echo $company_email; ?> or <?php echo $company_phone; ?>.</p>

<table class="thanks">
	<tr>
		<td colspan="2" class="thanks_label">Sent Information</td>
	</tr>
	<tr>
		<td class="thanks_label">Your Name: </td>
		<td><?php echo $customer_name; ?><span class="error">* <?php echo $nameErr;?></span></td>
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

<?php include('includes/constant/footer.inc.php'); ?>