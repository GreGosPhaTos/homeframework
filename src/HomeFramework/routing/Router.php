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
    private $formater;

    public function getController() {
        $parser = ParserFactory::getParser($this->format);
        $parser->parse;

        // @todo externaliser le reader dans une classe
    }

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
