<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:53
 * To change this template use File | Settings | File Templates.
 */
class Eolien
{
    private $power_eolien;
    private $fc_eolien;
    private $td_eolien;
    private $parc_eolien;

    //Represente la puissance unitaire d'une éolienne en MW
    const PUISSANCEUNITAIRE=1.5;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct($loadFactor=1, $uptimeRate=0.98,$power=0){
        $this->fc_eolien=$loadFactor;
        $this->td_eolien=$uptimeRate;
        $this->power_eolien=$power;
    }

    public function setPowerEolien($powerEolien){
        if(isset($powerEolien)){
            $this->power_eolien=((($powerEolien*4)/$this->getTauxDisponibiliteEolien())/$this->getFacteurChargeEolien());
        }
    }

    public function getPowerEolien(){
        return $this->power_eolien;
    }

    public function setFacteurChargeEolien($fcEolien){
        if(isset($fcEolien)){
            $this->fc_eolien=$fcEolien;
        }

    }

    public function getFacteurChargeEolien(){
        return $this->fc_eolien;
    }

    public function setTauxDisponibiliteEolien($tdEolien){
        if(isset($tdEolien)){
            $this->td_eolien=$tdEolien;
        }
    }

    public function getTauxDisponibiliteEolien(){
        return $this->td_eolien;
    }

    public function getParcEolien(){
        $this->parc_eolien=( $this->power_eolien / self::PUISSANCEUNITAIRE );
        return $this->parc_eolien;
    }
}
