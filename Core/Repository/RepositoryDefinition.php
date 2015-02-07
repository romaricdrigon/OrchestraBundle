<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository;

/**
 * Class RepositoryDefinition
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryDefinition implements RepositoryDefinitionInterface
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;

    /**
     * @var string ID of the service in Symfony DIC
     */
    protected $serviceId;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;


    public function __construct(\ReflectionClass $reflectionClass, $serviceId, $entityClass, $name)
    {
        $this->reflectionClass  = $reflectionClass;
        $this->serviceId        = $serviceId;
        $this->entityClass      = $entityClass;

        // Build/cache a few properties
        $this->name = $name;
        $this->slug = strtolower($name);
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
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @inheritdoc
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }
}
