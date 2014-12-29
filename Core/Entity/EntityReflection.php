<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity;

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

    protected $actionsCollection;


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
     * @return \ReflectionMethod[] list of public methods from class
     */
    public function getMethods()
    {
        return $this->reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
    }

    /**
     * @inheritdoc
     */
    public function getMethod($methodName)
    {
        return $this->reflectionClass->getMethod($methodName);
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

    /**
     * @inheritdoc
     */
    public function isListable()
    {
        return $this->reflectionClass->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\Entity\ListableEntityInterface');
    }
}
