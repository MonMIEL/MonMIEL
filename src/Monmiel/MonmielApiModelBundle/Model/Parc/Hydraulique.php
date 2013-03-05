<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Hydraulique
{
    private $max_hydraulique;
    private $fc_hydraulique;
    private $td_hydraulique;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_hydraulique=1;
        $this->td_hydraulique=1;
        $this->max_hydraulique=0;
    }

    public function setMaxHydraulique($maxHydro){
        if($maxHydro> $this->max_hydraulique){
            $this->max_hydraulique=$maxHydro;
        }
    }

    public function getMaxHydraulique(){
        return $this->max_hydraulique;
    }

    public function setFacteurChargeHydraulique($fcHydraulique){
        if(isset($fcHydraulique)){
            $this->fc_hydraulique=$fcHydraulique;
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

    public function getValueHydraulique(){
        return (($this->getMaxHydraulique()/$this->getTauxDisponibiliteHydraulique())/$this->getFacteurChargeHydraulique());
    }
}
