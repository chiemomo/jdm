<?php
/*FRONTEND Index.php*/
include 'includes/constant/config.inc.php';
session_start();
return_meta();
?>
	
<?php include('includes/constant/nav.inc.php'); ?>
	
<div id="navBreadCrumb">
	<img src="images/common/no-upcharge.png" width="1000" height="65" />
	<p class="small">*No up-charge for Miura and Epon irons only. Other custom options available and may incur additional upcharge. Ask us for details.</p>
</div>

<div class="jp_wrap100">
	<div class="left_box box_grey">
		<h1>FIND THE BEST JAPANESE GOLF CLUBS HERE!</h1>
		<p>At Fairway Golf, we are proud to bring you some of the best Japanese golf clubs available.  Brands like <i><b>Miura, Epon, Fourteen, Romaro, Yonex and Yururi</b></i> are world famous for high quality products. </p>
		<h3>4.26 | EPON Fitting/Demo Day at Fairway Golf San Diego</h3>
		<img src="images/common/epon-event.jpg" width="740" height="164" />
		<p><b>Get FREE 30min Private Fitting Session with a EPON Tachnician</b></p>
		<p>Experience the FEEL of EPON golf clubs from the world's premier forging house! EPON products are sold exclusively through a network of Authorized Dealer's who have been carefully selected to represent the brand based on the expertise and experience in custom club fitting. </p>
		<p><strong>CALL NOW for appointment to secure your spot!</strong></p>
		<p>Date: <strong>Saturday, April 26th, 2014</strong><br />
		Time:<strong> 11:00 AM to 4:00 PM</strong><br />
		Place: <strong>Fairway Golf Kearny Mesa Store</strong> (5040 Convoy Street, San Diego, CA 92111)<br />
		Appointment: Call at <strong>(858) 268-1702</strong></p>
	</div>
</div>


<!--<div class="colmask rightmenu">
	<div class="colleft">
		<div class="col1">
			<!-- Column 1 start -->
			
		<?php
/*				$content="";
			
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
*/			?>
			
			
			
		<!--</div>		<!-- Column 1 end -->

<div class="right_box" style="padding-top:0; margin-bottom:0">
	<!-- Column 2 start -->
	<?php include('includes/constant/right_column.inc1.php'); ?>
	<!-- Column 2 end -->
</div>

<div class="jp_about jp_wrap100">
	<h2>LEARN MORE ABOUT</h2>
	<ul>
		<li><a href="miura-golf-clubs.html"><img src="http://www.fairwaygolfusa.com/japan/images/home/miura-250x200.jpg" width="249" height="200" alt="Miura - Japanese golf clubs" /></a></li>
		<li><a href="epon-golf-clubs.html"><img src="http://www.fairwaygolfusa.com/japan/images/home/epon-250x200.jpg" width="249" height="200" alt="Epon - Japanese golf clubs" /></a></li>
		<li><a href="fourteen-golf-clubs.html"><img src="http://www.fairwaygolfusa.com/japan/images/home/fourteen-250x200.jpg" width="249" height="200" alt="Fourteen - Japanese golf clubs" /></a></li>
		<li><a href="yururi-golf-clubs.html"><img src="http://www.fairwaygolfusa.com/japan/images/home/yururi-250x200.jpg" width="249" height="200" alt="Yururi - Japanese golf clubs" /></a></li>
	</ul>
	<p style="color:#666">*All EPON and MIURA are sold as built from our facility. Head only sales are not available due to Manufacturer restrictions.</p>
</div>
		
		
<?php include('includes/constant/footer.inc.php'); ?>