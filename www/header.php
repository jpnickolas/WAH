<div class="header">
	<div class="branding">
		<h2 class="subtitle">Wicked Awesome History</h2>
		<h1 class="title">WAH</h1>
	</div>
	<div class="menu">
		<ul>
			<li><a href="setup.php">Start Game</a></li>
			<li><a href="question_submission.php">Submit a Question</a></li>
			<li><a href="about.php">About WAH</a></li>
			<?php 
				if(isset($_COOKIE["login"]) && $_COOKIE["login"])
				{
					echo '<li><a href="admin.php">Admin Page</a></li>';
				}
				else
				{
					echo '<li>';
					echo '<form name="login_form" id="login-form" action="about.php" method="post">
							<input name="username" id="username" type="text" placeholder="Username" />
							<input name="password" id="password" type="password" placeholder="Password" />
							<input type="submit" value="Login" />
						</form>';
					echo '</li>';
				}
			?>
		</ul>
	</div>
</div>