<?php
namespace HomeFramework\app;

/**
 * Class Application
 * @package HomeFramework\app
 *
 */
abstract class Application {

    /**
     * @var \HomeFramework\container\Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $name;

    /**
     *
     */
    public function __construct() {
	    $this->container = new \HomeFramework\container\Container();
	    $this->name = "";
	}

    /**
     * Run the application
     * @return void
     */
    public function run() {
	    // Bootstrap par défaut
	    $this->container->set("Application", $this);
		$this->container->attach(new Bootstrap($this->container));
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