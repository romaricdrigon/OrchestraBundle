<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder;
use RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository1;

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
        $this->sut = new RepositoryRouteBuilder();
    }

    public function test_it_builds_name()
    {
        $slug = 'foo';

        $this->assertEquals('orchestra_repository_foo_list', $this->sut->buildRouteName($slug));
    }


    public function test_it_builds_route()
    {
        $slug = 'foo';
        $repository = new MockRepository1();

        $this->assertNotNull($route = $this->sut->buildRoute($repository, $slug));

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);

        $this->assertEquals('/foo/list', $route->getPath());

        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:list', $route->getDefault('_controller'));
        $this->assertEquals('listing', $route->getDefault('repository_method'));
        $this->assertEquals('foo', $route->getDefault('repository_slug'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $route->getDefault('orchestra_type'));

        $this->assertEquals('GET', $route->getRequirement('_method'));
    }
}
 