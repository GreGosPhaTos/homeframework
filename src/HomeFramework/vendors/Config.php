<?php
namespace HomeFramework\vendors;

/**
 * Class Config
 * @package HomeFramework\vendors
 */
class Config {
    /**
     * @param $vendor
     * @return mixed
     */
    public static function getMainClassPath($vendor) {

        $classPaths = array(
            "log4php" => __DIR__.'/../../../vendor/log4php/src/main/php/Logger.php',
        );

        return $classPaths[$vendor];
    }
}