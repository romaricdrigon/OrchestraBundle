<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilderInterface;

/**
 * Class RepositoryActionCollectionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryActionCollectionBuilder implements RepositoryActionCollectionBuilderInterface
{
    /**
     * @var \RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilderInterface
     */
    protected $repositoryRouteBuilder;


    /**
     * @param RepositoryRouteBuilderInterface $repositoryRouteBuilder
     */
    public function __construct(RepositoryRouteBuilderInterface $repositoryRouteBuilder)
    {
        $this->repositoryRouteBuilder = $repositoryRouteBuilder;
    }

    /**
     * @inheritdoc
     */
    public function build(RepositoryInterface $repository, $slug)
    {
        $reflection = new \ReflectionClass($repository);

        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $collection = new RepositoryActionCollection();

        foreach ($methods as $method) {
            $methodName = $method->getShortName();

            // For now, name is the humanized version of Method name
            $name = $this->humanizeName($methodName);

            $routeName = $this->repositoryRouteBuilder->buildRouteName($slug);

            $action = new RepositoryAction($methodName, $name, $routeName);

            $collection->addAction($action);
        }

        return $collection;
    }

    /**
     * Humanize name, adding a space before each capital
     *
     * @param string $name
     * @return string
     */
    protected function humanizeName($name)
    {
        $name = preg_replace('/([A-Z]{1})/', ' $1', $name);

        $name = ucfirst($name);

        return trim($name);
    }
} 