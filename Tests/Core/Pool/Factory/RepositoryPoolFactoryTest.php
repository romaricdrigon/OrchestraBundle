<?php

/*
 *
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool\Factory;

use RomaricDrigon\OrchestraBundle\Core\Pool\Factory\RepositoryPoolFactory;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Class RepositoryPoolFactoryTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryPoolFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryPoolFactory
     */
    private $sut;
    
    public function setUp()
    {
        $this->sut = new RepositoryPoolFactory();
    }

    public function test_it_builds_empty_pool()
    {
        $pool = $this->sut->createPool();

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface', $pool);

        $this->assertEmpty($pool->all());
    }

    public function test_it_create_pool_with_repositories()
    {
        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\Factory\MockRepository1', 'orchestra.service.mock1', 'Some\\Class\\Mock1');

        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\Factory\MockRepository2', 'orchestra.service.mock2', 'Some\\Class\\Mock2');

        $pool = $this->sut->createPool();

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface', $pool);

        $this->assertCount(2, $pool->all());
    }
}

final class MockRepository1 implements RepositoryInterface {
    public function listing() {}

    public function find($id) {}
}

final class MockRepository2 implements RepositoryInterface {
    public function listing() {}

    public function find($id) {}
}
