<?php 
	function connect() {
		$con=mysql_pconnect("db.csh.rit.edu","username","password");
		if(!$con)
		{
			echo "Could not connect to database.";
			return null;
		}
		mysql_select_db("hilton_boardgame", $con);
		return $con;
	}
?>