<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Resolver\RepositoryEntity\RepositoryEntityResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RepositoryListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryListener implements EventSubscriberInterface
{
    /**
     * @var RepositoryEntityResolverInterface
     */
    protected $repositoryEntityResolver;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 900;


    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * @param RepositoryEntityResolverInterface $repositoryEntityResolver
     */
    public function __construct(RepositoryEntityResolverInterface $repositoryEntityResolver)
    {
        $this->repositoryEntityResolver = $repositoryEntityResolver;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // At the moment we use repository_slug only
        if (! $request->attributes->has('repository_slug')) {
            return;
        }

        $repositorySlug = $request->attributes->get('repository_slug');

        $entity = $this->repositoryEntityResolver->findBySlug($repositorySlug);

        $request->attributes->set('entity', $entity);
    }
}
