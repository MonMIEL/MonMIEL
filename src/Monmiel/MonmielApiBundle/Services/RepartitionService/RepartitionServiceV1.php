<?php

namespace Monmiel\MonmielApiBundle\Services\RepartitionService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;

/**
 * @DI\Service("monmiel.repartition.service")
 */
  class RepartitionServiceV1 implements RepartitionServiceInterface
{
    /**
     * @DI\Inject("monmiel.transformers.v1.service")
     * @var \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public $transformers;

    /**
     * @DI\Inject("monmiel.parc.service")
     * @var \Monmiel\MonmielApiBundle\Services\ParcService\ParcService $facilityService
     */
    public $facilityService;

    /**
     * @DI\Inject("debug.stopwatch", required=false)
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    public $stopWatch;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
     */
    protected $targetYear;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
     */
    protected $referenceYear;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
     */
    protected $targetParcPower;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Power $userParcPower
     */
    protected $referenceParcPower;

    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($day)
    {
        $referenceDay = $this->getReferenceDay($day);

        $ComputeDay = $this->computeMixedTargetDailyConsumption($referenceDay);
        return $ComputeDay;
    }

    /**
     * @var $yearComputed \Monmiel\MonmielApiModelBundle\Model\Year
     */
    protected $yearComputed;
    /**
     * @param $dayNumber integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function getReferenceDay($dayNumber)
    {
        return $this->transformers->get($dayNumber);
    }


    /**Public method for test, allow to pass a day directly in parameter without using database
     * @param $referenceDay Day
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function  computeMixedTargetDailyConsumption($referenceDay)
    {
        if(isset($this->stopWatch))
        {
            $this->stopWatch->start("computeDistribution", "repartition");
        }
        $referenceQuarters = $referenceDay->getQuarters();
        $userMixDay = new Day();

        /** @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarter */
        foreach ($referenceQuarters as $quarter) {

            $maxProductionQuarter = $this->computeMaxProductionPerEnergy($quarter);
            $computedQuarter=    $this->computeDistribution($maxProductionQuarter);
            $userMixDay->addQuarters($computedQuarter);

            $this->updateYearComputed($computedQuarter);
        }
        if(isset($this->stopWatch))
        {
            $this->stopWatch->stop("computeDistribution");
        }

