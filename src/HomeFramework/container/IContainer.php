<?php
namespace HomeFramework\container;

interface IContainer {

    /**
     * @param $service
     *
     * @return mixed
     */
    public function get($service);

    /**
     * @param $service
     * @param $object
     *
     * @return mixed
     */
    public function set($service, &$object);

}