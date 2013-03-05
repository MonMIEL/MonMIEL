<?php

namespace Monmiel\MonmielApiModelBundle\Model;
/**
 * Created by JetBrains PhpStorm.
 * User: patrice
 * Date: 05/03/13
 * Time: 09:26
 */
class Mesure
{
    /**
     * the quantity of the mesure
     * @var float
     */
    protected $value;

    /**
     * the unity of mesure
     * @var \Monmiel\MonmielApiModelBundle\Model\UnitOfMesure>
     */
    protected $unitOfMesure;


    function __construct($value, $unitOfMesure)
    {
        $this->unitOfMesure = $unitOfMesure;
        $this->value = $value;
    }

    /**
     * @param \Monmiel\MonmielApiModelBundle\Model\UnitOfMesure $unitOfMesure
     */
    public function setUnitOfMesure($unitOfMesure)
    {
        $this->unitOfMesure = $unitOfMesure;
    }

    /**
     * @return \Monmiel\MonmielApiModelBundle\Model\UnitOfMesure
     */
    public function getUnitOfMesure()
    {
        return $this->unitOfMesure;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
}
