<?php
namespace HomeFramework\common;

interface Ibuilder {

    /**
     * Sets the application container
     *
     * @param \HomeFramework\container\Container  $container
     *
     * @return mixed
     */
    public function setContainer(\HomeFramework\container\IContainer $container);

    /**
     * Build the object
     *
     * @return void
     */
    public function build();
}