        return $userMixDay;
    }


    /**
     * @param $quarterMax Quarter
     * @return Quarter
     */
    protected function computeDistribution($quarterMax)
    {
        $quarter = new Quarter($quarterMax->getDate());
        $consoTotal = $quarterMax->getConsoTotal();
        $consoTotal = $consoTotal - $quarterMax->getEolien();

        if ($consoTotal < 0) {
            $quarter->setEolien($quarterMax->getEolien() + $consoTotal);
            return $quarter;
        }
        $quarter->setEolien($quarterMax->getEolien());

        $consoTotal = $consoTotal - $quarterMax->getPhotovoltaique();
        if ($consoTotal < 0) {
            $quarter->setPhotovoltaique($quarterMax->getPhotovoltaique() + $consoTotal);
            return $quarter;
        }
        $quarter->setPhotovoltaique($quarterMax->getPhotovoltaique());

        $consoTotal = $consoTotal - $quarterMax->getHydraulique();
        if ($consoTotal < 0) {
            $quarter->setHydraulique($quarterMax->getHydraulique() + $consoTotal);
            return $quarter;
        }
        $quarter->setHydraulique($quarterMax->getHydraulique());

        $consoTotal = $consoTotal - $quarterMax->getNucleaire();
        if ($consoTotal <= 0) {
            $quarter->setNucleaire($quarterMax->getNucleaire() + $consoTotal);
            return $quarter;
        }
        $quarter->setNucleaire($quarterMax->getNucleaire());

        $quarter->setFlamme($consoTotal);
        $this->facilityService->submitFlamePower($quarter->getFlamme());

        return $quarter;
    }

    /**
     * Update a quarter with production capacity for target year
     * @param $quarter \Monmiel\MonmielApiModelBundle\Model\Quarter
     * @param $powerTargetYear \Monmiel\MonmielApiModelBundle\Model\Power
     * @param $powerReferencedYear \Monmiel\MonmielApiModelBundle\Model\Power
     * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
     */
    public function computeMaxProductionPerEnergy($quarter){

        $targetParcPower = $this->getTargetParcPower();
        $referenceParcPower = $this->getReferenceParcPower();
        $aeolianProductionCapacity = ($targetParcPower->getWind() == 0) ? 0 : ($targetParcPower->getWind() * $quarter->getEolien()) / $referenceParcPower->getWind();
        $photovoltaicProductionCapacity = ($targetParcPower->getPhotovoltaic() == 0) ? 0 : ($targetParcPower->getPhotovoltaic() * $quarter->getPhotovoltaique()) / $referenceParcPower->getPhotovoltaic();
        $nuclearProductionCapacity = ($targetParcPower->getNuclear());
//        $nuclearProductionCapacity = ($targetParcPower->getNuclear() * $quarter->getNucleaire()) / $referenceParcPower->getNuclear();
        $hydraulicProductionCapacity = ($quarter->getHydraulique());

        $maxProductionQuarter = new Quarter($quarter->getDate(), $quarter->getConsoTotal(), 0, 0, 0, 0, 0, 0, 0);
        $maxProductionQuarter->setEolien($aeolianProductionCapacity);
        $maxProductionQuarter->setPhotovoltaique($photovoltaicProductionCapacity);
        $maxProductionQuarter->setNucleaire($nuclearProductionCapacity);
        $maxProductionQuarter->setHydraulique($hydraulicProductionCapacity);

        return $maxProductionQuarter;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Year $referenceYear
     */
    public function setReferenceYear($referenceYear)
    {
        $this->referenceYear = clone $referenceYear;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Year
     */
    public function getReferenceYear()
    {
        return $this->referenceYear;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Power $targetParcPower
     */
    public function setTargetParcPower($targetParcPower)
    {
        $this->targetParcPower = clone $targetParcPower;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getTargetParcPower()
    {
        return $this->targetParcPower;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Year $targetYear
     */
    public function setTargetYear($targetYear)
    {
        $this->targetYear = clone $targetYear;
        $this->initComputedYear();
    }

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
    protected function updateYearComputed($quarter)
    {
       // echo "-------------------------------------------------------------------------------\n" .$this->yearComputed->toString();
        if($quarter->getInterval()>0){
            $coeff=(60/$quarter->getInterval());
        }
        else{
            $coeff=4;
        }
        $this->yearComputed->setNbInterval($this->yearComputed->getNbInterval()
                                           +($quarter->getInterval()/60));
        $this->yearComputed->setConsoTotalEolien(($quarter->getEolien()/$coeff)+$this->yearComputed->getConsoTotalEolien());
        $this->yearComputed->setConsoTotalFlamme(($quarter->getFlamme()/$coeff)+$this->yearComputed->getConsoTotalFlamme());
        $this->yearComputed->setConsoTotalHydraulique(($quarter->getHydraulique()/$coeff)+$this->yearComputed->getConsoTotalHydraulique());
        $this->yearComputed->setConsoTotalNucleaire(($quarter->getNucleaire()/$coeff)+$this->yearComputed->getConsoTotalNucleaire());
        $this->yearComputed->setConsoTotalPhotovoltaique(($quarter->getPhotovoltaique()/$coeff)+$this->yearComputed->getConsoTotalPhotovoltaique());
        $this->yearComputed->setConsoTotalGlobale(($this->yearComputed->getConsoTotalEolien())+$this->yearComputed->getConsoTotalFlamme()+
            $this->yearComputed->getConsoTotalHydraulique()+$this->yearComputed->getConsoTotalNucleaire()+$this->yearComputed->getConsoTotalPhotovoltaique());
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Year
     */
    public function getTargetYear()
    {
        return $this->targetYear;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Power $referenceParcPower
     */
    public function setReferenceParcPower($referenceParcPower)
    {
        $this->referenceParcPower = clone $referenceParcPower;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getReferenceParcPower()
    {
        return $this->referenceParcPower;
    }

    /**
     * @param \Monmiel\MonmielApiBundle\Services\ParcService\ParcService $facilityService
     */
    public function setFacilityService($facilityService)
    {
        $this->facilityService = $facilityService;
    }

    /**
     * @return \Monmiel\MonmielApiBundle\Services\ParcService\ParcService $facilityService
     */
    public function getFacilityService()
    {
        return $this->facilityService;
    }

    /**
     * @param \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1 $transformers
     */
    public function setTransformers($transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * @return \Monmiel\MonmielApiBundle\Services\TransformersService\TransformersV1
     */
    public function getTransformers()
    {
        return $this->transformers;
    }

    public function getComputedYear()
    {
        return $this->yearComputed;
    }
}
