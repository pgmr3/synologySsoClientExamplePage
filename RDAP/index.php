<?php declare(strict_types=1);
// ------------------------------------------------------------------------------
//
//  � Copyright (?) 2023 License: GPLv3 https://www.gnu.org/licenses/gpl-3.0.txt
//  Author: https://github.com/pgmr3
// ------------------------------------------------------------------------------
// additional code for authorization check/automatic logout
include_once('../check_accesstoken.php');
?>
<!DOCTYPE html>
<body>
	<div id="session-lifetime" >loading...</div>
	<br/>
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
		//Query the user login status? and query remaining login time.
		fetchAccess(true); //with issue remaining term
		//fetchAccess(false); //without issue remaining term
	}
	//document.addEventListener('DOMContentLoaded', dokumentLoadDone , false); //first event loaded
	window.addEventListener('load', dokumentLoadDone);// secondly, fully loaded
</script>



<?php // declare(strict_types=1);

include './src/Rdap.php'; //fie
include './src/RdapException.php';//fie

use Metaregistrar\RDAP\Rdap; //fie
use Metaregistrar\RDAP\RdapException;


$search = 59980;
$protocol = Metaregistrar\RDAP\rdap::ASN;


//$search = '6939';
//$protocol = Metaregistrar\RDAP\rdap::ASN;

//$search = '81.4.97.200';
//$search = '82.135.96.210';
//$search = '8.8.4.4';
//$protocol = Metaregistrar\RDAP\Rdap::IPV4;

//$search = '2001:470::';  //Nicht OK
//$protocol = Metaregistrar\RDAP\Rdap::IPV6;

//domain info des eigenen html-servers
$search = $_SERVER['SERVER_NAME'];//Host
$ServerArray = explode('.', $search);//Host splitten
$search = $ServerArray[count($ServerArray)-2] . '.' . $ServerArray[count($ServerArray)-1]; //Domain aus den beiden h�chen Array Elementen Zusammen  bauen
$protocol = Metaregistrar\RDAP\Rdap::DOMAIN;

//$search = 'RIPE-NCC-END-MNT';//Fehler �ng�ltiger Parameter
//$search = 'farb.klecks.net'; //nicht gefunden
//$search = 'klecks.net';
//$search = 'pgmr2.eu'; //nicht gefunden
//$protocol = Metaregistrar\RDAP\Rdap::DOMAIN;


try {
    $rdap  = new Metaregistrar\RDAP\Rdap($protocol);
    $test  = $rdap->search($search);

    if ($test && $test->getErrorCode() === null) {
        //var_dump ($test);
        echo nl2br('class name: ' . $test->getClassname() . PHP_EOL);
        echo nl2br('handle: ' . $test->getHandle() . PHP_EOL);
        echo nl2br('LDH (letters, digits, hyphens) name: ' . $test->getLDHName() . PHP_EOL);
        
        if($test->getClassname() === 'ip network') { //fie        
	        echo nl2br("name: ".$test->getName().PHP_EOL);
	        echo nl2br("type: ".$test->getType().PHP_EOL);
	        echo nl2br("port 43 service: ".$test->getPort43().PHP_EOL);
        }
        
        if (is_array($test->getNameservers())) {
            echo nl2br("\nNameservers:\n");
            foreach ($test->getNameservers() as $nameserver) {
            	$nameserver->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
        if (is_array($test->getSecureDNS())) {
            echo nl2br("DNSSEC:\n");
            foreach ($test->getSecureDNS() as $dnssec) {
                $dnssec->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
        echo nl2br("rdap conformance: \n");
        foreach ($test->getConformance() as $conformance) {
            $conformance->dumpContents();
        }
        echo nl2br(PHP_EOL);
        if (is_array($test->getEntities())) {
            echo nl2br("Entities found:\n");
            foreach ($test->getEntities() as $entity) {
                $entity->dumpContents();
                echo nl2br(PHP_EOL);
            }
        }
        if (is_array($test->getLinks())) {
            echo nl2br("Links:\n");
            foreach ($test->getLinks() as $link) {
                $link->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
        if (is_array($test->getNotices())) {
            echo nl2br("Notices:\n");
            foreach ($test->getNotices() as $notice) {
                $notice->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
        if (is_array($test->getRemarks())) {
            echo nl2br("Remarks:\n");
            foreach ($test->getRemarks() as $remark) {
                $remark->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
        if (is_array($test->getStatus())) {
            echo nl2br("Statuses:\n");
            foreach ($test->getStatus() as $status) {
                $status->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }

        if (is_array($test->getEvents())) {
            echo nl2br("Events:\n");
            foreach ($test->getEvents() as $event) {
                $event->dumpContents();
            }
            echo nl2br(PHP_EOL);
        }
    } else {
        $title = '';
        if ($test) {
            $title = $test->getTitle();
        }
        echo nl2br("$search was not found on any RDAP service. $title\n");
    }
} catch (RdapException $e) {
    echo nl2br('ERROR: ' . $e->getMessage() . PHP_EOL);
}
