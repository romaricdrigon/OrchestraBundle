<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\HiddenAction;

use Doctrine\Common\Annotations\Reader;

/**
 * Class HiddenActionResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class HiddenActionResolver implements HiddenActionResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\Hidden';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function isHiddenObject($object)
    {
        $reflectionObject = new \ReflectionObject($object);

        $annotation = $this->annotationReader->getClassAnnotation($reflectionObject, $this->annotationClass);

        if (null !== $annotation) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function isHiddenReflectionMethod(\ReflectionMethod $reflectionMethod)
    {
        $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

        if (null !== $annotation) {
            return true;
        }

        return false;
    }
} 