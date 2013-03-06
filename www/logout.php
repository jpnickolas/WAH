<?php setcookie("login",false,time()+60*60); ?>
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
			if(isset($_COOKIE["login"]) && $_COOKIE["login"])
			{
				echo 'Success!!!';
			}
			else
			{
				echo 'Failure :(';
			}
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