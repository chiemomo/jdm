<?php
//JDM

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//SQL credentials
define ("DB_HOST", "localhost");
define ("DB_USER", "hci573");
define ("DB_PASS", "hci573");
define ("DB_NAME", "hci573");

//tables
define ("TABLE_PRODUCTS", "products_jdm_chie");
define ("TABLE_SHAFTS", "shafts_jdm_chie");
define ("TABLE_INQUIRIES", "inquiries_jdm_chie");
define ("USERS", "users_jdm_chie");
define ("USER_DETAILS", "user_details_jdm_chie");
define ("USER_BLOG", "user_blog_jdm_chie");

//connect to the SQL database
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

//site base
define ("SITE_BASE", "http://".$_SERVER['HTTP_HOST']."/jdm");
define ("SITE_ROOT", $_SERVER['DOCUMENT_ROOT']."/jdm");

//email to use for verification
define ("GLOBAL_EMAIL", "notused@gmail.com");
define ("REQUIRE_ACTIVIATION",false); //keep this as false

//keys (ideally, those would be stored on a separate machine or server)
$salt = "ae4bca65f3283fe26a6d3b10b85c3a308";
global $salt;

$passsalt = "f576c07dbe00e8f07d463bc14dede9e492";
global $passsalt;

$password_store_key = sha1("dsf4dgfd5s2");
global $password_store_key;

/********************/
/**** FUNCTIONS *****/
/********************/

/*Function to add a new user to the system */
function add_user($fullname, $username, $password, $email, $date, $user_ip, $activation_code){
	
	//declaring $salt and $link as global allows the function to access the values stored in these variables
	global $salt;
	global $link;
	global $password_store_key;
	
	$err = array();
	
	//here we validate that the user submitted all fields
	//php function 'strlen' — Get string length
	if(empty($fullname) || strlen($fullname) < 4)
	{
		$err[] = "You must enter your name";
	}
	
	if(empty($username) || strlen($username) < 4)
	{
		$err[] = "You must enter a username";
	}
	
	if(empty($password) || strlen($password) < 4)
	{
		$err[] = "You must enter a password";
	}
	
	if(empty($email) || !check_email($email)) //check_email - custom function on line 302
	{
		$err[] = "Please enter a valid email address.";
	}
	
	

	$q = mysql_query("SELECT user_name, usr_email FROM ".USERS." WHERE user_name = '$username' OR usr_email = AES_ENCRYPT('$email', '$salt')");
	if(mysql_num_rows($q) > 0)
	{
		$err[] = "User already exists";
	}

	if(empty($err))
	{
		//the function hash_pass is defined in config.inc.php, line 312
		$password = hash_pass($password);

		$q1 = mysql_query("INSERT INTO ".USERS." (full_name, user_name, usr_pwd, usr_email, date, users_ip, activation_code) VALUES ('$fullname', '$username', '$password', AES_ENCRYPT('$email', '$salt'), '$date', '$user_ip', '$activation_code')", $link) or die("Unable to insert data");

		//Generate rough hash based on user id from above insertion statement
		$user_id = mysql_insert_id($link); //get the id of the last inserted item
		$md5_id = md5($user_id);
		mysql_query("UPDATE ".USERS." SET md5_id='$md5_id' WHERE id='$user_id'");

		if (REQUIRE_ACTIVIATION){
		
			//set the approve flag to 0
			$rs_activ = mysql_query("UPDATE ".USERS." SET approved='0' WHERE
				md5_id='". $md5_id. "' AND activation_code = '" . $activation_code ."' ") or die(mysql_error());
		
			//send an email with the activation key
			
			//first, retrieve my encrypted password
			$key = $password_store_key;
			$result = mysql_query("SELECT * , AES_DECRYPT(password, '$key') AS password FROM ". PSTORE_TABLE ." WHERE username=AES_ENCRYPT('".GLOBAL_EMAIL."', '$key')") or die(mysql_error());
			$row = mysql_fetch_assoc($result);
			$pw = $row['password'];
			
			//generate the message
			$message = "Hi ".$fullname."!\n
				Thank you for registering with us. Here are your login details...

				User ID: ".$username."\n
				Email: ".$email."\n
				Password: ".$_POST['password']."\n\n

				You must activate your account before you can actually do anything:\n
				".SITE_BASE."/users/activate.php?user=".$md5_id."&activ_code=".$activation_code."\n\n\n

				Thank You,\n

				Administrator\n
				".SITE_BASE."";
			
			
			//next, we use swift's email function
			$email_to = $email; $email_from=GLOBAL_EMAIL;$password = $pw; $subj = "Registration successful!";
			$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
			  ->setUsername($email_to)
			  ->setPassword($password);

			$mailer = Swift_Mailer::newInstance($transport);

			$message = Swift_Message::newInstance($subj)
			  ->setFrom(array($email_from => 'Jivko Sinapov'))
			  ->setTo(array($email_to))
			  ->setBody($message);

			$result = $mailer->send($message);
	
		}
		else {
			//activate user by default
			// set the approved field to 1 to activate the account
			$rs_activ = mysql_query("UPDATE ".USERS." SET approved='1' WHERE
				md5_id='". $md5_id. "' AND activation_code = '" . $activation_code ."' ") or die(mysql_error());
		}
	}

	
	
	
	return $err;
}

/*Function to secure pages and check users*/
function secure_page()
{
	session_start();
	global $db;

	//Secure against Session Hijacking by checking user agent
	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		//Make sure values match!
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']) or $_SESSION['logged'] != true)
		{
			logout();
			exit;
		}

		//We can only check the DB IF the session has specified a user id
		if(isset($_SESSION['user_id']))
		{
			$details = mysql_query("SELECT ckey, ctime FROM ".USERS." WHERE id ='".$_SESSION['user_id']."'") or die(mysql_error());
			list($ckey, $ctime) = mysql_fetch_row($details);

			//We know that we've declared the variables below, so if they aren't set, or don't match the DB values, force exit
			if(!isset($_SESSION['stamp']) && $_SESSION['stamp'] != $ctime || !isset($_SESSION['key']) && $_SESSION['key'] != $ckey)
			{
				logout();
				exit;
			}
		}
	}
	//if we get to this, then the $_SESSION['HTTP_USER_AGENT'] was not set and the user cannot be validated
	else
	{
		logout();
		exit;
	}
}

/*Function to logout users securely*/
function logout($lm = NULL)
{
	if(!isset($_SESSION))
	{
		session_start();
	}

	//If the user is 'partially' set for some reason, we'll want to unset the db session vars
	if(isset($_SESSION['user_id']))
	{
		global $db;
		mysql_query("UPDATE ".USERS." SET ckey= '', ctime= '' WHERE id='".$_SESSION['user_id']."'") or die(mysql_error());
		unset($_SESSION['user_id']);
	}
		
	unset($_SESSION['user_name']);
	unset($_SESSION['user_level']);
	unset($_SESSION['HTTP_USER_AGENT']);
	unset($_SESSION['stamp']);
	unset($_SESSION['key']);
	unset($_SESSION['fullname']);
	unset($_SESSION['logged']);
	session_unset();
	session_destroy();

	if(isset($lm))
	{
		header("Location: ".SITE_BASE."/users/login.php?msg=".$lm);
	}
	else
	{
		header("Location: ".SITE_BASE."/users/login.php");
	}
}

/*Function to checks if the person logged in has admin rights using the session data*/
function is_admin()
{
	if(isset($_SESSION['user_level']) && $_SESSION['user_level'] >= 5)
	{
		return 1;
	}
	else
	{
		return 0 ;
	}
}

/*Function to generate key for login.php*/
function generate_key($length = 7)
{
	$password = "";
	$possible = "0123456789abcdefghijkmnopqrstuvwxyz";

	$i = 0;
	while ($i < $length)
	{
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($password, $char))
		{
			$password .= $char;
			$i++;
		}
	}
	return $password;
}

