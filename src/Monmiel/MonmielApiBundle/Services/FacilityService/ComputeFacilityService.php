<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use JMS\DiExtraBundle\Annotation as DI;
use Monmiel\MonmielApiModelBundle\Event\NewDayEvent;

/**
 * @DI\Service("monmiel.facility.service")
 */
class ComputeFacilityService
{
    function __construct()
    {
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Event\NewDayEvent $event
     * @DI\Observe("monmiel.new.simulated.day")
     */
    public function computeFacilities($event)
    {
        $day = $event->getDay();

    }

}
