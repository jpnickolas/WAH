<?php
	include("database.php");
	$loginFailed=true;
	if(isset($_COOKIE["login"]) && $_COOKIE["login"])
	{
		$loginFailed=false;
	}
	if(isset($_POST["username"]) && isset($_POST["password"]))
	{
		$loginFailed=true;
		$con = connect();
		$username = $_POST["username"];
		$password = $_POST["password"];
		$credentials = mysql_query("SELECT * FROM admin_usernames");
	
		while($user=mysql_fetch_array($credentials))
		{
			if($username == $user["username"] && $password==$user["password"])
			{
				$loginFailed=false;
				setcookie("login",true,time()+60*60*24);
				setcookie("user",$_POST["username"],time()+60*60*24);
				break;
			}
		}
		if(!$loginFailed)
		{
			header('Location: '.$_SERVER['REQUEST_URI']);
		}
	}
?>