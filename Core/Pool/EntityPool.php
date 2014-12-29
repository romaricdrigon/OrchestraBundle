<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

use RomaricDrigon\OrchestraBundle\Exception\DomainErrorException;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityPool
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityPool implements EntityPoolInterface
{
    protected $entitiesBySlug = [];

    /**
     * Add an entity to the pool
     *
     * @param EntityReflectionInterface $entityReflection
     * @throws DomainErrorException
     */
    public function addEntityReflection(EntityReflectionInterface $entityReflection)
    {
        // At the moment slug is not configurable otherwise
        $slug = $entityReflection->getSlug();

        if (isset($this->entitiesBySlug[$slug])) {
            throw new DomainErrorException('Two entities are registered with the same "'.$slug.'" slug!');
        }

        $this->entitiesBySlug[$slug] = $entityReflection;
    }

    /**
     * Get an entity from by slug
     *
     * @param string $slug
     * @throws DomainErrorException
     * @return \ReflectionClass
     */
    public function getBySlug($slug)
    {
        if (! isset($this->entitiesBySlug[$slug])) {
            throw new DomainErrorException('Unable to find entity for slug '.$slug.'!');
        }

        return $this->entitiesBySlug[$slug];
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->entitiesBySlug;
    }
}
