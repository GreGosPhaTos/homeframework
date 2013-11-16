<?php
namespace HomeFramework\container;

/**
 * Interface Container 
 * @package HomeFramework\container
 */
interface IContainerAware {

    /**
     * Sets a container
     *
     * @param IContaier $container
     */
    public function setContainer(IContainer $container);
}
