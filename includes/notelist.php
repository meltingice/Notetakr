<?php
	session_start();
	include_once('dbconnect.php');
	include_once('globals.php');
	
	if($_GET['parent'])
	{
		$parent = cleanseInput($_GET['parent']);
		outputList($parent);
	}
	
	function outputList($parent=-2)
	{
		if($parent==-2)
		{
			$query = "SELECT postID,title,lastmodified FROM notes WHERE userID='".$_SESSION['userID']."' ORDER BY title ASC";
		}
		elseif($parent==-1)
		{
			$query = "SELECT postID,title,lastmodified FROM notes WHERE userID='".$_SESSION['userID']."' AND parent='0' ORDER BY title ASC";
		}
		else
		{
			$query = "SELECT postID,title,lastmodified FROM notes WHERE userID='".$_SESSION['userID']."' AND parent='$parent' ORDER BY title ASC";
		}
		$result = mysql_query($query);
		
		$index=0;
		echo "<ul>";
		while(list($postID,$title,$lastmodified) = mysql_fetch_row($result))
		{
			$index++;
			$time = strtotime($lastmodified);
			$timestamp = date('m/d/Y \@ H:i', $time);
			echo "<li><p><a href=\"javascript:ajaxLoad($postID,'".cleanseInput($title)."')\">$title</a></p><p style=\"font-size:12px;\">($timestamp)</p></li>";
			
		}
		if($index==0)
		{
			echo "<li><p>No notes in this folder</p></li>";
		}
		echo "</ul>";
	}
?>