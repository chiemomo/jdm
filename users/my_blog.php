<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Write your blog " .$_SESSION['fullname'] . "!");

$blogtitle = NULL;
$blogentry = NULL;
$userid = $_SESSION['user_id'];

$msg = NULL;
$err = array();

if(isset($_POST['postblog']))
{ 
	//filter is defined config.inc.php, line 258
	$blogtitle = filter($_POST['blogtitle']);
	$blogentry = filter($_POST['blogentry']);
	$date = date('Y-m-d H:i:s');
	
	$err = array();
	
	if(empty($blogtitle) || strlen($blogentry) < 2)
	{
		$err[] = "You must enter blog title";
	}
	
	if(empty($blogentry) || strlen($blogentry) < 4)
	{
		$err[] = "You must enter blog entry";
	}
	
	$q2 = mysql_query("INSERT INTO ".USER_BLOG." (id, blog_title, blog_entry, time_submitted) VALUES ('$userid', '$blogtitle', '$blogentry', '$date')", $link) or die("Unable to insert data");

	//if there are no errors, set $msg to "post successful!" - later on, it is displayed on the page
	if ( count($err) == 0){
		$msg = "Blog Post Successful!";
		$meta_title = "Blog Post Successful!";
	}
	
}

?>
<script>
</script>
</head>
<body>
<div id="container">

	<?php include '../includes/constant/nav.inc.php'; ?>

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

	<h1>Hey <?php echo $_SESSION['fullname']; ?>!  Write your blog here!</h1>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="blogposted">
	<table cellspacing="5" cellpadding="5" border="0">
	<tr>
	<td>Title</td>
	<td><input type="text" name="blogtitle" /></td>
	<tr>
	<td>Content</td>
	<td><textarea name="blogentry" cols="40" rows="6" ></textarea></td>
	</tr>
	<tr>
	<td colspan="2" align="center">
		<input type="submit" name="postblog" value="Post Now" />
	</td>
	</tr>
	</table>
	</form>

</div>
</body>
</html>