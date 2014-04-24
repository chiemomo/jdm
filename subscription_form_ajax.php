<?php
include 'includes/constants/dbc.php';

//Check for post data
if($_POST and $_GET)
{
	if ($_GET['cmd'] == 'add'){
	
		//Assign variables and sanitize POST data
		$customer = mysql_real_escape_string($_POST['customer']);
		$email = mysql_real_escape_string($_POST['email']);
		$club = mysql_real_escape_string($_POST['club']);
		$shaft = mysql_real_escape_string($_POST['shaft']);
		$subscribe = $_POST['subscribe'];
	 
		//Build our query statement
		$query = "INSERT INTO ".TABLE_INQUIRIES."(customer, email, club, shaft, subscribe, time) VALUES ('".$customer."', '".$email."', '".$club."', '".$shaft."', '".$subscribe."', now());";
		mysql_query($query) or die(mysql_error());
		
		//After the $_POST data is processed, we use the exit() function because we don't need to actually show the page as the request is made in the background
		exit();
	}
}

?>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Subscription Form with AJAX</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<link rel="stylesheet" href="css/jdm.css">
<script>
//Form processing function start
$(function()
{

	/* AUTO-COMPLETION for CLUBs - define an array holding the strings that will be used for auto-completion in the club field. */
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

	/* AUTO-COMPLETION for SHAFTs - define an array holding the strings that will be used for auto-completion in the shaft field. */
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

	//SUBMIT form
	$(".submit").click(function()
    {
        
		//create variables to store the data entered into the form
		var customer = $("#customer").val();
        var email = $("#email").val();     
        var club = $("#club").val();     
        var shaft = $("#shaft").val();
        var subscribe = $("#subscribe").val();
		
		if(document.getElementById("subscribe").checked){
			document.getElementById("subscribeHidden").disabled = true;
		}
		
        //Check for empty values
        if(customer == '' || email == '' || club == '' || shaft == '')
        {
			//show the html error message where div.error if there is empty field
			$('.error').fadeIn(400).show().html('Please fill required fields.'); 
        }
        else
        {
			//construct the data string to insert the table	
			var datastring = "customer=" + customer + "&email=" + email + "&club=" + club + "&shaft=" + shaft +"&subscribe=" + subscribe;
 
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
						$('.success').fadeIn(2000).show().html('Thanks ' +customer + ', your request has been submitted successfully!').fadeOut(6000); //Show, then hide success msg
						$('.error').fadeOut(2000).hide(); //If showing error, fade out
						
						//every time user submit information, it load all the messages and show them
						//$("#load_msgs").fadeIn(400).show().load('get_msg.php');
		 
					}
				}
			);
        }
		
		//return false to prevent reloading page
        return false;
    });

	$( "input[type=submit], button" )
		.button()
		.click(function( event ) {
		event.preventDefault();
	});
});
</script>
</head>
<body>
<div class="container">
<form method="post" name="form" id="form">
 
<div class="ui-widget">
	<label for="club">Clubs: </label>
	<input id="club">
</div>

<div class="ui-widget">
	<label for="shaft">Shafts: </label>
	<input id="shaft">
</div>

<p><label>Full Name: </label>
<input type="text" id="customer" name="customer" /></p>

<p><label>Email Address: </label>
<input type="text" id="email" name="email" /></p>

<input type="checkbox" id="subscribe" name="subscribe" value="yes" checked>Subscribe Newsletter
<input type="hidden" id="subscribeHidden" name="subscribeHidden" value="no">

<p><button type="submit" class="submit" value="submit">Get A Quote!</button></p>

 </form>

<p>
<span class="success" style="display:none;"></span>
<span class="error" style="display:none;"></span>
</p>


<div id="load_msgs" style="display:none;border-top: 1px solid #ccc;"></div>

</div>
</body>
</html>
