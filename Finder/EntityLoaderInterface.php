<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

/**
 * Interface EntityLoaderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityLoaderInterface
{
    /**
     * @param string $bundleNamespace
     */
    public function addBundleNamespace($bundleNamespace);

    /**
     * Load (if needed) all classes within entities folders, return their class names
     *
     * @return string[] fully qualified class names (with namespace) of all classes found within entities folders
     */
    public function load();
} 