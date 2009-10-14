<?php
	session_start();
	include_once('dbconnect.php');
	include_once('globals.php');
	require_once('recaptchalib.php');
	
	if($_POST['username'])
	{
		$username = cleanseInput(strtolower($_POST['username']));
		$password = hash('sha256',$_POST['password']);
		
		$query = "SELECT userID,username,password,confirmed FROM users WHERE username='" . $username . "'";
		$result = mysql_query($query);
		$data = mysql_fetch_array($result, MYSQL_ASSOC);
		
		if($data['username'])
		{
		    if($password == $data['password'])
		    {
		    	$_SESSION['username'] = $username;
		    	$_SESSION['userID'] = $data['userID'];
		    	header('Location: ../home.php');
		    }
		    else
		    {
		    	header('Location: ../index.php?login=password');
		    }
		}
		else
		{
		    header('Location: ../index.php?login=username');
		}
		
	}
	else
	{
		header('Location: ../index.php');
	}
	
	mysql_close();
?>