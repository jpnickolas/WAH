<?php
	include("database.php");
	if(isset($_COOKIE["login"]) && $_COOKIE["login"])
	{
		$con=connect();
		$query='INSERT INTO admin_usernames VALUES (DEFAULT,"' . $_POST['username'] . '","' . $_POST['password'] . '")';
		mysql_query($query);
	}
	else
	{
		echo 'Please sign in and try again.';
	}
?>