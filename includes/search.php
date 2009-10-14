<?php
	include_once('dbconnect.php');
	include_once('globals.php');
	session_start();
	
	if($_GET['query'])
	{
		$query = cleanseInput($_GET['query']);
		$searchquery = "SELECT content,title,postID FROM notes WHERE (content LIKE '%".$query."%' OR title LIKE '%".$query."%') AND userID='".$_SESSION['userID']."'";
		$searchresult = mysql_query($searchquery);
		
		echo '<div class="searchclose"><p><a href="javascript:searchClose()">Close&nbsp;<img src="img/delete.png" alt="X" /></a></p></div>';
		$index=0;
		while(list($content,$title,$postID) = mysql_fetch_row($searchresult))
		{
			$content = html_entity_decode($content,ENT_QUOTES);
		    $index++;
		    if(strlen($content)>200)
		    {
		    	$first = stripos($content,$query);
		    	if($first>100)
		    	{
		    		$start = $first-100;
		    		$finish = $first+100;
		    	}
		    	elseif($first<=100)
		    	{
		    		$start = round($first/2,0);
		    		$finish = $first+100;
		    	}
		    	else
		    	{
		    		$start = 0;
		    		$finish = 200;
		    	}
		    	$excerpt = processContent(substr($content,$start,$finish));
		    	$excerpt = processSearch($excerpt)."...";
		    }
		    else
		    {
		    	$excerpt = processContent($content);
		    	$excerpt = processSearch($excerpt);
		    }
	    	echo "<div class='searchresult'>";
		    echo "<h3><a href=\"notes.php?note=".$postID."\">".htmlspecialchars($title)."</a></h3>";
		    echo "<p>".htmlspecialchars($excerpt)."</p>";
		    echo "</div>";
		}
		if($index==0)
		{
			echo "<p>No documents match your search query.</p>";
		}
		
		echo '<div class="searchclose"><p><a href="javascript:searchClose()">Close&nbsp;<img src="img/delete.png" alt="X" /></a></p></div>';
	}
	
	function processSearch($content)
	{
		$pattern = array('/<p>/','/<\/p>/','/&nbsp;/');
		$replace = array(' ',' ',' ');
		return preg_replace($pattern, $replace, $content);
	}
?>