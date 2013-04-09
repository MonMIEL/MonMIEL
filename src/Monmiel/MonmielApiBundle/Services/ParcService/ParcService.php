<?php

namespace Monmiel\MonmielApiBundle\Services\ParcService;

use JMS\DiExtraBundle\Annotation as DI;

use Monmiel\MonmielApiBundle\Services\ParcService\ParcServiceInterface;
use Monmiel\MonmielApiModelBundle\Model\Year;
use Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc;
use Monmiel\MonmielApiModelBundle\Model\Power;

/**
 * @DI\Service("monmiel.parc.service")
 */
class ParcService implements ParcServiceInterface
{

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc $refParcPower
     */
    protected $refParcPower;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc $targetParcPower
     */
    protected $targetParcPower;

    /**
     * @var \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc $finalParcPower
     */
    protected $finalParcPower;

    /**
     * @param $flamePower float
     */
    public function submitFlamePower($flamePower)
    {
        $this->finalParcPower->submitFlamePower($flamePower);
    }

    public function submitImportPower($importPower)
    {
        $this->finalParcPower->submitImportPower($importPower);
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\Year $year
     * @param float $hourInterval
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPower($year, $hourInterval)
    {
        $nuclear = $year->getConsoTotalNucleaire() / $hourInterval;
        $eolien = $year->getConsoTotalEolien() / $hourInterval;
        $photovoltaic = $year->getConsoTotalEolien() / $hourInterval;
        $hydraulic = $year->getConsoTotalHydraulique() / $hourInterval;
        $flamme = $year->getConsoTotalFlamme() / $hourInterval;
        $import = 0;
        $step = 0;
        $other = 0;

        return new Power($flamme, $hydraulic, $import, $nuclear, $other,$photovoltaic, $step, $eolien);
    }

    public function getSimulatedParc($year)
    {
        // TODO: Implement getSimulatedParc() method.
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getFinalPower()
    {
        return $this->finalParcPower->getPower();
    }

    /**
     * @param $year Year
     * @param $interval float
     */
    public function setRefParcPower($year, $interval = 8760)
    {
        $power = $this->getPower($year, $interval);
        $nuclearPercent = $power->getNuclear()/$power->getTotal();
        $this->refParcPower = new GlobalParc($power, $nuclearPercent);
    }

    /**
     * @param $year Year
     * @param $interval float
     */
    public function setTargetParcPower($year, $interval = 8760)
    {
        $power = $this->getPower($year, $interval);
        $nuclearPercent = $power->getNuclear()/$power->getTotal();
        $this->targetParcPower = new GlobalParc($power, $nuclearPercent);
        $this->finalParcPower = new GlobalParc($power, $nuclearPercent);
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getRefParcPower()
    {
        return $this->refParcPower->getPower();
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getTargetParcPower()
    {
        return $this->targetParcPower->getPower();
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Parc\GlobalParc
     */
    public function getFinalParcPower()
    {
        return $this->finalParcPower;
    }

}
