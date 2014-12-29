<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionInterface;

/**
 * Interface RepositoryMenuInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryMenuInterface
{
    /**
     * @return RepositoryActionCollectionInterface[] keys are repository slug
     */
    public function getMenu();
}
