<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Class RepositoryRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteBuilder implements RepositoryRouteBuilderInterface
{
    /**
     * @var string the controller action a repository will redirect to
     */
    protected $controller = 'RomaricDrigonOrchestraBundle:Generic:list';

    /**
     * @var string the method called on the repository class
     */
    protected $repositoryMethod = 'listing';

    /**
     * @var string suffix to form route URI
     */
    protected $patternSuffix = 'list';

    /**
     * @var string prefix to route name
     */
    protected $namePrefix = 'orchestra_repository';

    /**
     * @var string suffix to route name
     */
    protected $nameSuffix = 'list';

    /**
     * @var string methods allowed to o access to our repository
     */
    protected $methodRequirement = 'GET';

    /**
     * @inheritdoc
     */
    public function buildRoute(RepositoryInterface $repositoryInterface, $slug)
    {
        $pattern = '/'.$slug.'/'.$this->patternSuffix;
        $defaults = [
            '_controller'   => $this->controller,
            'repository_method' => $this->repositoryMethod,
            'repository_slug'   => $slug
        ];
        $requirements = [
            '_method'       => $this->methodRequirement
        ];

        return new Route($pattern, $defaults, $requirements);
    }

    /**
     * @inheritdoc
     */
    public function buildRouteName($slug)
    {
        return $this->namePrefix.'_'.$slug.'_'.$this->nameSuffix;
    }
} 