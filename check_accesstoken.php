<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------

include_once('config.php');

// checks the access token stored in the cookie (session) against the SSO server
// if the answer is negative, the access token in the session is deleted, corresponds to a forced logout by the SSO sever, for example user was deleted
// the timing of the session is also checked
function CheckAccesstoken () {
	if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
	session_start();//wiederholter Start ohne Änderung der Parameter
	
	function httpGetCheckAccesstoken ($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//for testing ignore checking CA
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$output=curl_exec($ch);
		curl_close($ch);
		 
		//Evaluation answer, write session variables
		$json_resp = json_decode($output, true);
		if($json_resp['success'] == true){
			$_SESSION['user_name'] = $json_resp["data"]["user_name"];
			$_SESSION['user_id'] = $json_resp["data"]["user_id"];
			$_SESSION['lifetime'] = $_SESSION['endTime'] - time();//Remaining time
			if ($_SESSION['lifetime'] <= 0) {
				sessionEnds();
				return false;
			}
			return true;
		} 
		else {	
			sessionEnds();
			return false;
		}
	}
	
	if(isset($_SESSION['sso_accesstoken'])) {
		$accesstoken = $_SESSION['sso_accesstoken']; // Repeated checking of the access status, with the access_token is in the cookie (session)
	}
	else {
		//cookie had already expired earlier
		return false; 
	}
	
	$url_str = SSO_HOST.'/webman/sso/SSOAccessToken.cgi?action=exchange&access_token='.$accesstoken;//.'&app_id='.APP_ID);

	$_SESSION['url_str_check'] = $url_str;//test
	
	return httpGetCheckAccesstoken($url_str);
	exit();
}

function sessionEnds() {
	// Destroy cookie & session
	$_SESSION = array(); // Delete all session variables.
	// Since the session should be deleted, we also delete the session cookie.
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - SESSION_COOKIE_LIFETIME, $params["path"], // The time when cookies expire should be in the past
			$params["domain"], $params["secure"], $params["httponly"]
		);
		$_SESSION['lifetime'] = 0;
	}
	session_destroy();
} 
?>