<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Doctrine\DoctrineInjecterInterface;
use RomaricDrigon\OrchestraBundle\Domain\Doctrine\DoctrineAwareInterface;
use RomaricDrigon\OrchestraBundle\Exception\Request\MissingAttributeException;
use RomaricDrigon\OrchestraBundle\Exception\Request\UnsupportedTypeException;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryEntity\RepositoryEntityResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class DoctrineRepositoryListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class DoctrineRepositoryListener implements EventSubscriberInterface
{
    /**
     * @var DoctrineInjecterInterface
     */
    protected $doctrineInjecter;

    /**
     * @var RepositoryEntityResolverInterface
     */
    protected $repositoryEntityResolver;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 250;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    public function __construct(DoctrineInjecterInterface $doctrineInjecter)
    {
        $this->doctrineInjecter         = $doctrineInjecter;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws MissingAttributeException
     * @throws UnsupportedTypeException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // First, check if it's an Orchestra Repository request
        if (! $request->attributes->has('repository')) {
            return;
        }

        $repository = $request->attributes->get('repository');

        if ($repository instanceof DoctrineAwareInterface) {
            if (! $request->attributes->has('entity')) {
                throw new MissingAttributeException('entity');
            }

            $entity = $request->attributes->get('entity');

            // Finally, inject Doctrine repository into ours
            $this->doctrineInjecter->injectDoctrine($repository, $entity);
        }
    }
} 