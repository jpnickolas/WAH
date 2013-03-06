<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<script language="Javascript" type="text/javascript" src="js/functions.js"> </script>
<link rel="stylesheet" type="text/css" href="styles.css">
<style>
<?php
	for($i=0; $i<$_POST['players']; $i++)
	{
		echo '#player-' . ($i+1) . ' {
			background: #' . dechex(rand(0,16*16*16-1)) . ';
		}
		';
	}
?>
</style>
</head>

<?php
	$con=connect(); 
	$tablesize=9;
	$rings=3;
	//get database values
	$tableIds=mysql_query("SELECT * FROM question_categories");
	
	//gets the categories the user chooses
	$dbCategories=$_POST['selectedCategories'];
	
	//gets the category names
	$categoryNames=array_fill(0,count($dbCategories)-1,"");
	
	//gets the category id's
	$i=0;
	while($row=mysql_fetch_array($tableIds))
	{
		if(in_array($row["id"], $dbCategories))
		{
			$categoryNames[$i] = $row['category_name'];
			if($categoryNames[$i]=="")
				$categoryNames[$i]="*";
			$i++;
		}
	}
	
	//loads the head and scripts
	//loads the initialize function, and initializes the board nodes
	echo "<body onload=\"initialize(document.getElementById('gameBoard'), " . $rings . ",";
	
	//sends the array of category names and id's to the javascript file
	echo '[';
	for($x=0; $x<count($dbCategories); $x++)
	{
		if($x!=0)
			echo ',';
		echo $dbCategories[$x];
	}
	echo '],';
	echo '[';
	for($x=0; $x<count($categoryNames); $x++)
	{
		if($x!=0)
			echo ',';
		echo "'" . $categoryNames[$x] . "'";
	}
	echo '],';
	
	//gets the number of players
	echo $_POST['players'] . ");\">";
	?>
	<?php include("header.php"); ?>
    <div class="content">
	<a id="instructions" onclick="instructions()">Click here for instructions</a><br><br>
	<?php
	echo '<p>';
	for($i=0; $i<$_POST['players']; $i++)
	{
		echo 'Player ' . ($i+1) . " = <span id='player-" . ($i+1) . "'>&nbsp</span> ";
	}
	echo '</p>';
	echo "<div id='lightbox-container'><div id='lightbox-background'></div><div id='lightbox'></div></div>";
	echo "<table id=\"gameBoard\">";
	$middleMade = false;
	
	//creates all of the table cells for the board with the respective class names based on the ring
	for($x=0; $x<$tablesize; $x++) {
		echo "<tr>";
		for($y=0; $y<$tablesize; $y++) {
			$classname = "";
			for($ring=0; $ring<$rings; $ring++)
			{
				if($x==$ring || $y==$ring || $x==$tablesize-1-$ring || $y ==$tablesize-1-$ring)
				{
					$classname="ring-" . ($ring+1);
					
					break;
				}
			}
			if($classname == "") {
				if(!$middleMade) {
					$middleSize = $tablesize-($rings*2);
					echo '<td class="finalQuestion" rowspan="' . $middleSize . '" colspan="' . $middleSize . '"></td>';
					$middleMade=True;
				}
			}
			else {
				echo '<td border="1" class="' . $classname . '"><div class="categoryTitle"></div><div class="playerContainer"></div></td>';
			}
		}
		echo "</tr>";
	}
	echo "</table>";
	
	//creates a hidden form to send to the question form
	echo "<form name=\"magic_form\" action=\"question.php\" target=\"magic_frame\" method=\"post\"><input id=\"category_id\" type=\"hidden\" name=\"category_id\" value=\"\" /></form>";
?>
	</div>
    <div class="footer">
        <div class="menu">
        	<ul>
            	<li><a href="setup.php">Start Game</a></li>
            	<li><a href="question_submission.php">Submit a Question</a></li>
            	<li><a href="about.php">About WAH</a></li>
            </ul>
        </div>
        <div class="copyright">
        	&copy; 2013 - <a href="mailto:hilton@csh.rit.edu">Nick Hilton</a>
        </div>
    </div>
</body>
</html>