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
	<div id="session-lifetime" >undefined</div>
</body>
<script src="../js/myLoginScript.js" type="text/javascript"></script>
<script>
	window.setInterval(function () { fetchAccess();	}, 
	1000); //mili seconds 
</script>


<?php 
//ursprünglicher code
require('UserInfo.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>UserInfo</title>
	<style>
table {
	margin-top: 20px;
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: center;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
h2{font-family: sans-serif,'Helvetica';}
</style>

</head>
<body>
<center><h2>UserInfo</h2></center>

	<table>
		<tr>
			<th>Ip</th>
			<th>Device</th>
			<th>Os</th>
			<th>Browser</th>
		</tr>
		<tr>
			<td><?= UserInfo::get_ip();?></td>
			<td><?= UserInfo::get_device();?></td>
			<td><?= UserInfo::get_os();?></td>
			<td><?= UserInfo::get_browser();?></td>
		</tr>
	</table>

</body>
</html>