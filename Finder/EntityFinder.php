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

    public function buildPool()
    {

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