<?php
require 'config.inc.php';

//PREPARE A CLUB LIST IN JSON FORMAT fOR JQUERY UI AUTO-COMPLETION

//run the function and convert the array to json format
$autocomplete_list = get_club();
$response = array("club" => $autocomplete_list);
echo json_encode($response);

?>