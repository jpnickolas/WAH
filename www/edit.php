<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
 <script type="text/javascript">
 function add(i) {
	//adds a new wrong answer slot
	var count=document.getElementById('wrongAnswers_'+i).children.length;
	if(count>0)
	{
		var children=document.getElementById('wrongAnswers_'+i).children;
		children[children.length-1].insertAdjacentHTML('afterend','<input type="text" name="wrong_answer_'+(Math.floor(count/2+1)-1)+'" id="wrong_answer_'+(Math.floor(count/2+1)-1)+'" placeholder="Enter a wrong answer" /><br>');
	}
	else
		document.getElementById('wrongAnswers_'+i).innerHTML='<input type="text" name="wrong_answer_'+(Math.floor(count/2+1)-1)+'" id="wrong_answer_'+(Math.floor(count/2+1)-1)+'" placeholder="Enter a wrong answer" /><br>';
 }
 function remove(i) {
	//removes the last wrong answer slot
	var count=document.getElementById('wrongAnswers_'+i).children.length;
	
	if(count>0)
	{
		var node=document.getElementById('wrongAnswers_'+i);
		node.removeChild(node.children[node.children.length-1]);
		if(count>1)
			node.removeChild(node.children[node.children.length-1]);
	}
		//document.getElementById('wrongAnswers').innerHTML-='<input type="text" name="wrong_answer_'+(count)+'" id="wrong_answer_'+(count+1)+'" placeholder="Enter a wrong answer" /><br>';
 }
 function deleteQuestion(i)
 {
	var form=document.forms["question-edit-form-"+i];
	form.setAttribute("action","delete_question.php");
	form.submit();
	form.parentNode.removeChild(form);
 }
 </script>
 </head>
 <body>
 <style>
	 input[type="text"],textarea{
		width:700px !important;
	 }
 </style>
<?php
	if($loginFailed)
	{
		echo "Please sign in and try again.";
	}
	else
	{
		$con = connect();
		
		$categoryId=$_POST["categoryId"];
		$categories=mysql_query("SELECT category_table_name FROM question_categories WHERE `id`='".$categoryId."'");
		$category = mysql_fetch_row($categories);
		$category = $category[0];
		$questionsData=mysql_query("SELECT * FROM " . $category);
		$i=0;
		while($question = mysql_fetch_array($questionsData))
		{
			echo '<form name="question-edit-form-' . $i . '" method="post" action="update_question.php" target="confirmation-frame-' . $i . '">
					<input type="hidden" name="question-id" value="'.str_replace('"','&#34;',$question['id']) .'" />
					<input type="hidden" name="category-id" value="' .str_replace('"','&#34;',$categoryId) .'" />
					<p>Question:</p>
					<input type="text" name="question" id="question" value="' . str_replace('"','&#34;',$question['question']) . '" /><br>
					<p>Correct Answer:</p>
					<input type="text" name="correct_answer" id="correct_answer" value="' . str_replace('"','&#34;',$question['correct_answer']) . '" /><br>
					<input type="button" value="Add Answer" onclick="add('.$i.')" />
					<input type="button" value="Remove Answer" onclick="remove('. $i . ')" />';
					
			echo '	<div id="wrongAnswers_'.$i.'">';
			echo '  <p>Incorrect Answers:</p>';
			
			$wrongAnswers=explode("\n",$question['wrong_answers']);
			for($j=0; $j<count($wrongAnswers); $j++)
			{
				if($wrongAnswers[$j]=="")
				{
					unset($wrongAnswers[$j]);
				}
			}
			for($j=0; $j<count($wrongAnswers); $j++)
				echo '<input type="text" name="wrong_answer_'.$j.'" id="wrong_answer_'.$j.'" value="' . str_replace('"','&#34;',$wrongAnswers[$j]) . '" /><br>';
			echo '	</div>';
					
			echo'	<p>Story:</p>
					<textarea name="story" >'.str_replace('"','&#34;',$question['story']).'</textarea>
					<input type="submit" value="Submit"  />
					<input type="button" value="Delete Question" onclick="deleteQuestion('.$i.');" />
				</form>';
			echo '<iframe class="confirmation-frame" name="confirmation-frame-' . $i . '"></iframe>';
			$i+=1;
		}
	}
?>
</body>
</html>