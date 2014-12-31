<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool;

use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPool;

/**
 * Class EntityPoolTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityPool
     */
    private $sut;
    
    public function setUp()
    {
        $this->sut = new EntityPool();
    }

    public function test_it_adds_and_gets_entities()
    {
        $reflection1 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface');
        \Phake::when($reflection1)->getSlug()->thenReturn('mockentity1');

        $reflection2 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface');
        \Phake::when($reflection2)->getSlug()->thenReturn('mockentity2');

        $this->sut->addEntityReflection($reflection1);
        $this->sut->addEntityReflection($reflection2);

        $this->assertCount(2, $this->sut->all());

        $this->assertEquals($reflection1, $this->sut->getBySlug('mockentity1'));
        $this->assertEquals($reflection2, $this->sut->getBySlug('mockentity2'));
    }

    public function test_it_throws_exception_when_adding_twice_entity()
    {
        $reflection1 = \Phake::mock('RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface');
        \Phake::when($reflection1)->getSlug()->thenReturn('mockentity1');

        $this->sut->addEntityReflection($reflection1);

        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->addEntityReflection($reflection1);
    }

    public function test_it_throws_exception_when_entity_not_found()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->getBySlug('foo');
    }
}