/*Function to super sanitize anything going near the DBs*/
function filter($data)
{
	$data = trim(htmlentities(strip_tags($data)));

	if (get_magic_quotes_gpc())
	{
		$data = stripslashes($data);
	}

	$data = mysql_real_escape_string($data);
	return $data;
}

/*Function to easily output all of the css, js, etc...*/
function return_meta($title = NULL, $keywords = NULL, $description = NULL)
{
	if(is_null($title))
	{
		$title = "JDM Golf Clubs";
	}

	$meta = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>'.$title.'</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="keywords" content="'.$keywords.'" />
				<meta name="description" content="'.$description.'" />
				<meta name="language" content="en-us" />
				<meta name="robots" content="index,follow" />
				<meta name="googlebot" content="index,follow" />
				<meta name="msnbot" content="index,follow" />
				<meta name="revisit-after" content="7 Days" />
				<meta name="url" content="'.SITE_BASE.'" />
				<meta name="copyright" content="Copyright '.date("Y").' Your site name here. All rights reserved." />
				<meta name="author" content="Your site name here" />
				<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
				<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
				<script src="//code.jquery.com/jquery-1.10.2.js"></script>
				<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
				<link rel="stylesheet" type="text/css" media="all" href="'.SITE_BASE.'/includes/styles/styles.css" />

			';

	echo $meta;
}

