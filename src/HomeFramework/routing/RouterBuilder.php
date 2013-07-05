<?php
namespace HomeFramework\routing;

/**
 * Class RouterBuilder
 *
 * @package HomeFramework\routing
 */
class RouterBuilder implements \HomeFramework\common\IBuilder {

    /**
     * @var \HomeFramework\container\Container
     */
    private $container;

    /**
     * @return \HomeFramework\routing\Router
     */
    public function build() {
        $router = new \HomeFramework\routing\Router();
        $router->setFormatter($this->container->get('RouterFormatter'));
        $router->setHTTPRequest($this->container->get('HTTPRequest'));

        return $router;
    }

    /**
     * Sets the application container
     *
     * @param $container
     *
     * @return mixed
     */
    public function setContainer(\HomeFramework\common\IAccess $container) {
        $this->container = $container;
    }
}