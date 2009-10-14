<?php
	require_once('includes/recaptchalib.php');
	$publickey = "6LdS1AAAAAAAAMRxe7X47hQ18wAhgWZGFBOmxc-o"; // you got this from the signup page
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>notetakr! - registration</title>
<link href="css/styles.css" type="text/css" rel="stylesheet" />
<link href="css/modalbox.css" type="text/css" rel="stylesheet" />
<link href="css/styles-registration.css" type="text/css" rel="stylesheet" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script src="js/backend.js" type="text/javascript"></script>
<script src="js/modalbox.js" type="text/javascript"></script>
<script>
var RecaptchaOptions = {
   theme : 'white'
};
</script>
</head>
<body onload="javascript:checkForms('register')">

<!-- run the modaldiv checks -->
<?php include_once('includes/modaldiv.php');?>

<div id="header-container">
	<div id="header"></div>	
</div>
<div id="registerbox">
	<img src="img/registration.png" alt="login" id="login-image" />
	<form enctype="multipart/form-data" action="includes/register.php" id="loginform" name="loginform" method="post">
	    <p><input type="text" value="username" name="username" id="usernameinput" onfocus="javascript:switchUsernameForm()" onkeyup="javascript:formValidation('usernameinput')" /></p>
	    <p><input type="text" value="password" name="password" id="passwordinput" onfocus="javascript:switchPasswordForm()" onkeyup="javascript:formValidation('passwordinput')"/></p>
	    <p><input type="text" value="email address" name="email1" id="emailinput1" onfocus="javascript:switchEmailForm(1)" onkeyup="javascript:formValidation('emailinput1')"/></p>
	   	<p><input type="text" value="email address again" name="email2" id="emailinput2" onfocus="javascript:switchEmailForm(2)" onkeyup="javascript:formValidation('emailinput2')"/></p>
	   	<div id="captcha">
	   		<?php echo recaptcha_get_html($publickey); ?>
	   	</div>
	    <p><input type="submit" value="register" name="submit" id="submitbutton" /></p>
	</form>
	<p><a href="index.php">[ return to homepage ]</a></p>
</div>
<div id="register-rays"></div>

<div id="ad">
	<script type="text/javascript"><!--
	google_ad_client = "pub-6696775752725393";
	//468x60, created 12/20/07
	google_ad_slot = "6121378885";
	google_ad_width = 468;
	google_ad_height = 60;
	//--></script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
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