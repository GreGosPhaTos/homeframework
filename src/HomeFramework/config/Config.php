<?php
namespace HomeFramework\config;

use HomeFramework\common\IAccess;

class Config implements IAccess {
    /**
     * @var array
     */
    private $config = array();

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value) {
        if (isset($this->config[$name]) && is_array($this->config[$name]) && is_array($value)) {
            $this->config[$name] = array_merge($value, $this->config[$name]);
        } else {
            $this->config[$name] = $value;
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name) {
        return $this->config[$name];
    }
}