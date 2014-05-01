<?php
/*nav.inc.php*/
$frontend_pages = array("Home","Get A Quote","About");
$frontend_links = array("index.php","quote_form.php","about.php");

$admin_pages = array("Home","Clubs","Shafts","Inquiries","Import","Profile","Add Users","Logout");
$admin_links = array("index.php","list_club.php","list_shaft.php","list_inquiry.php","import.php","profile.php","register.php","logout.php");
?>
<div class="nav">
	<ul>
		
		<?php

		if(!isset($_SESSION['user_id'])) //checks out true if nobody is logged in
		{
			for ($i = 0; $i < count($frontend_pages); $i++){
				if(!strpos($_SERVER['SCRIPT_NAME'], $frontend_links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $frontend_links[$i]) { 
				$class = "active";
			}
		else
			$class = "";

		?>
			<li><a href="<?php echo $frontend_links[$i];?>" class="<?php echo $class;?>"><?php echo $frontend_pages[$i];?></a></li>
		<?php

			}
		}
		else	//else, a user must be logged in so we show them some different options
		{
			for ($i = 0; $i < count($admin_pages); $i++){
				//if(!strpos($_SERVER['SCRIPT_NAME'], "/users/".$admin_links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $admin_links[$i]) { 
				if(!strpos($_SERVER['SCRIPT_NAME'], "/admin/".$admin_links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $admin_links[$i]) { 
				$class = "active";
			}
		else
			$class = "";
	
		?>
			<li><a href="<?php echo $admin_links[$i];?>" class="<?php echo $class;?>"><?php echo $admin_pages[$i];?></a></li>
		<?php

			}
		}
		?>
				
	</ul>
	<p id="layoutdims"></p>
</div>
