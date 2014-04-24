<?php

require 'includes/constants/dbc.php';

//A functions which return an array holding all club in the product table
function get_club(){

	$query="SELECT club FROM " . TABLE_PRODUCTS . " WHERE 1;";
	$result = mysql_query($query) or die(mysql_error());
	
	$club = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		if (!$row)
			break;
		
		$club[] = str_replace("\r","",$row['club']);
	}
	
	return $club;

}

$autocomplete_list = get_club();
$response = array("club" => $autocomplete_list);
echo json_encode($response);

?>