<?php
namespace HomeFramework\container;

/**
 * Class Container The dynamic objects handler
 * @package HomeFramework\container
 */
class Container implements IContainer {

    /**
     * @var array
     */
    private $subscribers = array();

    /**
     * @var Service
     */
    private $service;

    /**
     * Dynamic getter
     *
     * @param string $serviceName
     * @return mixed
     * @throws \RuntimeException
     */
    public function get($serviceName) {
        $this->setService(new Service());
        $this->service->setName($serviceName);
        if ($this->fetchService()) {
            return $this->service->getInstance();
        }

        throw new \RuntimeException ("Initialization of service " . $serviceName . " failed");
    }

    /**
     * Set a new service to the container
     *
     * @param \HomeFramework\container\Service $service
     * @return void
     */
    public function setService(Service $service) {
        $this->service = $service;
    }

    /**
     * Notify the subscribers
     *
     * @throws \RuntimeException
     * @return bool
     */
    public function fetchService() {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->pushService($this)) {
                return true;
            }
        }

        throw new \RuntimeException("No service for " . $this->service->getName());
    }

    /**
     * Returns the service
     *
     * @return Service
     */
    public function getService() {
        return $this->service;
    }

    /**
     * Attach a new subscriber
     *
     * @param IContainerSubscriber $subscriber
     * @return mixed|void
     */
    public function subscribe(IContainerSubscriber $subscriber) {
        if (isset($this->subscribers[get_class($subscriber)]) && $this->subscribers[get_class($subscriber)] === $subscriber) {
            return;
        }

        $this->subscribers[get_class($subscriber)] = $subscriber;
    }

    /**
     * Detach a subscriber
     *
     * @param IContainerSubscriber $subscriber
     * @return mixed|void
     */
    public function unSubscribe(IContainerSubscriber $subscriber) {
        if (isset($this->subscribers[get_class($subscriber)])) {
            unset($this->subscribers[get_class($subscriber)]);
        }
    }
}