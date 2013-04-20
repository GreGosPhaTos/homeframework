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
            ->setContainer($this->container);

        return $routerBuilder->build();
    }

    /**
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function InitializeRouterFormatter() {
        $config = $this->container->get('DefaultConfiguration');
        $routeConfig = $config->get('route');
        $routerFormatterClass = "\\HomeFramework\\formatter\\".$routeConfig['route']['']."Formatter";
        $routerFormatter = new $routerFormatterClass($routeConfig['file']);

        return $routerFormatter;
    }

    /**
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function InitializeDefaultConfiguration() {
        // Default values
        $configureFormatter = new \HomeFramework\formatter\XMLFormatter(__DIR__."../app.xml");
        $config = new \HomeFramework\config\Configurator($configureFormatter);
        $config->configure();
        // @TODO externaliser dans un config
        $defaultConfDir = __DIR__.'/../apps/'.$this->container->get("Application")->name().'/config';
        $defaultRouteFile = $defaultConfDir."/routes.xml";
        $config->set("route", array("file" => $defaultRouteFile));

        return $config;
    }

    /**
     *
     */
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