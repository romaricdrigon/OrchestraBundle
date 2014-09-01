<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

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
     * @inheritdoc
     */
    public function setDoctrineRepository(ObjectRepository $repository)
    {
        $this->doctrineRepository = $repository;
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
} 