<?php
	include("database.php");
	
	$con=connect();
	if(isset($_COOKIE["login"]) && $_COOKIE["login"])
	{
		if(isset($_POST['question-id']))
		{
			$categoryId = $_POST['category-id'];
			
			$tableNames=mysql_query("SELECT category_table_name FROM question_categories WHERE `id`='".$categoryId."'");
			
			$tableName = mysql_fetch_row($tableNames);
			$category = $tableName[0];
			mysql_query("DELETE FROM ".$category." WHERE `id`='".$_POST['question-id']."'");
		}
		else if(isset($_POST['username']))
		{
			if($_POST['username']==$_COOKIE['username'])
			{
				echo 'You cannot remove yourself as an admin';
			}
			else 
			{
				mysql_query("DELETE FROM admin_usernames WHERE `id`='".$_POST['adminId']."'");
			}
		}
	}
	else
	{
		echo 'Please sign in and try again.';
	}
?>