<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 24/07/13
 * Time: 23:45
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;


abstract class Bootstrap implements IContainerSubscriber {

    /**
     * A Cached Object Container
     *
     * @var array
     */
    private $cache = array();

    /**
     *
     *
     * @param \HomeFramework\container\IContainer $container
     * @return bool
     */
    public function pushService(IContainer $container) {
        $service = $container->getService();
        $service->setInstance($this->get($service->getName()));
        return true;
    }

    /**
     * @param $serviceName
     * @return mixed
     * @throws \RuntimeException
     */
    final protected function get($serviceName) {
        $serviceName = ucfirst($serviceName);
        if (isset($this->cache[$serviceName])) return $this->cache[$serviceName];

        $method = "initialize".$serviceName;
        if (is_callable(array($this, $method), true)) {
            $this->cache[$serviceName] = $this->$method();
            return $this->cache[$serviceName];
        }

        throw new \RuntimeException($method ." is not callable.");
    }
}