<?php
namespace HomeFramework\app;

use HomeFramework\container,
    HomeFramework\http\HTTPResponse,
    HomeFramework\http\XMLResponse,
    HomeFramework\http\JSONResponse,
    HomeFramework\http\HTTPRequest;


/**
 *
 *
 * @author Adrien
 */
class Bootstrap extends container\ContainerAware implements \SplObserver {

    /**
     * @return \HomeFramework\http\HTTPRequest
     */
    protected function InitializeHTTPRequest() {
        return new HTTPRequest();
    }

    /**
     * @return HTTPResponse
     */
    protected function InitializeHTTPResponse() {
        return new HTTPResponse();
    }

    /**
     * @return JSONResponse
     */
    protected function InitializeJSONResponse() {
        return new JSONResponse();
    }

    /**
     * @return XMLResponse
     */
    protected function InitializeXMLResponse() {
        return new XMLResponse();
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
        $replacement = array('appName' => $this->container->get('ApplicationName'));
        $configReader = $this->container->get($config->get('reader'));
        $routeConfig['file'] = $configReader->read($replacement, $routeConfig['file']);
        $config->set('route', $routeConfig);

        $routerFormatterClass = "\\HomeFramework\\formatter\\".$routeConfig['parser']['format']."Formatter";
        $routerFormatter = new $routerFormatterClass(file_get_contents($routeConfig['file']));

        return $routerFormatter;
    }

    /**
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function InitializeDefaultConfiguration() {
        // Default values
        $config = new \HomeFramework\config\Configurator(
            // @todo fix me
            new \HomeFramework\formatter\XMLFormatter(file_get_contents(__DIR__."/../../../../../apps/app.xml"))
        );

        return $config->configure();
    }

    /**
     * @return \HomeFramework\manager\EntityManager
     * @TODO fixer
     */
    protected function InitializeEntityManager() {
        $config = $this->container->get('DefaultConfiguration');
        $emConfig = $config->get('entityManager');
        $api = $emConfig['api'];
        $className = $emConfig['api']."Factory";
        $method = "get".$emConfig['sgbd']."Connexion";
        $dao = $className::$method;
        $namespace = $emConfig['namespace'];

        return new \HomeFramework\manager\EntityManager($api, $dao, $namespace);
    }

    /**
     * @return \HomeFramework\reader\ConfigPathReaderÇ
     */
    protected function InitializePathReader() {
        return new \HomeFramework\reader\PathReader();
    }

    /**
     * @param \SplSubject $container
     * @throws \InvalidArgumentException
     * @internal param $serviceName
     *
     * @return bool
     */
    public function update(\SplSubject $container) {
        // @TODO assignation obligatoire à chaque fois ? utilisation du helper Object
        $this->setContainer($container);
        $serviceName = $this->container->getServiceName();
        $method = "Initialize".ucfirst($serviceName);

        if (is_callable(array($this, $method), true)) {
            $service = $this->$method();
        } else {
            throw new \InvalidArgumentException($method . " : This method is not callable. This service doesn't exist.");
        }

        if (is_object($service)) {
            $this->container->set($serviceName, $service);
            return true;
        }

        return false;
    }
}