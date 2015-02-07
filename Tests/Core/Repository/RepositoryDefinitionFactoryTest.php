<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Core\Repository;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionFactory;

/**
 * Class RepositoryDefinitionFactoryTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryDefinitionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryDefinitionFactory
     */
    private $sut;
    
    public function setUp()
    {
        $resolver = \Phake::mock('RomaricDrigon\OrchestraBundle\Resolver\Repository\RepositoryNameResolver');

        $this->sut = new RepositoryDefinitionFactory($resolver);
    }

    public function test_it_builds_repository_definiton()
    {
        $reflectionClass = \Phake::mock('\ReflectionClass');

        $repositoryDefinition = $this->sut->build($reflectionClass, 'service.id', 'Some\\Entity');

        $this->assertInstanceOf('RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinition', $repositoryDefinition);
        $this->assertEquals('Some\\Entity', $repositoryDefinition->getEntityClass());
    }
}
