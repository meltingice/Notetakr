<?php
	session_start();
	include_once('includes/dbconnect.php');
	include_once('includes/notelist.php');
	include_once('includes/globals.php');
	include_once('includes/folderfunctions.php');
	
	if(!isset($_SESSION['userID'])){ header('Location: index.php'); exit; } //makes sure user is logged in
	
	if($_GET['note'])
	{
		$note = cleanseInput($_GET['note']);
		
		$_SESSION['postID'] = $note;
		$query = "SELECT userID,title,content,parent FROM notes WHERE postID='".$note."'";
		$result = mysql_query($query);
		
		$index=0;
		while(list($userID,$title,$content,$parent) = mysql_fetch_row($result))
		{	
			$index++;
			if($_SESSION['userID']!=$userID)
			{
				header('Location: home.php');
			}
			else
			{
				$pagetitle = $title;
				$pagecontent = $content;
			}
		}
		if($index==0)
		{
			header('Location: home.php');
		}
	}
	else
	{
		$pagetitle = "Untitled Document";
	}
?>