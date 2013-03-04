<?php

namespace Monmiel\MonmielApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonmielMonmielApiBundle:Default:index.html.twig', array('name' => $name));
    }
}
