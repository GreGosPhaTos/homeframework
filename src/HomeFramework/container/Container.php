<?php
namespace HomeFramework\container;


/**
 * Class Container
 *
 *
 */
class Container implements \HomeFramework\common\IAccess, SplSubject {

    /**
     * @var array
     */
    private $container = array();

    /**
     * @var array
     */
    private $observers = array();

    public function get($service) {
        if(!isset($this->container[$service])) {
            $this->notify($service);
        }
        return $this->container[$service];
    }

    /**
     * Set a new service to the container
     *
     * @param $service
     * @param $object
     *
     * @return void
     */
    public function set($service, $object) {
        if ($this->container[$service] !== $object) {
            unset($this->container[$service]);
            $this->container[$service] = $object;
        }
    }

    /**
     * @param string $service
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function notify($service = "") {
        foreach ($this->observers as $observer) {
            if ($observer->update($service)) {
                return true;
            }
        }
        throw new \RuntimeException("Aucun service " . $service . " n' a été trouvé");
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