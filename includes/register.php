<?php
	include_once('dbconnect.php');
	include_once('globals.php');
	require_once('recaptchalib.php');
	
	/*reCaptcha validation code*/
	$privatekey = "6LdS1AAAAAAAAP-OtHVwncfjOiqkC2JiRhpD5zz0";
	$resp = recaptcha_check_answer ($privatekey,
	                                $_SERVER["REMOTE_ADDR"],
	                                $_POST["recaptcha_challenge_field"],
	                                $_POST["recaptcha_response_field"]);
	
	if (!$resp->is_valid) {
	  /*die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
	       "(reCAPTCHA said: " . $resp->error . ")");*/
	       header('Location: ../register.php?captcha=false&error='.$resp->error); exit;	
	}
	
	if($_POST['username'])
	{
		$username = cleanseInput(strtolower($_POST['username']));
		$password = cleanseInput($_POST['password']);
		$email1 = cleanseInput($_POST['email1']);
		$email2 = cleanseInput($_POST['email2']);
		
		$validate = validateForms($username, $password, $email1, $email2);
		if(!$validate){ header('Location: ../register.php'); exit; }
		
		$password = hash('sha256', $password);
		//$confirm = hash('sha256',(rand(0,9999)+rand(0,9999)));
		
		$addquery = "INSERT INTO `users`
				(
					`username`,
					`email`,
					`password`,
					`confirmed`,
					`joindate`
				) VALUES (
					'".$username."',
					'".$email1."',
					'".$password."',
					'1',
					NOW()
				)";
		$result = mysql_query($addquery);
		
		if($result)
		{
			/*$IDquery = "SELECT userID FROM users WHERE username='$username' LIMIT 1";
			$IDresult = mysql_query($IDquery);
			$user = mysql_fetch_row($IDresult);
			
			$message = "
			<html>
			<head><title>Confirm Your Notetakr Account</title></head>
			<body>
			<p>In order to confirm your Notetakr account, you must activate it.</p>
			<p>Just follow this link: <a href=\"http://notetakr.com/includes/confirm.php?user=".$user[0]."&key=".$confirm."\">http://notetakr.com/includes/confirm.php?user=".$user[0]."&key=".$confirm."</a>.</p>
			<p>Please do not reply to this email.</p>
			</body>
			</html>
			";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'To: '.$username.' <'.$email1.'>' . "\r\n";
			$headers .= 'From: Notetakr <notetakr@meltingice.net>' . "\r\n";
			mail($email1, "Confirm your Notetakr Account", $message, $headers);*/
			header('Location: ../index.php?register=true');
				
		}
		else{ header('Location: ../register.php?register=fail'); }

		

	}
	
	function validateForms($username, $password, $email1, $email2)
	{
		if(strlen($username)<3 || strlen($username)>15)
		{
			return false;
		}
		elseif(strlen($password)<4 || strlen($password)>15)
		{
			return false;
		}
		elseif($email1 != $email2)
		{
			return false;
		}
		elseif(strpos($email1, "@")==false||strpos($email2,"@")==false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	mysql_close();
?>