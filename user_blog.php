<?php
include 'includes/constant/config.inc.php';

return_meta("User Blog");

/*
//Listing of existing images in directory

	$media = get_images($file_location); //calls dir_tree function in constant.inc.php file
	
	print_r($media);
	
	$media_count = 0;

	if(!empty($media))
	{
		foreach($media as $media_disp)
		{
			$media_loc = htmlspecialchars($media_disp);
			list($width, $height, $type, $attr)= getimagesize($media_loc);

			$media_count++;
		}
	}
	else
	{
	}
*/
	
?>
</head>
<body>
<div id="container">

	<?php include 'includes/constant/nav.inc.php'; ?>

	<h1>Recent Blog Posts</h1>
	<p>See everyone's updates here.</p>

	<?php
	$s = mysql_query("SELECT ".USERS.".id, ".USERS.".user_name, ".USER_BLOG.".blog_id, ".USER_BLOG.".blog_title, ".USER_BLOG.".blog_entry, ".USER_BLOG.".image, ".USER_BLOG.".time_submitted FROM ".USERS." INNER JOIN ".USER_BLOG." ON ".USERS.".id=".USER_BLOG.".id ORDER BY time_submitted DESC;") or die(mysql_error());

echo $s;	

	if(mysql_num_rows($s) != 0)
	{
		echo "<table id='user_blog'>";
		echo "<tr>";
		echo "<th>Blog#</th>";
		echo "<th>User Name</th>";
		echo "<th>Blog Title</th>";
		echo "<th>Blog Entry</th>";
		echo "<th>Image</th>";
		echo "<th>Date</th>";
		echo "</tr>";
		
		while($r = mysql_fetch_array($s))
		{
			echo "<tr>";
			echo "<td>".($r['blog_id'])."</td>";
			echo "<td>".($r['user_name'])."</td>";
			echo "<td>".($r['blog_title'])."</td>";
			echo "<td>".($r['blog_entry'])."</td>";
//			echo "<td><img class=\"gridimg2\" src=\"".$media_disp."\" /></td>";
			echo "<td>".($r['image'])."</td>";
			echo "<td>".($r['time_submitted'])."</td>";
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