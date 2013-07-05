<?php
namespace HomeFramework\formatter;


class XMLFormatter implements IFormatter {
    /**
     * @var array|string
     */
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * returns an array of data
     *
     * @throws \RuntimeException
     * @return array
     */
    public function toArray() {
        $xml = new \DOMDocument();
        if (!$xml->loadXML($this->data)) {
            throw new \RuntimeException("Le format XML est invalide");
        }

        return $this->parseXML($xml->documentElement);
    }

    /**
     * Format data
     *
     * @return string
     */
    public function format() {

    }

    /**
     * @param $node
     * @return array|string
     */
    private function parseXML($node) {
        $output = array();

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = $this->parseXML($child);

                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        if (!isset($output[$t])) {
                            $output[$t] = array();
                        }

                        $output[$t][] = $v;
                    } elseif($v) {
                        $output = (string) $v;
                    }
                }

                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = array();

                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }

                        $output['@attributes'] = $a;
                    }

                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v)==1 && $t!='@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }
}
