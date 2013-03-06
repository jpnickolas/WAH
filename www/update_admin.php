<?php
	include("database.php");
	if(isset($_COOKIE["login"]) && $_COOKIE["login"])
	{
		$con=connect();
		$query="UPDATE admin_usernames SET 
				`username`='" . $_POST['username'] . "',
				`password`='".$_POST['password']."'
				WHERE `id`='" . $_POST['adminId'] . "';";
		mysql_query($query);
	}
	else
	{
		echo 'Please sign in and try again.';
	}
?>