<html>
	<head>
	<title>WAH - Wicked Awesome History</title>
	<script type="text/javascript">
	function setAnswer() {
		window.correctAnswer=document.getElementById('correct');
		window.correctAnswer.id="";
		window.story=document.getElementById('story').innerHTML;
		document.getElementById('story').innerHTML="";
		document.getElementById('story').style.display="none";
		document.getElementById('result').style.display="none";
		document.getElementById('continueGame').style.display="none";
	}
	function checkAnswer(answer) {
		if(window.correctAnswer.checked)
		{
			document.getElementById('result').innerHTML="Congratulations, you got the answer correct!";
			window.correct=true;
		}
		else
		{
			document.getElementById('result').innerHTML="Incorrect, read the following story and learn some damn history:";
			window.correct=false;
		}
		document.getElementById('story').innerHTML=window.story;
		document.getElementById('story').style.display="block";
		document.getElementById('result').style.display="block";
		document.getElementById('continueGame').style.display="block";
		document.getElementById("questionForm").style.display="none";
		//window.parent.document.getElementById('lightbox-container').className='';
	}
	function exit() {
		window.parent.document.getElementById('lightbox-container').className='';
		window.parent.questionCorrect=window.correct;
		if(!window.correct)
		{
			window.parent.currentPlayer=(window.parent.currentPlayer+1)%window.parent.totalPlayers;
			window.parent.document.getElementById('currentPlayer').innerHTML="Player "+(window.parent.currentPlayer+1)+"'s turn";
		}
		else
		{
			if(window.parent.player[window.parent.currentPlayer].val.className.indexOf("advanceSpot")!=-1)
				window.parent.advanceNodes();
		}
	}
	</script>
	</head>
	<body onload="setAnswer();">

	<?php
		$con=mysql_connect("db.csh.rit.edu","hilton","[database_password]"); 
		mysql_select_db("hilton_boardgame", $con);
		
		$categoryId=$_POST['category_id'];
		$tableNames=mysql_query("SELECT category_table_name FROM question_categories");
		//echo $tableNames;
		mysql_data_seek($tableNames,$categoryId);
		$tableName = mysql_fetch_row($tableNames);
		$questionsData=mysql_query("SELECT * FROM " . $tableName[0]);
		$questionData=null;
		if(mysql_num_rows($questionsData)>1)
		{
			$questionId=rand(0,mysql_num_rows($questionsData)-1);
			mysql_data_seek($questionsData,$questionId);
			$questionData=mysql_fetch_array($questionsData);
		}
		else
		{
			$questionData=mysql_fetch_array($questionsData);
		}
		$wrongAnswers=explode("\n",$questionData['wrong_answers']);
		for($i=0; $i<count($wrongAnswers); $i++)
		{
			if($wrongAnswers[$i]=="")
			{
				unset($wrongAnswers[$i]);
			}
		}
		$wrongAnswers=array_values($wrongAnswers);
		$correctPosition=rand(0,count($wrongAnswers)+1);
		$correctAnswer=$questionData['correct_answer'];
		$story = $questionData['story'];
		$placed=false;
		echo '<h4>' . $questionData['question'] . '</h4>';
		echo '<form id="questionForm">';
		for($i=0; $i<count($wrongAnswers); $i++)
		{
			if($i==$correctPosition)
			{
				echo '<label><input id="correct" type="radio" name="answers" value="' . $correctAnswer .'" >' . $correctAnswer . '</label><br>';
				$placed=true;
			}
			echo '<label><input type="radio" name="answers" value="' . $wrongAnswers[$i] .'" >' . $wrongAnswers[$i] . '</label><br>';
		}
		if(!$placed)
		{
			echo '<label><input id="correct" type="radio" name="answers" value="' . $correctAnswer .'?" >' . $correctAnswer . '</label><br>';
		}
		echo '<input type="button" id="testMagic" onclick="checkAnswer()" value="Submit Answer" />';
		echo '</form>';
		echo '<h4 id="result"></h4>';
		echo '<p id="story">' . $story . '</p><br><a href="#" id="continueGame" onclick="exit()">Click to continue</a>';
	?>
	</body>
</html>