<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

interface TransformersInterface
{
    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day $day
     */
    public function get($day);

    /**
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function UpdateConsoTotal($day);

}
