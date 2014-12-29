<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Resolver;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryNameResolver;

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
     * @var
     */
    private $repoWithAnnotation;

    
    public function setUp()
    {
        $reader = \Phake::mock('Doctrine\Common\Annotations\Reader');

        $reflection = \Phake::mock('\ReflectionClass');

        $this->repoWithAnnotation = new RepositoryDefinition($reflection, 'orchestra.id', 'Some\\Class');

        $annotation = \Phake::mock('RomaricDrigon\OrchestraBundle\Annotation\Name');

        \Phake::when($annotation)->getName()->thenReturn('Mock1');

        \Phake::when($reader)->getClassAnnotation($reflection, 'RomaricDrigon\\OrchestraBundle\\Annotation\\Name')->thenReturn($annotation);

        $this->sut = new RepositoryNameResolver($reader);
    }

    public function test_it_gets_name_from_annotation()
    {
        $this->assertEquals('Mock1', $this->sut->getName($this->repoWithAnnotation));
    }
}
