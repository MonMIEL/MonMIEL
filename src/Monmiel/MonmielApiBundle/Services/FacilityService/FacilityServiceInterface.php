<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

use Monmiel\MonmielApiModelBundle\Model\Quarter;

interface FacilityServiceInterface
{
    /**
     * @param Quarter $quarter
     */
    public function submitQuarters($quarter);

    /**
     * @return
     */
    public function getSimulatedParc();
}
