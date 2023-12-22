<?php

namespace Metaregistrar\RDAP;

use Metaregistrar\RDAP\Data\RdapEntity;
use Metaregistrar\RDAP\Data\RdapNameserver;
use Metaregistrar\RDAP\Data\RdapNotice;
use PHPUnit\Framework\TestCase;

final class RdapTest extends TestCase {
    /**
     * just to test
     */
    public function testCase(): void {
        $this->assertFalse(false);
    }

    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testEmptySearch(): void {
        $rdap = new Rdap(Rdap::IPV4);

        $this->expectException(RdapException::class);
        $rdap->search('');
    }

    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testNoConstructorParamter(): void {
        $this->expectException(RdapException::class);
        new Rdap('');
    }

    /**
     *
     *
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testDomainSearch(): void {
        $rdap = new Rdap(Rdap::DOMAIN);

        $response = $rdap->search('udag.com');

        $this->assertNotNull($response);

        $nameserver = $response->getNameservers();
        $this->assertIsArray($nameserver);

        $this->assertInstanceOf(RdapNameserver::class, $nameserver[0]);
        foreach ($response->getEntities() as $entity) {
            $this->assertInstanceOf(RdapEntity::class, $entity);
        }
    }

    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testNonExistantSearch(): void {
        $rdap = new Rdap(Rdap::DOMAIN);

        $response = $rdap->search('mrfglsadfgasdf.rocks');

        $this->assertNotNull($response);

        $this->assertEquals(404, $response->getErrorCode());
        $this->assertEquals('Object not found', $response->getTitle());
    }

    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testSiteSearch(): void {
        $rdap = new Rdap(Rdap::DOMAIN);

        $response = $rdap->search('adac.site');

        $this->assertNotNull($response);

        $secureDNS = $response->getSecureDNS();
        $this->assertIsArray($secureDNS);

        $tags = [];
        foreach ($secureDNS as $dns) {
            $tags[] = $dns->getKeyTag();
        }
    }
    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testInvalidDomainSearch(): void {
        $rdap = new Rdap(Rdap::DOMAIN);

        $invalidDomainName = 'notADomainName';

        $this->expectException(RdapException::class);
        $this->expectExceptionMessage("Invalid domain name '$invalidDomainName'.");

        $rdap->search($invalidDomainName);
    }


    /**
     * @return void
     * @throws \Metaregistrar\RDAP\RdapException
     */
    public function testIpv4Search(): void {
        $rdap = new Rdap(Rdap::IPV4);

        $result = $rdap->search('8.8.4.4');

        $this->assertNotNull($result);

        $notices = $result->getNotices();
        $this->assertIsArray($notices);

        $this->assertInstanceOf(RdapNotice::class, $notices[0]);
        foreach ($result->getEntities() as $entity) {
            $this->assertInstanceOf(RdapEntity::class, $entity);
        }
    }
}
