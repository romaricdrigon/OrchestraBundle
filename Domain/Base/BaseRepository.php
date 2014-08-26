<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Base;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Class BaseRepository
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Private as we want users to have only one way to access it
     *
     * @var ObjectRepository
     */
    private $doctrineRepository;

    /**
     * @inheritdoc
     */
    public function setDoctrineRepository(ObjectRepository $repository)
    {
        $this->doctrineRepository = $repository;
    }

    /**
     * We want users who extend this class to have only way to access Doctrine repository, and the goal is not to expose it outside
     * @return ObjectRepository
     */
    final protected function getDoctrineRepository()
    {
        return $this->doctrineRepository;
    }

    /**
     * @inheritdoc
     */
    abstract public function listing();
} 