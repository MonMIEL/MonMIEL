<?php

namespace Monmiel\MonmielApiBundle\Services\RepartitionService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;

/**
 * @DI\Service("monmiel.repartition.v2.service")
 */
class RepartitionServiceV2 extends RepartitionServiceV1 implements RepartitionServiceInterface
{
    /**
     * @DI\Inject("monmiel.transformers.v1.service")
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
//    public $transformers;
//
//    /**
//     * @DI\Inject("monmiel.facility.service")
//     * @var \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $facilityService
//     */
//    public $facilityService;
//
//    /**
//     * @DI\Inject("debug.stopwatch")
//     * @var \Symfony\Component\Stopwatch\Stopwatch
//     */
//    public $stopWatch;
//
//    /**
//     * @var \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
//     */
//    protected $targetYear;
//
//    /**
//     * @var \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
//     */
//    protected $referenceYear;
//
//    /**
//     * @var \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
//     */
//    protected $targetParcPower;
//
//    /**
//     * @var \Monmiel\MonmielApiModelBundle\Model\Power $userParcPower
//     */
//    protected $referenceParcPower;
//
//    /**
//     * @param $day integer
//     * @return \Monmiel\MonmielApiModelBundle\Model\Day
//     */
//    public function get($day)
//    {
//        $referenceDay = $this->getReferenceDay($day);
//        $ComputeDay = $this->computeMixedTargetDailyConsumption($referenceDay);
//        return $ComputeDay;
//    }
//
//    /**
//     * @var $yearComputed \Monmiel\MonmielApiModelBundle\Model\Year
//     */
//    protected $yearComputed;
//    /**
//     * @param $dayNumber integer
//     * @return \Monmiel\MonmielApiModelBundle\Model\Day
//     */
//    public function getReferenceDay($dayNumber)
//    {
//        return $this->transformers->get($dayNumber);
//    }
//
//
//    /**Public method for test, allow to pass a day directly in parameter without using database
//     * @param $referenceDay Day
//     * @return \Monmiel\MonmielApiModelBundle\Model\Day
//     */
//    public function  computeMixedTargetDailyConsumption($referenceDay)
//    {
//
//        $this->stopWatch->start("computeDistribution", "repartition");
//        $referenceQuarters = $referenceDay->getQuarters();
//        $userMixDay = new Day();
//
//        /** @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarter */
//        foreach ($referenceQuarters as $quarter) {
//
//            $maxProductionQuarter = $this->computeMaxProductionPerEnergy($quarter);
//            $computedQuarter=    $this->computeDistribution($maxProductionQuarter);
//            $userMixDay->addQuarters($computedQuarter);
//
//            $this->updateYearComputed($computedQuarter);
//        }
//        $this->stopWatch->stowxxp("computeDistribution");
//        return $userMixDay;
//    }


    /**
     * @param $quarter Quarter
     * @return Quarter
     */
    protected function computeDistribution($quarter)
    {
        $consoTotal = $quarter->getConsoTotal();
        $consoTotal = $consoTotal - $quarter->getEolien();

        if ($consoTotal < 0) {
            $quarter->setEolien($quarter->getEolien() + $consoTotal);
            return $quarter;
        }

        $consoTotal = $consoTotal - $quarter->getPhotovoltaique();
        if ($consoTotal < 0) {
            $quarter->setPhotovoltaique($quarter->getPhotovoltaique() + $consoTotal);
            return $quarter;
        }

        $consoTotal = $consoTotal - $quarter->getHydraulique();
        if ($consoTotal < 0) {
            $quarter->setHydraulique($quarter->getHydraulique() + $consoTotal);
            return $quarter;
        }

        $consoTotal = $consoTotal - $quarter->getNucleaire();
        if ($consoTotal <= 0) {
            $quarter->setNucleaire($quarter->getNucleaire() + $consoTotal);
            return $quarter;
        }

//        $quarter->setFlamme($consoTotal);
//        $this->facilityService->submitQuarters($quarter->getFlamme());


        return DecisionSelector::getDecisionAndUpdatesQuarter($quarter,$consoTotal);;
    }

//    /**
//     * Update a quarter with production capacity for target year
//     * @param $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
//     * @param $powerTargetYear \Monmiel\MonmielApiModelBundle\Model\Power
//     * @param $powerReferencedYear \Monmiel\MonmielApiModelBundle\Model\Power
//     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
//     */
//    public function computeMaxProductionPerEnergy($quarter){
//
//        $targetParcPower = $this->getTargetParcPower();
//        $referenceParcPower = $this->getReferenceParcPower();
//        $aeolianProductionCapacity = ($targetParcPower->getWind() == 0) ? 0 : ($targetParcPower->getWind() * $quarter->getEolien()) / $referenceParcPower->getWind();
//        $photovoltaicProductionCapacity = ($targetParcPower->getPhotovoltaic() == 0) ? 0 : ($targetParcPower->getPhotovoltaic() * $quarter->getPhotovoltaique()) / $referenceParcPower->getPhotovoltaic();
//
//        $nuclearProductionCapacity = ($targetParcPower->getNuclear());
//        $hydraulicProductionCapacity = ($targetParcPower->getHydraulic());
//
//        $maxProductionQuarter = new Quarter($quarter->getDate(), $quarter->getConsoTotal(), 0, 0, 0, 0, 0, 0, 0);
//        $maxProductionQuarter->setEolien($aeolianProductionCapacity);
//        $maxProductionQuarter->setPhotovoltaique($photovoltaicProductionCapacity);
//        $maxProductionQuarter->setNucleaire($nuclearProductionCapacity);
//        $maxProductionQuarter->setHydraulique($hydraulicProductionCapacity);
//
//        return $maxProductionQuarter;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiModelBundle\Model\Year $referenceYear
//     */
//    public function setReferenceYear($referenceYear)
//    {
//        $this->referenceYear = $referenceYear;
//    }
//
//    /**
//     * @return \Monmiel\MonmielApiModelBundle\Model\Year
//     */
//    public function getReferenceYear()
//    {
//        return $this->referenceYear;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
//     */
//    public function setTargetParcPower($targetParcPower)
//    {
//        $this->targetParcPower = $targetParcPower;
//    }
//
//    /**
//     * @return \Monmiel\MonmielApiModelBundle\Model\Power
//     */
//    public function getTargetParcPower()
//    {
//        return $this->targetParcPower;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
//     */
//    public function setTargetYear($targetYear)
//    {
//        $this->targetYear = $targetYear;
//        $this->initComputedYear();
//    }

