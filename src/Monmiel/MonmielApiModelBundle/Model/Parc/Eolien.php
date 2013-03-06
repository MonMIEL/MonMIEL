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
    private $max_eolien;
    private $fc_eolien;
    private $td_eolien;
    private $puissance_eolien;
    private $parc_eolien;

    //Represente la puissance unitaire d'une éolienne en MW
    const PUISSANCEUNITAIRE=1.5;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_eolien=1;
        $this->td_eolien=1;
        $this->max_eolien=0;
    }

    public function setMaxEolien($maxEolien){
        if($maxEolien> $this->max_eolien){
            $this->max_eolien=$maxEolien;
        }
    }

    public function getMaxEolien(){
        return $this->max_eolien;
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

    public function getValueEolien(){
        $this->puissance_eolien=((($this->getMaxEolien()*4)/$this->getTauxDisponibiliteEolien())/$this->getFacteurChargeEolien());
        return $this->puissance_eolien;
    }

    public function getParcEolien(){
        $this->parc_eolien=( $this->puissance_eolien/ PUISSANCEUNITAIRE );
        return $this->parc_eolien;
    }
}
