<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionBuilder;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryAction;

/**
 * Class RepositoryActionCollectionBuilderTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryActionCollectionBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryActionCollectionBuilder
     */
    private $sut;
    
    public function setUp()
    {
        $nameResolver = \Phake::mock('RomaricDrigon\OrchestraBundle\Resolver\Repository\RepositoryNameResolver');

        \Phake::when($nameResolver)->getName($this->anything())->thenReturn('mock');

        //$this->sut = new RepositoryActionCollectionBuilder($nameResolver);
    }

    public function test_it_builds_collection()
    {
        $repo = new MockRepository();

        /*$this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionInterface', $collection = $this->sut->build($repo));

        $this->assertEquals(2, count($collection));
        $this->assertEquals('mock', $collection->getName());

        $array = iterator_to_array($collection);*/

        /** @var RepositoryAction $listing */
        /*$listing = $array[0];

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionInterface', $listing);
        $this->assertEquals('listing', $listing->getMethod());
        $this->assertEquals('Listing', $listing->getName());
        $this->assertTrue($listing->isListing());*/

        /** @var RepositoryAction $camelCase */
        /*$camelCase = $array[1];

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionInterface', $camelCase);
        $this->assertEquals('someCamelCaseName', $camelCase->getMethod());
        $this->assertEquals('Some Camel Case Name', $camelCase->getName());
        $this->assertFalse($camelCase->isListing());*/
    }
}

class MockRepository implements RepositoryInterface {
    public function listing() {}

    public function someCamelCaseName() {}

    protected function trap() {}

    public function find($id) {}
}
