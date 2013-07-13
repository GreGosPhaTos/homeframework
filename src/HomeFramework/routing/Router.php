<?php
namespace HomeFramework\routing;

/**
 * Class Router
 *
 * @package HomeFramework\routing
 */
class Router
{
    /**
     * @var \HomeFramework\http\HTTPRequest
     */
    private $httpRequest;

    /**
     * @var \HomeFramework\formatter\Iformatter
     */
    private $formatter;

    /**
     *
     * @throws \RuntimeException
     * @throws \Exception
     * @return mixed
     */
    public function getRoute() {
        $routes = $this->formatter->toArray();
        $routeEntity = null;

        if (!isset($routes['route'])) {
            throw new \RuntimeException("la configuration de la route est erronée.");
        }

        foreach ($routes['route'] as $route) {
            if (preg_match('#^'.$route['url'].'$#', $this->httpRequest->getRequestURI(), $matches)) {
                $routeEntity = new Route();
                if (isset($route['vars'])) {
                    $i = 1;
                    foreach (explode(',', $route['vars']) as $varName) {
                        $vars[$varName] = $matches[$i];
                        $i++;
                    }
                    $routeEntity->setVars($vars);
                }

                $routeEntity->setUrl($route['url']);
                $routeEntity->setModule($route['module']);
                $routeEntity->setAction($route['action']);
                break 1;
            }
        }

        if (is_null($routeEntity)) {
            throw new \Exception("Pas de route disponible.");
        }

        /* @TODO à fixer avec la classe Request */
        array_merge($_GET, $routeEntity->getVars());
        return $routeEntity;
    }

    /**
     * Sets the http request
     *
     * @param \HomeFramework\http\HTTPRequest $httpRequest
     */
    public function setHTTPRequest (\HomeFramework\http\HTTPRequest $httpRequest) {
        $this->httpRequest = $httpRequest;
    }

    /**
     * Sets the formatter
     *
     * @param \HomeFramework\formatter\Iformatter $formatter
     */
    public function setFormatter (\HomeFramework\formatter\Iformatter $formatter) {
        $this->formatter = $formatter;
    }
}
