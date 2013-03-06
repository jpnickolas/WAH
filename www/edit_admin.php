 <?php include("login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>WAH - Wicked Awesome History</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<script language="javascript">
 function deleteAdmin(i)
 {
	var form=document.forms["admin-edit-form-"+i];
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
		$con=connect();
		$categoryId=$_POST["categoryId"];
		$admins=mysql_query("SELECT * FROM admin_usernames");
		
		$i=0;
		while($credentials = mysql_fetch_array($admins))
		{
			echo '<form name="admin-edit-form-' . $i . '" method="post" action="update_admin.php" target="confirmation-frame-' . $i . '">
					<p>Username:</p>
					<input type="hidden" name="adminId" id="adminId" value="' . $credentials['id'] . '" />
					<input type="text" name="username" id="username" value="' . $credentials['username'] . '" /><br>
					<p>Change Password:</p>
					<input type="password" name="password" id="password" value="' . $credentials['password'] . '" /><br>
					<input type="submit" value="Submit"  />
					<input type="button" value="Delete Admin" onclick="deleteAdmin('.$i.');" />
				</form>';
			echo '<iframe class="confirmation-frame" name="confirmation-frame-' . $i . '"></iframe>';
			$i+=1;
		}
		echo '<form name="admin-edit-form-' . $i . '" method="post" action="add_admin.php" target="confirmation-frame-' . $i . '">
				<p>Username:</p>
				<input type="text" name="username" id="username" /><br>
				<p>Change Password:</p>
				<input type="password" name="password" id="password" /><br>
				<input type="submit" value="Add New Admin" onclick="location.reload(true)"  />
			</form>';
		echo '<iframe class="confirmation-frame" name="confirmation-frame-' . $i . '"></iframe>';
	}
?>
</body>
</html>