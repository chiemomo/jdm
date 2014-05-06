<?php
require 'config.inc.php';

//create password store if it doesn't exist
//an SQL query for creating a table
//The table has four fields: PID,Name,Continent, and Diameter
//The query specifies the types of the fields 
$sql = "CREATE TABLE IF NOT EXISTS " . PSTORE_TABLE . " (
		PID INT NOT NULL AUTO_INCREMENT,
		username varbinary(256) UNIQUE,
		password varbinary(256),
		PRIMARY KEY(PID)
)";

// Execute query
$result = mysql_query($sql) or die (mysql_error());


if ($_POST){
	if (isset($_POST['add_password'])){
		if (isset($_POST['username']) and isset($_POST['password'])){
			$username = mysql_real_escape_string($_POST['username']);
			$password = mysql_real_escape_string($_POST['password']);

			$key = $password_store_key;
			$q1 = mysql_query("INSERT INTO " . PSTORE_TABLE . " (username, password) VALUES (AES_ENCRYPT('$username', '$key'), AES_ENCRYPT('$password', '$key'))") or die(mysql_error());
			
			
			//$result = mysql_query("SELECT * , AES_DECRYPT(password, '$key') AS password FROM " .PSTORE_TABLE." WHERE username=AES_ENCRYPT('$username', '$key')") or die(mysql_error());
			
			//$row = mysql_fetch_assoc($result);
			//echo "<p>".$row['password']."</p>";
			echo "Saved password for user ".$username."<br>";
		}
	}
}


?>


<html>
<head>

<!-- add link to css -->
 <link href="includes/styles/myform.css"> 


</head>

<body>




<form id="form" name="form" method="post" action="pws.php">
<h1>Password Store</h1>
<p>Use this form to add encrypted username-password pairs</p>

<label>Name
</label>
<input type="text" name="username" id="name" />
<label>Password
</label>
<input type="password" name="password" id="name" />

<button type="submit" id="submit_button" name="add_password" value="add" >Submit</button>
<div class="spacer"></div>
</form>



</body>
</html>