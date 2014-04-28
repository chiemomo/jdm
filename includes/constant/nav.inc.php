<?php
/*nav.inc.php*/
?>
	<div class="nav">
		<ul>
			
			<!-- SITE HOME link -->
			<li
			<?php 
			
				//checks if the current page matches the string '/users/index.php'
				//strpos — Find the position of the first occurrence of a substring in a string
				//print_r($_SERVER);
				if(!strpos($_SERVER['SCRIPT_NAME'], '/users/index.php') and basename($_SERVER['SCRIPT_NAME']) == 'index.php') { echo "class=\"current\""; }
			?> >
			
			<a href="<?php echo SITE_BASE; ?>">Site Home</a>
			</li>
			

			<?php if(!isset($_SESSION['user_id'])) //checks out true if nobody is logged in
			{
			?>
				<!-- REGISTER link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'register.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/register.php">Register</a></li>
				
				<!-- LOGIN link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'login.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/login.php">Login</a></li>

				<!-- USER BLOG link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'user_blog.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/user_blog.php">User Blog</a></li>
				
				<!-- QUOTE FORM link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'quote_form.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/quote_form.php">Get A Quote</a></li>

			<?php
			}
			else	//else, a user must be logged in so we show them some different options
			{
			?>
				
				<!-- SECURE HOME link -->
				<li <?php if(strpos($_SERVER['SCRIPT_NAME'], 'users/index.php')) { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/">Secure Home</a></li>
				
				<!-- USER PROFILE link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'profile.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/profile.php">User Profile</a></li>
					
			<?php
			if(is_admin()) {
			?>

				<!-- MANAGE USERS link: only available to administrators -->
				<li <?php if(strpos($_SERVER['SCRIPT_NAME'], 'users/admin.php')) { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/admin.php">Manage Users</a></li>

			<?php
			} 
			?>
								
				<!-- MY BLOG link -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'my_blog.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/my_blog.php">My Blog</a></li>

				<!-- USER BLOG link for logged in users -->
				<li <?php if(basename($_SERVER['SCRIPT_NAME']) == 'user_blog.php') { ?>class="current"<?php } ?>><a href="<?php echo SITE_BASE; ?>/users/user_blog.php">User Blog</a></li>

				<!-- LOGOUT link -->
				<li><a href="<?php echo SITE_BASE; ?>/logout.php">Logout</a></li>
				<?php
			}
			?>
		</ul>
	</div>
