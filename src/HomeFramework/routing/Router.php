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
     * @var \HomeFramework\routing\Route $route
     */
    private $route;

    /**
     * @var \HomeFramework\http\HTTPRequest
     */
    private $httpRequest;

    /**
     * @var \HomeFramework\formatter\Iformatter
     */
    private $formatter;

    public function getController() {
        $routeConfiguration = $this->formatter->toArray();
        $routes = $routeConfiguration['route'];

        foreach ($routes as $route) {
            $vars = array();

            if (isset($route['@vars'])) {
                $vars = $route['@vars'];
            }

            $this->route->setUrl($route['url']);
            $this->route->setUrl($route['module']);
            $this->route->setUrl($route['action']);

            new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
        }

        try
        {
            // On récupère la route correspondante à l'URL.
            $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == \Library\Router::NO_ROUTE)
            {
                // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
                $this->httpResponse->redirect404();
            }
        }

        // On ajoute les variables de l'URL au tableau $_GET.
        $_GET = array_merge($_GET, $matchedRoute->vars());

        // On instancie le contrôleur.
        $controllerClass = 'Applications\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());

    }

    /**
     * Sets the route entity
     *
     * @param Route $route
     */
    public function setRoute (\HomeFramework\routing\Route $route) {
        $this->route = $route;
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
