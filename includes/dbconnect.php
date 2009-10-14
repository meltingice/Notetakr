<?php
	$mysqlhost = "localhost";
	$mysqluser = "user";
	$mysqlpass = "password";
	$mysqldb = "database";
	@mysql_pconnect($mysqlhost, $mysqluser, $mysqlpass) or die('Could not connect to MySQL Server!');
	@mysql_select_db($mysqldb)or die('Could not select database!');
?>