<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\Security;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\ExpressionLanguage\Expression;
use RomaricDrigon\OrchestraBundle\Annotation\Security;

/**
 * Class SecurityResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class SecurityResolver implements SecurityResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\Security';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function getExpression(\ReflectionMethod $reflectionMethod)
    {
        /** @var Security $annotation */
        $annotation = $this->annotationReader->getMethodAnnotation($reflectionMethod, $this->annotationClass);

        if (null !== $annotation) {
            return new Expression($annotation->getExpression());
        }

        return null;
    }
}
