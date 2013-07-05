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
        $this->setContainer(new \HomeFramework\container\Container());
	    $this->name = "";
	}

    public function __destruct() {
        $this->shutDown();
    }

    /**
     * Before the app run
     * @return void
     */
    protected function beforeRun() {
        // default Bootstrap
        $this->container->attach(new Bootstrap());
        $this->container->set("ApplicationName", $this->getName());
    }

    /**
     * @todo finir
     */
    protected function shutDown() {}

    /**
     * Run the application
     * @return void
     */
    final public function run() {
	    $this->beforeRun();
        FrontDispatcher::dispatch($this);
        $this->shutDown();
	}

    /**
     * Returns the application name.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name) {
        $this->name = (string)$name;
    }

    /**
     *
     * @return \HomeFramework\container\Container
     */
    public function getContainer() {
	    return $this->container;
	}
}