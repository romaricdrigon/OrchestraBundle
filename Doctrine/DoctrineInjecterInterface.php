<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Interface DoctrineInjecterInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface DoctrineInjecterInterface
{
    /**
     * Injects Doctrine correct repository into given $repository
     *
     * @param RepositoryInterface $repository
     * @param EntityReflectionInterface $entityReflection
     */
    public function injectDoctrine(RepositoryInterface $repository, EntityReflectionInterface $entityReflection);
} 