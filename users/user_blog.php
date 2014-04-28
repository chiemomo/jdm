<?php
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("User blog including " .$_SESSION['fullname'] . "'s blog!");

?>
</head>
<body>
<div id="container">

	<?php include '../includes/constant/nav.inc.php'; ?>

	<h1>Recent Blog Posts</h1>
	<p>See everyone's updates here.</p>

	<?php
	$s = mysql_query("SELECT ".USERS.".id, ".USERS.".user_name, ".USER_BLOG.".blog_id, ".USER_BLOG.".blog_title, ".USER_BLOG.".blog_entry, ".USER_BLOG.".image, ".USER_BLOG.".time_submitted FROM ".USERS." INNER JOIN ".USER_BLOG." ON ".USERS.".id=".USER_BLOG.".id ORDER BY time_submitted DESC;") or die(mysql_error());		

	if(mysql_num_rows($s) != 0)
	{
		echo "<table id='user_blog'>";
		echo "<tr>";
		echo "<th>Blog#</th>";
		echo "<th>User Name</th>";
		echo "<th>Blog Title</th>";
		echo "<th>Blog Entry</th>";
		echo "<th>Image</th>";
		echo "<th>Date Submitted</th>";
		echo "<th>Edit</th>";
		echo "</tr>";
		
		while($r = mysql_fetch_array($s))
		{	
			echo "<tr>";
			echo "<td>".($r['blog_id'])."</td>";
			echo "<td>".($r['user_name'])."</td>";
			echo "<td>".($r['blog_title'])."</td>";
			echo "<td>".($r['blog_entry'])."</td>";
			echo "<td>".($r['image'])."</td>";
			echo "<td>".($r['time_submitted'])."</td>";
			if($_SESSION['user_id'] == $r['id']) {
				echo "<td><a href='edit_blog.php'>edit my blog</td>";
			}
			else
			{
				echo "<td></td>";
			}
			echo "</tr>";
		}
	}
	else
	{
		echo "<p>No blog post found.</p>";
	}
	
		echo "</table>";

	?>


</div>
</body>
</html>