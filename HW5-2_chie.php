<?php

/*
	Homework 5, Part 2: Dynamic Charts
	
	For this part, your task is to write a php page which displays dynamic charts using data stored in SQL tables.
	
	Step 1: Create an install.php file that creates 2 different SQL tables and populates them with some dummy data. The tables could be tables that you will use in your project. Before you proceed, make sure you write and test SQL queries that retrieve all items for each of the two tables. 
	
	Step 2: In index.php, using PHP and HTML, display three different charts (e.g., a bar graph, a line graph, etc.) that visualize data from any of the 2 tables. At least one of those graph must have data from two different data series (e.g., a line plot with two different lines, a stacked bar graph, etc.). Use chart types that are different from the two examples shown in class. For each chart, write a short caption describing the chart and display it underneath the chart. 

	This part of the assignment is worth 6 points: 5 for correct functionality and 1 for comments and code readability. 
	
	
	EXTRA CREDIT
	
	[ 1 pt ] Define and use your own PHP functions for each type of graph, i.e., define a function to generate the Google Image Charts URL for a pie chart given a data series and a set of labels. 
	[ 1 pt ] Add a form that allows the user to add data for one of the tables. Upon submitting, reload the page so that the chart displaying data from that table is updated. 
	[ 1 pt ] Add a fourth chart using Javascript along with Google Charts (or any other javascript chart library). 
	[ 1 pt ] One of the charts must show / compare data from both tables in the same chart
	
	

*/

include 'includes/constants/dbc.php';

//Retrieve data (all column) from the inquiry table
	$query = "SELECT * FROM " . TABLE_INQUIRIES . " ORDER BY club DESC;";

	//execute it
	$result = mysql_query($query) or die("Failed to retrieve rows: " . mysql_error());

	//array to store the rows
	$table_rows = array();

	while($row = mysql_fetch_array($result))
	{
		$table_rows[] = $row; //add the next row to the list of rows stored in $table_rows
	}
	//print_r($table_rows); echo "<br><br>";
	
//CHART 1: BAR CHART: Number of inquiries per club

//step 1: extract all categories
	$club = array();

	foreach ($table_rows as $current_row){
		//if the product category of the current row is not in the list, add it
		if ( !in_array($current_row['club'], $club) ) {
			$club[] = $current_row['club'];
		}
	}
	//print_r($club); echo "<br><br>";

//step 2-1: compute the order counts for each club
	$counts_per_club = array();
	foreach ($club as $cat_i){
		$counts_per_club[$cat_i] = 0; //start with zero
	}

	foreach ($table_rows as $current_row){
		//find the category of the current row
		$current_row_club = $current_row['club'];
		//echo "Incrementing club " . $current_row_club . "<br>";
			
		$counts_per_club[$current_row_club] ++; //increment the count for the club of the current row
	}
	//print_r($counts_per_club); echo "<br><br>";

//step 3: generate the Google Image Charts string
	$chart_url_1 = "https://chart.googleapis.com/chart?";

	//set static values
	$chart_title = "Inquiries Per Club";
	$x = 500;
	$y = 400;
	$chart_type = "bhs";
	$scale = "0,10";
	$count_label = "N,333333,0,-1,14";

	//add all values to the url string
	$chart_url_1 .= "chtt=" . $chart_title; //add chart title
	$chart_url_1 .= "&chs=" . $x . "x" . $y; //add width($x) and hight($y) of the chart image
	$chart_url_1 .= "&cht=" . $chart_type; //add chart type
	$chart_url_1 .= "&chds=" . $scale; //add scale
	$chart_url_1 .= "&chm=" . $count_label; //show count numbers on each bar

	//add number of inquiries computed at step 2
	$chart_url_1 .= "&chd=t:";
	for ($i = 0; $i < count($club); $i++){
		
		//get the club at index $i
		$club_i = $club[$i];
		
		//add the data to the URL
		$chart_url_1 .= $counts_per_club[$club_i];
		
		if ($i < count($club) - 1){
			$chart_url_1 .= ",";
		}
	}

	//add labels on y axis
	$chart_url_1.="&chxt=y&chxl=0:";
	foreach ($club as $club_i){
		$chart_url_1 .= "|" . $club_i;
	}
//CHART 1: END
	

//CHART 2: LINE SHART: Number of inquiries and newsletter subscription per day
/*
SELECT DATE(time) AS date, COUNT(id) AS inquiries, COUNT(CASE WHEN subscribe = 'yes' THEN subscribe END) AS subscribed
FROM `inquiries_jdm_chie`
GROUP BY date
*/

//Retrieve data (all column) from the inquiry table
$query2 = "SELECT DATE(time) AS date, COUNT(id) AS inquiries, COUNT(CASE WHEN subscribe = 'yes' THEN subscribe END) AS subscriptions
FROM " . TABLE_INQUIRIES . " GROUP BY date;";

	//execute it
	$result2 = mysql_query($query2) or die("Failed to retrieve rows: " . mysql_error());

	//array to store the rows
	$table_rows2 = array();

	while($row2 = mysql_fetch_array($result2))
	{
		$table_rows2[] = $row2; //add the next row to the list of rows stored in $table_rows
	}
	//print_r($table_rows2); echo "<br><br>";

