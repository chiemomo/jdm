<?php

$names = array("Home","Explore","Archive","Blog","About Us");
$short_names = array("home","explore","archive","blog","about");

//using get data, find out which page we're at
$page_index = 0; //assume we're at home (the page at index 0)
if ($_GET){
	if ( isset($_GET['page']) ){
	
		//the function array_search will return the index of the array $short_name at which the value is $_GET['page']
		$page_index = array_search( $_GET['page'], $short_names );
	}
}


?>


<ul>
	<?php
	

		for ($i = 0; $i < count($names); $i++){
		
			if ($i == $page_index){
				$class_i="active";
			}
			else {
				$class_i="";
			}
			
			//if index of $short_names is bigger than 0, append value of $short_name to the URL
			if ($i > 0)
				$link_i = "index.php?page=" . $short_names[$i];
			//otherwise ($i should be 0) return url for home
			else $link_i = "index.php";
			
			?>
			
			<li><a href="<?php echo $link_i;?>" class="<?php echo $class_i;?>"><?php echo $names[$i];?></a></li>
			
			<?php
		}
	?>
</ul>
<p id="layoutdims"></p>