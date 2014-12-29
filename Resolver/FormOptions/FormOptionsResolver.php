<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\FormOptions;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Annotation\FormOptions;

/**
 * Class CommandFactoryResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class FormOptionsResolver implements FormOptionsResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\FormOptions';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function getFormOptions(\ReflectionProperty $reflectionProperty)
    {
        /** @var FormOptions $annotation */
        $annotation = $this->annotationReader->getPropertyAnnotation($reflectionProperty, $this->annotationClass);

        if (null !== $annotation) {
            return $annotation->getOptions();
        }

        return [];
    }
}
