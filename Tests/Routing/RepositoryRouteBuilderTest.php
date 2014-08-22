<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder;

/**
 * Class RepositoryRouteBuilderTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryRouteBuilder
     */
    private $sut;

    public function setUp()
    {
        $pool = \Phake::mock('RomaricDrigon\OrchestraBundle\Pool\RepositoryPool');

        \Phake::when($pool)->all()->thenReturn([
            'mock1' => 'anything',
            'mock2' => 'not used'
        ]);

        $this->sut = new RepositoryRouteBuilder($pool);
    }

    public function test_it_builds_route_collection()
    {
        $this->assertNotNull($routes = $this->sut->getCollection());

        $this->assertEquals(2, count($routes));

        $this->assertNotNull($route1 = $routes->get('orchestra_repository_mock1_list'));

        $this->assertEquals('/mock1/list', $route1->getPath());
        $this->assertEquals('all', $route1->getDefault('repository_method'));
        $this->assertEquals('mock1', $route1->getDefault('repository_slug'));

        $this->assertNotNull($route2 = $routes->get('orchestra_repository_mock2_list'));

        $this->assertEquals('/mock2/list', $route2->getPath());
        $this->assertEquals('mock2', $route2->getDefault('repository_slug'));

        $this->assertNull($routes->get('orchestra_repository_mock3_list'));
    }
}
 