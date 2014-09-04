<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Exception\Request\MissingAttributeException;
use RomaricDrigon\OrchestraBundle\Exception\Request\UnsupportedTypeException;
use RomaricDrigon\OrchestraBundle\Routing\EntityRouteBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use RomaricDrigon\OrchestraBundle\Resolver\EntityRepository\EntityRepositoryResolverInterface;

/**
 * Class EntityResolverListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityResolverListener implements EventSubscriberInterface
{
    /**
     * @var EntityRepositoryResolverInterface
     */
    protected $entityRepositoryResolver;

    /**
     * Our subscriber priority
     * We must go after the Repository received Doctrine
     */
    const PRIORITY = 150;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    public function __construct(EntityRepositoryResolverInterface $entityRepositoryResolver)
    {
        $this->entityRepositoryResolver = $entityRepositoryResolver;
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

        if (EntityRouteBuilder::ROUTE_TYPE === $type && $request->request->has('id')) {
            if (! $request->attributes->has('entity')) {
                throw new MissingAttributeException('entity');
            }

            $entity = $request->attributes->get('entity');
            $id = $request->request->get('id');

            $repository = $this->entityRepositoryResolver->findForEntity($entity);

            $object = $repository->find($id);

            $request->attributes->set('object', $object);
        }
    }
} 