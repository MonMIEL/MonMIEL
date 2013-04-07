<?php

namespace Monmiel\MonmielApiBundle\Controller;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Mesure;
use Monmiel\MonmielApiModelBundle\Model\Response\SimulationResultSeries;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response;

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
        $this->init($request);

        $result = new SimulationResultSeries();
        for ($i = 1; $i < 363; $i++) {
            $day = $this->repartition->get($i);
            $result->addDay($day);
        }
        $targetYear = $this->createTargetYearObject($request);
        $computedYear = $this->repartition->getComputedYear();

        $parc = $this->parc->getTargetParcPower();
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
     * Initialisation de la simulation
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function init(HttpRequest $request = null)
    {
        $this->stopWatch->start("init", "controller");
        /**
         * On renseigne le service transformers, des la consommation total en 2011 (531 TwH)
         * et celle qu'a rentré l'utilisateur.
         */
        $actualConsoMesure = new Mesure(531, \Monmiel\Utils\ConstantUtils::TERAWATT_HOUR);
        $userConsoMesure = new Mesure($request->get("targetConso"), \Monmiel\Utils\ConstantUtils::TERAWATT_HOUR);
        $this->transformers->setConsoTotalActuel($actualConsoMesure);
        $this->transformers->setConsoTotalDefinedByUser($userConsoMesure);

        /**
         * On crée l'objet Year de référence, seulement 2011 actuellement.
         * On crée l'objet Year que l'utilisateur souhaite atteindre, tout cela à partir de la request.
         * Et on renseigne le tout au service transformers.
         */
        $refYear = $this->createRefYearObject();
        $targetYear = $this->createTargetYearObject($request);
        $this->transformers->setReferenceYear($refYear);
        $this->transformers->setTargetYear($targetYear);

        /**
         * On demande au service de Parc de calculer le parc de référence et celui qu'on vise à partir de nos
         * deux objets Year.
         */
        $this->parc->setRefParcPower($refYear);
        $this->parc->setTargetParcPower($targetYear);
        $targetParcPower = $this->parc->getTargetParcPower();
        $refParcPower = $this->parc->getRefParcPower();

        /**
         * On renseigne au service repartition les parcs calculés et les objets Years.
         */
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
        $totalHydro = $request->get("hydro") * 1000000;
        return new Year(2050, $totalNuclear, $totalEol, $totalPhoto, 0, $totalHydro, 0);
    }

     public function createRefYearObject()
     {
         return new Year(2011, 419801949, 11253649, 2000000, 0, 38000000, 0);
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
