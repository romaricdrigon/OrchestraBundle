<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Getter;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Class RepositoryNameGetter
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameGetter implements RepositoryNameGetterInterface
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
    public function getName(RepositoryInterface $repository)
    {
        $reflectionObject = new \ReflectionObject($repository);

        $annotation = $this->annotationReader->getClassAnnotation($reflectionObject, $this->annotationClass);

        if (null !== $annotation) {
            $name = $annotation->getName();

            if ($name) {
                return $name;
            }
        }

        return $this->generateDefaultName($repository);
    }

    /**
     * Returns a string extracted from Repository class name, without the "Repository" part
     *
     * @param RepositoryInterface $repository
     * @return string
     */
    protected function generateDefaultName(RepositoryInterface $repository)
    {
        $reflect = new \ReflectionClass($repository);

        return str_replace('Repository', '', $reflect->getShortName());
    }
}