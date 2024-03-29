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
        <h3>About WAH</h3>
		<p>
			Wicked Awesome History (<strong>WAH</strong>) is a board game similar to <a href="http://boardgamegeek.com/boardgame/1362/wits-end" target="blank">Wits End</a>.
			It is a trivia game that is (supposed to be) based around house history and stories, although the form is set up so that you can post any kind of questions or
			nonesense you want. It's a fairly simple game. You roll the die to determine how far you move. You move that distance in either one direction or the other, you
			chose. When you land on a spot, you answer a question about that category of history. If you get it correct, you roll again. If you fail and get it wrong, the 
			next player rolls. If you answer a question correctly on an advance square (located at the center of each side of the board), then you advance closer to the center.
			If you make it to the center, you win! 
		</p>
		<p>
			This game is my first real attempt at using php and databases. It's made with a combination of php, mysql, and vanilla javascript. I feel like a terrible person 
			for how everything is coded, but so be it. This was a wonderful opportunity for learning, and I have future projects to improve the coding style. I am proud of the
			outcome. 
		</p>
		<p>
			You can add a question by clicking the <a href="question_submission.php">submit a question button</a>, but I am not responsible for the nature of the question
			you post. I specifically added fairly clean stories. Also, be sure to include as complete a story as possible. It's fun to know the stories of old farts. 
		</p>
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