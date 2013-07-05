<?php
/**
 * From SYMFONY 2
 * User: Adrien
 * Date: 19/05/13
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;


use HomeFramework\common\IAccess;
/**
 * A simple implementation of ContainerAwareInterface.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @api
 */
class ContainerAware implements IContainerAware
{
    /**
     * @var ContainerInterface
     *
     * @api
     */
    protected $container;

    /**
     * Sets the Container associated with this Controller.
     *
     * @param IAccess $container A ContainerInterface instance
     *
     * @return mixed|void
     * @api
     */
    public function setContainer(IAccess $container = null)
    {
        $this->container = $container;
    }
}