//step 1: extract all values
	$date = array();
	$inquries = array();
	$subscriptions = array();

	foreach ($table_rows2 as $current_row){
		if ( !in_array($current_row['date'], $date) ) {
			$date[] = $current_row['date'];
		}
		if ( !in_array($current_row['inquiries'], $date) ) {
			$inquries[] = $current_row['inquiries'];
		}
		if ( !in_array($current_row['subscriptions'], $date) ) {
			$subscriptions[] = $current_row['subscriptions'];
		}
	}

/*	print_r($date); echo "<br><br>";
	print_r($inquries); echo "<br><br>";
	print_r($subscriptions); echo "<br><br>";
*/

//step 2: no computing is needed since it's counted in the SQL query

//step 3: generate the Google Image Charts string
//https://chart.googleapis.com/chart?chtt=Inquiries%20and%20Subscribe%20Per%20Day&chs=700x300&cht=lc&chds=0,10&chm=N,00FF00,0,-1,14|N,0000FF,1,-1,14&chco=00FF00,0000FF&chdl=Inquiries|Subscriptions&chxt=x,y&chxl=0:|2014-04-20|2014-04-21|2014-04-22|2014-04-23|2014-04-24|2014-04-25|2014-04-27|1:|0|5|10&chd=t:1,1,1,2,6,10,1|1,1,1,2,5,6,0

	$chart_url_2 = "https://chart.googleapis.com/chart?";

	$chart_title = "Inquiries and Subscribe Per Day";
	$x = 700;
	$y = 300;
	$chart_type = "lc";
	$scale = "0,10";
	$count_label = "N,00FF00,0,-1,14|N,0000FF,1,-1,14";
	$colors = "00FF00,0000FF";
	$legend = "Subscriptions|Inquiries";

	$chart_url_2 .= "chtt=" . $chart_title; //add chart title
	$chart_url_2 .= "&chs=" . $x . "x" . $y; //add width($x) and hight($y) of the chart image
	$chart_url_2 .= "&cht=" . $chart_type; //add chart type
	$chart_url_2 .= "&chds=" . $scale; //add scale
	$chart_url_2 .= "&chm=" . $count_label; //show count numbers on each bar
	$chart_url_2 .= "&chco=" . $colors; //add colors of the lines
	$chart_url_2 .= "&chdl=" . $legend; //generate string for chart legend

	//labels for x & y axis
	$chart_url_2 .= "&chxt=x,y&chxl=0:";
	foreach ($date as $date_i){
		$chart_url_2 .= "|" . $date_i;
	}
	$chart_url_2 .= "|1:|0|5|10";

	//add number of subscriptions per day
	$chart_url_2 .= "&chd=t:";
	for ($i = 0; $i < count($subscriptions); $i++){
		$chart_url_2 .= $subscriptions[$i];		
		if ($i < count($subscriptions) - 1){
			$chart_url_2 .= ",";
		}
	}

	//add number of inquiries per day
	$chart_url_2 .= "|";
	for ($i = 0; $i < count($inquries); $i++){
		$chart_url_2 .= $inquries[$i];	
		if ($i < count($inquries) - 1){
			$chart_url_2 .= ",";
		}
	}
//CAHRT 2: END


//CHART 3: LINE SHART: Number of inquiries and newsletter subscription per day
/*
SELECT TABLE_INQUIRIES.id, TABLE_INQUIRIES.club, TABLE_PRODUCTS.price, TABLE_INQUIRIES.quantity
FROM TABLE_INQUIRIES
LEFT JOIN TABLE_PRODUCTS
ON TABLE_INQUIRIES.club=TABLE_PRODUCTS.club
ORDER BY TABLE_INQUIRIES.id;

SELECT inquiries_jdm_chie.id, inquiries_jdm_chie.club, products_jdm_chie.price, inquiries_jdm_chie.quantity
FROM inquiries_jdm_chie
LEFT JOIN products_jdm_chie
ON inquiries_jdm_chie.club=products_jdm_chie.club
ORDER BY inquiries_jdm_chie.id;

SELECT inquiries_jdm_chie.id, inquiries_jdm_chie.shaft, shafts_jdm_chie.price, inquiries_jdm_chie.quantity
FROM inquiries_jdm_chie
LEFT JOIN shafts_jdm_chie
ON inquiries_jdm_chie.shaft=products_jdm_chie.shaft
ORDER BY inquiries_jdm_chie.id;
*/
//Retrieve id, club and quantity from the inquiry table, price from the product table and join 
	$query3 = "SELECT " . TABLE_INQUIRIES . ".id, " . TABLE_INQUIRIES . ".club, " . TABLE_PRODUCTS . ".price, " . TABLE_INQUIRIES . ".quantity FROM " . TABLE_INQUIRIES . " LEFT JOIN " . TABLE_PRODUCTS . " ON " . TABLE_INQUIRIES . ".club=" . TABLE_PRODUCTS . ".club ORDER BY " . TABLE_INQUIRIES .".id;";
	$result3 = mysql_query($query3) or die("Failed to retrieve rows: " . mysql_error());

	$table_rows3 = array();
	while($row3 = mysql_fetch_array($result3))
	{
		$table_rows3[] = $row3;
	}
	//print_r($table_rows3); echo "<br><br>";

