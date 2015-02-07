<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Resolver;

use RomaricDrigon\OrchestraBundle\Resolver\Repository\RepositoryNameResolver;

/**
 * Class RepositoryNameResolverTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryNameResolver
     */
    private $sut;

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    /**
     * @var \ReflectionClass
     */
    private $reflection2;
    
    public function setUp()
    {
        $reader = \Phake::mock('Doctrine\Common\Annotations\Reader');

        $this->reflection = new \ReflectionClass('\ReflectionClass');

        $this->reflection2 = new \ReflectionClass('RomaricDrigon\OrchestraBundle\Domain\Doctrine\BaseRepository');

        $annotation = \Phake::mock('RomaricDrigon\OrchestraBundle\Annotation\Name');

        \Phake::when($annotation)->getName()->thenReturn('Mock1');

        \Phake::when($reader)->getClassAnnotation($this->reflection, 'RomaricDrigon\\OrchestraBundle\\Annotation\\Name')->thenReturn($annotation);

        $this->sut = new RepositoryNameResolver($reader);
    }

    public function test_it_gets_name_from_annotation()
    {
        $this->assertEquals('Mock1', $this->sut->getName($this->reflection));
    }

    public function test_it_generates_default_name()
    {
        $this->assertEquals('Base', $this->sut->getName($this->reflection2));
    }
}
