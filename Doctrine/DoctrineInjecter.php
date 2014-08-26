<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use RomaricDrigon\OrchestraBundle\Domain\Base\BaseRepositoryInterface;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Pool\EntityReflectionInterface;

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
        if (false === $repository instanceof BaseRepositoryInterface) {
            return; // nothing to do!
        }

        /** @var $repository BaseRepositoryInterface */

        $doctrineRepository = $this->doctrineRepositoryFinder->findForEntity($entityReflection);

        $repository->setDoctrineRepository($doctrineRepository);
    }
} 