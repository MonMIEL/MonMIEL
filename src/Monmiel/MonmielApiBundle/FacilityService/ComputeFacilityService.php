<?php

namespace Monmiel\MonmielApiBundle\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("monmiel.facility")
 */
class ComputeFacilityService
{

    /**
     * @DI\Observe("monmiel.new.simulated.day")
     */
    public function computeFacilities($event)
    {

    }

}
