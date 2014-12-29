<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Pool;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
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
        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository1', 'orchestra.service.mock1');

        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository2', 'orchestra.service.mock2');

        $this->assertNotNull($repo1 = $this->sut->getBySlug('mock1'));
        $this->assertEquals('orchestra.service.mock1', $repo1->getServiceId());

        $this->assertNotNull($repo2 = $this->sut->getBySlug('mock2'));
        $this->assertEquals('orchestra.service.mock2', $repo2->getServiceId());
    }

    public function test_it_throws_exception_when_adding_twice_repository()
    {
        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository1', 'orchestra.service.mock1');

        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->addRepository('RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository1', 'orchestra.service.mock1');
    }

    public function test_it_throws_exception_when_repository_not_found()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\DomainErrorException');

        $this->sut->getBySlug('foo');
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
