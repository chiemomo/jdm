<?php
/*
//specify the filename and store it in a variable
$file_name_1 = "review_assignments.csv";

//open the file for reading
$file_1 = fopen( $file_name_1, 'r');//r stands for reading

if (!$file_1){
	echo "hi The file " . $file_name_1 . " doesn't exist or couldn't be opened!<br>";
	exit();	
}

$next_ch = fgetc($file_1);
echo "The next character is: " . $next_ch . "<br>";

$next_ch = fgetc($file_1);
echo "The next character is: " . $next_ch . "<br>";

//use a while loop to read all characters
while (true){

	//first, check if the file pointer is at the end of the file -- if so, break out of the while loop
	if ( feof($file_1) ){
		break;
	}
	else {
		$next_ch = fgetc($file_1);
		echo "The next character is: " . $next_ch . "<br>";
	}
}

//close the file
fclose($file_1);


//Example: Reading line by line

$file_1 = fopen( $file_name_1, 'r');

while (true){
	if ( feof($file_1) ){
		break;
	}
	else {
		$next_line = fgets($file_1);
		echo "The next line is: " . $next_line . "<br>";
	}
}

//close the file
fclose($file_1);
*/

//Example: Open and read a CSV file

$csv_filename = "review_assignments.csv";
$csv_file = fopen( $csv_filename, "r" );

while (true){
	if ( feof($csv_file) ){
		break;
	}
	else {
		$next_line_tokens = fgetcsv($csv_file, 1000, ";");
		
		echo "<br>Data for the next line:<br>";
		print_r($next_line_tokens);
		
		
	}
}
?>