<?php
namespace HomeFramework\bundles;


use HomeFramework\vendors;

/**
 * Class Logger A proxy Logger class.
 * @package HomeFramework\bundles
 */
class Logger {

    /**
     * Instance of the substitute class
     *
     * @var object $instance
     */
    private $instance;

    /**
     * The log file path
     *
     * @var string $filePath
     */
    private $filePath;

    /**
     * @param $filePath
     */
    public function __construct($filePath) {
        $this->setFilePath($filePath);
        $this->load();
    }

    /**
     * Load the instance of substitute class
     */
    private function load() {
        // Set log4PHP
        $this->instance = vendors\Log4phpFactory::getLog4phpInstance(
            array(
                'appenders' => array(
                    'default' => array(
                        'class' => 'LoggerAppenderRollingFile',
                        'layout' => array(
                            'class' => 'LoggerLayoutPattern',
                            'param' => array(
                                'value' => '%date [%logger] %message%newline'
                            ),
                        ),
                        'params' => array(
                            'file' => $this->filePath.'all.log',
                            'maxFileSize' => '1MB',
                            'maxBackupIndex' => 5,
                        ),
                    ),
                ),
                'rootLogger' => array(
                    'appenders' => array('default'),
                ),
            )
        );
    }

    /**
     * @param string $filePath The log file.
     * @throws \InvalidArgumentException
     */
    public function setFilePath($filePath) {
        if (!is_dir($filePath)) {
            throw new \InvalidArgumentException("Invalid logger path.");
        }
        $this->filePath = $filePath;
    }

    /**
     * Proxy of trace method
     * @param $message
     */
    public function trace($message) {
        $this->instance->trace($message);
    }

    /**
     * Proxy of debug method
     * @param $message
     */
    public function debug($message) {
        $this->instance->debug($message);
    }

    /**
     * Proxy of info method
     * @param $message
     */
    public function info($message) {
        $this->instance->info($message);
    }

    /**
     * Proxy of warning method
     * @param $message
     */
    public function warn($message) {
        $this->instance->warn($message);
    }

    /**
     * Proxy of error method
     * @param $message
     */
    public function error($message) {
        $this->instance->error($message);
    }

    /**
     * Proxy of fatal method
     * @param $message
     */
    public function fatal($message) {
        $this->instance->fatal($message);
    }
}