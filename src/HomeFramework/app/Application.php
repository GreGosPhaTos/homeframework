<?php
namespace HomeFramework\app;

use HomeFramework\container\ContainerAware,
    HomeFramework\container\Container;

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

    protected $logger;

    /**
     *
     */
    public function __construct() {
        $this->setContainer(new Container());
	    $this->name = "";

        // default Bootstrap
        $this->container->subscribe(new DefaultBootstrap());
        $this->logger = $this->container->get("logger");
	}

    /**
     * Before the Application starts
     * @throws \RuntimeException
     * @return void
     */
    protected function beforeRun() {
        // set the application name in the config
        if (is_null($this->getName())) throw new \RuntimeException ("Application must have a name.");
        $config = $this->container->get("DefaultConfiguration");
        $config->set("applicationName", $this->getName());
        // log application start
        $this->logger->info("### Application " .$this->getName() . " starts");
        $this->logger->debug("At Start -- Memory Usage : " . memory_get_usage());
    }

    /**
     * Application stops
     */
    protected function shutDown() {
        $this->logger->info("### Application " .$this->getName() . " stops");
        $this->logger->debug("At Stop -- Memory Usage : " . memory_get_usage());
    }

    /**
     * Run the application
     * @return void
     */
    final public function run() {
        $this->beforeRun();
        FrontDispatcher::dispatch($this->container);
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