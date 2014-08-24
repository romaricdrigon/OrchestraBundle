<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
        return new Response('Here soon you will see a nice dashboard');
    }

    public function listAction($repository_slug, $repository_method)
    {
        $repository = $this->get('orchestra.pool.repository_pool')->getBySlug($repository_slug);

        // TODO: checks security (from annotation on repo)

        // TODO: run repo

        // TODO: build template

        // TODO: return it!

        return $this->renderView('RomaricDrigonOrchestraBundle:Generic:list', [
            'content' => 'repository '.$repository_slug.' method '.$repository_method
        ]);
    }
}