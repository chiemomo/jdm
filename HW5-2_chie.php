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
	
//Chrat 1: BAR CHART: Number of inquiries per club

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


//Chrat 2: LINE SHART: Number of inquiries and newsletter subscription per day
/*
SELECT DATE(time) AS date, COUNT(id) AS inquiries, COUNT(subscribe = 'yes') AS subscribed
FROM `inquiries_jdm_chie`
GROUP BY date

SELECT DATE(time) AS date, COUNT(subscribe = 'yes')
FROM `inquiries_jdm_chie`
GROUP BY date
*/
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
	$labels = $club;
	$data = $counts_per_club;

	$chart_url = "https://chart.googleapis.com/chart?";

	$chart_title = "Inquiries Per Club";
	$x = 500;
	$y = 400;
	$chart_type = "bhs";
	$scale = "0,10";
	$count_label = "N,333333,0,-1,14";
	//$colors = array('C6D9FD','3493EC','0000FF','02335E');

	$chart_url .= "chtt=" . $chart_title; //add chart title
	$chart_url .= "&chs=" . $x . "x" . $y; //add width($x) and hight($y) of the chart image
	$chart_url .= "&cht=" . $chart_type; //add chart type
	$chart_url .= "&chds=" . $scale; //add scale
	$chart_url .= "&chm=" . $count_label; //show count numbers on each bar
	//define colors of the chart
	//$chart_url .= "&chco=";
	/*
	for ($i = 0; $i < count($colors); $i++) {

		$chart_url .= $colors[$i];
		
		if ($i < count($colors) - 1) {
			$chart_url .= ",";
		}
	}
	*/	
	//count inquiries for each club
	$chart_url .= "&chd=t:";
	for ($i = 0; $i < count($club); $i++){
		
		//get the club at index $i
		$club_i = $club[$i];
		
		//add the data to the URL
		$chart_url .= $counts_per_club[$club_i];
		
		if ($i < count($club) - 1){
			$chart_url .= ",";
		}
	}

	//labels for x & y axis
	$chart_url.="&chxt=y&chxl=0:";
	foreach ($club as $club_i){
		$chart_url .= "|" . $club_i;
	}

	/*generate string for chart legend
	$chart_url .= "&chdl=";
	for ($i = 0; $i < count($labels); $i++){
		$chart_url .= $labels[$i];
		
		if ($i < count($club) - 1){
			$chart_url .= "|";
		}
	}*/

	?>

<html>

	<!-- Chart 1 -->
	<p><?php echo $chart_url_1;?></p>
    <img src="<?php echo $chart_url_1;?>"></img>
	
	<!-- Chart 2 -->
	<p><?php echo $chart_url_2;?> </p>
    <img src="<?php echo $chart_url_2;?>"></img>

	<!-- Chart 3 -->
	<p><?php echo $chart_url_3?> </p>
    <img src="<?php echo $chart_url_3;?>"></img>

</html>