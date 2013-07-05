<?php
namespace HomeFramework\common;

interface IBuilder {

    /**
     * Sets the application container
     *
     * @param \HomeFramework\common\IAccess  $container
     *
     * @return mixed
     */
    public function setContainer(\HomeFramework\common\IAccess $container);

    /**
     * Build the object
     *
     * @return void
     */
    public function build();
}