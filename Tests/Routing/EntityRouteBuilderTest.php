<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Domain\EntityInterface;
use RomaricDrigon\OrchestraBundle\Pool\EntityReflection;
use RomaricDrigon\OrchestraBundle\Routing\EntityRouteBuilder;
use Symfony\Component\Routing\Route;

/**
 * Class EntityRouteBuilderTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRouteBuilder
     */
    private $sut;
    
    public function setUp()
    {
        $this->sut = new EntityRouteBuilder();
    }

    public function test_it_builds_routes()
    {
        $entity = new MockEntity();
        $entRef = new EntityReflection(new \ReflectionClass($entity));

        $this->assertNotEmpty($routes = $this->sut->buildRoutes($entRef, 'mockentity'));

        /** @var Route $route1 */
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route1 = $routes['orchestra_entity_mockentity_foo']);

        $this->assertEquals('/mockentity/foo', $route1->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:entityMethod', $route1->getDefault('_controller'));
        $this->assertEquals('foo', $route1->getDefault('entity_method'));
        $this->assertEquals('foo', $route1->getDefault('method_slug'));
        $this->assertEquals('mockentity', $route1->getDefault('entity_slug'));

        /** @var Route $route2 */
        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route2 = $routes['orchestra_entity_mockentity_foobar']);

        $this->assertEquals('/mockentity/foobar', $route2->getPath());
        $this->assertEquals('fooBar', $route2->getDefault('entity_method'));
        $this->assertEquals('foobar', $route2->getDefault('method_slug'));
        $this->assertEquals('mockentity', $route2->getDefault('entity_slug'));
    }
}

class MockEntity implements EntityInterface {
    public function foo() {}

    public function fooBar() {}
}