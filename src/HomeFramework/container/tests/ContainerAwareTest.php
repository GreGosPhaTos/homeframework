<?php
namespace HomeFramework\container\tests;

use HomeFramework\container\ContainerAware;

class ContainerAwareTest extends \PHPUnit_Framework_TestCase {
    
    /**
     *
     */
    public function testSetContainer() {
        $mockContainer = $this->getMock('\\HomeFramework\\container\\Container');
        $stub = $this->getMockForAbstractClass('\\HomeFramework\\container\\ContainerAware');
        $stub->expects($this->any())
            ->method('setContainer')
            ->with($mockContainer)
            ->will($this->returnValue(TRUE));

        $this->assertEquals($stub->setContainer($mockContainer), null);
    }
}
