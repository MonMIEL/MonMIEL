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
     * the TerraWatt Unity
     * @return UnitOfMesure
     */
    public function geUnityTerraWatt(){
        return new UnitOfMesure(MESURE_TERAWATT, "TerraWatt");
    }

    /**
     * the GigaWatt Unity
     * @return UnitOfMesure
     */
    public function  getUnityGigaWatt(){
        //return UnitOfMesure::MESURE_GIGAWATT;
        return new UnitOfMesure(MESURE_GIGAWATT, "Gigawatt");
    }

    /**
     * the unity of mesure for consommation per hour
     * @return UnitOfMesure
     */
    public  function  getUnityGigaWattHour(){
        return UnitOfMesure::MESURE_GIGAWATT_HOUR;
        new UnitOfMesure(MESURE_GIGAWATT_HOUR, "La consommation en gigawatt pendant une heure");
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
