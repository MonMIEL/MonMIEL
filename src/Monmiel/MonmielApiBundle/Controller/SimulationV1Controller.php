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
//        $response->setContent($this->getContent());
        return $response;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function init(HttpRequest $request)
    {
        $userConsoMesure = new Mesure(478, 'GW');
        $actualConsoMesure = new Mesure(478, 'GW');

        $this->transformers->setConsoTotalActuel($actualConsoMesure);
        $this->transformers->setConsoTotalDefinedByUser($userConsoMesure);
        $this->transformers->setReferenceYear($this->createRefYearObject());
        $this->transformers->setTargetYear($this->createTargetYearObject($request));

        $targetParcPower = $this->parc->getPower($this->createTargetYearObject($request));
        $refParcPower = $this->parc->getPower($this->createRefYearObject());
        $this->repartition->setReferenceYear($this->createRefYearObject($request));
        $this->repartition->setTargetYear($this->createTargetYearObject($request));
        $this->repartition->setReferenceParcPower($refParcPower);
        $this->repartition->setTargetParcPower($targetParcPower);

        $result = new SimulationResultSeries();

        for ($i = 1; $i < 100; $i++) {
            $day = $this->repartition->get($i);
            $result->addDay($day);
        }
//        $finaParc = $this->parc->getSimulatedParc();
//        var_dump($finaParc);exit;
        $response = new Response();
        $json = json_encode($result->getSeries());
        $response->setContent($json);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->send();

    }

    public function createTargetYearObject(HttpRequest $request)
    {
//        return new AskUser(0, 151998661, 12, 1679207799, 124821812, 4966116, 0, 600000000, 4514598);
        return new Year(2050, 1679207799/4, 4514598/4, 4966116/4, 0/4, 151998661/4, 0);
    }

     public function createRefYearObject()
     {
         return new Year(2011, 1679207799/4, 4514598/4, 4966116/4, 0, 151998661/4, 0);
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
     * @var \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $parc
     * @DI\Inject("monmiel.facility.service")
     */
    public $parc;
}
