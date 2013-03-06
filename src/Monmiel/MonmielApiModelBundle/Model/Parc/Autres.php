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

    private $parc_autre;

    private $puissance_autre;

    //Represente la puissance unitaire d'autre en MW, par défaut à 1 en attendant des precisions
    const PUISSANCEUNITAIRE=1;

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
        $this->puissance_autre=((($this->getMaxAutre()*4)/$this->getTauxDisponibiliteAutre())/$this->getFacteurChargeAutre());
        return $this->puissance_autre;
    }

    public function getParcAutre(){
        $this->parc_autre=( $this->puissance_autre/ self::PUISSANCEUNITAIRE );
        return $this->parc_autre;
    }
}

