<?php

namespace Monmiel\MonmielApiBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @DI\Service("monmiel.simulation.controller")
 */
class SimulationV1Controller extends Controller
{

    public function sendSimulationResult(HttpRequest $request)
    {
        $response = new Response();
        var_dump("toto");
        return $response;
    }
}
