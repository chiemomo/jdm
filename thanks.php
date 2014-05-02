<?php
require 'includes/constant/config.inc.php';
require_once('includes/swift/lib/swift_required.php');
return_meta();

//Process a submission on quote_form.php and insert the data into the inquiry table.
if($_POST) //Check for post data
{
	//Assign variables and sanitize POST data
	$club = mysql_real_escape_string($_POST['club']);
	$shaft = mysql_real_escape_string($_POST['shaft']);
	$quantity = preg_replace('#[^0-9]#', '', $_POST['quantity']); //get rid of letters except numbers
	$customer_name = mysql_real_escape_string($_POST['customer']);
	$customer_email = mysql_real_escape_string($_POST['email']);
	$comment = mysql_real_escape_string($_POST['comment']);
	$subscribe = $_POST['subscribe']; //The value is 'yes' or 'no' only
 
	//Build a query statement for insertion
	$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, quantity, subscribe, comment, time) VALUES ('".$customer_name."', '".$customer_email."', '".$club."', '".$shaft."', '".$quantity."', '".$subscribe."', '".$comment."', now());";
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
$email_password = "";
$email_from = "umikoariko@gmail.com";
$from_name = "Fairway Golf, Inc.";


//Compute prices for quote

//Fetch price for single club from the product table 
$query_club_pcice = "SELECT `price` FROM `" . TABLE_PRODUCTS . "` WHERE `club` = '" . $club . "' limit 1";
$result_club_price = mysql_query($query_club_pcice) or die("Failed to retrieve rows: " . mysql_error());

//Fetch price for single shaft from the shaft table
$query_shaft_pcice = "SELECT `price` FROM `" . TABLE_SHAFTS . "` WHERE `shaft` = '" . $shaft . "' limit 1";
$result_shaft_price = mysql_query($query_shaft_pcice) or die("Failed to retrieve rows: " . mysql_error());

//Assign variable to the results
$club_price = mysql_result($result_club_price, 0);
$shaft_price = mysql_result($result_shaft_price, 0);
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
send_email($customer_email,$email_content,$email_subject);

?>
	
<?php include 'includes/constant/nav.inc.php'; ?>

<p>Thank you for your interest!</p>
<p>A custom quote for your JDM will be sent to your email address.<br>
If you do not receive the quote within 5 min, please submit the form again or contact us at <?php echo $company_email; ?> or <?php echo $company_phone; ?>.</p>

<p>Your request has been sent as below:<br>
Your Name: <span class="your_info"><?php echo $customer_name; ?></span><br> 
Your Email: <span class="your_info"><?php echo $customer_email; ?></span><br> 
Your Club: <span class="your_info"><?php echo $club; ?></span><br>
Your Shaft: <span class="your_info"><?php echo $shaft; ?></span><br>
Quantity: <span class="your_info"><?php echo $quantity; ?></span><br>
Comment: <span class="your_info"><?php echo $comment; ?></span><br>
Newsletter Subscription: <span class="your_info"><?php echo $subscribe; ?></span></p>

<?php include('includes/constant/footer.inc.php'); ?>