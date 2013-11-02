<?php
namespace HomeFramework\app;

use HomeFramework\container\IContainer,
    HomeFramework\http\HTTPResponse,
    HomeFramework\http\XMLResponse,
    HomeFramework\http\JSONResponse,
    HomeFramework\http\HTTPRequest,
    HomeFramework\bundles\Logger;


/**
 * Class Bootstrap the default Bootstrap
 * @package HomeFramework\app
 */
class DefaultBootstrap implements IBootstrap {

    public function init(IContainer $container) {
    
    }

    /**
     * @return \HomeFramework\http\HTTPRequest
     */
    public static function initializeHTTPRequest(IContainer $container) {
        $container->set('HTTPRequest', function() {
            return new HTTPRequest();
        }
    }

    /**
     * @return HTTPResponse
     */
    protected function initializeHTTPResponse() {
        return new HTTPResponse();
    }

    /**
     * @return JSONResponse
     */
    protected function initializeJSONResponse() {
        return new JSONResponse();
    }

    /**
     * @return XMLResponse
     */
    protected function initializeXMLResponse() {
        return new XMLResponse();
    }

    /**
     * @return Logger
     * @throws \Exception
     */
    protected function initializeLogger() {
        $config = $this->get('DefaultConfiguration');
        $loggerConfig = $config->get('logger');

        try {
            return $logger = new Logger($loggerConfig["path"]);
        } catch (\Exception $e) {
            var_dump($loggerConfig["path"]);
            throw new \Exception("Logger initialisation failed with message : " . $e->getMessage());
        }
    }

    /**
     *
     * @return \HomeFramework\routing\Router
     */
    protected function initializeRouter() {
        $router = new \HomeFramework\routing\Router();
        $router->setFormatter($this->get('RouterFormatter'));
        $router->setHTTPRequest($this->get('HTTPRequest'));

        return $router;
    }

    /**
     * @throws \Exception
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function initializeRouterFormatter() {
        $config = $this->get('DefaultConfiguration');
        $routeConfig = $config->get('route');
        $replacement = array('appName' => $config->get('applicationName'));
        $configReader = $this->get($config->get('reader'));
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
    }

    /**
     * @throws \Exception
     * @return \HomeFramework\formatter\XMLFormatter
     */
    protected function initializeDefaultConfiguration() {
        $filename = __DIR__."/../../../../../apps/app.xml";
        if (!is_file($filename)) {
            $message = "Application config file is not set.";
            $this->get("logger")->error("Bootstrap " . $message);
            throw new \Exception($message);
        }

        $config = new \HomeFramework\config\Configurator(
            new \HomeFramework\formatter\XMLFormatter(file_get_contents($filename))
        );

        return $config->configure();
    }

    /**
     * @return \HomeFramework\manager\EntityManager
     */
    protected function initializeEntityManager() {
        $config = $this->get('DefaultConfiguration');
        $emConfig = $config->get('entityManager');
        $api = $emConfig['api'];
        $className = $api."Factory";
        $method = "get".$emConfig['sgbd']."Connexion";
        $dao = $className::$method;

        return new \HomeFramework\manager\EntityManager($api, $dao);
    }

    /**
     * @:return \HomeFramework\manager\EntityManager
     */
    protected function initializePDOEntityManager() {
        $config = $this->get('DefaultConfiguration');
        $emConfig = $config->get('entityManager');
        $api = 'PDO';
        $className = $api."Factory";
        $method = "get".$emConfig['sgbd']."Connexion";
        $dao = $className::$method;

        return new \HomeFramework\manager\EntityManager($api, $dao);
    }

    /**
     * @return \HomeFramework\reader\ConfigPathReaderÇ
     */
    protected function initializePathReader() {
        return new \HomeFramework\reader\PathReader();
    }
}
