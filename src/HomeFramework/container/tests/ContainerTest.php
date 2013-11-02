<?php
namespace HomeFramework\container\tests;

use HomeFramework\container\Container,
    HomeFramework\container\exception\ContainerInvalidArgumentException;

class ContainerTest extends \PHPUnit_Framework_TestCase {

    /**
     *
     * @expectedException ContainerInvalidArgumentException
     */
    public function testSetInvalidServiceName() {
        $this->assertTrue("Coco");
        $container = new Container();
        $container->set(true, 'falseParameter');
    }
}