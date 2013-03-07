<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;
use \Monmiel\MonmielApiModelBundle\Model\Year;
interface TransformerServiceInterface
{
    /**
     * get the total consummation for the different Energy for year reference, eg conso 2011
     * @return Year
     */
    public function  getConsoTotalForYearReference();

    /**
     *get the total consummation for the different Energy for year target, eg conso 2050
     * @return Year
     */
    public function getConsoTotalForYearTarget();
}
