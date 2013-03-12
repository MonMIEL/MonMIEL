<?php

namespace Monmiel\MonmielApiBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Response\SimulationResultSeries;

/**
 * @DI\Service("monmiel.test.controller")
 */
class DebugPerfController extends Controller
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function testPerf(HttpRequest $request)
    {
        $response = new Response();
        $response->setContent($this->getHtmlContent());
        $this->launchSimu();

        return $response;
    }

    public function getHtmlContent()
    {
        $content = <<<EOF
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
    </body>
</html>
EOF;

        return $content;
    }

    public function launchSimu()
    {

    }

}
