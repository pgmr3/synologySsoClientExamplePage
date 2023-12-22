<?php declare(strict_types=1);

namespace Metaregistrar\RDAP\Data;

final class RdapRole extends RdapObject {
    /**
     * @return void
     */
    public function dumpContents(): void {
        echo nl2br('- Role: ' . $this->getRole() . PHP_EOL);
    }

    /**
     * @return mixed
     */
    public function getRole() {
        return $this->{0};
    }
}