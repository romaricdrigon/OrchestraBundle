<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool;

use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;
use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPool;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflection;

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
        $entity = new MockEntity1();
        $ref    = new \ReflectionClass($entity);
        $er1    = new EntityReflection($ref);
        $this->sut->addEntityReflection($er1);
        // slug should be "mock1"

        $entity = new MockEntity2();
        $ref    = new \ReflectionClass($entity);
        $er2    = new EntityReflection($ref);
        $this->sut->addEntityReflection($er2);
        // slug should be "mock2"

        $this->assertEquals($er1, $this->sut->getBySlug('mockentity1'));

        $this->assertEquals($er2, $this->sut->getBySlug('mockentity2'));
    }

    public function test_it_throws_exception_when_adding_twice_entity()
    {
        $entity = new MockEntity1();
        $ref    = new \ReflectionClass($entity);
        $er1    = new EntityReflection($ref);

        $this->sut->addEntityReflection($er1);

        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->addEntityReflection($er1);
    }

    public function test_it_throws_exception_when_entity_not_found()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->getBySlug('foo');
    }
}

class MockEntity1 implements EntityInterface {
    public function getId() {}
}

class MockEntity2 implements EntityInterface {
    public function getId() {}
}
