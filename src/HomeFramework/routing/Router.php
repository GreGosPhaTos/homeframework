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
     * @throws \RuntimeException
     * @throws \HttpRequestException
     * @return mixed
     */
    public function getRoute() {
        $routes = $this->formatter->toArray();
        $routeEntity = null;

        if (!isset($routes['route'])) {
            throw new \RuntimeException("la configuration de la route est erronée.");
        }

        foreach ($routes['route'] as $route) {
            if (preg_match('/^\/'.$route['@attributes']['url'].'$/', $this->httpRequest->getRequestURI(), $matches)) {
                $routeEntity = new Route();
                if (isset($route['@attributes']['vars'])) {
                    $i = 1;
                    foreach (explode(',', $route['@attributes']['vars']) as $varName) {
                        $vars[$varName] = $matches[$i];
                        $i++;
                    }
                }

                $routeEntity->setUrl($route['@attributes']['url']);
                $routeEntity->setModule($route['@attributes']['module']);
                $routeEntity->setAction($route['@attributes']['action']);
                break 1;
            }
        }

        if (is_null($routeEntity)) {
            throw new \HttpRequestException("Pas de route disponible.");
        }

        /* @TODO à fixer avec la classe Request */
        array_merge($_GET, $routeEntity->vars());
        return $this->route;
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
