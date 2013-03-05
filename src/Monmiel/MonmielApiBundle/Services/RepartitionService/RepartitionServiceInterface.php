<?php

namespace Monmiel\MonmielApiBundle\Services\FacilityService;

interface RepartitionServiceInterface
{
    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($day);
}
