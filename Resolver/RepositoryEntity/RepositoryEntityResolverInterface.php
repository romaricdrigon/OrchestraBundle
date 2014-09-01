<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositoryEntity;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Interface RepositoryEntityResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryEntityResolverInterface
{
    /**
     * Find EntityReflection corresponding to given Repository (slug)
     *
     * @param string $repositorySlug
     * @return EntityReflectionInterface
     */
    public function findBySlug($repositorySlug);
} 