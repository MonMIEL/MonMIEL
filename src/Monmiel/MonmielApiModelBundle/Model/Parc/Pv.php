<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:52
 * To change this template use File | Settings | File Templates.
 */
class Pv
{

    private $fc_pv;
    private $td_pv;
    private $power_Pv;
    private $parc_Pv;

    //Represente la puissance unitaire d'un panneau photovoltaique par M² en MW
    const POWERUNIT=0.001;
    const LOADFACTOR=0.09;
    const AVAILABILITYRATE=1;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 9% (année 2011)
    public function __construct($loadFactor= self::LOADFACTOR, $availabilityRate= self::AVAILABILITYRATE ,$power=0){
        $this->fc_pv=$loadFactor;
        $this->td_pv=$availabilityRate;
        $this->power_Pv=$power;
    }

    public function setPowerPv($PowerPv){
        if(isset($PowerPv)){
            $this->power_Pv= $PowerPv/$this->fc_pv;
        }
    }

    public function getPowerPv(){
        return $this->power_Pv;
    }

    public function setFacteurChargePv($fcPv){
        if(isset($fcPv)){
            $this->fc_pv=$fcPv;
        }
    }

    public function getFacteurChargePv(){
        return $this->fc_pv;
    }

    public function setTauxDisponibilitePv($tdPv){
        if(isset($tdPv)){
            $this->td_pv=$tdPv;
        }
    }

    public function getTauxDisponibilitePv(){
        return $this->td_pv;
    }

    public function getParcPv(){
        $this->parc_Pv=( $this->power_Pv/ self::POWERUNIT );
        return $this->parc_Pv;
    }
}
