<?php
require 'includes/constants/dbc.php';

//PREPARE A CLUB LIST IN JSON FORMAT fOR JQUERY UI AUTO-COMPLETION

//A functions which return an array holding all club in the product table
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

//run the function and convert the array to json format
$autocomplete_list = get_club();
$response = array("club" => $autocomplete_list);
echo json_encode($response);

?>