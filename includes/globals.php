<?php
	function cleanseInput($input)
	{
		return htmlentities($input,ENT_QUOTES);
	}
	
	function processContent($content)
	{
		return str_replace("~amp","&",$content);
	}
?>