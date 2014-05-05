 <?php 
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Import CSV Files");

//http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
//http://www.johnboy.com/scripts/import-csv-file-with-php-mysql/import.phps

//Insert data to the CLUB table
if (isset($_POST['submit'])) {

	if ($_FILES['csv1']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv1']['tmp_name'];
		$handle = fopen($file,"r");
		
		//loop through the csv file and insert into database
		//http://dev.mysql.com/doc/refman/5.1/en/insert-on-duplicate.html
		do { 
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
						(".CURRENT_TIMESTAMP.")
					) ON DUPLICATE KEY UPDATE
						upc = '".addslashes($data[2])."',
						sku = '".addslashes($data[3])."',
						club = '".addslashes($data[4])."',
						brand = '".addslashes($data[5])."',
						category = '".addslashes($data[6])."',
						price = '".addslashes($data[7])."',
						cost = '".addslashes($data[8])."',
						status = '".addslashes($data[9])."',
						details = '".addslashes($data[10])."',
						time = (".CURRENT_TIMESTAMP.")"
				); 
			} 
		} while ($data = fgetcsv($handle,1000,",","'")); 

		fclose($handle);
		
		//redirect
		header("Location: ".$_SERVER['PHP_SELF']."?success=1"); die;
		

	}
	
	if ($_FILES['csv2']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv2']['tmp_name'];
		$handle = fopen($file,"r");
			
		//loop through the csv file and insert into database
		do { 
			if ($data[1]) { 
				mysql_query("INSERT INTO ".TABLE_SHAFTS." (id, product_id, upc, sku, shaft, brand, category, price, cost, status, details, time) VALUES 
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
						(".CURRENT_TIMESTAMP.")
					) ON DUPLICATE KEY UPDATE 
						upc = '".addslashes($data[2])."',
						sku = '".addslashes($data[3])."',
						shaft = '".addslashes($data[4])."',
						brand = '".addslashes($data[5])."',
						category = '".addslashes($data[6])."',
						price = '".addslashes($data[7])."',
						cost = '".addslashes($data[8])."',
						status = '".addslashes($data[9])."',
						details = '".addslashes($data[10])."',
						time = (".CURRENT_TIMESTAMP.")"
				); 
			} 
		} while ($data = fgetcsv($handle,1000,",","'")); 

		fclose($handle);

		//redirect
		header("Location: ".$_SERVER['PHP_SELF']."?success=2"); die;
	
	}

}

?>

<?php include '../includes/constant/nav.inc.php'; ?>

<h1>Import Product Data with CSV Files</h1>

<?php if (!empty($_GET['success'])) { echo "<div class='success'>Your file has been imported.</div>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
  Choose your file: <br /> 
  <input name="csv1" type="file" id="csv1" /> 
  <input type="submit" name="submit" value="Submit" /> 
</form> 

<form action="" method="post" enctype="multipart/form-data" name="form2" id="form2"> 
  Choose your file: <br /> 
  <input name="csv2" type="file" id="csv2" /> 
  <input type="submit" name="submit" value="Submit" /> 
</form> 

<?php include('../includes/constant/footer.inc.php'); ?>