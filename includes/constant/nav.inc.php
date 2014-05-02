<?php
/*nav.inc.php*/
$frontend_pages = array("Home","Get A Quote","About");
$frontend_links = array("index.php","quote_form.php","about.php");

$admin_pages = array("Home","Inquiries","Clubs","Shafts","Import","Edit Profile","Add Users");
$admin_links = array("index.php","list_inquiry.php","list_club.php","list_shaft.php","import.php","profile.php","register.php");
?>

</head>
<body>
<div class="topWrapper"> 

<?php
if(!isset($_SESSION['user_id'])) //checks out true if nobody is logged in
{
?>

<div class="htag bar_bg">Questions? Ask Our Customer Service Now! <a href="mailto:<?php echo $company_email; ?>">Email Us</a> or Call <?php echo $company_phone; ?></div>
<div id="mainWrapper">
	<div class="header">
		<div class="logo"><a href="<?php echo SITE_BASE; ?>"><img src="<?php echo SITE_BASE; ?>/images/common/sprite.gif" alt="Fairway Golf Pro Shop, San Diego, California - Huge inventory, Scotty Cameron Putters, High quality Japanese golf clubs, Tour Golf Clubs and more!!" width="1" height="1" /></a></div>
		<div class="header_r"><p>Established in 1991 in San Diego, California.<br />A provider of the best golf equipment with the best service.</p></div>
	</div>
	<div class="nav">
		<ul>
		<?php
		for ($i = 0; $i < count($frontend_pages); $i++) {
			if(!strpos($_SERVER['SCRIPT_NAME'], $frontend_links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $frontend_links[$i]) { 
				$class = "active";
			}
			else
				$class = "";
		?>
		<li><a href="<?php echo $frontend_links[$i];?>" class="<?php echo $class;?>"><?php echo $frontend_pages[$i];?></a></li>
		<?php
		}
		?>					
		</ul>
	</div>		

<?php
}
else	//else, a user must be logged in so we show them some different options
{
?>

<div id="mainWrapper">
	<div class="header">
		<div class="logo"><a href="<?php echo SITE_BASE."/admin"; ?>"><img src="<?php echo SITE_BASE; ?>/images/common/sprite.gif" alt="Fairway Golf Pro Shop, San Diego, California - Huge inventory, Scotty Cameron Putters, High quality Japanese golf clubs, Tour Golf Clubs and more!!" width="1" height="1" /></a></div>
		<div class="header_r"><p><b>Hi <?php echo $_SESSION['fullname']; ?>!</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo SITE_BASE."/admin/logout.php"; ?>" class="bar_bg logout">LOGOUT</a></p></div>
	</div>
	<div class="nav">
		<ul>
		<?php
		for ($i = 0; $i < count($admin_pages); $i++) {
			if(!strpos($_SERVER['SCRIPT_NAME'], "/admin/".$admin_links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $admin_links[$i]) { 
				$class = "active";
			}
			else
				$class = "";
		?>
		<li><a href="<?php echo $admin_links[$i];?>" class="<?php echo $class;?>"><?php echo $admin_pages[$i];?></a></li>
		<?php
		}
		?>
	</ul>
</div>		

<?php
}
?>
<!--
<div id="navBreadCrumb">
<?php
/*$crumbs = explode("/",$_SERVER["REQUEST_URI"]);
foreach($crumbs as $crumb){
    echo ucfirst(str_replace(array(".php","_"),array(""," "),$crumb) . ' ');
}*/
?>
</div>
-->
