<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: Rhttps://github.com/pgmr3
// ------------------------------------------------------------------------------
// additional code for authorization check/automatic logout
include_once('../check_accesstoken.php');
if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
session_start();
if (!CheckAccesstoken() === "true") { 
	echo "Verboten / Forbidden";
	exit();
}
?>
<!DOCTYPE html>
<body>
	<div id="session-lifetime" >loading ...</div>
</body>
<script src="../js/myLoginScript.js" type="text/javascript"></script>
<script>
	window.setInterval(function () { fetchAccess();	}, 
	1000); //milliseconds 
</script>


<?php
	// original code from
	// https://github.com/phpsysinfo/phpsysinfo
	
	//copy the complete code from phpsysinfo into this directory. Then copy the first 24 lines of this file into the file index.php
?>

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
		<div class="form-signin">
			<h1 class="form-signin-heading">phpsysinfo</h1>
			<h2 class="form-signin-heading" >your choice: back/home/menu</h2>
			<INPUT TYPE="button" VALUE="back" onClick="history.go(-1);">
			<button id="home-button" onclick="window.location.href = '/'" >home</button>
			<button id="menu-button" onclick="window.location.href = '/my/'" >menu</button>
			<br\>
			<br\>
			<div id="demo" >To see the original output of the phpsysinfo project here. <br\></div>
			<div>			original code from: <br\></div>
			<div>			<a href="https://github.com/phpsysinfo/phpsysinfo">https://github.com/phpsysinfo/phpsysinfo </a><br\></div>
			<div>			copy the complete code from phpsysinfo into this directory. Then copy the first 24 lines of this file into the file index.php <br\> </div>
			<br\>
		</div>
	</div>
</body>