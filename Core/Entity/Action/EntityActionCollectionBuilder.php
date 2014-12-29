<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityActionCollectionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityActionCollectionBuilder implements EntityActionCollectionBuilderInterface
{
    /**
     * @var EntityActionBuilderInterface
     */
    protected $entityActionBuilder;

    /**
     * @param EntityActionBuilderInterface $entityActionBuilder
     */
    public function __construct(EntityActionBuilderInterface $entityActionBuilder)
    {
        $this->entityActionBuilder = $entityActionBuilder;
    }

    /**
     * @inheritdoc
     */
    public function build(EntityReflectionInterface $entityReflection)
    {
        $reflectionMethods = $entityReflection->getMethods();

        $collection = new EntityActionCollection();

        foreach ($reflectionMethods as $reflectionMethod) {
            $action = $this->entityActionBuilder->build($entityReflection, $reflectionMethod);

            if (null === $action) {
                continue;
            }

            $collection->addAction($action);
        }

        return $collection;
    }
}
