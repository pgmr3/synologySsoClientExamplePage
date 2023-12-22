<?php
// ------------------------------------------------------------------------------
//  © Copyright (с) 2020
//  Author: Dmitri Agababaev, d.agababaev@duncat.net
//
//  Redistributions and use of source code, with or without modification, are
//  permitted that retain the above copyright notice
//
//  License: MIT
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------
include_once('../config.php');

if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
session_start();//wiederohlter Start Session ohne Parameter

if (!isset($_SESSION['sso_accesstoken'])) {
	echo "Verboten / Forbidden";
	exit();
}

if (!isset($_SESSION['user_id'])) {
	header('location: '.SSO_HOST.'/webman/sso/SSOOauth.cgi?app_id='.APP_ID.'&scope=user_id&redirect_uri='.REDIRECT_URI);
}

if (isset($_GET['logout'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['sso_accesstoken']);
	header('location: '.LOCAL_HOST);
}

// here we can do something after login
?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>Tools</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="https://github.com/pgmr3">
	<meta name="copyright" content="https://www.gnu.org/licenses/gpl-3.0.html" />
	<script src="../js/myLoginScript.js" type="text/javascript"></script>
</head>	

<body>
	<?php
	echo 'User ID:'.$_SESSION['user_id'].' is logged in';
	echo '<br \>';
	?>
	<div id="session-lifetime" >loading...</div>
	<div class="container">
		<div class="form-signin">
			<h1 class="form-signin-heading">Tools</h1>
			<h2 class="form-server-heading">
				<?php echo ' '.$_SERVER['SERVER_NAME'];?> 
			</h2>
			<div id="server-info"></div>
			<br/>
			<INPUT TYPE="button" VALUE="back" onClick="history.go(-1);">
			<button id="anwendung-button" onclick="window.location.href = '/'" >home</button>
			
			<h3 class="form-php-heading" >Show server php info's</h3>
			<button id="php-button">php Info</button>
			<h3 class="form-serverinfo-heading" >Show serverinfo phpSysinfo</h3>
			<button id="serverinfo-button">phpSysinfo</button>
			<h3 class="form-serverRdap-heading" >ICANN Show domain information of the server host</h3>
			<button id="serverRdap-button">domain Info</button>
			<h3 class="form-client-heading" >Show client info's</h3>
			<button id="client-button">client Info</button>
			<h3 class="form-some-heading" >Some site info's</h3>
			<button id="someSite-button">some seite</button>
			<h3 class="form-some2-heading" >Some site 2 info's</h3>
			<button id="someSite2-button">some seite 2</button>
			
			<br\>
			<div id="demo" ></div>
			<br\>
		</div>
	</div>
	
	<script>	
	
	// server info/server time
	function fetchServerInfo() {
		const url = './serverinfo.php';
		const xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE) {
				if (xhr.status === 200) {
					document.getElementById('server-info').innerHTML = xhr.responseText;
				}
				// Next request in 1000 milliseconds
				setTimeout(fetchServerInfo, 1000);
			}
		};
		xhr.open('GET', url, true);
		xhr.send();
	}
	// Serverinfo - Start first request
	fetchServerInfo();
		
	// Document fully loaded
	function dokumentLoadDone(event) {
		<?php
		//Restart session lifetime
		if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
		session_start();//wiederohlter Start Session ohne Parameter
		$_SESSION['endTime'] = time()+ SESSION_COOKIE_LIFETIME;
		?>
		// access state? - Start first request and cyclical
		fetchAccess(true); //with issue remaining term
		//fetchAccess(false); //without issue remaining term
	}
	//document.addEventListener('DOMContentLoaded', dokumentLoadDone , false); //first event loaded
	window.addEventListener('load', dokumentLoadDone);// secondly, fully loaded
		
	var php_button = document.getElementById("php-button");
	if(php_button !== null)php_button.addEventListener('click' , myEventPhp);
	document.getElementById("php-button").addEventListener("click", () => { myEventPhp("myEventPhp_addEventListener");});
	function myEventPhp (text) {window.location.href = ("/php/php.php");};

	document.getElementById("serverinfo-button").addEventListener("click", () => { myEvents("phpsysinfo");});
	document.getElementById("serverRdap-button").addEventListener("click", () => { window.location.href = ("/RDAP/");});
	document.getElementById("client-button").addEventListener("click", () => { window.location.href = ("/client/");});
	document.getElementById("someSite-button").addEventListener("click", () => { window.location.href = ("/someSite/");});
	document.getElementById("someSite2-button").addEventListener("click", () => { window.location.href = ("/someSite2/");});

	// Event brancher
	function myEvents(text) {
		console.log(text);
		switch (text) {
		  case "phpsysinfo":
			window.location.href = ("/phpsysinfo-main/");
			break;
		  case label2:
			//code to be executed if text=label2;
			break;
		  case label3:
			//code to be executed if text=label3;
			break;
		
		  default:
			//code to be executed if text is different from all labels;
		}
	}
	
	</script>

</body>