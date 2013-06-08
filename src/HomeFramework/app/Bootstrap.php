<?php
namespace HomeFramework\app;

use HomeFramework\container;

/**
 *
 *
 * @author Adrien
 */
class Bootstrap extends container\ContainerAware implements \SplObserver {

    /**
     * @return \HomeFramework\http\HTTPRequest
     */
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
        $replacement = array('appName' => $this->container->get('Application')->getName());
        $configReader = $this->container($config->get('reader'));
        $routeConfig['file'] = $configReader->read($replacement, $routeConfig['file']);
        $config->set('route', $routeConfig);

        $routerFormatterClass = "\\HomeFramework\\formatter\\".$routeConfig['route']['parser']['format']."Formatter";
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
        return $config;
    }

    /**
     * @return \HomeFramework\reader\ConfigPathReader
     */
    protected function InitializePathReader() {
        return new \HomeFramework\reader\ConfigPathReader();
    }

    /**
     * @return \HomeFramework\page\Page
     */
    protected function InitializePage() {
        $config = $this->container->get('DefaultConfiguration');
        $routeConfig = $config->get('page');
        $replacement = array('appName' => $this->container->get('Application')->getName());
        $configReader = $this->container($config->get('reader'));
        $routeConfig['file'] = $configReader->read($replacement, $routeConfig['file']);
        $config->set('route', $routeConfig);


        $pageBuilder = new \HomeFramework\page\PageBuilder();
        $pageBuilder
            ->setContainer($this->container);

        return $pageBuilder->build();
    }

    /**
     * @param \SplSubject $container
     * @internal param $serviceName
     *
     * @return bool
     */
    public function update(\SplSubject $container) {
        // @TODO assignation obligatoire à chaque fois ? utilisation du helper Object
        $this->setContainer($container);
        $service = $this->Initialize.ucfirst($this->container->getServiceName());
        if (is_callable($service)) {
            $this->container->set($this->container->getServiceName(), new $service);
            return true;
        }

        return false;
    }
}