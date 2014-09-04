<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\FormType;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Annotation\FormType;

/**
 * Class CommandFactoryResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class FormTypeResolver implements FormTypeResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\FormType';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function getFormType(\ReflectionProperty $reflectionProperty)
    {
        /** @var FormType $annotation */
        $annotation = $this->annotationReader->getPropertyAnnotation($reflectionProperty, $this->annotationClass);

        if (null !== $annotation) {
            return $annotation->getType();
        }

        return null;
    }
}