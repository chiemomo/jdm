<?php
require 'includes/constant/config.inc.php';

//PREPARE A SHAFT LIST IN JSON FORMAT fOR JQUERY UI AUTO-COMPLETION

//execute the function and convert the array to json format
$autocomplete_list = get_shaft();
$response = array("shaft" => $autocomplete_list);
echo json_encode($response);

?>