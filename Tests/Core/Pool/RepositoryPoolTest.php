<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool;

use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPool;

/**
 * Class RepositoryPoolTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryPool
     */
    private $sut;

    public function setUp()
    {
        $this->sut = new RepositoryPool();
    }

    public function test_it_adds_and_gets_repositories()
    {
        $definition1 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition');
        \Phake::when($definition1)->getSlug()->thenReturn('mock1');

        $definition2 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition');
        \Phake::when($definition2)->getSlug()->thenReturn('mock2');

        $this->sut->addRepositoryDefinition($definition1);
        $this->sut->addRepositoryDefinition($definition2);

        $this->assertCount(2, $this->sut->all());

        $this->assertEquals($definition1, $this->sut->getBySlug('mock1'));
        $this->assertEquals($definition2, $this->sut->getBySlug('mock2'));
    }

    public function test_it_throws_exception_when_adding_twice_repository()
    {
        $definition1 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition');
        \Phake::when($definition1)->getSlug()->thenReturn('mock1');

        $this->sut->addRepositoryDefinition($definition1);

        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->addRepositoryDefinition($definition1);
    }

    public function test_it_throws_exception_when_repository_not_found()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->getBySlug('foo');
    }
}


