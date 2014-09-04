<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Repository;

use RomaricDrigon\OrchestraBundle\Domain\Event\EventInterface;

/**
 * Interface ReceiveEventsInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface ReceiveEventInterface
{
    public function receive(EventInterface $event);
}