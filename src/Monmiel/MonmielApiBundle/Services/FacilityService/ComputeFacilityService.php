<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;
use Monmiel\MonmielApiModelBundle\Model\Parc\Parc;

/**
 * @DI\Service("monmiel.facility.service")
 */
class ComputeFacilityService implements FacilityServiceInterface
{
    private $parc;
    /**
     * @param Quarter $quarter
     */

    public function initParc(){
        $p=Parc::getInstance();
        if(isset($p)){
            $this->parc=$p;
        }
    }

    public function submitQuarters($quarter)
    {
        $parc=Parc::getInstance();
        if(isset($parc) && isset($quarter)){
            $parc->setMax($quarter[0],$quarter[1],$quarter[2],$quarter[3],$quarter[4]);
            //$this->parc->setMax($quarter->getNucleaire(), $quarter->getEolien(), $quarter->getPhotovoltaique(), $quarter->getHydraulique(), $quarter->getAutre());
        }
        else{
            echo "Aucun objet parc existant. La méthode initParc() doit avoir été appelée au préalable";
        }
    }

    public function getSimulatedParc()
    {
        $parc=Parc::getInstance();
        $parcFinal=$parc->getParc(null);
        return $parcFinal;
    }
}
