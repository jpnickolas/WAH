<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
	<?php include("header.php"); ?>
    <div class="content">
<?php
	
	$con=mysql_connect("db.csh.rit.edu","hilton","fiefdom1{stiffen"); 
	if(!$con)
	{
		echo "No database could be connected to at this time.";
	}
	mysql_select_db("hilton_boardgame", $con);
	$tableName = $_POST['category'];
	
	//makes the tablename only alphanumeric
	$table = preg_replace("/[^A-Za-z0-9]/","",$tableName);
	
	//checks if the user set up a new category
	if($table=='newcategory')
	
		//check if they sent over a new category value
		if(isset($_POST['new_category']))
		{
			//makes the tableName alphanumeric
			$tableName=$_POST['new_category'];
			$table = preg_replace("/[^A-Za-z0-9]/","",$tableName);
			
			//if it's only numeric (because mysql hates numeric names!), it tacks the letter n onto the end
			if(is_numeric($table))
				$table=$table . "n";
				
			//checks if the table exists
			if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"))!=1)
			{
			
				//creates it, and inserts the category to the end of the question category
				$rows = mysql_query("SELECT id FROM question_categories");
				mysql_query("CREATE TABLE " . $table . "(id INT NOT NULL AUTO_INCREMENT,question TEXT,wrong_answers LONGTEXT,correct_answer TEXT,story LONGTEXT, PRIMARY KEY ('id'))",$con);
				mysql_query('INSERT INTO question_categories VALUES (DEFAULT,"' . $table . '","' . $tableName . '")');
			}
		}
		
	//gets all of the wrong answers
	$wrongAnswers="";
	$count=1;
	while(isset($_POST["wrong_answer_" . $count]))
	{
		$wrongAnswers.=($_POST["wrong_answer_" . $count] . "\n");
		$count+=1;
	}
	
	//replaces all of the quotes with \"
	$wrongAnswers=str_replace('"','\"',$wrongAnswers);
	if(preg_replace("/[^A-Za-z]/","",$tableName)=="")
		$table=$table . "n";
	$story = str_replace('"','\"',$_POST['story']);
	$correct_answer=str_replace('"','\"',$_POST['correct_answer']);
	$question=str_replace('"','\"',$_POST['question']);
		
	//gets the last row in the table
	$rows = mysql_query("SELECT id FROM " . $table);
	$rows=mysql_num_rows($rows)+1;
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"))>0)
	{
		//inserts the question into the end of the table
		$query="INSERT INTO " . $table . ' VALUES (DEFAULT,"' . $question . '","' . $wrongAnswers . '","' . $correct_answer . '","'  . $story . '")';
		mysql_query($query);
		echo "<h2>Thank you</h2><h3>your question added successfully.</h3>";
	}
	else
	{
		//tells you if there is an error
		echo "<h2>There was an error uploading your question. Please try again, and if the issue persists, email me <a href='mailto:hilton@csh.rit.edu'>here</a>.</h2>";
		echo "<h4>Table " . $table . " does not exist.</h4>";
	}
	mysql_close($con);
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