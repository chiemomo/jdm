<?php
require 'includes/constant/config.inc.php';
require_once('includes/swift/lib/swift_required.php');
return_meta();

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
		//exit();


//Swift
$username = "umikoariko";
$email_password = "";
$email_from = "umikoariko@gmail.com";
$from_name = "Fairway Golf";


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
http://www." . $company_url;

$email_subject = "Custom quote for " . $club;

//echo $email_content;
//send it to the customer
send_email($customer_email,$email_content,$email_subject);
echo "email sent";
	}

}



?>
	
	<script>
		//Function which gets executed when the document is loaded
		$(function()
		{

			//JQUERY UI AUTO-COMPLETION for CLUBs

			//Define an array holding the strings that will be used for auto-completion in the club field.
			var availableClubs = [ ];
			
			$.ajax(
				{
					type: "POST",
					url: "generate_club.php", 
					data: "",
					success: function(response)
					{
						
						/* use JSON's function to parse the response */
						var parsed_response = JSON.parse(response);
						
						/* retrieve the club array that is part of the response. */
						availableClubs = parsed_response.club;
						
						/* select the HTML element with id="club" and call the autocomplete() function from the jquery UI library */
						$( "#club" ).autocomplete({
							source: availableClubs
						});
					}
				}
			);

			//JQUERY UI AUTO-COMPLETION for SHAFTS
			
			//define an array to hold shaft string
			var availableShafts = [ ];
			
			$.ajax(
				{
					type: "POST",
					url: "generate_shaft.php", 
					data: "",
					success: function(response)
					{
						
						/* use JSON's function to parse the response */
						var parsed_response = JSON.parse(response);
						
						/* retrieve the shaft array that is part of the response. */
						availableShafts = parsed_response.shaft;
						
						/* select the HTML element with id="shaft" and call the autocomplete() function from the jquery UI library */
						$( "#shaft" ).autocomplete({
							source: availableShafts
						});
					}
				}
			);

			//PROCESS FORM SUBMISSION & PASS IT ON TO PHP
			$(".submit").click(function()
			{
				
				//create variables to store the data entered into the form
				var customer = $("#customer").val();
				var email = $("#email").val();     
				var club = $("#club").val();     
				var shaft = $("#shaft").val();
				var quantity = $("#quantity").val();
				var comment = $("#comment").val();
			
				/* what if a customer uncheck the subscription box?*/
				if(document.getElementById("subscribe").checked){
					var subscribe = 'yes';
				} else {
					var subscribe = 'no';
				}
					
				//Check for empty values
				if(customer == '' || email == '' || club == '' || shaft == '' || quantity == '')
				{
					//show the html error message where div.error if there is empty field
					$('.error').fadeIn(400).show().html('<p class="red">*Please fill out all required fields.</p>'); 
				}
				else
				{
					//construct the data string to insert the table	
					var datastring = "customer=" + customer + "&email=" + email + "&club=" + club + "&shaft=" + shaft + "&quantity=" + quantity 
					+ "&subscribe=" + subscribe +"&comment=" + comment;
		 
					/* AJAX request. The request is made to $_SERVER['PHP_SELF']
					The request is handled by checking for $_POST data (line 5)	*/
					$.ajax( 
						{
						type: "POST",
						url: "<?php echo $_SERVER['PHP_SELF']; ?>?cmd=add", 
						data: datastring,
						success: function()
							{
								$('#customer').val(''); //Clear out val from text box
								$('#email').val(''); //Clear out val from text box
								$('#club').val(''); //Clear out val from text box
								$('#shaft').val(''); //Clear out val from text box
								$('#quantity').val(''); //Clear out val from text box
								$('#comment').val(''); //Clear out val from text box
								//$('.success').fadeIn(2000).show().html('Thanks ' +customer + ', your request has been submitted successfully!').fadeOut(6000); //Show, then hide success msg
								$('.error').fadeOut(2000).hide(); //If showing error, fade out
								
								var thanks = "<p>Thanks " + customer + " for your interest!</p>"
								thanks += "<p>Your quote for " + club + " with " + shaft + " is on its way.</p>" 
								
								$(function() {
									$( "#success" ).dialog({ position: { my: "center", at: "center", of: "#form_wrapper" } });
									$( "#success" ).dialog({ width: 360, height: 200 });
									$( "#success" ).dialog().html(thanks);
								});
								
								//every time user submit information, it load all the messages and show them
								//$("#load_msgs").fadeIn(400).show().load('get_msg.php');
				 
							}
						}
					);
				}
				
				//return false to prevent reloading page
				return false;
			});
			
			//JQUERY UI ACCORDION (pre-defined function) used for product details
			$(function() {
				$( "#accordion" ).accordion();
			});

			//JQUERY UI BUTTON (pre-defined function)
			$( "input[type=submit], button" )
				.button()
				.click(function( event ) {
				event.preventDefault();
			});
			
			//JQUERY STICKY DIV W/ SCROLL
			//http://www.pixelbind.com/make-a-div-stick-when-you-scroll/
			var s = $("#form_wrapper");
			var pos = s.position();                   
			$(window).scroll(function() {
				var windowpos = $(window).scrollTop();
				if (windowpos >= pos.top) {
					s.addClass("stick");
				} else {
					s.removeClass("stick");
				}
			});		

		});
	</script>
</head>
<body>
	<div id="container">

	<?php include 'includes/constant/nav.inc.php'; ?>

		<div class="wrapper">
			<!-- left container -->
			<div class="container_left">
				<!-- jquery ui accordion -->
				<div id="accordion">
				<?php
					//show product details HTML which is generated by the function
					echo load_product_details();
				?>
				</div>
			</div>
			<!-- container on the right -->	
			<div class="container_right">
				<!-- quote form -->
				<div id="form_wrapper">
					<h2>Get A Quote Now!</h2>
					<p><small>* required field</small></p>
					<form method="post" name="form" id="quote_form">
						<!-- jquery ui auto-complete for club -->
						<div class="ui-widget">
						<label for="club">Clubs*: </label>
						<input id="club">
						</div>
						<!-- jquery ui auto-complete for shaft -->
						<div class="ui-widget">
						<label for="shaft">Shafts*: </label>
						<input id="shaft">
						</div>
						<p><label>Quantity*: </label>
						<input type="text" id="quantity" name="quantity" /></p>
						<p><label>Full Name*: </label>
						<input type="text" id="customer" name="customer" /></p>
						<p><label>Email Address*: </label>
						<input type="text" id="email" name="email" /></p>
						<p><label>Comment: </label>
						<textarea name="text" id="comment" rows="3" cols="34"></textarea></p>
						<input type="checkbox" id="subscribe" name="subscribe" value="yes" checked>Subscribe Newsletter
						<p><button type="submit" class="submit" value="submit">Get A Quote!</button></p>
					</form>
					<!-- display error or success message -->
					<p class="error" style="display:none;"></p>
					<div id="success" title="Request Success!"></div>
					<!--<div id="load_msgs" style="display:none;border-top: 1px solid #ccc;"></div>-->
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
</html>