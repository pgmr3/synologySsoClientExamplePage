<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  author: https://github.com/pgmr3
// ------------------------------------------------------------------------------
include_once('../check_accesstoken.php');
?>


<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>some site 2</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="pgmr2.com">
	<meta name="copyright" content="https://www.gnu.org/licenses/gpl-3.0.html" />
	<script src="https://dsm.pgmr2.com/webman/sso/synoSSO-1.0.0.js"></script> 
	<script src="../js/myLoginScript.js" type="text/javascript"></script>
</head>

<body>
	<div class="container">
		<div id="session-lifetime" >loading</div>
		<div class="form-signin">
			<h1 class="form-signin-heading">some site 2</h1>
			<h2 class="form-signin-heading" >your choice: back/home/menu/sign out </h2>
			<INPUT TYPE="button" VALUE="back" onClick="history.go(-1);">
			<button id="home-button" onclick="window.location.href = '/'" >home</button>
			<button id="menu-button" onclick="window.location.href = '/my/'" >menu</button>
			<button id="logout-button">sign out</button>
			<br\>
			<br\>
			<div id="demo" >OnOn this example page, the user is logged out after the session lifetime stored in config.php has expired and the home document is then displayed.</div>
			<br\>
		</div>
	</div>
</body>

<script>
	// globals
	var Xlogedin = true;
	
	// sign out event function is triggert
	var myEventLogOut = function() {
		console.log("myEventLogOut");
		SYNOSSO.logout({
			callback: logoutCallback
		});
		// since there is no response from SSYNOSSO.logout the following comes
		doTestLogedin(onComplete ,null ,$startLogout=true).then ((data) => {
			//console.log(data); //hier undefined, da asyncron 
		})
		.catch(console.log);
		window.location.replace("/"); // clear history
	};
	
	//callback von SYNOSSO.logout - will NOT fire!
	function logoutCallback(response){
		console.log("logoutCallback");
		if(response) { 
			console.log (response);
			alert("logout resonse in console");
			Xlogedin = false;
		} 
	}
	
	//logout button
	var logout_button = document.getElementById("logout-button");
	if(logout_button !== null) logout_button.addEventListener('click' , myEventLogOut, false); 
	
	//menu button
	var menu_button = document.getElementById("menu-button");
	if(menu_button !== null) menu_button.addEventListener('click' , myEventMenu, false); 	
	var myEventMenu= function() {
		window.location.replace("/my/"); 
	}
	
	// Document fully loaded
	function dokumentLoadDone(event) {
		<?php
		//Restart session lifetime
		if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
		session_start();//repeated start session without new parameters
		$_SESSION['endTime'] = time()+ SESSION_COOKIE_LIFETIME;
		?>
		//Query the user login status? and query remaining login time.
		fetchAccess(true); //with issue remaining term
		//fetchAccess(false); //without issue remaining term
	}
	//document.addEventListener('DOMContentLoaded', dokumentLoadDone , false); //first event loaded
	window.addEventListener('load', dokumentLoadDone);// secondly, fully loaded

</script>