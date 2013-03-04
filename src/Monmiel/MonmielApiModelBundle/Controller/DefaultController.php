<?php

namespace Monmiel\MonmielApiModelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonmielMonmielApiModelBundle:Default:index.html.twig', array('name' => $name));
    }
}
