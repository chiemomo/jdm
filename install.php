<?php
//JDM

require 'includes/constants/dbc.php';

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

//insert the product data from csv file.
$insert_products = mysql_query("LOAD DATA INFILE 'jdm_products.csv'
		INTO TABLE ".TABLE_PRODUCTS."
		FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '\"' 
		LINES TERMINATED BY '\n'
		IGNORE 1 LINES (id,product_id,upc,sku,club,brand,category,price,cost,status,details,time)") or die("Error loading CSV file into MySQL table: " . mysql_error());
		
if($insert_products)
{
	echo "Table TABLE_PRODUCTS populated successfully<br>";
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

//insert the product data from csv file.
$insert_shafts = mysql_query("LOAD DATA INFILE 'jdm_shafts.csv'
		INTO TABLE ".TABLE_SHAFTS."
		FIELDS TERMINATED BY ','
		OPTIONALLY ENCLOSED BY '\"' 
		LINES TERMINATED BY '\n'
		IGNORE 1 LINES (id,product_id,upc,sku,shaft,brand,category,price,cost,status,details,time)") or die("Error loading CSV file into MySQL table: " . mysql_error());
		
if($insert_shafts)
{
	echo "Table TABLE_SHAFTS populated successfully<br>";
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
		
//create a table to contain inquiry data
$install_users = mysql_query("CREATE TABLE IF NOT EXISTS " . TABLE_USERS . "(
	id int(11) NOT NULL AUTO_INCREMENT,
	employee varchar(220),
	email varchar(220),
	user varchar(220),
	password varchar(220),
	time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY(id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;") or die("Error creating table TABLE_USERS:" . mysql_error());

if($install_users)
{
	echo "Table TABLE_USERS created successfully<br>";
}
		
?>