<?php declare(strict_types=1);

namespace Metaregistrar\RDAP\Data;

final class RdapLink extends RdapObject {
    /**
     * @var string
     */
    protected $rel;
    /**
     * @var string
     */
    protected $href;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $value;

    public function __construct(string $key, $content) {
        parent::__construct($key, null);
        if (is_array($content)) {
            //print_r($content);
            if (isset($content[0])) {
                if (isset($content[0]['rel'])){
                    $this->rel   = $content[0]['rel'];
                }
                $this->href  = $content[0]['href'];
                $this->type  = $content[0]['type'];
                if (isset($content[0]['value'])){//fie
                    $this->value = $content[0]['value'];
                }//fie	
            } else {
                if (isset($content['rel'])){
                    $this->rel   = $content['rel'];
                }
                $this->href  = $content['href'];
                $this->type  = $content['type'];
                if (isset($content['value'])){//fie
                    $this->value = $content['value'];
                }//fie
            }
        }
    }

    public function dumpContents(): void {
        //fie org echo '  - Link: ' . $this->rel . ': ', $this->href . ' (' . $this->title . ")\n";
        echo nl2br('  - Link: ' . $this->href . "\n");//fie
    }

    /**
     * @return string
     */
    public function getRel(): string {
        return $this->rel;
    }

    /**
     * @return string
     */
    public function getHref(): string {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }
}
