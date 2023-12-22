<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------
//zusätzlicher Code für authorisierungs Prüfung/automatischer logout
include_once('../check_accesstoken.php');
if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
session_start();
if (!CheckAccesstoken() === "true") { //oder Folgezeile
//if(!isset($_SESSION['sso_accesstoken'])) {
	echo "Verboten / Forbidden";
	exit();
}
?>
<!DOCTYPE html>
<body>
	<div id="session-lifetime" ></div>
</body>
<script src="../js/myLoginScript.js" type="text/javascript"></script>
<script>
	window.setInterval(function () { fetchAccess();	}, 
	1000); //milliseconds 
</script>


<!-- urspünglicher Code -->
<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>phpsysinfo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="https://github.com/pgmr3">
	<meta name="copyright" content="https://www.gnu.org/licenses/gpl-3.0.html" />
</head>

<body>
	<div class="container">
		<div class="form-client">
			<h1 class="form-client-heading">Client tools</h1>
			<h2 class="form-client-heading">Please choose info 1 / info 2 / menu</h2>
			<button id="info1-button" onclick="window.location.href = '/client/client.php'">Info 1</button>
			<button id="info2-button" onclick="window.location.href = '/client/info2.php'">Info 2</button>
			<button id="menu-button" onclick="window.location.href = '/my/'" >menu</button>
		</div>
	</div>
</body>