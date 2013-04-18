<?php
namespace HomeFramework\app;

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
        return new \HomeFramework\http\HTTPRequest();
    }

    /**
     *
     * @return \HomeFramework\routing\Router
     */
    protected function InitializeRouter() {
        $routerBuilder = new \HomeFramework\routing\RouterBuilder();
        $routerBuilder
            ->setRequest($this->container->get("HttpRequest"))
            ->setApplication($this->container->get("Application"));

        return $routerBuilder->build();
    }

    protected function InitializeRouterFormatter() {
        // @todo ? conf ?
        $xmlFile = "";
        $routerFormater = new \HomeFramework\formatter\XMLFormatter($xmlFile);

        return $routerFormater;
    }

    protected function InitializePage() {
        $routerBuilder = new \HomeFramework\page\Page();
        $routerBuilder->setRequest($this->container->get("HttpRequest"));
    }

    public function update($serviceName) {
        $function = $this->Initialize.ucfirst($serviceName);
        if (!is_callable($this->Initialize.ucfirst($serviceName))) {
            throw new \RuntimeException('La fonction '.$function. ' n\'existe pas.');
        }

        $service = $function;
        $this->container->set($serviceName, new $service);
    }
}