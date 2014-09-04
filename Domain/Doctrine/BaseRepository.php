<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use RomaricDrigon\OrchestraBundle\Doctrine\ObjectManagerInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Annotation\Hidden;
use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;

/**
 * Class BaseRepository
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class BaseRepository implements DoctrineAwareInterface, RepositoryInterface
{
    /**
     * @var ObjectRepository
     */
    protected $doctrineRepository;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @inheritdoc
     *
     * @Hidden
     */
    public function setDoctrineRepository(ObjectRepository $repository)
    {
        $this->doctrineRepository = $repository;
    }

    /**
     * @inheritdoc
     *
     * @Hidden
     */
    public function setObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Typical listing function, using Doctrine Repository findAll()
     *
     * @inheritdoc
     */
    public function listing()
    {
        return $this->doctrineRepository->findAll();
    }

    /**
     * Typical find function, where ID returned by our entities is the Doctrine database ID
     *
     * @param mixed $id
     * @return null|EntityInterface
     */
    public function find($id)
    {
        return $this->find($id);
    }
} 