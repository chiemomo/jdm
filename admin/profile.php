<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Edit " .$_SESSION['fullname'] . "'s Profile");
$msg = NULL;

if(isset($_POST['update']))
{
	$update = "UPDATE ".USERS." SET full_name = '".filter($_POST['fullname'])."', user_name = '".filter($_POST['username'])."', usr_email = AES_ENCRYPT('".filter($_POST['email'])."', '$salt')";

	if(!empty($_POST['newpass']))
	{
		$update .= ", usr_pwd = '".hash_pass(filter($_POST['newpass']))."'";
	}

	$update .= " WHERE id = '".$_SESSION['user_id']."'";

	$run_update = mysql_query($update) or die(mysql_error());

	if($run_update)
	{
		$msg = "Profile updated successfully!";
	}

}
?>

<?php include '../includes/constant/nav.inc.php'; ?>

<h1>Edit My Profile</h1>

<?php
if(isset($msg))
{
	echo '<div class="success">'.$msg.'</div>';
}

$in = mysql_query("SELECT *, AES_DECRYPT(usr_email, '$salt') AS email FROM ".USERS." WHERE id = '".$_SESSION['user_id']."'") or die("Unable to get your info!");

while($r = mysql_fetch_array($in))
{
?>

<?php
//print_r($_SESSION);
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="profile_form" class="admin_form" >
<table cellspacing="5" cellpadding="5" border="0">
	<tr>
		<td>Name</td>
		<td><input type="text" name="fullname" value="<?php echo $r['full_name']; ?>" /></td>
	</tr>
	<tr>
		<td>Username</td>
		<td><input type="text" name="username" value="<?php echo $r['user_name']; ?>" /></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="text" name="email" value="<?php echo $r['email']; ?>" /></td>
	</tr>
	<tr>
		<td>New Password</td>
		<td><input type="password" name="newpass" /></td>
	</tr>
	<tr>
		<td>Login Information:</td>
		<td>Last login: <?php echo $r['last_login']; ?><br>Total number of logins: <?php echo $r['num_logins']; ?></td>
	</tr>
	<tr>
		<td colspan="2">
		<input type="submit" name="update" value="Update Profile" class="button green" />
		</td>
	</tr>
</table>
</form>

<?php
}

include('../includes/constant/footer.inc.php'); ?>