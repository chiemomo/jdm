<?php
require 'includes/constant/config.inc.php';
return_meta();
?>
	
<script>
	//Function which gets executed when the document is loaded
	$(function()
	{

		/*** JQUERY UI AUTO-COMPLETION ***/

		//define an array to hold club string
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

		//Not in use this time
		/*** PROCESS FORM SUBMISSION & PASS IT ON TO PHP 
		$(".submit").click(function()
		{
			
			//create variables to store the data entered into the form
			var customer = $("#customer").val();
			var email = $("#email").val();     
			var club = $("#club").val();     
			var shaft = $("#shaft").val();
			var quantity = $("#quantity").val();
			var comment = $("#comment").val();
		
			// what if a customer uncheck the subscription box?
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
	 
				//AJAX request. The request is made to $_SERVER['PHP_SELF']
				//The request is handled by checking for $_POST data (line 5)
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
*/
		
		//Not in use this time
		/****JQUERY UI BUTTON (pre-defined function)
		$( "input[type=submit], button" )
			.button()
			.click(function( event ) {
			event.preventDefault();
		});
*/			

		/*** JQUERY UI ACCORDION (pre-defined function) used for product details ***/
		$(function() {
			$( "#accordion" ).accordion();
		});

		/*** JQUERY STICKY DIV W/ SCROLL ***/
		//http://www.pixelbind.com/make-a-div-stick-when-you-scroll/
		//http://www.pixelbind.com/examples/stick-a-div/2/
		$(document).ready(function() {
			var s = $("#sticker");
			var pos = s.position();	
			var stickermax = $(document).outerHeight() - $(".footer").outerHeight() - s.outerHeight() - 40; //40 value is the total of the top and bottom margin
			$(window).scroll(function() {
				var windowpos = $(window).scrollTop();
				if (windowpos >= pos.top && windowpos < stickermax) {
					s.attr("style", ""); //kill absolute positioning
					s.addClass("stick"); //stick it
				} else if (windowpos >= stickermax) {
					s.removeClass(); //un-stick
					s.css({position: "absolute", top: stickermax + "px"}); //set sticker right above the footer
					
				} else {
					s.removeClass(); //top of page
				}
			});
		});			
		
	});
</script>

<?php include 'includes/constant/nav.inc.php'; ?>

<div class="container_left">
	<div id="accordion">
	<?php echo load_product_details(); //show product details HTML which is generated by the function in config.inc.php ?>
	</div>
</div>
<div class="container_right">
	<!-- quote form -->
	<div id="sticker">
		<h2>Get A Quote Now!</h2>
		<p><small>* required field</small></p>
		<form action="thanks.php" method="post" name="form" id="quote_form">
			<!-- jquery ui auto-complete for club -->
			<div class="ui-widget">
			<label for="club">Clubs*: </label>
			<input id="club" name="club">
			</div>
			<!-- jquery ui auto-complete for shaft -->
			<div class="ui-widget">
			<label for="shaft">Shafts*: </label>
			<input id="shaft" name="shaft">
			</div>
			<p><label>Quantity*: </label>
			<input type="text" id="quantity" name="quantity" /></p>
			<p><label>Full Name*: </label>
			<input type="text" id="customer" name="customer" /></p>
			<p><label>Email Address*: </label>
			<input type="text" id="email" name="email" /></p>
			<p><label>Comment: </label>
			<textarea name="comment" id="comment" rows="3" cols="34"></textarea></p>
			<input type="checkbox" id="subscribe" name="subscribe" value="yes" checked>Subscribe Newsletter
			<p><button type="submit" class="submit" value="submit">Get A Quote!</button></p>
		</form>
		<!-- display error or success message -->
		<p class="error" style="display:none;"></p>
		<div id="success" title="Request Success!"></div>
		<!--<div id="load_msgs" style="display:none;border-top: 1px solid #ccc;"></div>-->
	</div>
</div>

<?php include('includes/constant/footer.inc.php'); ?>