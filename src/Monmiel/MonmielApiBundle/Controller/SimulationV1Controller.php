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
 * @DI\Service("monmiel.simulation.controller")
 */
class SimulationV1Controller extends Controller
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendSimulationResult(HttpRequest $request)
    {
        $response = new Response();
        $this->init($request);

        $result = new SimulationResultSeries();
        for ($i = 1; $i < 363; $i++) {
            $day = $this->repartition->get($i);
            $result->addDay($day);
        }
        $targetYear = $this->createTargetYearObject($request);
        $computedYear = $this->repartition->getComputedYear();

        $parc = $this->repartition->getTargetParcPower();
        $finaParc = $this->parc->getFinalPower();


        $result->setFinalConso($computedYear);
        $result->setTargetConso($targetYear);
        $result->setTargetParcPower($parc);
        $result->setFinalParcPower($finaParc);


        $response = new Response();
        $json = $this->serializer->serialize($result, "json");
        $response->setContent($json);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function init(HttpRequest $request = null)
    {
        $this->stopWatch->start("init", "controller");
        $userConsoMesure = new Mesure($request->get("targetConso"), \Monmiel\Utils\ConstantUtils::TERAWATT_HOUR);
        $actualConsoMesure = new Mesure(478, \Monmiel\Utils\ConstantUtils::TERAWATT_HOUR);

        $this->transformers->setConsoTotalActuel($actualConsoMesure);
        $this->transformers->setConsoTotalDefinedByUser($userConsoMesure);

        $refYear = $this->createRefYearObject();
        $targetYear = $this->createTargetYearObject($request);

        $this->transformers->setReferenceYear($refYear);
        $this->transformers->setTargetYear($targetYear);

        $this->parc->setTargetParcPower($targetYear);
        $this->parc->setRefParcPower($refYear);
        $targetParcPower = $this->parc->getTargetParcPower();
        $refParcPower = $this->parc->getRefParcPower();
        $this->repartition->setReferenceYear($refYear);
        $this->repartition->setTargetYear($targetYear);
        $this->repartition->setReferenceParcPower($refParcPower);
        $this->repartition->setTargetParcPower($targetParcPower);
        $this->stopWatch->stop("init");
    }

    public function createTargetYearObject(HttpRequest $request = null)
    {
        $totalNuclear = $request->get("nuke") * 1000000;
        $totalPhoto = $request->get("photo") * 1000000;
        $totalEol = $request->get("eol") * 1000000;
        return new Year(2050, $totalNuclear, $totalEol, $totalPhoto, 0, 50000000, 0);
    }

     public function createRefYearObject()
     {
         return new Year(2011, 421000000, 12000000, 2000000, 0, 50000000, 0);
     }

    public function getContent()
    {
        $content = <<<EOF
{"simulation" :
   { "present-data":
     {
         "nucleaire": 50,
         "Photovoltaique" : 10,
         "Eolien" : 5,
         "Hydraulique" : 5,
         "Centrales flammes": 30,
         "STEP" : 0
     },
 "target-data":
     [
         {"name" : "nucleaire", "y": 35, "z": -15},
         {"name" : "Photovoltaique", "y": 15, "z":5},
{"name" : "Eolien","y": 15, "z":10},
{"name" : "Hydraulique","y": 5,"z":0},
{"name" : "Centrales a flammes","y": 30,"z":0},
{"name" : "STEP","y": 0,"z":0}
     ],
"series": [
       {
         "name": "Nucleaire",
         "data": [ 502, 635, 809, 947, 1402, 3634, 5268, 502, 635, 809, 947, 1402, 3634, 5268]
      },
      {  "name": "Photovoltaique",
         "data": [106, 107, 111, 133, 221, 767, 1766]
      },
      {  "name": "Eolien",
         "data": [163, 203, 276, 408, 547, 729, 628]
      },
      {  "name": "Hydraulique",
         "data": [18, 31, 54, 156, 339, 818, 1201]
      },
      {  "name": "Centrales flammes",
         "data": [2, 2, 2, 6, 13, 30, 46]
      },
      {  "name": "STEP",
         "data": [0, 0, 0, 0, 0, 0, 0]
      },
      {  "name": "Import",
         "data": [0, 0, 0, 0, 0, 0, 0]
      }
      ]
   }

}
EOF;
        return $content;

    }

    /**
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1
     * @DI\Inject("monmiel.transformers.v1.service")
     */
    public $transformers;

    /**
     * @var \Monmiel\MonmielApiBundle\Services\RepartitionService\RepartitionServiceV1 $repartition
     * @DI\Inject("monmiel.repartition.service")
     */
    public $repartition;

    /**
     * @var \Monmiel\MonmielApiBundle\Services\ParcService\ParcService $parc
     * @DI\Inject("monmiel.parc.service")
     */
    public $parc;

    /**
     * @DI\Inject("debug.stopwatch")
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @var \JMS\Serializer\Serializer $serializer
     * @DI\Inject("serializer")
     */
    public $serializer;
}
