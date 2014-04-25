<?php
require 'includes/constants/dbc.php';

//PREPARE A SHAFT LIST IN JSON FORMAT fOR JQUERY UI AUTO-COMPLETION

//A functions which return an array holding all shaft in the shaft table
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

//execute the function and convert the array to json format
$autocomplete_list = get_shaft();
$response = array("shaft" => $autocomplete_list);
echo json_encode($response);

?>