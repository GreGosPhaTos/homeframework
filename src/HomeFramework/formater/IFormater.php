<?php
namespace HomeFramework\formater;


interface IFormater {
    /**
     * @param array|string $data
     */
    public function __construct($data);

    /**
     * returns an array of data
     *
     * @return array
     */
    public function toArray();

    /**
     * Format data
     *
     * @return string
     */
    public function format();
}