<?php
require 'includes/constant/config.inc.php';

//Pre-assign our variables to avoid undefined indexes
$username = NULL;
$pass2 = NULL;
$msg = NULL;
$err = array();

//See if form was submitted, if so, execute...
if(isset($_POST['login']))
{

	//Assigning vars and sanitizing user input
	$username = filter($_POST['user']);
	$pass2 = filter($_POST['pass']);

	if(empty($username) || strlen($username) < 4)
	{
		$err[] = "You must enter a username";
	}
	if(empty($pass2) || strlen($pass2) < 4)
	{
		$err[] = "You seem to have forgotten your password.";
	}
	//Select only ONE password from the db table if the username = username, or the user input email (after being encrypted) matches an encrypted email in the db
	$q = mysql_query("SELECT usr_pwd, id FROM ".USERS." WHERE user_name = '$username' OR usr_email = AES_ENCRYPT('$username', '$salt')") or die(mysql_error());

	//Select only the password if a user matched
	
	
	list($pass, $userid) = mysql_fetch_row($q);
	//now the variable $pass holds the value in column usr_pwd, $userid holds the value for id

	if(empty($err))
	{
		//If someone was found, check to see if passwords match
		if(mysql_num_rows($q) > 0)
		{
			if(hash_pass($pass2) === $pass)
			{

				$user_info = mysql_query("SELECT id, full_name, user_name FROM ".USERS." WHERE id = '$userid' LIMIT 1") or die("Unable to get user info");
				list($id, $name, $username) = mysql_fetch_row($user_info);

				session_start();
				//REALLY start new session (wipes all prior data)
	   			session_regenerate_id(true);

				//update the timestamp and key for session verification
				$stamp = time();
				$ckey = generate_key();
				mysql_query("UPDATE ".USERS." SET ctime = '$stamp', ckey = '$ckey', num_logins = num_logins+1, last_login = now() WHERE id='$id'") or die(mysql_error());

				//Assign session variables to information specific to user
				$_SESSION['user_id'] = $id;
				$_SESSION['fullname'] = $name;
				$_SESSION['user_name'] = $username;
				$_SESSION['user_level'] = $level;
				$_SESSION['stamp'] = $stamp;
				$_SESSION['key'] = $ckey;
				$_SESSION['logged'] = true;
				
				//And some added encryption for session security
				$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

				//Build a message for display where we want it
				$msg = "Logged in successfully!";

				//redirect to a new location
				header("Location: ".SITE_BASE."/admin");
			} //end passwords matched
			else
			{
				//Passwords don't match, issue an error
				$err[] = "Invalid User or Password";
			}
		} //end if user found
		else
		{
			//No rows found in DB matching username or email, issue error
			$err[] = "This user was not found in the database.";
		}
	} //end if no error
}  //end form posted

return_meta("Administrator Login");
?>

<?php include 'includes/constant/nav.inc.php'; ?>

	<?php
	//Show message if isset
	if(isset($msg) || !empty($_GET['msg']))
	{
		if(!empty($_GET['msg']))
		{
			$msg = $_GET['msg'];
		}
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

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login_form" class="admin_form">
<table cellpadding="5" cellspacing="5" border="0">
	<tr>
	<td>Username:</td>
	<td><input type="text" name="user" value="" class="required" /></td>
	</tr>
	<td>Password:</td>
	<td><input type="password" name="pass" value="" class="required" /></td>
	</tr>
	<tr>
	<td colspan="2" align="center"><input type="submit" name="login" value="Login" class="button orange" /></td>
	</tr>
</table>
</form>

<?php include('includes/constant/footer.inc.php'); ?>