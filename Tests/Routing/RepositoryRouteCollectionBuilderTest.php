<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Pool\RepositoryPool;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteCollectionBuilder;
use RomaricDrigon\OrchestraBundle\Tests\Pool\MockRepository1;
use RomaricDrigon\OrchestraBundle\Tests\Pool\MockRepository2;
use Symfony\Component\Routing\Route;

/**
 * Class RepositoryRouteCollectionBuilderTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteCollectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryRouteCollectionBuilder
     */
    private $sut;
    
    public function setUp()
    {
        $builder = \Phake::mock('RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder');

        \Phake::when($builder)->buildRouteName('mock1')->thenReturn('name_mock1');
        \Phake::when($builder)->buildRouteName('mock2')->thenReturn('name_mock2');

        \Phake::when($builder)->buildRoute($this->anything(), $this->anything())->thenReturn(new Route('path1'));

        $this->sut = new RepositoryRouteCollectionBuilder($builder);
    }

    public function test_it_builds_empty_collection()
    {
        $pool = \Phake::mock('RomaricDrigon\OrchestraBundle\Pool\RepositoryPool');

        \Phake::when($pool)->all()->thenReturn([]);

        $this->assertNotNull($collection = $this->sut->getCollection($pool));

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $this->assertEquals(0, count($collection));
    }

    public function test_it_builds_collection()
    {
        $pool = \Phake::mock('RomaricDrigon\OrchestraBundle\Pool\RepositoryPool');

        \Phake::when($pool)->all()->thenReturn([
            'mock1' => new MockRepository1(),
            'mock2' => new MockRepository2()
        ]);

        $this->assertNotNull($collection = $this->sut->getCollection($pool));

        $this->assertInstanceOf('Symfony\Component\Routing\RouteCollection', $collection);

        $this->assertEquals(2, count($collection));

        $this->assertNotNull($collection->get('name_mock1'));
        $this->assertNotNull($collection->get('name_mock2'));

        $this->assertNull($collection->get('foo'));
    }
}
 