<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 20/04/13
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\common;


interface IAccess {
    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function set($name, $value);

}
