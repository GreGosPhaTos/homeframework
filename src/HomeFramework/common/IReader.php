<?php
namespace HomeFramework\common;


interface IReader {
    /**
     * @param array $replacement
     * @param $subject
     * @return mixed
     */
    public function read(array $replacement, $subject);
}