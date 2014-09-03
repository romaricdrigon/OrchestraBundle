<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositorySlug;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Class RepositorySlugResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositorySlugResolver implements RepositorySlugResolverInterface
{
    /**
     * @inheritdoc
     */
    public function getSlug(RepositoryInterface $repository)
    {
        $reflect = new \ReflectionClass($repository);

        return strtolower(str_replace('Repository', '', $reflect->getShortName()));
    }
} 