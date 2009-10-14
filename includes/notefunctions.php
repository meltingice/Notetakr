<?php
	session_start();
	include_once('dbconnect.php');
	include_once('globals.php');
	include_once('notelist.php');
	include_once('folderfunctions.php');

	if($_GET['folderlist']){ getFolderList(); }
	if($_POST['initcontent']){ ajaxInitSave($_POST['initcontent'],$_POST['title'],$_POST['folder']); }
	if($_POST['content']){ ajaxSave($_POST['content']); }
	if($_POST['finishinit']==true){ endInitState(); }
	if($_GET['getpostID']==true){ getPostID(); }
	if($_GET['loadnote']){ ajaxLoad($_GET['loadnote']); }
	if($_GET['deletenote']){ deleteNote($_GET['deletenote']); }
	if($_POST['editnote']){ editNote($_POST['editnote'],$_POST['noteID']); }
	
	function getFolderList()
	{
		$query = "SELECT folderID,foldername FROM folders WHERE userID='".$_SESSION['userID']."'";
		$result = mysql_query($query);
		
		echo '<form enctype="multipart/form-data" action="javascript:ajaxInitSave()" method="post" name="notesave">';
		echo "<p>Name: <input type=\"text\" name=\"notename\" /></p> \n";
		echo '<p>Folder: <select name="folderlist">';
		echo "<option name=\"-1\" value=\"-1\">Uncategorized</option>\n";
		while(list($folderID,$foldername) = mysql_fetch_row($result))
		{
			echo "<option name=\"$folderID\" value=\"$folderID\">$foldername</option>\n";
		}
		echo "</select></p>\n";
		echo "<p><input type=\"submit\" name=\"submit\" value=\"Save\" /></p>\n	";
		echo "</form>\n";
	}
	
	function ajaxInitSave($content,$title,$folder)
	{
		$processedContent = processContent($content);
		$content = cleanseInput($processedContent);
		$title = cleanseInput($title);
		$folder = cleanseInput($folder);
		
		$addquery = "INSERT INTO `notes` (
						`postID` ,
						`userID` ,
						`title` ,
						`creationdate` ,
						`lastmodified` ,
						`content` ,
						`parent`
						)
						VALUES (
							NULL , '".$_SESSION['userID']."', '$title', NOW( ) , NOW( ) , '$content', '$folder'
						)";
		$result = mysql_query($addquery);
		
		
		
		$getquery = "SELECT postID FROM notes WHERE title='$title' AND userID='".$_SESSION['userID']."'";
		$result = mysql_query($getquery);
		$data = mysql_fetch_row($result);
		
		$_SESSION['postID'] = $data[0];
	}
	
	function endInitState()
	{
		$query = "SELECT title FROM notes WHERE postID='".$_SESSION['postID']."'";
		$result = mysql_query($query);
		$data = mysql_fetch_row($result);
		
		echo "<p>notetakr - ".$data[0]."</p>";
	}
	
	function ajaxSave($content)
	{
		$processedContent = processContent($content);
		$content = cleanseInput($processedContent);
		
		$updatequery = "UPDATE notes SET content='$content',lastmodified=NOW() WHERE postID='".$_SESSION['postID']."' AND userID='".$_SESSION['userID']."'";
		$updateresult = mysql_query($updatequery);
	}
	
	function ajaxLoad($postID)
	{
		$postID = cleanseInput($postID);
		$query = "SELECT content FROM notes WHERE postID='$postID' AND userID='".$_SESSION['userID']."'";
		$result = mysql_query($query);
		if($result)
		{
			$content = mysql_fetch_row($result);
			echo html_entity_decode($content[0],ENT_QUOTES);
			$_SESSION['postID'] = $postID;
		}
	}
	
	function deleteNote($noteID)
	{
		$noteID = cleanseInput($noteID);
		
		$query = "DELETE FROM notes WHERE postID='$noteID' AND userID='".$_SESSION['userID']."' LIMIT 1";
		$result = mysql_query($query);
		
		header('Location: ../home.php');
	}
	
	function editNote($name,$noteID)
	{
		$name = cleanseInput($name);
		$noteID = cleanseInput($noteID);
		
		$query = "UPDATE notes SET title='$name' WHERE postID='$noteID' AND userID='".$_SESSION['userID']."' LIMIT 1";
		$result = mysql_query($query);
		
		header('Location: ../home.php');
	}
	
	function getPostID()
	{
		echo $_SESSION['postID'];
	}
?>