<?php
	include("database.php");
	$con=connect();
	$categoryId = $_POST['category-id'];
	
	$tableNames=mysql_query("SELECT category_table_name FROM question_categories WHERE `id`='".$categoryId."'");
	
	$tableName = mysql_fetch_row($tableNames);
	$category = $tableName[0];
	$questionId=$_POST["question-id"];
	$question=$_POST["question"];
	$correctAnswer=$_POST["correct_answer"];
	$story=$_POST["story"];
	//gets all of the wrong answers
	$wrongAnswers="";
	$count=0;
	while(isset($_POST["wrong_answer_" . $count]))
	{
		$wrongAnswers.=($_POST["wrong_answer_" . $count] . "\n");
		$count+=1;
	}
	
	//replaces all of the quotes with \"
	$wrongAnswers=str_replace('"','\"',$wrongAnswers);
	
	mysql_query("UPDATE " . $category . " SET  
			`question`='".$question."',
			`wrong_answers`='".str_replace("'","&#39;",$wrongAnswers)."',
			`correct_answer`='".$correctAnswer."',
			`story`='".$story."'
			WHERE `id`=" . $questionId . ";");
?>