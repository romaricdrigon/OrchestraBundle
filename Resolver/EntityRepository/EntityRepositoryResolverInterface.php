<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\EntityRepository;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Interface EntityRepositoryResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityRepositoryResolverInterface
{
    /**
     * Find Repository corresponding to given Entity
     *
     * @param EntityReflectionInterface $entityReflection
     * @return RepositoryDefinitionInterface
     */
    public function findForEntity(EntityReflectionInterface $entityReflection);
}
