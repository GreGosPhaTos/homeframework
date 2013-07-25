<?php
namespace HomeFramework\container;

use HomeFramework\common\IAccess;

interface IContainerAware {

    /**
     * @param \HomeFramework\container\IContainer $container
     * @return mixed
     */
    public function setContainer(IContainer $container = null);

}