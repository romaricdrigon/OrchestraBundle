<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\ListingHeader;

use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;
use RomaricDrigon\OrchestraBundle\Domain\Query\QueryInterface;
use RomaricDrigon\OrchestraBundle\Exception\DomainErrorException;

/**
 * Class ListingHeaderResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class ListingHeaderResolver implements ListingHeaderResolverInterface
{
    /**
     * @inheritdoc
     */
    public function getHeaders(EntityInterface $entity, $methodName)
    {
        // We must get some data
        $data = $entity->{$methodName}();

        if (is_array($data)) {
            // For an array we use headers
            return array_keys($data);
        } else if ($data instanceof QueryInterface) {
            // For a query, it's the name of the properties
            $headers = [];

            // A Query is a Traversable object
            foreach ($data as $key => $value) {
                $headers[] = $key;
            }

            return $headers;
        } else {
            $entityName = (new \ReflectionClass($entity))->getName();

            throw new DomainErrorException('Entity '.$entityName.' method '.$methodName.' should return either an array, either an instance of QueryInterface');
        }
    }
}