<?php
/*FRONTEND Index.php*/
include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
</head>
<body>
<div id="container">


<div id="header">

	<h1>The Title / Logo of the Webiste</h1>
	<h2>Some catchy sounding phrase</h2>
	
	<?php include('includes/constant/nav.inc.php'); ?>
	
</div>


<div class="colmask rightmenu">
	<div class="colleft">
		<div class="col1">
			<!-- Column 1 start -->
			
			<?php
				$content="";
			
				//use $_GET data to find out where we are
				if ( !$_GET ){ //if there is no $_GET data, we must be at the home area
					$content = "<p>Content Home</p>";
					
					//alternatively, include a seprate page here
					//include("content_home.php");
				}
				else {
					if ( isset($_GET['page']) ){
						$content = "<p>Content for page " . $_GET['page'] . "</p>";
						
						//alternatively, you may be include a page with the name $_GET['page'] . ".php"
						
						//$page_to_include = "content_" . $_GET['page'] . ".php";
						//include($page_to_include);
					}
				}
			
			
				echo $content;
			?>
			
			
			
			<!-- Column 1 end -->
		</div>
		<div class="col2">
			<!-- Column 2 start -->
			<?php include('includes/constant/right_column.inc.php'); ?>
			<!-- Column 2 end -->
		</div>
	</div>
</div>

<?php include('includes/constant/footer.inc.php'); ?>

</div>

</body>
</html>

