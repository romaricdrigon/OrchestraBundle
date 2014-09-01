<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Interface DoctrineRepositoryFinderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface DoctrineRepositoryFinderInterface
{
    /**
     * Find Doctrine Repository for given EntityReflectionInterface
     *
     * @param EntityReflectionInterface $entityReflection
     * @return ObjectRepository
     */
    public function findForEntity(EntityReflectionInterface $entityReflection);
} 