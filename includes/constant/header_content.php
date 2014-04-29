<?php

$names = array("Home","Today's Quiz","Quiz Archives","Mobile Apps","Blog","About");
$links = array("index.php","todays_quiz.php","archive.php","apps.php","blog.php","about.php");

?>


<ul>
	<?php
	
		for ($i = 0; $i < count($names); $i++){
			if(!strpos($_SERVER['SCRIPT_NAME'], "/qb/".$links[$i]) and basename($_SERVER['SCRIPT_NAME']) ==  $links[$i]) { 
				$class = "active";
			}
			else
				$class = "";
		
			?>
			<li><a href="<?php echo $links[$i];?>" class="<?php echo $class;?>"><?php echo $names[$i];?></a></li>
			
			<?php
		}
	?>
</ul>
<p id="layoutdims"></p>