<?php
require '../includes/constant/config.inc.php';
secure_page();
$meta_title = "Add Admin Users";

$msg = NULL;
$err = array();

if(isset($_POST['add']))
{
	//filter is defined config.inc.php, line 258
	$fullname = filter($_POST['fullname']);
	$username = filter($_POST['username']);
	$password = filter($_POST['password']);
	$email = filter($_POST['email']);
	$date = date('Y-m-d');
	$user_ip = $_SERVER['REMOTE_ADDR'];
	$activation_code = rand(1000,9999);
	
	//define in config.inc.php, line 39
	$err = add_user($fullname, $username, $password, $email, $date, $user_ip, $activation_code);

	//if there are no errors, set $msg to "Registration Successfull" - later on, it is displayed on the page
	if ( count($err) == 0){
		$msg = "Registration successful!";
		$meta_title = "Registration successful!";
	}
	
}

return_meta($meta_title);
?>

<?php include '../includes/constant/nav.inc.php'; ?>

<h1>Add Admin Users</h1>

<?php
//Show message if isset
if(isset($msg))
{
	echo '<div class="success">'.$msg.'</div>';
}
//Show error message if isset
if(!empty($err)) 
{
	echo '<div class="err">';
	foreach($err as $e)
	{
		echo $e.'<br />';
	}
	echo '</div>';
}
?>

<!-- If the user just registered, we will not display the form. Instead, we offer them a link to log in -->
<?php //enter PHP mode and start an if-statement
if (isset($msg)) { ?> 

	<!-- we're now back in HTML mode but the HTML code will only appear if the condition in the if-statement was true -->
	<p class="admin_form"><b>You may now <a href = "../login.php">log in</a>!</b></p>

<?php //now we enter PHP mode again to close the curly bracket and add the 'else'
} 
else { //if isset($msg) returns false, then we are here -- now we just show the form as before
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register_form" class="admin_form">
<table cellspacing="5" cellpadding="5" border="0">
	<tr>
		<td>Name</td>
		<td><input type="text" name="fullname" value="" class="required" /></td>
	</tr>
	<tr>
		<td>User Name</td>
		<td><input type="text" name="username" value="" class="required" /></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="text" name="email" value="" class="required email" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password" value="" class="required" /></td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="submit" name="add" value="Register" class="button green" />
		</td>
	</tr>
</table>
</form>

<?php 
}
?>

<?php include('../includes/constant/footer.inc.php'); ?>