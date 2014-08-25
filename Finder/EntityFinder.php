<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

/**
 * Class EntityFinder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityFinder implements EntityFinderInterface
{
    /**
     * string[] namespaces where to look for
     */
    protected $namespaces;

    /**
     * @var string the bundle subfolder/subnamespace where to look for entities
     */
    protected $entityNamespace = 'Entity';

    /**
     * @inheritdoc
     */
    public function addNamespace($namespace)
    {
        $this->namespaces[] = $this->buildEntityNamespace($namespace);
    }

    /**
     * @inheritdoc
     */
    public function getEntitiesReflections()
    {
        $allClasses = get_declared_classes();

        $entities = [];

        // We checks entities both implements EntityInterface
        // and are in a correct /Entity folder
        foreach ($allClasses as $className) {
            $reflection = new \ReflectionClass($className);

            // Order of checks is important here for optimization purpose
            if ($reflection->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\EntityInterface')) {
                foreach ($this->namespaces as $namespace) {
                    if ($reflection->inNamespace($namespace)) {
                        $allClasses[] = $reflection;

                        continue;
                    }
                }
            }
        }

        return $entities;
    }

    /**
     * Builds the fully-qualified namespace where we will look for entities for that Bundle
     *
     * @param string $bundleNamespace
     * @return string
     */
    protected function buildEntityNamespace($bundleNamespace)
    {
        return $bundleNamespace.'\\'.$this->entityNamespace;
    }
} 