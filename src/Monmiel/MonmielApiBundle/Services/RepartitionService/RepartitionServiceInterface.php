<?php

namespace Monmiel\MonmielApiBundle\Services\RepartitionService;

interface RepartitionServiceInterface
{
    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function get($day);
}
