<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Pool\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Routing\EntityRouteCollectionBuilder;
use Symfony\Component\Routing\Route;

/**
 * Class EntityRouteCollectionBuilderTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteCollectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRouteCollectionBuilder
     */
    private $sut;

    public function setUp()
    {
        $builder = \Phake::mock('RomaricDrigon\OrchestraBundle\Routing\EntityRouteBuilder');

        \Phake::when($builder)->buildRoutes($this->anything(), 'mock1')->thenReturn(['foo' => new Route('/')]);
        \Phake::when($builder)->buildRoutes($this->anything(), 'mock2')->thenReturn(['bar' => new Route('/')]);

        $this->sut = new EntityRouteCollectionBuilder($builder);
    }

    public function test_it_builds_empty_collection()
    {
        $pool = \Phake::mock('RomaricDrigon\OrchestraBundle\Pool\EntityPool');

        \Phake::when($pool)->all()->thenReturn([]);

        $this->assertNotNull($collection = $this->sut->getCollection($pool));

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $this->assertEquals(0, count($collection));
    }

    public function test_it_builds_collection()
    {
        $pool = \Phake::mock('RomaricDrigon\OrchestraBundle\Pool\EntityPool');

        \Phake::when($pool)->all()->thenReturn([
            'mock1' => new MockEntityReflection(),
            'mock2' => new MockEntityReflection()
        ]);

        $this->assertNotNull($collection = $this->sut->getCollection($pool));

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $this->assertEquals(2, count($collection));

        $this->assertNotNull($collection->get('foo'));
        $this->assertNotNull($collection->get('bar'));

        $this->assertNull($collection->get('fooBar'));
    }
}

class MockEntityReflection implements EntityReflectionInterface {
    public function getSlug() {}

    public function getMethods() {}

    public function getName() {}

    public function getNamespacedName() {}
}
 