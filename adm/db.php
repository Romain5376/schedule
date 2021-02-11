<?php
function getdbx(){
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if( strpos($actual_link, '/adm'))
	{
		$ctx = file_get_contents('config'); 
	}else{
		$ctx = file_get_contents('adm/config'); 
	}
	$ctxelmt = explode("####", $ctx);
    $bdd = new PDO($ctxelmt[0], $ctxelmt[1], $ctxelmt[2]);
	return $bdd;
}