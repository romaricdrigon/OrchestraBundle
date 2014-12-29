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


    public function __construct(\ReflectionClass $reflectionClass, $serviceId)
    {
        $this->reflectionClass  = $reflectionClass;
        $this->serviceId        = $serviceId;
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return strtolower($this->getName());
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
        return str_replace('Repository', '', $this->reflectionClass->getShortName());
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
    public function getReflection()
    {
        return $this->reflectionClass;
    }
}
