<?php

namespace Monmiel\MonmielApiModelBundle\Model;
/**
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

    /**
     * constructor using the default unitOfMesure
     * @param $value float
     */
    function __construct($value)
    {
        $this->unitOfMesure = $this->getDefaultUnitOfMesure();
        $this->value = $value;
    }

    /**
     * method to compare the UnitOfMesure  $mesureA and $mesureB
     * @param $mesureA Mesure
     * @param $mesureB Mesure
     * @return bol
     */
    static function isEqualsMesure($mesureA, $mesureB){
        return $mesureA->getUnitOfMesure()->getName() == $mesureB->getUnitOfMesure()->getName();
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

    /**
     * convert mesure $from using the UnitOfMesure $unitOfMesure
     * for example: $mesure = (100 TerraWatt) and $unitOfMesure = GW, then this function return 100*1000 GW
     * @param $mesure Mesure
     * @param $unitOfMesure UnitOfMesure
     * @return Mesure
     */
    static function convertMesureByOtherUnitOfMesure($mesure, $unitOfMesure){
        //TODO à faire
    }

    /**
     * return the default unitOfMesure
     * @var UnitOfMesure
     */
    private function getDefaultUnitOfMesure(){
        return UnitOfMesure::createUnityGigaWatt();
    }
}
