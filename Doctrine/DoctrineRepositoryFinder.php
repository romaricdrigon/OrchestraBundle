<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class DoctrineRepositoryFinder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class DoctrineRepositoryFinder implements DoctrineRepositoryFinderInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function findForEntity(EntityReflectionInterface $entityReflection)
    {
        $entityClassName = $entityReflection->getNamespacedName();

        $entityDoctrineName = $this->entityManager->getClassMetadata($entityClassName)->getName();

        return $this->entityManager->getRepository($entityDoctrineName);
    }
} 