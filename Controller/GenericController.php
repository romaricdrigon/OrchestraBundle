<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GenericController
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * "Base" controller our Request goes to
 */
class GenericController extends Controller
{
    /**
     * Action for the dashboard page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

    /**
     * Action used when a repository "listing" is called
     *
     * @param string $repository_slug
     * @param string $repository_method
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($repository_slug, $repository_method)
    {
        $repository = $this->get('orchestra.pool.repository_pool')->getBySlug($repository_slug);

        $name = $this->get('orchestra.getter.repository_name_getter')->getName($repository);

        // TODO: checks security (from annotation on repo)

        // TODO: run repo

        return $this->render('RomaricDrigonOrchestraBundle:Generic:list.html.twig', [
            'content'   => 'repository '.$repository_slug.' method '.$repository_method,
            'title'     => $name
        ]);
    }

    /**
     * Action used when a method on en Entity is called
     *
     * @param string $entity_slug
     * @param string $entity_method name
     * @param string $method_slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityMethodAction($entity_slug, $entity_method, $method_slug)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }
}