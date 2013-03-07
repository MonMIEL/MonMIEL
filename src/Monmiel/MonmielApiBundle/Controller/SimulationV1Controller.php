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
        $response->setContent($this->getContent());
        return $response;
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
}