    /**
     *Resetting values
      */
    protected function initComputedYear()
{
    $this->yearComputed=$this->targetYear;
       $this->yearComputed->setConsoTotalEolien(0);
    $this->yearComputed->setConsoTotalFlamme(0);
    $this->yearComputed->setConsoTotalHydraulique(0);
    $this->yearComputed->setConsoTotalNucleaire(0);
    $this->yearComputed->setConsoTotalPhotovoltaique(0);

}

    /**
     * Updating values with quarter
     * @param $quarter Quarter
     */
    protected function updateYearComputed($quarter,$coeff = 4)
    {
        //TODO updates

        $this->yearComputed->setConsoTotalEolien($quarter->getEolien()/$coeff+$this->yearComputed->getConsoTotalEolien());
        $this->yearComputed->setConsoTotalFlamme($quarter->getFlamme()/$coeff+$this->yearComputed->getConsoTotalFlamme());
        $this->yearComputed->setConsoTotalHydraulique($quarter->getHydraulique()/$coeff+$this->yearComputed->getConsoTotalHydraulique());
        $this->yearComputed->setConsoTotalNucleaire($quarter->getNucleaire()/$coeff+$this->yearComputed->getConsoTotalNucleaire());
        $this->yearComputed->setConsoTotalPhotovoltaique($quarter->getPhotovoltaique()/$coeff+$this->yearComputed->getConsoTotalPhotovoltaique());

    }

//    /**
//     * @return \Monmiel\MonmielApiModelBundle\Model\Year
//     */
//    public function getTargetYear()
//    {
//        return $this->targetYear;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiModelBundle\Model\Power $referenceParcPower
//     */
//    public function setReferenceParcPower($referenceParcPower)
//    {
//        $this->referenceParcPower = $referenceParcPower;
//    }
//
//    /**
//     * @return \Monmiel\MonmielApiModelBundle\Model\Power
//     */
//    public function getReferenceParcPower()
//    {
//        return $this->referenceParcPower;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $facilityService
//     */
//    public function setFacilityService($facilityService)
//    {
//        $this->facilityService = $facilityService;
//    }
//
//    /**
//     * @return \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService
//     */
//    public function getFacilityService()
//    {
//        return $this->facilityService;
//    }
//
//    /**
//     * @param \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
//     */
//    public function setTransformers($transformers)
//    {
//        $this->transformers = $transformers;
//    }
//
//    /**
//     * @return \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1
//     */
//    public function getTransformers()
//    {
//        return $this->transformers;
//    }

    public function getComputedYear()
    {
        $this->yearComputed->setConsoTotalGlobale($this->yearComputed->getConsoTotalEolien()+$this->yearComputed->getConsoTotalFlamme()+
            $this->yearComputed->getConsoTotalHydraulique()+$this->yearComputed->getConsoTotalNucleaire()+$this->yearComputed->getConsoTotalPhotovoltaique());

        return $this->yearComputed;
    }
}