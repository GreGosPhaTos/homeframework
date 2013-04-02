<?php
namespace HomeFramework\helper;

/**
 * Class ObjectHelper
 *
 * @package lib\helper
 */
class ObjectHelper {

    /**
     * Compare two object
     *
     * @param $o1
     * @param $o2
     *
     * @return bool
     */
    static public function isClone(&$o1, &$o2)
    {
        if ($o1 === $o2) {
            return true;
        }

        return false;
    }

    /**
     * Compare two object values
     *
     * @param $o1
     * @param $o2
     *
     * @return bool
     *
     */
    static public function isEgal(&$o1, &$o2)
    {
        if ($o1 == $o2) {
            return true;
        }

        return false;
    }

}