<?php declare(strict_types=1);


include './src/Rdap.php'; //fie
include './src/RdapException.php';//fie

use Metaregistrar\RDAP\Rdap; //fie
use Metaregistrar\RDAP\RdapException;


//$search = 59980;
//$protocol = Metaregistrar\RDAP\rdap::ASN;


//$search = '6939';
//$protocol = Metaregistrar\RDAP\rdap::ASN;

//$search = '81.4.97.200';
//$search = '82.135.96.210';
//$search = '8.8.4.4';
//$protocol = Metaregistrar\RDAP\Rdap::IPV4;

// die IPv6 cidr/Bereiche müssen genau einem Element in https://data.iana.org/rdap/ipv6.json  entsprechen!
$search = '2001:400::/23';//OK
//$search = '2001:470::/48';  //Nicht OK
//$search = '2001:470:ffff:ffff:ffff:ffff:ffff:ffff'; //Nicht OK
//$search = '2001:470::/23';  //Nicht OK
$protocol = Metaregistrar\RDAP\Rdap::IPV6;

//domain info des eigenen html-servers
//$search = $_SERVER['SERVER_NAME'];//Host
//$ServerArray = explode('.', $search);//Host splitten
//$search = $ServerArray[count($ServerArray)-2] . '.' . $ServerArray[count($ServerArray)-1]; //Domain aus den beiden höchen Array Elementen Zusammen  bauen
//$protocol = Metaregistrar\RDAP\Rdap::DOMAIN;

//$search = 'RIPE-NCC-END-MNT';//Fehler üngültiger Parameter
//$search = 'farb.klecks.net'; //nicht gefunden
//$search = 'klecks.net';
//$search = 'pgmr2.com';
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
        } //fie
	    echo nl2br("port 43 service: ".$test->getPort43().PHP_EOL);
        
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
