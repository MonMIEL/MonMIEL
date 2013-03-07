<?php

namespace Monmiel\MonmielApiBundle\Services\TransformersService;

interface TransformersServiceInterfaceV1
{
    /**
     * @param $day integer
     * @return \Monmiel\MonmielApiModelBundle\Model\Day $day
     */
    public function get($day);

    /**
     * update the conso total for the Quarters of the Day in parameter with the actual conso and the input Coson
     * @param $day \Monmiel\MonmielApiModelBundle\Model\Day
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function updateConsoTotalQuartersForDayByConsoTotalActualAndConsoDefineByUser($day, $actualConso, $inputConso);


    /**
     * get the Day with the Quarters updated by Day Id,actual conso and the input Conso
     * @param $dayId integer
     * @param $actualConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @param $inputConso \Monmiel\MonmielApiModelBundle\Model\Mesure
     * @return \Monmiel\MonmielApiModelBundle\Model\Day
     */
    public function updateConsoQuartersByDayIdAndConsoTotalActuelAndConsoDefineByUser($dayId, $actualConso, $inputConso);


    /**
     *  Get the power of each type energy for reference year
     * @return  \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPowerRef();

    /**
     *  Get the power of each type energy for target year
     * @return \Monmiel\MonmielApiModelBundle\Model\Power
     */
    public function getPowerTarget();


}
