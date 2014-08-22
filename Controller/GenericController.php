<?php

namespace RomaricDrigon\OrchestraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GenericController
 * This file is part of the Orchestra project.
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * "Base" controller our Request goes to
 */
class GenericController extends Controller
{
    public function indexAction()
    {
        return new Response('No content here yet!');
    }
}