<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPoolInterface;
use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use RomaricDrigon\OrchestraBundle\Exception\Request\MissingAttributeException;
use RomaricDrigon\OrchestraBundle\Exception\Request\UnsupportedTypeException;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryEntity\RepositoryEntityResolverInterface;
use RomaricDrigon\OrchestraBundle\Routing\EntityRouteBuilder;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ObjectResolverListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class ObjectResolverListener implements EventSubscriberInterface
{
    /**
     * @var EntityPoolInterface
     */
    protected $entityPool;

    /**
     * @var RepositoryPoolInterface
     */
    protected $repositoryPool;

    /**
     * @var RepositoryEntityResolverInterface
     */
    protected $repositoryEntityResolver;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 1000;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    public function __construct(EntityPoolInterface $entityPool, RepositoryPoolInterface $repositoryPool, RepositoryEntityResolverInterface $repositoryEntityResolver)
    {
        $this->entityPool   = $entityPool;
        $this->repositoryPool = $repositoryPool;
        $this->repositoryEntityResolver = $repositoryEntityResolver;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws MissingAttributeException
     * @throws UnsupportedTypeException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // First, check if it's an Orchestra request
        if (! $request->attributes->has('orchestra_type')) {
            return;
        }

        $type = $request->attributes->get('orchestra_type');

        if (RepositoryRouteBuilder::ROUTE_TYPE === $type) {
            if (! $request->attributes->has('repository_slug')) {
                throw new MissingAttributeException('repository_slug');
            }

            $slug = $request->attributes->get('repository_slug');

            $repository = $this->repositoryPool->getBySlug($slug);

            $request->attributes->set('repository', $repository);

            $entity = $this->repositoryEntityResolver->findBySlug($slug);

            $request->attributes->set('entity', $entity);
        } else if (EntityRouteBuilder::ROUTE_TYPE === $type) {
            if (! $request->attributes->has('entity_slug')) {
                throw new MissingAttributeException('entity_slug');
            }

            $slug = $request->attributes->get('entity_slug');
            $entity = $this->entityPool->getBySlug($slug);

            $request->attributes->set('entity', $entity);
        } else {
            throw new UnsupportedTypeException($type);
        }
    }
} 