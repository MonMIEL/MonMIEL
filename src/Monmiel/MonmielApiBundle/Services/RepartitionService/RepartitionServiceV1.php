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
     * @var \Monmiel\MonmielApiModelBundle\Model\Day
     */
    private $dayRetrieved;

    private $coeffToUseYarly; // for computing theoric consumption

    private $coeffPerEnergy= array(); //for each type of energy a specific value

    private $totalNuclearReferenceYear = 720;

    private $totalEolienReferenceYear = 133;

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

    private function  computeEstimateTedTargetDailyConsumption($dayNumber)

    {
        $this->getReferenceDay($dayNumber);

        $this->computeCoeffDailyMix();
        $coeffToUse = $this->coeffPerEnergy; //given


        //i retrieve a day
        $currentDay = $this->dayRetrieved;
        $current = $currentDay;
        $current->setQuarters(array());
        $currentDayQuarters = $currentDay->getgetQuarters();

        for ($j = 0; $j < sizeof($currentDayQuarters); $j++) {

            $currentQuarter = $currentDayQuarters[$j];
            $currentQuarter = $this->updateQuarter($currentQuarter, $coeffToUse);
            //call aurelien method
            array_push($current, $currentQuarter);
        }


        return current;

    }


    /**
     * @param $quarter
     * @param $coeff
     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    public function updateQuarter($quarter){
        $quarterUpdated = $quarter;

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

        return $this->computeEstimateTedTargetDailyConsumption($day);
    }



}
