<?php

namespace Monmiel\MonmielApiBundle\Services\RepartitionService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;
use Monmiel\MonmielApiModelBundle\Model\Mesure;

/**
 * @DI\Service("monmiel.repartition.service")
 */
class RepartitionServiceV1 implements RepartitionServiceInterface
{
public   $nb=0;

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

    private $coeffToUseYarly; // for computing theoric consumption

    private $coeffPerEnergy; //for each type of energy a specific value


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

    /**
     * @param $dayNumber integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function getReferenceDay($dayNumber)
    {
        return $this->transformers->get($dayNumber);
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
        $this->transformers->setConsoActuel(new Mesure(700));
        $this->transformers->setConsoTotalDefinedByUser(new Mesure(800));
        $dayRetrieved = $this->getReferenceDay($dayNumber);

        $this->computeCoeffDailyMix(); //to do once
        $coeffToUse = $this->coeffPerEnergy; //given


        //i retrieve a day
        $currentDayQuarters = $dayRetrieved->getQuarters();
        $computedDayQuarters = array();

        /** @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarter */
        foreach ($currentDayQuarters as $quarter) {
            $computedQuarter = $this->updateQuarter($quarter);
            $computedDayQuarters[] = $computedQuarter;
            $this->facilityService->submitQuarters($computedQuarter); //callback to parc method
        }

        $dayRetrieved->setQuarters($computedDayQuarters);
        return $dayRetrieved;
    }

    /**
     * Updates quarter with values for each coefficient
     * @param $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    public function updateQuarter($quarter){

        $oldConsoNuclear = $quarter->getNucleaire();
        $coeffNucleaire = $this->coeffPerEnergy["nuclear"];
        $quarter->setNucleaire($coeffNucleaire * $oldConsoNuclear);

        $oldConsoEolien = $quarter->getEolien();
        $coeffEolien = $this->coeffPerEnergy["eolian"];
        $quarter->setEolien($coeffEolien * $oldConsoEolien);

        $oldConsoHydraulique = $quarter->getHydraulique();
        $coeffHydraulique = $this->coeffPerEnergy["hydraulic"];
        $quarter->setHydraulique($coeffHydraulique * $oldConsoHydraulique);

        $oldConsoPhotovoltaique = $quarter->getPhotovoltaique();
        $coeffPhotovoltaique = $this->coeffPerEnergy["photovoltaic"];
        $quarter->setPhotovoltaique($coeffPhotovoltaique * $oldConsoPhotovoltaique);

        $flammeValue = $quarter->getConsoTotal()-($coeffPhotovoltaique * $oldConsoPhotovoltaique+$coeffHydraulique * $oldConsoHydraulique+$coeffEolien * $oldConsoEolien+$coeffNucleaire * $oldConsoNuclear);
        $quarter->setFlamme($flammeValue); //updating ajustment value;

        return $quarter;
    }


    private function computeCoeffDailyMix(){
        $coeffNuclear = $this->totalNuclearTargetYear / $this->totalNuclearReferenceYear;
        $coeffEolien = $this->totalEolienTargetYear / $this->totalEolienReferenceYear;
        $coeffHydraulique = $this->totalHydraulicTargeteYear / $this->totalHydraulicReferenceYear;
        $coeffPhotovoltaique = $this->totalPhotovoltaiqueTargetYear / $this->totalPhotovoltaiqueReferenceYear;

        $coeffArray = array(
            "nuclear" => $coeffNuclear,
            "eolian" => $coeffEolien,
            "hydraulic" => $coeffHydraulique,
            "photovoltaic" => $coeffPhotovoltaique
        );

        $this->coeffPerEnergy = $coeffArray;
    }

    /**
     * Compute the production capacity quarter by quarter for target year
     * @param $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    private function computeProductionCapacity($quarter){
        

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
