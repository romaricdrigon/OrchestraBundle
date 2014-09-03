<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Interface RepositoryActionCollectionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryActionCollectionBuilderInterface
{
    /**
     * @param RepositoryInterface $repository
     * @param string $slug
     * @return RepositoryActionCollection
     */
    public function build(RepositoryInterface $repository, $slug);
} 