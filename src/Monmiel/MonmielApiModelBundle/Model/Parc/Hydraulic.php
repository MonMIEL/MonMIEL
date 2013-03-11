<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Hydraulic
{
    private $fc_hydraulic;
    private $td_hydraulic;

    private $power_hydraulic;
    private $parc_hydraulic;

    //Represente la puissance unitaire de l'hydaulique en MW
    const PUISSANCEUNITAIRE=1;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct($loadFactor=1, $availabilityRate=0.872,$power=0){
        $this->fc_hydraulic=$loadFactor;
        $this->td_hydraulic=$availabilityRate;
        $this->max_hydraulic=$power;
    }

    public function setPowerHydraulic($powerHydro){
        if(isset($powerHydro)){
            $this->power_hydraulic=$powerHydro/$this->fc_hydraulic;
        }
    }

    public function getPowerHydraulic(){
        return $this->power_hydraulic;
    }

    public function setFacteurChargeHydraulique($fcHydraulique){
        if(isset($fcHydraulique)){
            $this->fc_hydraulic=$fcHydraulique;
        }
    }

    public function getFacteurChargeHydraulique(){
        return $this->fc_hydraulique;
    }

    public function setTauxDisponibiliteHydraulique($tdHydraulique){
        if(isset($tdHydraulique)){
            $this->td_hydraulique=$tdHydraulique;
        }
    }

    public function getTauxDisponibiliteHydraulique(){
        return $this->td_hydraulique;
    }

    public function getParcHydraulic(){
        $this->parc_hydraulic=( ($this->power_hydraulic/$this->td_hydraulic)/ self::PUISSANCEUNITAIRE );
        return $this->parc_hydraulic;
    }

}
