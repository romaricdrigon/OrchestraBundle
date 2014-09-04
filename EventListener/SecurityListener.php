<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use RomaricDrigon\OrchestraBundle\Security\ExpressionLanguage;

/**
 * Class SecurityListener
 * Heavily inspired by the one from SensioFrameworkExtraBundle
 *
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SecurityListener implements EventSubscriberInterface
{
    /**
     * @var SecurityContextInterface|null
     */
    protected $securityContext;

    /**
     * @var ExpressionLanguage|null
     */
    protected $language;

    /**
     * @var AuthenticationTrustResolverInterface|null
     */
    protected $trustResolver;

    /**
     * @var RoleHierarchyInterface|null
     */
    protected $roleHierarchy;

    /**
     * Our subscriber priority
     * Way below so we can access as much attributes as possible
     */
    const PRIORITY = 100;


    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * @param SecurityContextInterface $securityContext
     * @param ExpressionLanguage $language
     * @param AuthenticationTrustResolverInterface $trustResolver
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(SecurityContextInterface $securityContext = null, ExpressionLanguage $language = null, AuthenticationTrustResolverInterface $trustResolver = null, RoleHierarchyInterface $roleHierarchy = null)
    {
        $this->securityContext  = $securityContext;
        $this->language         = $language;
        $this->trustResolver    = $trustResolver;
        $this->roleHierarchy    = $roleHierarchy;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws \LogicException
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // TODO: fetch Security annotation

        if (!$this->language->evaluate($configuration->getExpression(), $this->getVariables($request))) {
            throw new AccessDeniedException(sprintf('Expression "%s" denied access.', $configuration->getExpression()));
        }
    }

    // code should be sync with Symfony\Component\Security\Core\Authorization\Voter\ExpressionVoter
    private function getVariables(Request $request)
    {
        $token = $this->securityContext->getToken();

        if (null !== $this->roleHierarchy) {
            $roles = $this->roleHierarchy->getReachableRoles($token->getRoles());
        } else {
            $roles = $token->getRoles();
        }

        $variables = array(
            'token' => $token,
            'user'  => $token->getUser(),
            // we removed "object" and "request"
            'roles' => array_map(function ($role) { return $role->getRole(); }, $roles),
            'trust_resolver' => $this->trustResolver,
            'security_context' => $this->securityContext,
        );

        // controller variables should also be accessible: repository, entity...
        return array_merge($request->attributes->all(), $variables);
    }
} 