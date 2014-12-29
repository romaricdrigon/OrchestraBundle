<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Exception\OrchestraRuntimeException;
use RomaricDrigon\OrchestraBundle\Resolver\Security\SecurityResolverInterface;
use RomaricDrigon\OrchestraBundle\Routing\EntityRouteBuilder;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilder;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationTrustResolverInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use RomaricDrigon\OrchestraBundle\Security\ExpressionLanguage;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

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
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var ExpressionLanguage
     */
    protected $language;

    /**
     * @var AuthenticationTrustResolverInterface
     */
    protected $trustResolver;

    /**
     * @var RoleHierarchyInterface
     */
    protected $roleHierarchy;

    /**
     * @var SecurityResolverInterface
     */
    protected $securityResolver;

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
     * @param SecurityResolverInterface $securityResolver
     */
    public function __construct(SecurityContextInterface $securityContext, ExpressionLanguage $language, AuthenticationTrustResolverInterface $trustResolver, RoleHierarchyInterface $roleHierarchy = null, SecurityResolverInterface $securityResolver)
    {
        $this->securityContext  = $securityContext;
        $this->language         = $language;
        $this->trustResolver    = $trustResolver;
        $this->roleHierarchy    = $roleHierarchy;
        $this->securityResolver = $securityResolver;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws AccessDeniedException
     * @throws OrchestraRuntimeException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // First, check if it's an Orchestra request
        if (! $request->attributes->has('orchestra_type')) {
            return;
        }

        $type = $request->attributes->get('orchestra_type');

        if (EntityRouteBuilder::ROUTE_TYPE === $type) {
            if (! $request->attributes->has('entity')) {
                throw new OrchestraRuntimeException('Request is missing attribute "entity"');
            }

            /** @var EntityReflectionInterface $entity */
            $entity = $request->attributes->get('entity');

            if (! $request->attributes->has('entity_method')) {
                throw new OrchestraRuntimeException('Request is missing attribute "entity_method"');
            }

            $entityMethod = $request->attributes->get('entity_method');

            $reflectionMethod = $entity->getMethod($entityMethod);
        } else if (RepositoryRouteBuilder::ROUTE_TYPE === $type) {
            if (! $request->attributes->has('repository')) {
                throw new OrchestraRuntimeException('Request is missing attribute "repository"');
            }

            /** @var RepositoryInterface $repository */
            $repository = $request->attributes->get('repository');

            $repositoryReflection = new \ReflectionClass($repository);

            if (! $request->attributes->has('repository_method')) {
                throw new OrchestraRuntimeException('Request is missing attribute "repository_method"');
            }

            $repositoryMethod = $request->attributes->get('repository_method');

            $reflectionMethod = $repositoryReflection->getMethod($repositoryMethod);
        } else {
            return;
        }

        $expression = $this->securityResolver->getExpression($reflectionMethod);

        // We may have no Security expression
        if (null === $expression) {
            return;
        }

        if (! $this->language->evaluate($expression, $this->getVariables($request))) {
            throw new AccessDeniedException(sprintf('Expression "%s" denied access.', $expression));
        }
    }

    // code should be sync with Symfony\Component\Security\Core\Authorization\Voter\ExpressionVoter
    protected function getVariables(Request $request)
    {
        $token  = $this->securityContext->getToken();
        $user   = null;
        $roles  = [];

        if ($token instanceof TokenInterface) {
            $user = $token->getUser();

            if (null !== $this->roleHierarchy) {
                $roles = $this->roleHierarchy->getReachableRoles($token->getRoles());
            } else {
                $roles = $token->getRoles();
            }
        }

        $variables = array(
            'token' => $token,
            'user'  => $user,
            // we removed "object" and "request"
            'roles' => array_map(function (RoleInterface $role) { return $role->getRole(); }, $roles),
            'trust_resolver' => $this->trustResolver,
            'security_context' => $this->securityContext,
        );

        // controller variables should also be accessible: repository, entity...
        return array_merge($request->attributes->all(), $variables);
    }
}
