<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use RomaricDrigon\OrchestraBundle\Domain\Doctrine\DoctrineAwareInterface;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class DoctrineInjecter
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class DoctrineInjecter implements DoctrineInjecterInterface
{
    /**
     * @var DoctrineRepositoryFinderInterface
     */
    protected $doctrineRepositoryFinder;

    public function __construct(DoctrineRepositoryFinderInterface $doctrineRepositoryFinder)
    {
        $this->doctrineRepositoryFinder = $doctrineRepositoryFinder;
    }

    /**
     * @inheritdoc
     */
    public function injectDoctrine(RepositoryInterface $repository, EntityReflectionInterface $entityReflection)
    {
        if (false === $repository instanceof DoctrineAwareInterface) {
            return; // nothing to do!
        }

        /** @var $repository DoctrineAwareInterface */

        $doctrineRepository = $this->doctrineRepositoryFinder->findForEntity($entityReflection);

        $repository->setDoctrineRepository($doctrineRepository);
    }
} 