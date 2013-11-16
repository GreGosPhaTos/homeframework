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
    protected $name = "";
    protected $logger;

    /**
     *
     */
    public function __construct() {
        $this->setContainer(new Container());
        $this->addBootStrap(new DefaultBootstrap());
	}

    /**
     * Before the Application starts
     * @throws \RuntimeException
     * @return void
     */
    protected function before() {
        $this->logger = $this->container->get("Logger");
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
    protected function after() {
        $this->logger->info("### Application " .$this->getName() . " stops");
        $this->logger->debug("At Stop -- Memory Usage : " . memory_get_usage());
    }

    /**
     * Run the application
     * @return void
     */
    final public function run() {
        $this->before();
        FrontDispatcher::dispatch($this->container);
        $this->after();
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

    /**
     *
     */
    public function addBootStrap (Bootstrap $bootstrap) {
        $bootstrap->setContainer($this->container);
        // TODO Now ?
        $bootstrap->boot();
    }
}
