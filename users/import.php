 <?php 
/*Secured user only page*/
include '../includes/constant/config.inc.php';
secure_page();
return_meta("");

//http://www.johnboy.com/blog/tutorial-import-a-csv-file-using-php-and-mysql
//http://www.johnboy.com/scripts/import-csv-file-with-php-mysql/import.phps

$query_for_import = "INSERT INTO contacts (contact_first, contact_last, contact_email) VALUES";
$number_of_columns = 3;

if (isset($_POST['submit'])) {

	if ($_FILES['csv']['size'] > 0) {

		//get the csv file
		$file = $_FILES['csv']['tmp_name'];
		$handle = fopen($file,"r");
		
		//loop through the csv file and insert into database
		do {
			if ($data[0]) {
				mysql_query($query_for_import.
					"("
					for ($i = 0; $i < $number_of_columns; $i++) {
						"'".addslashes($data[$i])."',"
					}
					
					if ($i = $number_of_columns-1) {
						"'".addslashes($data[$i])."'"
					}
					")"
				);
			}
		} while ($data = fgetcsv($handle,1000,",","'"));

//ORG

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
	
		//redirect
		header('Location: import.php?success=1'); die;

	}
	
}
/*
//http://wininterview.blogspot.in/2013/01/read-and-write-csv-file-in-php.html
$row = 1;
if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
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
  Choose your file: <br />
  <input type="file" name="csv" id="csv" />
  <input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>