/*Function to validate email addresses*/
function check_email($email)
{
	return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

/*Function to update user details*/
function hash_pass($pass)
{
	global $passsalt;
	$hashed = md5(sha1($pass));
	$hashed = crypt($hashed, $passsalt);
	$hashed = sha1(md5($hashed));
	return $hashed;
}

/*Function to store images in a DB*/
$file_location = "images";
global $file_location;

function store_image($tmp_filename){
	global $link;
	
	// Read the file
	$fp = fopen($tmp_filename, 'r'); //creates a handle to the file, open $tmp_filename for 'r' = reading
	$data = fread($fp, filesize($tmp_filename)); //reads the actual data, read all data from the file
	$data = addslashes($data); //prepare the data to be stored in an SQL table
	fclose($fp); //close the file handle, to save memory

	// Create the query and insert
	// into our database.
	$query = "INSERT INTO " . USER_BLOG . " (image) VALUES ('$data');";
	$result = mysql_query($query, $link) or die (mysql_error());
}

/*Function to return all images in the path*/
function get_images($path){

	//initialize an empty array to hold the result
	$results = array();

	//open the directory
	$handle = opendir($path);
	
	while (true){
		$current_file = readdir($handle); //get the name of the next file in the directory
		
		//echo "Next file:" . $current_file . "<br>";
		
		//if there is a next file
		if ($current_file) {
		
			//construct the full path of the file relative to the base of the directory
			$full_relative_path = $path."/".$current_file;
		
			if (is_file($full_relative_path) and 
				( substr($current_file, -3) == "png" or 
				substr($current_file, -3) == "jpg" or
				substr($current_file, -3) == "gif" or
				substr($current_file, -3) == "mp4" or 
				substr($current_file, -3) == "wmv" or
				substr($current_file, -3) == "mov" or 
				substr($current_file, -3) == "flv" ) )
				{
					$results[]=$full_relative_path;
				}
		}
		else
			break;
	}

	return $results;
}

/*Function to generate HTML table from MySQL tables*/
//http://davidwalsh.name/html-mysql-php
//http://www.php.net/manual/en/function.mysql-field-name.php
//http://www.php.net/manual/en/function.mysql-num-fields.php

$query_for_table = "";

function generate_html_table() {
	
		global $query_for_table;
	
		echo '<table class="db_table">';
		echo '<tr>';
		//for field names
		for ($i = 0; $i < mysql_num_fields($query_for_table); $i++) {
			echo "<th>" . mysql_field_name($query_for_table, $i) . "</th>";
		}
		echo "<th>Edit</th>";	
		echo '</tr>';
		//for values
		while($row = mysql_fetch_row($query_for_table)) {
			echo '<tr>';
			foreach($row as $key=>$value) {
				echo '<td>',$value,'</td>';
			}
			//to edit the row
			echo "<td><a href='edit_blog.php'>edit</td>";
			echo '</tr>';
		}
		echo '</table><br />';
	}

/*Function to return an array holding all club in the product table*/
function get_club(){

	//pull out club data with ascending order
	$query = "SELECT club FROM " . TABLE_PRODUCTS . " ORDER BY club ASC;";
	$result = mysql_query($query) or die(mysql_error());
	
	//define an array to hold the string
	$club = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		//when there is no more data row, break the while loop
		if (!$row)
			break;
		
		//sanitize the string and put every data in the rows into club array
		$club[] = str_replace("\r","",$row['club']);
	}
	
	return $club;

}

/*Function to return an array holding all shaft in the shaft table*/
function get_shaft(){

	//pull shaft data from the shaft table with ascending order
	$query="SELECT shaft FROM " . TABLE_SHAFTS . " ORDER BY shaft ASC;";
	$result = mysql_query($query) or die(mysql_error());
	
	//define an array to hold shaft data
	$shaft = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		//when there is no more row, break the while loop
		if (!$row)
			break;
		
		//sanitize the string
		$shaft[] = str_replace("\r","",$row['shaft']);
	}
	
	return $shaft;

}

/*Function to load product data from the product table and wrap around them with HTML*/
function load_product_details()
{
    //the variable $build holds the HTML content that is generated by the function
	$build = '';
	
	//set up a query and execute it
	//pull out necessary data from the table and sort descending by product name
	$query = "SELECT product_id, club, details FROM ".TABLE_PRODUCTS." ORDER BY club ASC"; 
    $result = mysql_query($query) or die(mysql_error());
    
	if(mysql_num_rows($result) == 0)
    {
		//if there is no data returned, show below message
		$build .= "<p><b>No product found.</b></p>";
    }
    else
    {
        while($row = mysql_fetch_array($result))
        {
			//wrap the entry by HTML
            $build .= "<h3 class=\"product_title\">".$row['club']."</h3>";
			$build .= "<div>";
            $build .= "<p class=\"product_image\"><img src=\"images/".$row['product_id'].".jpg\" align=\"left\" hspace=\"10\" /></p>";
            $build .= "<p class=\"product_details\"><b>Details: </b><br>".$row['details']."</p>"; 		
            $build .= "</div>";
        }
    }
    return $build;
}

//Function to send an email (Swift)
function send_email($email_to, $content, $subject){

	global $username;
	global $email_password;
	global $email_from;
	global $from_name;

	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl");
	$transport->setUsername($username);
	$transport->setPassword($email_password);

	//create the mailer object which will send the email
	$mailer = Swift_Mailer::newInstance($transport);

	//create arrays holding the information about sender and receiver
	$from = array($email_from => $from_name);
	$to = array($email_to);

	//setup the body of the emal
	$email_subject = $subject;
	$email_body = $content;

	//create the message object using the variables we defined above
	$message = Swift_Message::newInstance($email_subject);
	$message->setFrom($from);
	$message->setTo($to);
	$message->setBody($email_body);

	//finally, send it!
	$result = $mailer->send($message);

}

?>