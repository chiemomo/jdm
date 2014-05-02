 <?php 
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("Import CSV Files");

//http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
//http://www.johnboy.com/scripts/import-csv-file-with-php-mysql/import.phps

//Insert data to the CLUB table
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

		//redirect
		header('Location: import.php?success=1'); die;

	}

    fclose($handle);
	
}

//Insert data to the SHAFT table
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

		//redirect
		header('Location: import.php?success=1'); die;

	}

    fclose($handle);
	
}

?>

<?php include '../includes/constant/nav.inc.php'; ?>

<h1>Import Product Data with CSV Files</h1>

<?php if (!empty($_GET['success'])) { echo "<b>Your file has been imported.</b><br><br>"; } //generic success notice ?>

<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" class="admin_form">

<table>
	<tr>
		<td colspan="2">Import Club Data</td>
	</tr>
	<tr>
		<td><input type="file" name="csv" id="csv" /></td>
		<td><input type="submit" name="submit_club" value="Import" class="button green" /></td>
	</tr>
</table>

<table>
	<tr>
		<td colspan="2">Import Shaft Data</td>
	</tr>
	<tr>
		<td><input type="file" name="csv" id="csv" /></td>
		<td><input type="submit" name="submit_shaft" value="Import" class="button green" /></td>
	</tr>
</table>

</form>

<?php include('../includes/constant/footer.inc.php'); ?>