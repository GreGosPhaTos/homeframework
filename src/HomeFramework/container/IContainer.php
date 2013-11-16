<?php
namespace HomeFramework\container;

/**
 * Lazy Loading Interface Container 
 * @package HomeFramework\container
 */
interface IContainer {

    /**
     * Return the instance
     *
     * @param string $serviceName
     * @param bool $forceInstance
     * @return mixed
     */
    public function get($serviceName, $forceInstance = false);
    
    /**
     * Clear Cache
     * 
     * @return void
     *
     */ 
    public function clearCache();

    /**
     * Set a new service to the container
     *
     * @param $serviceName
     * @param $callback
     * @internal param \HomeFramework\container\Service $service
     * @return void
     */
    public function set($serviceName, $callback);
}
