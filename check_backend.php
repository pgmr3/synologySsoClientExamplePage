<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------

// Checking the access token stored in the cookie (session) against the sso server. Return json object from sso server to calling javascript
// Attention, if errors or warnings are issued in this code, they will destroy the json object to be returned!

include_once('config.php');
header('Access-Control-Allow-Origin: '.LOCAL_HOST );
//header('Access-Control-Allow-Origin: https://sso-yourdomain.com');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	$startTime = time();
	$endTime = time()+ SESSION_COOKIE_LIFETIME;
	setcookie(session_name(),session_id(),$endTime);
	$name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
	session_start([
		'cookie_lifetime' => time() + SESSION_COOKIE_LIFETIME, //86400, //3600 =1h; 86400 =1d
		'cookie_path' => '/'
	]);
	$_SESSION['endTime'] = $endTime;
}

// Check access token on sso server
function httpGet ($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//for testing ignore checking CA
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$output=curl_exec($ch);
	curl_close($ch);
 
	$json_resp = json_decode($output, true);
	if($json_resp['success'] == true){
		$_SESSION['user_name'] = $json_resp["data"]["user_name"];
		$_SESSION['user_id'] = $json_resp["data"]["user_id"];	
	} else {
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		unset($_SESSION['sso_accesstoken']);
	}
	return $output;
}

//perform logout
function logout() {
	$_SESSION = array(); // Delete all session variables.

	// destroy cookie (session)
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 86400, $params["path"], //The time must be in the past
			$params["domain"], $params["secure"], $params["httponly"]
		);
	}

	// delete the session itself
	if (session_destroy()){
		$json = '{"successful":true}'; 
	}
	else {
		$json = '{"successful":false}'; 
	}

	header('Content-Type: application/json');	
	$obj = json_decode($json);
	//return json for logged out
	echo $json; 
	exit();
}

//Logout request?
if(isset($_GET['startLogout'])) {
	if ($_GET['startLogout'] === "true") {
		logout();
		exit();
	}
}

// evaluate passed parameters
if(isset($_GET['accesstoken'])) $accesstoken = $_GET['accesstoken']; //after the (first) login, the access token is in the header
else if(isset($_SESSION['sso_accesstoken'])) $accesstoken = $_SESSION['sso_accesstoken']; // Repeated checking of the access status, with the access_token is in the cookie (session)
else $accesstoken = "no-given-token"; // no access token was passed -> parameter error will be generated in the SSO server

$_SESSION['sso_accesstoken'] = $accesstoken; // Store access token in session cookie
$url_str = SSO_HOST.'/webman/sso/SSOAccessToken.cgi?action=exchange&access_token='.$accesstoken;//.'&app_id='.APP_ID);

//$_SESSION['url_str_check'] = $url_str; //for testing
//header('accesstoken:'.$accesstoken); //for testing

//return json for logged in
header('Content-Type: application/json');
echo httpGet($url_str);
?>