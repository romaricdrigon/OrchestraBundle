<?php

namespace RomaricDrigon\OrchestraBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class GenericController extends Controller
{
    public function indexAction()
    {
        return new Response('No content here yet!');
    }
}