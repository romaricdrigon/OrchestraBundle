<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryAction;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollection;
use Symfony\Component\Routing\Route;

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

    /**
     * @var RepositoryAction
     */
    private $action1;

    /**
     * @var RepositoryAction
     */
    private $action2;

    /**
     * @var RepositoryAction
     */
    private $action3;


    public function setUp()
    {
        $builder = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionBuilder');

        $collection = (new RepositoryActionCollection('mock'))
            ->addAction($this->action1 = new RepositoryAction('m1', 'n1', 'r1', 's1'))
            ->addAction($this->action2 = new RepositoryAction('m2', 'n2', 'r2', 's2', 'Some\Class\Command'))
            ->addAction($this->action3 = new RepositoryAction('listing', 'listing', 'listing', 'listing'))
        ;

        \Phake::when($builder)->build($this->anything())->thenReturn($collection);

        $this->sut = new RepositoryRouteBuilder($builder);
    }

    public function test_it_builds_route()
    {
        $repositoryDefinition = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface');

        $this->assertNotNull($routes = $this->sut->buildRoutes($repositoryDefinition, 'mock'));

        $this->assertInternalType('array', $routes);

        $this->assertCount(3, $routes);

        $this->assertArrayHasKey('r1', $routes);

        /** @var Route $r1 */
        $r1 = $routes['r1'];

        $this->assertEquals('/mock/s1', $r1->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:repositoryQuery', $r1->getDefault('_controller'));
        $this->assertEquals('mock', $r1->getDefault('repository_slug'));
        $this->assertEquals('m1', $r1->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $r1->getDefault('orchestra_type'));
        $this->assertEquals('GET', $r1->getRequirement('_method'));
        $this->assertNull($r1->getDefault('command_class'));

        $this->assertArrayHasKey('r2', $routes);

        /** @var Route $r2 */
        $r2 = $routes['r2'];

        $this->assertEquals('/mock/s2', $r2->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:repositoryCommand', $r2->getDefault('_controller'));
        $this->assertEquals('mock', $r2->getDefault('repository_slug'));
        $this->assertEquals('m2', $r2->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $r2->getDefault('orchestra_type'));
        $this->assertEquals('Some\Class\Command', $r2->getDefault('command_class'));

        $this->assertArrayHasKey('listing', $routes);

        /** @var Route $listing */
        $listing = $routes['listing'];

        $this->assertEquals('/mock/listing', $listing->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:list', $listing->getDefault('_controller'));
        $this->assertEquals('mock', $listing->getDefault('repository_slug'));
        $this->assertEquals('listing', $listing->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $listing->getDefault('orchestra_type'));
        $this->assertNull($listing->getDefault('command_class'));
    }
}