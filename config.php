<?php
// ------------------------------------------------------------------------------
//  © Copyright (с) 2020
//  Author: Dmitri Agababaev, d.agababaev@duncat.net
//
//  Redistributions and use of source code, with or without modification, are
//  permitted that retain the above copyright notice
//
//  License: MIT
// ------------------------------------------------------------------------------
//
//  © Copyright (с) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Reinhard Fiebelkorn
// ------------------------------------------------------------------------------

define('APP_ID', 'eb3df56d6f3f11914eb6514c978346fX'); //Application ID in SSO server on Synology NAS with DSM
define('SSO_HOST', 'https://sso-yourdomain.com');// 'https://dsm.yourserverdomain.toplevel:5001'); //Synology NAS with DSM
define('LOCAL_HOST', 'https://yourpagedomain.com'); // Your server host 
define('REDIRECT_URI', 'https://yourpagedomain.com'); // not not really used by SSO

define('SESSION_NAME', 'ServerTools'); // Name of session cookie on client browser
define('SESSION_COOKIE_LIFETIME', 90); // 86400); // Lifetime of session cookie on client browser in seconds
?>
