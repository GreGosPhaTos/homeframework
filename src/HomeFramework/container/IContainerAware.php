<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 19/05/13
 * Time: 13:12
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;


interface IContainerAware {

    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function setContainer(ContainerInterface $container = null);

}