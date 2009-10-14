<div id="modaldiv">
	<div id="modalbox">
		<div id="modalclose"><p><a href="javascript:modalClose()">Close&nbsp;<img src="img/delete.png" alt="X" /></a></p></div>
		<div id="modalcontent"></div>
		<div id="extracontent"></div>
		<div id="ajaxloader" style="display:none"><img src="img/ajax-loader.gif" alt="saving" /></div>
	</div>
</div>

<?php
	$array = explode('/',$_SERVER['SCRIPT_NAME']);
	$filename = $array[count($array)-1];
?>

<?php if($_GET['login']=="username" && $filename=="index.php"){ ?>
<script type="text/javascript" language="javascript">
	modalBox('Username does not exist',250,150);
</script>
<?php } elseif($_GET['login']=="password" && $filename=="index.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Password is incorrect',250,150);
</script>
<?php } elseif($_GET['register']=='true' && $filename=="index.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Registration successful, you may now login!',250,150);
</script>
<?php } elseif($_GET['register']=='fail' && $filename=="register.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Registration failed, username and/or password already in use',250,150);
</script>
<?php } elseif($_GET['confirm']=='true' && $filename=="index.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Your account has been confirmed, you can now login!',250,150);
</script>
<?php } elseif($_GET['confirm']=='false' && $filename=="index.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Account confirmation failed',250,150);
</script>
<?php } elseif($_GET['confirm']=='needs' && $filename=="index.php") { ?>
<script type="text/javascript" language="javascript">
	modalBox('Account confirmation is required before using notetakr.  Please check your email.',250,200);
</script>
<?php } ?>