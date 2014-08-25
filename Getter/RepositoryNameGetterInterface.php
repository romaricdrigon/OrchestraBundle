<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Getter;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Interface RepositoryNameGetterInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryNameGetterInterface
{
    /**
     * Get the repository name, to display
     * There may be none, and we will generate a default then
     *
     * @param RepositoryInterface $repository
     * @return string
     */
    public function getName(RepositoryInterface $repository);
} 