<html>
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
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
<?php
	
	$con=mysql_connect("db.csh.rit.edu","hilton","[database_password]"); 
	if(!$con)
	{
		echo "No database could be connected to at this time.";
	}
	mysql_select_db("hilton_boardgame", $con);
	$tableName = $_POST['category'];
	$table = preg_replace("/[^A-Za-z0-9]/","",$tableName);
	if($table=='newcategory')
		if(isset($_POST['new_category']))
		{
			$tableName=$_POST['new_category'];
			$table = preg_replace("/[^A-Za-z0-9]/","",$tableName);
			if(is_numeric($table))
				$table=$table . "n";
			if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"))!=1) 
			{
				$rows = mysql_query("SELECT id FROM question_categories");
				mysql_query("CREATE TABLE " . $table . "(id INT,question TEXT,wrong_answers LONGTEXT,correct_answer TEXT,story LONGTEXT)",$con);
				mysql_query("INSERT INTO question_categories VALUES (" . mysql_num_rows($rows) . ',"' . $table . '","' . $tableName . '")');
			}
		}
	$wrongAnswers="";
	$count=1;
	while(isset($_POST["wrong_answer_" . $count]))
	{
		$wrongAnswers.=($_POST["wrong_answer_" . $count] . "\n");
		$count+=1;
	}
	$wrongAnswers=str_replace('"','\"',$wrongAnswers);
	if(preg_replace("/[^A-Za-z]/","",$tableName)=="")
		$table=$table . "n";
	$rows = mysql_query("SELECT id FROM " . $table);
	$rows=mysql_num_rows($rows);
	$story = str_replace('"','\"',$_POST['story']);
	$correct_answer=str_replace('"','\"',$_POST['correct_answer']);
	$question=str_replace('"','\"',$_POST['question']);
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"))>0)
	{
		$query="INSERT INTO " . $table . " VALUES (" . $rows . ',"' . $question . '","' . $wrongAnswers . '","' . $correct_answer . '","'  . $story . '")';
		mysql_query($query);
		echo "<h2>Thank you</h2><h3>your question added successfully.</h3>";
	}
	else
	{
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
            	<li><a href="about.html">About WAH</a></li>
            </ul>
        </div>
        <div class="copyright">
        	&copy; 2013 - <a href="mailto:hilton@csh.rit.edu">Nick Hilton</a>
        </div>
    </div>
</body>
</html>