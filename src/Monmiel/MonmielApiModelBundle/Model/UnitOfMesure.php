<?php
namespace Monmiel\MonmielApiModelBundle\Model;

/**
 * unity of mesure
 * @author Patrice
 */

class UnitOfMesure
{
    /**
     * terawatt unity
     */
    const MESURE_TERAWATT = 'TW';

    /**
     * terawatt unity
     */
    const MESURE_GIGAWATT ='GW';

    /**
     * terawatt unity
     */
    const MESURE_GIGAWATT_HOUR ='GWH';

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
        return new UnitOfMesure(UnitOfMesure::MESURE_TERAWATT, "teraWatt");
    }

    /**
     * the GigaWatt Unity
     * @return UnitOfMesure
     */
    static public function  createUnityGigaWatt(){
        return new UnitOfMesure(UnitOfMesure::MESURE_GIGAWATT, "Gigawatt");
    }

    /**
     * the unity of mesure for consommation per hour
     * @return UnitOfMesure
     */
    static public  function  getUnityGigaWattHour(){
        return new UnitOfMesure(UnitOfMesure::MESURE_GIGAWATT_HOUR, "La consommation en gigawatt pendant une heure");
    }

    /**
     * @return bool , true, if the current unity is a TerraWatt
     */
    public function isTerraWatt(){
        return $this->name == UnitOfMesure::MESURE_TERAWATT;
    }

    /**
     * @return bool , true if the current unity is a Gigawatt
     */
    public function isGigaWatt(){
        return $this->name == UnitOfMesure::MESURE_GIGAWATT;
    }
}
