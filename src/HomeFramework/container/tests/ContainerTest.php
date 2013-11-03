<?php
namespace HomeFramework\container\tests;

use HomeFramework\container\Container;

class ContainerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Container
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
     * @covers Container
     * @covers
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
     * @covers Container::clearCache
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
     *  @covers Container::set()
     *
     * @expectedException \HomeFramework\container\exception\ContainerInvalidArgumentException
     */
    public function testSetInvalidServiceName() {
        $container = new Container();
        $container->set(123, 'bar');
    }

    /**
     * @covers Container::set()
     *
     * @expectedException \HomeFramework\container\exception\ContainerInvalidArgumentException
     */
    public function testSetInvalidCallback() {
        $container = new Container();
        $container->set('foo', 'bar');
    }
}