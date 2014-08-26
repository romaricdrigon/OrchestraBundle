<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Base;

use Doctrine\Common\Persistence\ObjectRepository;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Interface BaseRepositoryInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface BaseRepositoryInterface extends RepositoryInterface
{
    /**
     * Will receive dependency
     *
     * @param ObjectRepository $repository
     */
    public function setDoctrineRepository(ObjectRepository $repository);
} 