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

	$query_for_table = mysql_query("SELECT * FROM ".TABLE_PRODUCTS." ORDER BY club ASC;") or die(mysql_error());		

	//constant/config.inc.php line 393
	generate_html_table();
	
	?>


</div>
</body>
</html>