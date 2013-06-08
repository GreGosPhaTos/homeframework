<?php
namespace HomeFramework\app;

use HomeFramework\container\ContainerAware;

/**
 * Class Application
 * @package HomeFramework\app
 *
 */
abstract class Application extends ContainerAware {

    /**
     * @var string
     */
    protected $name;

    /**
     *
     */
    public function __construct() {
	    $this->container = $this->setContainer(new \HomeFramework\container\Container());
	    $this->name = "";
	}

    public function __destruct() {
        $this->shutDown();
    }

    /**
     *
     */
    protected function beforeRun() {
        // Bootstrap par défaut
        //$this->container->set("Application", $this);
        $this->container->attach(new Bootstrap());
    }

    protected function shutDown() {
        exit;
    }

    /**
     * Run the application
     * @return void
     */
    final public function run() {
	    $this->beforeRun();
        FrontDispatcher::dispatch($this);
	}

    /**
     * Returns the application name.
     *
     * @return string
     */
    public function name() {
        return $this->name;
    }

    /**
     *
     * @return \HomeFramework\container\Container
     */
    public function getContainer() {
	    return $this->container;
	}

}