<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script type="text/javascript">
	function checkForm() {
		//checks if at least two categories are selected
		
		//gets all of the categories
		var categories = document.getElementsByName('selectedCategories[]');
		
		//gets all of the categories that are checked
		var checkedCategories=0;
		for(var i = 0; i< categories.length; i++)
			if(categories[i].checked)
				checkedCategories++;
		if(checkedCategories<2)
		{
			document.getElementById('issues').innerHTML="Choose at least two categories!";
			return false;
		}
		else
			return true;
	}
</script>
</head>
<body>
	<?php include("header.php"); ?>
    <div class="content">
        <form id="gameForm" onsubmit="return checkForm()" action="game.php" method="post" name="setup_game">
			<p>Select a number of categories for your game:</p>
            <?php
                $con=mysql_connect("db.csh.rit.edu","hilton","fiefdom1{stiffen"); 
                mysql_select_db("hilton_boardgame", $con);
                $rows = mysql_query("SELECT * FROM question_categories");
				
				//Gets all of the categories, and allows them to be selected
                while($row = mysql_fetch_array($rows))
                {
                    echo '<input type="checkbox" name="selectedCategories[]" value="' . $row['id'] . '">' . $row['category_name'] . "</input>\n";
                }
            ?>
			<p>Select the number of players for your game:
            <select name="players">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
			</p>
			<p id="issues"></p>
            <input type="submit" value="Submit" />
        </form>
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