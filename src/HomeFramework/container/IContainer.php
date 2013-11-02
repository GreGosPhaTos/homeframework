<?php
namespace HomeFramework\container;

/**
 * Lazy Loading Interface Container 
 * @package HomeFramework\container
 */
Interface IContainer {

    /**
     * Return the instance
     *
     * @param string $serviceName
     * @return mixed
     * @throws \RuntimeException
     */
    public function get($serviceName, $forceInstance = false);
    
    /**
     * Clear Cache
     * 
     * @return void
     *
     */ 
    public clearCache();
    
    /**
     * Set the cache 
     *
     * @param string $serviceName
     * return void
     */
    private function cache($serviceName) 
    
    /**
     * Set a new service to the container
     *
     * @param \HomeFramework\container\Service $service
     * @return void
     */
    public function set($serviceName, $callback);
}
