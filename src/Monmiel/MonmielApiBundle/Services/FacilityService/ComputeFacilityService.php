<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;

/**
 * @DI\Service("monmiel.facility.service")
 */
class ComputeFacilityService implements FacilityServiceInterface
{
    /**
     * @param Quarter $quarter
     */
    public function submitQuarters($quarter)
    {
        // TODO: Implement submitQuarters() method.
    }

    /**
     * @return
     */
    public function getSimulatedParc()
    {
        // TODO: Implement getSimulatedParc() method.
    }
}
