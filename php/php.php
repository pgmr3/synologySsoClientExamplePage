<?php
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------
// additional code for authorization check/automatic logout
include_once('../check_accesstoken.php');
?>

<!DOCTYPE html>
<body>
	<div id="session-lifetime" >loading...</div>
</body>

<script src="../js/myLoginScript.js" type="text/javascript"></script>
<script>

	// Document fully loaded
	function dokumentLoadDone(event) {
		<?php
		//Restart session lifetime
		if(session_status() !== PHP_SESSION_ACTIVE) $name_vorher = session_name (SESSION_NAME); //"ServerTools"); 
		session_start();//repeated start session without new parameters
		$_SESSION['endTime'] = time()+ SESSION_COOKIE_LIFETIME;
		?>
		fetchAccess(true); //with issue remaining term
		//fetchAccess(false); //without issue remaining term
	}
	document.addEventListener('DOMContentLoaded', dokumentLoadDone , false);
</script>


<?php 
	//original code
	phpinfo();
?>		