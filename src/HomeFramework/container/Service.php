<?php

namespace HomeFramework\container;


class Service {

    /**
     * Service Name
     *
     * @var string $name
     */
    private $name;

    /**
     * Service Instance
     *
     * @var object $instance
     */
    private $instance;

    /**
     * Set the service name
     *
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set the service instance
     *
     * @param object $instance
     */
    public function setInstance($instance) {
        $this->instance = $instance;
    }

    /**
     * Returns the instance of the service
     *
     * @return object
     */
    public function getInstance() {
        return $this->instance;
    }

    /**
     * Returns the name of the service
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}