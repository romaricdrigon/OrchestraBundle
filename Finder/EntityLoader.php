<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

use Symfony\Component\ClassLoader\ClassMapGenerator;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class EntityLoader
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityLoader implements EntityLoaderInterface
{
    /**
     * string[] bundles (that may contain entities) namespaces
     */
    protected $bundleNamespaces;

    /**
     * @var string the bundle subfolder/subnamespace where to look for entities
     * Both are the same due to PSR
     */
    protected $entityNamespace = 'Entity';

    /**
     * @var Filesystem instance of Symfony Filesystem component
     */
    protected $filesystem;


    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem   = $filesystem;
    }

    /**
     * @inheritdoc
     */
    public function addBundleNamespace($bundleNamespace)
    {
        $this->bundleNamespaces[] = $bundleNamespace;
    }

    /**
     * @inheritdoc
     */
    public function load()
    {
        $entitiesClassNames = [];

        // First, we must make sure entities are all loaded
        // They may have been autoloaded, but if the class is not used somewhere, we won't be able to see it
        foreach ($this->bundleNamespaces as $bundleNamespace) {
            $bundle = new \ReflectionClass($bundleNamespace);
            $bundleDir = dirname($bundle->getFilename());
            $entityDir = $this->buildEntityDir($bundleDir);

            if ($this->filesystem->exists($entityDir)) {
                // Symfony component takes care of subfolders and so on...
                $newClasses = ClassMapGenerator::createMap($entityDir);

                // duplicated classes (if that can happen!) will be merged
                $entitiesClassNames = array_merge($entitiesClassNames, $newClasses);
            }
        }

        return array_keys($entitiesClassNames);
    }

    /**
     * Builds the fully-qualified path where we will look for entities for that Bundle
     *
     * @param string $bundleDir
     * @return string
     */
    protected function buildEntityDir($bundleDir)
    {
        return $bundleDir.'/'.$this->entityNamespace;
    }
} 