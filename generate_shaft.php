<?php

require 'includes/constants/dbc.php';

//A functions which return an array holding all club in the product table
function get_shaft(){

	$query="SELECT shaft FROM " . TABLE_SHAFTS . " WHERE 1;";
	$result = mysql_query($query) or die(mysql_error());
	
	$shaft = array();
	
	while (true)
	{
		$row = mysql_fetch_array($result);
		
		if (!$row)
			break;
		
		$shaft[] = str_replace("\r","",$row['shaft']);
	}
	
	return $shaft;

}

$autocomplete_list = get_shaft();
$response = array("shaft" => $autocomplete_list);
echo json_encode($response);

?>