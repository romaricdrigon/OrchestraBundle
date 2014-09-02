<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\ListingHeader;

use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;

/**
 * Interface ListingHeaderResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface ListingHeaderResolverInterface
{
    /**
     * @param EntityInterface $entity
     * @param string $methodName
     * @return array headers names
     * @throws \RomaricDrigon\OrchestraBundle\Exception\Domain\EntityQueryReturnException
     */
    public function getHeader(EntityInterface $entity, $methodName);
} 