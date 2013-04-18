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
     */
    private $formatter;

    public function getController() {

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
