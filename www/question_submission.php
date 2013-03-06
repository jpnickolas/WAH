<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
 <script type="text/javascript">
 function add() {
	//adds a new wrong answer slot
	var count=document.getElementById('wrongAnswers').children.length;
	if(count>0)
	{
		var children=document.getElementById('wrongAnswers').children;
		children[children.length-1].insertAdjacentHTML('afterend','<input type="text" name="wrong_answer_'+(count/2+1)+'" id="wrong_answer_'+(count/2+1)+'" placeholder="Enter a wrong answer" /><br>');
	}
	else
		document.getElementById('wrongAnswers').innerHTML='<input type="text" name="wrong_answer_'+(count/2+1)+'" id="wrong_answer_'+(count/2+1)+'" placeholder="Enter a wrong answer" /><br>';
 }
 function remove() {
	//removes the last wrong answer slot
	var count=document.getElementById('wrongAnswers').children.length;
	
	if(count>0)
	{
		var node=document.getElementById('wrongAnswers');
		node.removeChild(node.children[node.children.length-1]);
		if(count>1)
			node.removeChild(node.children[node.children.length-1]);
	}
		//document.getElementById('wrongAnswers').innerHTML-='<input type="text" name="wrong_answer_'+(count)+'" id="wrong_answer_'+(count+1)+'" placeholder="Enter a wrong answer" /><br>';
 }
 function addNewCategory() {
	//prompts the user for a new category
	document.getElementById('newCategory').innerHTML='<input type="text" name="new_category" id="new_category" placeholder="Enter the new category" /><br>';
 }
 </script>
 </head>
 <body>
	<?php include("header.php"); ?>
    <div class="content">
	<form name="question_form" id="submit-question-form" action="add_question.php" method="post">
		<select name="category">
			<option value="" selected>--Select Category--</option>
			<?php
				$con=connect();
				$rows = mysql_query("SELECT * FROM question_categories");
				while($row = mysql_fetch_array($rows))
				{
					echo '<option onclick="document.getElementById(\'newCategory\').innerHTML=\'\'" value="' . $row['category_table_name'] . '">' . $row['category_name'] . "</option>\n";
				}
				echo "<option value=\"new_category\" onclick=\"addNewCategory()\">--New Category--</option>";
				mysql_close($con);
			?>
		</select><br>
		<div id="newCategory"></div>
		<input type="text" name="question" id="question" placeholder="Enter your question" /><br>
		<input type="text" name="correct_answer" id="correct_answer" placeholder="Enter the correct answer" /><br>
		<input type="button" value="Add Answer" onclick="add()" />
		<input type="button" value="Remove Answer" onclick="remove()" />
		<div id="wrongAnswers">
			<input type="text" name="wrong_answer_1" id="wrong_answer_1" placeholder="Enter a wrong answer" /><br>
		</div>
		<textarea name="story" placeholder="Enter the story of this question here"></textarea>
		<input type="submit" value="Submit"  />
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