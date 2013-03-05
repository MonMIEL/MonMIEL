<?php
namespace Monmiel\MonmielApiModelBundle\Model;
/**
 * Created by JetBrains PhpStorm.
 * User: patrice
 * Date: 05/03/13
 * Time: 09:26
 * To change this template use File | Settings | File Templates.
 */
class UnitOfMesure
{
    /**
     * terawatt unit
     */
    const MESURE_TERAWATT = 'TW';

    /**
     * terawatt unit
     */
    const MESURE_GIGAWATT ='GW';

    /**
     * terawatt unit
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

    function __construct(){

    }
    /**
     * return the unit of
     * @return string
     */
    public function geUnityTerraWatt(){
        return UnitOfMesure::MESURE_TERAWATT;
    }

    /**
     * return the unity Gigawatt
     * @return string
     */
    public function  getUnityGigaWatt(){
        return UnitOfMesure::MESURE_GIGAWATT;
    }

    /**
     * the unity of mesure for consommation per hour
     * @return string
     */
    public  function  getUnityGigaWattHour(){
        return UnitOfMesure::MESURE_GIGAWATT_HOUR;
    }

}
