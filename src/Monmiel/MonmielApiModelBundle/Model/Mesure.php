<?php

namespace Monmiel\MonmielApiModelBundle\Model;
use \Monmiel\Utils\ConstantUtils;
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
     */
    protected $unitOfMesure;

    /**
     * constructor using the default unitOfMesure
     * @param $value float
     */
    function __construct($value, $unitOfMesure = null)
    {
        $this->value = $value;

        if(isset($unitOfMesure)){
            $this->unitOfMesure = $this->getDefaultUnitOfMesure();
        }else{
           $this->unitOfMesure = $unitOfMesure;
        }
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
     * convert mesure $mesureToConvert using the UnitOfMesure $newUnitOfMesure
     * for example: $mesure = (100 TerraWatt) and $unitOfMesure = GW, then this function return 100*1000 GW
     * @param $mesureToConvert Mesure
     * @param $newUnitOfMesure
     * @return Mesure
     */
    static function convertMesureByOtherUnitOfMesure($mesureToConvert, $newUnitOfMesure){
        /**
         * @var $mesureConverted Mesure
         */
        $mesureConverted = null;
        /**
         * @var $coeff float
         */
        $coeff = 1;//default value
        //if they parameters is not null
        if (isset($mesureToConvert) && isset($newUnitOfMesure)){
            $mesureConverted = $mesureToConvert;
            if($mesureToConvert->isTerraWatt())
            {
                //terrawatt to gigawatt
                if($newUnitOfMesure == ConstantUtils::GIGAWATT){
                    echo("_____________________________________ HERE_______________________");
                    //convert Terrawatt to Gigawatt
                    $coeff = 1000;
                }
                //terrawatt to watt
                else if($newUnitOfMesure == ConstantUtils::WATT){
                    //convert Terrawatt to watt
                    $coeff = 1000000;
                }
            }
            else if($mesureToConvert->isGigaWatt())
            {
                //gigawatt to terawatt
                if($newUnitOfMesure == ConstantUtils::TERAWATT){
                    //convert Terrawatt to Gigawatt
                    $coeff = 1/1000;
                }
                //gigawatt to watt
                else if($newUnitOfMesure == ConstantUtils::WATT){
                    //convert Terrawatt to watt
                    $coeff = 1000000;
                }
            }
            else if($mesureToConvert->isTerraWattHeure())
            {
                //terraWattheure to terraWatt
                if($newUnitOfMesure == ConstantUtils::TERAWATT){
                    $coeff = 1/365*24;
                }
                //terraWattheure to GIGAWATT
                else if($newUnitOfMesure == ConstantUtils::GIGAWATT){
                    $coeff = 1000/365*24;
                }
                //terraWattheure to WATT
                else if($newUnitOfMesure == ConstantUtils::KILOWATTWATT){
                    $coeff = 1000000/365*24;
                }
                //terraWattheure to WATT
                else if($newUnitOfMesure == ConstantUtils::WATT){
                    $coeff = 1000000000/365*24;
                }
            }
            else if($mesureToConvert->isGigaWattHour())
            {
                //GIGAWattheure to GIGAWATT
                if($newUnitOfMesure == ConstantUtils::GIGAWATT){
                    $coeff = 1/365*24;
                }
                //GIGAWattheure to WATT
                else if($newUnitOfMesure == ConstantUtils::KILOWATTWATT){
                    $coeff = 1000/365*24;
                }
                //GIGAWattheure to WATT
                else if($newUnitOfMesure == ConstantUtils::WATT){
                    $coeff = 1000000/365*24;
                }
            }
            else if($mesureToConvert->isWatt())
            {
                //...
            }
            else if($mesureToConvert->isWattHour())
            {
                //...
            }
            else{
                //Not implemented code Exception
            }
        }
        echo("------------- coefficient:".$coeff);
        echo("------------- unit of mesure:".$newUnitOfMesure);

        $valueConverted = ($mesureToConvert->getValue())*$coeff;

        $mesureConverted->setUnitOfMesure($newUnitOfMesure);

        $mesureConverted->setValue($valueConverted);

    return $mesureConverted;
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

    public function setUnitOfMesure($unitOfMesure)
    {
        $this->unitOfMesure = $unitOfMesure;
    }

    public function getUnitOfMesure()
    {
        return $this->unitOfMesure;
    }

    /**
     * return the default unitOfMesure
     */
    private function getDefaultUnitOfMesure(){
        return \Monmiel\Utils\ConstantUtils::GIGAWATT;
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isTerraWatt(){
        return $this->getUnitOfMesure() == ConstantUtils::TERAWATT;
    }

    /**
     * this method return true if the current unity is a terrawattHour
     * @return bool
     */
    public function isTerraWattHeure(){
        return $this->getUnitOfMesure() == ConstantUtils::TERAWATT_HOUR;
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isGigaWatt(){
        return $this->getUnitOfMesure() == ConstantUtils::GIGAWATT;
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isGigaWattHour(){
        return $this->getUnitOfMesure() == ConstantUtils::GIGAWATT_HOUR;
    }

    /**
     * this method return true if the current unity is a watt
     * @return bool
     */
    public function isWatt(){
        return $this->getUnitOfMesure() == ConstantUtils::WATT;
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isWattHour(){
        return $this->getUnitOfMesure() == ConstantUtils::WATT_HOUR;
    }
}
