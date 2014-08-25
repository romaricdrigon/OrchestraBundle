<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Pool;

use RomaricDrigon\OrchestraBundle\Domain\EntityInterface;
use RomaricDrigon\OrchestraBundle\Pool\EntityPool;

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
        $entity1 = new MockEntity1();
        $this->sut->addEntity($entity1);
        // slug should be "mock1"

        $entity2 = new MockEntity2();
        $this->sut->addEntity($entity2);
        // slug should be "mock2"

        $this->assertEquals($entity1, $this->sut->getBySlug('mockentity1'));

        $this->assertEquals($entity2, $this->sut->getBySlug('mockentity2'));
    }

    public function test_it_throws_exception_when_adding_twice_entity()
    {
        $entity1 = new MockEntity1();

        $this->sut->addEntity($entity1);

        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\EntityAddedTwiceException');

        $this->sut->addEntity($entity1);
    }

    public function test_it_throws_exception_when_entity_not_found()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\EntityNotFoundException');

        $this->sut->getBySlug('foo');
    }
}

class MockEntity1 implements EntityInterface {}

class MockEntity2 implements EntityInterface {}
 