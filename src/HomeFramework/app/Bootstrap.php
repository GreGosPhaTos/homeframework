<?php
namespace \HomeFramework\app;

use HomeFramework\container;

/**
 *
 *
 * @author Adrien
 */
class Bootstrap implements SplObserver {

    protected $container;

    public function __construct(\IContainer $container) {
        $this->container = $container;
    }

    protected function InitializeHttpRequest() {
        return new HomeFramework\http\HTTPRequest();
    }

    protected function InitializeRouter() {
        $routerBuilder = new HomeFramework\routing\RouterBuilder();
        $routerBuilder
            ->setRequest($this->container->get("HttpRequest"))
            ->setApplication($this->container->get("Application"));
    }

    protected function InitializePage() {
        $routerBuilder = new HomeFramework\page\Page();
        $routerBuilder->setRequest($container->get("HttpRequest"));
    }

    public function update($serviceName) {
        $object = $this->Initialize.ucfirst($serviceName)();
        $this->container->set($service, new );
    }
}