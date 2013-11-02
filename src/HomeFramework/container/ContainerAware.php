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
     * @param IContainer $container A Container instance
     *
     * @return mixed|void
     */
    public function setContainer(IContainer $container = null)
    {
        $this->container = $container;
    }
}
