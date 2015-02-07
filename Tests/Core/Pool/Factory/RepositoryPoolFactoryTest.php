<?php

/*
 *
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool\Factory;

use RomaricDrigon\OrchestraBundle\Core\Pool\Factory\RepositoryPoolFactory;
use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition;

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
        $factory = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionFactory');

        $reflection = new \ReflectionClass('RomaricDrigon\OrchestraBundle\Domain\Doctrine\BaseRepository');

        \Phake::when($factory)->build($this->anything(), $this->anything(), $this->anything())->thenReturn(new RepositoryDefinition($reflection, '', '', ''));

        $this->sut = new RepositoryPoolFactory($factory);
    }

    public function test_it_builds_empty_pool()
    {
        $pool = $this->sut->createPool();

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface', $pool);

        $this->assertEmpty($pool->all());
    }

    public function test_it_create_pool_with_repositories()
    {
        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Domain\Doctrine\BaseRepository', 'orchestra.service.mock1', 'Some\\Class\\Mock1');

        $pool = $this->sut->createPool();

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface', $pool);

        $this->assertCount(1, $pool->all());
    }
}
