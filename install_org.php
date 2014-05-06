<?php
//JDM

require 'includes/constant/config.inc.php';

//create a table to contain product data
$install_products = mysql_query("CREATE TABLE IF NOT EXISTS " . TABLE_PRODUCTS . "(
	id int(11) NOT NULL AUTO_INCREMENT,
	product_id varchar(220),
	upc varchar(220),
	sku varchar(220),
	club varchar(220),
	brand varchar(220),
	category varchar(220),
	price decimal(13,2),
	cost decimal(13,2),
	status varchar(220),
	details varchar(220),
	time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	UNIQUE KEY(product_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die("Error creating table TABLE_PRODUCTS:" . mysql_error());

if($install_products)
{
	echo "Table TABLE_PRODUCTS created successfully<br>";
}


//create a table to contain shaft data
$install_shafts = mysql_query("CREATE TABLE IF NOT EXISTS " . TABLE_SHAFTS . "(
	id int(11) NOT NULL AUTO_INCREMENT,
	product_id varchar(220),
	upc varchar(220),
	sku varchar(220),
	shaft varchar(220),
	brand varchar(220),
	category varchar(220),
	price decimal(13,2),
	cost decimal(13,2),
	status varchar(220),
	details varchar(220),
	time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	UNIQUE KEY(product_id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die("Error creating table TABLE_SHAFTS:" . mysql_error());

if($install_shafts)
{
	echo "Table TABLE_SHAFTS created successfully<br>";
}


//create a table to contain inquiry data
$install_inquiries = mysql_query("CREATE TABLE IF NOT EXISTS " . TABLE_INQUIRIES . "(
	id int(11) NOT NULL AUTO_INCREMENT,
	brand varchar(220),
	category varchar(220),
	club varchar(220),
	shaft varchar(220),
	quantity tinyint(22),
	customer varchar(220),
	email varchar(220),
	phone varchar(220),
	subscribe enum('yes','no'),
	comment text(500),
	time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die("Error creating table TABLE_INQUIRIES:" . mysql_error());

if($install_inquiries)
{
	echo "Table TABLE_INQUIRIES created successfully<br>";
}

		
//create a table to contain user data
$install_users = mysql_query("CREATE TABLE IF NOT EXISTS " . USERS . "(
	id int(11) NOT NULL AUTO_INCREMENT,
	md5_id varchar(200) NOT NULL DEFAULT '',
	full_name varchar(255),
	user_name varchar(200) NOT NULL DEFAULT '',
	usr_email varchar(255),
	user_level tinyint(4) NOT NULL DEFAULT '1',
	usr_pwd varchar(220) NOT NULL DEFAULT '',
	date date NOT NULL DEFAULT '0000-00-00',
	users_ip varchar(200) NOT NULL DEFAULT '',
	approved int(1) NOT NULL DEFAULT '0',
	activation_code int(10) NOT NULL DEFAULT '0',
	ckey varchar(220) NOT NULL DEFAULT '',
	ctime varchar(220) NOT NULL DEFAULT '',
	num_logins int(11) NOT NULL DEFAULT '0',
	last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die("Error creating table USERS:" . mysql_error());	
	
if($install_users)
{
	echo "Table USERS created successfully<br>";
}

//manually insert some information about a few users so that we can see it show up on the page once those users log in
$detail_insert = mysql_query("INSERT INTO ".USERS." (id,md5_id,full_name,user_name,usr_email,user_level,usr_pwd,date,users_ip,approved,activation_code,ckey,ctime,num_logins,last_login)
VALUES
(7,'8f14e45fceea167a5a36dedd4bea2543','Chie Tuller','chie','chie@test.com',1,'44a00c076bb8ca34f6cb1ca8fb300838779ff52f','2014-05-02','127.0.0.1',1,9307,,,15,'2014-05-06 07:53:41');") or die(mysql_error());




/*** insert data from CSV files ***/

//insert the product data from csv file.
$insert_products = mysql_query("LOAD DATA INFILE 'products_jdm_chie.csv'
		INTO TABLE ".TABLE_PRODUCTS."
		FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '\"' 
		LINES TERMINATED BY '\n'
		") or die("Error loading CSV file into MySQL table: " . mysql_error());
		//IGNORE 1 LINES (id,product_id,upc,sku,club,brand,category,price,cost,status,details,time)") or die("Error loading CSV file into MySQL table: " . mysql_error());
		
if($insert_products)
{
	echo "Table TABLE_PRODUCTS populated successfully<br>";
}
	
//insert the shaft data from csv file.
$insert_shafts = mysql_query("LOAD DATA INFILE 'shafts_jdm_chie.csv'
		INTO TABLE ".TABLE_SHAFTS."
		FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '\"' 
		LINES TERMINATED BY '\n'
		") or die("Error loading CSV file into MySQL table: " . mysql_error());
		//IGNORE 1 LINES (id,product_id,upc,sku,shaft,brand,category,price,cost,status,details,time)") or die("Error loading CSV file into MySQL table: " . mysql_error());
		
if($insert_shafts)
{
	echo "Table TABLE_SHAFTS populated successfully<br>";
}

//insert the product data from csv file.
$insert_inquiries = mysql_query("LOAD DATA INFILE 'inquiries_jdm_chie.csv'
		INTO TABLE ".TABLE_INQUIRIES."
		FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '\"' 
		LINES TERMINATED BY '\n'
		") or die("Error loading CSV file into MySQL table: " . mysql_error());
		//IGNORE 1 LINES (id,brand,category,club,shaft,quantity,customer,email,phone,subscribe,comment,time)") or die("Error loading CSV file into MySQL table: " . mysql_error());
		
if($insert_inquiries)
{
	echo "Table TABLE_INQUIRIES populated successfully<br>";
}

	
?>