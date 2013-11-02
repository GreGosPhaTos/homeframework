<?php 
namespace HomeFramework\container;

abstract class ContainerAware implements IContainerAware {
    
    /**
     * @var Container
     *
     * @api
     */
    protected $container;

    /**
     * Sets the Container associated with this Controller.
     *
     * @param Container $container A Container instance
     *
     * @return mixed|void
     */
    public function setContainer(Container $container = null)
    {
        $this->container = $container;
    }
}
