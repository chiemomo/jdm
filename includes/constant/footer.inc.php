		<div class="jp_wrap100">&nbsp;</div> <!-- 100% width -->
		<div class="push"></div> <!-- necessary for sticky footer -->
	</div> <!-- close id="mainWrapper" -->
</div> <!-- close class="topWrapper" -->
<?php
if(!isset($_SESSION['user_id'])) //checks out true if nobody is logged in
{
?>
<div class="bar_bg">
	<div class="footer">
<ul>
<li>&nbsp;</li>
</ul>
	<p class="company_info"><?php echo $company_name; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $company_address; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $company_phone; ?></p>
	<p class="copy">&copy; Fairway Golf, Inc. All Rights Reserved.&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo SITE_BASE; ?>/login.php">Admin</a></p>
	</div>
</div>
<?php
}
else {
?>
<div class="footer footer_admin">
	<p class="copy">&copy; Fairway Golf, Inc. All Rights Reserved.&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo SITE_BASE; ?>/login.php">Admin</a></p>
</div>
<?php
}
?>
</body>
</html>