<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Resolver\ListingHeader;

use RomaricDrigon\OrchestraBundle\Domain\Query\QueryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\ListingHeader\ListingHeaderResolver;
use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;

/**
 * Class ListingHeaderResolverTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class ListingHeaderResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ListingHeaderResolver
     */
    private $sut;
    
    public function setUp()
    {
        $this->sut = new ListingHeaderResolver();
    }

    public function test_it_gets_array_headers()
    {
        $entity = new MockEntity();

        $this->assertEquals(['h1', 'h2'], $this->sut->getHeaders($entity, 'viewHeader'));
    }

    public function test_it_gets_query_headers()
    {
        $entity = new MockEntity();

        $this->assertEquals(['h1', 'h2'], $this->sut->getHeaders($entity, 'viewQuery'));
    }
}

class MockEntity implements EntityInterface {
    public function viewHeader() {
        return ['h1' => 'v1', 'h2' => 'v2'];
    }

    public function viewQuery()
    {
        return new MockQuery();
    }

    public function getId() {}
}

class MockQuery implements \IteratorAggregate, QueryInterface {
    public $h1;
    public $h2;
    private $h3;

    public function getIterator() {
        return new \ArrayIterator($this);
    }
}