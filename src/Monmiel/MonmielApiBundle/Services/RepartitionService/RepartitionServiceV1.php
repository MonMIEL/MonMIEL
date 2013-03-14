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
     * @DI\Inject("debug.stopwatch")
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

        $this->stopWatch->start("computeDistribution", "repartition");
        $referenceQuarters = $referenceDay->getQuarters();
        $userMixDay = new Day();

        /** @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarter */
        foreach ($referenceQuarters as $quarter) {

            $maxProductionQuarter = $this->computeMaxProductionPerEnergy($quarter);
            $computedQuarter=    $this->computeDistribution($maxProductionQuarter);
            $userMixDay->addQuarters($computedQuarter);
          //  echo "Fin .....................................................................";
        //    var_dump($computedQuarter);

            //exit;

            $this->updateYearComputed($computedQuarter);


        }
        $this->stopWatch->stop("computeDistribution");
        return $userMixDay;
    }
      /**
       * @param $quarter
       * @return \Monmiel\MonmielApiModelBundle\Model\Quarter
       */
      private function cloneAndReset($quarter)
      {
          /**
           * @var \Monmiel\MonmielApiModelBundle\Model\Quarter $quarterNew
           */
          $quarterNew = new Quarter($quarter->getDate(), $quarter->getConsoTotal(), 0, 0, 0, 0, 0, 0, 0);


          return $quarterNew;


      }

    /**
     * @param $quarterMax Quarter
     * @return Quarter
     */
    protected function computeDistribution($quarterMax)
    {
<<<<<<< HEAD
        /**
         *@var Quarter
          */
       $result=$this->cloneAndReset($quarter);//clone $quarter;
        $result->setEolien(50);

        $consoTotal = $quarter->getConsoTotal();
        $consoTotal = $consoTotal - $quarter->getEolien();

        if ($consoTotal <= 0) {



            $result->setEolien((int)$quarter->getEolien() + $consoTotal);

          //    $result->setEolien($quarter->getEolien());
            return $result;
=======
        $quarter = new Quarter($quarterMax->getDate());
        $consoTotal = $quarterMax->getConsoTotal();
        $consoTotal = $consoTotal - $quarterMax->getEolien();

        if ($consoTotal < 0) {
            $quarter->setEolien($quarterMax->getEolien() + $consoTotal);
            return $quarter;
>>>>>>> bce6b6c1956b6bfe7dda39c4bc8a0d3449566273
        }
        $quarter->setEolien($quarterMax->getEolien());

<<<<<<< HEAD
        $result->setEolien($quarter->getEolien());

   //     echo "\n";
        $result->setPhotovoltaique(51);
        $consoTotal = $consoTotal - $quarter->getPhotovoltaique();
        if ($consoTotal <= 0) {
            $result->setPhotovoltaique((int)$quarter->getPhotovoltaique() + $consoTotal);

            return $result;
=======
        $consoTotal = $consoTotal - $quarterMax->getPhotovoltaique();
        if ($consoTotal < 0) {
            $quarter->setPhotovoltaique($quarterMax->getPhotovoltaique() + $consoTotal);
            return $quarter;
>>>>>>> bce6b6c1956b6bfe7dda39c4bc8a0d3449566273
        }
        $quarter->setPhotovoltaique($quarterMax->getPhotovoltaique());

<<<<<<< HEAD
        $result->setHydraulique(52);
        $result->setPhotovoltaique($quarter->getPhotovoltaique());
        $consoTotal = $consoTotal - $quarter->getHydraulique();
        if ($consoTotal < 0) {
            $result->setHydraulique((int)$quarter->getHydraulique() + $consoTotal);
            return $result;
        }
        $result->setHydraulique($quarter->getHydraulique());
        $result->setNucleaire(53);
        $consoTotal = $consoTotal - $quarter->getNucleaire();
        if ($consoTotal <= 0) {
            $result->setNucleaire((int) $quarter->getNucleaire() + $consoTotal);
            return $result;
=======
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
>>>>>>> bce6b6c1956b6bfe7dda39c4bc8a0d3449566273
        }
        $quarter->setNucleaire($quarterMax->getNucleaire());

<<<<<<< HEAD
        $result->setNucleaire($quarter->getNucleaire());
        $result->setFlamme(0);
        $result->setFlamme( $consoTotal);
      // echo "dddddddddddddddd" . $consoTotal;
    //    $result->setFlamme($quarter->getFlamme());
        $this->facilityService->submitQuarters($quarter->getFlamme());
=======
        $quarter->setFlamme($consoTotal);
        $this->facilityService->submitFlamePower($quarter->getFlamme());
>>>>>>> bce6b6c1956b6bfe7dda39c4bc8a0d3449566273

//       var_dump($result);
//        exit;

        return $result;
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
        $hydraulicProductionCapacity = ($targetParcPower->getHydraulic());

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
    protected function updateYearComputed($quarter,$coeff = 4)
    {
<<<<<<< HEAD
      //  echo "-------------------------------------------------------------------------------\n" .$this->yearComputed->toString();
=======
       // echo "-------------------------------------------------------------------------------\n" .$this->yearComputed->toString();
>>>>>>> bce6b6c1956b6bfe7dda39c4bc8a0d3449566273


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
     * @param \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService $facilityService
     */
    public function setFacilityService($facilityService)
    {
        $this->facilityService = $facilityService;
    }

    /**
     * @return \Monmiel\MonmielApiBundle\Services\FacilityService\ComputeFacilityService
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
