<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

use RomaricDrigon\OrchestraBundle\Pool\EntityReflection;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class EntityFinder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityFinder implements EntityFinderInterface
{
    /**
     * string[] bundles (that may contain entities) namespaces
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
        $this->namespaces[] = $namespace;
    }

    /**
     * @inheritdoc
     */
    public function getEntitiesReflections()
    {
        $loader = new EntityLoader(new Filesystem(), new Finder());
        $loader->load();

        $allClasses = get_declared_classes();

        $entities = [];

        // We checks entities both implements EntityInterface
        // and are in a correct /Entity folder
        foreach ($allClasses as $className) {
            var_dump($className);
            $reflection = new \ReflectionClass($className);

            // Order of checks is important here for optimization purpose
            if ($reflection->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\EntityInterface')) {
                foreach ($this->namespaces as $namespace) {
                    if ($namespace === $reflection->getNamespaceName()) {
                        $allClasses[] = new EntityReflection($reflection);

                        continue;
                    }
                }
            }
        }

        return $entities;
    }


} 