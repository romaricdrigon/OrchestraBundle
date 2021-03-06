<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\Repository;

use Doctrine\Common\Annotations\Reader;

/**
 * Class RepositoryNameResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameResolver
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
    public function getName(\ReflectionClass $reflectionClass)
    {
        $annotation = $this->annotationReader->getClassAnnotation($reflectionClass, $this->annotationClass);

        if (null !== $annotation) {
            $name = $annotation->getName();

            if ($name) {
                return $name;
            }
        }

        return str_replace('Repository', '', $reflectionClass->getShortName());
    }
}
