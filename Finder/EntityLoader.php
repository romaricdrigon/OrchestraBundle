<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

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
     * @var Finder instance of Symfony Finder component
     */
    protected $finder;

    /**
     * @var Filesystem instance of Symfony Filesystem component
     */
    protected $filesystem;


    public function __construct(Filesystem $filesystem, Finder $finder)
    {
        $this->filesystem   = $filesystem;
        $this->finder       = $finder;
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
            $entityNamespace = $this->buildEntityNamespace($bundleNamespace);
            $entityDir = $this->buildEntityDir($bundleDir);

            if ($this->filesystem->exists($entityDir)) {
                // Symfony Finder works recursively by default - next code does not support this, so we limit depth
                $phpFiles = $this->finder->in($entityDir)->files()->name('/\.php$/')->depth('== 0');

                /** @var $file \SplFileInfo */
                foreach ($phpFiles as $file) {
                    // Following PSR, getBasename() remove ".php" suffix
                    $className = $entityNamespace.'\\'.$file->getBasename('.php');

                    // class may be defined, otherwise only way is to include it...
                    if (! class_exists($className)) {
                        include $file->getPathname();
                    }

                    $entitiesClassNames[] = $className;
                }
            }
        }

        return $entitiesClassNames;
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
     *
     * @param string $bundleDir
     * @return string
     */
    protected function buildEntityDir($bundleDir)
    {
        return $bundleDir.'/'.$this->entityNamespace;
    }
} 