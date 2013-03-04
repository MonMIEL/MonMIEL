<?php

namespace Monmiel\MonmielDaoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MonmielMonmielDaoBundle:Default:index.html.twig', array('name' => $name));
    }
}
