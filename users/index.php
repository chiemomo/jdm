<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();

return_meta("Welcome to the secured user area " .$_SESSION['fullname'] . "!");
?>
</head>
<body>
<div id="container">

	<?php include '../includes/constant/nav.inc.php';
	?>

	<h1>Your name is <?php echo $_SESSION['fullname']; ?>!</h1>

	<p>Your user id is <?php echo $_SESSION['user_id']; ?></p>

	<p>Here is the information we store when a user logs in successfully:</p>

	<pre><?php print_r($_SESSION); ?></pre>

	<?php
	$s = mysql_query("SELECT * FROM ".USER_DETAILS." WHERE detail_user_id = '".$_SESSION['user_id']."'") or die(mysql_error());
	if(mysql_num_rows($s) != 0)
	{
		echo "<h1>The database has this to say...</h1>";
		while($r = mysql_fetch_array($s))
		{
			echo "<p>".nl2br($r['detail_notes'])."</p>";
			echo "<hr />";
		}
	}
	else
	{
		echo "<p>No details found.</p>";
	}
	?>

</div>
</body>
</html>