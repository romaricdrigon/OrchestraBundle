<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositorySlug;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Interface RepositorySlugResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositorySlugResolverInterface
{
    /**
     * @param RepositoryInterface $repository
     * @return string Repository slug
     */
    public function getSlug(RepositoryInterface $repository);
} 