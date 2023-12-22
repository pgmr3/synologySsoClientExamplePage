<?php declare(strict_types=1);

namespace Metaregistrar\RDAP\Data;

final class RdapDescription extends RdapObject {
    /**
     * @var string|null
     */
    protected $description;

    /**
     * RdapDescription constructor.
     * @param string $key
     * @param mixed $content
     */
    public function __construct(string $key, $content) {
        parent::__construct($key, null);
        if (is_array($content)) {
            $this->description = $content[0];
        } else {
            $this->description = $content;
        }
    }

    /**
     * @return void
     */
    public function dumpContents(): void {
        echo nl2br('  - Description: ' . $this->getDescription() . PHP_EOL);
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description??'';
    }
}
