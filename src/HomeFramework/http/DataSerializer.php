<?php
namespace HomeFramework\http;


class DataSerializer implements \Serializable {

    /**
     * @return string|void
     */
    public function serialize() {}

    /**
     *
     * @param string $serialized
     * @return array|void
     */
    public function unserialize($serialized) {
        return explode('&', $serialized);
    }
}