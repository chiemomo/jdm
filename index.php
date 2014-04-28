<?php
/*Index.php
	**Provides web visitors basic information, links to login and register pages
*/
include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
</head>
<body>
<div id="container">

	<?php include 'includes/constant/nav.inc.php'; ?>

	<h1>This is a secure user system!</h1>
	<p>Basic, yes.  Secure, yes.  Good looking, no.</p>

</div>
</body>
</html>

