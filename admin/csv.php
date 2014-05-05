<?php  
include '../includes/constant/config.inc.php';

if ($_FILES['csv']['size'] > 0) { 

    //get the csv file 
    $file = $_FILES['csv']['tmp_name']; 
    $handle = fopen($file,"r"); 
     
    //loop through the csv file and insert into database 
    do { 
		if ($data[1]) { 
            mysql_query("INSERT INTO ".TABLE_PRODUCTS." (product_id, club, brand) VALUES 
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



if ($_FILES['csv2']['size'] > 0) { 

    //loop through the csv file and insert into database 
    do { 
		if ($data[1]) { 
            mysql_query("INSERT INTO ".TABLE_SHAFTS." (product_id, shaft, brand) VALUES 
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
$i = 0;
$row = 1;
if (($handle = fopen("../test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $i = 1;
		$num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}


?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<title>Import a CSV File with PHP & MySQL</title> 
</head> 

<body> 

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?> 

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv" type="file" id="csv" /> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 

<form action="" method="post" enctype="multipart/form-data" name="form2" id="form2"> 
  Choose your file: <br /> 
  <input name="csv2" type="file" id="csv2" /> 
  <input type="submit" name="Submit" value="Submit" /> 
</form> 


</body> 
</html> 

			if ($data[1]) {
				mysql_query("INSERT INTO ".TABLE_PRODUCTS." (id, product_id, upc, sku, club, brand, category, price, cost, status, details, time) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."',
						'".addslashes($data[7])."',
						'".addslashes($data[8])."',
						'".addslashes($data[9])."',
						'".addslashes($data[10])."',
						'".addslashes($data[11])."'
					)
				");
			}
		} while ($data = fgetcsv($handle,1000,",","'"));
