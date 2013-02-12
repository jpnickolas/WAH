<html>
<head>
<title>WAH - Wicked Awesome History</title>
<script language="Javascript" type="text/javascript" src="js/functions.js"> </script>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<?php
	$con=mysql_connect("db.csh.rit.edu","hilton","[database_password]"); 
	if(!$con)
	{
		echo "Could not connect to the database. Please try again.";
	}
	mysql_select_db("hilton_boardgame", $con);
	$tablesize=9;
	$rings=3;
	//get database values
	$tableIds=mysql_query("SELECT * FROM question_categories");
	$dbCategories=$_POST['selectedCategories'];
	$categoryNames=array_fill(0,count($dbCategories)-1,"");
	$i=0;
	foreach($dbCategories as $category)
	{
		mysql_data_seek($tableIds,(int)$category);
		$thisCategory=mysql_fetch_array($tableIds);
		$categoryNames[$i] = $thisCategory['category_name'];
		if($categoryNames[$i]=="")
			$categoryNames[$i]="*";
		$i++;
	}
	
	//loads the head and scripts
	//loads the initialize function, and initializes the board nodes
	echo "<body onload=\"initialize(document.getElementById('gameBoard'), " . $rings . ",";
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
	
		
	echo $_POST['players'] . ");\">";
	?>
	<div class="header">
    	<div class="branding">
            <h2 class="subtitle">Wicked Awesome History</h2>
            <h1 class="title">WAH</h1>
        </div>
        <div class="menu">
        	<ul>
            	<li><a href="setup.php">Start Game</a></li>
            	<li><a href="question_submission.php">Submit a Question</a></li>
            	<li><a href="about.html">About WAH</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
	<a id="instructions" onclick="instructions()">Click here for instructions</a><br><br>
	<?php
	echo "<div id='lightbox-container'><div id='lightbox-background'></div><div id='lightbox'></div></div>";
	//echo "<input type=\"button\" onclick=\"initialize(document.getElementById('gameBoard'), " . $rings . "));\"/>";
	/*
	echo '<style type="text/css">';
	for($i=0; $i<$rings; $i++) {
		echo ".ring-" . ($i+1) . "{background-color:#" . dechex(255-$i/$rings*255) . "0000}";
	}
	echo '</style>';*/
	echo "<table id=\"gameBoard\">";
	$middleMade = false;
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
	echo "<form name=\"magic_form\" action=\"question.php\" target=\"magic_frame\" method=\"post\"><input id=\"category_id\" type=\"hidden\" name=\"category_id\" value=\"\" /></form>";
?>
	</div>
    <div class="footer">
        <div class="menu">
        	<ul>
            	<li><a href="setup.php">Start Game</a></li>
            	<li><a href="question_submission.php">Submit a Question</a></li>
            	<li><a href="about.html">About WAH</a></li>
            </ul>
        </div>
        <div class="copyright">
        	&copy; 2013 - <a href="mailto:hilton@csh.rit.edu">Nick Hilton</a>
        </div>
    </div>
</body>
</html>