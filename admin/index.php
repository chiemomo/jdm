<?php
/*ADMIN index.php - secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Welcome to the secured user area " .$_SESSION['fullname'] . "!");

/****CHART****/
//Retrieve data (all column) from the inquiry table
	$query = "SELECT * FROM " . TABLE_INQUIRIES . " ORDER BY club DESC;";
	//$query = "SELECT club, COUNT(*) AS CLUBCOUNT FROM " . TABLE_INQUIRIES . " GROUP BY club ORDER BY CLUBCOUNT DESC;";

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

	arsort($counts_per_club, SORT_NUMERIC);
	//print_r($counts_per_club); echo "<br><br>";

//step 3: generate the Google Image Charts string

	$chart_url_1 = "https://chart.googleapis.com/chart?";

	//set static values
	$chart_title = "Inquiries Per Club";
	$x = 500;
	$y = 600;
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

//step 1: extract all values and put them in arrays
	$date = array();
	$inquries = array();
	$subscriptions = array();

	foreach ($table_rows2 as $current_row){
			$date[] = $current_row['date'];
			$inquries[] = $current_row['inquiries'];	
			$subscriptions[] = $current_row['subscriptions'];
	}

/*	print_r($date); echo "<br><br>";
	print_r($inquries); echo "<br><br>";
	print_r($subscriptions); echo "<br><br>";
*/

//step 2: no computing is needed since it's counted in the SQL query

//step 3: generate the Google Image Charts string

	$chart_url_2 = "https://chart.googleapis.com/chart?";

	$chart_title = "Inquiries and Subscribe Per Day";
	$x = 1000;
	$y = 300;
	$chart_type = "lc";
	$scale = "0,15";
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
	$chart_url_2 .= "|1:|0|5|10|15";

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
	$query3 = "SELECT " . TABLE_INQUIRIES . ".id, " . TABLE_INQUIRIES . ".club, " . TABLE_PRODUCTS . ".price AS price_club, " . TABLE_INQUIRIES . ".quantity FROM " . TABLE_INQUIRIES . " LEFT JOIN " . TABLE_PRODUCTS . " ON " . TABLE_INQUIRIES . ".club=" . TABLE_PRODUCTS . ".club ORDER BY " . TABLE_INQUIRIES .".id DESC;";
	$result3 = mysql_query($query3) or die("Failed to retrieve rows: " . mysql_error());

	$table_rows3 = array();
	while($row3 = mysql_fetch_array($result3))
	{
		$table_rows3[] = $row3;
	}
	//print_r($table_rows3); echo "<br><br>";

//Retrieve id, shaft and quantity from the inquiry table, price from the shaft table and join 	
	$query4 = "SELECT " . TABLE_INQUIRIES . ".id, " . TABLE_INQUIRIES . ".shaft, " . TABLE_SHAFTS . ".price AS price_shaft, " . TABLE_INQUIRIES . ".quantity FROM " . TABLE_INQUIRIES . " LEFT JOIN " . TABLE_SHAFTS . " ON " . TABLE_INQUIRIES . ".shaft=" . TABLE_SHAFTS . ".shaft ORDER BY " . TABLE_INQUIRIES .".id DESC;";
	$result4 = mysql_query($query4) or die("Failed to retrieve rows: " . mysql_error());
	
	$table_rows4 = array();
	while($row4 = mysql_fetch_array($result4))
	{
		$table_rows4[] = $row4;
	}
	//print_r($table_rows4); echo "<br><br>";

//combine above two arrays into one where id is matched
	$combined_array = array();
	foreach($table_rows3 as $key => $value){
		foreach($table_rows4 as $value2){
			if($value['id'] === $value2['id']){
				$combined_array[$key] = array_merge($table_rows3[$key], $table_rows4[$key]);
			}               
		}
	}
	//print_r($combined_array); echo "<br>";

//step 1: extract all values
	$id = array();
	$price_club = array();
	$price_shaft = array();
	$price_total = array();

	foreach ($combined_array as $current_row){
		$id[] = $current_row['id'];
		$price_club[] = $current_row['price_club'] * $current_row['quantity'];
		$price_shaft[] = $current_row['price_shaft'] * $current_row['quantity'];
		$price_total[] = ($current_row['price_club'] + $current_row['price_shaft']) * $current_row['quantity']; //compute compute total price with price x quantity
	}
	
//step 2: compute
	
//step 3: generate the Google Image Charts string

	$chart_url_3 = "https://chart.googleapis.com/chart?";

	$chart_title = "Quote";
	$x = 750;
	$y = 400;
	$chart_type = "bvs";
	$scale = "0,5000";
	$count_label = "N,FF0000,-1,,12|N,333333,0,,12,,c|N,333333,1,,12,,c";
	$colors = "00A5C6,FFFF42";
	$legend = "Club|Shaft";

	$chart_url_3 .= "chtt=" . $chart_title; //add chart title
	$chart_url_3 .= "&chs=" . $x . "x" . $y; //add width($x) and hight($y) of the chart image
	$chart_url_3 .= "&cht=" . $chart_type; //add chart type
	$chart_url_3 .= "&chds=" . $scale; //add scale
	$chart_url_3 .= "&chm=" . $count_label; //show count numbers on each bar
	$chart_url_3 .= "&chco=" . $colors; //add colors of the lines
	$chart_url_3 .= "&chdl=" . $legend; //generate string for chart legend

	//labels for x & y axis
	$chart_url_3 .= "&chxt=x,y&chxl=0:";
	for ($i = 0; $i < 20; $i++){
		$chart_url_3 .= "|" . $id[$i];
	}
	$chart_url_3 .= "|1:|0|500|1000|1500|2000|2500|3000";

	//add total price for each inquiry
/*	$chart_url_3 .= "&chd=t:";
	for ($i = 0; $i < count($price_total); $i++){
		$chart_url_3 .= $price_total[$i];		
		if ($i < count($price_total) - 1){
			$chart_url_3 .= ",";
		}
	}
*/
	$chart_url_3 .= "&chd=t:";
	for ($i = 0; $i < 20; $i++){
		$chart_url_3 .= $price_club[$i];		
		if ($i < 19){
			$chart_url_3 .= ",";
		}
	}

	$chart_url_3 .= "|";
	for ($i = 0; $i < 20; $i++){
		$chart_url_3 .= $price_shaft[$i];		
		if ($i < 19){
			$chart_url_3 .= ",";
		}
	}

//CAHRT 3: END

?>

<?php include '../includes/constant/nav.inc.php'; ?>

<h1>Quote Request Analytics</h1>

<!-- Chart 1 -->
<div class="jp_about jp_wrap100">
<h2>Quote Request per Club</h2>
<img src="<?php echo $chart_url_1;?>">
</div>

<!-- Chart 2 -->
<div class="jp_about jp_wrap100">
<h2>Quote Request and Newsletter Subscription per Day</h2>
<img src="<?php echo $chart_url_2;?>">
</div>

<!-- Chart 3 -->
<div class="jp_about jp_wrap100">
<h2>Possible Revenue per Quote (the most recent 20 quotes)</h2>
<img src="<?php echo $chart_url_3;?>">
</div>

<?php include('../includes/constant/footer.inc.php'); ?>