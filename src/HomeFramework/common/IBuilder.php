<?php
namespace HomeFramework\common;

interface Ibuilder {

    /**
     * Setting the container
     *
     * @return void
     */

    abstract public function setContainer($container);

    /**
     * Build the object
     *
     * @return void
     */
    abstract public function build();
}