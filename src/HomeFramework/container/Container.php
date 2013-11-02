<?php
namespace HomeFramework\container;

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
     * @return mixed
     * @throws \RuntimeException
     */
    public function get($serviceName, $forceInstance = false) {
        if (true === $forceInstance || !isset($this->cache[$serviceName])) {
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
    public clearCache() {
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
     * @param \HomeFramework\container\Service $service
     * @return void
     */
    public function set($serviceName, $callback) {
        if (!is_callable($callback)) {
            throw new \RuntimeException("[Container] callback is not a function for service : [" . $serviceName . "]");
        }

        $this->container[$serviceName] = $callback;
    }

}
