<?php
namespace HomeFramework\app;

use HomeFramework\container\ContainerAware,
    HomeFramework\container\IContainer,
    HomeFramework\http\HTTPResponse,
    HomeFramework\http\XMLResponse,
    HomeFramework\http\JSONResponse,
    HomeFramework\http\HTTPRequest,
    HomeFramework\bundles\Logger;

/**
 * Class Bootstrap the default Bootstrap
 * @package HomeFramework\app
 */
abstract class Bootstrap extends ContainerAware {

    protected $container;

    /**
     *
     */
    public function getContainer() {
        return $this->container;
    }

    /**
     *
     */
    abstract public function boot();
}
