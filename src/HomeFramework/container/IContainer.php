<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Adrien
 * Date: 19/05/13
 * Time: 13:21
 * To change this template use File | Settings | File Templates.
 */

namespace HomeFramework\container;


interface IContainer {

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * @param $value
     *
     * @internal param $name
     * @return void
     */
    public function set($value);
}