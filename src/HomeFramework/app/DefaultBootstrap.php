<?php
namespace HomeFramework\app;

use HomeFramework\http\HTTPResponse,
    HomeFramework\http\XMLResponse,
    HomeFramework\http\JSONResponse,
    HomeFramework\http\HTTPRequest,
    HomeFramework\bundles\Logger,
    HomeFramework\config\Configurator;

/**
 * Class Bootstrap the default Bootstrap
 * @package HomeFramework\app
 */
class DefaultBootstrap extends Bootstrap {

    public function boot() {
        $this->initializeDefaultConfiguration();
        $this->initializeLogger();
        $this->initializeHTTPRequest();
        $this->initializeHTTPResponse();
        $this->initializeJSONResponse();
        $this->initializeRouter();
        $this->initializeRouterFormatter();
        $this->initializePathReader();
    }

    /**
     * @return \HomeFramework\http\HTTPRequest
     */
    protected function initializeHTTPRequest() {
        $this->container->set('HTTPRequest', function() {
            return new HTTPRequest();
        });
    }

    /**
     * @return HTTPResponse
     */
    protected function initializeHTTPResponse() {
        $this->container->set('HTTPResponse', function() {
            return new HTTPResponse();
        });
    }

    /**
     * @return JSONResponse
     */
    protected function initializeJSONResponse() {
        $this->container->set('JSONResponse', function() {
            return new JSONResponse();
        });
    }

    /**
     * @return XMLResponse
     */
    protected function initializeXMLResponse() {
        $this->container->set('XMLResponse', function() {
            return new XMLResponse();
        });
    }

    /**
     * @return Logger
     * @throws \Exception
     */
    protected function initializeLogger() {
        $container = $this->container;
        $container->set('Logger', function() use ($container) {
            $config = $container->get('DefaultConfiguration');
            $loggerConfig = $config->get('logger');

            try {
                return $logger = new Logger($loggerConfig["path"]);
            } catch (\Exception $e) {
                var_dump($loggerConfig["path"]);
                throw new \Exception("Logger initialisation failed with message : " . $e->getMessage());
            }
        });
    }

    /**
     *
     * @return \HomeFramework\routing\Router
     */
    protected function initializeRouter() {
        $container = $this->container;
        $container->set('Router', function() use ($container) {
            $router = new \HomeFramework\routing\Router();
            $router->setFormatter($container->get('RouterFormatter'));
            $router->setHTTPRequest($container->get('HTTPRequest'));

            return $router;
        });
    }

    /**
     * @throws \Exception
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function initializeRouterFormatter() {
        $container = $this->container;
        $container->set('RouterFormatter', function() use ($container) {
            $config = $container->get('DefaultConfiguration');
            $routeConfig = $config->get('route');
            $replacement = array('appName' => $config->get('applicationName'));
            $configReader = $container->get($config->get('reader'));
            if (!isset($routeConfig['file'])) {
                $message = "Route config file is not set.";
                $this->get("logger")
                    ->error("Bootstrap " . $message);
                throw new \Exception($message);
            }

            $routeConfig['file'] = $configReader->read($replacement, $routeConfig['file']);
            $config->set('route', $routeConfig);
            $routerFormatterClass = "\\HomeFramework\\formatter\\".$routeConfig['parser']['format']."Formatter";
            $routerFormatter = new $routerFormatterClass(file_get_contents($routeConfig['file']));

            return $routerFormatter;
        });
    }

    /**
     * @throws \Exception
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function initializeDefaultConfiguration() {
        $container = $this->container;
        $container->set('DefaultConfiguration', function() use ($container) {
            $filename = __DIR__."/../../../../../apps/app.xml";

            if (!is_file($filename)) {
                $message = "Application config file is not set.";
                throw new \Exception($message);
            }

            $config = new \HomeFramework\config\Configurator(
                new \HomeFramework\formatter\XMLFormatter(file_get_contents($filename))
            );

            return $config->configure();
        });
    }

    /**
     * @return \HomeFramework\manager\EntityManager
     */
    protected function initializeEntityManager() {
        $container = $this->container;
        $container->set('EntityManager', function() use ($container) {
            $config = $container->get('DefaultConfiguration');
            $emConfig = $config->get('entityManager');
            $api = $emConfig['api'];
            $className = $api."Factory";
            $method = "get".$emConfig['sgbd']."Connexion";
            $dao = $className::$method;

            return new \HomeFramework\manager\EntityManager($api, $dao);
        });
    }

    /**
     * @return \HomeFramework\manager\EntityManager
     */
    protected function initializePDOEntityManager() {
        $container = $this->container;
        $container->set('PDOEntityManager', function() use ($container) {
            $config = $container->get('DefaultConfiguration');
            $emConfig = $config->get('entityManager');
            $api = 'PDO';
            $className = $api."Factory";
            $method = "get".$emConfig['sgbd']."Connexion";
            $dao = $className::$method;

            return new \HomeFramework\manager\EntityManager($api, $dao);
        });
    }

    /**
     * @return \HomeFramework\reader\ConfigPathReader
     */
    protected function initializePathReader() {
        $this->container->set('PathReader', function() {
            return new \HomeFramework\reader\PathReader();
        });
    }


}