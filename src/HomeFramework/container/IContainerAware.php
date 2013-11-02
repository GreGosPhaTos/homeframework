<?php
namespace HomeFramework\container;

/**
 * Interface Container 
 * @package HomeFramework\container
 */
Interface IContainerAware {

    /**
     * Sets a container
     *
     * @param IContaier $container
     */
    public function setContainer(IContainer $container);
}
