<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: Rhttps://github.com/pgmr3
// ------------------------------------------------------------------------------

include_once('config.php');
include_once('check_accesstoken.php');

if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
session_start();//repeated start without changing the parameters

if(!isset($_SESSION['endTime']) || !isset($_SESSION['sso_accesstoken']) )  {
	header('State:'.'noAccess');
	exit();
}

$_SESSION['lifetime'] = $_SESSION['endTime'] - time();//Remaining time
if ($_SESSION['lifetime'] <= 0 ) {
	CheckAccesstoken();
	if(!isset($_SESSION['sso_accesstoken'])) {
		header('location: '.LOCAL_HOST.'/');
		header('State:'.'noAccess');
		exit();
	}
}
else {
	header('State:'.'waiting');
	//usleep(1000);
}

if(isset($_GET['echoSessionLifetime'])) {
	if ($_GET['echoSessionLifetime'] === "true") {
		echo "You will be logged out in ".$_SESSION['lifetime']." seconds. Renew with F5/reload site.";
	}
	else exit();
}

?>