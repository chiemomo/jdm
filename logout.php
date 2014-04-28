<?php
/*Logout.php*/
require 'includes/constant/config.inc.php';
$message = urlencode("You have logged out successfully");
logout($message);