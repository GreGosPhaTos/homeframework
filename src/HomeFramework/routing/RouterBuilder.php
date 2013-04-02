<?php
namespace HomeFramework\routing;

/**
 * Class RouterBuilder
 *
 * @package HomeFramework\routing
 */
class RouterBuilder implements HomeFramework\common\IBuilder {

    /**
     * @var HomeFramework\container\Container
     */
    private $container;

    /**
     *
     * @param HomeFramework\container\Container $container
     */
    public function setContainer(HomeFramework\container\Container $container) {
        $this->container = $container;
    }

    /**
     * @return HomeFramework\routing\Router
     */
    public function build() {
        $router = new HomeFramework\routing\Router();

        $router
            ->setApp($this->container->get('Application'))
            ->setRequest($this->container->get('HTTPRequest'));

        return $router;
    }
}