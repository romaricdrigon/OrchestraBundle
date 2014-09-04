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
 * Class ParamConverterListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class ParamConverterListener implements EventSubscriberInterface
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

        if (EntityRouteBuilder::ROUTE_TYPE === $type && $request->query->has('id')) {
            if (! $request->attributes->has('repository')) {
                throw new MissingAttributeException('repository');
            }

            $repository = $request->attributes->get('repository');

            $id = $request->query->get('id');

            $object = $repository->find($id);

            $request->attributes->set('object', $object);
        }
    }
} 