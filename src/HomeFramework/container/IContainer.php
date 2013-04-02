<?php
namespace \HomeFramework\container;

interface IContainer {

    public function get($service);

    public function set($service, $callback);

}