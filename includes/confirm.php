<?php
	include_once('dbconnect.php');
	include_once('globals.php');
	
	if($_GET['key'])
	{
		$userid = cleanseInput($_GET['user']);
		$key = cleanseInput($_GET['key']);
		
		$query = "SELECT confirmkey FROM users WHERE userID='$userid'";
		$result = mysql_query($query);
		$returnedkey = mysql_fetch_row($result);
		
		if($returnedkey[0] == $key)
		{
			$confirmquery = "UPDATE users SET confirmed='1' WHERE userID='$userid'";
			$confirmresult = mysql_query($confirmquery);
			if($confirmresult)
			{
				header('Location: ../index.php?confirm=true');
			}
			else
			{
				header('Location: ../index.php?confirm=false');
			}
		}
		
	}
?>