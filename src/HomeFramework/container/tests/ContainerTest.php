<?php
namespace HomeFramework\container\tests;

use HomeFramework\container\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers \HomeFramework\container\Container::get()
     */
    public function testContainer() {
        $container = new Container();
        $containerReflexionCacheProperty = new \ReflectionProperty(get_class($container), 'cache');
        $containerReflexionCacheProperty->setAccessible(true);
        $container->set('foo', $callback = function() {
            $instance = new \stdClass();
            $instance->bar = 'foobar';

            return $instance;
        });

        $this->assertEquals($container->get('foo')->bar, "foobar");
        $cache = $containerReflexionCacheProperty->getValue($container);
        $this->assertEquals($cache, array('foo' => $callback()));
    }


    /**
     * @covers \HomeFramework\container\Container::get()
     * 
     * @expectedException \HomeFramework\container\exception\ContainerInvalidArgumentException
     */
    public function testGetInvalidServiceName() {
        $container = new Container();
        $container->set('foo', $callback = function() {
            $instance = new \stdClass();
            $instance->bar = 'foobar';

            return $instance;
        });

        $container->get('bar');
    }


    /**
     * @covers \HomeFramework\container\Container
     */
    public function testContainerForceInstance() {
        $container = new Container();
        $containerReflexionCacheProperty = new \ReflectionProperty(get_class($container), 'cache');
        $containerReflexionCacheProperty->setAccessible(true);
        $container->set('foo', $callback = function() {
            $instance = new \stdClass();
            $instance->bar = 'foobar';

            return $instance;
        });

        $this->assertEquals($container->get('foo')->bar, "foobar");

        $container->set('foo', $callback = function() {
            $instance = new \stdClass();
            $instance->foo = 'foobar';

            return $instance;
        });

        $this->assertEquals($container->get('foo')->bar, "foobar");
        $containerReflexionCacheProperty->getValue($container);

        $this->assertEquals($container->get('foo', true)->foo, "foobar");
        $cache = $containerReflexionCacheProperty->getValue($container);
        $this->assertEquals($cache, array('foo' => $callback()));

    }

    /**
     * @covers \HomeFramework\container\Container::clearCache()
     */
    public function testClearCache() {
        $container = new Container();
        $containerReflexionCacheProperty = new \ReflectionProperty(get_class($container), 'cache');
        $containerReflexionCacheProperty->setAccessible(true);
        $container->set('foo', $callback = function() {
            $instance = new \stdClass();
            $instance->foo = 'foobar';

            return $instance;
        });

        $container->get('foo');
        $cache = $containerReflexionCacheProperty->getValue($container);
        $this->assertEquals($cache, array('foo' => $callback()));
        $container->clearCache();
        $cache = $containerReflexionCacheProperty->getValue($container);
        $this->assertEquals($cache, array());
    }

    /**
     * @covers \HomeFramework\container\Container::set()
     *
     * @expectedException \HomeFramework\container\exception\ContainerInvalidArgumentException
     */
    public function testSetInvalidServiceName() {
        $container = new Container();
        $container->set(123, 'bar');
    }

    /**
     * @covers \HomeFramework\container\Container::set()
     *
     * @expectedException \HomeFramework\container\exception\ContainerInvalidArgumentException
     */
    public function testSetInvalidCallback() {
        $container = new Container();
        $container->set('foo', 'bar');
    }

    /**
     * @covers \HomeFramework\container\Container::hasService()
     */
    public function testHasService() {
        $container = new Container();
        $this->assertFalse($container->hasService('foobar'));
    }
}
