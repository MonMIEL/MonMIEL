<?php

namespace Monmiel\TransformersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonmielTransformersBundle:Default:index.html.twig', array('name' => $name));
    }
}
