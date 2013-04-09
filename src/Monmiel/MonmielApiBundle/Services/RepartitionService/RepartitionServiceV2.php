<?php
namespace Monmiel\MonmielApiBundle\Services\RepartitionService;
use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Model\Day;
use Monmiel\MonmielApiModelBundle\Model\Quarter;
use Monmiel\MonmielApiBundle\Services\RepartitionService\DecisionSelector;

/**
 * @DI\Service("monmiel.repartition.v2.service")
 */
class RepartitionServiceV2 extends RepartitionServiceV1 implements RepartitionServiceInterface
{
    /**
     * @DI\Inject("monmiel.repartition.decision.service")
     * @var DecisionSelector $decision
     */
    public $decision;

    /**
     * @param $quarter Quarter
     * @return Quarter
     */
    protected function computeDistribution($quarterMax)
    {
//        $this->decision->storeInStepsOrExport($quarterMax);
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

        $quarter = $this->decision->getDecisionAndUpdatesQuarterDeficit($quarter, $consoTotal);
        $this->facilityService->submitFlamePower($quarter->getFlamme());
        $this->facilityService->submitImportPower($quarter->getImport());
        return $quarter;
    }

    protected function initComputedYear()
    {
        parent::initComputedYear();
        $this->yearComputed->setConsoTotalImport(0);
        $this->yearComputed->setConsoTotalSteps(0);
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
        $this->yearComputed->setConsoTotalImport($quarter->getImport() / $coeff + $this->yearComputed->getConsoTotalImport());
        $this->yearComputed->setConsoTotalSteps($quarter->getSteps() / $coeff + $this->yearComputed->getConsoTotalSteps());
    }
}
