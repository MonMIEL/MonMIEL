<?php

namespace Monmiel\MonmielApiBundle\Services\RepartitionService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;

/**
 * @DI\Service("monmiel.repartition.service")
 */
class RepartitionServiceV1 implements RepartitionServiceInterface
{


    /**
     * @DI\Inject("monmiel.transformers.service")
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public $transformers;

        /**
     * @DI\Inject("monmiel.facility.service")
     * @var \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $facilityService
     */
    public $facilityService;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Day
     */
    private $dayRetrieved;

    private $coeffToUseYarly; // for computing theoric consumption

    private $coeffPerEnergy= array(); //for each type of energy a specific value


    /**
     * Toutes ces informations sont fournies par ?
     *
     */
    private $totalNuclearReferenceYear = 720;  //data given

    private $totalEolienReferenceYear = 133; //data given

    private $totalHydraulicReferenceYear = 120;

    private $totalPhotovoltaiqueReferenceYear = 117;

    private $totalNuclearTargetYear = 770;

    private $totalEolienTargetYear = 168;

    private $totalHydraulicTargeteYear = 140;

    private $totalPhotovoltaiqueTargetYear = 182;


    public function getReferenceDay($dayNumber)
    {
        $this->dayRetrieved = $this->transformers->get($dayNumber);
    }


    /**
     * Computes and updates a day value using
     * same repartition as reference year
     * @param $dayNumber
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */

 /*   private function  computeEstimateTedTargetDailyConsumption($dayNumber)

    {

        //TO UNDO
        $this->getReferenceDay($dayNumber);


        $coeffToUse =  2;//given


        //i retrieve a day
        $currentDay = $this->dayRetrieved;
        $current = $currentDay;
        $current->setQuarters(array());
        $currentDayQuarters = $currentDay->getgetQuarters();

        for ($j = 0; $j < sizeof($currentDayQuarters); $j++) {

            $currentQuarter = $currentDayQuarters[$j];
            $currentQuarter = $currentQuarter->coeffMulitiplication($coeffToUse); //$this->updateQuarter($currentQuarter, $coeffToUse);



            array_push($current->getQuarters(), $currentQuarter);
        }


        return current;

    }*/
    private function  computeMixedTargetDailyConsumption($dayNumber)

    {
        $this->getReferenceDay($dayNumber);

        $this->computeCoeffDailyMix(); //to do once
        $coeffToUse = $this->coeffPerEnergy; //given


        //i retrieve a day
        $currentDay = $this->dayRetrieved;
        $current = $currentDay;
        $current->setQuarters(array());
        $currentDayQuarters = $currentDay->getgetQuarters();

        for ($j = 0; $j < sizeof($currentDayQuarters); $j++) {

            $currentQuarter = $currentDayQuarters[$j];
            $currentQuarter = $this->updateQuarter($currentQuarter);
            $this->facilityService->submitQuarters($currentQuarter); //callback to facility service for each quarter
            array_push($current->getQuarters(), $currentQuarter);
        }


        return current;

    }

    /**
     * Updates quarter with values for each coefficient
     * @param $quarter
     * @param $coeff
     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    public function updateQuarter($quarter){
        /**
         * @var \Monmiel\MonmielApiModelBundle\Model\Quarter
         */
        $quarterUpdated  = $quarter;

        $oldConsoNuclear = $quarter->getNucleaire();
        $coeffNucleaire = $this->coeffPerEnergy[0];
        $quarterUpdated->setNucleaire($coeffNucleaire * $oldConsoNuclear);

        $oldConsoEolien = $quarter->getEolien();
        $coeffEolien = $this->coeffPerEnergy[1];
        $quarterUpdated->setEolien($coeffEolien * $oldConsoEolien);

        $oldConsoHydraulique = $quarter->getHydraulique();
        $coeffHydraulique = $this->coeffPerEnergy[2];
        $quarterUpdated->setHydraulique($coeffHydraulique * $oldConsoHydraulique);

        $oldConsoPhotovoltaique = $quarter->getPhotovoltaique();
        $coeffPhotovoltaique = $this->coeffPerEnergy[3];
        $quarterUpdated->setPhotovoltaique($coeffPhotovoltaique * $oldConsoPhotovoltaique);

        $flammeValue=$quarterUpdated->getTotal()-($coeffPhotovoltaique * $oldConsoPhotovoltaique+$coeffHydraulique * $oldConsoHydraulique+$coeffEolien * $oldConsoEolien+$coeffNucleaire * $oldConsoNuclear);
        $quarterUpdated->setFlamme($flammeValue); //updating ajustment value;

        return quarterUpdated;
    }


    private function computeCoeffDailyMix(){
        $coeffNuclear = $this->totalNuclearTargetYear / $this->totalNuclearReferenceYear;
        $coeffEolien = $this->totalEolienTargetYear / $this->totalEolienReferenceYear;
        $coeffHydraulique = $this->totalHydraulicTargeteYear / $this->totalHydraulicReferenceYear;
        $coeffPhotovoltaique = $this->totalPhotovoltaiqueTargetYear / $this->totalPhotovoltaiqueReferenceYear;

        array_push($this->coeffPerEnergy,$coeffNuclear);
        array_push($this->coeffPerEnergy,$coeffEolien);
        array_push($this->coeffPerEnergy,$coeffHydraulique);
        array_push($this->coeffPerEnergy,$coeffPhotovoltaique);
    }

    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($day)
    {

        return $this->computeMixedTargetDailyConsumption($day);
    }



}
