<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Class RepositoryNameResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameResolver implements RepositoryNameResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\Name';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function getName(RepositoryDefinitionInterface $repositoryDefinition)
    {
        $annotation = $this->annotationReader->getClassAnnotation($repositoryDefinition->getReflection(), $this->annotationClass);

        if (null !== $annotation) {
            $name = $annotation->getName();

            if ($name) {
                return $name;
            }
        }

        return $repositoryDefinition->getName();
    }
}
