==============
How to deploy?
==============

1.	Go to /jdm/csv/ folder and put "jdm_products.csv", "jdm_shafts.csv", "jdm_inquiries.csv" into "hci573" folder inside of the MySQL data folder on your server.
	(e.g. With WAMP, C:\wamp\bin\mysql\mysql5.6.12\data\hci573)

2.	Run /jdm/install.php/ in the root folder to install all tables and insert dummy data into the tables.

3.	Open /jdm/includes/constant/pws.php and input your (real) email username and password to test swiftmailer.

4.	To login to admin area, click on green "admin" text link at the bottom right of the website or type URL /jdm/login.php, use username: chie and password: 1111.

5.	For a test on "import.php" in admin area, open to /jdm/csv/ folder and use "test_club.csv" for uploading club data and "test_shaft.csv" for uploading shaft data. 
 

==============
Site Structure
==============

- Front-end
	|
	---- Get a Quote (quote_form.php)
	---- Login (login.php)

- Back-end
	|
	---- Home (index.php)
	---- Inquiries (list_inquiry.php)
	---- Clubs (list_club.php)
	---- Shafts (list_shaft.php)
	---- Edit Profile (profile.php)
	---- Add Users (register.php)
	---- Logout (logout.php)

	
==============
Files Included
==============

- index.php
- quote_form.php
- thanks.php
- login.php
admin
  	|
	---- index.php
	---- list_inquiry.php
	---- list_club.php
	---- list_shaft.php
	---- import.php
	---- profile.php
	---- register.php
	---- logout.php
includes
		|
		---- constant
			|
			---- config.inc.php
			---- nav.inc.php
			---- footer.inc.php
			---- generate_club.php
			---- generate_shaft.php
		---- js
			|
			---- jquery-1.10.2.js
		---- styles
			|
			---- jdm.css
		---- swift
			|
			---- a bunch of files and folders
				
			
===========================
Third Party Library & Codes
===========================

1.	jQuery UI (Accordion & Autocomplete)
	https://jqueryui.com/
	Used in quote_form.php
	
2.	Swift Mailer
	http://swiftmailer.org/
	Used in thanks.php
	
3.	Sticky Div w/ Scrolling
	http://www.pixelbind.com/make-a-div-stick-when-you-scroll/
	Used in quote_form.php
	
4.	Import CSV files
	http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
	Used in admin/import.php
	
5.	Google Image Chart
	https://developers.google.com/chart/image/
	Used in admin/index.php

6.	Post an Unchecked Check Box
	http://www.webdeveloper.com/forum/showthread.php?209721-Posting-an-UNCHECKED-check-box
	Used in quote_form.php and thanks.php
	
	
===========
Bugs to Fix (but don't know how)
===========

1.	Once I logged in to admin area then went back to the pages in the root folder without logging out, the navigation menu is still for admin area.  
2.	When I import data with CSV files, it saves the first row which is for field names.
3.	Something wrong with saving Admin user's email address and it does not save correctly.


==================
Future Development
==================

1.	Add a function to send the inquiry data to our order management system via an email when a customer decided to actually order
2.	Add an ability to edit products data directly not only by CSV files
2.	Add a forum page
3.	Add a blog page