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
        $filesystem = new Filesystem();
        $finder = new Finder();

        // First, we must make sure entities are all loaded
        // They may have been autoloaded, but if the class is not used somewhere, we won't be able to see it
        foreach ($this->namespaces as $bundleNamespace) {
            $bundle = new \ReflectionClass($bundleNamespace);
            $bundleDir = dirname($bundle->getFilename());
            $entityNamespace = $this->buildEntityNamespace($bundleNamespace);
            $entityDir = $this->buildEntityDir($bundleDir);

            if ($filesystem->exists($entityDir)) {
                // Symfony Finder works recursively by default
                $phpFiles = $finder->in($entityDir)->files()->name('/\.php$/');

                /** @var $file \SplFileInfo */
                foreach ($phpFiles as $file) {
                    $className = $entityNamespace.'\\'.$file->getBasename('.php');

                    // class may be defined, otherwise we need to include it...
                    if (! class_exists($className)) {
                        include $file->getPathname();
                    }
                }
            }
        }

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
                        $allClasses[] = new EntityReflection($reflection);

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

    /**
     * Builds the fully-qualified path where we will look for entities for that Bundle
     * Due to PSR entity namespace === the subfolder
     *
     * @param string $bundleDir
     * @return string
     */
    protected function buildEntityDir($bundleDir)
    {
        return $bundleDir.'/'.$this->entityNamespace;
    }
} 