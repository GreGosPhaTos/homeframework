<?php
namespace HomeFramework\container;

use HomeFramework\common\IAccess;

interface IContainerAware {

    /**
     * @param \HomeFramework\common\IAccess $container
     * @return mixed
     */
    public function setContainer(IAccess $container = null);

}