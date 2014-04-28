 <?php 
//http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
//http://www.johnboy.com/scripts/import-csv-file-with-php-mysql/import.phps

/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();

if ($_FILES[csv][size] > 0) {

    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $handle = fopen($file,"r");
    
    //loop through the csv file and insert into database
    do {
        if ($data[0]) {
            mysql_query("INSERT INTO contacts (contact_first, contact_last, contact_email) VALUES
                (
                    '".addslashes($data[0])."',
                    '".addslashes($data[1])."',
                    '".addslashes($data[2])."'
                )
            ");
        }
    } while ($data = fgetcsv($handle,1000,",","'"));
    //

    //redirect
    header('Location: import.php?success=1'); die;

}




function readCSV($csvFile){
$file_handle = fopen($csvFile, 'r');
while (!feof($file_handle) ) {
$line_of_text[] = fgetcsv($file_handle, 1024);
}
fclose($file_handle);
return $line_of_text;
}

// Set path to CSV file
$csvFile = 'test_data.csv';

//calling the function
$csv = readCSV($csvFile);
if(!empty($csv)){
    foreach($csv as $file){
        //inserting into database
        $query_insert = "insert into csv_data_upload set 
            name    =   '".$file[0]."',
            value   =   '".$file[1]."'";
            echo $query_insert;
        $insert = mysql_query($query_insert);   
  }
}else{
   echo 'Csv is empty'; 
    
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Import a CSV File with PHP & MySQL</title>
</head>

<body>

<?php if (!empty($_GET[success])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
  Choose your file: <br />
  <input name="csv" type="file" id="csv" />
  <input type="submit" name="Submit" value="Submit" />
</form>

</body>
</html>
