<?php
	session_start();
	include_once('dbconnect.php');
	include_once('globals.php');
	
	if($_POST['updatelist']==true)
	{
		$folder = cleanseInput($_POST['folnum']);
		updateDocTree($_POST['folder'],$folder);
	}
	
	if($_POST['newfolder']){ addNewFolder($_POST['newfolder']); }
	if($_POST['editfolder']){ editFolderName($_POST['editfolder'],$_POST['folderID']); }
	if($_GET['deletefolder']){ deleteFolder($_GET['deletefolder'],$_GET['move']); }
		
	function getFolderDropDown()
	{
		$query1 = "SELECT folderID,foldername FROM folders WHERE userID='".$_SESSION['userID']."'";
		$result1 = mysql_query($query1);
		$query2 = "SELECT parent FROM notes WHERE postID='".$_SESSION['postID']."'";
		$result2 = mysql_query($query2);
		$parent = mysql_fetch_row($result2);
		
		echo "<select name=\"folderselect\">\n";
		echo "<option name=\"-2\" value=\"-2\">Show All Notes</option>";
		echo "<option name=\"-1\" value=\"-1\" ";

		if($parent[0]==0)
		{
			echo "selected>Uncategorized</option>";
		}
		else
		{
			echo ">Uncategorized</option>";
		}
		
		while(list($folderID,$foldername) = mysql_fetch_row($result1))
		{
			echo "<option name=\"$folderID\" value=\"$folderID\" ";
			if($parent[0]==$folderID)
			{
				echo "selected>$foldername</option>\n";
			} 
			else
			{
				echo ">$foldername</option>\n";
			}
		}
		echo "</select>\n";
	}
	
	function outputDocTree()
	{
		$query1 = "SELECT folderID,foldername FROM folders WHERE userID='".$_SESSION['userID']."' ORDER BY foldername ASC";
		$result1 = mysql_query($query1);
		$query2 = "SELECT postID,title,parent,lastmodified FROM notes WHERE userID='".$_SESSION['userID']."' ORDER BY title ASC";
		$result2 = mysql_query($query2);
		
		while(list($folderID,$foldername) = mysql_fetch_row($result1))
		{
			$folderIDarray[] = $folderID;
			$foldernamearray[] = $foldername;
		}
		while(list($postID,$title,$parent,$lastmodified) = mysql_fetch_row($result2))
		{
			$postIDarray[] = $postID;
			$titlearray[] = $title;
			$parentarray[] = $parent;
			$time = strtotime($lastmodified);
			$timestamp = date('m/d/Y \@ H:i', $time);
			$lastmodifiedarray[] = $timestamp;
		}
		$folderIDarray[] = 0;
		$foldernamearray[] = 'Uncategorized';
		
		for($i=0;$i<count($folderIDarray);$i++)
		{
			echo "<div class=\"foldercontainer\">\n";
			echo "<h3>";
			if($foldernamearray[$i]!='Uncategorized')
			{
				echo "<a href=\"javascript:editFolder(".$folderIDarray[$i].",'".cleanseInput($foldernamearray[$i])."')\"><img src=\"../img/folder_edit.png\" alt=\"Edit\" /></a>&nbsp;";
				echo "<a href=\"javascript:deleteFolder(".$folderIDarray[$i].")\"><img src=\"../img/folder_delete.png\" alt=\"Delete\" /></a>&nbsp;";
			}
			echo $foldernamearray[$i]."</h3>\n";
			echo "<ul id=\"folder_".$folderIDarray[$i]."\" style=\"list-style: none;padding-left: 20px;\">\n";
			for($i2=0;$i2<count($postIDarray);$i2++)
			{
				if($parentarray[$i2]==$folderIDarray[$i])
				{
					echo "<li id=\"note_".$postIDarray[$i2]."\">";
					echo "<p class=\"notename\"><img src=\"../img/bullet_go.png\" alt=\"anchor\" class=\"anchor\" />&nbsp;";
					echo "<a href=\"javascript:editNote(".$postIDarray[$i2].",'".cleanseInput($titlearray[$i2])."')\"><img src=\"../img/note_edit.png\" alt=\"edit\" /></a>&nbsp";
					echo "<a href=\"javascript:deleteNote(".$postIDarray[$i2].",true)\"><img src=\"../img/note_delete.png\" alt=\"Delete\" /></a>&nbsp;";
					echo "<a href=\"notes.php?note=".$postIDarray[$i2]."\">".$titlearray[$i2]."</a></p>";
					echo "<p class=\"notedate\">Last Modified: ".$lastmodifiedarray[$i2]."</p></li>\n";
				}
			}
			echo "</ul>\n";
			echo "</div>\n";
		}
		
		?>
		<script type="text/javascript" language="javascript">
			var e = new Array();
			<?php
				for($i3=0;$i3<count($folderIDarray);$i3++)
				{
					echo "e[$i3] = 'folder_".$folderIDarray[$i3]."';\n";
				}
			?>
			initializeDocTree(e);
		</script>
		<?php
	}
	
	function updateDocTree($notearray,$newparent)
	{
		foreach($notearray as $note)
		{
			$note = cleanseInput($note);
			$query = "UPDATE notes SET parent='$newparent' WHERE postID='$note' AND userID='".$_SESSION['userID']."'";
			$result = mysql_query($query);
		}
	}
	
	function addNewFolder($newfoldername)
	{
		$newfoldername = cleanseInput($newfoldername);
		$query = "INSERT INTO folders (
				`userID` ,
				`foldername`
				)
				VALUES (
				'".$_SESSION['userID']."', '$newfoldername'
				);";
		$result = mysql_query($query);
		mysql_close();
		header('Location: ../home.php');
	}
	
	function editFolderName($newname, $folderID)
	{
		$newname = cleanseInput($newname);
		$query = "UPDATE folders SET foldername='$newname' WHERE folderID='$folderID' AND userID='".$_SESSION['userID']."' LIMIT 1";
		$result = mysql_query($query);
		header('Location: ../home.php');
	}
	
	function deleteFolder($folderID,$move)
	{
		$folderID = cleanseInput($folderID);
		
		$query = "SELECT postID FROM notes WHERE parent='$folderID' AND userID='".$_SESSION['userID']."'";
		$result = mysql_query($query);
		
		if($move=='true')
		{
			while(list($postID) = mysql_fetch_row($result))
			{
				$query2 = "UPDATE notes SET parent='0' WHERE postID='$postID' AND userID='".$_SESSION['userID']."'";
				mysql_query($query2);
			}

		}
		elseif($move=='false')
		{
			while(list($postID) = mysql_fetch_row($result))
			{
				$query2 = "DELETE FROM notes WHERE postID='$postID' AND userID='".$_SESSION['userID']."'";
				mysql_query($query2);
			}
		}
		
		$delquery = "DELETE FROM folders WHERE folderID='$folderID' AND userID='".$_SESSION['userID']."' LIMIT 1";
		mysql_query($delquery);
		
		header('Location: ../home.php');
	}
?>