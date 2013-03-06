<?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script language="javascript">
	function editCategory(categoryId)
	{
		var passValues = document.getElementById("passCategoryId");
		var passId=document.getElementById("categoryId"); 
		passId.setAttribute('value',categoryId);
		passValues.submit();
		
	}
</script>
</head>
<body>
	<?php include("header.php"); ?>
    <div class="content">
		<?php
			if(isset($_COOKIE["login"]) && $_COOKIE["login"])
			{
				echo '<div class="sidebar">';
				$con = connect();
				$categories = mysql_query("SELECT * FROM question_categories");
				echo '<ul>';
				while($row = mysql_fetch_array($categories))
				{
					echo '<li>
							<a href="#' . $row['id'] . '" onclick="editCategory('.$row['id'].')">' . $row['category_name'] . '</a>
						</li>';
				}
				echo '<li>
						<a href="edit_admin.php" target="edit-frame">Edit Admins</a>
					</li>';
				echo '</ul>';
				echo '</div>';
				echo '<div class="admin-content"><iframe name="edit-frame" id="edit-frame"></iframe></div>';
				echo '<form id="passCategoryId" target="edit-frame" method="post" action="edit.php"><input name="categoryId" id="categoryId" type="hidden" value="0" /></form>';
			}
			else
			{
				echo '<h2>Please sign in to access the admin page.</h2>';
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