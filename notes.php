<?php include_once('includes/pageInit.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="A fast, easy, and ajax powered note taking web application.">
<meta name="keywords" content="note, notes, ajax, javascript, web 2.0, fast, easy, notetaking, class, business">
<title>notetakr - note editor</title>
<link href="css/notes.css" type="text/css" rel="stylesheet" />
<link href="css/modalbox.css" type="text/css" rel="stylesheet" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script src="js/modalbox.js" type="text/javascript"></script>
<script src="js/backend.js" type="text/javascript"></script>
<script src="js/notes.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "table,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,flash,searchreplace,print,contextmenu",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	plugin_insertdate_dateFormat : "%Y-%m-%d",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_data/example_link_list.js",
	external_image_list_url : "example_data/example_image_list.js",
	flash_external_list_url : "example_data/example_flash_list.js"
});
</script>
</head>
<body onload="javascript:initPageDesign();" onresize="javascript:initPageDesign()">

<!-- include the modaldiv -->
<?php include_once('includes/modaldiv.php');?>

<div id="header-container">
	<div id="right-header"><img src="img/ajaxnotify.gif" alt="ajax notify" id="ajaxnotify" style="display:none" /></div>
	<div id="center-header"><p>notetakr - <?php echo $pagetitle; ?></p></div>
</div>
<div id="left-panel">
	<div id="nav">
		<a href="home.php"><img src="img/home.png" alt="Home" name="Home" /></a>&nbsp;<a href="javascript:newNote()" name="New Note"><img src="img/note_add.png" alt="New Note" /></a>&nbsp;<a href="logout.php"><img src="img/logout.png" alt="Logout" name="Logout" /></a><br />
		<form method="post" action="javascript:changeEditorFolder()" onchange="javascript:changeEditorFolder()" name="foldermenu" id="foldermenu">
		<?php getFolderDropDown(); ?>
		</form>
	</div>
	<div id="left-panel-content">
		<?php
			outputList();
		?>
	</div>
</div>
<div id="editor">
	<form method="post" action="<?php if($_GET['note']){ echo "javascript:ajaxSave()";} else { echo "javascript:modalInitialSaveBox('Enter name and choose folder.',300,250)"; }?>" name="editorform" id="editorform">
		<textarea name="editorinput" cols="100" id="editorinput"><?php echo $pagecontent; ?></textarea>
	<p id="savebuttons"><input type="submit" name="submit" id="notesubmit" value="Save" />&nbsp;
	<a id="saveas" href="javascript:modalInitialSaveBox('Enter name and choose folder',300,250)">Save As</a></p>
</form>
</div>
<div id="dummytext" style="display:none"></div>
</body>
</html>
<?php mysql_close(); ?>
