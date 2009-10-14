<?php
session_start();
include_once('includes/folderfunctions.php');
include_once('includes/dbconnect.php');
if(!isset($_SESSION['userID'])){ header('Location: index.php'); exit; }

/*Retrieve last modified note ID*/
$query = "SELECT postID FROM notes WHERE userID='".$_SESSION['userID']."' ORDER BY lastmodified DESC LIMIT 1";
$result = mysql_query($query);
$data = mysql_fetch_row($result);
$lastmodified = $data[0];
?>

<?php
	$organizerhelp = "<ul>
	<li><p><img src=\"img/bullet_go.png\" alt=\"go\" />&nbsp;Click and drag to organize notes</p></li>
	<li><p><img src=\"img/delete.png\" alt=\"delete\" />&nbsp;Click to delete a note</p></li>
	<li><p><img src=\"img/folder_edit.png\" alt=\"edit\" />&nbsp;Click to edit a folders name</p></li>
	<li><p><img src=\"img/folder_delete.png\" alt=\"delete folder\" />&nbsp;Click to delete a folder.  More options after click</p></li>
</ul>"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="A fast, easy, and ajax powered note taking web application.">
<meta name="keywords" content="note, notes, ajax, javascript, web 2.0, fast, easy, notetaking, class, business">
<title>notetakr!</title>
<link href="css/styles-home.css" type="text/css" rel="stylesheet" />
<link href="css/modalbox.css" type="text/css" rel="stylesheet" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script src="js/modalbox.js" type="text/javascript"></script>
<script src="js/backend.js" type="text/javascript"></script>
</head>
<body onload="javascript:checkForms('home');">

<!-- run the modaldiv checks -->
<?php include_once('includes/modaldiv.php');?>

<div id="header-container">
	<div id="header"></div>
</div>
<div id="content-container">
	<div id="left-container">
		<div class="left-item" style="text-align: center;cursor:pointer;" onclick="javascript:window.location='notes.php';">
			<h3>Start a New Note</h3>
		</div>
		<div class="left-item">
			<div class="content-item-title"><p>Quick Links</p></div>
			<ul>
				<li><p><a href="notes.php?note=<?php echo $lastmodified; ?>">Open Last Note</a></p></li>
				<li><p><a href="http://forums.notetakr.com">Notetakr Forums</a></p></li>
				<li><p><a href="http://blog.notetakr.com">Developer Blog</a></p></li>
				<li><p><a href="logout.php">Logout</a></p></li>
			</ul>
		</div>
		<div class="left-ad">
			<script type="text/javascript"><!--
			google_ad_client = "pub-6696775752725393";
			//200x200, created 12/19/07
			google_ad_slot = "6374910673";
			google_ad_width = 200;
			google_ad_height = 200;
			//--></script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	</div>
	<div id="right-container">
		<div class="right-item">
			<form enctype="multipart/form-data" action="includes/search.php" id="searchform" name="searchform" method="post">
				<p><input name="searchfield" type="text" id="searchfield" value="document search" onfocus="javascript:switchSearchForm()" onkeyup="documentSearch()" /></p>
				<input name="search" type="submit" id="submit" style="display:none" />
			</form>
			<div id="searchresults" style="display:none">
				<p>Please enter at least 3 letters.</p>
				<div class="searchclose"><p><a href="javascript:searchClose()">Close&nbsp;<img src="img/delete.png" alt="X" /></a></p></div>
			</div>
		</div>
		<div class="right-item">
			<div class="content-item-title" style="height: 50px">
				<p>Document Tree/Organizer</p>
				<p style="font-size:14px"><a href="javascript:modalNewFolder('Enter the name for the new folder.',350,250)"><img src="img/folder_add.png" alt="Add Folder" />&nbsp;Add Folder</a> | <a href="javascript:modalBox('organizer help',350,250)">Organizer Help</a></p>
			</div>
			<div id="doctree">
				<?php outputDocTree(); ?>
			</div>
		</div>
	</div>
</div>
<div id="rays"></div>
<div id="footer">
	<p>designed and coded by ryan "meltingice" lefevre copyright <?php echo date('Y'); ?></p>
	<p>ajax powered by <a href="http://script.aculo.us">scriptaculous</a> and <a href="http://prototypejs.org">prototype</a></p>
	<p>I'm not old enough to ask for beer money donations, but if you want to give a hard-working college kid a little extra money, I would gladly accept a donation anyways. <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form></p>
</div>
</body>
</html>
<?php mysql_close(); ?>