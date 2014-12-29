<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\EmitEvent;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Annotation\EmitEvent;

/**
 * Class EmitEventResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EmitEventResolver implements EmitEventResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\EmitEvent';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function methodEmitsEvent(\ReflectionMethod $reflectionMethod)
    {
        /** @var EmitEvent $annotation */
        $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

        if (null !== $annotation) {
            return true;
        }

        return false;
    }
}
