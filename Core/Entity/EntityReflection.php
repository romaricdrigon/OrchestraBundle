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

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $namespacedName;

    /**
     * @var bool
     */
    protected $isListable;


    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;

        // Build/cache a few properties
        $this->slug = strtolower($reflectionClass->getShortName());
        $this->name = $reflectionClass->getShortName();
        $this->namespacedName = $reflectionClass->getName();
        $this->isListable = $reflectionClass->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\Entity\ListableEntityInterface');
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return $this->slug;
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
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getNamespacedName()
    {
        return $this->namespacedName;
    }

    /**
     * @inheritdoc
     */
    public function isListable()
    {
        return $this->isListable;
    }
}
