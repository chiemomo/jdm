 <?php 
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("");

//http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
//http://www.johnboy.com/scripts/import-csv-file-with-php-mysql/import.phps

if (isset($_POST['submit_club'])) {

	if ($_FILES['csv']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv']['tmp_name'];
		$handle = fopen($file,"r");
		
		//loop through the csv file and insert into database
		do {
			if ($data[1]) {
				mysql_query("INSERT INTO ".TABLE_PRODUCTS." (product_id, club, brand, category, price, cost, status, details) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."',
						'".addslashes($data[7])."'
					)
				");
			}
		} while ($data = fgetcsv($handle,1000,",","'"));
		//

		//redirect
		header('Location: import.php?success=1'); die;

	}

    fclose($handle);
	
}

if (isset($_POST['submit_shaft'])) {

	if ($_FILES['csv']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv']['tmp_name'];
		$handle = fopen($file,"r");
		
		//loop through the csv file and insert into database
		do {
			if ($data[1]) {
				mysql_query("INSERT INTO ".TABLE_SHAFTS." (product_id, shaft, brand, category, price, cost, status, details) VALUES
					(
						'".addslashes($data[0])."',
						'".addslashes($data[1])."',
						'".addslashes($data[2])."',
						'".addslashes($data[3])."',
						'".addslashes($data[4])."',
						'".addslashes($data[5])."',
						'".addslashes($data[6])."',
						'".addslashes($data[7])."'
					)
				");
			}
		} while ($data = fgetcsv($handle,1000,",","'"));
		//

		//redirect
		header('Location: import.php?success=1'); die;

	}

    fclose($handle);
	
}


		//count the line 1
		
//		for ($i = 0; $i < mysql_num_fields($query_for_table); $i++) {
	//		echo "<th>" . mysql_field_name($query_for_table, $i) . "</th>";
		//}

		
		/*
		
		function readCSV($csvFile){

			$file_handle = fopen($csvFile, 'r');
			while (!feof($file_handle) ) {
			$line_of_text[] = fgetcsv($file_handle, 1024);
			}
			fclose($file_handle);
			return $line_of_text;
			}

			// Set path to CSV file
			$csvFile = 'jdm_products_test.csv';

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
*/


?>

</head>
<body>
<div id="container">

	<?php include '../includes/constant/nav.inc.php'; ?>

	<h1>Hey <?php echo $_SESSION['fullname']; ?>!  Import Data</h1>

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

<p>Upload a CSV file to add Clubs</p>
<p>Choose your file: </p>
  <input type="file" name="csv" id="csv" />
  <input type="submit" name="submit_club" value="Submit" />

<p>Upload a CSV file to add Shafts</p>
<p>Choose your file: </p>
  <input type="file" name="csv" id="csv" />
  <input type="submit" name="submit_shaft" value="Submit" />

  </form>

</body>
</html>
