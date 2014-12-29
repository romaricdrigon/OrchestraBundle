<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Doctrine\DoctrineInjecterInterface;
use RomaricDrigon\OrchestraBundle\Doctrine\ObjectManagerInterface;
use RomaricDrigon\OrchestraBundle\Domain\Doctrine\DoctrineAwareInterface;
use RomaricDrigon\OrchestraBundle\Exception\OrchestraRuntimeException;
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
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 700;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    public function __construct(DoctrineInjecterInterface $doctrineInjecter, ObjectManagerInterface $objectManager)
    {
        $this->doctrineInjecter = $doctrineInjecter;
        $this->objectManager    = $objectManager;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws OrchestraRuntimeException
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
                throw new OrchestraRuntimeException('Request has an orchestra_type, but no "entity" attribute was found');
            }

            $entity = $request->attributes->get('entity');

            // Inject object manager first
            $repository->setObjectManager($this->objectManager);

            // Finally, inject Doctrine repository into ours
            $this->doctrineInjecter->injectDoctrine($repository, $entity);
        }
    }
}
