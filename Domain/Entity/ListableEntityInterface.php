<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Entity;

use RomaricDrigon\OrchestraBundle\Domain\Query\QueryInterface;

/**
 * Interface ListableEntityInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface ListableEntityInterface
{
    /**
     * @return QueryInterface|array
     */
    public function viewListing();
}
