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

    public function setMaxEolien($maxEolien){
        if($maxEolien> $this->max_eolien){
            $this->max_eolien=$maxEolien;
        }
    }

    public function getMaxEolien(){
        return $this->max_eolien;
    }

    public function setFacteurChargeEolien($fcEolien){
            $this->fc_eolien=$fcEolien;

    }

    public function getFacteurChargeEolien(){
        return $this->fc_eolien;
    }

    public function setTauxDisponibiliteEolien($tdEolien){
        $this->td_eolien=$tdEolien;

    }

    public function getTauxDisponibiliteEolien(){
        return $this->td_eolien;
    }
}
