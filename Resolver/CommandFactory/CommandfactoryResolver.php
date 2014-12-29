<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\CommandFactory;

use Doctrine\Common\Annotations\Reader;
use RomaricDrigon\OrchestraBundle\Annotation\CommandFactory;

/**
 * Class CommandFactoryResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandFactoryResolver implements CommandFactoryResolverInterface
{
    /**
     * @var Reader
     */
    protected $annotationReader;

    /**
     * @var string class of the annotation we will be reading
     */
    protected $annotationClass = 'RomaricDrigon\\OrchestraBundle\\Annotation\\CommandFactory';


    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @inheritdoc
     */
    public function getCommandFactory($commandClass)
    {
        $reflection = new \ReflectionClass($commandClass);

        /** @var CommandFactory $annotation */
        $annotation = $this->annotationReader->getClassAnnotation($reflection, $this->annotationClass);

        if (null !== $annotation) {
            return $annotation->getMethod();
        }

        return null;
    }
}
