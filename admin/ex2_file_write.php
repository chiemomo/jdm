<?php

//specify the filename and store it in a variable
//$file_name_1 = "newfile2.txt";
//$file_name_1 = "alphabet.txt";
$file_name_1 = "newfile4.csv";

//open the file for reading
$file_1 = fopen( $file_name_1, 'w+');

if (!$file_1){
	echo "The file " . $file_name_1 . " doesn't exist or couldn't be opened!<br>";
	exit();	
}

//Example 1: Write to a new file (use mode w or c)
//fwrite($file_1, "This is some sample text\nnext line.");
//fwrite($file_1, "\nhello.");
//fwrite($file_1, "A");

//Example 2: Write to an existing file (use mode w or a)
//fwrite($file_1, "\nAppanded text.");

//Example 3: Write to a CSV file
//$row_1 = array("A","apple",45,12.34);
//$row_2 = array("B","beet",45,12.34);
//$row_3 = array("C","carrot,candy",45,12.34);

//fputcsv($file_1, $row_1); 
//fputcsv($file_1, $row_2); 
//fputcsv($file_1, $row_3); 

//display the contents of the file (must be opened in reading mode)
//rewind($file_1);
//$file_contents = fread($file_1, filesize($file_name_1));
//$file_contents = str_replace("\n", "<br>", $file_contents);
//echo "The file contains:<br><br>" . $file_contents;

//close the file once we're done
fclose($file_1);

echo "<br>done.";