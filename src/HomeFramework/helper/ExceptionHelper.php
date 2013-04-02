<?php
namespace HomeFramework\helper;

/**
 * Class ExceptionHelper
 *
 * @package HomeFramework\helper
 */
class ExceptionHelper {

    static public function exceptionOutputer (\Exception $e) {
        printf('Exception catched code %d message %s', $e->getCode(), $e->getMessage());
    }
}