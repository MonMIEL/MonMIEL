<?php

namespace Monmiel\MonmielApiBundle\Services\ParcService;

use Monmiel\MonmielApiModelBundle\Model\Quarter;

interface ParcServiceInterface
{
    /**
     * @param $flamePower float
     */
    public function submitFlamePower($flamePower);

    /**
     * @param $year \Monmiel\MonmielApiModelBundle\Model\Year
     * @param float $hourInterval
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPower($year, $hourInterval);

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getFinalPower();

    public function getSimulatedParc($year);
}
