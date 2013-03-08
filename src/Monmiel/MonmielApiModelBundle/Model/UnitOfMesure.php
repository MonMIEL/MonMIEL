<?php
namespace Monmiel\MonmielApiModelBundle\Model;
use \Monmiel\Utils\ConstantUtils;
/**
 * unity of mesure
 * @author Patrice
 */

class UnitOfMesure
{
    /**
     * name of unit of mesure
     * @var string
     */
    protected  $name;

    /**
     * description of the unit of mesure
     * @var string
     */
    protected  $description;


    function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * the TerraWatt Unity
     * @return UnitOfMesure
     */
    static public function createUnityTerraWatt(){
        return new UnitOfMesure(ConstantUtils::TERAWATT, "teraWatt");
    }

    /**
     * the GigaWatt Unity
     * @return UnitOfMesure
     */
    static public function  createUnityGigaWatt(){
        return new UnitOfMesure(ConstantUtils::GIGAWATT, "Gigawatt");
    }

    /**
     * the unity of mesure for consommation per hour
     * @return UnitOfMesure
     */
    static public  function  getUnityGigaWattHour(){
        return new UnitOfMesure(ConstantUtils::GIGAWATT_HOUR, "La consommation en gigawatt pendant une heure");
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isTerraWatt(){
        return $this->name == ConstantUtils::TERAWATT;
    }

    /**
     * this method return true if the current unity is a Gigawatt
     * @return bool
     */
    public function isGigaWatt(){
        return $this->name == ConstantUtils::GIGAWATT;
    }
}
