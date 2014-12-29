<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Resolver;

use RomaricDrigon\OrchestraBundle\Resolver\RepositoryNameResolver;
use RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository1;
use RomaricDrigon\OrchestraBundle\Tests\Core\Pool\MockRepository2;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Class RepositoryNameGetterTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameGetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryNameResolver
     */
    private $sut;

    /**
     * @var \ReflectionObject
     */
    private $reflectionofRepository;

    /**
     * @var RepositoryInterface
     */
    private $repoWithAnnotation;
    
    public function setUp()
    {
        $reader = \Phake::mock('Doctrine\Common\Annotations\Reader');

        $this->repoWithAnnotation = new MockRepository1();
        $this->reflectionofRepository = new \ReflectionObject($this->repoWithAnnotation);

        \Phake::when($reader)->getClassAnnotation($this->reflectionofRepository, 'RomaricDrigon\\OrchestraBundle\\Annotation\\Name');

        $this->sut = new RepositoryNameResolver($reader);
    }

    public function test_it_gets_name_from_annotation()
    {
        $this->assertEquals('Mock1', $this->sut->getName($this->repoWithAnnotation));
    }

    public function test_it_generate_default_name()
    {
        $this->assertEquals('Mock2', $this->sut->getName(new MockRepository2()));
    }
}
