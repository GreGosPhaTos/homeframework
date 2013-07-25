<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 23/07/13
 * Time: 21:19
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;


interface IContainerSubscriber {

    /**
     * Initialize the service
     *
     * @param IContainer $container
     * @return bool
     */
    public function pushService (IContainer $container);
}