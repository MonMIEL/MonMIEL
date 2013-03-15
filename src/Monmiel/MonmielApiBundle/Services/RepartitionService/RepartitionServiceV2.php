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
        $this->decision->storeInStepsOrExport($quarterMax);
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
        $quarter = $this->decision->getDecisionAndUpdatesQuarterDeficit($quarter, $consoTotal);
        $this->facilityService->submitFlamePower($quarter->getFlamme());
        return $quarter;
    }

    protected function initComputedYear()
    {
        $this->yearComputed = $this->targetYear;
        $this->yearComputed->setConsoTotalEolien(0);
        $this->yearComputed->setConsoTotalFlamme(0);
        $this->yearComputed->setConsoTotalHydraulique(0);
        $this->yearComputed->setConsoTotalNucleaire(0);
        $this->yearComputed->setConsoTotalPhotovoltaique(0);
        $this->yearComputed->setImportTotal(0);
        $this->yearComputed->setStepsTotal(0);
        $this->yearComputed->setExportTotal(0);
    }

    /**
     * Updating values with quarter
     * @param $quarter Quarter
     */
    protected function updateYearComputed($quarter, $coeff = 4)
    {
        //TODO updates
        $this->yearComputed->setConsoTotalEolien($quarter->getEolien() / $coeff + $this->yearComputed->getConsoTotalEolien());
        $this->yearComputed->setConsoTotalFlamme($quarter->getFlamme() / $coeff + $this->yearComputed->getConsoTotalFlamme());
        $this->yearComputed->setConsoTotalHydraulique($quarter->getHydraulique() / $coeff + $this->yearComputed->getConsoTotalHydraulique());
        $this->yearComputed->setConsoTotalNucleaire($quarter->getNucleaire() / $coeff + $this->yearComputed->getConsoTotalNucleaire());
        $this->yearComputed->setConsoTotalPhotovoltaique($quarter->getPhotovoltaique() / $coeff + $this->yearComputed->getConsoTotalPhotovoltaique());
        $this->yearComputed->setImportTotal($quarter->getImport() / $coeff + $this->yearComputed->getImportTotal());
        $this->yearComputed->setExportTotal($quarter->getExport() / $coeff + $this->yearComputed->getExportTotal());
        $this->yearComputed->setStepsTotal($quarter->getSteps() / $coeff + $this->yearComputed->getStepsTotal());
    }

    public function getComputedYear()
    {
        $this->yearComputed->setConsoTotalGlobale($this->yearComputed->getConsoTotalEolien() +
            $this->yearComputed->getConsoTotalFlamme() +
            $this->yearComputed->getConsoTotalHydraulique() +
            $this->yearComputed->getConsoTotalNucleaire() +
            $this->yearComputed->getConsoTotalPhotovoltaique() +
            $this->yearComputed->getImportTotal() +
            $this->yearComputed->getStepsTotal());
        return $this->yearComputed;
    }
}
