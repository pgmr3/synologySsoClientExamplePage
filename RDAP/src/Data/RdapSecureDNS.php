<?php declare(strict_types=1);

namespace Metaregistrar\RDAP\Data;

final class RdapSecureDNS extends RdapObject {
    /**
     * @var bool
     */
    protected $rdapSecureDNS;
    /**
     * @var null|string
     */
    protected $delegationSigned;
    /**
     * @var null|int
     */
    protected $maxSigLife;
    /**
     * @var null|array
     */
    protected $dsData;
    /**
     * @var null|string
     */
    protected $keyTag;
    /**
     * @var null|string
     */
    protected $digestType;
    /**
     * @var null|string
     */
    protected $digest;
    /**
     * @var null|string
     */
    protected $algorithm;

    /**
     * @return boolean
     */
    public function isRdapSecureDNS(): bool {
        return $this->rdapSecureDNS;
    }

    /**
     * @return void
     */
    public function dumpContents(): void {
        if ($this->delegationSigned) {
            echo nl2br("- Domain name is signed\n");
        } else {
            echo nl2br("- Domain name is not signed\n");
        }
        if ($this->getKeyTag()) {
            $this->dumpDigest();
        }
        if ($this->getDsData()) {
            $this->dumpDnskey();
        }
    }

    /**
     * @return null|string
     */
    public function getKeyTag(): ?string {
        if (is_array($this->keyTag)) {
            return (string)array_shift($this->keyTag);
        }

        return $this->keyTag;
    }

    /**
     * @return void
     */
    public function dumpDigest(): void {
        echo nl2br('- Delegation signed: ' . $this->getDelegationSigned() . PHP_EOL);
        echo nl2br('- Max sig life: ' . $this->getMaxSigLife() . PHP_EOL);
        echo nl2br('- Keytag: ' . $this->getKeyTag() . PHP_EOL);
        echo nl2br('- Algorithm: ' . $this->getAlgorithm() . PHP_EOL);
        echo nl2br('- Digest Type :' . $this->getDigestType() . PHP_EOL);
        echo nl2br('- Digest: ' . $this->getDigest() . PHP_EOL);
    }

    /**
     * @return null|string
     */
    public function getDelegationSigned(): ?string {
        return $this->delegationSigned;
    }

    /**
     * @return int|null
     */
    public function getMaxSigLife(): ?int {
        return $this->maxSigLife;
    }

    /**
     * @return null|string
     */
    public function getAlgorithm(): ?string {
        if (is_array($this->algorithm)) {
            return (string)array_shift($this->algorithm);
        }

        return $this->algorithm;
    }

    /**
     * @return null|string
     */
    public function getDigestType(): ?string {
        if (is_array($this->digestType)) {
            return (string)array_shift($this->digestType);
        }

        return $this->digestType;
    }

    /**
     * @return null|string
     */
    public function getDigest(): ?string {
        if (is_array($this->digest)) {
            return (string)array_shift($this->digest);
        }

        return $this->digest;
    }

    /**
     * @return array|null
     */
    public function getDsData(): ?array {
        return $this->dsData;
    }

    /**
     * @return void
     */
    public function dumpDnskey(): void {
        echo nl2br('- Delegation signed: ' . $this->getDelegationSigned() . PHP_EOL);
        echo nl2br('- Max sig life: ' . $this->getMaxSigLife() . PHP_EOL);
        echo nl2br('- DNS Key: ' . implode(', ', $this->getDsData()) . PHP_EOL);
    }
}
