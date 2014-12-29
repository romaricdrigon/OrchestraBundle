<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RepositorySlugListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositorySlugListener implements EventSubscriberInterface
{
    /**
     * @var RepositoryPoolInterface
     */
    protected $repositoryPool;

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

    public function __construct(RepositoryPoolInterface $repositoryPool)
    {
        $this->repositoryPool = $repositoryPool;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->attributes->has('repository_slug')) {
            return;
        }

        $slug = $request->attributes->get('repository_slug');

        $repositoryDefinition = $this->repositoryPool->getBySlug($slug);

        $request->attributes->set('repository_definition', $repositoryDefinition);
    }
}
