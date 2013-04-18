<?php
namespace HomeFramework\routing;

use HomeFramework\routing;

/**
 * Class ParserFactory
 *
 * @package HomeFramework\routing
 */
class ParserFactory {
    /**
     * Get the Parser object by the format
     *
     * @param string $format Format
     * @return XMLParser
     */
    static public function getParser($format) {
        switch ($format) {
            case 'xml' :
                return new XMLParser();
            break;
        }
    }
}