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

	<h1>Registered Shafts</h1>
	<p>Click "Edit" to edit the shaft data.</p>

	<?php

	$query_for_table = mysql_query("SELECT * FROM ".TABLE_SHAFTS." ORDER BY shaft ASC;") or die(mysql_error());		

	//constant/config.inc.php line 393
	generate_html_table();
	
	?>


</div>
</body>
</html>