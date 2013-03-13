<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;
use Monmiel\MonmielApiModelBundle\Model\Parc\Parc;
use Monmiel\MonmielApiModelBundle\Model\Year;

/**
 * @DI\Service("monmiel.facility.service")
 */
class ComputeFacilityService implements FacilityServiceInterface
{
    /**
     * @var $parc Parc
     */
    private $parc;

    public function submitQuarters($solde)
    {
        $this->parc=Parc::getInstance();
        if(isset($this->parc) && isset($solde)){
            //$parc->setMaxValue($quarter[0],$quarter[1],$quarter[2],$quarter[3],$quarter[4]);
            $this->parc->setMaxValueFlamme($solde);
        }
        else{
            throw new \Exception("Aucun objet parc existant. La méthode initParc() doit avoir été appelée au préalable");
        }
    }
    /*
     *
     */

    public function getSimulatedParc($year,$interval=8760)
    {
        $this->parc=Parc::getInstance();
        $this->parc->setPowerForEachEnergy($year,$interval);
        return $this->parc->getParc();
    }


    /**
     * @param $year Year
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */

    public function getPower($year,$interval=8760)
    {
        // return an object power calculated
        $parc=Parc::getInstance();
        $parc->setPowerForEachEnergy($year,$interval);
        return $parc->getPower();
    }

}
