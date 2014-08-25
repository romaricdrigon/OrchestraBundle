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
    public function dashboardAction()
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

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
}