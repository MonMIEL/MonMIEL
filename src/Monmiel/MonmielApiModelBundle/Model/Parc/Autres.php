<?php

namespace Monmiel\MonmielApiModelBundle\Model\Parc;
/**
 * Created by JetBrains PhpStorm.
 * User: Miage
 * Date: 04/03/13
 * Time: 17:54
 * To change this template use File | Settings | File Templates.
 */
class Autres
{
    private $max_autre;

    private $fc_autre;

    private $td_autre;

    //A la construction de l'objet on defini l'objet comme si il était toujours disponible avec un facteur de charge égale à 1
    public function __construct(){
        $this->fc_autre=1;
        $this->td_autre=1;
        $this->max_autre=0;
    }

    public function setMaxAutre($maxAutre){
        if($maxAutre> $this->max_autre){
            $this->max_autre=$maxAutre;
        }
    }

    public function getMaxAutre(){
        return $this->max_autre;
    }

    public function setFacteurChargeAutre($fcAutre){
        if(isset($fcAutre)){
            $this->fc_autre=$fcAutre;
        }
    }

    public function getFacteurChargeAutre(){
        return $this->fc_autre;
    }

    public function setTauxDisponibiliteAutre($tdAutre){
        if(isset($tdAutre)){
            $this->td_autre=$tdAutre;
        }
    }

    public function getTauxDisponibiliteAutre(){
        return $this->td_autre;
    }


    public function getValueAutre(){
        return (($this->getMaxAutre()/$this->getTauxDisponibiliteAutre())/$this->getFacteurChargeAutre());
    }
}