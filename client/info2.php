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
	1000); //mili seconds 
</script>


<?php
//ursprünglicher code
header("Cache-Control: no-cache, no-store");
	//OK <tr><td>X-Forwarded-For IP Address(es)</td><td>".$_SERVER['HTTP_X_FORWARDED_FOR']."&nbsp;</td></tr> 
if (isset( $_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$xForwarded = $_SERVER['HTTP_X_FORWARDED_FOR'];
} 
else $xForwarded = "";
print "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
	<tr><td align=\"center\"><strong>Attribute</strong></td><td align=\"center\"><strong>Value</strong></td></tr>
	<tr><td>IP Address (either v4 of v6)</td><td>".$_SERVER['REMOTE_ADDR']."</td></tr>
	<tr><td>Hostname</td><td>".gethostbyaddr($_SERVER['REMOTE_ADDR'])."</td></tr>
	
	<tr><td>X-Forwarded-For IP Address(es)</td><td>".
	$xForwarded
	."&nbsp;</td></tr>
	
	<tr><td>Port</td><td>".$_SERVER['REMOTE_PORT']."</td></tr>
	<tr><td>REQUEST_METHOD</td><td>".$_SERVER['REQUEST_METHOD']."</td></tr>
	<tr><td>CONTENT_TYPE</td><td>".$_SERVER['CONTENT_TYPE']."</td></tr>
	<tr><td>GATEWAY_INTERFACE</td><td>".$_SERVER['GATEWAY_INTERFACE']."</td></tr>
	
	<tr><td>Browser (User Agent)</td><td>".$_SERVER['HTTP_USER_AGENT']."</td></tr>
	<tr><td>Request Time (Unixtime)</td><td>" .$_SERVER['REQUEST_TIME'] ."</td></tr>
	<tr><td>Request Time</td><td>" .date("d.m.Y H:i:s",$_SERVER['REQUEST_TIME']) ."</td></tr>
	<!--
	<tr><td>Copyright</td><td><a href=\"https://weberblog.net/small-what-is-my-ip-script-at-ip-webernetz-net/\">https://weberblog.net/small-what-is-my-ip-script-at-ip-webernetz-net/</a></td></tr>
	-->
</table>";
?>