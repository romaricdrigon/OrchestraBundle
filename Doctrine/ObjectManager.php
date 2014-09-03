<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ObjectManager
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class ObjectManager implements ObjectManagerInterface
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
    public function saveObject($object)
    {
        // though Object should be already managed by Doctrine
        $this->entityManager->persist($object);

        $this->entityManager->flush();
    }

    /**
     * @inheritdoc
     */
    public function removeObject($object)
    {
        $this->entityManager->remove($object);

        $this->entityManager->flush();
    }
} 