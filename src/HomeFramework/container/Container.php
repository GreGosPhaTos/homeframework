<?php
namespace HomeFramework\container;

use HomeFramework\common\IAccess;

/**
 * Class Container
 *
 *
 */
class Container implements IAccess, \SplSubject {

    /**
     * @var array
     */
    private $container = array();

    /**
     * @var array
     */
    private $observers = array();

    /**
     * @var
     */
    private $service;

    public function get($service) {
        if(!isset($this->container[$service])) {
            $this->service = $service;
            $this->notify();
        }
        return $this->container[$service];
    }

    /**
     * Set a new service to the container
     *
     * @param $service
     * @param $object
     *
     * @internal param $service
     * @return void
     */
    public function set($service, $object) {
        if (!isset($this->container[$service])) {
            $this->container[$service] = $object;
        } else if ($this->container[$service] !== $object) {
            $this->container[$service] = $object;
        }
    }

    /**
     * @return mixed
     */
    public function getServiceName() {
        return $this->service;
    }

    /**
     * Notify the observers
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function notify() {
        foreach ($this->observers as $observer) {
            if ($observer->update($this)) {
                return true;
            }
        }
        throw new \RuntimeException("Aucun service " . $this->service . " n' a été trouvé");
    }

    /**
     * Attach a new observer
     *
     * @param \HomeFramework\container\SplObserver|\SplObserver $observer
     *
     * @return void
     */
    public function attach(\SplObserver $observer) {
        if (!isset($this->observers[get_class($observer)]) || (isset($this->observers[get_class($observer)]) && $this->observers[get_class($observer)] !== $observer)) {
            unset($this->container[get_class($observer)]);
            $this->observers[get_class($observer)] = $observer;
        }
    }

    /**
     * Detach an observer
     *
     * @param \HomeFramework\container\SplObserver|\SplObserver $observer
     *
     * @return void
     */
    public function detach(\SplObserver $observer) {
        unset($this->observers[$observer]);
    }
}