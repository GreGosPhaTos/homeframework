<?php
namespace HomeFramework\routing;

/**
 * Class Router
 *
 * @package HomeFramework\routing
 */
class Router
{
    private $ressource;

    private $routeFilePath;

    /**
     *
     * @throws \RuntimeException
     * @return unknown
     */
    public function getController() {
        // @todo externaliser le reader dans un classe
        $dom = new \DOMDocument;
        $dom->load($this->routeFilePath);

        try {
            foreach ($dom->getElementsByTagName('route') as $route) {
                if (preg_match('`^'.$route->getAttribute('url').'$`', $this->ressource, $matches)) {
                    $module = $route->getAttribute('module');
                    $action = $route->getAttribute('action');

                    $className = $module.'Controller';

                    if (!file_exists(dirname(__FILE__).'/../Applications/'.$this->application->name().'/Modules/'.$module.'/'.$className.'.class.php')) {
                        throw new \RuntimeException('Le module où pointe la route n\'existe pas');
                    }

                    $class = '\\app\\'.$this->application->name().'\\Modules\\'.$module.'\\'.$className;
                    $controller = new $class($this->application, $module, $action);

                    if ($route->hasAttribute('vars')) {
                        $vars = explode(',', $route->getAttribute('vars'));

                        foreach ($matches as $key => $match) {
                            if ($key !== 0) {
                                $this->httpRequest()->addGetVar($vars[$key - 1], $match);
                            }
                        }
                    }

                    break;
                }
            }
        } catch (\Exception $e) {
            HomeFramework\helper\ExceptionHelper::exceptionOutputer($e);
        }

        if (!isset($controller)) {
            $this->httpResponse()->redirect404();
        }

        return $controller;
    }

    private function parseRouteFile

    /**
     * Set the application attribute
     *
     * @param HomeFramework\app\Application $application
     */
    public function setApp (HomeFramework\app\Application $application) {
        $this->application = $application;
    }

    public function setHTTPRequest (HomeFramework\http\HTTPRequest $httpRequest) {
        $this->httpRequest = $httpRequest;
    }
}
