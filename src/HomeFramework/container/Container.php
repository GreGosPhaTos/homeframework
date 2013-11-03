<?php
namespace HomeFramework\container;

use HomeFramework\container\exception\ContainerException,
    HomeFramework\container\exception\ContainerInvalidArgumentException;

/**
 * Lazy Loading Container
 * @package HomeFramework\container
 */
class Container implements IContainer {
    
    /**
     * @var array
     */
    private $container = array();

    /**
     * @var array
     */
    private $cache = array();

    /**
     * Return the instance
     *
     * @param string $serviceName
     * @param bool $forceInstance
     * @throws ContainerException
     * @return mixed
     */
    public function get($serviceName, $forceInstance = false) {
        if (!$this->hasService($serviceName)) {
            throw new ContainerException("Service [".$serviceName."] doesn't exists");
        } else if (true === $forceInstance || !isset($this->cache[$serviceName])) {
            $this->cache($serviceName);
        }

        return $this->cache[$serviceName];
    }

    /**
     * Clear Cache
     * 
     * @return void
     *
     */ 
    public function clearCache() {
        $this->cache = array();
    }

    /**
     * Set the cache 
     *
     * @param string $serviceName
     * return void
     */
    private function cache($serviceName) {
        $callback = $this->container[$serviceName];
        $this->cache[$serviceName] = $callback();
    }

    /**
     * Set a new service to the container
     *
     * @param $serviceName
     * @param $callback
     * @throws ContainerInvalidArgumentException
     *
     * @return void
     */
    public function set($serviceName, $callback) {
        if (!is_string($serviceName)) {
            throw new ContainerInvalidArgumentException("ServiceName must be a string given : [" . gettype($serviceName) . "]");
        }

        if (!is_callable($callback)) {
            throw new ContainerInvalidArgumentException("Callback must be a callable function in service : [" . $serviceName . "]");
        }

        $this->container[$serviceName] = $callback;
    }

    /**
     * Returns if the given service exists
     *
     * @param $serviceName
     * @return bool
     */
    public function hasService($serviceName) {
        if (isset($this->container[$serviceName])) {
            return true;
        }

        return false;
    }
}
