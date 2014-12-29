<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository;

/**
 * Interface RepositoryDefinitionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryDefinitionInterface
{
    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return \ReflectionMethod[] list of public methods from class, keys are slugs
     */
    public function getMethods();

    /**
     * @param string $methodName
     * @return \ReflectionMethod
     */
    public function getMethod($methodName);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string ID of the service in DIC
     */
    public function getServiceId();

    /**
     * @return \ReflectionClass
     * Temp, to be removed
     */
    public function getReflection();

    /**
     * @return string fully qualified class name of the related entity
     */
    public function getEntityClass();
}
