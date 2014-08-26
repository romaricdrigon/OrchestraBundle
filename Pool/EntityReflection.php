<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;
use RomaricDrigon\OrchestraBundle\Exception\EntityTwiceSameSlugException;

/**
 * Class EntityReflection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityReflection implements EntityReflectionInterface
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;


    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return strtolower($this->reflectionClass->getShortName());
    }

    /**
     * @throws EntityTwiceSameSlugException
     * @return \ReflectionMethod[] list of public methods from class, keys are slugs
     */
    public function getMethods()
    {
        $reflectionMethods = $this->reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

        $methods = [];

        foreach ($reflectionMethods as $reflectionMethod) {
            $slug = strtolower($reflectionMethod->getShortName());

            if (isset($methods[$slug])) {
                throw new EntityTwiceSameSlugException($reflectionMethod->getShortName(), $slug);
            }

            $methods[$slug] = $reflectionMethod;
        }

        return $methods;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->reflectionClass->getShortName();
    }

    /**
     * @inheritdoc
     */
    public function getNamespacedName()
    {
        return $this->reflectionClass->getName();
    }
} 