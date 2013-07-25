<?php
namespace HomeFramework\vendors;


class Log4phpFactory {

    public static function getLog4phpInstance(array $config) {
        $classPath = Config::getMainClassPath("log4php");
        require ($classPath);

        \Logger::configure($config);
        return \Logger::getLogger('homeFrameworkLogger');
    }
}