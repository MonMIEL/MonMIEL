<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;
use \Monmiel\MonmielApiModelBundle\Model\Year;
interface TransformerServiceInterface
{
    /**
     * @return Year
     */
    public function  getConsoTotalForYearReference();//en megawattheure

    /**
     * @return Year
     */
    public function getConsoTotalForYearTarget();//en megawattheure
}
