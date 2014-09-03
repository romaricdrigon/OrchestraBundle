<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Routing;

use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryAction;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
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
            ->addAction($this->action1 = new RepositoryAction('m1', 'n1'))
            ->addAction($this->action2 = new RepositoryAction('m2', 'n2'))
            ->addAction($this->action3 = new RepositoryAction('listing', 'listing'))
        ;

        \Phake::when($builder)->build($this->anything())->thenReturn($collection);

        $this->sut = new RepositoryRouteBuilder($builder);
    }

    public function test_it_builds_route()
    {
        $repository = new MockRepository();

        $this->assertNotNull($routes = $this->sut->buildRoutes($repository, 'mock'));

        $this->assertInternalType('array', $routes);

        $this->assertCount(3, $routes);

        $this->assertArrayHasKey('orchestra_repository_mock_m1', $routes);

        /** @var Route $r1 */
        $r1 = $routes['orchestra_repository_mock_m1'];

        $this->assertEquals('/mock/m1', $r1->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:repositoryMethod', $r1->getDefault('_controller'));
        $this->assertEquals('mock', $r1->getDefault('repository_slug'));
        $this->assertEquals('m1', $r1->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $r1->getDefault('orchestra_type'));
        $this->assertEquals('GET', $r1->getRequirement('_method'));

        $this->assertArrayHasKey('orchestra_repository_mock_m2', $routes);

        /** @var Route $r2 */
        $r2 = $routes['orchestra_repository_mock_m2'];

        $this->assertEquals('/mock/m2', $r2->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:repositoryMethod', $r2->getDefault('_controller'));
        $this->assertEquals('mock', $r2->getDefault('repository_slug'));
        $this->assertEquals('m2', $r2->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $r2->getDefault('orchestra_type'));

        $this->assertArrayHasKey('orchestra_repository_mock_listing', $routes);

        /** @var Route $listing */
        $listing = $routes['orchestra_repository_mock_listing'];

        $this->assertEquals('/mock/listing', $listing->getPath());
        $this->assertEquals('RomaricDrigonOrchestraBundle:Generic:list', $listing->getDefault('_controller'));
        $this->assertEquals('mock', $listing->getDefault('repository_slug'));
        $this->assertEquals('listing', $listing->getDefault('repository_method'));
        $this->assertEquals(RepositoryRouteBuilder::ROUTE_TYPE, $listing->getDefault('orchestra_type'));
    }
}

class MockRepository implements RepositoryInterface {
    public function listing() {}
}
