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
    public function getTerraWatt(){
        return UnitOfMesure::MESURE_TERAWATT;
    }

    /**
     * return the unity Gigawatt
     * @return string
     */
    public function  getGigaWatt(){
        return UnitOfMesure::MESURE_GIGAWATT;
    }


    public  function  getGigaWattHour(){

        return UnitOfMesure::MESURE_GIGAWATT_HOUR;
    }

}