//Retrieve id, shaft and quantity from the inquiry table, price from the shaft table and join 	
	$query4 = "SELECT " . TABLE_INQUIRIES . ".id, " . TABLE_INQUIRIES . ".shaft, " . TABLE_SHAFTS . ".price, " . TABLE_INQUIRIES . ".quantity FROM " . TABLE_INQUIRIES . " LEFT JOIN " . TABLE_SHAFTS . " ON " . TABLE_INQUIRIES . ".shaft=" . TABLE_SHAFTS . ".shaft ORDER BY " . TABLE_INQUIRIES .".id;";
	$result4 = mysql_query($query4) or die("Failed to retrieve rows: " . mysql_error());
	
	$table_rows4 = array();
	while($row4 = mysql_fetch_array($result4))
	{
		$table_rows4[] = $row4;
	}
	//print_r($table_rows4); echo "<br><br>";

//step 1: extract all values
	$price = array();

	foreach ($table_rows3 as $current_row){
		if ( !in_array($current_row['price'], $date) ) {
			$price[] = $current_row['price'];
		}
	}

	print_r($price); echo "<br><br>";

//step 2: no computing is needed since it's counted in the SQL query

//step 3: generate the Google Image Charts string
//https://chart.googleapis.com/chart?chtt=Inquiries%20and%20Subscribe%20Per%20Day&chs=700x300&cht=lc&chds=0,10&chm=N,00FF00,0,-1,14|N,0000FF,1,-1,14&chco=00FF00,0000FF&chdl=Inquiries|Subscriptions&chxt=x,y&chxl=0:|2014-04-20|2014-04-21|2014-04-22|2014-04-23|2014-04-24|2014-04-25|2014-04-27|1:|0|5|10&chd=t:1,1,1,2,6,10,1|1,1,1,2,5,6,0

	$chart_url_2 = "https://chart.googleapis.com/chart?";

	$chart_title = "Inquiries and Subscribe Per Day";
	$x = 700;
	$y = 300;
	$chart_type = "lc";
	$scale = "0,10";
	$count_label = "N,00FF00,0,-1,14|N,0000FF,1,-1,14";
	$colors = "00FF00,0000FF";
	$legend = "Subscriptions|Inquiries";

	$chart_url_2 .= "chtt=" . $chart_title; //add chart title
	$chart_url_2 .= "&chs=" . $x . "x" . $y; //add width($x) and hight($y) of the chart image
	$chart_url_2 .= "&cht=" . $chart_type; //add chart type
	$chart_url_2 .= "&chds=" . $scale; //add scale
	$chart_url_2 .= "&chm=" . $count_label; //show count numbers on each bar
	$chart_url_2 .= "&chco=" . $colors; //add colors of the lines
	$chart_url_2 .= "&chdl=" . $legend; //generate string for chart legend

	//labels for x & y axis
	$chart_url_2 .= "&chxt=x,y&chxl=0:";
	foreach ($date as $date_i){
		$chart_url_2 .= "|" . $date_i;
	}
	$chart_url_2 .= "|1:|0|5|10";

	//add number of subscriptions per day
	$chart_url_2 .= "&chd=t:";
	for ($i = 0; $i < count($subscriptions); $i++){
		$chart_url_2 .= $subscriptions[$i];		
		if ($i < count($subscriptions) - 1){
			$chart_url_2 .= ",";
		}
	}

	//add number of inquiries per day
	$chart_url_2 .= "|";
	for ($i = 0; $i < count($inquries); $i++){
		$chart_url_2 .= $inquries[$i];	
		if ($i < count($inquries) - 1){
			$chart_url_2 .= ",";
		}
	}
//CAHRT 3: END

?>

<html>

	<p>Please put jdm_inquiries.csv in the HW_5-2_chie folder into C:\wamp\bin\mysql\mysql5.6.12\data\hci573 in order to populate tables.</p>

	<!-- Chart 1 -->
	<h2>This bar chart shows how many inquires each club has got.</h2>
    <img src="<?php echo $chart_url_1;?>"></img>
	<p>Chart URL: <?php echo $chart_url_1;?></p>
	
	<br><br>
	
	<!-- Chart 2 -->
	<h2>This line chart to show number of inquiries and email letter subscriptions</h2>
    <img src="<?php echo $chart_url_2;?>"></img>
	<p>Chart URL: <?php echo $chart_url_2;?> </p>

</html>