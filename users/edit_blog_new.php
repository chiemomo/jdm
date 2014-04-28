<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Edit your blog " .$_SESSION['fullname'] . "!");
$msg = NULL;
$date = date('Y-m-d H:i:s');

if(isset($_POST['update']))
{
	$in = mysql_query("UPDATE ".USER_BLOG." SET blog_title = '".filter($_POST['blogtitle'])."', blog_entry = '".filter($_POST['blogentry'])."', time_submitted = '".$date."' WHERE blog_id = '".($_POST['blogid'])."';") or die(mysql_error());

	if($update)
	{
		$msg = "Blog updated successfully!";
	}

}


?>
<script>
</script>
</head>
<body>
<div id="container">

	<?php include '../includes/constant/nav.inc.php'; ?>

	<h1>Hey <?php echo $_SESSION['fullname']; ?>!  Edit your blog!</h1>

	<?php
	if(isset($msg))
	{
		echo '<div class="success">'.$msg.'</div>';
	}

	$in = mysql_query("SELECT * FROM ".USER_BLOG." WHERE id = '".$_SESSION['user_id']."'") or die("Unable to get your info!");

//http://www.daveismyname.com/creating-a-blog-from-scratch-with-php-bp#.Uxgmt_ldWDA
//admin/edit-post.php
	$in->execute(array(':blog_id' => $_GET['id']));
	$row = $in->fetch(); 

	?>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="edit_blog">

	<table cellspacing="5" cellpadding="5" border="0">
	<tr>
	<td>Blog#</td>
	<td><input type="hidden" name="blogid" value="<?php echo $r['blog_id']; ?>" />
	</td>
	</tr>
	<tr>
	<td>Title</td>
	<td><input type="text" name="blogtitle" value="<?php echo $r['blog_title']; ?>" /></td>
	<tr>
	<td>Content</td>
	<td><textarea name="blogentry" cols="40" rows="6" value="" ><?php echo $r['blog_entry']; ?></textarea></td>
	</tr>
	<tr>
	<td>Date Posted</td>
	<td><?php echo $r['time_submitted']; ?></td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<input type="submit" name="update" value="Update Now" />
	</td>
	</tr>
	</table>

	</form>

</div>
</body>
</html>