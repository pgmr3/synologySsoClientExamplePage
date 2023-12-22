// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------


//has user access with this token?
const doTestLogedin = async (whenDone, $atoken="Default", $startLogout=false ) => {
	let requestData = "";
	if ($atoken === "Default") {
		requestData = {
			startLogout: $startLogout
		}
	} else {
		requestData = {
			accesstoken: $atoken,
			startLogout: $startLogout
		}
	}
	const phpScriptUrl =  '/check_backend.php';
	
	// Create the URL with the GET parameters
	const queryString = Object.keys(requestData).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(requestData[key])}`).join('&');
	const fullUrl = `${phpScriptUrl}?${queryString}`;
	console.log(fullUrl);

	// Create a fetch request
	fetch(fullUrl, {
		method: 'GET',
		mode: 'cors',//'no-cors', 
		credentials: 'include',
		cache: 'no-store',
		headers: {
			'Content-Type': 'application/json'
			//The following header enables CORS (replace "allowed-domain.com" with your allowed domain)
			, 'Origin': 'SSO_HOST'  //'allowed-domain.com'  
		}		
	})
	
	.then(response => {
		if (!response.ok) {
			console.log("response.status =", response.status);
			console.log(response);
			throw new Error('response from check_backend.php was not ok');
		}
		return response.json();
	})

	.then (jsonResponse => {
		// Erfolgreiche Anfrage
		console.log(jsonResponse);
		let logedin = false;
		var message = "resonse no data";
		var stringjson = "{no_data}"
		//if (response && response.success && response.data) {
		if (jsonResponse.success && jsonResponse.data) {
			message = 'Logged in success, User name=' + jsonResponse.data.user_name + ', User ID=' + jsonResponse.data.user_id;
			console.log(message);
			stringjson = JSON.stringify(jsonResponse); // Converting JS object to JSON string
			console.log(stringjson);
			console.log("access"); 
			//alert("access");//test
			logedin = true;
		} 
		else if (jsonResponse.successful) {
			logedin = false;
			console.log(jsonResponse);
			console.log("no access after logout");
			//alert("logged out");//test
			//return jsonResponse;
			//return jsonResponse.json(); // if logout
		}						
		else {
			console.log(jsonResponse);
			console.log("no access");
			//alert("no access");//test
			logedin = false;
		}	
		whenDone(logedin);//callback()
		//Visibility(logedin, !logedin); //global
		//Xlogedin = logedin; //global
		return logedin;
		//alert ("response in console");//Test
	})
	
	.catch(error => {
		// Error in request
		console.error('Error in response from check_backend.php:', error);
	});
}

	
// access state ? echoSessionLifetime or nothing, after the session ends dom on /
function fetchAccess($echoSessionLifetime=false) {
	// URL
	const phpScriptUrl = '../check_lifetime.php';
	// GET parameters
	requestData = {
		'echoSessionLifetime': $echoSessionLifetime // 'true',
		//,foo: bar
	}		
	// Create the URL with the GET parameters
	const queryString = Object.keys(requestData).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(requestData[key])}`).join('&');
	const fullUrl = `${phpScriptUrl}?${queryString}`;
	console.log(fullUrl);
	// Create a fetch request
	fetch(fullUrl, {
		method: 'GET',
		mode: 'cors',//'no-cors', 
		credentials: 'include',
		cache: 'no-store',
		headers: {
			'Content-Type': 'application/json'
			//The following header enables CORS (replace "allowed-domain.com" with your allowed domain)
			, 'Origin': 'SSO_HOST'  //'allowed-domain.com'  
		}		
	})
	.then(response => {
		if (!response.ok) {
			console.log("response.status =", response.status);
			console.log(response);
			throw new Error('response from check_lifetime.php was not ok');
		}
		//header abfragen
		if ( response.headers.get('State') === 'noAccess'){
			window.location.replace("/"); // clear history
			//this.done;
			throw new Error('noAccess'); //The chain is aborted, no restart
		}
		//SessionLifetime is text
		return response.text();
	})
	.then((text) => {
		//SessionLifetime to document
		document.getElementById('session-lifetime').innerHTML = text; 
		return;
	})
	.then (() => {
		// delayed repetition
		let start = Date.now();
		while (Date.now() - start < 1000) { // 1 second
		  // wating
		}
		timer =	setTimeout(fetchAccess($echoSessionLifetime), 0); 
		return;
	})
	.catch(error => {
		// Error in request
		console.error('Error in response from check_lifetime.php:', error);
	});
	
	console.log("check_lifetime.php fired");
}


// This variant works, but requires too many resources
// access state ? echoSessionLifetime or nothing, after the session ends dom on / 
function fetchAccess_old($echoSessionLifetime=false) {
	// URL
	const phpScriptUrl = '../check_lifetime.php';
	// GET parameters
	requestData = {
		'echoSessionLifetime': $echoSessionLifetime // 'true',
		//,foo: bar
	}		
	// Create the URL with the GET parameters
	const queryString = Object.keys(requestData).map(key => `${encodeURIComponent(key)}=${encodeURIComponent(requestData[key])}`).join('&');
	const fullUrl = `${phpScriptUrl}?${queryString}`;
	console.log(fullUrl);
	// AJAX-Anfrage
	const xhr2 = new XMLHttpRequest();
	xhr2.onreadystatechange = function () {
		if (xhr2.readyState === xhr2.HEADERS_RECEIVED) {
			const Astate = xhr2.getResponseHeader("State");
			if (Astate === "noAccess") {
				//window.location.href = ("/"); // clear history not
				window.location.replace("/"); // clear history
				xhr2.abort();
			}
		}
		if (xhr2.readyState === XMLHttpRequest.DONE) {
			if (xhr2.status === 200) {
				console.log("$echoSessionLifetime: "+$echoSessionLifetime);
				document.getElementById('session-lifetime').innerHTML = xhr2.responseText; //this also fire new fetchAccess()
				timer =	setTimeout(fetchAccess($echoSessionLifetime), 1000); 
			}
		}
	};
	xhr2.open('GET', fullUrl, true);
	xhr2.setRequestHeader('echoSessionLifetime', $echoSessionLifetime); // this doesn't work for php scripts
	xhr2.send();
	console.log("check_lifetime.php fired");
}